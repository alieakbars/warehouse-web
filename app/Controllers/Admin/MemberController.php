<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\HomeModel;
use App\Models\Admin\ProductModel;
use App\Models\Admin\TransaksiModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MemberController extends BaseController
{
    function waktu()
    {
        date_default_timezone_set('Asia/Jakarta');
        $dt = date('Y-m-d H:i:s');
        return $dt;
    }

    public function index()
    {
        if (!session()->get('admin_logged')) {
            return redirect()->to(base_url('loginController'));
        }
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM wilayah");
        $results = $query->getResultArray();

        $data = [
            'wilayah' => $results,
            'title' => 'Member',
            'menu' => 'Data Member'
        ];

        return view('Admin/memberView', $data);
    }
    public function getwilayah()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM wilayah");
        $results = $query->getResultArray();
        return json_encode($results);
    }
    public function getmember()
    {
        $db = \Config\Database::connect();

        $columns = array(
            'ui.nama_depan',
            'ui.nama_belakang',
            'ui.nik'
        );

        $table = " user_info ui join wilayah w on w.id_wilayah = ui.zoning join poin_belanja pb on pb.user_id = ui.user_id ";
        $where = "Where 1=1 ";

        $orderby = ' order by nama_depan asc ';

        $period1 = $this->request->getVar('period1');
        $period2 = $this->request->getVar('period2');
        $length = $this->request->getVar('length');
        $start = $this->request->getVar('start');

        if (isset($period1) || isset($period2)) {
            $where .= " AND (DATE(tanggal_join) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2 . "+1 days")) . "') ";
        }

        if ($_POST['search']['value'] != '') {
            $where .= " AND ";
            foreach ($columns as $c) {
                $where .= " CONVERT(" . $c . ",CHARACTER) like '%" . $_POST['search']['value'] . "%' OR ";
            }
            $where = substr_replace($where, "", -3);
        }
        // for count all 'recordsFiltered' Datatable
        $query = $db->query("select " . str_replace(" , ", " ", implode(", ", $columns)) . " from $table $where ");
        $rows = $query->getResult();

        // for count filtered 'recordsTotal' Datatable 
        $query1 =  $db->query("select ui.*,w.nama_wilayah, pb.poin as poin_belanja from $table $where $orderby LIMIT " . $length . " OFFSET " . $start . " ");
        $rowsLimit = $query1->getResult();
        // we send this output to frontend
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => count($rows),
            "recordsFiltered" => count($rows),
            "data" => array()
        );

        $i = 1;
        foreach ($rowsLimit as $each) {
            $arr = array();
            $arr['user_id'] = $each->user_id;
            $arr['nik'] = $each->nik;
            $arr['tgl_lahir'] = $each->tgl_lahir;
            $arr['nama'] = $each->nama_depan . ' ' . $each->nama_belakang;
            $arr['alamat'] = $each->alamat;
            $arr['alamat_fb'] = $each->alamat_fb;
            $arr['email'] = $each->email;
            $arr['password'] = $each->password;
            $arr['mobile'] = $each->mobile;
            $arr['no_rek'] = $each->no_rek;
            $arr['nama_bank'] = $each->nama_bank;
            $arr['wilayah'] = $each->nama_wilayah;
            $arr['k_referal'] = $each->k_referal;
            $arr['status'] = $each->status;
            $arr['tipe_akun'] = $each->tipe_akun;
            $arr['poin'] = $each->poin;
            $arr['poin_belanja'] = $each->poin_belanja;
            $arr['zoning'] = $each->zoning;
            $arr['nama_depan'] = $each->nama_depan;
            $arr['nama_belakang'] = $each->nama_belakang;
            $arr['tanggal_join'] = $each->tanggal_join;
            $output['data'][] = $arr;
        }

        echo json_encode($output);
    }

    public function addmember()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {

            $nik = $this->request->getVar('nik');
            $tgl_lahir = $this->request->getVar('tgl_lahir');
            $nama_depan = $this->request->getVar('nama_depan');
            $nama_belakang = $this->request->getVar('nama_belakang');
            $alamat_fb = $this->request->getVar('alamat_fb');
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');
            $mobile = $this->request->getVar('mobile');
            $no_rek = $this->request->getVar('no_rek');
            $nama_bank = $this->request->getVar('nama_bank');
            $zoning = $this->request->getVar('zoning');
            $k_referal = $this->request->getVar('k_referal');
            $status = $this->request->getVar('status');
            $tipe_akun = $this->request->getVar('tipe_akun');
            $alamat = $this->request->getVar('alamat');
            $time = $this->waktu();

            $pw = password_hash($password, PASSWORD_BCRYPT);

            $query1 = $db->query("SELECT user_id from user_info where mobile = '$mobile'");
            $results = $query1->getResult();

            if ($results) {
                throw new \Exception('Data sudah ada !');
            }

            $query = $db->query("SELECT max(user_id) as kodeTerbesar FROM user_info");
            $results = $query->getResultArray();

            $kodeBarang = $results[0]['kodeTerbesar'];
            $urutan = (int) substr($kodeBarang, 3, 4);
            $urutan++;
            $huruf = "HGM";
            $kodeBarang = $huruf . sprintf("%04s", $urutan);

            $db->query("INSERT into user_info (user_id,nik,tgl_lahir,nama_depan,nama_belakang,alamat,alamat_fb,email,password,mobile,
            no_rek,nama_bank,zoning,k_referal,status,tipe_akun,poin,tanggal_join) VALUES ('$kodeBarang','$nik','$tgl_lahir','$nama_depan',
            '$nama_belakang','$alamat','$alamat_fb','$email','$pw','$mobile','$no_rek','$nama_bank','$zoning','$k_referal','$status',
            '$tipe_akun','0','$time')");

            $db->query("UPDATE wilayah SET kuota_wilayah = kuota_wilayah-1 WHERE id_wilayah = '$zoning'");
            $db->query("INSERT INTO poin_belanja (user_id,poin) VALUES ('$kodeBarang','0')");

            $db->transCommit();
            echo json_encode([
                "status_code" => '01',
                "message" => "Berhasil Ditambah",
                "data" => null,
            ]);
        } catch (\Exception $th) {
            $db->transRollback();
            echo json_encode([
                "status_code" => '02',
                "message" => $th->getMessage(),
                "data" => $th,
            ]);
        }
    }

    public function updatemember()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $nik = $this->request->getVar('nik');
            $tgl_lahir = $this->request->getVar('tgl_lahir');
            $nama_depan = $this->request->getVar('nama_depan');
            $nama_belakang = $this->request->getVar('nama_belakang');
            $alamat_fb = $this->request->getVar('alamat_fb');
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');
            $mobile = $this->request->getVar('mobile');
            $no_rek = $this->request->getVar('no_rek');
            $nama_bank = $this->request->getVar('nama_bank');
            $zoning = $this->request->getVar('zoning');
            $k_referal = $this->request->getVar('k_referal');
            $status = $this->request->getVar('status');
            $tipe_akun = $this->request->getVar('tipe_akun');
            $alamat = $this->request->getVar('alamat');
            $e_zoning = $this->request->getVar('e_zoning');
            $user_id = $this->request->getVar('user_id');

            $query1 = $db->query("SELECT user_id from user_info where user_id != '$user_id' AND mobile = '$mobile'");
            $results = $query1->getResult();

            if ($results) {
                throw new \Exception('Data sudah ada !');
            }

            if ($password) {
                $pw = password_hash($password, PASSWORD_BCRYPT);
                $is_pw = "password = '" . $pw . "',";
            } else {
                $is_pw = "";
            }


            $db->query("UPDATE user_info set nik = '$nik', tgl_lahir = '$tgl_lahir', nama_depan = '$nama_depan', nama_belakang = '$nama_belakang',
            alamat = '$alamat', alamat_fb = '$alamat_fb', email = '$email', $is_pw mobile = '$mobile',
            no_rek = '$no_rek', nama_bank = '$nama_bank', zoning = '$zoning', k_referal = '$k_referal', status = '$status',
            tipe_akun = '$tipe_akun' where user_id = '$user_id' ");

            $db->query("UPDATE wilayah SET kuota_wilayah = kuota_wilayah+1 WHERE id_wilayah = '$e_zoning'");
            $db->query("UPDATE wilayah SET kuota_wilayah = kuota_wilayah-1 WHERE id_wilayah = '$zoning'");

            $db->transCommit();
            echo json_encode([
                "status_code" => '01',
                "message" => "Berhasil diupdate",
                "data" => null,
            ]);
        } catch (\Throwable $th) {
            $db->transRollback();
            echo json_encode([
                "status_code" => '02',
                "message" => $th->getMessage(),
                "data" => $th,
            ]);
        }
    }

    public function deletemember()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $kode = $this->request->getVar('user_id');

            $db->query("DELETE FROM user_info where user_id = '$kode'");
            $db->query("DELETE FROM poin_belanja where user_id = '$kode'");

            $db->transCommit();
            echo json_encode([
                "status_code" => '01',
                "message" => "Berhasil Dihapus",
                "data" => null,
            ]);
        } catch (\Throwable $th) {
            $db->transRollback();
            echo json_encode([
                "status_code" => '02',
                "message" => $th->getMessage(),
                "data" => $th,
            ]);
        }
    }

    public function cetakexcelmember()
    {
        $spreadsheet = new Spreadsheet();

        $db = \Config\Database::connect();

        $table = " user_info ui join wilayah w on w.id_wilayah = ui.zoning join min_belanja_member mbm on mbm.id_tarif = ui.tipe_akun";
        $where = "Where 1=1 ";

        $orderby = ' order by tanggal_join desc ';
        $period1 = $this->request->getVar('period1');
        $period2 = $this->request->getVar('period2');

        if (isset($period1) || isset($period2)) {
            $where .= " AND (DATE(tanggal_join) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2 . "+1 days")) . "') ";
        }

        $query1 =  $db->query("select * from $table $where $orderby ");
        $rowsLimit = $query1->getResult();

        if (!$rowsLimit) {
            return redirect()->back();
        }
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->setActiveSheetIndex(0)->mergeCells('B1:Q1');
        $spreadsheet->setActiveSheetIndex(0)->mergeCells('B2:Q2');
        $spreadsheet->getActiveSheet()->freezePane('A5');
        $spreadsheet->getActiveSheet()->getRowDimension(1);

        // $spreadsheet->getActiveSheet()->getStyle('A4:K4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00FF7F');

        $objDrawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $objDrawing->setName('logo-hedglow');
        $objDrawing->setDescription('logo-hedglow');
        $objDrawing->setPath('assets/img/hedglow.png');
        $objDrawing->setCoordinates('A1');
        $objDrawing->setOffsetX(2);
        $objDrawing->setOffsetY(7);
        $objDrawing->setWidthAndHeight(60, 120);
        $objDrawing->setResizeProportional(true);
        $objDrawing->setWorksheet($spreadsheet->getActiveSheet());

        $style_header = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => [
                    'argb' => '252271',
                ],
            ],
            'font' => [
                'bold' => true,
                'color' => [
                    'argb' => 'CCCCCC',
                ],
            ]
        ];

        $style_left = [
            'borders' => [
                'allborders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ]
        ];

        $style_center = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
            ]
        ];

        $spreadsheet->getActiveSheet()->getStyle('A4:Q4')->applyFromArray($style_header);
        $spreadsheet->getActiveSheet()->getStyle('B1:B2')->applyFromArray($style_center);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B1', 'REPORT AKUN MEMBER')
            ->setCellValue('B2', $period1 . " - " . $period2)
            ->setCellValue('A4', 'NO')
            ->setCellValue('B4', 'Kode')
            ->setCellValue('C4', 'NIK')
            ->setCellValue('D4', 'Tgl Lahir')
            ->setCellValue('E4', 'Nama')
            ->setCellValue('F4', 'Alamat')
            ->setCellValue('G4', 'Alamat FB')
            ->setCellValue('H4', 'Email')
            ->setCellValue('I4', 'Mobile')
            ->setCellValue('J4', 'No Rek')
            ->setCellValue('K4', 'Nama Bank')
            ->setCellValue('L4', 'Zona')
            ->setCellValue('M4', 'Kode Referal')
            ->setCellValue('N4', 'Status')
            ->setCellValue('O4', 'Tipe Akun')
            ->setCellValue('P4', 'Saldo')
            ->setCellValue('Q4', 'Tanggal Join');


        $column = 5;
        // tulis data mobil ke cell
        $no = 1;
        foreach ($rowsLimit as $data) {
            if ($data->status == 1) {
                $method = 'Aktif';
            } else {
                $method = 'Tidak Aktif';
            }
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $no++)
                ->setCellValue('B' . $column, $data->user_id)
                ->setCellValue('C' . $column, $data->nik)
                ->setCellValue('D' . $column, $data->tgl_lahir)
                ->setCellValue('E' . $column, $data->nama_depan . " " . $data->nama_belakang)
                ->setCellValue('F' . $column, $data->alamat)
                ->setCellValue('G' . $column, $data->alamat_fb)
                ->setCellValue('H' . $column, $data->email)
                ->setCellValue('I' . $column, $data->mobile)
                ->setCellValue('J' . $column, $data->no_rek)
                ->setCellValue('K' . $column, $data->nama_bank)
                ->setCellValue('L' . $column, $data->nama_wilayah)
                ->setCellValue('M' . $column, $data->k_referal)
                ->setCellValue('N' . $column, $method)
                ->setCellValue('O' . $column, $data->nama_tarif)
                ->setCellValue('P' . $column, $data->poin)
                ->setCellValue('Q' . $column, $data->tanggal_join);


            // $spreadsheet->getActiveSheet()->setCellValueExplicit('E' . $column, $data->mobile, PHPExcel_Cell_DataType::TYPE_STRING);
            // $spreadsheet->getActiveSheet()->setCellValueExplicit('G' . $column, $data->ongkir, PHPExcel_Cell_DataType::TYPE_STRING);
            // $spreadsheet->getActiveSheet()->setCellValueExplicit('H' . $column, $data->total_harga, PHPExcel_Cell_DataType::TYPE_STRING);
            // $spreadsheet->getActiveSheet()->setCellValueExplicit('I' . $column, $total_belanja, PHPExcel_Cell_DataType::TYPE_STRING);

            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Report Akun Member ' . date("d-m-Y");

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

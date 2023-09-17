<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UserController extends BaseController
{
    function waktu()
    {
        date_default_timezone_set('Asia/Jakarta');
        $dt = date('Y-m-d H:i:s');
        return $dt;
    }

    public function index()
    {
        if (!session()->get('logged')) {
            return redirect()->to(base_url('loginController'));
        }
        $db = \Config\Database::connect();
        $query1 = $db->query("SELECT id,nama from warehouse where status = '1'");
        $results = $query1->getResult();

        $data = [
            'title' => 'Pengaturan User',
            'menu' => 'Pengaturan',
            'warehouse' => $results
        ];

        return view('Admin/userView', $data);
    }

    public function getuser()
    {
        $db = \Config\Database::connect();

        $columns = array(
            'u.id',
            'u.username',
            'u.nama',
            'u.no_pegawai',
            'u.status',
            'u.level',
            'w.nama as nama_warehouse',
            'w.id as id_warehouse',
            'u.created_at'
        );

        $table = "user u left join warehouse w on w.id=u.cabang";
        $where = "Where 1=1 AND w.status = 1";

        $orderby = ' order by u.id desc';
        $period1 = $this->request->getVar('period1');
        $period2 = $this->request->getVar('period2');
        $length = $this->request->getVar('length');
        $start = $this->request->getVar('start');

        // if (isset($period1) || isset($period2)) {
        //     $where .= " AND (DATE(u.created_at) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2 . "+1 days")) . "') ";
        // }

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
        $query1 =  $db->query("select " . str_replace(" , ", " ", implode(", ", $columns)) . " from $table $where $orderby LIMIT " . $length . " OFFSET " . $start . " ");
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
            $arr['id'] = $each->id;
            $arr['username'] = $each->username;
            $arr['nama'] = $each->nama;
            $arr['no_pegawai'] = $each->no_pegawai;
            $arr['status'] = $each->status;
            $arr['level'] = $each->level;
            $arr['nama_warehouse'] = $each->nama_warehouse;
            $arr['id_warehouse'] = $each->id_warehouse;
            $arr['created_at'] = $each->created_at;
            $output['data'][] = $arr;
        }

        echo json_encode($output);
    }

    public function adduser()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {

            $username = $this->request->getVar('username');
            $password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
            $nama = $this->request->getVar('nama');
            $no_pegawai = $this->request->getVar('no_pegawai');
            $status = $this->request->getVar('status');
            $level = $this->request->getVar('level');
            $cabang = $this->request->getVar('cabang');


            $time = $this->waktu();

            $query1 = $db->query("SELECT id from user where username = '$username'");
            $results = $query1->getResult();

            if ($results) {
                throw new \Exception('Username sudah ada !');
            }

            $db->query("INSERT into user (username,password,nama,no_pegawai,status,level,cabang,created_at) VALUES ('$username','$password','$nama','$no_pegawai','$status','$level','$cabang',now())");

            $db->transCommit();
            echo json_encode([
                "status_code" => '202',
                "message" => "Berhasil Ditambah",
                "data" => null,
            ]);
        } catch (\Exception $th) {
            $db->transRollback();
            echo json_encode([
                "status_code" => '303',
                "message" => $th->getMessage(),
                "data" => $th,
            ]);
        }
    }

    public function updateuser()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $id = $this->request->getVar('id');
            $username = $this->request->getVar('username');
            $pw = $this->request->getVar('password');
            $nama = $this->request->getVar('nama');
            $no_pegawai = $this->request->getVar('no_pegawai');
            $status = $this->request->getVar('status');
            $level = $this->request->getVar('level');
            $cabang = $this->request->getVar('cabang');

            $query1 = $db->query("SELECT id from user where id != '$id' AND username = '$username'");
            $results = $query1->getResult();

            if ($results) {
                throw new \Exception('Username sudah ada !');
            }

            if ($pw != '') {
                $password = password_hash($pw, PASSWORD_DEFAULT);
                $db->query("UPDATE user set username = '$username', password = '$password', nama = '$nama', no_pegawai = '$no_pegawai', status = '$status', level = '$level', cabang = '$cabang' where id = '$id' ");
            } else {
                $db->query("UPDATE user set username = '$username', nama = '$nama', no_pegawai = '$no_pegawai', status = '$status', level = '$level', cabang = '$cabang' where id = '$id' ");
            }

            $db->transCommit();
            echo json_encode([
                "status_code" => '202',
                "message" => "Berhasil diupdate",
                "data" => null,
            ]);
        } catch (\Throwable $th) {
            $db->transRollback();
            echo json_encode([
                "status_code" => '303',
                "message" => $th->getMessage(),
                "data" => $th,
            ]);
        }
    }

    public function deleteuser()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $id = $this->request->getVar('id');

            $db->query("DELETE FROM user where id = '$id'");

            $db->transCommit();
            echo json_encode([
                "status_code" => '202',
                "message" => "Berhasil Dihapus",
                "data" => null,
            ]);
        } catch (\Throwable $th) {
            $db->transRollback();
            echo json_encode([
                "status_code" => '303',
                "message" => $th->getMessage(),
                "data" => $th,
            ]);
        }
    }

    public function cetakexcelguest()
    {
        $spreadsheet = new Spreadsheet();

        $db = \Config\Database::connect();

        $table = " user_pengunjung";
        $where = "Where 1=1 ";

        $orderby = ' order by join_date desc ';
        $period1 = $this->request->getVar('period1');
        $period2 = $this->request->getVar('period2');

        if (isset($period1) || isset($period2)) {
            $where .= " AND (DATE(join_date) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2 . "+1 days")) . "') ";
        }

        $query1 =  $db->query("select * from $table $where $orderby ");
        $rowsLimit = $query1->getResult();

        if (!$rowsLimit) {
            return redirect()->back();
        }
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->setActiveSheetIndex(0)->mergeCells('B1:G1');
        $spreadsheet->setActiveSheetIndex(0)->mergeCells('B2:G2');
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

        $spreadsheet->getActiveSheet()->getStyle('A4:G4')->applyFromArray($style_header);
        $spreadsheet->getActiveSheet()->getStyle('B1:B2')->applyFromArray($style_center);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B1', 'REPORT AKUN PENGUNJUNG')
            ->setCellValue('B2', $period1 . " - " . $period2)
            ->setCellValue('A4', 'NO')
            ->setCellValue('B4', 'Kode')
            ->setCellValue('C4', 'Nama')
            ->setCellValue('D4', 'Email')
            ->setCellValue('E4', 'Mobile')
            ->setCellValue('F4', 'Tanggal Masuk')
            ->setCellValue('G4', 'Status');


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
                ->setCellValue('B' . $column, $data->id_pengunjung)
                ->setCellValue('C' . $column, $data->nama)
                ->setCellValue('D' . $column, $data->email)
                ->setCellValue('E' . $column, $data->mobile)
                ->setCellValue('F' . $column, $data->join_date)
                ->setCellValue('G' . $column, $method);

            // $spreadsheet->getActiveSheet()->setCellValueExplicit('E' . $column, $data->mobile, PHPExcel_Cell_DataType::TYPE_STRING);
            // $spreadsheet->getActiveSheet()->setCellValueExplicit('G' . $column, $data->ongkir, PHPExcel_Cell_DataType::TYPE_STRING);
            // $spreadsheet->getActiveSheet()->setCellValueExplicit('H' . $column, $data->total_harga, PHPExcel_Cell_DataType::TYPE_STRING);
            // $spreadsheet->getActiveSheet()->setCellValueExplicit('I' . $column, $total_belanja, PHPExcel_Cell_DataType::TYPE_STRING);

            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Report Akun Pengunjung ' . date("d-m-Y");

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

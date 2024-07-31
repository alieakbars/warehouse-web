<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Admin\HomeModel;
use App\Models\Admin\TransaksiModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use PHPExcel_Cell_DataType;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;
use PHPExcel_Worksheet_Drawing;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PenitipanController extends BaseController
{
    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
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
            'title' => 'Penitipan In',
            'menu' => 'Penitiapn',
            'warehouse' => $results
        ];

        return view('Admin/penitipaninView', $data);
    }

    public function out()
    {
        if (!session()->get('logged')) {
            return redirect()->to(base_url('loginController'));
        }
        $db = \Config\Database::connect();
        $query1 = $db->query("SELECT id,nama from warehouse where status = '1'");
        $results = $query1->getResult();

        $data = [
            'title' => 'Penitipan Out',
            'menu' => 'Transaksi',
            'warehouse' => $results
        ];

        return view('Admin/penitipanoutView', $data);
    }

    public function getbarangin()
    {
        $db = \Config\Database::connect();

        $columns = array(
            'i.sn',
            'i.date_in',
            'i.date_out',
            'i.user_in',
            'i.user_out',
            'i.tahun',
            'i.bulan',
            'i.no_urut',
            'i.kategori',
            'i.model',
            'i.customer',
            'w.nama as cabang_origin',
            'w1.nama as cabang_destination'
        );

        $columnfilter = array(
            'i.sn',
            'i.user_in',
            'i.tahun',
            'i.bulan',
            'i.no_urut',
            'i.kategori',
            'i.model'
        );

        $table = "penitipan i 
        left join warehouse w on w.id=i.cabang
        left join warehouse w1 on w1.id=i.cabang_move";
        $where = "Where 1=1 AND i.date_out is null";

        //=================== TEMPLATE DATATABLE ===================

        // print_r('<pre>');
        // print_r(isset($_POST['order']) ? "ada" : "gak");die();
        $orderby = ' order by i.id desc ';
        $period1 = $this->request->getVar('period1');
        $period2 = $this->request->getVar('period2');
        $length = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $cabang = $this->request->getVar('cabang');


        if ($period1 != '' || $period2 != '') {
            $where .= " AND (DATE(i.date_in) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2 . "+1 days")) . "') ";
        } else {
            $where .= " AND (DATE(i.date_in) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2)) . "') ";
        }

        if ($cabang != '') {
            $where .= " AND i.cabang = '" . $cabang . "'";
        }

        if ($_POST['search']['value'] != '') {
            $where .= " AND ";
            foreach ($columnfilter as $c) {
                $where .= " CONVERT(" . $c . ",CHARACTER) like '%" . $_POST['search']['value'] . "%' OR ";
            }
            $where = substr_replace($where, "", -3);
        }

        // print_r("select " . str_replace(" , ", " ", implode(", ", $columns)) . " from $table $where $orderby LIMIT " . $length . " OFFSET " . $start . " ");
        // die();

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
        //=================== END TEMPLATE DATATABLE ===================

        $i = 1;
        foreach ($rowsLimit as $each) {
            $arr = array();
            $arr['sn'] = $each->sn;
            $arr['date_in'] = $each->date_in;
            $arr['user_in'] = $each->user_in;
            $arr['tahun'] = $each->tahun;
            $arr['bulan'] = $each->bulan;
            $arr['no_urut'] = $each->no_urut;
            $arr['kategori'] = $each->kategori;
            $arr['model'] = $each->model;
            $arr['customer'] = $each->customer;
            $arr['cabang_origin'] = $each->cabang_origin;
            $arr['cabang_destination'] = $each->cabang_destination;

            $output['data'][] = $arr;
        }

        echo json_encode($output);
    }

    public function getbarangout()
    {
        $db = \Config\Database::connect();

        $columns = array(
            'i.sn',
            'i.date_in',
            'i.date_out',
            'i.user_in',
            'i.user_out',
            'i.tahun',
            'i.bulan',
            'i.no_urut',
            'i.kategori',
            'i.model',
            'i.customer',
            'w.nama as cabang_origin',
            'w1.nama as cabang_destination'
        );

        $columnfilter = array(
            'i.sn',
            'i.user_out',
            'i.tahun',
            'i.bulan',
            'i.no_urut',
            'i.kategori',
            'i.model',
            'i.customer'

        );
        $table = "penitipan i 
        left join warehouse w on w.id=i.cabang
        left join warehouse w1 on w1.id=i.cabang_move";
        $where = "Where 1=1 AND i.date_out is not null";

        //=================== TEMPLATE DATATABLE ===================

        // print_r('<pre>');
        // print_r(isset($_POST['order']) ? "ada" : "gak");die();
        $orderby = ' order by i.id desc ';
        $period1 = $this->request->getVar('period1');
        $period2 = $this->request->getVar('period2');
        $length = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $cabang = $this->request->getVar('cabang');

        if ($period1 != '' || $period2 != '') {
            $where .= " AND (DATE(i.date_out) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2 . "+1 days")) . "') ";
        } else {
            $where .= " AND (DATE(i.date_out) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2)) . "') ";
        }

        if ($cabang != '') {
            $where .= " AND i.cabang = '" . $cabang . "'";
        }

        if ($_POST['search']['value'] != '') {
            $where .= " AND ";
            foreach ($columnfilter as $c) {
                $where .= " CONVERT(" . $c . ",CHARACTER) like '%" . $_POST['search']['value'] . "%' OR ";
            }
            $where = substr_replace($where, "", -3);
        }

        // print_r("select " . str_replace(" , ", " ", implode(", ", $columns)) . " from $table $where $orderby LIMIT " . $length . " OFFSET " . $start . " ");
        // die();

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
        //=================== END TEMPLATE DATATABLE ===================

        $i = 1;
        foreach ($rowsLimit as $each) {
            $arr = array();
            $arr['sn'] = $each->sn;
            $arr['date_in'] = $each->date_in;
            $arr['date_out'] = $each->date_out;
            $arr['user_in'] = $each->user_in;
            $arr['user_out'] = $each->user_out;
            $arr['tahun'] = $each->tahun;
            $arr['bulan'] = $each->bulan;
            $arr['no_urut'] = $each->no_urut;
            $arr['kategori'] = $each->kategori;
            $arr['model'] = $each->model;
            $arr['customer'] = $each->customer;
            $arr['cabang_origin'] = $each->cabang_origin;
            $arr['cabang_destination'] = $each->cabang_destination;
            $output['data'][] = $arr;
        }

        echo json_encode($output);
    }

    public function cetakexcelin()
    {
        $db = \Config\Database::connect();
        $columns = array(
            'i.sn',
            'i.date_in',
            'i.date_out',
            'i.user_in',
            'i.user_out',
            'i.tahun',
            'i.bulan',
            'i.no_urut',
            'i.kategori',
            'i.model',
            'i.cabang',
            'i.customer',
            'w.nama as cabang_origin',
            'w1.nama as cabang_destination'
        );

        $table = "penitipan i 
        left join warehouse w on w.id=i.cabang
        left join warehouse w1 on w1.id=i.cabang_move";
        $where = "Where 1=1 AND i.date_out is null";

        $orderby = ' order by i.id desc ';
        $period1 = $this->request->getVar('period1');
        $period2 = $this->request->getVar('period2');
        $cabang = $this->request->getVar('cabang');


        if ($period1 != '' || $period2 != '') {
            $where .= " AND (DATE(i.date_in) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2 . "+1 days")) . "') ";
        } else {
            $where .= " AND (DATE(i.date_in) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2)) . "') ";
        }

        if ($cabang != '') {
            $where .= " AND i.cabang = '" . $cabang . "'";
        }
        $query1 =  $db->query("select " . str_replace(" , ", " ", implode(", ", $columns)) . " from $table $where $orderby ");
        $rowsLimit = $query1->getResult();

        // if (!$rowsLimit) {
        //     return redirect()->back();
        // }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('B1:L1');
        $sheet->mergeCells('B2:L2');
        $sheet->freezePane('A5');
        $sheet->getRowDimension(1);

        $objDrawing = new Drawing();
        $objDrawing->setName('logo-kdk');
        $objDrawing->setDescription('logo-kdk');
        $objDrawing->setPath('assets_adm/img/logo1.png');
        $objDrawing->setCoordinates('A1');
        $objDrawing->setOffsetX(2);
        $objDrawing->setOffsetY(7);
        $objDrawing->setWidthAndHeight(50, 100);
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

        $sheet->getStyle('A4:L4')->applyFromArray($style_header);
        $sheet->getStyle('B1:B2')->applyFromArray($style_center);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);

        $sheet
            ->setCellValue('B1', 'REPORT PENITIPAN IN')
            ->setCellValue('B2', $period1 . " - " . $period2)
            ->setCellValue('A4', 'NO')
            ->setCellValue('B4', 'SN')
            ->setCellValue('C4', 'Tanggal In')
            ->setCellValue('D4', 'User In')
            ->setCellValue('E4', 'Tahun')
            ->setCellValue('F4', 'Bulan')
            ->setCellValue('G4', 'No Urut')
            ->setCellValue('H4', 'Kategori')
            ->setCellValue('I4', 'model')
            ->setCellValue('J4', 'Customer')
            ->setCellValue('K4', 'Warehouse Asal')
            ->setCellValue('L4', 'Warehouse Tujuan');


        $column = 5;
        // tulis data mobil ke cell
        $no = 1;
        foreach ($rowsLimit as $data) {
            $sheet
                ->setCellValue('A' . $column, $no++)
                ->setCellValue('B' . $column, $data->sn)
                ->setCellValue('C' . $column, $data->date_in)
                ->setCellValue('D' . $column, $data->user_in)
                ->setCellValue('E' . $column, $data->tahun)
                ->setCellValue('F' . $column, $data->bulan)
                ->setCellValue('G' . $column, $data->no_urut)
                ->setCellValue('H' . $column, $data->kategori)
                ->setCellValue('I' . $column, $data->model)
                ->setCellValue('J' . $column, $data->customer)
                ->setCellValue('K' . $column, $data->cabang_origin)
                ->setCellValue('L' . $column, $data->cabang_destination);
            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Report penitipan In ' . date("d-m-Y");

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        ob_start();
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();
        die($content);
    }

    public function cetakexcelout()
    {
        $spreadsheet = new Spreadsheet();

        $db = \Config\Database::connect();
        $columns = array(
            'i.sn',
            'i.date_in',
            'i.date_out',
            'i.user_in',
            'i.user_out',
            'i.tahun',
            'i.bulan',
            'i.no_urut',
            'i.kategori',
            'i.model',
            'i.customer',
            'w.nama as cabang_origin',
            'w1.nama as cabang_destination'

        );

        $table = "penitipan i 
        left join warehouse w on w.id=i.cabang
        left join warehouse w1 on w1.id=i.cabang_move";
        $where = "Where 1=1 AND i.date_out is not null";

        $orderby = ' order by i.id desc ';
        $period1 = $this->request->getVar('period1');
        $period2 = $this->request->getVar('period2');
        $cabang = $this->request->getVar('cabang');


        if ($period1 != '' || $period2 != '') {
            $where .= " AND (DATE(i.date_out) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2 . "+1 days")) . "') ";
        } else {
            $where .= " AND (DATE(i.date_out) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2)) . "') ";
        }

        if ($cabang != '') {
            $where .= " AND i.cabang = '" . $cabang . "'";
        }

        $query1 =  $db->query("select " . str_replace(" , ", " ", implode(", ", $columns)) . " from $table $where $orderby ");
        $rowsLimit = $query1->getResult();

        // if (!$rowsLimit) {
        //     return redirect()->back();
        // }
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->setActiveSheetIndex(0)->mergeCells('B1:N1');
        $spreadsheet->setActiveSheetIndex(0)->mergeCells('B2:N2');
        $spreadsheet->getActiveSheet()->freezePane('A5');
        $spreadsheet->getActiveSheet()->getRowDimension(1);

        // $spreadsheet->getActiveSheet()->getStyle('A4:K4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00FF7F');

        $objDrawing = new Drawing();
        $objDrawing->setName('logo-kdk');
        $objDrawing->setDescription('logo-kdk');
        $objDrawing->setPath('assets_adm/img/logo1.png');
        $objDrawing->setCoordinates('A1');
        $objDrawing->setOffsetX(2);
        $objDrawing->setOffsetY(7);
        $objDrawing->setWidthAndHeight(50, 100);
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

        $spreadsheet->getActiveSheet()->getStyle('A4:N4')->applyFromArray($style_header);
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



        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B1', 'REPORT PENITIPAN OUT')
            ->setCellValue('B2', $period1 . " - " . $period2)
            ->setCellValue('A4', 'NO')
            ->setCellValue('B4', 'SN')
            ->setCellValue('C4', 'Tanggal In')
            ->setCellValue('D4', 'Tanggal Out')
            ->setCellValue('E4', 'User In')
            ->setCellValue('F4', 'User Out')
            ->setCellValue('G4', 'Tahun')
            ->setCellValue('H4', 'Bulan')
            ->setCellValue('I4', 'No Urut')
            ->setCellValue('J4', 'Kategori')
            ->setCellValue('K4', 'model')
            ->setCellValue('L4', 'customer')
            ->setCellValue('M4', 'Warehouse Asal')
            ->setCellValue('N4', 'Warehouse Tujuan');

        $column = 5;
        // tulis data mobil ke cell
        $no = 1;
        foreach ($rowsLimit as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $no++)
                ->setCellValue('B' . $column, $data->sn)
                ->setCellValue('C' . $column, $data->date_in)
                ->setCellValue('D' . $column, $data->date_out)
                ->setCellValue('E' . $column, $data->user_in)
                ->setCellValue('F' . $column, $data->user_out)
                ->setCellValue('G' . $column, $data->tahun)
                ->setCellValue('H' . $column, $data->bulan)
                ->setCellValue('I' . $column, $data->no_urut)
                ->setCellValue('J' . $column, $data->kategori)
                ->setCellValue('K' . $column, $data->model)
                ->setCellValue('L' . $column, $data->customer)
                ->setCellValue('M' . $column, $data->cabang_origin)
                ->setCellValue('N' . $column, $data->cabang_destination);
            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Report Penitipan Out ' . date("d-m-Y");

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx'); // 'Xlsx' for Excel 2007 or later format

        ob_start();
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();
        die($content);
    }
}

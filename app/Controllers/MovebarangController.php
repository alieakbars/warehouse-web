<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MovebarangController extends BaseController
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
            'title' => 'Pindah Produk',
            'menu' => 'Pengaturan',
            'warehouse' => $results
        ];

        return view('Admin/movebarangView', $data);
    }

    public function getbarang()
    {
        $db = \Config\Database::connect();

        $columns = array(
            'pp.sn',
            'i.date_in',
            'pp.date_move',
            'i.user_in',
            'pp.user_move',
            'i.tahun',
            'i.bulan',
            'i.no_urut',
            'i.kategori',
            'i.model',
            'w.nama as warehouse_lama',
            'wb.nama as warehouse_baru'

        );

        $columnfilter = array(
            'pp.sn',
            'i.user_in',
            'pp.user_move',
            'i.tahun',
            'i.bulan',
            'i.no_urut',
            'i.nama'
        );

        $table = "pindah_produk pp 
        left join inventory i on i.sn = pp.sn 
        left join warehouse w on w.id = pp.cabang_old 
        left join warehouse wb on wb.id = pp.cabang_move ";
        $where = "Where 1=1";

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
            $where .= " AND (DATE(pp.date_move) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2 . "+1 days")) . "') ";
        } else {
            $where .= " AND (DATE(pp.date_move) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2)) . "') ";
        }

        if ($cabang != '') {
            $where .= " AND pp.cabang_move = '" . $cabang . "'";
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
            $arr['date_move'] = $each->date_move;
            $arr['user_move'] = $each->user_move;
            $arr['user_in'] = $each->user_in;
            $arr['tahun'] = $each->tahun;
            $arr['bulan'] = $each->bulan;
            $arr['no_urut'] = $each->no_urut;
            $arr['kategori'] = $each->kategori;
            $arr['model'] = $each->model;
            $arr['warehouse_lama'] = $each->warehouse_lama;
            $arr['warehouse_baru'] = $each->warehouse_baru;
            $output['data'][] = $arr;
        }

        echo json_encode($output);
    }

    public function cetakexcelmove()
    {
        $spreadsheet = new Spreadsheet();

        $db = \Config\Database::connect();
        $columns = array(
            'pp.sn',
            'i.date_in',
            'pp.date_move',
            'i.user_in',
            'pp.user_move',
            'i.tahun',
            'i.bulan',
            'i.no_urut',
            'i.kategori',
            'i.model',
            'w.nama as warehouse_lama',
            'wb.nama as warehouse_baru'
        );

        $table = "pindah_produk pp 
        left join inventory i on i.sn = pp.sn 
        left join warehouse w on w.id = pp.cabang_old 
        left join warehouse wb on wb.id = pp.cabang_move ";
        $where = "Where 1=1";

        $orderby = ' order by i.id desc ';
        $period1 = $this->request->getVar('period1');
        $period2 = $this->request->getVar('period2');
        $cabang = $this->request->getVar('cabang');


        if ($period1 != '' || $period2 != '') {
            $where .= " AND (DATE(pp.date_move) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2 . "+1 days")) . "') ";
        } else {
            $where .= " AND (DATE(pp.date_move) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2)) . "') ";
        }

        if ($cabang != '') {
            $where .= " AND pp.cabang_move = '" . $cabang . "'";
        }


        $query1 =  $db->query("select " . str_replace(" , ", " ", implode(", ", $columns)) . " from $table $where $orderby ");
        $rowsLimit = $query1->getResult();

        // if (!$rowsLimit) {
        //     return redirect()->back();
        // }
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->setActiveSheetIndex(0)->mergeCells('B1:M1');
        $spreadsheet->setActiveSheetIndex(0)->mergeCells('B2:M2');
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

        $spreadsheet->getActiveSheet()->getStyle('A4:M4')->applyFromArray($style_header);
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


        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B1', 'REPORT BARANG PINDAH')
            ->setCellValue('B2', $period1 . " - " . $period2)
            ->setCellValue('A4', 'NO')
            ->setCellValue('B4', 'SN')
            ->setCellValue('C4', 'Tanggal In')
            ->setCellValue('D4', 'Tanggal Move')
            ->setCellValue('E4', 'User In')
            ->setCellValue('F4', 'User Move')
            ->setCellValue('G4', 'Tahun')
            ->setCellValue('H4', 'Bulan')
            ->setCellValue('I4', 'No Urut')
            ->setCellValue('J4', 'Kategori')
            ->setCellValue('K4', 'Model')
            ->setCellValue('L4', 'Warehouse Lama')
            ->setCellValue('M4', 'Warehouse Baru');

        $column = 5;
        // tulis data mobil ke cell
        $no = 1;
        foreach ($rowsLimit as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $no++)
                ->setCellValue('B' . $column, $data->sn)
                ->setCellValue('C' . $column, $data->date_in)
                ->setCellValue('D' . $column, $data->date_move)
                ->setCellValue('E' . $column, $data->user_in)
                ->setCellValue('F' . $column, $data->user_move)
                ->setCellValue('G' . $column, $data->tahun)
                ->setCellValue('H' . $column, $data->bulan)
                ->setCellValue('I' . $column, $data->no_urut)
                ->setCellValue('J' . $column, $data->kategori)
                ->setCellValue('K' . $column, $data->model)
                ->setCellValue('L' . $column, $data->warehouse_lama)
                ->setCellValue('M' . $column, $data->warehouse_baru);

            // $spreadsheet->getActiveSheet()->setCellValueExplicit('F' . $column, $data->mobile, PHPExcel_Cell_DataType::TYPE_STRING);
            // $spreadsheet->getActiveSheet()->setCellValueExplicit('G' . $column, $data->ongkir, PHPExcel_Cell_DataType::TYPE_STRING);
            // $spreadsheet->getActiveSheet()->setCellValueExplicit('H' . $column, $data->total_harga, PHPExcel_Cell_DataType::TYPE_STRING);
            // $spreadsheet->getActiveSheet()->setCellValueExplicit('I' . $column, $total_belanja, PHPExcel_Cell_DataType::TYPE_STRING);

            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Report Barang Pindah ' . date("d-m-Y");

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

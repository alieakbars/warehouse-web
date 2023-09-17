<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class WarehouseController extends BaseController
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
        $data = [
            'title' => 'Pengaturan Warehouse',
            'menu' => 'Pengaturan'
        ];

        return view('Admin/warehouseView', $data);
    }

    public function getwarehouse()
    {
        $db = \Config\Database::connect();

        $columns = array(
            'id',
            'nama',
            'deskripsi',
            'status',
            'created_at'
        );

        $table = "warehouse";
        $where = "Where 1=1 ";

        $orderby = ' order by id desc';
        $period1 = $this->request->getVar('period1');
        $period2 = $this->request->getVar('period2');
        $length = $this->request->getVar('length');
        $start = $this->request->getVar('start');

        if (isset($period1) || isset($period2)) {
            $where .= " AND (DATE(created_at) BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2 . "+1 days")) . "') ";
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
            $arr['nama'] = $each->nama;
            $arr['deskripsi'] = $each->deskripsi;
            $arr['status'] = $each->status;
            $arr['created_at'] = $each->created_at;
            $output['data'][] = $arr;
        }

        echo json_encode($output);
    }

    public function addwarehouse()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {

            $nama = $this->request->getVar('nama');
            $deskripsi = $this->request->getVar('deskripsi');
            $status = $this->request->getVar('status');


            $time = $this->waktu();

            $query1 = $db->query("SELECT id from warehouse where nama = '$nama'");
            $results = $query1->getResult();

            if ($results) {
                throw new \Exception('Warehouse sudah ada !');
            }

            $db->query("INSERT into warehouse (nama,deskripsi,status,created_at) VALUES ('$nama','$deskripsi','$status',now())");

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

    public function updatewarehouse()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $id = $this->request->getVar('id');
            $nama = $this->request->getVar('nama');
            $deskripsi = $this->request->getVar('deskripsi');
            $status = $this->request->getVar('status');

            $query1 = $db->query("SELECT id from warehouse where id != '$id' AND nama = '$nama'");
            $results = $query1->getResult();

            if ($results) {
                throw new \Exception('Warehouse sudah ada !');
            }

            $db->query("UPDATE warehouse set nama = '$nama', deskripsi = '$deskripsi', status = '$status' where id = '$id' ");

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

    public function deletewarehouse()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $id = $this->request->getVar('id');

            $db->query("DELETE FROM warehouse where id = '$id'");

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
}

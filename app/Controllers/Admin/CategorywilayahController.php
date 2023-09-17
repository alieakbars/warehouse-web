<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\HomeModel;
use App\Models\Admin\ProductModel;
use App\Models\Admin\TransaksiModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class CategorywilayahController extends BaseController
{

    public function index()
    {
        if (!session()->get('admin_logged')) {
            return redirect()->to(base_url('loginController'));
        }
        $getorder = new ProductModel();
        $data = [
            'kategori' => $getorder->getCategory(),
            'title' => 'Kategori',
            'title1' => 'Wilayah',
            'menu' => 'Data Kategori'
        ];

        return view('Admin/categorywilayahView', $data);
    }

    public function getcategory()
    {
        $db = \Config\Database::connect();

        $columns = array(
            'cat_id',
            'cat_title'
        );

        $table = "categories";
        $where = "Where 1=1 ";

        $orderby = ' order by cat_id asc ';
        $period1 = $this->request->getVar('email');
        $period2 = $this->request->getVar('email');
        $length = $this->request->getVar('length');
        $start = $this->request->getVar('start');

        // if (isset($period1) || isset($period2)) {
        //     $where .= " AND (oh.tanggal::DATE BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2 . "+1 days")) . "') ";
        // }
        if ($_POST['search']['value'] != '') {
            $where .= " AND ";
            foreach ($columns as $c) {
                $where .= " CONVERT(" . $c . ",CHARACTER) like '%" . $_POST['search']['value'] . "%' OR ";
            }
            $where = substr_replace($where, "", -3);
        }

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
            $arr['cat_id'] = $each->cat_id;
            $arr['cat_title'] = $each->cat_title;
            $output['data'][] = $arr;
        }

        echo json_encode($output);
    }

    public function getwilayah()
    {
        $db = \Config\Database::connect();

        $columns = array(
            'id_wilayah',
            'nama_wilayah',
            'kuota_wilayah'
        );

        $table = " wilayah";
        $where = "Where 1=1 ";

        //=================== TEMPLATE DATATABLE ===================

        // print_r('<pre>');
        // print_r(isset($_POST['order']) ? "ada" : "gak");die();
        $orderby = ' order by id_wilayah desc ';
        $period1 = $this->request->getVar('email');
        $period2 = $this->request->getVar('email');
        $length = $this->request->getVar('length');
        $start = $this->request->getVar('start');

        // if (isset($period1) || isset($period2)) {
        //     $where .= " AND (tanggal::DATE BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2 . "+1 days")) . "') ";
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
        //=================== END TEMPLATE DATATABLE ===================

        $i = 1;
        foreach ($rowsLimit as $each) {
            $arr = array();
            $arr['id_wilayah'] = $each->id_wilayah;
            $arr['nama_wilayah'] = $each->nama_wilayah;
            $arr['kuota_wilayah'] = $each->kuota_wilayah;
            $output['data'][] = $arr;
        }

        echo json_encode($output);
    }

    public function addcategory()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $cat_title = $this->request->getVar('cat_title');
            $db->query("INSERT INTO categories (cat_title) VALUES ('$cat_title')");

            $db->transCommit();
            echo json_encode([
                "status_code" => '01',
                "message" => "Berhasil ditambah",
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

    public function addwilayah()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $nama_wilayah = $this->request->getVar('nama_wilayah');
            $kuota_wilayah = $this->request->getVar('kuota_wilayah');
            $db->query("INSERT INTO wilayah (nama_wilayah,kuota_wilayah) VALUES ('$nama_wilayah','$kuota_wilayah')");

            $db->transCommit();
            echo json_encode([
                "status_code" => '01',
                "message" => "Berhasil ditambah",
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

    public function updatecategory()
    {

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $cat_title = $this->request->getVar('cat_title');
            $cat_id = $this->request->getVar('cat_id');

            $db->query("UPDATE categories set cat_title = '$cat_title' where cat_id = '$cat_id' ");

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

    public function updatewilayah()
    {

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $nama_wilayah = $this->request->getVar('nama_wilayah');
            $kuota_wilayah = $this->request->getVar('kuota_wilayah');
            $id_wilayah = $this->request->getVar('id_wilayah');

            $db->query("UPDATE wilayah set nama_wilayah = '$nama_wilayah', kuota_wilayah = '$kuota_wilayah' where id_wilayah = '$id_wilayah' ");

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

    public function deletecategory()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $cat_id = $this->request->getVar('cat_id');

            $db->query("DELETE FROM categories where cat_id = '$cat_id' ");

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

    public function deletewilayah()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $id_wilayah = $this->request->getVar('id_wilayah');

            $db->query("DELETE FROM wilayah where id_wilayah = '$id_wilayah' ");

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
}

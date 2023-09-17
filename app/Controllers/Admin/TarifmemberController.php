<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\HomeModel;
use App\Models\Admin\ProductModel;
use App\Models\Admin\TransaksiModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class TarifmemberController extends BaseController
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
        $data = [
            'title' => 'Tarif Belanja Minimum',
            'menu' => 'Tarif Belanja Minimum'
        ];

        return view('Admin/tarifmemberView', $data);
    }
    public function gettarif()
    {
        $db = \Config\Database::connect();

        $columns = array(
            'nama_tarif',
            'tarif'
        );

        $table = " min_belanja_member";
        $where = "Where 1=1 ";

        $orderby = ' order by id_tarif asc ';
        $period1 = $this->request->getVar('email');
        $period2 = $this->request->getVar('email');
        $length = $this->request->getVar('length');
        $start = $this->request->getVar('start');

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
        $query1 =  $db->query("select * from $table $where $orderby LIMIT " . $length . " OFFSET " . $start . " ");
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
            $arr['id_tarif'] = $each->id_tarif;
            $arr['nama_tarif'] = $each->nama_tarif;
            $arr['tarif'] = $each->tarif;
            $output['data'][] = $arr;
        }

        echo json_encode($output);
    }

    public function updatetarif()
    {

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $id = $this->request->getVar('id_tarif');
            $tarif = $this->request->getVar('tarif');
            $db->query("UPDATE min_belanja_member SET tarif = $tarif WHERE id_tarif = '$id'");

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
}

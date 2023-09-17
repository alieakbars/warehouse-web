<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\HomeModel;
use App\Models\Admin\ProductModel;
use App\Models\Admin\TransaksiModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Exception;
use PhpParser\Node\Expr\Throw_;

class AdsController extends BaseController
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
            return redirect()->to(base_url('Admin/loginController'));
        }

        $data = [
            'title' => 'Iklan',
            'menu' => 'Data Iklan'
        ];

        return view('Admin/adsView', $data);
    }

    public function getads()
    {
        $db = \Config\Database::connect();

        $columns = array(
            'judul',
            'gambar',
            'tanggal',
            'status',
            'id_iklan'

        );

        $table = "promo_iklan";
        $where = "Where 1=1 ";

        $orderby = ' order by judul asc ';
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
            $arr['id_iklan'] = $each->id_iklan;
            $arr['judul'] = $each->judul;
            $arr['gambar'] = $each->gambar;
            $arr['status'] = $each->status;
            $arr['tanggal'] = $each->tanggal;

            $output['data'][] = $arr;
        }

        echo json_encode($output);
    }

    public function addads()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {

            $judul = $this->request->getVar('judul');
            $file1 = $this->request->getFile('gambar');
            $status = $this->request->getVar('status');
            $time = $this->waktu();

            $gambar1 = '';

            if ($file1->isValid()) {
                $gambar1 = $file1->getRandomName();
                $file1->move('assets/img_ads', $gambar1, true);
            }

            $query1 = $db->query("SELECT id_iklan from promo_iklan where judul = '$judul'");
            $results = $query1->getResult();

            if ($results) {
                throw new \Exception('Data sudah ada !');
            }

            $db->query("INSERT into promo_iklan (judul,gambar,tanggal,status) VALUES ('$judul','$gambar1','$time','$status')");

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

    public function updateads()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $id_iklan = $this->request->getVar('id_iklan');
            $judul = $this->request->getVar('judul');
            $gambar1 = $this->request->getvar('gambar1');
            $status = $this->request->getVar('status');
            $file1 = $this->request->getFile('gambar');
            $time = $this->waktu();

            if ($file1->isValid()) {
                if ($gambar1) {
                    if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/assets/img_ads/' . $gambar1)) {
                        unlink($_SERVER["DOCUMENT_ROOT"] . '/assets/img_ads/' . $gambar1);
                    }
                }
                $gambar1 = $file1->getRandomName();
                $file1->move('assets/img_ads', $gambar1, true);
            }

            $query1 = $db->query("SELECT id_iklan from promo_iklan where id_iklan != '$id_iklan' AND judul = '$judul'");
            $results = $query1->getResult();

            if ($results) {
                throw new \Exception('Data sudah ada !');
            }

            $db->query("UPDATE promo_iklan set judul = '$judul', gambar = '$gambar1', status = '$status' where id_iklan = '$id_iklan' ");

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

    public function deleteads()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $kode = $this->request->getVar('id_iklan');
            $namaFile1 = $this->request->getVar('gambar');

            if ($namaFile1) {
                if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/assets/img_ads/' . $namaFile1)) {
                    unlink($_SERVER["DOCUMENT_ROOT"] . '/assets/img_ads/' . $namaFile1);
                }
            }

            $db->query("DELETE FROM promo_iklan where id_iklan = '$kode'");

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

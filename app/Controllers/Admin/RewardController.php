<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\HomeModel;
use App\Models\Admin\ProductModel;
use App\Models\Admin\TransaksiModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Exception;
use PhpParser\Node\Expr\Throw_;

class RewardController extends BaseController
{
    function waktu()
    {
        date_default_timezone_set('Asia/Jakarta');
        $dt = date('Y-m-d H:i:s');
        return $dt;
    }
    function tanggal()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tgl = date('Y-m-d');
        return $tgl;
    }

    public function index()
    {
        if (!session()->get('admin_logged')) {
            return redirect()->to(base_url('loginController'));
        }

        $data = [
            'title' => 'Reward',
            'menu' => 'Reward'
        ];

        return view('Admin/rewardView', $data);
    }

    public function getreward()
    {
        $db = \Config\Database::connect();

        $columns = array(
            'id_wd',
            'judul',
            'deskripsi',
            'poin',
            'gambar',
            'tgl_akhir',
            'status'
        );

        $table = "withdraw_poin";
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
            $arr['id_wd'] = $each->id_wd;
            $arr['judul'] = $each->judul;
            $arr['deskripsi'] = $each->deskripsi;
            $arr['poin'] = $each->poin;
            $arr['gambar'] = $each->gambar;
            $arr['tgl_akhir'] = $each->tgl_akhir;
            $arr['status'] = $each->status;

            $output['data'][] = $arr;
        }

        echo json_encode($output);
    }

    public function addreward()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {

            $judul = $this->request->getVar('judul');
            $deskripsi = $this->request->getFile('deskripsi');
            $poin = $this->request->getVar('poin');
            $file1 = $this->request->getFile('gambar');
            $tgl_akhir = $this->request->getVar('tgl_akhir');
            $status = $this->request->getVar('status');

            $tanggal = $this->tanggal();

            $gambar1 = '';

            if ($file1->isValid()) {
                $gambar1 = $file1->getRandomName();
                $file1->move('assets/img_reward', $gambar1, true);
            }

            $query1 = $db->query("SELECT id_wd from withdraw_poin where judul = '$judul'");
            $results = $query1->getResult();

            if ($results) {
                throw new \Exception('Data sudah ada !');
            }

            $db->query("INSERT into withdraw_poin (judul,deskripsi,poin,gambar,tgl_akhir,status) VALUES
            ('$judul','$deskripsi','$poin','$gambar1','$tgl_akhir','$status')");

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

    public function updatereward()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        // print_r($_POST);
        // die();

        try {
            $judul = $this->request->getVar('judul');
            $deskripsi = $this->request->getFile('deskripsi');
            $poin = $this->request->getVar('poin');
            $file1 = $this->request->getFile('gambar');
            $tgl_akhir = $this->request->getVar('tgl_akhir');
            $status = $this->request->getVar('status');
            $id_wd = $this->request->getVar('id_wd');
            $gambar1 = $this->request->getvar('gambar1');

            $time = $this->waktu();

            if ($file1->isValid()) {
                if ($gambar1) {
                    if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/assets/img_reward/' . $gambar1)) {
                        unlink($_SERVER["DOCUMENT_ROOT"] . '/assets/img_reward/' . $gambar1);
                    }
                }
                $gambar1 = $file1->getRandomName();
                $file1->move('assets/img_reward', $gambar1, true);
            }

            $query1 = $db->query("SELECT id_wd from withdraw_poin where id_wd != '$id_wd' AND judul = '$judul'");
            $results = $query1->getResult();

            if ($results) {
                throw new \Exception('Data sudah ada !');
            }

            $db->query("UPDATE withdraw_poin set judul = '$judul', deskripsi = '$deskripsi', poin = '$poin', gambar = '$gambar1',
             tgl_akhir = '$tgl_akhir', status = '$status' where id_wd = '$id_wd' ");

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

    public function deletereward()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $kode = $this->request->getVar('id_wd');
            $namaFile1 = $this->request->getVar('gambar');

            if ($namaFile1) {
                if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/assets/img_reward/' . $namaFile1)) {
                    unlink($_SERVER["DOCUMENT_ROOT"] . '/assets/img_reward/' . $namaFile1);
                }
            }

            $db->query("DELETE FROM withdraw_poin where id_wd = '$kode'");

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

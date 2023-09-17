<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function cekuser()
    {
        $db = \Config\Database::connect();
        $id = $this->request->getVar('id');

        $query = $db->query("SELECT id FROM user WHERE id ='$id' AND status = 1");
        $rowsLimit = $query->getResult();

        if ($rowsLimit) {
            return json_encode([
                "status_code" => "202",
                "message" => "Aktif"
            ]);
        } else {
            return json_encode([
                "status_code" => "303",
                "message" => "Tidak Aktif"
            ]);
        }
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $query = $db->query("SELECT * FROM user WHERE username ='$username' AND status = '1'");
        $dataUser = $query->getResult();

        if ($dataUser) {
            if (password_verify($password, $dataUser[0]->password)) {

                return json_encode([
                    "status_code" => "202",
                    "message" => "Berhasil Login",
                    "data" => array(
                        'id' => $dataUser[0]->id,
                        'nama' => $dataUser[0]->nama,
                        'no_pegawai' => $dataUser[0]->no_pegawai,
                        'level' => $dataUser[0]->level,
                        'cabang' => $dataUser[0]->cabang,

                    )
                ]);
            } else {
                return json_encode([
                    "status_code" => "303",
                    "message" => "Password anda salah !",
                    "data" => null
                ]);
            }
        } else {
            return json_encode([
                "status_code" => "202",
                "message" => "User tidak ditemukan !",
                "data" => null
            ]);
        }
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LoginController extends BaseController
{
    public function index()
    {
        if (session()->get('logged')) {
            return redirect()->to(base_url('dashboardController'));
        }
        $data = [
            'title' => 'login'
        ];
        return view('Admin/loginView', $data);
    }
    public function process()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $query = $db->query("SELECT * FROM user where username = '$username'  LIMIT 1");
        $check = $query->getRow();

        if ($check) {
            $lv = $check->level;
            if ($check->status != 1) {
                session()->setFlashdata('error', 'Akun anda tidak aktif');
                return redirect()->back();
            }
            if ($lv == 2) {
                session()->setFlashdata('error', 'Akun tidak mempunyai akses');
                return redirect()->back();
            }
            if (password_verify($password, $check->password)) {
                session()->set([
                    'id' => $check->id,
                    'name' => $check->nama,
                    'status' => $check->status,
                    'no_pegawai' => $check->no_pegawai,
                    'level' => $check->status,
                    'logged' => TRUE
                ]);
                return redirect()->to(base_url('loginController'));
            } else {
                session()->setFlashdata('error', 'Username & Password Salah');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('error', 'Username & Password Salah');
            return redirect()->back();
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('loginController'));
    }
}

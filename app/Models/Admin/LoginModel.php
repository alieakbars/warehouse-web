<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class LoginModel extends Model
{
    public function getCategory()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM categories");
        $results = $query->getResultArray();
        return $results;
    }
    public function getOrderGuestDetail($kode)
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM orders_pengunjung where kode_transaksi = '$kode'");
        return $query->getResultArray();
    }
}

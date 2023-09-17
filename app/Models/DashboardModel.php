<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
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

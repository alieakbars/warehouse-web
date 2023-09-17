<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    public function getOrderMember()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT orders, gambar FROM promo_iklan where status = 1");
        $results = $query->getResultArray();
        return $results;
    }
    public function getOrderGuestDetail($kode)
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM orders_pengunjung where kode_transaksi = '$kode'");
        return $query->getResultArray();
    }
    public function getOrderMemberDetail($kode)
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM orders where kode_transaksi = '$kode'");
        return $query->getResultArray();
    }
}

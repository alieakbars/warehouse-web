<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    public function getOrder()
    {
        $user = session()->get('user_id');
        $type = session()->get('type');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM order_harga where user_id = '$user'");
        return $query->getResultArray();
    }
    public function getOrderGuest()
    {
        $user = session()->get('user_id');
        $type = session()->get('type');

        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM order_harga_pengunjung where user_id = '$user'");
        return $query->getResultArray();
    }
    public function getOrderGuestDetail($kode)
    {
        $user = session()->get('user_id');
        $type = session()->get('type');

        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM orders_pengunjung where kode_transaksi = '$kode'");
        return $query->getResultArray();
    }

    public function getOrderMemberDetail($kode)
    {
        $user = session()->get('user_id');
        $type = session()->get('type');

        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM orders where kode_transaksi = '$kode'");
        return $query->getResultArray();
    }
}

<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class InvoiceController extends BaseController
{
    function waktu()
    {
        date_default_timezone_set('Asia/Jakarta');
        $dt = date('Y-m-d H:i:s');
        return $dt;
    }

    public function cetakinvoiceguest()
    {
        $kode = $this->request->getVar('kodetransaksi');

        if (!isset($kode)) {
            return redirect()->to(base_url('Admin/transaksiController'));
        }

        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM orders_pengunjung where kode_transaksi = '$kode'");
        $data = $query->getResult();
        $result['orders'] = $data;

        $query1 = $db->query("SELECT * FROM order_harga_pengunjung where kode_transaksi = '$kode'");
        $data1 = $query1->getRow();
        $result['order'] = $data1;
        return view('Admin/invoiceView', $result);
    }

    public function cetakinvoicemember()
    {
        $kode = $this->request->getVar('kodetransaksi');

        if (!isset($kode)) {
            return redirect()->to(base_url('Admin/transaksiController/guest'));
        }

        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM orders where kode_transaksi = '$kode'");
        $data = $query->getResult();
        $result['orders'] = $data;

        $query1 = $db->query("SELECT oh.*, ui.mobile FROM order_harga oh LEFT JOIN user_info ui ON ui.user_id = oh.user_id where kode_transaksi = '$kode'");
        $data1 = $query1->getRow();
        $result['order'] = $data1;
        return view('Admin/invoiceView', $result);
    }
}

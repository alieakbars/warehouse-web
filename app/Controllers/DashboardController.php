<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DashboardModel;

class DashboardController extends BaseController
{

    public function index()
    {
        if (!session()->get('logged')) {
            return redirect()->to(base_url('loginController'));
        }
        $db = \Config\Database::connect();
        $query = $db->query("SELECT count(id) as jumlah FROM inventory WHERE date(date_in) = date(now())");
        $inharian = $query->getResult();

        $query1 = $db->query("SELECT count(id) as jumlah FROM inventory WHERE month(date_in) = month(now())");
        $inbulanan = $query1->getResult();

        $query2 = $db->query("SELECT count(id) as jumlah FROM inventory WHERE date(date_out) = date(now())");
        $outharian = $query2->getResult();

        $query3 = $db->query("SELECT count(id) as jumlah FROM inventory WHERE month(date_out) = month(now())");
        $outbulanan = $query3->getResult();

        $getorder = new DashboardModel();
        $data = [
            // 'kategori' => $getorder->getCategory(),
            'title' => 'Dashboard',
            'menu' => 'Data Produk',
            'inharian' => $inharian[0]->jumlah,
            'inbulanan' => $inbulanan[0]->jumlah,
            'outharian' => $outharian[0]->jumlah,
            'outbulanan' => $outbulanan[0]->jumlah,

        ];

        return view('Admin/dashboardView', $data);
    }
    public function getProduct()
    {
        $db = \Config\Database::connect();

        $columns = array(
            'p.product_title',
            'p.brand',
            'c.cat_title'
        );

        $table = " products p
            left join products_price pp on pp.product_id = p.product_id
            left join categories c on c.cat_id = p.product_cat
            left join image_product ip on ip.product_id = p.product_id
        ";
        $where = "Where 1=1 ";

        //=================== TEMPLATE DATATABLE ===================

        // print_r('<pre>');
        // print_r(isset($_POST['order']) ? "ada" : "gak");die();
        $orderby = ' order by p.product_title asc ';
        $period1 = $this->request->getVar('email');
        $period2 = $this->request->getVar('email');
        $length = $this->request->getVar('length');
        $start = $this->request->getVar('start');

        // if (isset($period1) || isset($period2)) {
        //     $where .= " AND (oh.tanggal::DATE BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2 . "+1 days")) . "') ";
        // }


        if ($_POST['search']['value'] != '') {
            $where .= " AND ";
            foreach ($columns as $c) {
                $where .= " CONVERT(" . $c . ",CHARACTER) like '%" . $_POST['search']['value'] . "%' OR ";
            }
            $where = substr_replace($where, "", -3);
        }

        // print_r("select o.*, oh.*, " . str_replace(" , ", " ", implode(", ", $columns)) . " from $table $where $orderby LIMIT " . $length . " OFFSET " . $start . " ");
        // die();

        // for count all 'recordsFiltered' Datatable
        $query = $db->query("select " . str_replace(" , ", " ", implode(", ", $columns)) . " from $table $where ");
        $rows = $query->getResult();

        // for count filtered 'recordsTotal' Datatable 
        $query1 =  $db->query("select p.*,pp.*,c.cat_title,ip.* from $table $where $orderby LIMIT " . $length . " OFFSET " . $start . " ");
        $rowsLimit = $query1->getResult();
        // we send this output to frontend
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => count($rows),
            "recordsFiltered" => count($rows),
            "data" => array()
        );
        //=================== END TEMPLATE DATATABLE ===================

        $i = 1;
        foreach ($rowsLimit as $each) {
            $arr = array();
            $arr['product_id'] = $each->product_id;
            $arr['product_cat'] = $each->product_cat;
            $arr['product_title'] = $each->product_title;
            $arr['product_desc'] = $each->product_desc;
            $arr['product_weight'] = $each->product_weight;
            $arr['brand'] = $each->brand;
            $arr['composition'] = $each->composition;
            $arr['formulasi'] = $each->formulasi;
            $arr['skin_type'] = $each->skin_type;
            $arr['benefit'] = $each->benefit;
            $arr['storage_period'] = $each->storage_period;
            $arr['volume'] = $each->volume;
            $arr['expired'] = $each->expired;
            $arr['product_size'] = $each->product_size;
            $arr['unit_size'] = $each->unit_size;
            $arr['pack'] = $each->pack;
            $arr['origin'] = $each->origin;
            $arr['price_distributor'] = $each->price_distributor;
            $arr['price_reseller'] = $each->price_reseller;
            $arr['price_agen'] = $each->price_agen;
            $arr['price_guest'] = $each->price_guest;
            $arr['qty'] = $each->qty;
            $arr['poin'] = $each->poin;
            $arr['status'] = $each->status;
            $arr['cat_title'] = $each->cat_title;
            $arr['gambar1'] = $each->gambar1;
            $arr['gambar2'] = $each->gambar2;
            $arr['gambar3'] = $each->gambar3;
            $output['data'][] = $arr;
        }

        echo json_encode($output);
    }

    public function getorderguest()
    {
        $db = \Config\Database::connect();

        $columns = array(
            'kode_transaksi',
            'nama',
            'email',
            'mobile'
        );

        $table = " order_harga_pengunjung";
        $where = "Where 1=1 ";

        //=================== TEMPLATE DATATABLE ===================

        // print_r('<pre>');
        // print_r(isset($_POST['order']) ? "ada" : "gak");die();
        $orderby = ' order by id_harga desc ';
        $period1 = $this->request->getVar('email');
        $period2 = $this->request->getVar('email');
        $length = $this->request->getVar('length');
        $start = $this->request->getVar('start');

        if (isset($period1) || isset($period2)) {
            $where .= " AND (tanggal::DATE BETWEEN '" . date('Y-m-d', strtotime($period1)) . "' and '" . date('Y-m-d', strtotime($period2 . "+1 days")) . "') ";
        }


        if ($_POST['search']['value'] != '') {
            $where .= " AND ";
            foreach ($columns as $c) {
                $where .= " CONVERT(" . $c . ",CHARACTER) like '%" . $_POST['search']['value'] . "%' OR ";
            }
            $where = substr_replace($where, "", -3);
        }

        // print_r("select o.*, oh.*, " . str_replace(" , ", " ", implode(", ", $columns)) . " from $table $where $orderby LIMIT " . $length . " OFFSET " . $start . " ");
        // die();

        // for count all 'recordsFiltered' Datatable
        $query = $db->query("select " . str_replace(" , ", " ", implode(", ", $columns)) . " from $table $where ");
        $rows = $query->getResult();

        // for count filtered 'recordsTotal' Datatable 
        $query1 =  $db->query("select *, " . str_replace(" , ", " ", implode(", ", $columns)) . " from $table $where $orderby LIMIT " . $length . " OFFSET " . $start . " ");
        $rowsLimit = $query1->getResult();
        // we send this output to frontend
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => count($rows),
            "recordsFiltered" => count($rows),
            "data" => array()
        );
        //=================== END TEMPLATE DATATABLE ===================

        $i = 1;
        foreach ($rowsLimit as $each) {
            $arr = array();
            $arr['kode_transaksi'] = $each->kode_transaksi;
            $arr['tanggal'] = $each->tanggal;
            $arr['nama'] = $each->nama;
            $arr['total_harga'] = $each->total_harga;
            $arr['metode'] = $each->metode;
            $arr['alamat'] = $each->tujuan;
            $arr['bukti_tf'] = $each->bukti_tf;
            $arr['status'] = $each->status;
            $arr['id_harga'] = $each->id_harga;
            $arr['mobile'] = $each->mobile;
            $arr['email'] = $each->email;
            $arr['ongkir'] = $each->ongkir;
            $output['data'][] = $arr;
        }

        echo json_encode($output);
    }
    public function getCategory()
    {
        $getorder = new ProductModel();
        $data =  $getorder->getCategory();
        return json_encode($data);
    }

    public function addProduct()
    {
        // print_r($_POST);
        // die();

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $file1 = $this->request->getFile('image1');
            $file2 = $this->request->getFile('image2');
            $file3 = $this->request->getFile('image3');
            $gambar1 = '';
            $gambar2 = '';
            $gambar3 = '';

            if ($file1->isValid()) {
                $gambar1 = $file1->getRandomName();
                $file1->move('assets/img_prod', $gambar1, true);
            }
            if ($file2->isValid()) {
                $gambar2 = $file2->getRandomName();
                $file2->move('assets/img_prod', $gambar2, true);
            }
            if ($file3->isValid()) {
                $gambar3 = $file3->getRandomName();
                $file3->move('assets/img_prod', $gambar3, true);
            }
            $product_title = $this->request->getVar('product_name');
            $category = $this->request->getVar('category_id');
            $qty = $this->request->getVar('product_qty');
            $price_guest = $this->request->getVar('harga_guest');
            $price_distributor = $this->request->getVar('harga_distributor');
            $price_reseller = $this->request->getVar('harga_reseller');
            $price_agen = $this->request->getVar('harga_agen');
            $poin = $this->request->getVar('poin');
            $weight = $this->request->getVar('product_weight');
            $brand = $this->request->getVar('merek');
            $composition = $this->request->getVar('komposisi');
            $formulasi = $this->request->getVar('formulasi');
            $skin = $this->request->getVar('jenis_kulit');
            $benefit = $this->request->getVar('manfaat');
            $storage_period = $this->request->getVar('masa_penyimpanan');
            $volume = $this->request->getVar('volume');
            $expired = $this->request->getVar('expired');
            $product_size = $this->request->getVar('ukuran_produk');
            $unit_size = $this->request->getVar('ukuran_satuan');
            $pack = $this->request->getVar('kemasan');
            $origin = $this->request->getVar('asal');
            $status = $this->request->getVar('status');
            $product_desc = $this->request->getVar('product_desc');

            $query = $db->query("SELECT max(product_id) as kodeTerbesar FROM products");
            $data = $query->getResultArray();
            $kode = $data[0]['kodeTerbesar'] + 1;

            $db->query("INSERT into products (product_id,product_cat,product_title,product_desc,product_weight,brand,composition,formulasi,
            skin_type,benefit,storage_period,volume,expired,product_size,unit_size,pack,origin) VALUES ('$kode','$category','$product_title',
            '$product_desc','$weight','$brand','$composition','$formulasi','$skin','$benefit','$storage_period','$volume','$expired',
            '$product_size','$unit_size','$pack','$origin')");

            $db->query("INSERT INTO products_price (product_id,price_distributor,price_reseller,price_agen,price_guest,qty,poin,status) VALUES 
            ('$kode','$price_distributor','$price_reseller','$price_agen','$price_guest','$qty','$poin','$status')");

            $db->query("INSERT INTO image_product (product_id,gambar1,gambar2,gambar3) VALUES ('$kode','$gambar1','$gambar2','$gambar3')");

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

    public function updateProduct()
    {
        // print_r($_POST);
        // die();

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $file1 = $this->request->getFile('image1');
            $file2 = $this->request->getFile('image2');
            $file3 = $this->request->getFile('image3');
            $gambar1 = $this->request->getvar('gambar1');
            $gambar2 = $this->request->getvar('gambar2');
            $gambar3 = $this->request->getvar('gambar3');

            if ($file1->isValid()) {
                if ($gambar1) {
                    if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/assets/img_prod/' . $gambar1)) {
                        unlink($_SERVER["DOCUMENT_ROOT"] . '/assets/img_prod/' . $gambar1);
                    }
                }

                $gambar1 = $file1->getRandomName();
                $file1->move('assets/img_prod', $gambar1, true);
            }
            if ($file2->isValid()) {
                if ($gambar2) {
                    if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/assets/img_prod/' . $gambar2)) {
                        unlink($_SERVER["DOCUMENT_ROOT"] . '/assets/img_prod/' . $gambar2);
                    }
                }
                $gambar2 = $file2->getRandomName();
                $file2->move('assets/img_prod', $gambar2, true);
            }
            if ($file3->isValid()) {
                if ($gambar3) {
                    if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/assets/img_prod/' . $gambar3)) {
                        unlink($_SERVER["DOCUMENT_ROOT"] . '/assets/img_prod/' . $gambar3);
                    }
                }
                $gambar3 = $file3->getRandomName();
                $file3->move('assets/img_prod', $gambar3, true);
            }

            $kode = $this->request->getVar('kode');
            $product_title = $this->request->getVar('product_name');
            $category = $this->request->getVar('category_id');
            $qty = $this->request->getVar('product_qty');
            $price_guest = $this->request->getVar('harga_guest');
            $price_distributor = $this->request->getVar('harga_distributor');
            $price_reseller = $this->request->getVar('harga_reseller');
            $price_agen = $this->request->getVar('harga_agen');
            $poin = $this->request->getVar('poin');
            $weight = $this->request->getVar('product_weight');
            $brand = $this->request->getVar('merek');
            $composition = $this->request->getVar('komposisi');
            $formulasi = $this->request->getVar('formulasi');
            $skin = $this->request->getVar('jenis_kulit');
            $benefit = $this->request->getVar('manfaat');
            $storage_period = $this->request->getVar('masa_penyimpanan');
            $volume = $this->request->getVar('volume');
            $expired = $this->request->getVar('expired');
            $product_size = $this->request->getVar('ukuran_produk');
            $unit_size = $this->request->getVar('ukuran_satuan');
            $pack = $this->request->getVar('kemasan');
            $origin = $this->request->getVar('asal');
            $status = $this->request->getVar('status');
            $product_desc = $this->request->getVar('product_desc');

            $db->query("UPDATE products set product_cat = '$category', product_title = '$product_title', product_desc = '$product_desc', product_weight = '$weight',
            brand = '$brand', composition = '$composition', formulasi = '$formulasi', skin_type = '$skin', benefit = '$benefit',
            storage_period = '$storage_period', volume = '$volume', expired = '$expired', product_size = '$product_size', unit_size = '$unit_size',
            pack = '$pack', origin = '$origin' where product_id = '$kode' ");

            $db->query("UPDATE products_price set price_distributor = '$price_distributor', price_reseller = '$price_reseller', 
            price_agen = '$price_agen', price_guest = '$price_guest', qty = '$qty', poin = '$poin', status = '$status'  where product_id = '$kode' ");

            $db->query("UPDATE image_product set gambar1 = '$gambar1', gambar2 = '$gambar2', gambar3 = '$gambar3' where product_id = '$kode' ");

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

    public function deleteProduct()
    {
        $namaFile1 = $this->request->getVar('gambar1');
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $kode = $this->request->getVar('pid');
            $namaFile1 = $this->request->getVar('gambar1');
            $namaFile2 = $this->request->getVar('gambar2');
            $namaFile3 = $this->request->getVar('gambar3');

            $db->query("DELETE FROM products where product_id = '$kode' ");
            $db->query("DELETE FROM image_product where product_id = '$kode' ");
            $db->query("DELETE FROM products_price where product_id = '$kode' ");

            if ($namaFile1) {
                if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/assets/img_prod/' . $namaFile1)) {
                    unlink($_SERVER["DOCUMENT_ROOT"] . '/assets/img_prod/' . $namaFile1);
                }
            }
            if ($namaFile2) {
                if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/assets/img_prod/' . $namaFile2)) {
                    unlink($_SERVER["DOCUMENT_ROOT"] . '/assets/img_prod/' . $namaFile2);
                }
            }
            if ($namaFile3) {
                if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/assets/img_prod/' . $namaFile3)) {
                    unlink($_SERVER["DOCUMENT_ROOT"] . '/assets/img_prod/' . $namaFile3);
                }
            }


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

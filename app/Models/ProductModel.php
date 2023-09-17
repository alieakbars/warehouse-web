<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'product_id';

    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'product_cat', 'product_title', 'product_price', 'harga_promo', 'poin', 'product_qty', 'product_desc',
        'product_weight', 'brand', 'composition', 'formulasi', 'skin_type', 'benefit', 'storage_period', 'volume', 'expired', 'product_size',
        'unit_size', 'pack', 'origin'
    ];

    public function getAllProducts()
    {
        $this->select('products.*,image_product.gambar1,products_price.price_distributor,products_price.price_reseller,
        products_price.price_agen,products_price.price_guest,products_price.price_guest,products_price.poin,products_price.status,products_price.qty');
        $this->join('image_product', 'image_product.product_id = products.product_id', 'LEFT');
        $this->join('products_price', 'products_price.product_id = products.product_id', 'LEFT');

        $result = $this->findAll();

        return $result;
    }
    public function getProducts($id)
    {
        $this->select('*');
        $this->select('products.*,image_product.gambar1,image_product.gambar2,image_product.gambar3,products_price.price_distributor,products_price.price_reseller,
        products_price.price_agen,products_price.price_guest,products_price.price_guest,products_price.poin,products_price.status,products_price.qty');
        $this->join('image_product', 'image_product.product_id = products.product_id', 'LEFT');
        $this->join('products_price', 'products_price.product_id = products.product_id', 'LEFT');
        $this->where('products.product_id', $id);
        $result = $this->find();

        return $result;
    }
    public function getAds()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT judul, gambar FROM promo_iklan where status = 1");
        $results = $query->getResultArray();
        return $results;
    }
    public function getBenefitMember()
    {
        $db = \Config\Database::connect();
        $user_id = session()->get('user_id');
        $query = $db->query("SELECT poin FROM poin_belanja where user_id = '" . $user_id . "'");
        $query2 = $db->query("SELECT poin FROM user_info where user_id = '" . $user_id . "'");
        $query3 = $db->query("SELECT COUNT(user_id) AS member FROM user_info WHERE k_referal = '" . $user_id . "'");
        $results1 = $query->getResultArray();
        $results2 = $query2->getResultArray();
        $results3 = $query3->getResultArray();
        $data = array(
            'poin' => $results1[0]['poin'],
            'saldo' => $results2[0]['poin'],
            'join_member' => $results3[0]['member']
        );
        return $data;
    }
    public function getCart()
    {
        $user = session()->get('user_id');
        $type = session()->get('type');
        if ($type == 1) {
            $get = 'pp.price_guest';
        } else if ($type == 2) {
            $get = 'pp.price_distributor';
        } else if ($type == 3) {
            $get = 'pp.price_reseller';
        } else if ($type == 4) {
            $get = 'pp.price_agen';
        } else {
            return false;
        }

        $db = \Config\Database::connect();
        $query = $db->query("SELECT c.p_id,i.gambar1, p.product_title, $get as price, c.qty, pp.poin, p.product_weight FROM cart c 
        left join products p on p.product_id = c.p_id
        left join products_price pp on pp.product_id = p.product_id
        left join image_product i on i.product_id = p.product_id
        where c.user_id = '$user'");
        return $query->getResultArray();
    }
    public function getOrder()
    {
        $user = session()->get('user_id');
        $type = session()->get('type');
        if ($type == 1) {
            $get = 'pp.price_guest';
        } else if ($type == 2) {
            $get = 'pp.price_distributor';
        } else if ($type == 3) {
            $get = 'pp.price_reseller';
        } else if ($type == 4) {
            $get = 'pp.price_agen';
        } else {
            return false;
        }

        $db = \Config\Database::connect();
        $query = $db->query("SELECT c.p_id,i.gambar1, p.product_title, $get as price, c.qty, pp.poin, p.product_weight FROM cart c 
        left join products p on p.product_id = c.p_id
        left join products_price pp on pp.product_id = p.product_id
        left join image_product i on i.product_id = p.product_id
        where c.user_id = '$user'");
        return $query->getResultArray();
    }
    public function getOrderGuest()
    {
        $user = session()->get('user_id');
        $type = session()->get('type');
        if ($type == 1) {
            $get = 'pp.price_guest';
        } else if ($type == 2) {
            $get = 'pp.price_distributor';
        } else if ($type == 3) {
            $get = 'pp.price_reseller';
        } else if ($type == 4) {
            $get = 'pp.price_agen';
        } else {
            return false;
        }

        $db = \Config\Database::connect();
        $query = $db->query("SELECT c.p_id,i.gambar1, p.product_title, $get as price, c.qty, pp.poin, p.product_weight FROM cart c 
        left join products p on p.product_id = c.p_id
        left join products_price pp on pp.product_id = p.product_id
        left join image_product i on i.product_id = p.product_id
        where c.user_id = '$user'");
        return $query->getResultArray();
    }
}

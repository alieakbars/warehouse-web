<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
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
}

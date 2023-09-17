<?php

namespace App\Models;

use CodeIgniter\Model;

class RegisterModel extends Model
{
    protected $table      = 'user_info';
    protected $primaryKey = 'user_id';

    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'user_id', 'nik', 'tgl_lahir', 'nama_depan', 'nama_belakang', 'alamat', 'alamat_fb', 'email',
        'password', 'mobile', 'no_rek', 'nama_bank', 'zoning', 'k_referal', 'status', 'tipe_akun', 'poin', 'tanggal_join'
    ];
}

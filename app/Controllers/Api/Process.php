<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class Process extends BaseController
{
    function waktu()
    {
        date_default_timezone_set('Asia/Jakarta');
        $dt = date('Y-m-d H:i:s');
        return $dt;
    }

    public function getmodelproduk()
    {
        $db = \Config\Database::connect();

        $query = $db->query("SELECT * FROM model_produk WHERE status = '1'");
        $rowsLimit = $query->getResult();
        $json_response = [];
        $message = "";
        $status = "";

        if ($rowsLimit) {
            $json_response = $rowsLimit;
            $status = "202";
            $message = "Data found";
        } else {
            $status = "303";
            $message = "Data not found";
        }
        return json_encode([
            "status_code" => $status,
            "message" => $message,
            "data" => $json_response,
        ]);
    }

    public function getinventory()
    {
        $db = \Config\Database::connect();

        $query = $db->query("SELECT * FROM inventory WHERE status = '1'");
        $rowsLimit = $query->getResult();
        $json_response = [];
        $message = "";
        $status = "";

        if ($rowsLimit) {
            $json_response = $rowsLimit;
            $status = "202";
            $message = "Data found";
        } else {
            $status = "303";
            $message = "Data not found";
        }
        return json_encode([
            "status_code" => $status,
            "message" => $message,
            "data" => $json_response,
        ]);
    }

    public function getwarehouse()
    {
        $db = \Config\Database::connect();

        $query = $db->query("SELECT * FROM warehouse WHERE status = '1'");
        $rowsLimit = $query->getResult();
        $json_response = [];
        $message = "";
        $status = "";

        if ($rowsLimit) {
            $json_response = $rowsLimit;
            $status = "202";
            $message = "Data found";
        } else {
            $status = "303";
            $message = "Data not found";
        }
        return json_encode([
            "status_code" => $status,
            "message" => $message,
            "data" => $json_response,
        ]);
    }

    public function getuser()
    {
        $db = \Config\Database::connect();

        $query = $db->query("SELECT * FROM user WHERE status = '1'");
        $rowsLimit = $query->getResult();
        $json_response = [];
        $message = "";
        $status = "";

        if ($rowsLimit) {
            $json_response = $rowsLimit;
            $status = "202";
            $message = "Data found";
        } else {
            $status = "303";
            $message = "Data not found";
        }
        return json_encode([
            "status_code" => $status,
            "message" => $message,
            "data" => $json_response,
        ]);
    }

    public function scanin()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $sn = $this->request->getvar('sn');
            // $nama = $this->request->getvar('nama');
            $status = $this->request->getvar('status');
            $date_in = $this->request->getvar('date_in');
            $user_in = $this->request->getvar('user');
            $tahun = $this->request->getvar('tahun');
            $bulan = $this->request->getvar('bulan');
            $no_urut = $this->request->getvar('no_urut');
            $kategori = $this->request->getvar('kategori');
            $model = $this->request->getvar('model');
            $cabang = $this->request->getvar('cabang');
            $data = array();
            array_push($data, $sn, $status, $date_in, $user_in, $tahun, $bulan, $no_urut, $kategori, $model, $cabang);

            $query = $db->query("SELECT id FROM inventory WHERE sn ='$sn' AND status = '1'");
            $rows = $query->getResult();

            if ($sn == '' || $sn == null) {
                throw new \Exception('Serial number tidak ditemukan !');
            }

            if ($rows) {
                throw new \Exception('Barcode sudah discan');
            }

            $db->query("INSERT INTO inventory (sn,status,date_in,user_in,tahun,bulan,no_urut,kategori,model,cabang) 
            VALUES ('$sn','$status',now(),'$user_in','$tahun','$bulan','$no_urut','$kategori','$model','$cabang')");

            $db->transCommit();
            echo json_encode([
                "status_code" => '202',
                "message" => "Berhasil scan in",
                "data" => $data,
            ]);
        } catch (\Exception $th) {
            $db->transRollback();
            echo json_encode([
                "status_code" => '303',
                "message" => $th->getMessage(),
                "data" => $data,
            ]);
        }
    }

    public function scanout()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $sn = $this->request->getvar('sn');
            $user_out = $this->request->getvar('user');
            $status = $this->request->getvar('status');
            $customer = $this->request->getvar('customer');
            $penitipan = $this->request->getvar('penitipan');
            $cabang = $this->request->getvar('cabang');
            $progress_id = $this->request->getvar('progress_id');

            $query1 = $db->query("SELECT id FROM inventory WHERE sn ='$sn' AND status = '1' AND date_out is not null");
            $rows1 = $query1->getResult();

            if ($rows1) {
                throw new \Exception('Sudah scan out');
            }

            if ($penitipan == 1) {
                $query2 = $db->query("SELECT * FROM inventory where sn ='$sn' AND status = '1'");
                $check = $query2->getRow();

                $db->query("INSERT INTO penitipan (sn,status,date_in,user_in,tahun,bulan,no_urut,kategori,model,customer,cabang,cabang_move) 
                VALUES ('$sn','$status',now(),'$user_out','$check->tahun','$check->bulan','$check->no_urut','$check->kategori','$check->model','$customer','$check->cabang','$cabang')");
            }

            if ($status == 2) {
                $tahun = $this->request->getvar('tahun');
                $bulan = $this->request->getvar('bulan');
                $no_urut = $this->request->getvar('no_urut');
                $kategori = $this->request->getvar('kategori');
                $model = $this->request->getvar('model');

                $query1 = $db->query("SELECT id FROM inventory WHERE sn ='$sn' AND status = '1' AND date_out is not null");
                $rows1 = $query1->getResult();
                if ($rows1) {
                    throw new \Exception('Sudah scan out');
                }

                $db->query("INSERT INTO inventory (sn,status,date_in,date_out,user_in,user_out,tahun,bulan,no_urut,kategori,model,customer,cabang,progress_id) 
            VALUES ('$sn','$status',now(),now(),'$user_out','$user_out','$tahun','$bulan','$no_urut','$kategori','$model','$customer','$cabang','$progress_id')");
            } else {
                $query = $db->query("SELECT id FROM inventory WHERE sn ='$sn' AND status = '1'");
                $rows = $query->getResult();
                if ($rows) {
                    $db->query("UPDATE inventory SET date_out = now(), user_out = '$user_out', status = '$status' , customer = '$customer', progress_id = '$progress_id' WHERE sn = '$sn'");
                } else {
                    throw new \Exception('Data tidak ada');
                }

                if ($sn == '' || $sn == null) {
                    throw new \Exception('Serial number tidak ditemukan');
                }
            }

            $db->transCommit();
            echo json_encode([
                "status_code" => '202',
                "message" => "Berhasil scan out",
                "data" => null,
            ]);
        } catch (\Exception $th) {
            $db->transRollback();
            echo json_encode([
                "status_code" => '303',
                "message" => $th->getMessage(),
                "data" => null,
            ]);
        }
    }

    public function move()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $sn = $this->request->getvar('sn');
            $user = $this->request->getvar('user');
            $status = $this->request->getvar('status');
            $cabang = $this->request->getvar('cabang');

            $query1 = $db->query("SELECT id FROM inventory WHERE sn ='$sn' AND status = '1' AND cabang = '$cabang'");
            $rows1 = $query1->getResult();

            if ($rows1) {
                throw new \Exception('Tidak boleh pindah pada warehouse yang sama');
            }

            $query = $db->query("SELECT id,cabang FROM inventory WHERE sn ='$sn' AND status = '1'");
            $rows = $query->getRow();
            if ($rows) {
                $db->query("INSERT INTO pindah_produk (sn,date_move,cabang_old,cabang_move,user_move) 
                VALUES ('$sn',now(),'$rows->cabang','$cabang','$user')");
                $db->query("UPDATE inventory SET cabang = '$cabang', status = '$status' WHERE sn = '$sn'");
            } else {
                throw new \Exception('Data tidak ada');
            }
            if ($sn == '' || $sn == null) {
                throw new \Exception('Serial number tidak ditemukan');
            }

            $db->transCommit();
            echo json_encode([
                "status_code" => '202',
                "message" => "Berhasil Move",
                "data" => null,
            ]);
        } catch (\Exception $th) {
            $db->transRollback();
            echo json_encode([
                "status_code" => '303',
                "message" => $th->getMessage(),
                "data" => null,
            ]);
        }
    }

    public function penitipanout()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $sn = $this->request->getvar('sn');
            $user_out = $this->request->getvar('user');
            $status = $this->request->getvar('status');

            $query1 = $db->query("SELECT id FROM penitipan WHERE sn ='$sn' AND status = '1' AND date_out is not null");
            $rows1 = $query1->getResult();

            if ($rows1) {
                throw new \Exception('Sudah scan out penitipan');
            }

            $query = $db->query("SELECT id FROM penitipan WHERE sn ='$sn' AND status = '1'");
            $rows = $query->getResult();
            if ($rows) {
                $db->query("UPDATE penitipan SET date_out = now(), user_out = '$user_out', status = '$status' WHERE sn = '$sn'");
            } else {
                throw new \Exception('Data tidak ada');
            }

            if ($sn == '' || $sn == null) {
                throw new \Exception('Serial number tidak ditemukan');
            }

            $db->transCommit();
            echo json_encode([
                "status_code" => '202',
                "message" => "Berhasil scan out penitipan",
                "data" => null,
            ]);
        } catch (\Exception $th) {
            $db->transRollback();
            echo json_encode([
                "status_code" => '303',
                "message" => $th->getMessage(),
                "data" => null,
            ]);
        }
    }
    public function getpenitipan()
    {
        $db = \Config\Database::connect();

        $query = $db->query("SELECT * FROM penitipan WHERE status = '1'");
        $rowsLimit = $query->getResult();
        $json_response = [];
        $message = "";
        $status = "";

        if ($rowsLimit) {
            $json_response = $rowsLimit;
            $status = "202";
            $message = "Data found";
        } else {
            $status = "303";
            $message = "Data not found";
        }
        return json_encode([
            "status_code" => $status,
            "message" => $message,
            "data" => $json_response,
        ]);
    }
    public function getquantity()
    {
        $db = \Config\Database::connect();

        $userId = $this->request->getGet('userId');

        $progressQuery = $db->query("SELECT 
            id,
            quantity
        FROM 
            quantity_progress
        WHERE 
            status = 'Active'
            AND user_id = ?
            AND DATE(creation_date) = CURDATE()
        LIMIT 1", [$userId]);

        $progressData = $progressQuery->getRow();

        $inventoryQuery = $db->query("SELECT 
            i.kategori,
            COUNT(*) AS total
        FROM 
            inventory i
        JOIN 
            quantity_progress p ON i.progress_id = p.id
        WHERE 
            p.status = 'Active'
            AND p.user_id = ?
            AND DATE(p.creation_date) = CURDATE()
        GROUP BY 
            i.kategori", [$userId]);

        $rowsLimit = $inventoryQuery->getResult();
        $json_response = [];
        $message = "";
        $status = "";
        $quantity = "";
        $progressId = "";

        if ($progressData) {
            $json_response = $rowsLimit ?: [];
            $status = "200";
            $message = $rowsLimit ? "Data found" : "Progress exists but no inventory yet";
            $quantity = $progressData->quantity;
            $progressId = $progressData->id;
        } else {
            $status = "400";
            $message = "No active progress found for today";
        }

        return json_encode([
            "status_code" => $status,
            "message" => $message,
            "quantity" => $quantity,
            "id" => $progressId,
            "data" => $json_response,
        ]);
    }

    public function finishscanout()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $id = $this->request->getPost('id');

            if (empty($id)) {
                throw new \Exception('ID tidak boleh kosong');
            }

            $query = $db->query("SELECT id, status FROM quantity_progress WHERE id = ? AND status = 'Active'", [$id]);
            $check = $query->getRow();

            if (!$check) {
                throw new \Exception('Data tidak ditemukan atau sudah Non-Active');
            }

            $db->query("UPDATE quantity_progress SET status = 'Non-Active' WHERE id = ? AND status = 'Active'", [$id]);

            $db->transCommit();
            echo json_encode([
                "status_code" => '200',
                "message" => "Berhasil Finish Scan Out",
                "data" => [
                    "id" => $id,
                    "previous_status" => "Active",
                    "current_status" => "Non-Active"
                ],
            ]);
        } catch (\Exception $th) {
            $db->transRollback();
            echo json_encode([
                "status_code" => '400',
                "message" => $th->getMessage(),
                "data" => null,
            ]);
        }
    }

    public function createquantity()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $quantity = $this->request->getvar('quantity');
            $warehouse_id = $this->request->getvar('warehouse_id');
            $user_id = $this->request->getvar('user_id');
            $username = $this->request->getvar('username');

            $data = [
                'quantity'      => $quantity,
                'progress'      => 0,
                'warehouse_id'  => $warehouse_id,
                'user_id'       => $user_id,
                'username'      => $username,
                'status'        => 'Active'
            ];

            $db->table('quantity_progress')->insert($data);
            $insertId = $db->insertID();   // <= ID auto-increment yang baru


            $db->transCommit();
            echo json_encode([
                "status_code" => '202',
                "message" => "Berhasil Create Quantity",
                "data" => ["progress_id" => $insertId],
            ]);
        } catch (\Exception $th) {
            $db->transRollback();
            echo json_encode([
                "status_code" => '303',
                "message" => $th->getMessage(),
                "data" => null,
            ]);
        }
    }
}

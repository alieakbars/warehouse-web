<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/invoice.css') ?>">
</head>

<?php
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}
?>

<body>
    <div id="page-wrap">
        <textarea id="header">INVOICE</textarea>
        <div id="identity">
            <div id="logo">
                <img id="image" style="height:50px" src="<?= base_url('assets/img/hedglow.png') ?>" alt="logo" />
            </div>
        </div>
        <div style="clear:both"></div>
        <div id="customer">
            <textarea id="customer-title">Invoice Pembelian</textarea>
            <table id="meta">
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td>
                        <p><?= $order->kode_transaksi ?></p>
                    </td>
                </tr>
                <tr>

                    <td class="meta-head">Waktu</td>
                    <td>
                        <p id="date"><?= $order->tanggal ?></p>
                    </td>
                </tr>

            </table>
        </div>

        <table id="items">
            <tr class="item-row" style="text-align: left;">
                <td>Alamat tujuan : <?= $order->tujuan ?></td>
                <td>No Handphone : <?= $order->mobile ?></td>
            </tr>
        </table>
        <table id="items">

            <tr>
                <th>Item</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Berat</th>
                <th>Poin</th>
            </tr>
            <?php foreach ($orders as $row) { ?>
                <tr class="item-row" style="text-align: center;">
                    <td class="description">
                        <p><?php echo $row->title ?></p>
                    </td>
                    <td class="item-name">
                        <p><?php echo rupiah($row->harga) ?></p>
                    </td>
                    <td>
                        <p class="cost"><?php echo $row->qty ?></p>
                    </td>
                    <td>
                        <p class="qty"><?php echo $row->berat ?> gram</p>
                    </td>
                    <td><span class="price"><?= @$row->poin ? $row->poin : 0 ?>
                        </span></td>
                </tr>
            <?php    } ?>

            <tr>
                <td colspan="2" class="blank"> </td>
                <td colspan="2" class="total-line">Total Harga :</td>
                <td class="total-value">
                    <div id="total"><?= rupiah($order->total_harga) ?></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="blank"> </td>
                <td colspan="2" class="total-line">Estimasi Ongkir :</td>

                <td class="total-value">
                    <p id="paid"><?= rupiah($order->ongkir) ?></p>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="blank"> </td>
                <td colspan="2" class="total-line">Total Tagihan :</td>

                <td class="total-value">
                    <p id="paid"><?= rupiah($order->total_harga + $order->ongkir) ?></p>
                </td>
            </tr>
        </table>
        <br><br><br><br>
        <div id="terms">
            <h5>HedGlow</h5>
            <p>Tanjung Morawa, Deli Serdang</p>
        </div>
    </div>
</body>

</html>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="<?= base_url('assets/js/invoice.js') ?>"></script>
<script>
    // window.print();
</script>
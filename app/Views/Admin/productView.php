<?= $this->extend('Admin/layout/Admin_layout') ?>

<?= $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $title ?>
            <button id="addProduct" class="m-0 btn btn-sm btn-primary" style="float: right;">Tambah Produk</button>
        </h6>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Gambar</th>
                        <th>Jumlah</th>
                        <th>Kategori</th>
                        <th>Harga Pengunjung</th>
                        <th>Harga Distributor</th>
                        <th>Harga Reseller</th>
                        <th>Harga Agen</th>
                        <th>Poin</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add-->
<div class="modal fade bd-example-modal-lg" data-backdrop="" id="formModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Detail Pesanan</h6>
                <button type="button" class="close btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update-product-form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text" id="product_title" name="product_name" class="form-control" placeholder="Masukkan Nama Produk" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Kategori</label>
                                <select id="category" class="form-control" name="category_id" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($kategori as $key) { ?>
                                        <option value="<?= $key['cat_id'] ?>"><?= $key['cat_title'] ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Stok Produk</label>
                                <input type="number" id="qty" name="product_qty" min="1" class="form-control" placeholder="Masukkan Stok Produk" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Harga Pengunjung</label>
                                <input type="number" id="price_guest" name="harga_guest" class="form-control" placeholder="Masukkan Harga Produk">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Harga Distributor</label>
                                <input type="number" id="price_distributor" name="harga_distributor" class="form-control" placeholder="Masukkan Harga Promo">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Harga Reseller</label>
                                <input type="number" id="price_reseller" name="harga_reseller" class="form-control" placeholder="Masukkan Harga Promo">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Harga Agen</label>
                                <input type="number" id="price_agen" name="harga_agen" class="form-control" placeholder="Masukkan Harga Promo">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Poin</label>
                                <input type="number" id="poin" name="poin" class="form-control" placeholder="Masukkan Poin">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Berat (Gram)</label>
                                <input type="number" id="weight" name="product_weight" step="0.01" class="form-control" placeholder="Masukkan Berat Barang (Gram)">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Merek</label>
                                <input type="text" id="brand" name="merek" class="form-control" placeholder="Masukkan Nama Merek">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Komposisi</label>
                                <input type="text" id="composition" name="komposisi" class="form-control" placeholder="Komposisi">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Formulasi</label>
                                <input type="text" id="formulasi" name="formulasi" class="form-control" placeholder="Jenis Bahan">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Jenis Kulit</label>
                                <input type="text" id="skin" name="jenis_kulit" class="form-control" placeholder="Jenis Kulit">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Manfaat Perawatan</label>
                                <input type="text" id="benefit" name="manfaat" class="form-control" placeholder="Masukkan Perawatan">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Masa Penyimpanan</label>
                                <input type="number" id="storage_period" name="masa_penyimpanan" class="form-control" placeholder="Lama Penyimpanan (Bulan)">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Volume</label>
                                <input type="number" id="volume" name="volume" class="form-control" placeholder="Volume">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tanggal Kadarluarsa</label>
                                <input type="date" id="expired" name="expired" class="form-control" placeholder="Expired">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Ukuran Produk</label>
                                <input type="number" id="product_size" name="ukuran_produk" class="form-control" placeholder="Volume Produk">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Ukuran Per Produk</label>
                                <input type="number" id="unit_size" name="ukuran_satuan" class="form-control" placeholder="Volume Per Produk">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Jumlah Produk Dalam Kemasan</label>
                                <input type="number" id="pack" name="kemasan" class="form-control" placeholder="Jumlah Dalam Kemasan">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select id="status" class="form-control" name="status">
                                    <option value="">Select Status</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Dikirim Dari</label>
                                <textarea class="form-control" id="origin" name="asal" placeholder="Asal"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Deskripsi Produk</label>
                                <textarea class="form-control" id="desc" name="product_desc" placeholder="Masukkan Deskripsi Produk"></textarea>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Foto Produk 1 <small>(format: jpg, jpeg, png)</small></label>
                                <input type="file" id="res1" name="image1" class="form-control">
                                <div id="image1"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Foto Produk 2 <small>(format: jpg, jpeg, png)</small></label>
                                <input type="file" id="res2" name="image2" class="form-control">
                                <div id="image2"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Foto Produk 3 <small>(format: jpg, jpeg, png)</small></label>
                                <input type="file" id="res3" name="image3" class="form-control">
                                <div id="image3"></div>
                            </div>
                        </div>
                        <input type="hidden" id="gambar1" name="gambar1" class="form-control">
                        <input type="hidden" id="gambar2" name="gambar2" class="form-control">
                        <input type="hidden" id="gambar3" name="gambar3" class="form-control">
                        <input type="hidden" id="kode" name="kode" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="buttons" class="btn btn-primary">Update Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    // function formatUang(angka) {
    //     var number_string = angka.replace(/[^,\d]/g, '').toString(),
    //         split = number_string.split(','),
    //         sisa = split[0].length % 3,
    //         rupiah = split[0].substr(0, sisa),
    //         ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    //     if (ribuan) {
    //         separator = sisa ? '.' : '';
    //         rupiah += separator + ribuan.join('.');
    //     }

    //     rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    //     return rupiah;
    // }

    // function setUang() {
    //     $("#price_guest").keyup(function() {
    //         let price = $("#price_guest").val();
    //         $("#price_guest").val(formatUang(price));
    //     });
    // }

    function getProduct() {
        $('#dataTable').DataTable({
            "order": [],
            "bSort": false,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "ajax": {
                "url": "<?= base_url(); ?>/Admin/productController/getProduct", // ajax source
                "type": "post",
                "data": function(d) {
                    d.period1 = $('#period1').val()
                    d.period2 = $('#period2').val()
                    d.card_type_filter = $('#card_type_filter').val()
                    d.batch_status_filter = $('#batch_status_filter').val()
                    return d
                }
            },
            "columns": [{
                    "data": "product_title"
                },
                {
                    "data": "gambar1",
                    render: function(data, type, row) {
                        let sts = `<img src="<?= base_url(); ?>/assets/img_prod/${data}" style="width:50px; height:50px;">`
                        return sts
                    }
                },
                {
                    "data": "qty"
                },
                {
                    "data": "cat_title"
                },
                {
                    "data": "price_guest",
                    "render": $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
                },
                {
                    "data": "price_distributor",
                    "render": $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
                },
                {
                    "data": "price_reseller",
                    "render": $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
                },
                {
                    "data": "price_agen",
                    "render": $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
                },
                {
                    "data": "poin"
                },
                {
                    render: function(data, type, row) {
                        let sts = `<div class="btn-group" role="group" aria-label="Basic example">
                        <span id="edit" class="btn btn-info btn-circle btn-sm">
                        <i class='fas fa-pencil-alt'></i>
                                    </span>`
                        action = `<span id="delete" class="btn btn-danger btn-circle btn-sm">
                        <i class='fa fa-trash'></i>
                                    </span>`
                        return sts + '\xa0\xa0' + action + '</div>'
                    }
                },
            ],
            "drawCallback": function(settings) {
                // Here the response
                cardBatch = settings.json.recordsFiltered;
            },


        });
    }

    function resetProduct() {
        $("#status").val('');

        $('#kode').val('')
        $('#product_title').val('')
        $('#qty').val('')
        $('#price_guest').val('')
        $('#price_distributor').val('')

        $('#price_reseller').val('')
        $('#price_agen').val('')
        $('#poin').val('')
        $('#weight').val('')
        $('#brand').val('')

        $('#composition').val('')
        $('#formulasi').val('')
        $('#skin').val('')
        $('#benefit').val('')
        $('#storage_period').val('')

        $('#volume').val('')
        $('#expired').val('')
        $('#product_size').val('')
        $('#unit_size').val('')
        $('#pack').val('')

        $('#origin').val('')
        $('#desc').val('')
        $('#image1').html('')
        $('#image2').html(``)
        $('#image3').html(``)
        $('#gambar1').val('')
        $('#gambar2').val('')
        $('#gambar3').val('')

        $('#res1').val('')
        $('#res2').val('')
        $('#res3').val('')
    }

    function loadAdd() {
        $("#addProduct").on("click", () => {
            $('#update-product-form').attr('act', 'add');
            $('#formModal').modal("show")
            $('#buttons').html('Save')
            $('#exampleModalLabel').html('<strong class="text-primary"><i class="fas fa-plus"></i>Tambah Produk</strong>')
            resetProduct()
        })
    }

    function loadedit() {
        $('#dataTable tbody').on('click', '#edit', function() {
            resetProduct()
            $('#update-product-form').attr('act', 'edit');
            $('#formModal').modal("show")
            $('#buttons').html('Save')
            $('#exampleModalLabel').html('<strong class="text-info"><i class="fas fa-edit"></i>Edit Produk</strong>')
            const data = $('#dataTable').DataTable().row($(this).parents('tr')).data();

            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>/Admin/productController/getCategory',
            }).then(function(dt) {
                var res = JSON.parse(dt);
                console.log(dt)
                let option = `<option value="">Silahkan Pilih</option>`;

                res.map((e) => {
                    option += `<option ${e.cat_id == data.product_cat ? `selected=selected`:''} value="${e.cat_id}" >${e.cat_title}</option>`;
                });
                $("#category").html(option);
            });

            $("#status").val(data.status);

            $('#kode').val(data.product_id)
            $('#product_title').val(data.product_title)
            $('#qty').val(data.qty)
            $('#price_guest').val(data.price_guest)
            $('#price_distributor').val(data.price_distributor)

            $('#price_reseller').val(data.price_reseller)
            $('#price_agen').val(data.price_agen)
            $('#poin').val(data.poin)
            $('#weight').val(data.product_weight)
            $('#brand').val(data.brand)

            $('#composition').val(data.composition)
            $('#formulasi').val(data.formulasi)
            $('#skin').val(data.skin_type)
            $('#benefit').val(data.benefit)
            $('#storage_period').val(data.storage_period)

            $('#volume').val(data.volume)
            $('#expired').val(data.expired)
            $('#product_size').val(data.product_size)
            $('#unit_size').val(data.unit_size)
            $('#pack').val(data.pack)

            $('#origin').val(data.origin)
            $('#desc').val(data.product_desc)
            $('#image1').html(`<img src="<?= base_url(); ?>/assets/img_prod/${data.gambar1}" class="img-fluid" width="200">`)
            $('#image2').html(`<img src="<?= base_url(); ?>/assets/img_prod/${data.gambar2}" class="img-fluid" width="200">`)
            $('#image3').html(`<img src="<?= base_url(); ?>/assets/img_prod/${data.gambar3}" class="img-fluid" width="200">`)
            $('#gambar1').val(data.gambar1)
            $('#gambar2').val(data.gambar2)
            $('#gambar3').val(data.gambar3)
        });
    }

    function condition() {
        $("#update-product-form").on("submit", function(e) {
            e.preventDefault()
            if ($('#update-product-form').attr('act') == 'add') {
                addProduct()
            } else {
                updateProduct();
            }
        })
    }


    function deleteProduct() {
        $('#dataTable tbody').on('click', '#delete', function() {

            const data = $('#dataTable').DataTable().row($(this).parents('tr')).data();
            // return console.log(data);
            Swal.fire({
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger mr-2',
                    cancelButton: 'btn btn-secondary'
                },
                reverseButtons: false,
                title: `Apakah kamu yakin ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    const dataDelete = {
                        "pid": data.product_id,
                        "gambar1": data.gambar1,
                        "gambar2": data.gambar2,
                        "gambar3": data.gambar3
                    };
                    $.ajax({
                        url: '<?= base_url(); ?>/Admin/productController/deleteProduct',
                        type: 'post',
                        data: dataDelete,
                        success: (data) => {
                            var res = JSON.parse(data);
                            console.log(res);
                            if (res.status_code == '01') {
                                Swal.fire(
                                    'Success!',
                                    res.message,
                                    'success'
                                )
                                $('#dataTable').DataTable().ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    res.message,
                                    'error'
                                )
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Swal.fire(
                                'Failed!',
                                textStatus + ' ' + XMLHttpRequest + ' ' + errorThrown,
                                'error'
                            )
                        }
                    })
                }
            })
        })
    }

    function addProduct() {
        let form_data = new FormData($("#update-product-form")[0]);

        if (!$('#product_title').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Nama Produk tidak boleh Kosong'
        });
        if (!$("#category").val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Kategori tidak boleh Kosong'
        });
        if (!$('#qty').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Stok tidak boleh Kosong'
        });
        if (!$('#price_guest').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Harga Pengunjung harus diisi'
        });
        if (!$('#price_distributor').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Harga distributor harus diisi'
        });

        if (!$('#price_reseller').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Harga Pengunjung harus diisi'
        });
        if (!$('#price_agen').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Harga agen harus diisi'
        });
        if (!$('#poin').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Poin tidak boleh Kosong'
        });
        if (!$('#weight').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Berat tidak boleh Kosong'
        });
        if (!$('#brand').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Merek tidak boleh Kosong'
        });

        if (!$('#composition').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Komposisi tidak boleh Kosong'
        });
        if (!$('#formulasi').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Formulasi tidak boleh Kosong'
        });
        if (!$('#skin').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Jenis kulit tidak boleh Kosong'
        });
        if (!$('#benefit').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Manfaat tidak boleh Kosong'
        });
        if (!$('#storage_period').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Masa penyimpanan tidak boleh Kosong'
        });

        if (!$('#volume').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Volume tidak boleh Kosong'
        });
        if (!$('#expired').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Kadarluarsa tidak boleh Kosong'
        });
        if (!$('#product_size').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Ukuran produk tidak boleh Kosong'
        });
        if (!$('#unit_size').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Ukuran per produk tidak boleh Kosong'
        });
        if (!$('#pack').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Jumlah produk kemasan tidak boleh Kosong'
        });
        if (!$('#status').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Status harus dipilih'
        });
        if (!$('#origin').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Asal tidak boleh Kosong'
        });
        if (!$('#desc').val('')) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Deskripsi tidak boleh Kosong'
        });

        $.ajax({
            url: '<?= base_url(); ?>/Admin/productController/addProduct',
            type: 'POST',
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: () => {
                swal.fire({
                    icon: "info",
                    title: "Processing ...",
                    buttons: false,
                    closeOnClickOutside: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
            },
            success: (data) => {
                var res = JSON.parse(data);
                console.log(res);
                if (res.status_code == "01") {
                    Swal.fire(
                        'Success!',
                        res.message,
                        'success'
                    )
                    $('#formModal').modal('hide');
                    $('#dataTable').DataTable().ajax.reload();
                } else {
                    Swal.fire(
                        'Failed!',
                        res.message,
                        'error'
                    )
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire(
                    'Failed!',
                    'Something went wrong',
                    'error'
                )
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
            }
        })
    }

    function updateProduct() {
        let form_data = new FormData($("#update-product-form")[0]);

        $.ajax({
            url: '<?= base_url(); ?>/Admin/productController/updateProduct',
            type: 'POST',
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: () => {
                swal.fire({
                    icon: "info",
                    title: "Processing ...",
                    buttons: false,
                    closeOnClickOutside: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
            },
            success: (data) => {
                var res = JSON.parse(data);
                console.log(res);
                if (res.status_code == "01") {
                    Swal.fire(
                        'Success!',
                        res.message,
                        'success'
                    )
                    $('#formModal').modal('hide');
                    $('#dataTable').DataTable().ajax.reload();
                } else {
                    Swal.fire(
                        'Failed!',
                        res.message,
                        'error'
                    )
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire(
                    'Failed!',
                    'Something went wrong',
                    'error'
                )
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
            }
        })
    }

    $(document).ready(function() {
        getProduct();
        deleteProduct();
        loadedit();
        loadAdd();
        condition();
        // setUang();
    });
</script>

<?= $this->endSection() ?>
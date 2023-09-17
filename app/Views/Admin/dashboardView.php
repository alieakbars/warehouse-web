<?= $this->extend('Admin/layout/Admin_layout') ?>

<?= $this->section('content') ?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Scan In (Hari Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $inharian ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Scan Out (Hari ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $outharian ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Scan In (Bulan Ini)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $inbulanan ?></div>
                            <!-- <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Scan Out (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $outbulanan ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <!-- <div class="row"> -->

    <!-- Area Chart -->
    <!-- <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4"> -->
    <!-- Card Header - Dropdown -->
    <!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div> -->
    <!-- Card Body -->
    <!-- <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div> -->

    <!-- Pie Chart -->
    <!-- <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4"> -->
    <!-- Card Header - Dropdown -->
    <!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div> -->
    <!-- Card Body -->
    <!-- <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Direct
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Social
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Referral
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

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
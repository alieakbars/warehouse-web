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
        <div class="col-sm-12">

            <div class="card shadow mb-4">
                <div class="card-header d-flex align-items-center">
                    <div class="input-group input-group-sm col-sm-2">
                        <label class="mr-2">Start</label>
                        <input class="form-control form-control-sm" type="text" id="period1" name="period1" value="" />
                    </div>
                    <div class="input-group input-group-sm col-sm-2 ml-1">
                        <label class="mr-2">End</label>
                        <input class="form-control form-control-sm" type="text" id="period2" name="period2" value="" />
                    </div>
                    <div class="input-group input-group-sm col-sm-3 ml-1">
                        <label class="mr-2">Warehouse</label>
                        <select id="cabang" class="form-control" name="cabang">
                            <option value="">Select Akses</option>
                            <?php foreach ($warehouse as $key) { ?>
                                <option value="<?= $key->id ?>"><?= $key->nama ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="input-group input-group-sm col-sm-2 ml-1">
                        <button class="btn btn-sm btn-primary" id="filter_data">Filter</button>
                    </div>
                    <div class="input-group input-group-sm col-sm-2 ml-1">
                        <span class="btn btn-sm btn-outline-success" onClick="getExcel()">
                            <i class=" fas fa-file-export"></i>
                            Export Excel
                        </span>
                        <div class="input-group input-group-sm col-sm-2">
                            <a href="<?php $_SERVER['PHP_SELF']; ?>" class="m-0 btn btn-sm btn-primary">Refresh</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Scan In</th>
                                    <th>User In</th>
                                    <th>Tahun</th>
                                    <th>Bulan</th>
                                    <th>Urutan</th>
                                    <th>Kategori</th>
                                    <th>Model</th>
                                    <th>Nama barang</th>
                                    <th>Warehouse</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    let flatDateOption = {
        dateFormat: "Y-m-d"
    };
    let flatTimeOption = {
        noCalendar: true,
        enableTime: true,
        time_24hr: true,
        dateFormat: "H:i:s",
        enableSeconds: true
    };

    let date = new Date();
    let dateNow = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`;
    let nextDate = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate() + 1}`;

    const loadDatepicker = () => {
        $("#period2").flatpickr({
            ...flatDateOption,
            defaultDate: dateNow,
            maxDate: dateNow,
            minDate: dateNow
        });

        $("#period1").flatpickr({
            ...flatDateOption,
            defaultDate: dateNow,
            maxDate: dateNow,
            onChange: function(selectedDates, dateStr, instance) {
                let datePicker = new Date(dateStr);
                let nextDatePicker = `${datePicker.getFullYear()}-${datePicker.getMonth() + 1}-${datePicker.getDate() }`;
                $("#period2").flatpickr({
                    ...flatDateOption,
                    defaultDate: dateNow,
                    minDate: nextDatePicker,
                    maxDate: dateNow
                });
            }
        });
    }

    const loadFilter = () => {
        $('#filter_data').click(function() {
            loadDataIn()
        });
    };

    const getExcel = () => {
        document.location.href = '<?= base_url(); ?>/transaksiController/cetakexcelin?period1=' + $('#period1').val() +
            '&period2=' + $('#period2').val() + '&cabang=' + $('#cabang').val()
    };

    function loadDataIn() {
        $('#dataTable').DataTable({
            "order": [],
            "bSort": false,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "pagingType": "full_numbers",
            "ajax": {
                "url": "<?= base_url(); ?>/transaksiController/getbarangin", // ajax source
                "type": "post",
                "data": function(d) {
                    d.period1 = $('#period1').val()
                    d.period2 = $('#period2').val()
                    d.cabang = $('#cabang').val()
                    return d
                }
            },
            "columns": [{
                    "data": "sn"
                },
                {
                    "data": "date_in"
                },
                {
                    "data": "user_in"
                },
                {
                    "data": "tahun"
                },
                {
                    "data": "bulan"
                },
                {
                    "data": "no_urut"
                },
                {
                    "data": "kategori"
                },
                {
                    "data": "model"
                },
                {
                    "data": "nama"
                },
                {
                    "data": "nama_warehouse"
                }
            ],

            "drawCallback": function(settings) {
                // Here the response
                cardBatch = settings.json.recordsFiltered;
            },


        });
    }


    function loadDetailOrder() {
        $('#dataTable tbody').on('click', '#ordermember', function() {
            // reset()
            $('#formModal').modal("show")
            $('#exampleModalLabel').html('<strong class="text-info"><i class="fas fa-edit"></i>Detail Pesanan</strong>')
            const data = $('#dataTable').DataTable().row($(this).parents('tr')).data();
            $('#kodeTrans').val(data.kode_transaksi)
            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>/Admin/transaksiController/getorderMemberDetail',
                data: {
                    'kode_transaksi': data.kode_transaksi
                },
            }).then(function(data) {
                var res = JSON.parse(data);
                let option;
                res.map((e) => {
                    option += `<tr>
                            <td>${e.title}</td>
                            <td>${e.qty}</td>
                            <td>Rp. ${e.harga}</td>
                            <td>${e.berat}</td>
                            <td>${e.poin}</td>
                            </tr>`;
                });
                $("#detailOrder").html(option);
                // $("#card_version_filter").html(optionfilter);
            });
        });
    }

    function showBuktiTf() {
        $('#dataTable tbody').on('click', '#showBukti', function() {
            // reset()
            $('#formModalBuktiTF').modal("show")
            $('#exampleModalLabelBuktiTF').html('<strong class="text-info"><i class="fas fa-edit"></i>Bukti Transfer</strong>')
            const data = $('#dataTable').DataTable().row($(this).parents('tr')).data();
            $('#previewBukti').html(`<img class="img-fluid" src="<?= base_url(); ?>/assets/bukti_tf/${data.bukti_tf}" />`)
        });
    }

    function cancelOrder() {
        $('#dataTable tbody').on('click', '#cancelOrder', function() {

            const data = $('#dataTable').DataTable().row($(this).parents('tr')).data();
            // return console.log(data);
            Swal.fire({
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger mr-2',
                    cancelButton: 'btn btn-secondary'
                },
                reverseButtons: false,
                title: `Apakah kamu yakin membatalkan pesanan ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    const dataDelete = {
                        "kode": data.kode_transaksi,
                        "status": 3
                    };
                    $.ajax({
                        url: '<?= base_url(); ?>/Admin/transaksiController/updateStatusOrderMember',
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

    function changeStatusOrder() {
        $('#dataTable tbody').on('click', '#updateOrder', function() {

            const data = $('#dataTable').DataTable().row($(this).parents('tr')).data();
            // return console.log(data);
            let sts
            if (data.status == 0) {
                sts = 1;
            } else if (data.status == 1) {
                sts = 2;
            }

            Swal.fire({
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger mr-2',
                    cancelButton: 'btn btn-secondary'
                },
                reverseButtons: false,
                title: `Apakah kamu yakin merubah status ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    const dataDelete = {
                        "kode": data.kode_transaksi,
                        "status": sts
                    };
                    $.ajax({
                        url: '<?= base_url(); ?>/Admin/transaksiController/updateStatusOrderMember',
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

    function modalOngkir() {
        $('#dataTable tbody').on('click', '#addOngkir', function() {
            // reset()
            $('#formModalUpload').modal("show")
            $('#staticBackdropLabelUpload').html('<strong class="text-info"><i class="fas fa-edit"></i>Add Ongkir</strong>')
            const data = $('#dataTable').DataTable().row($(this).parents('tr')).data();
            $('#kodeTransaksi').val(data.kode_transaksi)
        });
    }

    function addOngkir() {
        $("#form_addongkir").on("submit", function(e) {
            e.preventDefault()
            let metode = $("#formFileSm").val();
            if (!metode)
                return Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan !',
                    text: 'Tidak boleh Kosong'
                });

            let form_data = new FormData($("#form_addongkir")[0]);

            $.ajax({
                url: '<?= base_url(); ?>/Admin/transaksiController/updateOngkirMember',
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
                        $('#formModalUpload').modal('hide');
                        $("#formFileSm").val('');
                        $('#dataTable').DataTable().ajax.reload();
                    } else {
                        Swal.fire(
                            'Failed!',
                            res.message,
                            'error'
                        )
                        $("#formFileSm").val('');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    // Swal.fire(
                    //     'Failed!',
                    //     'Something went wrong',
                    //     'error'
                    // )
                    $("#formFileSm").val('');
                    console.log("Status: " + textStatus);
                    console.log("Error: " + errorThrown);
                }
            })

        })
        // form_data.append("data", property);
    }

    $(document).ready(function() {
        loadDatepicker()
        loadDataIn();
        loadDetailOrder();
        showBuktiTf();
        changeStatusOrder();
        cancelOrder();
        addOngkir();
        modalOngkir();
        loadFilter()
    });
</script>

<?= $this->endSection() ?>
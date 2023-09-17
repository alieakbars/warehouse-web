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
                    <!-- <div class="input-group input-group-sm col-sm-2">
                        <label class="mr-2">Start</label>
                        <input class="form-control form-control-sm" type="text" id="period1" name="period1" value="" />
                    </div>
                    <div class="input-group input-group-sm col-sm-2 ml-1">
                        <label class="mr-2">End</label>
                        <input class="form-control form-control-sm" type="text" id="period2" name="period2" value="" />
                    </div>
                    <div class="input-group input-group-sm col-sm-2 ml-1">
                        <button class="btn btn-sm btn-primary" id="filter_data">Filter</button>
                    </div> -->
                    <div class="input-group input-group-sm col-sm-4 ml-1">
                        <!-- <span class="btn btn-sm btn-outline-success">
                <i class=" fas fa-file-export"></i>
                Export
            </span> -->
                        <div class="input-group input-group-sm col-sm-2 ml-1">
                            <a href="<?php $_SERVER['PHP_SELF']; ?>" class="m-0 btn btn-sm btn-primary">Refresh</a>
                        </div>
                        <div class="input-group input-group-sm col-sm-2 ml-1">
                            <button id="addProduct" class="m-0 btn btn-sm btn-primary" style="float: right;">Tambah</button>
                        </div>

                        <!-- <span class="btn btn-sm btn-outline-success" onClick="getExcel()">
                <i class="fas fa-file-export"></i>
                Export
            </span> -->

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>No Pegawai</th>
                                    <th>Status</th>
                                    <th>Hak Akses</th>
                                    <th>Created At</th>
                                    <th>Warehouse</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

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
                                            <label>Username</label>
                                            <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan Username">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" id="nama" name="nama" min="1" class="form-control" placeholder="Masukkan Nama">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>No Pegawai</label>
                                            <input type="number" id="no_pegawai" name="no_pegawai" class="form-control" placeholder="Masukkan No Pegawai">
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
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Hak Akses</label>
                                            <select id="level" class="form-control" name="level">
                                                <option value="">Select Akses</option>
                                                <option value="1">Akses Web</option>
                                                <option value="2">Akses Mobile</option>
                                                <option value="3">Akses Web & Mobile</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Cabang</label>
                                            <select id="cabang" class="form-control" name="cabang">
                                                <option value="">Select Akses</option>
                                                <?php foreach ($warehouse as $key) { ?>
                                                    <option value="<?= $key->id ?>"><?= $key->nama ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="id" name="id" class="form-control">
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

    console.log(date);

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
                let datePicker1 = new Date(dateStr);
                let nextDatePicker1 = `${datePicker1.getFullYear()}-${datePicker1.getMonth() + 1}-${datePicker1.getDate() }`;
                $("#period2").flatpickr({
                    ...flatDateOption,
                    defaultDate: dateNow,
                    minDate: nextDatePicker1,
                    maxDate: dateNow
                });
            }
        });
    }

    const loadFilter = () => {
        $('#filter_data').click(function() {
            $('#dataTable').DataTable().ajax.reload();
        });
    };

    const getExcel = () => {
        document.location.href = '<?= base_url(); ?>/transaksiController/cetakexcelmember?period1=' + $('#period1').val() +
            '&period2=' + $('#period2').val()
    };

    function loadAdd() {
        $("#addProduct").on("click", () => {
            $('#update-product-form').attr('act', 'add');
            $('#formModal').modal("show")
            $('#buttons').html('Save')
            $('#exampleModalLabel').html('<strong class="text-primary"><i class="fas fa-plus"></i>Tambah User</strong>')
            resetProduct()
        })
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

    function addProduct() {
        let form_data = new FormData($("#update-product-form")[0]);

        if (!$('#username').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Username tidak boleh Kosong'
        });
        if (!$("#password").val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Password tidak boleh Kosong'
        });
        if (!$('#nama').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Nama tidak boleh Kosong'
        });
        if (!$('#no_pegawai').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'No Pegawai tidak boleh Kosong'
        });
        if (!$('#status').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'No Pegawai tidak boleh Kosong'
        });
        if (!$('#level').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Hak akses tidak boleh Kosong'
        });


        $.ajax({
            url: '<?= base_url(); ?>/userController/adduser',
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
                if (res.status_code == "202") {
                    Swal.fire(
                        'Success!',
                        res.message,
                        'success'
                    )
                    $('#dataTable').DataTable().ajax.reload();
                    $('#formModal').modal('hide');
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

    function loadDataIn() {
        $('#dataTable').DataTable({
            "order": [],
            "processing": true,
            "serverSide": true,
            "searching": false,
            "pagingType": "full_numbers",
            "ajax": {
                "url": "<?= base_url(); ?>/userController/getuser", // ajax source
                "type": "post",
                "data": function(d) {
                    d.period1 = $('#period1').val()
                    d.period2 = $('#period2').val()
                    return d
                }
            },
            "columns": [{
                    "data": "username"
                },
                {
                    "data": "nama"
                },
                {
                    "data": "no_pegawai"
                },
                {
                    "data": "status",
                    render: function(data, type, row) {
                        let sts = data
                        let changests = ``
                        if (sts == 1) {
                            changests = `<span class="badge badge-success">Aktif</span>`;
                        } else {
                            changests = `<span class="badge badge-danger">Tidak Aktif</span>`;
                        }
                        return changests
                    }
                },
                {
                    "data": "level",
                    render: function(data, type, row) {
                        let sts = data
                        let changests = ``
                        if (sts == 1) {
                            changests = 'Akses Web';
                        } else if (sts == 2) {
                            changests = 'Akses Mobile';
                        } else {
                            changests = 'Akses Web & Mobile'
                        }
                        return changests
                    }
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "nama_warehouse"
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
            ]
        });
    }

    function resetProduct() {
        $("#nik").val('');

        $('#username').val('')
        $('#password').val('')
        $('#nama').val('')
        $('#no_pegawai').val('')
        $('#status').val('')

        $('#level').val('')

    }


    function loadedit() {
        $('#dataTable tbody').on('click', '#edit', function() {
            // resetProduct()
            $('#update-product-form').attr('act', 'edit');
            $('#formModal').modal("show")
            $('#buttons').html('Save')
            $('#exampleModalLabel').html('<strong class="text-info"><i class="fas fa-edit"></i>Edit User</strong>')
            const data = $('#dataTable').DataTable().row($(this).parents('tr')).data();

            $("#username").val(data.username);
            // $("#password").val(data.password);
            $("#nama").val(data.nama);
            $('#no_pegawai').val(data.no_pegawai)
            $('#status').val(data.status)
            $('#level').val(data.level)
            $('#id').val(data.id)
            $('#cabang').val(data.id_warehouse)

        });
    }

    function updateProduct() {
        let form_data = new FormData($("#update-product-form")[0]);

        $.ajax({
            url: '<?= base_url(); ?>/userController/updateuser',
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
                if (res.status_code == "202") {
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

    function deletemodelproduk() {
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
                        "id": data.id,
                    };
                    $.ajax({
                        url: '<?= base_url(); ?>/userController/deleteuser',
                        type: 'post',
                        data: dataDelete,
                        success: (data) => {
                            var res = JSON.parse(data);
                            console.log(res);
                            if (res.status_code == '202') {
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


    $(document).ready(function() {
        loadDataIn();
        loadDatepicker()
        loadFilter()
        condition()
        loadAdd()
        loadedit()
        deletemodelproduk()
    });
</script>

<?= $this->endSection() ?>
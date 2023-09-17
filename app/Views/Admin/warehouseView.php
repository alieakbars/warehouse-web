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
                                    <th>Date</th>
                                    <th>Nama Warehouse</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
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
                            <h6 class="modal-title" id="exampleModalLabel">Detail Warehouse</h6>
                            <button type="button" class="close btn-sm" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="update-product-form" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Nama Warehouse</label>
                                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama Warehouse">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <input type="text" id="deskripsi" name="deskripsi" class="form-control" placeholder="Masukkan Deskripsiord">
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
                                    <input type="hidden" id="id" name="id" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" id="buttons" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function loadAdd() {
        $("#addProduct").on("click", () => {
            $('#update-product-form').attr('act', 'add');
            $('#formModal').modal("show")
            $('#buttons').html('Save')
            $('#exampleModalLabel').html('<strong class="text-primary"><i class="fas fa-plus"></i>Tambah Warehouse</strong>')
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

        if (!$('#nama').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Nama Warehouse tidak boleh Kosong'
        });
        if (!$('#status').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Status tidak boleh Kosong'
        });



        $.ajax({
            url: '<?= base_url(); ?>/warehouseController/addwarehouse',
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
                "url": "<?= base_url(); ?>/warehouseController/getwarehouse", // ajax source
                "type": "post",
                "data": function(d) {
                    d.period1 = $('#period1').val()
                    d.period2 = $('#period2').val()
                    return d
                }
            },
            "columns": [{
                    "data": "created_at"
                },
                {
                    "data": "nama"
                },
                {
                    "data": "deskripsi"
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
        $("#nama").val('');
        $('#deskripsi').val('')
        $('#status').val('')
    }


    function loadedit() {
        $('#dataTable tbody').on('click', '#edit', function() {
            // resetProduct()
            $('#update-product-form').attr('act', 'edit');
            $('#formModal').modal("show")
            $('#buttons').html('Save')
            $('#exampleModalLabel').html('<strong class="text-info"><i class="fas fa-edit"></i>Edit Warehouse</strong>')
            const data = $('#dataTable').DataTable().row($(this).parents('tr')).data();

            $("#nama").val(data.nama);
            $("#id").val(data.id);
            $("#deskripsi").val(data.deskripsi);
            $('#status').val(data.status)

        });
    }

    function updateProduct() {
        let form_data = new FormData($("#update-product-form")[0]);

        $.ajax({
            url: '<?= base_url(); ?>/warehouseController/updatewarehouse',
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
                        url: '<?= base_url(); ?>/warehouseController/deletewarehouse',
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
        condition()
        loadAdd()
        loadedit()
        deletemodelproduk()
    });
</script>

<?= $this->endSection() ?>
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
                                    <th>Kategori</th>
                                    <th>Model</th>
                                    <th>Kode</th>
                                    <th>Status</th>
                                    <th>Created At</th>
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
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <input type="text" id="kategori" name="kategori" class="form-control" placeholder="Masukkan Kategori" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Model</label>
                                            <input type="text" id="model" name="model" min="1" class="form-control" placeholder="Masukkan Model" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Kode</label>
                                            <input type="number" id="kode" name="kode" class="form-control" placeholder="Masukkan Kode">
                                        </div>
                                    </div>
                                    <div class="col-6">
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
            loadDataIn()
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
            $('#exampleModalLabel').html('<strong class="text-primary"><i class="fas fa-plus"></i>Tambah Model</strong>')
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

        if (!$('#kategori').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Kategori tidak boleh Kosong'
        });
        if (!$("#model").val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Model tidak boleh Kosong'
        });
        if (!$('#kode').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Kode tidak boleh Kosong'
        });
        if (!$('#status').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Status tidak boleh Kosong'
        });


        $.ajax({
            url: '<?= base_url(); ?>/modelprodukController/addmodelproduk',
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
                "url": "<?= base_url(); ?>/modelprodukController/getmodelproduk", // ajax source
                "type": "post",
                "data": function(d) {
                    d.period1 = $('#period1').val()
                    d.period2 = $('#period2').val()
                    return d
                }
            },
            "columns": [{
                    "data": "kategori"
                },
                {
                    "data": "model"
                },
                {
                    "data": "kode"
                },
                {
                    "data": "status",
                    render: function(data, type, row) {
                        let sts = row.status
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
                    "data": "created_at"
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


    function loadedit() {
        $('#dataTable tbody').on('click', '#edit', function() {
            // resetProduct()
            $('#update-product-form').attr('act', 'edit');
            $('#formModal').modal("show")
            $('#buttons').html('Save')
            $('#exampleModalLabel').html('<strong class="text-info"><i class="fas fa-edit"></i>Edit Pengunjung</strong>')
            const data = $('#dataTable').DataTable().row($(this).parents('tr')).data();

            $("#id_pengunjung").val(data.id_pengunjung);
            $("#kategori").val(data.kategori);
            $('#model').val(data.model)
            $('#kode').val(data.kode)
            $('#status').val(data.status)
            $('#id').val(data.id)

        });
    }

    function updateProduct() {
        let form_data = new FormData($("#update-product-form")[0]);

        $.ajax({
            url: '<?= base_url(); ?>/modelProdukController/updatemodelproduk',
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
                        url: '<?= base_url(); ?>/modelProdukController/deletemodelproduk',
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
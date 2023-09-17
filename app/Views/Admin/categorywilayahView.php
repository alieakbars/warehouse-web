<?= $this->extend('Admin/layout/Admin_layout') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-sm-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?>
                    <button id="addCategory" class="m-0 btn btn-sm btn-primary" style="float: right;">Tambah Kategori</button>
                </h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title1 ?>
                    <button id="addWilayah" class="m-0 btn btn-sm btn-primary" style="float: right;">Tambah Wilayah</button>
                </h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Wilayah</th>
                                <th>Kuota</th>
                                <th>Action</th>
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
            <form id="update-category-form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Nama Kategori</label>
                                <input type="text" id="cat_title" name="cat_title" class="form-control" placeholder="Masukkan kategori">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="cat_id" name="cat_id" class="form-control" placeholder="Masukkan kategori">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="buttons" class="btn btn-primary">Update Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" data-backdrop="" id="formModal1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel1">Detail Pesanan</h6>
                <button type="button" class="close btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update-wilayah-form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Nama Wilayah</label>
                                <input type="text" id="nama_wilayah" name="nama_wilayah" class="form-control" placeholder="Masukkan Wilayah">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Kuota Wilayah</label>
                                <input type="number" id="kuota_wilayah" name="kuota_wilayah" class="form-control" placeholder="Masukkan Kuota Wilayah">
                            </div>
                        </div>
                        <input type="hidden" id="id_wilayah" name="id_wilayah" class="form-control" placeholder="Masukkan Kuota Wilayah">
                    </div>
                </div>
                <input type="hidden" id="cat_id" name="cat_id" class="form-control" placeholder="Masukkan kategori">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="buttons1" class="btn btn-primary">Update Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function getCategory() {
        $('#dataTable').DataTable({
            "order": [],
            "bSort": false,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "ajax": {
                "url": "<?= base_url(); ?>/Admin/categorywilayahController/getcategory", // ajax source
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
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "cat_title"
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

    function getWilayah() {
        $('#dataTable1').DataTable({
            "order": [],
            "bSort": false,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "ajax": {
                "url": "<?= base_url(); ?>/Admin/categorywilayahController/getwilayah", // ajax source
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
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "nama_wilayah"
                },
                {
                    "data": "kuota_wilayah"
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

    function resetCategory() {
        $("#cat_title").val('');
        $('#cat_id').val('')
    }

    function resetWilayah() {
        $("#nama_wilayah").val('');
        $('#kuota_wilayah').val('')
        $('#id_wilayah').val('')
    }

    function loadAddCategory() {
        $("#addCategory").on("click", () => {
            $('#update-category-form').attr('act', 'add');
            $('#formModal').modal("show")
            $('#buttons').html('Save')
            $('#exampleModalLabel').html('<strong class="text-primary"><i class="fas fa-plus"></i>Tambah Kategori</strong>')
            resetCategory()
        })
    }

    function loadAddWilayah() {
        $("#addWilayah").on("click", () => {
            $('#update-wilayah-form').attr('act', 'add');
            $('#formModal1').modal("show")
            $('#buttons1').html('Save')
            $('#exampleModalLabel1').html('<strong class="text-primary"><i class="fas fa-plus"></i>Tambah Wilayah</strong>')
            resetWilayah()
        })
    }

    function loadeditCategory() {
        $('#dataTable tbody').on('click', '#edit', function() {
            resetCategory()
            $('#update-category-form').attr('act', 'edit');
            $('#formModal').modal("show")
            $('#buttons').html('Save')
            $('#exampleModalLabel').html('<strong class="text-info"><i class="fas fa-edit"></i>Edit Kategori</strong>')
            const data = $('#dataTable').DataTable().row($(this).parents('tr')).data();

            $("#cat_id").val(data.cat_id);
            $('#cat_title').val(data.cat_title)
        });
    }

    function loadeditWilayah() {
        $('#dataTable1 tbody').on('click', '#edit', function() {
            resetWilayah()
            $('#update-wilayah-form').attr('act', 'edit');
            $('#formModal1').modal("show")
            $('#buttons1').html('Save')
            $('#exampleModalLabel1').html('<strong class="text-info"><i class="fas fa-edit"></i>Edit Wilayah</strong>')
            const data = $('#dataTable1').DataTable().row($(this).parents('tr')).data();

            $("#id_wilayah").val(data.id_wilayah);
            $('#nama_wilayah').val(data.nama_wilayah)
            $('#kuota_wilayah').val(data.kuota_wilayah)

        });
    }

    function condition() {
        $("#update-category-form").on("submit", function(e) {
            e.preventDefault()
            if ($('#update-category-form').attr('act') == 'add') {
                addCategory()
            } else {
                updateCategory();
            }
        })

        $("#update-wilayah-form").on("submit", function(e) {
            e.preventDefault()
            if ($('#update-wilayah-form').attr('act') == 'add') {
                addWilayah()
            } else {
                updateWilayah();
            }
        })
    }


    function deleteCategory() {
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
                        "cat_id": data.cat_id,
                    };
                    $.ajax({
                        url: '<?= base_url(); ?>/Admin/categorywilayahController/deletecategory',
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

    function deleteWilayah() {
        $('#dataTable1 tbody').on('click', '#delete', function() {

            const data = $('#dataTable1').DataTable().row($(this).parents('tr')).data();
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
                        "id_wilayah": data.id_wilayah,
                    };
                    $.ajax({
                        url: '<?= base_url(); ?>/Admin/categorywilayahController/deletewilayah',
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
                                $('#dataTable1').DataTable().ajax.reload();
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

    function addCategory() {
        let form_data = new FormData($("#update-category-form")[0]);

        if (!$('#cat_title').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Kategori tidak boleh Kosong'
        });

        $.ajax({
            url: '<?= base_url(); ?>/Admin/categorywilayahController/addcategory',
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

    function addWilayah() {
        let form_data = new FormData($("#update-wilayah-form")[0]);

        if (!$('#nama_wilayah').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Nama wilayah tidak boleh Kosong'
        });

        if (!$('#kuota_wilayah').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Kuota wilayah tidak boleh Kosong'
        });

        $.ajax({
            url: '<?= base_url(); ?>/Admin/categorywilayahController/addwilayah',
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
                    $('#formModal1').modal('hide');
                    $('#dataTable1').DataTable().ajax.reload();
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

    function updateCategory() {
        let form_data = new FormData($("#update-category-form")[0]);

        $.ajax({
            url: '<?= base_url(); ?>/Admin/categorywilayahCOntroller/updatecategory',
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


    function updateWilayah() {
        let form_data = new FormData($("#update-wilayah-form")[0]);

        $.ajax({
            url: '<?= base_url(); ?>/Admin/categorywilayahCOntroller/updatewilayah',
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
                    $('#formModal1').modal('hide');
                    $('#dataTable1').DataTable().ajax.reload();
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
        getCategory();
        getWilayah()
        deleteCategory();
        deleteWilayah();
        loadeditCategory();
        loadeditWilayah()
        loadAddCategory();
        loadAddWilayah()
        condition();
    });
</script>

<?= $this->endSection() ?>
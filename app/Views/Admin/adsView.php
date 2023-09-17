<?= $this->extend('Admin/layout/Admin_layout') ?>

<?= $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $title ?>
            <button id="addProduct" class="m-0 btn btn-sm btn-primary" style="float: right;">Tambah Iklan</button>
        </h6>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Gambar</th>
                        <th>Tanggal</th>
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
                                <label>Judul</label>
                                <input type="text" id="judul" name="judul" class="form-control" placeholder="Masukkan Judul">
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
                                <label>Foto Iklan <small>(format: jpg, jpeg, png)</small></label>
                                <input type="file" id="gambar" name="gambar" class="form-control">
                                <div id="view"></div>
                            </div>
                        </div>
                        <input type="hidden" id="gambar1" name="gambar1" class="form-control">
                    </div>
                </div>
                <input type="hidden" id="id_iklan" name="id_iklan" class="form-control">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="buttons" class="btn btn-primary">Update Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function getProduct() {
        $('#dataTable').DataTable({
            "order": [],
            "bSort": false,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "ajax": {
                "url": "<?= base_url(); ?>/Admin/adsController/getads", // ajax source
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
                    "data": "judul"
                },
                {
                    "data": "gambar",
                    render: function(data, type, row) {
                        let sts = `<img src="<?= base_url(); ?>/assets/img_ads/${data}" style="width:50px; height:50px;">`
                        return sts
                    }
                },
                {
                    "data": "tanggal"
                },
                {
                    "data": "status",
                    render: function(data, type, row) {
                        let sts = ``
                        if (data == 1) {
                            sts = `<span class="badge badge-success">Aktif</span>`
                        } else {
                            sts = `<span class="badge badge-danger">Tidak Aktif</span>`
                        }
                        return sts
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
            ],
            "drawCallback": function(settings) {
                // Here the response
                cardBatch = settings.json.recordsFiltered;
            },


        });
    }

    function resetProduct() {
        $("#id_iklan").val('');
        $('#judul').val('')
        $('#view').html('')
        $('#gambar1').val('')
        $('#gambar').val('')
        $('#status').val('')

    }

    function loadAdd() {
        $("#addProduct").on("click", () => {
            $('#update-product-form').attr('act', 'add');
            $('#formModal').modal("show")
            $('#buttons').html('Save')
            $('#exampleModalLabel').html('<strong class="text-primary"><i class="fas fa-plus"></i>Tambah Iklan</strong>')
            resetProduct()
        })
    }

    function loadedit() {
        $('#dataTable tbody').on('click', '#edit', function() {
            resetProduct()
            $('#update-product-form').attr('act', 'edit');
            $('#formModal').modal("show")
            $('#buttons').html('Save')
            $('#exampleModalLabel').html('<strong class="text-info"><i class="fas fa-edit"></i>Edit Iklan</strong>')
            const data = $('#dataTable').DataTable().row($(this).parents('tr')).data();

            $("#id_iklan").val(data.id_iklan);
            $("#judul").val(data.judul);
            $('#gambar1').val(data.gambar)
            $('#status').val(data.status)
            $('#view').html(`<img src="<?= base_url(); ?>/assets/img_ads/${data.gambar}" class="img-fluid" width="200">`)

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


    function deleteMember() {
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
                        "id_iklan": data.id_iklan,
                        "gambar": data.gambar
                    };
                    $.ajax({
                        url: '<?= base_url(); ?>/Admin/adsController/deleteads',
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

        if (!$('#judul').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Judul tidak boleh Kosong'
        });
        if (!$("#gambar").val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Gambar tidak boleh Kosong'
        });
        if (!$('#status').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Status tidak boleh Kosong'
        });

        $.ajax({
            url: '<?= base_url(); ?>/Admin/adsController/addads',
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
            url: '<?= base_url(); ?>/Admin/adsController/updateads',
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
        deleteMember()
        loadedit();
        loadAdd();
        condition();
    });
</script>

<?= $this->endSection() ?>
<?= $this->extend('Admin/layout/Admin_layout') ?>

<?= $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header d-flex align-items-center">
        <h6 class="font-weight-bold text-primary"><?= $title ?></h6>
        <div class="input-group input-group-sm col-sm-2 ml-5">
            <label class="mr-2">Start</label>
            <input class="form-control form-control-sm" type="text" id="period1" name="period1" value="" />
        </div>
        <div class="input-group input-group-sm col-sm-2 ml-1">
            <label class="mr-2">End</label>
            <input class="form-control form-control-sm" type="text" id="period2" name="period2" value="" />
        </div>
        <div class="input-group input-group-sm col-sm-2 ml-1">
            <button class="btn btn-sm btn-primary" id="filter_data">Filter</button>
        </div>
        <div class="input-group input-group-sm col-sm-2 ml-1">
            <span class="btn btn-sm btn-outline-success" onClick="getExcel()">
                <i class="fas fa-file-export"></i>
                Export
            </span>
        </div>
        <div class="input-group input-group-sm col-sm-2 ml-1">
            <button class="btn btn-sm btn-primary" id="addProduct">Tambah Member</button>
        </div>
        <div class="input-group input-group-sm col-sm-2 ml-1">
            <a href="<?php $_SERVER['PHP_SELF']; ?>" class="m-0 btn btn-sm btn-primary">Refresh</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Join Date</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>No Rek</th>
                        <th>Nama Bank</th>
                        <th>Zoning</th>
                        <th>Referal</th>
                        <th>Tipe Akun</th>
                        <th>Saldo</th>
                        <th>Poin</th>
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
                                <label>NIK</label>
                                <input type="text" id="nik" name="nik" class="form-control" placeholder="Masukkan NIK">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tgl Lahir</label>
                                <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control" placeholder="Tanggal Lahir">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Nama depan</label>
                                <input type="text" id="nama_depan" name="nama_depan" class="form-control" placeholder="Masukkan Nama depan">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Nama belakang</label>
                                <input type="text" id="nama_belakang" name="nama_belakang" class="form-control" placeholder="Masukkan Nama belakang">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Alamat FB</label>
                                <input type="text" id="alamat_fb" name="alamat_fb" class="form-control" placeholder="Masukkan Alamat FB">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan Email">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Password
                                </label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="number" id="mobile" name="mobile" class="form-control" placeholder="No Hape">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Nomor Rekening</label>
                                <input type="number" id="no_rek" name="no_rek" class="form-control" placeholder="No Rekening">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Nama Bank</label>
                                <input type="text" id="nama_bank" name="nama_bank" class="form-control" placeholder="Nama Bank">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Zoning</label>
                                <select id="zoning" class="form-control" name="zoning">
                                    <option value="">Select Wilayah</option>
                                    <?php foreach ($wilayah as $key) { ?>
                                        <option value="<?= $key['id_wilayah'] ?>"><?= $key['nama_wilayah'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Kode referal</label>
                                <input type="text" id="k_referal" name="k_referal" class="form-control" placeholder="Kode Referal">
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
                                <label>Tipe Akun</label>
                                <select id="tipe_akun" class="form-control" name="tipe_akun">
                                    <option value="">Select Tipe</option>
                                    <option value="2">Distributor</option>
                                    <option value="3">Reseller</option>
                                    <option value="4">Agen</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="user_id" name="user_id" class="form-control">
                <input type="hidden" id="e_zoning" name="e_zoning" class="form-control">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="buttons" class="btn btn-primary">Update Produk</button>
                </div>
            </form>
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
            getProduct()
        });
    };

    const getExcel = () => {
        document.location.href = '<?= base_url(); ?>/Admin/memberController/cetakexcelmember?period1=' + $('#period1').val() +
            '&period2=' + $('#period2').val()
    };

    function getProduct() {
        $('#dataTable').DataTable({
            "order": [],
            "bSort": false,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "ajax": {
                "url": "<?= base_url(); ?>/Admin/memberController/getmember", // ajax source
                "type": "post",
                "data": function(d) {
                    d.period1 = $('#period1').val()
                    d.period2 = $('#period2').val()
                    return d
                }
            },
            "columns": [{
                    "data": "user_id"
                },
                {
                    "data": "tanggal_join"
                },
                {
                    "data": "nama"
                },
                {
                    "data": "alamat"
                },
                {
                    "data": "email"
                },
                {
                    "data": "mobile"
                },
                {
                    "data": "no_rek"
                },
                {
                    "data": "nama_bank"
                },
                {
                    "data": "wilayah"
                },
                {
                    "data": "k_referal"
                },
                {
                    "data": "tipe_akun",
                    "render": function(data, type, row) {
                        let sts = ``;
                        if (row.tipe_akun == 2) {
                            sts = `<span class="badge badge-success">Distributor</span>`;
                        } else if (row.tipe_akun == 3) {
                            sts = `<span class="badge badge-warning">Reseller</span>`;
                        } else if (row.tipe_akun == 4) {
                            sts = `<span class="badge badge-primary">Agen</span>`;
                        }
                        return sts
                    }
                },
                {
                    "data": "poin"
                },
                {
                    "data": "poin_belanja"
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
        $("#nik").val('');

        $('#tgl_lahir').val('')
        $('#nama_depan').val('')
        $('#nama_belakang').val('')
        $('#email').val('')
        $('#password').val('')

        $('#mobile').val('')
        $('#no_rek').val('')
        $('#nama_bank').val('')
        $('#zoning').val('')
        $('#k_referal').val('')

        $('#status').val('')
        $('#tipe_akun').val('')
        $('#alamat').val('')
        $("#user_id").val('')
        $("#e_zoning").val('')

    }

    function loadAdd() {
        $("#addProduct").on("click", () => {
            $('#update-product-form').attr('act', 'add');
            $('#formModal').modal("show")
            $('#buttons').html('Save')
            $('#exampleModalLabel').html('<strong class="text-primary"><i class="fas fa-plus"></i>Tambah Member</strong>')
            resetProduct()
        })
    }

    function loadedit() {
        $('#dataTable tbody').on('click', '#edit', function() {
            resetProduct()
            $('#update-product-form').attr('act', 'edit');
            $('#formModal').modal("show")
            $('#buttons').html('Save')
            $('#exampleModalLabel').html('<strong class="text-info"><i class="fas fa-edit"></i>Edit Member</strong>')
            const data = $('#dataTable').DataTable().row($(this).parents('tr')).data();

            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>/Admin/memberController/getwilayah',
            }).then(function(dt) {
                var res = JSON.parse(dt);
                console.log(dt)
                let option = `<option value="">Silahkan Pilih</option>`;

                res.map((e) => {
                    option += `<option ${e.id_wilayah == data.zoning ? `selected=selected`:''} value="${e.id_wilayah}" >${e.nama_wilayah}</option>`;
                });
                $("#zoning").html(option);
            });

            $("#user_id").val(data.user_id);
            $("#nik").val(data.nik);
            $('#tgl_lahir').val(data.tgl_lahir)
            $('#nama_depan').val(data.nama_depan)
            $('#nama_belakang').val(data.nama_belakang)
            $('#alamat_fb').val(data.alamat_fb)
            $('#email').val(data.email)
            $('#mobile').val(data.mobile)
            $('#no_rek').val(data.no_rek)
            $('#nama_bank').val(data.nama_bank)
            $('#k_referal').val(data.k_referal)
            $('#status').val(data.status)
            $('#tipe_akun').val(data.tipe_akun)
            $('#alamat').val(data.alamat)
            $("#e_zoning").val(data.zoning)

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
                        "user_id": data.user_id,
                    };
                    $.ajax({
                        url: '<?= base_url(); ?>/Admin/memberController/deletemember',
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

        if (!$('#nik').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'NIK tidak boleh Kosong'
        });
        if (!$("#tgl_lahir").val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Tanggal Lahir tidak boleh Kosong'
        });
        if (!$('#nama_depan').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Nama depan tidak boleh Kosong'
        });
        if (!$('#nama_belakang').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Nama Belakang tidak boleh Kosong'
        });

        if (!$('#email').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Email tidak boleh Kosong'
        });
        if (!$('#password').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Password tidak boleh Kosong'
        });
        if (!$('#mobile').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'No Handphone tidak boleh Kosong'
        });
        if (!$('#no_rek').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'No Rekening tidak boleh Kosong'
        });
        if (!$('#nama_bank').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Nama Bank tidak boleh Kosong'
        });

        if (!$('#zoning').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Zonasi tidak boleh Kosong'
        });
        if (!$('#status').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Status tidak boleh Kosong'
        });
        if (!$('#tipe_akun').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Tipe akun tidak boleh Kosong'
        });
        if (!$('#alamat').val()) return Swal.fire({
            icon: 'warning',
            title: 'Peringatan !',
            text: 'Alamat tidak boleh Kosong'
        });

        $.ajax({
            url: '<?= base_url(); ?>/Admin/memberController/addmember',
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
            url: '<?= base_url(); ?>/Admin/memberController/updatemember',
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
                    $('#period1').val('');
                    $('#period2').val('');
                    getProduct();
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
        loadDatepicker();
        loadFilter();
    });
</script>

<?= $this->endSection() ?>
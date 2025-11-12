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
                                    <th>Date In</th>
                                    <th>Date Out</th>
                                    <th>User In</th>
                                    <th>User Out</th>
                                    <th>Tahun</th>
                                    <th>Bulan</th>
                                    <th>No Urut</th>
                                    <th>Kategori</th>
                                    <th>Model</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Warehouse</th>
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
                        <div class="modal-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Berat</th>
                                    </tr>
                                </thead>
                                <tbody id="detailOrder">
                                </tbody>
                            </table>
                        </div>
                        <form class="form" target="_blank" action="<?= base_url(); ?>/Admin/invoiceController/cetakinvoiceguest" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="kodeTrans" name="kodetransaksi">
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-info">Cetak Invoice</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade bd-example-modal-lg" data-backdrop="" id="formModalBuktiTF" role="dialog" aria-labelledby="exampleModalLabelBuktiTF" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="exampleModalLabelBuktiTF">Detail Pesanan</h6>
                            <button type="button" class="close btn-sm" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="previewBukti">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade bd-example-modal-lg" data-backdrop="" id="formModalUpload" role="dialog" aria-labelledby="staticBackdropLabelUpload" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="staticBackdropLabelUpload">Detail Pesanan</h6>
                            <button type="button" class="close btn-sm" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="form" id="form_addongkir" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input class="form-control form-control-sm" id="formFileSm" name="ongkir" type="number">
                                <input type="hidden" id="kodeTransaksi" name="kodetransaksi">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // DEKLARASI OBJEK OPTION UNTUK FLATDATE
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
            loadDataout()
        });
    };

    const getExcel = () => {
        document.location.href = '<?= base_url(); ?>/transaksiController/cetakexcelout?period1=' + $('#period1').val() +
            '&period2=' + $('#period2').val() + '&cabang=' + $('#cabang').val()
    };

    function loadDataout() {
        $('#dataTable').DataTable({
            "order": [],
            "bSort": false,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "pagingType": "full_numbers",
            "ajax": {
                "url": "<?= base_url(); ?>/transaksiController/getbarangout", // ajax source
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
                    "data": "date_out"
                },
                {
                    "data": "user_in"
                },
                {
                    "data": "user_out"
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
                    "data": "customer"
                },
                {
                    "data": "status"
                },
                {
                    "data": "nama_warehouse"
                },
                {
                    "data": "id",
                    render: function(data, type, row) {
                        let deleteButton = `<span type="submit" class="ml-3 deleteDataButton" data-id="${row.id}"><i class="fas fa-trash-alt text-danger"></i></span>`;
                        return deleteButton
                    }
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
                url: '<?= base_url(); ?>/Admin/transaksiController/getorderGuestDetail',
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
                            </tr>`;
                });
                $("#detailOrder").html(option);
                // $("#card_version_filter").html(optionfilter);
            });
        });
    }

    function loadDelete() {
        $('#dataTable tbody').on('click', 'span.deleteDataButton', function() {

            const data = $('#dataTable').DataTable().row($(this).parents('tr')).data();

            Swal.fire({
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger mr-2',
                    cancelButton: 'btn btn-secondary'
                },
                reverseButtons: false,
                title: `Are you sure ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Close'
            }).then((result) => {
                if (result.isConfirmed) {
                    const dataDelete = {
                        "id": data.id
                    };
                    $.ajax({
                        url: '<?= base_url(); ?>/transaksiController/deletedataout',
                        type: 'post',
                        data: dataDelete,
                        success: (hsl) => {
                            var res = JSON.parse(hsl);
                            console.log(res);
                            if (res.status_code == '202') {
                                Swal.fire(
                                    'Success!',
                                    res.message,
                                    'success'
                                )
                                // reset();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    res.message,
                                    'error'
                                )
                            }
                            $('#dataTable').DataTable().ajax.reload();
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
        loadDatepicker()
        loadFilter()
        loadDataout()
        loadDelete()
    });
</script>

<?= $this->endSection() ?>
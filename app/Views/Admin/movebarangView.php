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
                                    <th>Date Scan In</th>
                                    <th>Date Scan Move</th>
                                    <th>User Scan In</th>
                                    <th>User Scan Move</th>
                                    <th>Tahun</th>
                                    <th>Bulan</th>
                                    <th>Urutan</th>
                                    <th>Kategori</th>
                                    <th>Model</th>
                                    <th>Warehouse Lama</th>
                                    <th>Warehouse Baru</th>
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

    console.log(nextDate);

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

        $("#period21").flatpickr({
            ...flatDateOption,
            defaultDate: dateNow,
            maxDate: dateNow,
            minDate: dateNow
        });
        $("#period11").flatpickr({
            ...flatDateOption,
            defaultDate: dateNow,
            maxDate: dateNow,
            onChange: function(selectedDates, dateStr, instance) {
                let datePicker1 = new Date(dateStr);
                let nextDatePicker1 = `${datePicker1.getFullYear()}-${datePicker1.getMonth() + 1}-${datePicker1.getDate() }`;
                $("#period21").flatpickr({
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
            $("#dataTable").DataTable().destroy();
            loadDataIn()
        });
    };

    const loadFilter1 = () => {
        $('#filter_data1').click(function() {
            $("#dataTable1").DataTable().destroy();
            loadDataIn1()
        });
    };

    const getExcel = () => {
        document.location.href = '<?= base_url(); ?>/movebarangController/cetakexcelmove?period1=' + $('#period1').val() +
            '&period2=' + $('#period2').val() + '&cabang=' + $('#cabang').val()
    };

    function loadAdd() {
        $("#addProduct").on("click", () => {
            $.fn.dataTable.tables({
                visible: true,
                api: true
            }).columns.adjust();
            $('#update-product-form').attr('act', 'add');
            $('#formModal').modal("show")
            $('#buttons').html('Save')
            $('#exampleModalLabel').html('<strong class="text-primary"><i class="fas fa-plus"></i>Pindah Produk</strong>')
            resetProduct()
        })
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

    function loadDataIn() {
        $('#dataTable').DataTable({
            "fixedHeader": true,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "order": [],
            "searching": true,
            "ajax": {
                "url": "<?= base_url(); ?>/movebarangController/getbarang", // ajax source
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
                    "data": "date_move"
                },
                {
                    "data": "user_in"
                },
                {
                    "data": "user_move"
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
                    "data": "warehouse_lama"
                },
                {
                    "data": "warehouse_baru"
                },
            ],
            "drawCallback": function(settings) {
                // Here the response
                cardBatch = settings.json.recordsFiltered;
            },


        });
    }
    $(document).ready(function() {
        loadDatepicker()
        loadDataIn();
        loadFilter()
        loadAdd()
    });
</script>

<?= $this->endSection() ?>
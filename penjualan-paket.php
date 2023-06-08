<?php
    include "apiDB.php"; // DB
    include "func/formatInput.php"; // FUNCTION
    include "config/userLogin.php"; // USER LOGIN
    include "config/penjualanPaketConfig.php"; // STATUS ORDER 
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title> <?= strtoupper($title) ?> | NRJ TOUR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "partial/meta.php" ?>

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Sweet Alert-->
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <style>
        .newline-cell {
            white-space: pre-line;
        }
    </style>
</head>

<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        <!-- ========== Topbar Start ========== -->
        <?php include "partial/topBar.php" ?>
        <!-- Topbar End -->

        <!-- ========== Sidebar Start ========== -->
        <?php include "partial/sideBar.php" ?>
        <!-- Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">


                    <!-- start page title -->
                    <!-- ========== START TABLE ========== -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0"><?= $title ?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a
                                                href="javascript: void(0);">Data & Laporan</a>
                                        </li>
                                        <li class="breadcrumb-item active">
                                            <?= $title ?></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- END TABLE -->

                    <div class="row">
                        <!-- SORTIR FITUR -->
                        <div class="col-12 col-sm-12 mb-2">
                            <form action="" method="post" class="card radius-10">
                                <div class="card-header">
                                    <h7>Sortir Data</h7>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-sm">
                                            <label for="dari" class="form-label">Dari</label>
                                            <input type="date" id="dari" value="<?= $from ?>" name="from" class="form-control form-control-sm" required>
                                        </div>
                                        <div class="col-12 col-sm">
                                            <label for="sampai" class="form-label">Sampai</label>
                                            <input type="date" id="sampai" value="<?= $to ?>" name="to" class="form-control form-control-sm" required>
                                        </div>
                                        <div class="col-12 col-sm">
                                            <label for="statuss" class="form-label">Status</label>
                                            <select required name="status" id="statuss" class="form-select form-select-sm" style="width: 100%">
                                                <option value="">--PILIH STATUS--</option>
                                                <?= optStatus($status) ?>
                                            </select>
                                        </div>  
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" name="sortir" class="btn btn-primary btn-sm">Cari</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 col-sm-4 mb-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex text-muted">
                                        <div class="flex-shrink-0  me-3 align-self-center">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                    <i class="ri-shopping-cart-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="mb-1">Total Orderan</p>
                                            <h5 class="mb-3"><?= number_format(reportPenjualan($from, $to, $status)['jumlahPaket'],0,",",".") ?> Paket</h5>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card-body -->
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 mb-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex text-muted">
                                        <div class="flex-shrink-0  me-3 align-self-center">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                    <i class="ri-price-tag-3-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="mb-1">Total DP</p>
                                            <h5 class="mb-3">Rp.<?= number_format(reportPenjualan($from, $to, $status)['jumlahDP'],0,",",".") ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card-body -->
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 mb-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex text-muted">
                                        <div class="flex-shrink-0  me-3 align-self-center">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                    <i class="ri-price-tag-3-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="mb-1">Total Pelunasan</p>
                                            <h5 class="mb-3">Rp.<?= number_format(reportPenjualan($from, $to, $status)['jumlahPelunasan'],0,",",".") ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card-body -->
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="downloadPdfBtn"></div>
                                    <table id="datatable" class="table table-striped dt-responsive table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>No. Order</th>
                                                <?php if($role_user == "ADMIN"){ ?>
                                                    <th>Konsultan</th>
                                                <?php } ?>
                                                <th>Harga</th>
                                                <th>Diskon</th>
                                                <th>Data Jamaah</th>
                                                <th>Status</th>
                                                <th>Tgl Order</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?= dataTable($from, $to, $status) ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========== START MODAL ========== -->
                    <?php  
                    $data = $dataPenjualanClass->selectDataPenjualan("dateKonsultan", $_SESSION['id_nrjtour'], $from, $to);
                    if($role_user == "ADMIN"){
                        $data = $dataPenjualanClass->selectDataPenjualan("date", $from, $to);
                    }
                    foreach($data['data'] as $row){
                        $show = true;
                        if($status != "ALL"){
                            $show = $row['status'] == $status ? true : false;
                        }
                        if($show){
                    ?>
                    <div class="modal fade" id="detailJamaah<?= $row['code_order'] ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Data Jamaah</h1>
                                </div>
                                <div class="modal-body">
                                    <h6>Foto KTP</h6>
                                    <br>
                                    <img src="<?= dataJamaah($row['code_order'])['foto_ktp'] ?>" alt=""
                                        style="width:100%;">
                                    <hr>
                                    <div class="mb-1" style="font-size: smaller;">
                                        NIK : <?= dataJamaah($row['code_order'])['nik'] ?>
                                    </div>
                                    <div class="mb-1" style="font-size: smaller;">
                                        Nama Sesuai KTP : <?= dataJamaah($row['code_order'])['nama'] ?>
                                    </div>
                                    <div class="mb-1" style="font-size: smaller;">
                                        Tempat, Tgl Lahir : <?= dataJamaah($row['code_order'])['tempat_lahir'] ?>,
                                        <?= dataJamaah($row['code_order'])['tgl_lahir'] ?>
                                    </div>
                                    <div class="mb-1" style="font-size: smaller;">
                                        Jenis Kelamin : <?= dataJamaah($row['code_order'])['jk'] ?>
                                    </div>
                                    <div class="mb-1" style="font-size: smaller;">
                                        Status Perkawinan : <?= dataJamaah($row['code_order'])['status_perkawinan'] ?>
                                    </div>
                                    <div class="mb-3" style="font-size: smaller;">
                                        Alamat : <br>
                                        <?= dataJamaah($row['code_order'])['kab_kota'] ?> -
                                        <?= dataJamaah($row['code_order'])['prov'] ?> <br>
                                        <?= dataJamaah($row['code_order'])['kec'] ?> <br>
                                        <?= dataJamaah($row['code_order'])['detail_alamat'] ?>
                                    </div>
                                    <?php if(dataKelengkapan($row['code_order'])['nums'] > 0){ ?>
                                    <h6>Data Kelengkapan</h6>
                                    <hr>
                                    <div class="mb-1" style="font-size: smaller;">
                                        Nomor Paspor : <?= dataKelengkapan($row['code_order'])['no_passport'] ?>
                                    </div>
                                    <div class="mb-1" style="font-size: smaller;">
                                        Tgl terbit Paspor : <?= dataKelengkapan($row['code_order'])['tgl_terbit'] ?>
                                    </div>
                                    <div class="mb-1" style="font-size: smaller;">
                                        Tgl berlaku Paspor : <?= dataKelengkapan($row['code_order'])['tgl_berlaku'] ?>
                                    </div>
                                    <div class="mb-1" style="font-size: smaller;">
                                        Dibuat di : <?= dataKelengkapan($row['code_order'])['alamat_terbit'] ?>
                                    </div>
                                    <div class="mb-1" style="font-size: smaller;">
                                        Vaksin : <?= dataKelengkapan($row['code_order'])['is_vaksi'] ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php  
                        }
                    }
                    ?>
                    <!-- END MODAL -->
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->



        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?php include "partial/layout.php" ?>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/libs/jszip/jszip.min.js"></script>
    <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>
    <!-- PRINT / PDF -->
    <script>
        // Fungsi untuk menginisialisasi DataTable dan menambahkan event listener pada tombol download PDF dan print
        function initializeDataTable() {
            var table = $('#datatable').DataTable();

            new $.fn.dataTable.Buttons(table, {
                buttons: [{
                        extend: 'pdfHtml5',
                        className: 'buttons-pdf buttons-html5',
                        customize: function (doc) {
                            // Mengatur orientasi menjadi landscape
                            doc.pageOrientation = 'landscape';

                            // Mengatur style agar data jamaah pada kolom "Data Jamaah" ditampilkan dalam satu baris
                            doc.content[1].table.body.forEach(function (row) {
                                if (row[5].text) {
                                    row[5].text = row[5].text.replace(/<br\s*\/?>/ig, ' ');
                                }
                            });
                        }
                    },
                    {
                        extend: 'print',
                        className: 'buttons-print',
                        customize: function (win) {
                            // Mengatur orientasi menjadi landscape
                            $(win.document.body).find('table').addClass('dt-print-view').css('width',
                                '100%');
                            $(win.document.body).find('table.dt-print-view').removeClass(
                                'table-bordered').removeClass('nowrap').addClass('table-striped');
                        }
                    }
                ]
            });

            table.buttons().container().appendTo('#downloadPdfBtn');
        }

        $(document).ready(function () {
            // Panggil fungsi untuk menginisialisasi DataTable
            initializeDataTable();
        });
    </script>

    <script src="assets/js/app.js"></script>
    <!-- Sweet Alerts js -->
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <?php if($_SESSION['alertSuccess'] != ""){ ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '<?= $_SESSION['alertSuccess'] ?>',
            showConfirmButton: false,
            timer: 1500
        })
    </script>
    <?php } ?>
    <?php if($_SESSION['alertError'] != ""){ ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: '<?= $_SESSION['alertError'] ?>',
            showConfirmButton: false,
            timer: 1500
        })
    </script>
    <?php } ?>

</body>

</html>
<?php $_SESSION['alertError'] = ""; $_SESSION['alertSuccess'] = "" ?>
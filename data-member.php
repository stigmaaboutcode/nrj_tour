<?php
    include "apiDB.php"; // DB
    include "func/formatInput.php"; // FUNCTION
    include "config/userLogin.php"; // USER LOGIN
    include "config/dataMemberConfig.php"; // STATUS ORDER 
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title><?= strtoupper($title) ?> | NRJ TOUR</title>
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
                    <!-- ========== START TAMPILAN ADMIN ========== -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0"><?= $title ?></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Data & Laporan</a>
                                        </li>
                                        <li class="breadcrumb-item active"><?= $title ?></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="downloadPdfBtn"></div>
                                    <table id="datatable" class="table table-striped dt-responsive table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Info User</th>
                                                <th>Upline</th>
                                                <!-- <th>Penjualan</th> -->
                                                <th>status</th>
                                                <th>tgl Gabung</th>
                                                <?php if($role_user != "KONSULTAN"){ ?>
                                                    <th>Aksi</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?= dataTable() ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

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
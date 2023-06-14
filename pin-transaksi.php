<?php
    include "apiDB.php"; // DB
    include "func/formatInput.php"; // FUNCTION
    include "config/userLogin.php"; // USER LOGIN
    include "config/pinTransaksiConfig.php"; // STATUS ORDER 
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
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between"><h4 class="mb-sm-0"><?= $title ?> </h4>

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
                        <?php if($role_user == "ADMIN"){ ?>
                        <div class="col-12 col-sm-4 mb-2">
                            <form action="" method="post" class="card radius-10">
                                <div class="card-body">
                                    <h7 class="card-title">Kirim PIN</h7>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12 col-sm-12 mb-3">
                                            <label for="konsultan" class="form-label">Konsultan</label>
                                            <select required name="konsultan" id="konsultan" class="form-select form-select-sm" style="width: 100%">
                                                <option value="ALL">Semua</option>
                                                <?= optUser($userID) ?>
                                            </select>
                                        </div>  
                                        <div class="col-12 col-sm-12 mb-3">
                                            <label for="jumlahPin" class="form-label">Jumlah PIN</label>
                                            <input required type="number" name="jumlahPin" id="jumlahPin" class="form-control form-control-sm" placeholder="Masukkan Jumlah PIN">
                                        </div>  
                                        <div class="col-12 col-sm-12 mb-3">
                                            <label for="categoryPin" class="form-label">Kategori</label>
                                            <div style="display: flex; justify-content: space-around;">
                                            <?php
                                                $opt = array('pinFree'=>'PIN FREE', 'pinRegis'=>'PIN REGISTRASI', 'pinPelunasan'=>'PIN PELUNASAN');
                                                foreach($opt as $key => $checkbox){
                                            ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="<?= $key ?>" id="<?= $key ?>" checked>
                                                    <label class="form-check-label" for="<?= $key ?>">
                                                        <?= $checkbox ?>
                                                    </label>
                                                </div>
                                            <?php } ?>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" name="addPin" class="btn btn-sm btn-outline-success" onclick="showAlert()">Add</button>
                                </div>
                            </form>
                        </div>
                        <?php } ?>
                        <div class="col-12 col-sm mb-2">
                            <div class="card">
                                <div class="card-body">
                                    <div id="downloadPdfBtn"></div>
                                    <table id="datatable" class="table table-striped dt-responsive table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <?php if($role_user == "ADMIN"){ ?>
                                                <th>Konsultan</th>
                                                <?php } ?>
                                                <th>PIN</th>
                                                <th>Kategori</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?= dataPinUser() ?>
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
                            doc.pageOrientation = 'portrait';

                            // Mengatur style agar data jamaah pada kolom "Data Jamaah" ditampilkan dalam satu baris
                            doc.content[1].table.body.forEach(function (row) {
                                row.forEach(function (cell, cellIndex) {
                                    if (cell.text && cellIndex === 5) {
                                        cell.text = cell.text.replace(/<br\s*\/?>/ig, ' ');
                                    }
                                });
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
    <script>
        function showAlert() {
            let timerInterval;

            Swal.fire({
                title: 'Generate Pin!',
                html: 'time in <b></b> milliseconds.',
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const b = Swal.getHtmlContainer().querySelector('b');
                    let startTime = new Date().getTime(); // Waktu saat halaman dimulai dimuat

                    timerInterval = setInterval(() => {
                        const currentTime = new Date().getTime(); // Waktu saat ini
                        const elapsedTime = currentTime - startTime; // Waktu yang sudah berlalu
                        b.textContent = elapsedTime;
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer');
                }
            });
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#konsultan').select2();
        });

    </script>

</body>

</html>
<?php $_SESSION['alertError'] = ""; $_SESSION['alertSuccess'] = "" ?>
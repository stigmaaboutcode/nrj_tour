<?php
    include "apiDB.php"; // DB
    include "func/formatInput.php"; // FUNCTION
    include "config/userLogin.php"; // USER LOGIN
    include "config/settingHargaPelunasanConfig.php"; // STATUS ORDER
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>SETTING HARGA PELUNASAN | NRJ TOUR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "partial/meta.php" ?>

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Sweet Alert-->
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

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
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Harga Pelunasan</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Harga & Bonus</a></li>
                                        <li class="breadcrumb-item active">Harga Pelunasan</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-12 col-sm-6 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="card-title">Setting Harga Pelunasan</h1>
                                    <hr>
                                    <form action="" method="post">
                                        <div class="mb-3">
                                            <label for="hargaReguler" class="form-label">Reguler (Rp)</label>
                                            <input type="number" class="form-control form-control-sm" id="hargaReguler"
                                                name="hargaReguler" required placeholder="Masukkan Harga DP" value="<?= nominalHarga()['reguler'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="hargaEksekutif" class="form-label">Eksekutif (Rp)</label>
                                            <input type="number" class="form-control form-control-sm" id="hargaEksekutif"
                                                name="hargaEksekutif" required placeholder="Masukkan Harga DP" value="<?= nominalHarga()['eksekutif'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="hargaRamadhan" class="form-label">Ramadhan (Rp)</label>
                                            <input type="number" class="form-control form-control-sm" id="hargaRamadhan"
                                                name="hargaRamadhan" required placeholder="Masukkan Harga DP" value="<?= nominalHarga()['ramadhan'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="hargaSyawal" class="form-label">Syawal (Rp)</label>
                                            <input type="number" class="form-control form-control-sm" id="hargaSyawal"
                                                name="hargaSyawal" required placeholder="Masukkan Harga DP" value="<?= nominalHarga()['syawal'] ?>">
                                        </div>
                                        <hr>
                                        <button type="submit" name="submit" class="btn btn-sm btn-primary float-end">Submit</button>
                                    </form>
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
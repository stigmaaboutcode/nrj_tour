<?php
    include "apiDB.php"; // DB
    include "func/formatInput.php"; // FUNCTION
    include "config/userLogin.php"; // USER LOGIN
    include "config/dasborConfig.php"; // STATUS ORDER
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>DASBOR | NRJ TOUR</title>
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
                                <h4 class="mb-sm-0">Dasbor</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">NRJ Tour</a></li>
                                        <li class="breadcrumb-item active">Dasbor</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <?php if($role_user == "ADMIN"){ ?>
                        <!-- ========== START TAMPILAN ADMIN ========== -->

                        <!-- END TAMPILAN ADMIN -->
                    <?php }else{ ?>
                        <!-- ========== START TAMPILAN MEMBER ========== -->
                        <div class="row">
                            <div class="col-xl-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0  me-3 align-self-center">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                        <i class="ri-wallet-3-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">Saldo Bonus</p>
                                                <h5 class="mb-3">Rp.<?= number_format(walletUser()['bonus'],0,",",".") ?></h5>
                                                <p class="text-truncate mb-0" style="font-size: smaller;"><a href="#withdraw" data-bs-toggle="modal">Withdraw!</a> Bonus Anda.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <div class="col-xl-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0  me-3 align-self-center">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                        <i class="ri-trophy-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">Saldo Poin</p>
                                                <h5 class="mb-3"><?= walletUser()['poin'] ?> Poin</h5>
                                                <p class="text-truncate mb-0" style="font-size: smaller;">Gratis 1 paket umroh untuk 10 poin. <a href="order-paket?usePoin=ya">Claim!</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                        </div>
                        <div class="modal fade" id="withdraw" tabindex="-1"
                        aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <form action="" method="post" class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Withdraw Bonus</h1>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <strong>Saldo Anda: Rp.<?= number_format(walletUser()['bonus'],0,",",".") ?></strong>
                                        </div>
                                        <div id="inputpin" class="col-12 col-sm-12 mb-3">
                                            <label for="nominal" class="form-label">Jumlah (Rp.)</label>
                                            <input required class="form-control form-control-sm" type="number" id="nominal" name="nominal" placeholder="Masukkan jumlah">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="withdrawBonus" class="btn btn-success">Withdraw</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- END TAMPILAN MEMBER -->
                    <?php } ?>

                    <div class="row"></div>

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
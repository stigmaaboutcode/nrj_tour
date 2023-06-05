<?php
    include "apiDB.php"; // DB
    include "func/formatInput.php"; // FUNCTION
    include "config/userLogin.php"; // USER LOGIN
    include "config/pelunasanPaketConfig.php"; // STATUS ORDER
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>PELUNASAN PAKET | NRJ TOUR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />

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

    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

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
                                <h4 class="mb-sm-0">Pelunasan Paket</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">NRJ Tour</a></li>
                                        <li class="breadcrumb-item active">Pelunasan Paket</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php if(!$_SESSION['inputPeunasanNrj']){ ?>
                    <div class="row">
                        <div class="col-12 col-sm-4 mx-auto">
                            <form action="" method="post" class="card">
                                <div class="card-body">
                                    <h1 class="card-title">Pin Transaksi Pelunasan</h1>
                                    <hr>
                                    <div class="mb-2">
                                        <input type="text" name="pin" id="pin" class="form-control" placeholder="Masukkan pin anda" style="text-transform: uppercase;">
                                        <p style="font-size: 0.6rem;"><strong>*untuk melakukan pelunasan paket umroh / haji anda harus memiliki pin yang dibuat oleh admin.</strong></p>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" name="submitPin" class="btn btn-primary btn-sm">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php }else{ ?>
                        <div class="row">
                            <div class="col-12 col-sm-6 mx-auto">
                                <form action="" method="post" enctype="multipart/form-data" class="card">
                                    <div class="card-body">
                                        <div class="border rounded p-3 mb-2">
                                            <h1 class="card-title">Umroh / Haji</h1>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12 col-sm-12 mb-3">
                                                    <label for="tglbrg" class="form-label">Tanggal Keberangkatan</label>
                                                    <input required type="date" class="form-control form-control-sm" id="tglbrg" name="tglbrg">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border rounded p-3 mb-2">
                                            <h1 class="card-title">Data Paspor</h1>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12 col-sm-12 mb-3">
                                                    <label for="nopaspor" class="form-label">Nomor Paspor</label>
                                                    <input required type="text" class="form-control form-control-sm" id="nopaspor" name="nopaspor" placeholder="cth: A0xxxxxxx" style="text-transform: uppercase;">
                                                </div>
                                                <div class="col-12 col-sm-6 mb-3">
                                                    <label for="tglterbit" class="form-label">Tanggal Terbit</label>
                                                    <input required type="date" class="form-control form-control-sm" id="tglterbit" name="tglterbit">
                                                </div>
                                                <div class="col-12 col-sm-6 mb-3">
                                                    <label for="tglberlaku" class="form-label">Tanggal Berlaku</label>
                                                    <input required type="date" class="form-control form-control-sm" id="tglberlaku" name="tglberlaku">
                                                </div>
                                                <div class="col-12 col-sm-6 mb-3">
                                                    <label for="almterbit" class="form-label">Alamat Terbit</label>
                                                    <input required type="text" class="form-control form-control-sm" id="almterbit" name="almterbit" placeholder="cth: makassar" style="text-transform: uppercase;">
                                                </div>
                                                <div class="col-12 col-sm-6 mb-3">
                                                    <label for="vaksin" class="form-label">Vaksin</label>
                                                    <select required class="form-select form-select-sm" name="vaksin" id="vaksin">
                                                        <?php  
                                                            $jkOpt = array("YA","TIDAK");
                                                            foreach($jkOpt as $opt){
                                                        ?>
                                                        <option value="<?= $opt ?>"><?= $opt ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($is_diskon != "GRATIS DP & PELUNASAN"){ ?>
                                            <div class="border rounded p-3 mb-2">
                                                <h1 class="card-title">Pembayaran</h1>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-12 col-sm-6 mb-3">
                                                        <label for="pembayaran" class="form-label">Paket Pembayaran</label>
                                                        <select required name="pembayaran" id="pembayaran" class="form-select form-select-sm">
                                                            <option value="">--PILIH PAKET PEMBAYARAN--</option>
                                                            <?= optPembayranPelunasan() ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-sm-6 mb-3">
                                                        <label for="rek" class="form-label">Rekening Tujuan</label>
                                                        <select required name="rek" id="rek" class="form-select form-select-sm">
                                                            <option value="">--PILIH REKENING TUJUAN--</option>
                                                            <?= optRekTujuan() ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-sm-12">
                                                        <label for="buktiTf" class="form-label">Bukti Transfer</label>
                                                        <input required type="file" name="buktiTf" id="buktiTf" class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button type="submit" name="lunasiPembayaran" class="btn btn-primary btn-sm">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } ?>

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
<?php $_SESSION['alertError'] = ""; $_SESSION['alertSuccess'] = ""; ?>
<?php
    include "apiDB.php"; // DB
    include "func/formatInput.php"; // FUNCTION
    include "config/userLogin.php"; // USER LOGIN
    include "config/orderPaketConfig.php"; // STATUS ORDER
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>REGISTRASI | NRJ TOUR</title>
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

    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script>
        $( document ).ready(function() {
            $.ajax({
                type:'post',
                url:'dataAjaxSQL/prov.php',
                success:function(hasil_prv){
                $("select[name=prov]").html(hasil_prv);
                }
            });
        });
        function viewKab() {
            var str = $("select#prov option:selected").attr("id");
            $.ajax({
                type:'post',
                url:'dataAjaxSQL/kabkota?prov_id='+str,
                success:function(hasil_kab){
                    $("select[name=kabkota]").html(hasil_kab);
                }
            })
        }
        function viewKec() {
            var str = $("select#kabkota option:selected").attr("id");
            $.ajax({
                type:'post',
                url:'dataAjaxSQL/kec?kabkota_id='+str,
                success:function(hasil_kab){
                    $("select[name=kec]").html(hasil_kab);
                }
            })
        }
    </script>

    <style>
        .hidden {
            display: none;
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
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Registrasi</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">NRJ Tour</a></li>
                                        <li class="breadcrumb-item active">Registrasi</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php if(!isset($_POST['submitPin']) && !isset($_GET['usePoin'])){ ?>
                    <div class="row">
                        <div class="col-12 col-sm-4 mx-auto">
                            <form action="" method="post" class="card">
                                <div class="card-body">
                                    <h1 class="card-title">Pin Berbayar / Free</h1>
                                    <hr>
                                    <div class="mb-2">
                                        <input type="text" name="pin" id="pin" class="form-control" placeholder="Masukkan pin anda" style="text-transform: uppercase;">
                                        <p style="font-size: 0.6rem;"><strong>*untuk melakukan pembelian paket umroh / haji anda harus memiliki pin yang dibuat oleh admin.</strong></p>
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
                            <div class="col-12 col-sm-8 mx-auto">
                                <form action="" method="post" enctype="multipart/form-data" class="card">
                                    <input type="hidden" name="ketDis" value="<?= $ketDis ?>">
                                    <input type="hidden" name="pinvALID" value="<?= $pinInput ?>">
                                    <div class="card-body">
                                        <?php if($ketDis != "DISKON 100%" && $ketDis != "DISKON DP"){ ?>
                                        <!-- ===================== START INFORMASI PEMBAYARAN ===================== -->
                                            <div class="border rounded p-3 mb-2">
                                                <h1 class="card-title">Pembayaran</h1>
                                                <hr>
                                                <div class="row">
                                                    <div id="kategoriPembayaran" class="col-12 col-sm-6 mb-3">
                                                        <label for="category" class="form-label">Kategori</label>
                                                        <select required name="category" id="category" class="form-select form-select-sm">
                                                            <option value="">--PILIH KATEGORI PEMBAYARAN--</option>
                                                            <?= optPembayranDP() ?>
                                                        </select>
                                                    </div>
                                                    <div id="kategoriRek" class="col-12 col-sm-6 mb-3">
                                                        <label for="rek" class="form-label">Rekening Tujuan</label>
                                                        <select required name="rek" id="rek" class="form-select form-select-sm">
                                                            <option value="">--PILIH REKENING TUJUAN--</option>
                                                            <?= optRekTujuan() ?>
                                                        </select>
                                                    </div>
                                                    <div id="kategoriBuktiTf" class="col-12 col-sm-12">
                                                        <label for="buktiTf" class="form-label">Bukti Transfer</label>
                                                        <input required type="file" name="buktiTf" id="buktiTf" class="form-control form-control-sm">
                                                    </div>
                                                </div>

                                            </div>
                                        <!-- END INFORMASI PEMBAYARAN -->
                                        <?php } ?>

                                        <?php if($ketDis != "DISKON 100%"){ ?>
                                        <!-- ===================== START AKUN KONSULTAN ===================== -->
                                            <div class="border rounded p-3 mb-2">
                                                <h1 class="card-title">Akun Konsultan</h1>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-12 col-sm-6 mb-3">
                                                        <label for="namakonsultan" class="form-label">Username</label>
                                                        <input required type="text" class="form-control form-control-sm" id="namakonsultan" name="namakonsultan" value="<?= $namakonsultan ?>" placeholder="cth: dodi77">
                                                    </div>
                                                    <div class="col-12 col-sm-6 mb-3">
                                                        <label for="emailkonsultan" class="form-label">Email</label>
                                                        <input required type="email" class="form-control form-control-sm" id="emailkonsultan" name="emailkonsultan" value="<?= $emailkonsultan ?>" placeholder="cth: cth@mail.com">
                                                    </div>
                                                    <div class="col-12 col-sm-6 mb-3">
                                                        <label for="nowakonsultan" class="form-label">No. WhatsApp (+62)</label>
                                                        <input required type="number" class="form-control form-control-sm" id="nowakonsultan" name="nowakonsultan" value="<?= $nowakonsultan ?>" placeholder="cth: 0877xxxxxx">
                                                    </div>
                                                    <div class="col-12 col-sm-6 mb-3">
                                                        <label for="passkonsultan" class="form-label">Password</label>
                                                        <input required type="password" class="form-control form-control-sm" id="passkonsultan" name="passkonsultan" value="<?= $passkonsultan ?>" placeholder="Masukkan Password">
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- END AKUN KONSULTAN -->
                                        <?php } ?>

                                        <!-- ===================== START DATA JAMAAH ===================== -->
                                            <div class="border rounded p-3 mb-2">
                                                <h1 class="card-title">Data Jamaah</h1>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-12 col-sm-12 mb-3">
                                                        <label for="fotoktp" class="form-label">Foto KTP</label>
                                                        <input required type="file" class="form-control form-control-sm" accept="" id="fotoKtp" name="fotoKtp" >
                                                    </div>
                                                    <div class="col-12 col-sm-6 mb-3">
                                                        <label for="nikktp" class="form-label">Nomor Induk Kependudukan (NIK)</label>
                                                        <input required type="number" class="form-control form-control-sm" id="nikktp" name="nikktp" placeholder="cth: 7371xxxxxxxxxxxxx">
                                                    </div>
                                                    <div class="col-12 col-sm-6 mb-3">
                                                        <label for="namaktp" class="form-label">Nama Sesuai KTP</label>
                                                        <input required type="text" class="form-control form-control-sm" id="namaktp" name="namaktp" placeholder="cth: Ahmad Suhendra">
                                                    </div>
                                                    <div class="col-12 col-sm-3 mb-3">
                                                        <label for="tempatlahir" class="form-label">Tempat Lahir</label>
                                                        <input required type="text" class="form-control form-control-sm" id="tempatlahir" name="tempatlahir" placeholder="cth: Ujung Pandang">
                                                    </div>
                                                    <div class="col-12 col-sm-3 mb-3">
                                                        <label for="tgllahir" class="form-label">Tanggal Lahir</label>
                                                        <input required type="date" class="form-control form-control-sm" id="tgllahir" name="tgllahir">
                                                    </div>
                                                    <div class="col-12 col-sm-3 mb-3">
                                                        <label for="jk" class="form-label">Jenis Kelamin</label>
                                                        <select required class="form-select form-select-sm" name="jk" id="jk">
                                                            <option value="">--PILIH JENIS KELAMIN--</option>
                                                            <?php  
                                                                $jkOpt = array("Laki-laki","Perempuan");
                                                                foreach($jkOpt as $opt){
                                                            ?>
                                                            <option value="<?= $opt ?>"><?= $opt ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-sm-3 mb-3">
                                                        <label for="statusperkawinan" class="form-label">Status Perkawinan</label>
                                                        <select required class="form-select form-select-sm" name="statusperkawinan" id="statusperkawinan">
                                                            <option value="">--PILIH STATUS PERKAWINAN--</option>
                                                            <?php  
                                                                $jkOpt = array("Belum Kawin","Sudah Kawin","Cerai Hidup","Cerai Mati");
                                                                foreach($jkOpt as $opt){
                                                            ?>
                                                            <option value="<?= $opt ?>"><?= $opt ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <h1 class="card-title">Alamat Jamaah</h1>
                                                    <hr>
                                                    <div class="col-12 col-sm-4 mb-3">
                                                        <label for="prov" class="form-label">Provinsi</label>
                                                        <select required required class="form-select form-select-sm" name="prov" id="prov" onchange="viewKab()">
                                                            <option value="">--PILIH PROVINSI--</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-sm-4 mb-3">
                                                        <label for="kabkota" class="form-label">Kab/Kota</label>
                                                        <select required class="form-select form-select-sm" name="kabkota" id="kabkota" onchange="viewKec()">
                                                            <option value="">--PILIH KAB / KOTA--</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-sm-4 mb-3">
                                                        <label for="kec" class="form-label">Kecamatan</label>
                                                        <select required class="form-select form-select-sm" name="kec" id="kec">
                                                            <option value="">--PILIH KECAMATAN--</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-sm-12">
                                                        <label for="detailalamat" class="form-label">Detail Alamat</label>
                                                        <textarea required name="detailalamat" id="detailalamat" rows="3" class="form-control form-control-sm" placeholder="cth: Jl Rajawali Lr.4"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- END DATA JAMAAH -->
                                        
                                        
                                    </div>
                                    <div class="card-footer text-end">
                                        <button type="submit" name="createOrder" class="btn btn-primary btn-sm">Submit</button>
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
<?php
    include "apiDB.php"; // DB
    include "func/formatInput.php"; // FUNCTION
    include "config/userLogin.php"; // USER LOGIN
    include "config/editJamaahConfig.php"; // STATUS ORDER
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>EDIT JAMAAH | NRJ TOUR</title>
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
                                <h4 class="mb-sm-0">Edit Jamaah</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">NRJ Tour</a></li>
                                        <li class="breadcrumb-item active">Edit Jamaah</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-8 mx-auto">
                            <form action="" method="post" enctype="multipart/form-data" class="card">
                                <div class="card-body">
                                    <!-- ===================== START DATA JAMAAH ===================== -->
                                        <div class="border rounded p-3 mb-2">
                                            <h1 class="card-title">Data Jamaah</h1>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12 col-sm-12 mb-3">
                                                    <label for="fotoktp" class="form-label">Foto KTP</label>
                                                    <input type="file" class="form-control form-control-sm" accept="" id="fotoKtp" name="fotoKtp" >
                                                </div>
                                                <div class="col-12 col-sm-6 mb-3">
                                                    <label for="nikktp" class="form-label">Nomor Induk Kependudukan (NIK)</label>
                                                    <input required type="number" class="form-control form-control-sm" id="nikktp" name="nikktp" placeholder="cth: 7371xxxxxxxxxxxxx" value="<?= dataJamaah($idOrder)['nik'] ?>">
                                                </div>
                                                <div class="col-12 col-sm-6 mb-3">
                                                    <label for="namaktp" class="form-label">Nama Sesuai KTP</label>
                                                    <input required type="text" class="form-control form-control-sm" id="namaktp" name="namaktp" placeholder="cth: Ahmad Suhendra" value="<?= dataJamaah($idOrder)['nama'] ?>">
                                                </div>
                                                <div class="col-12 col-sm-3 mb-3">
                                                    <label for="tempatlahir" class="form-label">Tempat Lahir</label>
                                                    <input required type="text" class="form-control form-control-sm" id="tempatlahir" name="tempatlahir" placeholder="cth: Ujung Pandang" value="<?= dataJamaah($idOrder)['tempat_lahir'] ?>">
                                                </div>
                                                <div class="col-12 col-sm-3 mb-3">
                                                    <label for="tgllahir" class="form-label">Tanggal Lahir</label>
                                                    <input required type="date" class="form-control form-control-sm" id="tgllahir" name="tgllahir" value="<?= dataJamaah($idOrder)['tgl_lahir'] ?>">
                                                </div>
                                                <div class="col-12 col-sm-3 mb-3">
                                                    <label for="jk" class="form-label">Jenis Kelamin</label>
                                                    <select required class="form-select form-select-sm" name="jk" id="jk">
                                                        <option value="">--PILIH JENIS KELAMIN--</option>
                                                        <?php  
                                                            $jkOpt = array("Laki-laki","Perempuan");
                                                            foreach($jkOpt as $opt){
                                                                $selected = $opt == dataJamaah($idOrder)['jk'] ? 'selected="selected"' : '';
                                                        ?>
                                                        <option value="<?= $opt ?>" <?= $selected ?>><?= $opt ?></option>
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
                                                                $selected = $opt == dataJamaah($idOrder)['status_perkawinan'] ? 'selected="selected"' : '';
                                                        ?>
                                                        <option value="<?= $opt ?>" <?= $selected ?>><?= $opt ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <h1 class="card-title">Alamat Jamaah</h1>
                                                <hr>
                                                <div class="col-12 col-sm-4 mb-3">
                                                    <label for="prov" class="form-label">Provinsi</label>
                                                    <select required required class="form-select form-select-sm" name="prov" id="prov" onchange="viewKab()">
                                                        <?= dataProv($idOrder) ?>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-sm-4 mb-3">
                                                    <label for="kabkota" class="form-label">Kab/Kota</label>
                                                    <select required class="form-select form-select-sm" name="kabkota" id="kabkota" onchange="viewKec()">
                                                        <?= dataKab($idOrder) ?>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-sm-4 mb-3">
                                                    <label for="kec" class="form-label">Kecamatan</label>
                                                    <select required class="form-select form-select-sm" name="kec" id="kec">
                                                        <?= dataKec($idOrder) ?>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-sm-12">
                                                    <label for="detailalamat" class="form-label">Detail Alamat</label>
                                                    <textarea required name="detailalamat" id="detailalamat" rows="3" class="form-control form-control-sm" placeholder="cth: Jl Rajawali Lr.4"><?= dataJamaah($idOrder)['detail_alamat'] ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- END DATA JAMAAH -->
                                    <!-- ===================== START DATA PELENGKAP ===================== -->
                                        <?php if(dataKelengkapan($idOrder)['nums'] > 0){ ?>
                                            <div class="border rounded p-3 mb-2">
                                                <h1 class="card-title">Umroh / Haji</h1>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-12 col-sm-12 mb-3">
                                                        <label for="tglbrg" class="form-label">Tanggal Keberangkatan</label>
                                                        <input required type="date" class="form-control form-control-sm" id="tglbrg" name="tglbrg" value="<?= dataJamaah($idOrder)['tgl_berangkat'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="border rounded p-3 mb-2">
                                                <h1 class="card-title">Data Paspor</h1>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-12 col-sm-12 mb-3">
                                                        <label for="nopaspor" class="form-label">Nomor Paspor</label>
                                                        <input required type="text" class="form-control form-control-sm" id="nopaspor" name="nopaspor" value="<?= dataKelengkapan($idOrder)['no_passport'] ?>" placeholder="cth: A0xxxxxxx" style="text-transform: uppercase;">
                                                    </div>
                                                    <div class="col-12 col-sm-6 mb-3">
                                                        <label for="tglterbit" class="form-label">Tanggal Terbit</label>
                                                        <input required type="date" class="form-control form-control-sm" id="tglterbit" name="tglterbit" value="<?= dataKelengkapan($idOrder)['tgl_terbit'] ?>">
                                                    </div>
                                                    <div class="col-12 col-sm-6 mb-3">
                                                        <label for="tglberlaku" class="form-label">Tanggal Berlaku</label>
                                                        <input required type="date" class="form-control form-control-sm" id="tglberlaku" name="tglberlaku" value="<?= dataKelengkapan($idOrder)['tgl_berlaku'] ?>">
                                                    </div>
                                                    <div class="col-12 col-sm-6 mb-3">
                                                        <label for="almterbit" class="form-label">Alamat Terbit</label>
                                                        <input required type="text" class="form-control form-control-sm" id="almterbit" name="almterbit" placeholder="cth: makassar" style="text-transform: uppercase;" value="<?= dataKelengkapan($idOrder)['alamat_terbit'] ?>">
                                                    </div>
                                                    <div class="col-12 col-sm-6 mb-3">
                                                        <label for="vaksin" class="form-label">Vaksin</label>
                                                        <select required class="form-select form-select-sm" name="vaksin" id="vaksin">
                                                            <?php  
                                                                $jkOpt = array("YA","TIDAK");
                                                                foreach($jkOpt as $opt){
                                                                    $selected = $opt == dataKelengkapan($idOrder)['is_vaksi'] ? 'selected="selected"' : '';
                                                            ?>
                                                                <option value="<?= $opt ?>" <?= $selected ?>><?= $opt ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <!-- END DATA PELENGKAP -->
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" name="editJamaah" class="btn btn-primary btn-sm">Submit</button>
                                </div>
                            </form>
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
    </script>
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
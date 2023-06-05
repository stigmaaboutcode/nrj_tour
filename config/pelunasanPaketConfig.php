<?php  
// $_SESSION['inputPeunasanNrj']

if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

if($role_user == "ADMIN"){
    header('Location: dasbor');
    exit();
}

$pinClass = new pinClass();
$dataBankClass = new dataBankClass();
$dataPenjualanClass = new dataPenjualanClass();
$dataKelengkapanJamaahClass = new dataKelengkapanJamaahClass();
$dataJamaahClass = new dataJamaahClass();
$hargaPelunasanClass = new hargaPelunasanClass();

$formatInputClass = new formatInputClass();
$dateNow = $formatInputClass->date()['dateNow'];

// CHECK URL DATA ORDER
if(!isset($_GET['idOrder'])){
    $_SESSION['alertError'] = "Pilih Orderan Paket.";
    header('Location: menunggu-pelunasan');
    exit();
}else{
    $idOrder = $_GET['idOrder'];
    $dataOrder = $dataPenjualanClass->selectDataPenjualan("oneCondition", "code_order", $idOrder);
    if($dataOrder['nums'] == 0){
        $_SESSION['alertError'] = "Data tidak ditemukan.";
        header('Location: menunggu-pelunasan');
        exit();
    }else{
        foreach($dataOrder['data'] as $row){
            $statusOrder = $row['status'];
            $categoryOrder = $row['category'];
            $perekrut = $row['perekrut'];
            $is_diskon = $row['is_diskon'];
        }
        if($statusOrder != "MENUNGGU PELUNASAN"){
            $_SESSION['alertError'] = "Data tidak ditemukan.";
            header('Location: menunggu-pelunasan');
            exit();
        }else{
            if($perekrut != $_SESSION['id_nrjtour']){
                $_SESSION['alertError'] = "Data tidak ditemukan.";
                header('Location: menunggu-pelunasan');
                exit();
            }
        }
    }
}

// VALIDATE PIN
if(isset($_POST['submitPin'])){
    $pinInput = strtoupper(trim($_POST['pin']));
    if($pinInput == ""){
        $_SESSION['alertError'] = "Pin tidak boleh kosong.";
        $_SESSION['inputPeunasanNrj'] = false;
    }else{
        $checkPinDp = $pinClass->selectPin("pinPelunasan",$pinInput,$dateNow,$_SESSION['id_nrjtour']);
        if($checkPinDp['nums'] > 0){
            $_SESSION['alertSuccess'] = "Success.";
            $_SESSION['inputPeunasanNrj'] = true;
        }else{
            $_SESSION['alertError'] = "Pin tidak berlaku.";
            $_SESSION['inputPeunasanNrj'] = false;
        }
    }
}

// SAVE PELUNASAN
if(isset($_POST['lunasiPembayaran'])){
    $nopaspor = strtoupper(trim($_POST['nopaspor']));
    $tglterbit = $_POST['tglterbit'];
    $tglberlaku = $_POST['tglberlaku'];
    $almterbit = strtoupper(trim($_POST['almterbit']));
    $vaksin = trim($_POST['vaksin']);

    $inputData = $dataKelengkapanJamaahClass->insertDataKelengkapanJamaah($idOrder,$nopaspor,$tglterbit,$tglberlaku,$almterbit,$vaksin);
    if($inputData){
        // DATA PEMBAYARAN
        $paket = "GRATIS";
        $hargaPelunasan = 0;
        $buktitfName = "GRATIS";
        if($is_diskon != "GRATIS DP & PELUNASAN"){
            // FOLDER
            $dir_bukti_tf = "assets/images/bukti_tf_umroh/";
            $fileNameTF = basename($_FILES["buktiTf"]["name"]);
            $targetFileTF = $dir_bukti_tf . $fileNameTF;
            $imageFileTypeTF = pathinfo($targetFileTF,PATHINFO_EXTENSION);
            // menghasilkan nama file yang unik
            $newFileNameTF = uniqid() . '.' . $imageFileTypeTF;
            $newTargetFileTF = $dir_bukti_tf . $newFileNameTF;
            move_uploaded_file($_FILES["buktiTf"]["tmp_name"], $newTargetFileTF);
            // DATA PEMBAYARAN
            $buktitfName = $newTargetFileTF;
            $kategoridanharga = explode(".",$_POST['pembayaran']);
            $hargaPelunasan = end($kategoridanharga);
            $paket = $kategoridanharga[0];
        }
        $updatePenjualan = $dataPenjualanClass->UpdateDataPenjualan("pelunasan","code_order",$idOrder,$paket,$hargaPelunasan,$buktitfName);
        if($updatePenjualan){
            $tglbrg = $_POST['tglbrg'];
            $updateJamaah = $dataJamaahClass->UpdateDataJamaah("tglKeberangkatan","code_order",$idOrder,$tglbrg);
            if($updateJamaah){
                $_SESSION['alertSuccess'] = "Data tersimpan.";
                header('Location: menunggu-pelunasan');
                exit();
            }
        }
    }
}

// OPTION PEMBAYARAN DP
function optPembayranPelunasan(){
    global $hargaPelunasanClass;

    $data = $hargaPelunasanClass->selectHargaPelunasan();

    foreach($data['data'] as $row){
        $reguler = $row['reguler'];
        $eksekutif = $row['eksekutif'];
        $ramadhan = $row['ramadhan'];
        $syawal = $row['syawal'];
    }
    echo '<option value="REGULER.' . $reguler . '">Reguler - Rp.' . number_format($reguler,0,",",".") . '</option>';
    echo '<option value="EKSEKUTIF.' . $eksekutif . '">Eksekutif - Rp.' . number_format($eksekutif,0,",",".") . '</option>';
    echo '<option value="RAMADHAN.' . $ramadhan . '">Ramadhan - Rp.' . number_format($ramadhan,0,",",".") . '</option>';
    echo '<option value="SYAWAL.' . $syawal . '">Syawal - Rp.' . number_format($syawal,0,",",".") . '</option>';
}

// REK ADMIN
function optRekTujuan(){
    global $dataBankClass;

    $data = $dataBankClass->selectDataBank("allData");

    foreach($data['data'] as $row){
        echo '<option value="">' . $row['nama_bank'] . ': ' . $row['atas_nama'] . ' (' . $row['no_rek'] . ')</option>';
    }
}
?>
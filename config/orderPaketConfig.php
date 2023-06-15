<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

if($role_user == "ADMIN"){
    header('Location: dasbor');
    exit();
}
$pinClass = new pinClass();
$hargaDpClass = new hargaDpClass();
$walletClass = new walletClass();
$dataPenjualanClass = new dataPenjualanClass();
$dataJamaahClass = new dataJamaahClass();
$dataBankClass = new dataBankClass();
$formatInputClass = new formatInputClass();
$dateNow = $formatInputClass->date()['dateNow'];
$dateTimeNow = $formatInputClass->date()['dateTimeNow'];

// DATA URL FOR DISKON POIN
$jumlahPoin = "Nothing";
if(isset($_GET['usePoin'])){
    $usePoin = $_GET['usePoin']; // DATA URL
    // PROBADI OR GRUP POIN
    if($usePoin == "ya"){
        // JUMLAH POIN
        $jumlahPoin = walletUser()['poin'];
        $ketDis = "DISKON 100%";
        // UNTUK POIN PRIBADI HARUS LEBIH DARI ATAU SAMA DENGAN 10 UNTUK DAPAT DIGUNAKAN 
        if($jumlahPoin < 10){
            $_SESSION['alertError'] = "Poin tidak cukup!";
            header('Location: dasbor');
            exit();
        }
    }else{
        header('Location: dasbor');
        exit();
    }
}

// VALIDATE PIN
if(isset($_POST['submitPin'])){
    $pinInput = strtoupper(trim($_POST['pin']));
    if($pinInput == ""){
        $_SESSION['alertError'] = "Pin tidak boleh kosong.";
        header('Location: order-paket');
        exit();
    }else{
        $checkPinBerbayar = $pinClass->selectPin("checkPIN",$_SESSION['id_nrjtour'],$pinInput,"PIN BERBAYAR");
        if($checkPinBerbayar['nums'] > 0){
            $ketDis = "BERBAYARAN";
            $_SESSION['alertSuccess'] = "Success.";
        }else{
            $checkPinFree = $pinClass->selectPin("checkPIN",$_SESSION['id_nrjtour'],$pinInput,"PIN FREE");
            if($checkPinFree['nums'] > 0){
                $ketDis = "DISKON DP";
                $_SESSION['alertSuccess'] = "Success.";
            }else{
                $_SESSION['alertError'] = "Pin tidak berlaku.";
                header('Location: order-paket');
                exit();
            }
        }
    }
}

// SAVE ORDER
if(isset($_POST['createOrder'])){
    // DATA PEMBAYARAN
    $isDiskon = "GRATIS DP & PELUNASAN";

    // AKUN CALON KONSULTAN
    $codeReferralKonsultan = $_SESSION['id_nrjtour'];
    $inputKonsultan = true;
    // TIDAK MENGGUNAKAN POIN
    if(!isset($_GET['usePoin'])){
        $getMakeKonsultan = true;
        // DATA CALON KONSULTAN
        $namakonsultan = strtolower(trim($_POST['namakonsultan']));
        $emailkonsultan = strtolower(trim($_POST['emailkonsultan']));
        $nowakonsultan = $formatInputClass->Notelpn(trim($_POST['nowakonsultan']));
        $passkonsultan = trim($_POST['passkonsultan']);
        // DATA PEMBAYARAN
        $isDiskon = $_POST['ketDis'] == "DISKON DP" ? "GRATIS DP" : "TIDAK ADA";
        if($getMakeKonsultan){
            $checkName = $userClass->selectUser("oneCondition","name",$namakonsultan);
            if($checkName['nums'] > 0){
                $inputKonsultan = false;
                $_SESSION['alertError'] = "Username sudah terdaftar.";
            }else{
                $checkEmail = $userClass->selectUser("oneCondition","email",$emailkonsultan);
                if($checkEmail['nums'] > 0){
                    $inputKonsultan = false;
                    $_SESSION['alertError'] = "Email sudah terdaftar.";
                }else{
                    $checkNoTelpn = $userClass->selectUser("oneCondition","no_telpn",$nowakonsultan);
                    if($checkNoTelpn['nums'] > 0){
                        $inputKonsultan = false;
                        $_SESSION['alertError'] = "No Telpn sudah terdaftar.";
                    }else{
                        $codeReferralKonsultan = generateRef();
                        $inputKonsultan = $userClass->insertUser($codeReferralKonsultan,$emailkonsultan,$namakonsultan,$nowakonsultan,password_hash($passkonsultan, PASSWORD_DEFAULT),$_SESSION['id_nrjtour'],$dateTimeNow);
                    }
        
                }
            }
        }
    }

    // INPUT PEMBELIAN PAKET
    if($inputKonsultan){
        $codeOrder = generateCodeOrder();
        // DATA PEMBAYARAN
        $buktitfName = "GRATIS";
        $hargaDp = 0;
        $kategori = "UMROH";

        // JIKA TIDAK ADA DISKON UPLOAD BUKTI TRANSFER
        if($isDiskon == "TIDAK ADA"){
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
            $kategoridanharga = explode(".",$_POST['category']);
            $hargaDp = end($kategoridanharga);
            $kategori = $kategoridanharga[0];
        }

        $inputPenjualanPaket = $dataPenjualanClass->insertDataPenjualan($codeOrder,$_SESSION['id_nrjtour'],$codeReferralKonsultan,$kategori,$isDiskon,$hargaDp,$buktitfName,$dateTimeNow);
        // INPUT DATA JAMAAH
        if($inputPenjualanPaket){
            // DATA JAMAAH
            $nikktp = preg_replace('/[^0-9]/','', trim($_POST['nikktp']));
            $namaKtp = ucwords(trim($_POST['namaktp']));
            $tempatlahir = ucwords(trim($_POST['tempatlahir']));
            $tgllahir = $_POST['tgllahir'];
            $jk = $_POST['jk'];
            $statusperkawinan = $_POST['statusperkawinan'];
            $prov = explode(".", $_POST['prov']);
            $kobkota = explode(".", $_POST['kabkota']);
            $kec = explode(".", $_POST['kec']);
            $detailalamat = $_POST['detailalamat'];

            // FOLDER
            $dir_foto_ktp = "assets/images/foto_ktp_jamaah/";
            $fileNameKTP = basename($_FILES["fotoKtp"]["name"]);
            $targetFileKTP = $dir_foto_ktp . $fileNameKTP;
            $imageFileTypeKTP = pathinfo($targetFileKTP,PATHINFO_EXTENSION);
            // menghasilkan nama file yang unik
            $newFileNameKTP = uniqid() . '.' . $imageFileTypeKTP;
            $newTargetFilektp = $dir_foto_ktp . $newFileNameKTP;
            move_uploaded_file($_FILES["fotoKtp"]["tmp_name"], $newTargetFilektp);
            $ktpName = $newTargetFilektp;

            $inputJamaah = $dataJamaahClass->insertDataJamaah($codeOrder,$ktpName,$nikktp,$namaKtp,$tempatlahir,$tgllahir,$detailalamat,$prov[1],$prov[0],$kobkota[1],$kobkota[0],$kec[1],$kec[0],$jk,$statusperkawinan);
            if($inputJamaah){
                if($isDiskon == "GRATIS DP & PELUNASAN"){
                    // PENGURANGAN SALDO POIN
                    $totalPoin = $jumlahPoin - 10;
                    $updateWallet = $walletClass->UpdateWallet("poin_balance",$totalPoin,$_SESSION['id_nrjtour']);
                    if($updateWallet){
                        $_SESSION['alertSuccess'] = "Data tersimpan.";
                        header('Location: order-paket');
                        exit();
                    }
                }else{
                    if($isDiskon == "GRATIS DP"){
                        $pinClass->UpdatePin($_SESSION['id_nrjtour'], $_POST['pinvALID'], "PIN FREE");
                    }else{
                        $pinClass->UpdatePin($_SESSION['id_nrjtour'], $_POST['pinvALID'], "PIN BERBAYAR");
                    }
                    $_SESSION['alertSuccess'] = "Data tersimpan.";
                    header('Location: order-paket');
                    exit();
                }

            }
        }
    }
}


function generateCodeOrder(){
    global $dateNow; // DATETIME NOW
    global $dataPenjualanClass; // CLASS DB PENJUALAN PAKE UMROH

    $dateNowArray = explode("-",$dateNow); // PISAH DATETIME
    $day = $dateNowArray[2]; $month = $dateNowArray[1]; $year = $dateNowArray[0]; // BERI VAR

    // GET DATA PENJUALAN PAKET WTH DATE
    $data = $dataPenjualanClass->selectDataPenjualan("dateUser", $_SESSION['id_nrjtour'], $dateNow, $dateNow);
    // CHECK DATA IF EXISTS
    if($data['nums'] == 0){
        $last_two_characters = substr($year, -2);
        $booking = $_SESSION['id_nrjtour'] . "-" . $day . $month . $last_two_characters . "001";
    }else{
        // SET DATA
        foreach($data['data'] as $row){
            $dbBooking = $row['code_order'];
        }
        $dbBookingDate = end(explode("-", $dbBooking));
        $order = $dbBookingDate + 1;
        if($day < 10){
            $booking = $_SESSION['id_nrjtour'] . "-0" . $order;
        }else{
            $booking = $_SESSION['id_nrjtour'] . "-" . $order;
        }
    }

    return $booking;
}

// CODE REFERRAL KONSULTAN
function generateRef(){
    global $userClass;
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $referralCode = '';
    for($i = 0; $i < 4; $i++) {
        $referralCode .= $characters[rand(0, strlen($characters) - 1)];
    }
    $referralCode = "NRJ" . $referralCode;
    $data = $userClass->selectUser("oneCondition","code_referral",$referralCode);
    if($data['nums'] > 0){
        return generateRef();
    }else{
        return $referralCode;
    }
}

// WALLET USER
function walletUser(){
    global $walletClass;

    $data = $walletClass->selectWallet($_SESSION['id_nrjtour']);
    foreach($data['data'] as $row){
        $result['poin'] = $row['poin_balance'];
        $result['bonus'] = $row['bonus_balance'];
    }

    return $result;
}

// OPTION PEMBAYARAN DP
function optPembayranDP(){
    global $hargaDpClass;

    $data = $hargaDpClass->selectHargaDp();

    foreach($data['data'] as $row){
        $umroh = $row['umroh'];
        $haji = $row['haji'];
    }
    echo '<option value="UMROH.' . $umroh . '">Umroh - Rp.' . number_format($umroh,0,",",".") . '</option>';
    echo '<option value="HAJI.' . $haji . '">Haji - Rp.' . number_format($haji,0,",",".") . '</option>';
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
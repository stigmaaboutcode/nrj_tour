<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

if($role_user == "ADMIN"){
    header('Location: dasbor');
    exit();
}

$dataBankUserClass = new dataBankUserClass();

if(isset($_POST['submit'])){
    $bankName = strtoupper(trim($_POST['bankName']));
    $accountName = ucwords(trim($_POST['accountName']));
    $accountNumber = preg_replace('/[^0-9]/','', trim($_POST['accountNumber']));

    // REQUIRED
    if($bankName == "" || $accountName == "" || $accountNumber == ""){
        $_SESSION['alertError'] = "Data tidak boleh kosong.";
    }else{
        $saveData = false;
        // CHECK FOR UPDTE OR INSERT
        if(dataBankUser()['nums'] > 0){
            $saveData = $dataBankUserClass->UpdateDataBankUser($_SESSION['id_nrjtour'],$bankName,$accountName,$accountNumber);
        }else{
            $saveData = $dataBankUserClass->insertDataBankUser($_SESSION['id_nrjtour'],$bankName,$accountName,$accountNumber);
        }
        if($saveData){
            $_SESSION['alertSuccess'] = "Data tersimpan.";
            header('Location: akun-bank-user');
            exit();
        }
    }
}

// DATA BANK
function dataBankUser(){
    global $dataBankUserClass;
    $data = $dataBankUserClass->selectDataBankUser($_SESSION['id_nrjtour']);
    foreach($data['data'] as $row){
        $result['nama_bank'] = $row['nama_bank'];
        $result['atas_nama'] = $row['atas_nama'];
        $result['no_rek'] = $row['no_rek'];
    }
    $result['nums'] = $data['nums'];

    return $result;
}

?>
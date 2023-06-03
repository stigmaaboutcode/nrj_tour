<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

$walletClass = new walletClass();
$withdrawClass = new withdrawClass();
$dataBankUserClass = new dataBankUserClass();
$formatInputClass = new formatInputClass();
$dateTimeNow = $formatInputClass->date()['dateTimeNow'];

// CREATE WALLET IF USER NOT ADMIN
if($role_user != "ADMIN"){
    // CHECK WALLET
    $checkWallet = $walletClass->selectWallet($_SESSION['id_nrjtour']);
    if($checkWallet['nums'] == 0){
        $createWallet = $walletClass->insertWallet($_SESSION['id_nrjtour']);
    }
}

if(isset($_POST['withdrawBonus'])){
    $nominal = preg_replace('/[^0-9]/','', trim($_POST['nominal']));

    if(walletUser()['bonus'] < $nominal){
        $_SESSION['alertError'] = "Saldo anda tidak cukup.";
        header('Location: dasbor');
        exit();
    }else{
        if(dataBankUser()['nums'] > 0){
            $totalBonus = walletUser()['bonus'] - $nominal;
            $updateWallet = $walletClass->UpdateWallet("bonus_balance",$totalBonus,$_SESSION['id_nrjtour']);
            if($updateWallet){
                $withdrawl = $withdrawClass->insertWithdraw($_SESSION['id_nrjtour'],$nominal,$dateTimeNow);
                if($withdrawl){
                    $_SESSION['alertSuccess'] = "Permintaan Withdraw sedang diproses.";
                    header('Location: dasbor');
                    exit();
                }
            }
        }else{
            $_SESSION['alertError'] = "Rekening Bank belum diatur.";
            header('Location: dasbor');
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
?>
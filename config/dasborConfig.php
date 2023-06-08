<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

$walletClass = new walletClass();
$withdrawClass = new withdrawClass();
$historyBonusPenjualanClass = new historyBonusPenjualanClass();
$dataPenjualanClass = new dataPenjualanClass();
$dataBankUserClass = new dataBankUserClass();
$historyBonusUplineClass = new historyBonusUplineClass();
$formatInputClass = new formatInputClass();
$dateTimeNow = $formatInputClass->date()['dateTimeNow'];

$from = $formatInputClass->date()['startMonth'];
$to = $formatInputClass->date()['endMonth'];

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

// REPORT PENJUALAN
function reportPenjualan($from, $to){
    global $dataPenjualanClass;
    global $role_user;
    $data = $dataPenjualanClass->selectDataPenjualan("dateKonsultan", $_SESSION['id_nrjtour'], $from, $to);
    if($role_user == "ADMIN"){
        $data = $dataPenjualanClass->selectDataPenjualan("date", $from, $to);
    }
    $result['jumlahDP'] = 0;
    $result['numDP'] = 0;
    $result['jumlahPelunasan'] = 0;
    $result['numPelunasan'] = 0;
    foreach($data['data'] as $row){
        if($row['status'] == "LUNAS"){
            $result['jumlahDP'] += $row['uang_muka'];
            $result['numDP'] += 1;
            $result['jumlahPelunasan'] += $row['uang_pelunasan'];
            $result['numPelunasan'] += 1;
        }elseif($row['status'] == "MENUNGGU PELUNASAN" || $row['status'] == "MENUNGGU KONFIRMASI PELUNASAN" || $row['status'] == "PELUNASAN DITOLAK"){
            $result['jumlahDP'] += $row['uang_muka'];
            $result['numDP'] += 1;
        }
    }
    return $result;
}

function totalBonus($from, $to){
    global $historyBonusPenjualanClass;
    $total = 0;
    $data = $historyBonusPenjualanClass->selectHistoryBonusPenjualan("byUser", $from, $to, $_SESSION['id_nrjtour']);
    foreach($data['data'] as $row){
        $total += $row['nominal'];
    }
    echo number_format($total,0,",",".");
}

function totalBonusMatching($from, $to){
    global $historyBonusUplineClass;
    $total = 0;
    $data = $historyBonusUplineClass->selectHistoryBonusUpline("byUser", $from, $to, $_SESSION['id_nrjtour']);
    foreach($data['data'] as $row){
        $total += $row['nominal'];
    }
    echo number_format($total,0,",",".");
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
<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

if($role_user == "ADMIN"){
    header('Location: dasbor');
    exit();
}

$walletClass = new walletClass();

// BELI POIN
if(isset($_POST['beli'])){
    $jumlahPoin = preg_replace('/[^0-9]/','', trim($_POST['poin']));
    $hargaPoin = 2000000;

    $totalHarga = $hargaPoin * $jumlahPoin;
    // CHECK JIKA SALDO BONUS CUKUP
    if(walletUser()['bonus'] < $totalHarga){
        $_SESSION['alertError'] = "Saldo bonus anda tidak cukup!";
    }else{
        // saldo bonus
        $totalSaldoBonus = walletUser()['bonus'] - $totalHarga;
        $walletClass->UpdateWallet("bonus_balance",$totalSaldoBonus,$_SESSION['id_nrjtour']);
        // saldo poin
        $totalSaldoPoin = walletUser()['poin'] + $jumlahPoin;
        $walletClass->UpdateWallet("poin_balance",$totalSaldoPoin,$_SESSION['id_nrjtour']);
        $_SESSION['alertSuccess'] = "Penambahan " . $jumlahPoin . " Poin!";
        header('Location: tukar-bonus-dan-poin');
        exit();
    }
}
// BELI POIN
if(isset($_POST['jual'])){
    $jumlahPoin = preg_replace('/[^0-9]/','', trim($_POST['poin']));
    $hargaPoin = 2000000;

    $totalHarga = $hargaPoin * $jumlahPoin;
    // CHECK JIKA SALDO BONUS CUKUP
    if(walletUser()['poin'] < $jumlahPoin){
        $_SESSION['alertError'] = "Saldo poin anda tidak cukup!";
    }else{
        // saldo poin
        $totalSaldoPoin = walletUser()['poin'] - $jumlahPoin;
        $walletClass->UpdateWallet("poin_balance",$totalSaldoPoin,$_SESSION['id_nrjtour']);
        // saldo bonus
        $totalSaldoBonus = walletUser()['bonus'] + $totalHarga;
        $walletClass->UpdateWallet("bonus_balance",$totalSaldoBonus,$_SESSION['id_nrjtour']);
        $_SESSION['alertSuccess'] = "Pengurangan " . $jumlahPoin . " Poin!";
        header('Location: tukar-bonus-dan-poin');
        exit();
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
?>
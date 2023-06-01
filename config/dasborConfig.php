<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

$walletClass = new walletClass();

// CREATE WALLET IF USER NOT ADMIN
if($role_user != "ADMIN"){
    // CHECK WALLET
    $checkWallet = $walletClass->selectWallet($_SESSION['id_nrjtour']);
    if($checkWallet['nums'] == 0){
        $createWallet = $walletClass->insertWallet($_SESSION['id_nrjtour']);
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
<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

$withdrawClass = new withdrawClass();
$dataBankUserClass = new dataBankUserClass();

// DATA TABLE
function dataTable(){
    global $withdrawClass;
    global $role_user;
    $num = 1;
    $data = $withdrawClass->selectWithdraw("oneCondition", "code_referral", $_SESSION['id_nrjtour']);
    if($role_user == "ADMIN"){
        $data = $withdrawClass->selectWithdraw("all");
    }
    foreach($data['data'] as $row){
        $fee = number_format($row['nominal'],0,",",".");
        echo '<tr>
                <th> ' . $num++ . ' </th>';
        if($role_user == "ADMIN"){
            echo '<td>
                    <strong>' . dataUser($row['code_referral'])['name'] . ' (' . $row['code_referral'] . ')</strong><br>
                    <i>' . dataUser($row['code_referral'])['email'] . '</i><br> 
                    <i>+62' . dataUser($row['code_referral'])['no_telpn'] . '</i><a href="https://api.whatsapp.com/send?phone=62' . dataUser($row['code_referral'])['no_telpn'] . '" class="btn btn-sm text-success radius-5"><i class="mx-auto ri-whatsapp-line"></i></a><br>
                </td>
                <td>
                    ' . dataBankUser($row['code_referral'])['atas_nama'] . '<br>
                    ' . dataBankUser($row['code_referral'])['no_rek'] . '<br>
                    ' . dataBankUser($row['code_referral'])['nama_bank'] . '
                </td>';
        }
        echo   '<td>' . $fee . '</td>
                <td>' . colorStatus($row['status']) . '</td>
                <td>' . $row['date'] . '</td>
            </tr>';
    }
}

// COLOR STATUS
function colorStatus($txt){
    if($txt == "PENDING"){
        return '<span class="badge rounded-pill alert-warning">' . $txt . '</span>';
    }elseif($txt == "DITOLAK"){
        return '<span class="badge rounded-pill alert-danger">' . $txt . '</span>';
    }else{
        return '<span class="badge rounded-pill alert-success">' . $txt . '</span>';
    }
}

// DATA BANK
function dataBankUser($user){
    global $dataBankUserClass;
    $data = $dataBankUserClass->selectDataBankUser($user);
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

// DATA USER
function dataUser($idUser){
    global $userClass;
    $data = $userClass->selectUser("oneCondition","code_referral",$idUser);
    foreach($data['data'] as $row){
        $result['name'] = $row['name'];
        $result['email'] = $row['email'];
        $result['no_telpn'] = $row['no_telpn'];
        $result['status'] = $row['status'];
    }
    $result['nums'] = $data['nums'];
    return $result;
}
?>
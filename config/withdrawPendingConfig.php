<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

if($role_user != "ADMIN"){
    header('Location: dasbor');
    exit();
}

$withdrawClass = new withdrawClass();
$walletClass = new walletClass();
$dataBankUserClass = new dataBankUserClass();

if(isset($_GET['id']) && isset($_GET['param'])){
    $idWd = $_GET['id'];
    $param = $_GET['param'];

    $checkWD = $withdrawClass->selectWithdraw("oneCondition", "id", $idWd);
    if($checkWD['nums'] > 0){
        foreach($checkWD['data'] as $row){
            $statusWd = $row['status'];
            $userWd = $row['code_referral'];
            $nominalWd = $row['nominal'];
        }
        if($statusWd == "PENDING"){
            if($param == "tolak"){
                $totalBonus = walletUser($userWd)['bonus'] + $nominalWd;
                $updateWallet = $walletClass->UpdateWallet("bonus_balance",$totalBonus,$userWd);
                if($updateWallet){
                    $updateWD = $withdrawClass->UpdateWithdraw($idWd,"DITOLAK");
                    if($updateWD){
                        $_SESSION['alertSuccess'] = "Data berhasil diubah.";
                        header('Location: withdraw-pending');
                        exit();
                    }
                }
            }elseif($param == "konfir"){
                $updateWD = $withdrawClass->UpdateWithdraw($idWd,"SUCCESS");
                if($updateWD){
                    $_SESSION['alertSuccess'] = "Data berhasil diubah.";
                    header('Location: withdraw-pending');
                    exit();
                }
            }
        }else{
            $_SESSION['alertError'] = "Data tidak ditemukan.";
            header('Location: withdraw-pending');
            exit();
        }
    }else{
        $_SESSION['alertError'] = "Data tidak ditemukan.";
        header('Location: withdraw-pending');
        exit();
    }

}

// DATA TABLE
function dataTable(){
    global $withdrawClass;
    $num = 1;
    $data = $withdrawClass->selectWithdraw("all");
    foreach($data['data'] as $row){
        if($row['status'] == "PENDING"){
            $fee = number_format($row['nominal'],0,",",".");
            echo '<tr>
                    <th> ' . $num++ . ' </th>
                <td>
                    <strong>' . dataUser($row['code_referral'])['name'] . ' (' . $row['code_referral'] . ')</strong><br>
                    <i>' . dataUser($row['code_referral'])['email'] . '</i><br> 
                    <i>+62' . dataUser($row['code_referral'])['no_telpn'] . '</i><a href="https://api.whatsapp.com/send?phone=62' . dataUser($row['code_referral'])['no_telpn'] . '" class="btn btn-sm text-success radius-5"><i class="mx-auto ri-whatsapp-line"></i></a><br>
                </td>
                <td>
                    ' . dataBankUser($row['code_referral'])['atas_nama'] . '<br>
                    ' . dataBankUser($row['code_referral'])['no_rek'] . '<br>
                    ' . dataBankUser($row['code_referral'])['nama_bank'] . '
                </td>
                <td>' . $fee . '</td>
                <td>' . colorStatus($row['status']) . '</td>
                <td>' . $row['date'] . '</td>
                <td>
                    <a href="withdraw-pending?id=' . $row['id'] . '&param=konfir" class="btn btn-sm btn-success"><i class="mx-auto ri-check-line"></i></a>
                    <a href="withdraw-pending?id=' . $row['id'] . '&param=tolak" class="btn btn-sm btn-danger"><i class="mx-auto  ri-close-line"></i></a>
                </td>
            </tr>';
        }
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

// WALLET USER
function walletUser($id){
    global $walletClass;

    $data = $walletClass->selectWallet($id);
    foreach($data['data'] as $row){
        $result['poin'] = $row['poin_balance'];
        $result['bonus'] = $row['bonus_balance'];
    }

    return $result;
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
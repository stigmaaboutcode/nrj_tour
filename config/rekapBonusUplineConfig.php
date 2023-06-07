<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

if($role_user != "ADMIN"){
    header('Location: dasbor');
    exit();
}

$historyBonusUplineClass = new historyBonusUplineClass();
$dataBankUserClass = new dataBankUserClass();
$formatInputClass = new formatInputClass();
$startMonth = $formatInputClass->date()['dateNow'];
$endMonth = $formatInputClass->date()['dateNow'];
$userID = "all";

//  SORTIR DATA
if(isset($_POST['sortir'])){
    $startMonth = $_POST['from'];
    $endMonth = $_POST['to'];
    $userID = $_POST['konsultan'];
}


// DATA TABLE
function dataTable($from, $to){
    global $historyBonusUplineClass;
    global $userClass;
    $num = 1;
    $dataKonsultan = $userClass->selectUser("oneCondition","role_user","KONSULTAN");
    foreach($dataKonsultan['data'] as $row){
        if($row['status'] == "AKTIF"){
            $data = $historyBonusUplineClass->selectHistoryBonusUpline("byUser", $from, $to, $row['code_referral']);
            if($data['nums'] > 0){
                $total = 0;
                foreach($data['data'] as $rows){
                    $total += $rows['nominal'];
                }
                echo '<tr>
                        <th> ' . $num++ . ' </th>
                        <td>
                            <strong>' . $row['name'] . ' (' . $row['code_referral'] . ')</strong><br>
                            <i>' . $row['email'] . '</i><br> 
                            <i>+62' . $row['no_telpn'] . '</i><a href="https://api.whatsapp.com/send?phone=62' . $row['no_telpn'] . '" class="btn btn-sm text-success radius-5"><i class="mx-auto ri-whatsapp-line"></i></a><br>
                        </td>
                        <td>
                            ' . dataBankUser($row['code_referral'])['atas_nama'] . '<br>
                            ' . dataBankUser($row['code_referral'])['no_rek'] . '<br>
                            ' . dataBankUser($row['code_referral'])['nama_bank'] . '
                        </td>
                        <td>Rp.' . number_format($total,0,",",".") . '</td>
                    </tr>';
            }
        }
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

function totalBonus($from, $to){
    global $userClass;
    global $historyBonusUplineClass;
    $dataKonsultan = $userClass->selectUser("oneCondition","role_user","KONSULTAN");
    foreach($dataKonsultan['data'] as $row){
        if($row['status'] == "AKTIF"){
            $data = $historyBonusUplineClass->selectHistoryBonusUpline("byUser", $from, $to, $row['code_referral']);
            if($data['nums'] > 0){
                $total = 0;
                foreach($data['data'] as $rows){
                    $total += $rows['nominal'];
                }
            }
        }
    }
    echo number_format($total,0,",",".");
}

// OPT USER 
function optUser($user){
    global $userClass;
    $data = $userClass->selectUser("oneCondition","role_user","KONSULTAN");
    foreach($data['data'] as $row){
        $selectd = $user == $row['code_referral'] ? 'selected="selected"' : '';
        echo '<option value="' . $row['code_referral'] . '" ' . $selectd . '>' . $row['name'] . '</option>';
    }
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
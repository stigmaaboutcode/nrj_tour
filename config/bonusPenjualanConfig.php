<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

$historyBonusPenjualanClass = new historyBonusPenjualanClass();
$formatInputClass = new formatInputClass();
$startMonth = $formatInputClass->date()['startMonth'];
$endMonth = $formatInputClass->date()['endMonth'];
$userID = $role_user == "ADMIN" ? "all" : $_SESSION['id_nrjtour'];

//  SORTIR DATA
if(isset($_POST['sortir'])){
    $startMonth = $_POST['from'];
    $endMonth = $_POST['to'];
    $userID = $role_user == "ADMIN" ? $_POST['konsultan'] : $_SESSION['id_nrjtour'];
}


// DATA TABLE
function dataTable($from, $to, $user){
    global $historyBonusPenjualanClass;
    global $role_user;
    $num = 1;
    $data = $historyBonusPenjualanClass->selectHistoryBonusPenjualan("byUser", $from, $to, $user);
    if($user == "all"){
        $data = $historyBonusPenjualanClass->selectHistoryBonusPenjualan("allData", $from, $to);
    }
    foreach($data['data'] as $row){
        $fee = number_format($row['nominal'],0,",",".");
        echo '<tr>
                <th> ' . $num++ . ' </th>
                <td> 
                    ' . $row['code_order'] . '
                </td>';
        if($role_user == "ADMIN"){
            echo '<td>
                    <strong>' . dataUser($row['code_referral'])['name'] . ' (' . $row['code_referral'] . ')</strong><br>
                    <i>' . dataUser($row['code_referral'])['email'] . '</i><br> 
                    <i>+62' . dataUser($row['code_referral'])['no_telpn'] . '</i><a href="https://api.whatsapp.com/send?phone=62' . dataUser($row['code_referral'])['no_telpn'] . '" class="btn btn-sm text-success radius-5"><i class="mx-auto ri-whatsapp-line"></i></a><br>
                </td>';
        }
        echo   '<td>' . $row['category'] . '</td>
                <td>Rp.' . $fee . '</td>
                <td>' . $row['date'] . '</td>
            </tr>';
    }
}

function totalBonus($from, $to, $user){
    global $historyBonusPenjualanClass;
    $total = 0;
    $data = $historyBonusPenjualanClass->selectHistoryBonusPenjualan("byUser", $from, $to, $user);
    if($user == "all"){
        $data = $historyBonusPenjualanClass->selectHistoryBonusPenjualan("allData", $from, $to);
    }
    foreach($data['data'] as $row){
        $total += $row['nominal'];
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
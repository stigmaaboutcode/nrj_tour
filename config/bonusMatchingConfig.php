<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

if($role_user == "ADMIN"){
    header('Location: dasbor');
    exit();
}

$historyBonusUplineClass = new historyBonusUplineClass();
$formatInputClass = new formatInputClass();
$startMonth = $formatInputClass->date()['startMonth'];
$endMonth = $formatInputClass->date()['endMonth'];

//  SORTIR DATA
if(isset($_POST['sortir'])){
    $startMonth = $_POST['from'];
    $endMonth = $_POST['to'];
}


// DATA TABLE
function dataTable($from, $to){
    global $historyBonusUplineClass;
    $num = 1;
    $data = $historyBonusUplineClass->selectHistoryBonusUpline("byUser", $from, $to, $_SESSION['id_nrjtour']);
    foreach($data['data'] as $row){
        $fee = number_format($row['nominal'],0,",",".");
        echo '<tr>
                <th> ' . $num++ . ' </th>
                <td> 
                    ' . $row['code_order'] . '
                </td>
                <td>' . $row['category'] . '</td>
                <td>Rp.' . $fee . '</td>
                <td>' . $row['date'] . '</td>
            </tr>';
    }
}

function totalBonus($from, $to){
    global $historyBonusUplineClass;
    $total = 0;
    $data = $historyBonusUplineClass->selectHistoryBonusUpline("byUser", $from, $to, $_SESSION['id_nrjtour']);
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
?>
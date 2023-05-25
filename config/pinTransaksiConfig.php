<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}
if($role_user != "ADMIN"){
    header('Location: pin-transaksi');
    exit();
}
$title = "Pin Transaksi";

$pinClass = new pinClass();
$formatInputClass = new formatInputClass();
$dateNow = $formatInputClass->date()['dateNow'];

if(isset($_POST['addPin'])){
    sleep(2);
    $totalCreatePin = 0;
    $getUser = $userClass->selectUser("oneCondition", "role_user", "KONSULTAN");
    foreach($getUser['data'] as $row){
        // CHECK PIN IF EXIST
        $pinCheck = $pinClass->selectPin("dataPinUser",$row['code_referral'],$dateNow);
        if($pinCheck['nums'] == 0){
            $insertPin = $pinClass->insertPin($row['code_referral'],pinDp(),pinPelunasan(),$dateNow);
            $totalCreatePin += 1;
        }
    }
    if($totalCreatePin > 0){
        $_SESSION['alertSuccess'] = "Pin Berhasil dibuat.";
        header('Location: pin-transaksi');
        exit();
    }else{
        $_SESSION['alertError'] = "Pin sudah tersedia.";
        header('Location: pin-transaksi');
        exit();
    }
}
// DATA TABLE
function dataTable(){
    global $userClass;
    global $role_user;
    $num = 1;
    $data = $userClass->selectUser("oneCondition", "role_user", "KONSULTAN");

    foreach($data['data'] as $row){
        echo '<tr>
                <th> ' . $num++ . ' </th>
                <td>
                    <strong>' . $row['name'] . '</strong><br>
                </td>
                <td> ' . dataPinUser($row['code_referral'])['dp'] . ' </td>
                <td> ' . dataPinUser($row['code_referral'])['pelunasan'] . ' </td>
            </tr>';
    }
}

// DATA PIN USER
function dataPinUser($user){
    global $pinClass;
    global $dateNow;

    $data = $pinClass->selectPin("dataPinUser", $user, $dateNow);

    if($data['nums'] == 0){
        $result['dp'] = '<span class="badge rounded-pill alert-danger">Belum ada</span>';
        $result['pelunasan'] = '<span class="badge rounded-pill alert-danger">Belum ada</span>';
    }else{
        foreach($data['data'] as $row){
            $result['dp'] = $row['pin_uang_muka'];
            $result['pelunasan'] = $row['pin_pelunasan'];
        }
    }
    return $result;
}

// GENERATE PIN
function generatePin() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $pin = '';
    
    for ($i = 0; $i < 12; $i++) {
        $pin .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $pin;
}

function pinDp(){
    global $dateNow;
    global $pinClass;
    $pin = generatePin();

    $dataPin = $pinClass->selectPin("pinUangMukaCheck",$pin,$dateNow);
    if($dataPin['nums'] > 0){
        return pinDp();
    }else{
        return $pin;
    }
}
function pinPelunasan(){
    global $dateNow;
    global $pinClass;
    $pin = generatePin();

    $dataPin = $pinClass->selectPin("pinPelunasanCheck",$pin,$dateNow);
    if($dataPin['nums'] > 0){
        return pinPelunasan();
    }else{
        return $pin;
    }
}
?>
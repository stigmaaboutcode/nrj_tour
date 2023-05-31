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
            $insertPin = $pinClass->insertPin($row['code_referral'],pinFree(),pinDp(),pinPelunasan(),$dateNow);
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
                <td> ' . dataPinUser($row['code_referral'])['free'] . ' </td>
                <td> ' . dataPinUser($row['code_referral'])['dp'] . ' </td>
                <td> ' . dataPinUser($row['code_referral'])['pelunasan'] . ' </td>
                <td> ' . dataPinUser($row['code_referral'])['tgl'] . ' </td>
            </tr>';
    }
}

// DATA PIN USER
function dataPinUser($user){
    global $pinClass;
    global $dateNow;

    $data = $pinClass->selectPin("dataPinUser", $user, $dateNow);

    if($data['nums'] == 0){
        $result['free'] = '<span class="badge rounded-pill alert-danger">Belum ada</span>';
        $result['dp'] = '<span class="badge rounded-pill alert-danger">Belum ada</span>';
        $result['pelunasan'] = '<span class="badge rounded-pill alert-danger">Belum ada</span>';
        $result['tgl'] = '-,-';
    }else{
        foreach($data['data'] as $row){
            $result['free'] = $row['pin_free'];
            $result['dp'] = $row['pin_uang_muka'];
            $result['pelunasan'] = $row['pin_pelunasan'];
            $result['tgl'] = ubahFormatTanggal($row['date_create']);
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

function pinFree(){
    global $dateNow;
    global $pinClass;
    $pin = generatePin();

    $dataPin = $pinClass->selectPin("pinFreeCheck",$pin,$dateNow);
    if($dataPin['nums'] > 0){
        return pinFree();
    }else{
        return $pin;
    }
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

function ubahFormatTanggal($tanggal){
    $bulan = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    );

    $tanggalArr = explode('-', $tanggal);
    if(intval($tanggalArr[2]) < 10){
        $tanggalBaru = '0' . intval($tanggalArr[2]) . ' ' . $bulan[intval($tanggalArr[1])] . ' ' . $tanggalArr[0];
    }else{
        $tanggalBaru = intval($tanggalArr[2]) . ' ' . $bulan[intval($tanggalArr[1])] . ' ' . $tanggalArr[0];
    }

    return $tanggalBaru;
}
?>
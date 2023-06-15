<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}
$title = "Pin Transaksi";

$pinClass = new pinClass();
$formatInputClass = new formatInputClass();
$dateNow = $formatInputClass->date()['dateNow'];

if(isset($_POST['addPin'])){
    $jumlahPIN = preg_replace('/[^0-9]/','', trim($_POST['jumlahPin']));
    if($jumlahPIN == ""){
        $_SESSION['alertError'] = "Masukkan Jumlah PIN.";
        header('Location: pin-transaksi');
        exit();
    }else{
        $konsultanID = $_POST['konsultan'];
        $pinFree = isset($_POST['pinFree']) ? true : false;
        $pinRegistrasi = isset($_POST['pinRegis']) ? true : false;
        $pinPelunasan = isset($_POST['pinPelunasan']) ? true : false;
        if($konsultanID != "ALL"){
            if($pinFree && $pinRegistrasi && $pinPelunasan){
                pinCreated($konsultanID,"PIN FREE",$jumlahPIN);
                pinCreated($konsultanID,"PIN BERBAYAR",$jumlahPIN);
                pinCreated($konsultanID,"PIN PELUNASAN",$jumlahPIN);
            }elseif($pinFree && $pinRegistrasi){
                pinCreated($konsultanID,"PIN FREE",$jumlahPIN);
                pinCreated($konsultanID,"PIN BERBAYAR",$jumlahPIN);
            }elseif($pinFree && $pinPelunasan){
                pinCreated($konsultanID,"PIN FREE",$jumlahPIN);
                pinCreated($konsultanID,"PIN PELUNASAN",$jumlahPIN);
            }elseif($pinRegistrasi && $pinPelunasan){
                pinCreated($konsultanID,"PIN BERBAYAR",$jumlahPIN);
                pinCreated($konsultanID,"PIN PELUNASAN",$jumlahPIN);
            }elseif($pinFree){
                pinCreated($konsultanID,"PIN FREE",$jumlahPIN);
            }elseif($pinRegistrasi){
                pinCreated($konsultanID,"PIN BERBAYAR",$jumlahPIN);
            }elseif($pinPelunasan){
                pinCreated($konsultanID,"PIN PELUNASAN",$jumlahPIN);
            }else{
                $_SESSION['alertError'] = "Pilih kategori.";
                header('Location: pin-transaksi');
                exit();
            }
        }else{
            $dataKonsultan = $userClass->selectUser("oneCondition","role_user","KONSULTAN");
            foreach($dataKonsultan['data'] as $rows){
                if($pinFree && $pinRegistrasi && $pinPelunasan){
                    pinCreated($rows['code_referral'],"PIN FREE",$jumlahPIN);
                    pinCreated($rows['code_referral'],"PIN BERBAYAR",$jumlahPIN);
                    pinCreated($rows['code_referral'],"PIN PELUNASAN",$jumlahPIN);
                }elseif($pinFree && $pinRegistrasi){
                    pinCreated($rows['code_referral'],"PIN FREE",$jumlahPIN);
                    pinCreated($rows['code_referral'],"PIN BERBAYAR",$jumlahPIN);
                }elseif($pinFree && $pinPelunasan){
                    pinCreated($rows['code_referral'],"PIN FREE",$jumlahPIN);
                    pinCreated($rows['code_referral'],"PIN PELUNASAN",$jumlahPIN);
                }elseif($pinRegistrasi && $pinPelunasan){
                    pinCreated($rows['code_referral'],"PIN BERBAYAR",$jumlahPIN);
                    pinCreated($rows['code_referral'],"PIN PELUNASAN",$jumlahPIN);
                }elseif($pinFree){
                    pinCreated($rows['code_referral'],"PIN FREE",$jumlahPIN);
                }elseif($pinRegistrasi){
                    pinCreated($rows['code_referral'],"PIN BERBAYAR",$jumlahPIN);
                }elseif($pinPelunasan){
                    pinCreated($rows['code_referral'],"PIN PELUNASAN",$jumlahPIN);
                }else{
                    break;
                    $_SESSION['alertError'] = "Pilih kategori.";
                    header('Location: pin-transaksi');
                    exit();
                }
            }
        }
        $_SESSION['alertSuccess'] = "Success.";
        header('Location: pin-transaksi');
        exit();
    }

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

// DATA PIN
function dataPinUser(){
    global $pinClass;
    global $role_user;
    $num = 1;
    if($role_user == "ADMIN"){
        $data = $pinClass->selectPin("aLL");
    }else{
        $data = $pinClass->selectPin("UserPin", $_SESSION['id_nrjtour']);
    }
    foreach($data['data'] as $row){
        $user = $role_user == "ADMIN" ? '<td> ' . dataUser($row['code_referral'])['name'] . ' </td>' : '';
        echo '<tr>
                <th> ' . $num++ . ' </th>
                ' . $user . '
                <td> ' . $row['pin'] . ' </td>
                <td> ' . $row['category'] . ' </td>
                <td> ' . statusPin($row['status']) . ' </td>
                <td> ' . ubahFormatTanggal($row['date_create']) . ' </td>
            </tr>';
    }
}

// CREATE PIN FREE
function pinCreated($user, $category, $jumlah){
    global $dateNow;
    global $pinClass;
    for($i = 0; $i < $jumlah; $i++){
        $pin = pinCheck($user);
        $pinClass->insertPin($user,$pin,$category,$dateNow);
    }
}

function pinCheck($user){
    global $pinClass;
    $pin = generatePin();

    $dataPin = $pinClass->selectPin("checkAndCreate",$user,$pin);
    if($dataPin['nums'] > 0){
        return pinCheck($user);
    }else{
        return $pin;
    }
}

// GENERATE PIN
function generatePin() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $pin = 'NRJ';
    
    for ($i = 0; $i < 9; $i++) {
        $pin .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $pin;
}

function statusPin($status){
    if($status == "BELUM DIGUNAKAN"){
        return '<span class="badge rounded-pill alert-success">' . $status . '</span>';
    }else{
        return '<span class="badge rounded-pill alert-danger">' . $status . '</span>';
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
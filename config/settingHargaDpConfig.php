<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

if($role_user != "ADMIN"){
    header('Location: dasbor');
    exit();
}

$hargaDpClass = new hargaDpClass();

if(isset($_POST['submit'])){
    $umrohDP = preg_replace('/[^0-9]/','', trim($_POST['umrohDP']));
    $HajiDP = preg_replace('/[^0-9]/','', trim($_POST['HajiDP']));

    if(($umrohDP == 0 || $umrohDP == "" ) || ($HajiDP == 0 || $HajiDP == "" )){
        $_SESSION['alertError'] = "Data tidak boleh kosong.";
    }else{
        $saveHarga = $hargaDpClass->UpdateHargaDp($umrohDP,$HajiDP);
        if($saveHarga){
            $_SESSION['alertSuccess'] = "Data tersimpan.";
            header('Location: setting-harga-dp');
            exit();
        }
    }
}

// DATA HARGA
function nominalHarga(){
    global $hargaDpClass;

    $data = $hargaDpClass->selectHargaDp();
    foreach($data['data'] as $row){
        $result['umroh'] = $row['umroh'];
        $result['haji'] = $row['haji'];
    }

    return $result;
}
?>
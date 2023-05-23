<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

if($role_user != "ADMIN"){
    header('Location: dasbor');
    exit();
}

$hargaPelunasanClass = new hargaPelunasanClass();

if(isset($_POST['submit'])){
    $hargaReguler = preg_replace('/[^0-9]/','', trim($_POST['hargaReguler']));
    $hargaEksekutif = preg_replace('/[^0-9]/','', trim($_POST['hargaEksekutif']));
    $hargaRamadhan = preg_replace('/[^0-9]/','', trim($_POST['hargaRamadhan']));
    $hargaSyawal = preg_replace('/[^0-9]/','', trim($_POST['hargaSyawal']));

    if(($hargaReguler == 0 || $hargaReguler == "" ) || ($hargaEksekutif == 0 || $hargaEksekutif == "" ) || ($hargaRamadhan == 0 || $hargaRamadhan == "" ) || ($hargaSyawal == 0 || $hargaSyawal == "" )){
        $_SESSION['alertError'] = "Data tidak boleh kosong.";
    }else{
        $saveHarga = $hargaPelunasanClass->UpdateHargaPelunasan($hargaReguler,$hargaEksekutif,$hargaRamadhan,$hargaSyawal);
        if($saveHarga){
            $_SESSION['alertSuccess'] = "Data tersimpan.";
            header('Location: setting-harga-pelunasan');
            exit();
        }
    }
}

// DATA HARGA
function nominalHarga(){
    global $hargaPelunasanClass;

    $data = $hargaPelunasanClass->selectHargaPelunasan();
    foreach($data['data'] as $row){
        $result['reguler'] = $row['reguler'];
        $result['eksekutif'] = $row['eksekutif'];
        $result['ramadhan'] = $row['ramadhan'];
        $result['syawal'] = $row['syawal'];
    }

    return $result;
}
?>
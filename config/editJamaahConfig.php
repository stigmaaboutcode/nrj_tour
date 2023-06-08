<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

if($role_user != "ADMIN"){
    header('Location: dasbor');
    exit();
}

// GET CLASS RAJA ONGKIR
$rajaOngkir = new rajaOngkir();
$dataJamaahClass = new dataJamaahClass();
$dataKelengkapanJamaahClass = new dataKelengkapanJamaahClass();
$dataPenjualanClass = new dataPenjualanClass();

// VALIDATE DATA 
$idOrder = $_GET['idOrder'];
if(!isset($_GET['idOrder'])){
    header('Location: penjualan-paket');
    exit();
}else{
    $checkData = $dataPenjualanClass->selectDataPenjualan("oneCondition", "code_order", $_GET['idOrder']);
    if($checkData['nums'] == 0){
        header('Location: penjualan-paket');
        exit();
    }
}

if(isset($_POST['editJamaah'])){
    // DATA JAMAAH
    $fotoKtp = $_FILES['fotoKtp'];
    $nikktp = preg_replace('/[^0-9]/','', trim($_POST['nikktp']));
    $namaKtp = ucwords(trim($_POST['namaktp']));
    $tempatlahir = ucwords(trim($_POST['tempatlahir']));
    $tgllahir = $_POST['tgllahir'];
    $jk = $_POST['jk'];
    $statusperkawinan = $_POST['statusperkawinan'];
    $prov = explode(".", $_POST['prov']);
    $kobkota = explode(".", $_POST['kabkota']);
    $kec = explode(".", $_POST['kec']);
    $detailalamat = $_POST['detailalamat'];
    $ktpName = dataJamaah($idOrder)['foto_ktp'];

    // JIKA ADA FILE BARU
    if(isset($fotoKtp) && $fotoKtp['error'] !== UPLOAD_ERR_NO_FILE){
        // DALETE OLD FILE
        if(unlink(dataJamaah($idOrder)['foto_ktp'])){
            // FOLDER
            $dir_foto_ktp = "assets/images/foto_ktp_jamaah/";
            $fileNameKTP = basename($_FILES["fotoKtp"]["name"]);
            $targetFileKTP = $dir_foto_ktp . $fileNameKTP;
            $imageFileTypeKTP = pathinfo($targetFileKTP,PATHINFO_EXTENSION);
            // menghasilkan nama file yang unik
            $newFileNameKTP = uniqid() . '.' . $imageFileTypeKTP;
            $newTargetFilektp = $dir_foto_ktp . $newFileNameKTP;
            move_uploaded_file($_FILES["fotoKtp"]["tmp_name"], $newTargetFilektp);
            $ktpName = $newTargetFilektp;
        }
    }
    // EDIT DATA JAMAAH
    $updateData = $dataJamaahClass->UpdateDataJamaah("allData","code_order",$idOrder,$ktpName,$nikktp,$namaKtp,$tempatlahir,$tgllahir,$detailalamat,$prov[1],$prov[0],$kobkota[1],$kobkota[0],$kec[1],$kec[0],$jk,$statusperkawinan);
    if($updateData){
        if(dataKelengkapan($idOrder)['nums'] > 0){
            $tglbrg = $_POST['tglbrg'];
            $updateTglBrng = $dataJamaahClass->UpdateDataJamaah("tglKeberangkatan","code_order",$idOrder,$tglbrg);
            if($updateTglBrng){
                $nopaspor = strtoupper(trim($_POST['nopaspor']));
                $tglterbit = $_POST['tglterbit'];
                $tglberlaku = $_POST['tglberlaku'];
                $almterbit = strtoupper(trim($_POST['almterbit']));
                $vaksin = trim($_POST['vaksin']);
                $updateDataKelengkapan = $dataKelengkapanJamaahClass->UpdateDataKelengkapanJamaah($idOrder,$nopaspor,$tglterbit,$tglberlaku,$almterbit,$vaksin);
                if($updateDataKelengkapan){
                    $_SESSION['alertSuccess'] = "Data tersimpan.";
                    header('Location: penjualan-paket');
                    exit();
                }
            }
        }else{
            $_SESSION['alertSuccess'] = "Data tersimpan.";
            header('Location: penjualan-paket');
            exit();
        }
    }
}

// DATA JAMAAH
function dataJamaah($codeOrder){
    global $dataJamaahClass;

    $data = $dataJamaahClass->selectDataJamaah("oneCondition","code_order",$codeOrder);
    foreach($data['data'] as $row){
        $result['foto_ktp'] = $row['foto_ktp'];
        $result['nik'] = $row['nik'];
        $result['nama'] = $row['nama'];
        $result['tempat_lahir'] = $row['tempat_lahir'];
        $result['tgl_lahir'] = $row['tgl_lahir'];
        $result['detail_alamat'] = $row['detail_alamat'];
        $result['id_prov'] = $row['id_prov'];
        $result['id_kab_kota'] = $row['id_kab_kota'];
        $result['id_kec'] = $row['id_kec'];
        $result['jk'] = $row['jk'];
        $result['status_perkawinan'] = $row['status_perkawinan'];
        $result['tgl_berangkat'] = $row['tgl_berangkat'];
    }
    return $result;
}

// OPT PROV
function dataProv($code){
    global $rajaOngkir;
    $data = $rajaOngkir->showProv();

    $provJamaah = dataJamaah($code)['id_prov'];

    if ($data == "error") {
        echo "cURL Error #:";
    } else {
        echo '<option value="">--PILIH PROVINSI--</option>';
    
        foreach($data as $index => $row){
            $selected = $provJamaah == $row['province_id'] ? 'selected="selected"' : '';
            echo "<option value='" . $row['province_id'] . "." . $row['province'] . "' id='" . $row['province_id'] . "'" . $selected . " >" . $row['province'] . "</option>";
        }
    }
}
// OPT KAB/ KOTA
function dataKab($code){
    global $rajaOngkir;
    
    $provJamaah = dataJamaah($code)['id_prov'];
    $data = $rajaOngkir->showKabKota($provJamaah);
    $kabJamaah = dataJamaah($code)['id_kab_kota'];

    if ($data == "error") {
        echo "cURL Error #:";
    } else {
        echo '<option value="">--PILIH KAB / KOTA--</option>';
    
        foreach($data as $index => $row){
            $selected = $kabJamaah == $row['city_id'] ? 'selected="selected"' : '';
            echo "<option value='" . $row['city_id'] . "." . $row['city_name'] . "' id='" . $row['city_id'] . "'" . $selected . ">" . $row['city_name'] . "</option>";
        }
    }
}
// OPT KEC
function dataKec($code){
    global $rajaOngkir;

    $kabJamaah = dataJamaah($code)['id_kab_kota'];
    $data = $rajaOngkir->showKec($kabJamaah);
    $kec = dataJamaah($code)['id_kec'];

    if ($data == "error") {
        echo "cURL Error #:";
    } else {
        echo '<option value="">--PILIH KECAMATAN--</option>';
    
        foreach($data as $index => $row){
            $selected = $kec == $row['subdistrict_id'] ? 'selected="selected"' : '';
            echo "<option value='" . $row['subdistrict_id'] . "." . $row['subdistrict_name'] . "' id='" . $row['subdistrict_id'] . "'" . $selected . ">" . $row['subdistrict_name'] . "</option>";
        }
    }
}

// DATA KELENGKAPAN
function dataKelengkapan($codeOrder){
    global $dataKelengkapanJamaahClass;

    $data = $dataKelengkapanJamaahClass->selectDataKelengkapanJamaah("oneCondition","code_order",$codeOrder);
    foreach($data['data'] as $row){
        $result['no_passport'] = $row['no_passport'];
        $result['tgl_terbit'] = $row['tgl_terbit'];
        $result['tgl_berlaku'] = $row['tgl_berlaku'];
        $result['alamat_terbit'] = $row['alamat_terbit'];
        $result['is_vaksi'] = $row['is_vaksi'];
    }
    $result['nums'] = $data['nums'];
    return $result;
}


?>
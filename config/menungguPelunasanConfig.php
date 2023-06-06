<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

if($role_user == "ADMIN"){
    header('Location: dasbor');
    exit();
}

$dataJamaahClass = new dataJamaahClass();
$dataPenjualanClass = new dataPenjualanClass();
$pinClass = new pinClass();
$formatInputClass = new formatInputClass();
$dateNow = $formatInputClass->date()['dateNow'];
$dateTimeNow = $formatInputClass->date()['dateTimeNow'];


// DATA TABLE
function dataTable(){
    global $dataPenjualanClass;
    $num = 1;
    $data = $dataPenjualanClass->selectDataPenjualan("oneCondition", "perekrut", $_SESSION['id_nrjtour']);
    foreach($data['data'] as $row){
        $show = $row['status'] == "MENUNGGU PELUNASAN" ? true : false;
        if($show){
            $fee = $row['uang_muka'] > 0 ? "Rp." . number_format($row['uang_muka'],0,",",".") : "Gratis";
            echo '<tr>
                    <th> ' . $num++ . ' </th>
                    <td><strong>' . $row['code_order'] . '</strong><br><i>(' . $row['category'] . ')</i></td>
                    <td> ' . $fee . ' </td>
                    <td> ' . $row['is_diskon'] . ' </td>
                    <td>
                        <strong>' . dataUser($row['direkrut'])['name'] . ' (' . $row['direkrut'] . ')</strong><br>
                        <i>' . dataUser($row['direkrut'])['email'] . '</i><br> 
                        <i>+62' . dataUser($row['direkrut'])['no_telpn'] . '</i><a href="https://api.whatsapp.com/send?phone=62' . dataUser($row['direkrut'])['no_telpn'] . '" class="btn btn-sm text-success radius-5"><i class="mx-auto ri-whatsapp-line"></i></a><br>
                        <a href="#detailJamaah' . $row['code_order'] . '" data-bs-toggle="modal">Detail</a>
                    </td>
                    <td>' . colorStatus($row['status']) . '</td>
                    <td>' . $row['date'] . '</td>
                    <td>
                        <a href="pelunasan-paket?idOrder=' . $row['code_order'] . '" class="btn btn-sm btn-warning text-dark"><i class="mx-auto ri-edit-line"></i></a>
                    </td>
                </tr>';
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
        $result['tgl_lahir'] = ubahFormatTanggal($row['tgl_lahir']);
        $result['detail_alamat'] = $row['detail_alamat'];
        $result['prov'] = $row['prov'];
        $result['kab_kota'] = $row['kab_kota'];
        $result['kec'] = $row['kec'];
        $result['jk'] = $row['jk'];
        $result['status_perkawinan'] = $row['status_perkawinan'];
        $result['tgl_berangkat'] = $row['tgl_berangkat'];
    }
    return $result;
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

// COLOR STATUS
function colorStatus($txt){
    if($txt == "MENUNGGU PELUNASAN"){
        return '<span class="badge rounded-pill alert-warning">' . $txt . '</span>';
    }elseif($txt == "DITOLAK"){
        return '<span class="badge rounded-pill alert-danger">' . $txt . '</span>';
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
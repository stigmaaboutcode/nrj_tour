<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

$dataJamaahClass = new dataJamaahClass();
$dataKelengkapanJamaahClass = new dataKelengkapanJamaahClass();
$dataPenjualanClass = new dataPenjualanClass();
$pinClass = new pinClass();
$hargaBonusClass = new hargaBonusClass();
$historyBonusUplineClass = new historyBonusUplineClass();
$dataBankClass = new dataBankClass();
$formatInputClass = new formatInputClass();
$dateNow = $formatInputClass->date()['dateNow'];
$dateTimeNow = $formatInputClass->date()['dateTimeNow'];

$title = "Penjualan Paket";

$status = "ALL";
$from = $formatInputClass->date()['startMonth'];
$to = $formatInputClass->date()['endMonth'];

if(isset($_POST['sortir'])){
    $status = $_POST['status'];
    $from = $_POST['from'];
    $to = $_POST['to'];
}

// DATA TABLE
function dataTable($from, $to, $status){
    global $dataPenjualanClass;
    global $role_user;
    $num = 1;
    $data = $dataPenjualanClass->selectDataPenjualan("dateKonsultan", $_SESSION['id_nrjtour'], $from, $to);
    if($role_user == "ADMIN"){
        $data = $dataPenjualanClass->selectDataPenjualan("date", $from, $to);
    }
    foreach($data['data'] as $row){
        $infoUser = "";
        if($role_user == "ADMIN"){
            $infoUser = '<td>
                            <strong>' . dataUser($row['perekrut'])['name'] . ' (' . $row['perekrut'] . ')</strong><br>
                            <i>' . dataUser($row['perekrut'])['email'] . '</i><br> 
                            <i>+62' . dataUser($row['perekrut'])['no_telpn'] . '</i><a href="https://api.whatsapp.com/send?phone=62' . dataUser($row['perekrut'])['no_telpn'] . '" class="btn btn-sm text-success radius-5"><i class="mx-auto ri-whatsapp-line"></i></a><br>
                        </td>';
        }
        $show = true;
        if($status != "ALL"){
            $show = $row['status'] == $status ? true : false;
        }
        if($show){
            $dpFee = $row['uang_muka'] > 0 ? "Rp." . number_format($row['uang_muka'],0,",",".") : "Gratis";
            $pelunasanFee = "Belum Dilunasi";
            $categoryPelunasan = '';
            $tglBerangkat = '';
            if($row['status'] != "PENDING" && $row['status'] != "DITOLAK" && $row['status'] != "MENUNGGU PELUNASAN"){
                $tglBerangkat = '<br>' . dataJamaah($row['code_order'])['tgl_berangkat'];
                $pelunasanFee = $row['uang_pelunasan'] > 0 ? "Rp." . number_format($row['uang_pelunasan'],0,",",".") : "Gratis";
                $categoryPelunasan = $row['paket_pelunasan'] != 'GRATIS' ? '<br>(' . $row['paket_pelunasan'] . ')' : '';
            }
            echo '<tr>
                    <th> ' . $num++ . ' </th>
                    <td>
                        <strong>' . $row['code_order'] . '</strong><br>
                        - <i>(' . $row['category'] . ')</i> -
                        ' . $tglBerangkat . '
                    </td>
                    ' . $infoUser . '
                    <td>
                        DP: ' . $dpFee . '<br>
                        Pelunasan: ' . $pelunasanFee . $categoryPelunasan . '

                    </td>
                    <td> ' . $row['is_diskon'] . ' </td>
                    <td>
                        <strong>' . dataUser($row['direkrut'])['name'] . ' (' . $row['direkrut'] . ')</strong><br>
                        <i>' . dataUser($row['direkrut'])['email'] . '</i><br> 
                        <i>+62' . dataUser($row['direkrut'])['no_telpn'] . '</i><a href="https://api.whatsapp.com/send?phone=62' . dataUser($row['direkrut'])['no_telpn'] . '" class="btn btn-sm text-success radius-5"><i class="mx-auto ri-whatsapp-line"></i></a><br>
                        <a href="#detailJamaah' . $row['code_order'] . '" data-bs-toggle="modal">Detail</a>
                    </td>
                    <td>' . colorStatus($row['status']) . '</td>
                    <td>' . $row['date'] . '</td>
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
        $result['tgl_berangkat'] = ubahFormatTanggal($row['tgl_berangkat']);
    }
    return $result;
}

// OPT STATUS
function optStatus($status){
    $arrayStatus = array('ALL','PENDING','DITOLAK','MENUNGGU PELUNASAN','MENUNGGU KONFIRMASI PELUNASAN','PELUNASAN DITOLAK','LUNAS');
    foreach($arrayStatus as $row){
        $selected = $row == $status ? 'selected="selected"' : '';
        echo '<option value="' . $row . '" ' . $selected. '>' . $row . '</option>';
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

// DATA BONUS
function bonusUser($cat){
    global $hargaBonusClass;
    $data = $hargaBonusClass->selectHargaBonus($cat);
    foreach($data['data'] as $row){
        $result['umroh'] = $row['umroh'];
        $result['haji'] = $row['haji'];
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
    global $role_user;
    if($txt == "PENDING"){
        return '<span class="badge rounded-pill alert-warning">' . $txt . '</span>';
    }elseif($txt == "DITOLAK"){
        return '<span class="badge rounded-pill alert-danger">' . $txt . '</span>';
    }elseif($txt == "MENUNGGU PELUNASAN"){
        return '<span class="badge rounded-pill alert-success">' . $txt . '</span>';
    }elseif($txt == "MENUNGGU KONFIRMASI PELUNASAN"){
        return '<span class="badge rounded-pill alert-warning">' . $txt . '</span>';
    }elseif($txt == "PELUNASAN DITOLAK"){
        return '<span class="badge rounded-pill alert-danger">' . $txt . '</span>';
    }elseif($txt == "LUNAS"){
        return '<span class="badge rounded-pill alert-success">' . $txt . '</span>';
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
        $result['upline'] = $row['upline'];
    }
    $result['nums'] = $data['nums'];
    return $result;
}
?>
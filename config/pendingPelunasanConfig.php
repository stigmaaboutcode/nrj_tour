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

$title = $role_user == "ADMIN" ? "Pembayaran Pelunasan" : "Pending Pelunasan";

// POST TOLAK
if(isset($_POST['tolak'])){
    $getId = $_POST['idOrder'];
    $checkData = $dataPenjualanClass->selectDataPenjualan("oneCondition", "code_order", $getId);
    if($checkData['nums'] > 0){
        foreach($checkData['data'] as $row){
            $statusForAksi = $row['status'];
        }
        if($statusForAksi == "MENUNGGU KONFIRMASI PELUNASAN"){
            $tolakPermintaan = $dataPenjualanClass->UpdateDataPenjualan("changeStatus","code_order",$getId,"PELUNASAN DITOLAK");
            if($tolakPermintaan){
                $_SESSION['alertSuccess'] = "Berhasil tolak permintaan.";
                header('Location: pending-pelunasan');
                exit();
            }
        }else{
            $_SESSION['alertError'] = "Data tidak ditemukan.";
            header('Location: pending-pelunasan');
            exit();
        }
    }else{
        $_SESSION['alertError'] = "Data tidak ditemukan.";
        header('Location: pending-pelunasan');
        exit();
    }
}

// POST RESEND
if(isset($_POST['resend'])){
    $getId = $_POST['idOrder'];
    $checkData = $dataPenjualanClass->selectDataPenjualan("oneCondition", "code_order", $getId);
    if($checkData['nums'] > 0){
        foreach($checkData['data'] as $row){
            $statusForAksi = $row['status'];
            $is_diskon = $row['is_diskon'];
            $bukti_tf_pelunasan = $row['bukti_tf_pelunasan'];
        }
        if($statusForAksi == "PELUNASAN DITOLAK"){
            $buktitfName = "GRATIS";
            if($is_diskon == "TIDAK ADA" || $is_diskon == "GRATIS DP"){
                // DELETE OLD FILE
                unlink($bukti_tf_pelunasan);
                // FOLDER
                $dir_bukti_tf = "assets/images/bukti_tf_umroh/";
                $fileNameTF = basename($_FILES["buktiTf"]["name"]);
                $targetFileTF = $dir_bukti_tf . $fileNameTF;
                $imageFileTypeTF = pathinfo($targetFileTF,PATHINFO_EXTENSION);
                // menghasilkan nama file yang unik
                $newFileNameTF = uniqid() . '.' . $imageFileTypeTF;
                $newTargetFileTF = $dir_bukti_tf . $newFileNameTF;
                move_uploaded_file($_FILES["buktiTf"]["tmp_name"], $newTargetFileTF);
                // DATA PEMBAYARAN
                $buktitfName = $newTargetFileTF;
            }
            $resendPermintaan = $dataPenjualanClass->UpdateDataPenjualan("resendPelunasan","code_order",$getId,$buktitfName);
            if($resendPermintaan){
                $_SESSION['alertSuccess'] = "Data terkirim.";
                header('Location: pending-pelunasan');
                exit();
            }
        }else{
            $_SESSION['alertError'] = "Data tidak ditemukan.";
            header('Location: pending-pelunasan');
            exit();
        }
    }else{
        $_SESSION['alertError'] = "Data tidak ditemukan.";
        header('Location: pending-pelunasan');
        exit();
    }
}

// POST TERIMA
if(isset($_POST['terima'])){
    $getId = $_POST['idOrder'];
    $checkData = $dataPenjualanClass->selectDataPenjualan("oneCondition", "code_order", $getId);
    if($checkData['nums'] > 0){
        foreach($checkData['data'] as $row){
            $statusForAksi = $row['status'];
            $perekrut = $row['perekrut'];
            $category = $row['category'];
            $is_diskon = $row['is_diskon'];
        }
        if($statusForAksi == "MENUNGGU KONFIRMASI PELUNASAN"){
            // CHANGE STATUS PEMBELIAN
            $updateStatusPembelian = $dataPenjualanClass->UpdateDataPenjualan("changeStatus","code_order",$getId,"LUNAS");
            if($updateStatusPembelian){
                // BAGIKAN BONUS PENJUALAN JIKA TIDAK ADA DISKON
                if($is_diskon == "TIDAK ADA" || $is_diskon == "GRATIS DP"){
                    $uplinePerekrut = dataUser($perekrut)['upline'];
                    if($uplinePerekrut != "ADMIN"){
                        $bonusUser = $category == "UMROH" ? bonusUser("UPLINE")['umroh'] : bonusUser("UPLINE")['haji'];
                        $historyBonusUplineClass->insertHistoryBonusUpline($getId,$uplinePerekrut,$perekrut,$category,$bonusUser,$dateTimeNow);
                    }
                }
                $_SESSION['alertSuccess'] = "Data berhasil diubah.";
                header('Location: pending-pelunasan');
                exit();
            }
        }else{
            $_SESSION['alertError'] = "Data tidak ditemukan.";
            header('Location: pending-pelunasan');
            exit();
        }
    }else{
        $_SESSION['alertError'] = "Data tidak ditemukan.";
        header('Location: pending-pelunasan');
        exit();
    }
}

// <a href="pending-pelunasan?idOrder=' . $row['code_order'] . '&param=cancel" class="btn btn-sm btn-danger"><i class="mx-auto ri-close-line"></i></a>
// DATA TABLE
function dataTable(){
    global $dataPenjualanClass;
    global $role_user;
    $num = 1;
    $data = $dataPenjualanClass->selectDataPenjualan("oneCondition", "perekrut", $_SESSION['id_nrjtour']);
    if($role_user == "ADMIN"){
        $data = $dataPenjualanClass->selectDataPenjualan("all");
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
        $btn = $row['status'] == "MENUNGGU KONFIRMASI PELUNASAN" ? '-,-' : '<a href="#resend' . $row['code_order'] . '" data-bs-toggle="modal" class="btn btn-sm btn-warning"><i class="mx-auto ri-restart-line"></i></a>';
        $show = $row['status'] == "MENUNGGU KONFIRMASI PELUNASAN" || $row['status'] == "PELUNASAN DITOLAK" ? true : false;
        if($role_user == "ADMIN"){
            $btn = '<a href="#confirmDp' . $row['code_order'] . '" data-bs-toggle="modal" class="btn btn-sm btn-success"><i class="mx-auto ri-check-line"></i></a>';
            $show = $row['status'] == "MENUNGGU KONFIRMASI PELUNASAN" ? true : false;
        }
        if($show){
            $dpFee = $row['uang_muka'] > 0 ? "Rp." . number_format($row['uang_muka'],0,",",".") : "Gratis";
            $pelunasanFee = $row['uang_pelunasan'] > 0 ? "Rp." . number_format($row['uang_pelunasan'],0,",",".") : "Gratis";
            echo '<tr>
                    <th> ' . $num++ . ' </th>
                    <td><strong>' . $row['code_order'] . '</strong><br> - <i>(' . $row['category'] . ')</i> - <br>' . dataJamaah($row['code_order'])['tgl_berangkat'] . '</td>
                    ' . $infoUser . '
                    <td>
                        DP: ' . $dpFee . '<br>
                        Pelunasan: ' . $pelunasanFee . '<br>
                        ' . $row['paket_pelunasan'] . '
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
                    <td>
                        ' .  $btn . '
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
        $result['tgl_berangkat'] = ubahFormatTanggal($row['tgl_berangkat']);
    }
    return $result;
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

// REK ADMIN
function optRekTujuan(){
    global $dataBankClass;

    $data = $dataBankClass->selectDataBank("allData");

    foreach($data['data'] as $row){
        echo '<option value="">' . $row['nama_bank'] . ': ' . $row['atas_nama'] . ' (' . $row['no_rek'] . ')</option>';
    }
}

// COLOR STATUS
function colorStatus($txt){
    global $role_user;
    if($txt == "MENUNGGU KONFIRMASI PELUNASAN"){
        $text = $role_user == "ADMIN" ? "KONFIRMASI PELUNASAN" : "PENDING PELUNASAN";
        return '<span class="badge rounded-pill alert-warning">' . $text . '</span>';
    }elseif($txt == "PELUNASAN DITOLAK"){
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
        $result['upline'] = $row['upline'];
    }
    $result['nums'] = $data['nums'];
    return $result;
}
?>
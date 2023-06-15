<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

$dataPenjualanClass = new dataPenjualanClass();
$dataJamaahClass = new dataJamaahClass();
$dataBankClass = new dataBankClass();
$walletClass = new walletClass();
$hargaBonusClass = new hargaBonusClass();
$historyBonusPenjualanClass = new historyBonusPenjualanClass();
$formatInputClass = new formatInputClass();
$dateNow = $formatInputClass->date()['dateNow'];
$dateTimeNow = $formatInputClass->date()['dateTimeNow'];

// DELETE
if(isset($_GET['idOrder']) && isset($_GET['param'])){
    $idOrder = $_GET['idOrder'];
    $param = $_GET['param'];
    $check = $dataPenjualanClass->selectDataPenjualan("oneCondition", "code_order", $idOrder);
    if($check['nums'] > 0){
        foreach($check['data'] as $row){
            $statusForAksi = $row['status'];
            $perekrut = $row['perekrut'];
            $fotoBuktiTf = $row['bukti_tf_uang_muka'];
            $konsultan = $row['direkrut'];
            $is_diskon = $row['is_diskon'];
        }
        if($statusForAksi == "PENDING" || $statusForAksi == "DITOLAK"){
            $deleteKonsultan = true;
            // JIKA MENGGUNAKAN POIN MAKA KMBALIKAN POIN
            if($is_diskon == "GRATIS DP & PELUNASAN"){
                $totalPoin = walletUser($perekrut)['poin'] + 10;
                $updateWallet = $walletClass->UpdateWallet("poin_balance",$totalPoin,$perekrut);
            }else{
                // CHECK DATA KONSULTAN
                $checkKonsultan = $userClass->selectUser("oneCondition","code_referral",$konsultan);
                // DELETE AKUN KONSULTAN JIKA ADA
                if($checkKonsultan['nums'] > 0){
                    $deleteKonsultan = $userClass->deleteUser($konsultan);
                }
            }
            if($deleteKonsultan){
                // DELETE BUKTI TF JIKA ADA
                if($fotoBuktiTf != "GRATIS"){
                    unlink($fotoBuktiTf);
                }
                // DELETE DATA PENJUALAN
                $deletePenjualan = $dataPenjualanClass->deleteDataPenjualan($idOrder);
                if($deletePenjualan){
                    // CHECK DATA JAMAAH
                    $checkDataJamaah = $dataJamaahClass->selectDataJamaah("oneCondition","code_order",$idOrder);
                    foreach($checkDataJamaah['data'] as $row){
                        $fotoKtp = $row['foto_ktp'];
                    }
                    unlink($fotoKtp);
                    $deleteDataJamaah = $dataJamaahClass->deleteDataJamaah($idOrder);
                    if($deleteDataJamaah){
                        $_SESSION['alertSuccess'] = "Data terhapus.";
                        header('Location: pending-dp');
                        exit();
                    }
                }
            }
            
        }else{
            $_SESSION['alertError'] = "Data tidak ditemukan.";
            header('Location: pending-dp');
            exit();
        }
    }else{
        $_SESSION['alertError'] = "Data tidak ditemuka.n";
        header('Location: pending-dp');
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
            $direkrut = $row['direkrut'];
            $category = $row['category'];
            $is_diskon = $row['is_diskon'];
        }
        if($statusForAksi == "PENDING"){
            // CHANGE STATUS PEMBELIAN
            $updateStatusPembelian = $dataPenjualanClass->UpdateDataPenjualan("changeStatus","code_order",$getId,"MENUNGGU PELUNASAN");
            if($updateStatusPembelian){
                // BAGIKAN BONUS PENJUALAN JIKA TIDAK ADA DISKON
                if($is_diskon == "TIDAK ADA"){
                    $bonusUser = $category == "UMROH" ? bonusUser("PENJUALAN")['umroh'] : bonusUser("PENJUALAN")['haji'];
                    $totalBonusUser = walletUser($perekrut)['bonus'] + $bonusUser;
                    $updateWallet = $walletClass->UpdateWallet("bonus_balance",$totalBonusUser,$perekrut);
                    if($updateWallet){
                        $historyBonusPenjualanClass->insertHistoryBonusPenjualan($getId,$perekrut,$category,$bonusUser,$dateTimeNow);
                    }
                }
                if($perekrut != $direkrut){
                    $userClass->UpdateUser("statusUser",$direkrut,"AKTIF");
                }
                $_SESSION['alertSuccess'] = "Data berhasil diubah.";
                header('Location: pending-dp');
                exit();
            }
        }else{
            $_SESSION['alertError'] = "Data tidak ditemukan.";
            header('Location: pending-dp');
            exit();
        }
    }else{
        $_SESSION['alertError'] = "Data tidak ditemukan.";
        header('Location: pending-dp');
        exit();
    }
}

// POST TOLAK
if(isset($_POST['tolak'])){
    $getId = $_POST['idOrder'];
    $checkData = $dataPenjualanClass->selectDataPenjualan("oneCondition", "code_order", $getId);
    if($checkData['nums'] > 0){
        foreach($checkData['data'] as $row){
            $statusForAksi = $row['status'];
        }
        if($statusForAksi == "PENDING"){
            $tolakPermintaan = $dataPenjualanClass->UpdateDataPenjualan("changeStatus","code_order",$getId,"DITOLAK");
            if($tolakPermintaan){
                $_SESSION['alertSuccess'] = "Berhasil tolak permintaan.";
                header('Location: pending-dp');
                exit();
            }
        }else{
            $_SESSION['alertError'] = "Data tidak ditemukan.";
            header('Location: pending-dp');
            exit();
        }
    }else{
        $_SESSION['alertError'] = "Data tidak ditemukan.";
        header('Location: pending-dp');
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
            $bukti_tf_uang_muka = $row['bukti_tf_uang_muka'];
        }
        if($statusForAksi == "DITOLAK"){
            $buktitfName = "GRATIS";
            if($is_diskon == "TIDAK ADA"){
                // DELETE OLD FILE
                unlink($bukti_tf_uang_muka);
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
            $resendPermintaan = $dataPenjualanClass->UpdateDataPenjualan("resendDp","code_order",$getId,$buktitfName);
            if($resendPermintaan){
                $_SESSION['alertSuccess'] = "Data terkirim.";
                header('Location: pending-dp');
                exit();
            }
        }else{
            $_SESSION['alertError'] = "Data tidak ditemukan.";
            header('Location: pending-dp');
            exit();
        }
    }else{
        $_SESSION['alertError'] = "Data tidak ditemukan.";
        header('Location: pending-dp');
        exit();
    }
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
        $btn = $row['status'] == "PENDING" ? '-,-' : '<a href="#resend' . $row['code_order'] . '" data-bs-toggle="modal" class="btn btn-sm btn-warning"><i class="mx-auto ri-restart-line"></i></a>';
        $show = $row['status'] == "PENDING" || $row['status'] == "DITOLAK" ? true : false;
        if($role_user == "ADMIN"){
            $btn = '<a href="#confirmDp' . $row['code_order'] . '" data-bs-toggle="modal" class="btn btn-sm btn-success"><i class="mx-auto ri-check-line"></i></a>';
            $show = $row['status'] == "PENDING" ? true : false;
        }
        if($show){

            $fee = $row['uang_muka'] > 0 ? "Rp." . number_format($row['uang_muka'],0,",",".") : "Gratis";
            echo '<tr>
                    <th> ' . $num++ . ' </th>
                    <td><strong>' . $row['code_order'] . '</strong><br> - <i>(' . $row['category'] . ')</i> - </td>';
            if($role_user == "ADMIN"){
                echo '<td>
                        <strong>' . dataUser($row['perekrut'])['name'] . ' (' . $row['perekrut'] . ')</strong><br>
                        <i>' . dataUser($row['perekrut'])['email'] . '</i><br> 
                        <i>+62' . dataUser($row['perekrut'])['no_telpn'] . '</i><a href="https://api.whatsapp.com/send?phone=62' . dataUser($row['perekrut'])['no_telpn'] . '" class="btn btn-sm text-success radius-5"><i class="mx-auto ri-whatsapp-line"></i></a><br>
                    </td>';
            }
            echo   '<td> ' . $fee . ' </td>
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
                        ' . $btn . '
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
// WALLET USER
function walletUser($perekrut){
    global $walletClass;

    $data = $walletClass->selectWallet($perekrut);
    foreach($data['data'] as $row){
        $result['poin'] = $row['poin_balance'];
        $result['bonus'] = $row['bonus_balance'];
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
    if($txt == "PENDING"){
        return '<span class="badge rounded-pill alert-warning">' . $txt . '</span>';
    }elseif($txt == "DITOLAK"){
        return '<span class="badge rounded-pill alert-danger">' . $txt . '</span>';
    }
}

// REK ADMIN
function optRekTujuan(){
    global $dataBankClass;

    $data = $dataBankClass->selectDataBank("allData");

    foreach($data['data'] as $row){
        echo '<option value="">' . $row['nama_bank'] . ': ' . $row['atas_nama'] . ' (' . $row['no_rek'] . ')</option>';
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
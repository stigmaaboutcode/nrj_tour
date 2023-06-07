<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

if($role_user != "ADMIN"){
    header('Location: dasbor');
    exit();
}

$formatInputClass = new formatInputClass();

if(isset($_GET['user'])){
    $idUser = $_GET['user'];
    if(dataUser($idUser)['nums'] > 0){
        $nama = dataUser($idUser)['name'];
        $email = dataUser($idUser)['email'];
        $notelpn = dataUser($idUser)['no_telpn'];
    }else{
        $_SESSION['alertError'] = "Data tidak ditemukan.";
        header('Location: data-member');
        exit();
    }
}else{
    $_SESSION['alertError'] = "Pilih Konsultan anda.";
    header('Location: data-member');
    exit();
}

if(isset($_POST['submit'])){
    $email = trim($_POST['email']);
    $nama = ucwords(trim($_POST['nama']));
    $notelpn = $formatInputClass->Notelpn(trim($_POST['notelpn']));

    if($email == "" || $nama == "" || $notelpn == ""){
        $_SESSION['alertError'] = "Data tidak boleh kosong.";
    }else{
        // CHECK EMAIL 
        $emailCheck = $userClass->selectUser("checkForUpdate","email",$email,$_GET['user']);
        if($emailCheck['nums'] > 0){
            $_SESSION['alertError'] = "Email sudah terdaftar.";
        }else{
            $noTelpnCheck = $userClass->selectUser("checkForUpdate","no_telpn",$notelpn,$_GET['user']);
            if($noTelpnCheck['nums'] > 0){
                $_SESSION['alertError'] = "Nomor Telpn sudah terdaftar.";
            }else{
                $updateData = $userClass->UpdateUser("editData",$_GET['user'],$email,$nama,$notelpn);
                if($updateData){
                    $_SESSION['alertSuccess'] = "Data berhasil diubah.";
                    header('Location: data-member');
                    exit();
                }
            }
        }
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
        $result['role_user'] = $row['role_user'];
        $result['upline'] = $row['upline'];
    }
    $result['nums'] = $data['nums'];
    return $result;
}
?>
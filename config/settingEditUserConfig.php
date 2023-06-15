<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

$formatInputClass = new formatInputClass();

if(isset($_POST['submit'])){
    $email = trim($_POST['email']);
    $nama = strtolower(trim($_POST['nama']));
    $notelpn = $formatInputClass->Notelpn(trim($_POST['notelpn']));

    if($email == "" || $nama == "" || $notelpn == ""){
        $_SESSION['alertError'] = "Data tidak boleh kosong.";
    }else{
        $checkName = $userClass->selectUser("checkForUpdate","name",$nama,$_SESSION['id_nrjtour']);
        if($checkName['nums'] > 0){
            $_SESSION['alertError'] = "Username sudah terdaftar.";
        }else{
            // CHECK EMAIL 
            $emailCheck = $userClass->selectUser("checkForUpdate","email",$email,$_SESSION['id_nrjtour']);
            if($emailCheck['nums'] > 0){
                $_SESSION['alertError'] = "Email sudah terdaftar.";
            }else{
                $noTelpnCheck = $userClass->selectUser("checkForUpdate","no_telpn",$notelpn,$_SESSION['id_nrjtour']);
                if($noTelpnCheck['nums'] > 0){
                    $_SESSION['alertError'] = "Nomor Telpn sudah terdaftar.";
                }else{
                    $updateData = $userClass->UpdateUser("editData",$_SESSION['id_nrjtour'],$email,$nama,$notelpn);
                    if($updateData){
                        $_SESSION['alertSuccess'] = "Data berhasil diubah.";
                        header('Location: edit-profil');
                        exit();
                    }
                }
            }
        }
    }
}
?>
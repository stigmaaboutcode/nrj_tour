<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

if(isset($_POST['submit'])){
    $passwordLama = trim($_POST['password']);
    $passwordBaru = trim($_POST['passbaru']);
    $passwordConfirm = trim($_POST['passConfirm']);

    if($passwordLama == "" || $passwordBaru == "" || $passwordConfirm == ""){
        $_SESSION['alertError'] = "Data tidak boleh kosong.";
    }else{
        // CHECK PASSWORD ANDA
        if(!password_verify($passwordLama,$passDb)){
            $_SESSION['alertError'] = "Password anda salah.";
        }else{
            if($passwordBaru != $passwordConfirm){
                $_SESSION['alertError'] = "Password anda tidak sesuai.";
            }else{
                $passHash = password_hash($passwordConfirm,PASSWORD_DEFAULT);
                $updatePass = $userClass->UpdateUser("editPass",$_SESSION['id_nrjtour'],$passHash);
                if($updatePass){
                    $_SESSION['alertSuccess'] = "Password berhasil diubah.";
                    header('Location: ganti-password');
                    exit();
                }
            }
        }
    }
}
?>
<?php  
if($_SESSION['loginNRJ']){
    header('Location: dasbor');
    exit();
}

// SET userClass
$userClass = new userClass;

if(isset($_POST['login'])){
    $email = strtolower(trim($_POST['email']));
    $password = trim($_POST['password']);

    if($email == "" || $password == ""){
        $_SESSION['alertError'] = "email / password anda salah!";
    }else{
        $checkAuth = $userClass->selectUser("oneCondition","email",$email);
        if($checkAuth['nums'] == 0){
            $_SESSION['alertError'] = "email / password anda salah!";
        }else{
            foreach($checkAuth['data'] as $row){
                $id_user = $row['code_referral'];
                $passwordDb = $row['password'];
                $status = $row['status'];
            }
            if(!password_verify($password, $passwordDb)){
                $_SESSION['alertError'] = "email / password anda salah!";
            }else{
                if($status == "TIDAK AKTIF"){
                    $_SESSION['alertError'] = "akun anda belum diaktifkan!";
                }else{
                    $_SESSION['loginNRJ'] = true;
                    $_SESSION['id_user'] = $id_user;
                    $_SESSION['alertSuccess'] = "Login Success!";
                    header('Location: dasbor');
                    exit();
                }
            }
        }
    }

}
?>
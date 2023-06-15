<?php  
session_start();
error_reporting(0);
if($_SESSION['loginNRJ']){
    header('Location: dasbor');
    exit();
}
// FILE CONTROLLER DATABASE 
require_once "modal/ConnectionsClass.php";
require_once "modal/dataBankClass.php";
require_once "modal/dataBankUserClass.php";
require_once "modal/dataJamaah.php";
require_once "modal/dataKelengkapanJamaah.php";
require_once "modal/dataPenjualanClass.php";
require_once "modal/hargaBonusClass.php";
require_once "modal/hargaDpClass.php";
require_once "modal/hargaPelunasanClass.php";
require_once "modal/historyBonusPenjualanClass.php";
require_once "modal/historyBonusUplineClass.php";
require_once "modal/pinClass.php";
require_once "modal/rajaOngkir.php";
require_once "modal/walletClass.php";
require_once "modal/withdrawClass.php";
require_once "modal/userClass.php";

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
            $checkAuthByName = $userClass->selectUser("oneCondition","name",$email);
            if($checkAuthByName['nums'] == 0){
                $_SESSION['alertError'] = "Login Invalid!";
            }else{
                foreach($checkAuthByName['data'] as $row){
                    $id_user = $row['code_referral'];
                    $passwordDb = $row['password'];
                    $status = $row['status'];
                }
                if(!password_verify($password, $passwordDb)){
                    $_SESSION['alertError'] = "Login Invalid!";
                }else{
                    if($status == "TIDAK AKTIF"){
                        $_SESSION['alertError'] = "akun anda belum diaktifkan!";
                    }else{
                        $_SESSION['loginNRJ'] = true;
                        $_SESSION['id_nrjtour'] = $id_user;
                        $_SESSION['alertSuccess'] = "Login Success!";
                        header('Location: dasbor');
                        exit();
                    }
                }
            }
        }else{
            foreach($checkAuth['data'] as $row){
                $id_user = $row['code_referral'];
                $passwordDb = $row['password'];
                $status = $row['status'];
            }
            if(!password_verify($password, $passwordDb)){
                $_SESSION['alertError'] = "Login Invalid!";
            }else{
                if($status == "TIDAK AKTIF"){
                    $_SESSION['alertError'] = "akun anda belum diaktifkan!";
                }else{
                    $_SESSION['loginNRJ'] = true;
                    $_SESSION['id_nrjtour'] = $id_user;
                    $_SESSION['alertSuccess'] = "Login Success!";
                    header('Location: dasbor');
                    exit();
                }
            }
        }
    }

}
?>
<?php
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



session_start();
error_reporting(0);

// SET CLASS
$userClass = new userClass();
$dataLogin = $userClass->selectUser("oneCondition","code_referral",$_SESSION['id_nrjtour']);
foreach($dataLogin['data'] as $row){
    $name = $row['name'];
    $email = $row['email'];
    $no_telpn = $row['no_telpn'];
    $role_user = $row['role_user'];
    $upline = $row['upline'];
    $passDb = $row['password'];
}



?>
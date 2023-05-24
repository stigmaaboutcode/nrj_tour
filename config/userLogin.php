<?php  
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
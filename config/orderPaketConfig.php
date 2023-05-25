<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

if($role_user == "ADMIN"){
    header('Location: dasbor');
    exit();
}
?>
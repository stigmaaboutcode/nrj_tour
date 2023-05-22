<?php  
if(!$_SESSION['loginNRJ']){
    header('Location: signin');
    exit();
}

?>
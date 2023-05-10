<?php  
session_start();
error_reporting(0);

session_unset();
header('Location: signin')
?>
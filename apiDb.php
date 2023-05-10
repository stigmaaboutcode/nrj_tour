<?php 
// FILE CONTROLLER DATABASE 
foreach (glob("modal/*.php") as $database) {
    include_once $database;
}

session_start();
error_reporting(0)
?>
<?php


require_once("../../connection.php") ;
session_start() ;
if(isset($_SESSION['user'])){
    if(isset($_POST['logout'])){
        $user = "?admin";
        if(isset($_SESSION['student'])) $user = "";
        session_destroy() ;
        header('location:/admin/login'.$user) ;
    }else{
        header('location:/admin/dashboard') ;
    }
}

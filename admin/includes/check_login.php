<?php

require_once('functions.php');
require_once('../../connection.php');
session_start();
if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST['submit-admin'])){
        $user = validate_input( $_POST['user'] );
        $pass = validate_input( $_POST['password'] )  ;
        $role = $_POST['role'] ;
        if( empty($user) || empty($pass) || empty($role) ){
            $_SESSION['err'] = "Tous les champs sont obligatoires" ;
            header("location:/admin/login?admin");
        }elseif(strlen($pass) < 8){
            $_SESSION['err'] = "mot de passe doit contenir au moins 8 caractères" ;
            header("location:/admin/login?admin");
        }else{
            if($_POST['role'] == "manager"){
               $query =  "SELECT * FROM manager WHERE email_user = '$user'";
               $result = mysqli_query($connect , $query) ; 
               $row = mysqli_fetch_assoc($result) ;
               if(mysqli_num_rows($result) == 0){
                    $_SESSION['err'] = "Email don't Exist";
                    header("location:/admin/login?admin");
               }elseif($row['email_user']=='manager@gmail.com'){
                   if($row['password'] == $pass || password_verify($pass,$row['password'])){
                    $_SESSION['manager'] = $row['id_user'] ;
                    $_SESSION['user'] = $row['id_user'] ;
                    header("location:/admin/dashboard");
                   }else{
                    $_SESSION["err"] = "Mot de passe incorrect" ;
                    header("location:/admin/login?admin");
                   }
               }elseif(password_verify($pass , $row['password'])){
                    $_SESSION['manager'] = $row['id_user'] ;
                    $_SESSION['user'] = $row['id_user'] ;
                    header("location:/admin/dashboard");
               }else{
                   $_SESSION["err"] = "le mot de passe ou email incorrect" ;
                   header("location:/admin/login?admin");
               }
            }elseif($_POST['role'] == "teacher"){
                $query =  "select * from teacher where email_user = '$user' ";
                $result = mysqli_query($connect , $query) ; 
                $row = mysqli_fetch_assoc($result) ;
                if(mysqli_num_rows($result) == 0){
                    $_SESSION['err'] = "Email don't Exist";
                    header("location:/admin/login?admin");
               }elseif(password_verify($pass , $row['password'])){
                    $_SESSION['teacher'] = $row['id_user'] ;
                    $_SESSION['user'] = $row['id_user'] ;
                    header("location:/admin/dashboard");
               }else{
                    $_SESSION["err"] = "le mot de passe ou utilisateur incorrect" ;
                    header("location:/admin/login?admin");
                }
            }
        }
        
    }

    if(isset($_POST['submit-student'])){
        $user = validate_input( $_POST['user'] );
        $pass = validate_input( $_POST['password'] )  ;
        if( empty($user) || empty($pass) ){
            $_SESSION['err'] = "Tous les champs sont obligatoires" ;
            header("location:/admin/login");
        }elseif(strlen($pass) < 8){
            
            $_SESSION['err'] = "mot de passe doit contenir au moins 8 caractères" ;
            header("location:/admin/login");
        }else{
            
            $query =  "SELECT * from student where email_user = '$user' ";
            $result = mysqli_query($connect , $query) ; 
            $row = mysqli_fetch_assoc($result) ;
            if(mysqli_num_rows($result) == 0){
                
                $_SESSION['err'] = "Email don't Exist";
                header("location:/admin/login");
            }elseif(password_verify($pass , $row['password'])){
                
                $_SESSION['student'] = $row['id_user'] ;
                $_SESSION['user'] = $row['id_user'] ;
                header("location:/admin/dashboard");
            }else{
                $_SESSION["err"] = "le mot de passe ou utilisateur incorrect" ;
                header("location:/admin/login");
            }
            
        }
        
    }
}


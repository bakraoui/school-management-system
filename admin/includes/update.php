<?php
require_once('../../connection.php') ;
include('../includes/functions.php') ;
session_start();

if(isset($_SESSION['user'])){

/* ---------------- Build the school  ---------------- */
if(isset($_POST['update-school'])){

    $name = validate_input($_POST['name'] ) ;
    $city = validate_input($_POST['city'] ) ;
    $adress = validate_input($_POST['adress' ]) ;
    $type = validate_input($_POST['type'] ) ;
    $email = validate_input($_POST['email'])  ;
    $tele = validate_input($_POST['tele'] ) ;
    $id = $_POST['id'];

    
    $logoName = $_FILES['logo']['name'] ;
    $logoSize = $_FILES['logo']['size'] ;
    $logoTemp = $_FILES['logo']['tmp_name'] ;

    if(empty($_POST['name']) || 
        empty($_POST['city']) || 
        empty($_POST['adress']) || 
        empty($_POST['type']) || 
        empty($_POST['email'])){

        $_SESSION['err'] = "Fields with * are required.";
        header('location:/admin/setting?school') ;
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['err'] = "Email Form is invalid.";
        header('location:/admin/setting?school') ;
    }elseif(empty($logoName) && empty($_POST['tele'])){
        $q = mysqli_query($connect,
            " UPDATE school 
              SET name = '$name' , city  = '$city',
               adress = '$adress' ,  type = '$type' , email ='$email' 
               WHERE id_school = '$id' " );
        $_SESSION['succ'] = "School infos was Updated.";
        
        header('location:/admin/setting?school') ;
    }elseif(empty($logoName)){
        $q = mysqli_query($connect,
            " UPDATE school 
              SET name ='$name' , city  ='$city',
               adress = '$adress' ,  type = '$type' , email = '$email',
               tele = '$tele'
              WHERE id_school = '$id' " );
        $_SESSION['succ'] = "Now You can use your Website.";
        header('location:/admin/setting?school') ;
    }else{
        $logo = explode('.',$logoName);
        $logoExt = end($logo);
        $extansions = array('jpg','jpeg','png') ;
        if(!is_in($logoExt,$extansions)){
            $_SESSION['err'] = "Logo extansion not valid.";
            header('location:/admin/setting?school') ;
        }elseif($logoSize > 100000){
            $_SESSION['succ'] = "Logo is too long.";
            header('location:/admin/setting?school') ;
        }else{
            $q = mysqli_query($connect,
            " UPDATE school 
              SET name ='$name' , city  ='$city',
               adress = '$adress' ,  type = '$type' , email ='$email',
               tele = '$tele' , logo = '$logoName'
               WHERE id_school = '$id' " );
            $_SESSION['succ'] = "Now You can use your Website.";
            move_uploaded_file($logoTemp, "../Files/Custom/".$logoName);
            header('location:/admin/setting?school') ;
        }
    }
    

    
    


}


// ------------- Update Manager ----------
if(isset($_POST['update-manager'])){
    if(isset($_POST['id'])){
        $id = unhash_str($_POST['id']) ;
        $lname = validate_input($_POST['lname'] ) ;
        $fname = validate_input($_POST['fname'] ) ;
        $cin = validate_input($_POST['cin'] ) ;
        $adress = validate_input($_POST['adress'] ) ;
        $city = validate_input($_POST['city'] ) ;
        $email = validate_input($_POST['email'] ) ;
        $image = $_FILES['image'] ;
        $imageName = $_FILES['image']['name'] ;
        $imageSize = $_FILES['image']['size']  ;
        $imageTmp = $_FILES['image']['tmp_name']  ;
        $imageExtansion = explode('.', $imageName ) ;
        $imageExtansion = strtolower(end($imageExtansion));
        $extansions = array('jpg','jpeg','png') ;

        if($_SESSION['manager'] != $id ) $direction = "?manager=".$id ;
        else $direction = "" ;
        
        if(empty($lname) || empty($fname) || empty($cin)  ||  empty($email)  ){
            
            $_SESSION['err']  ="All fields are required" ;
            header('location:/admin/profile'.$direction ) ;
        }elseif(!filter_var($email , FILTER_VALIDATE_EMAIL)){
            
            $_SESSION['err']  ="Invalid Email."."<br>Exemple : abc@xyz.exp" ;
            header('location:/admin/profile'.$direction ) ;
        }elseif(isset($imageName) && !empty($imageName)){
            $imageName = $cin.".".$imageExtansion ;
            if(!is_in($imageExtansion , $extansions)){
                
                $_SESSION['err']  ="File type is not allowed.<br>Only : jpeg, jpg, png." ;
                header('location:/admin/profile'.$direction ) ;
            } else{
                $query_email = "SELECT * FROM manager WHERE email_user = '$email'";
                $result_email = mysqli_query($connect , $query_email);
                $arr_email = mysqli_fetch_assoc($result_email);

                $query_old = "SELECT * FROM manager WHERE id_user = '$id' ";
                $result_old = mysqli_query($connect , $query_old);
                $arr_old = mysqli_fetch_assoc($result_old) ;
                
                if(mysqli_num_rows($result_email) == 1 && $arr_email['id_user'] != $id){
                    
                    $_SESSION['err']  ="Email already token" ;
                    header('location:/admin/profile'.$direction ) ;
                }elseif($arr_old['cin_user'] != $cin){
                    
                    $_SESSION['err']  ="Can't change the CIN.it is UNIQUE." ;
                    header('location:/admin/profile'.$direction ) ;
                }elseif(empty($city) && empty($city)){
                    $query  = "UPDATE manager SET  
                                lname_user = '$lname' , 
                                fname_user = '$fname' ,
                                email_user = '$email' , 
                                cin_user   = '$cin'   , 
                                image_user = '$imageName'
                                WHERE id_user = '$id'";
                     $result = mysqli_query($connect , $query) ;
                    
                     move_uploaded_file($imageTmp ,"../Files/managers/".$cin."/".$cin.".".$imageExtansion ) ;
                     
                     $_SESSION['succ']  ="Data was Updated" ;
                     header('location:/admin/profile'.$direction ) ;
                }elseif(empty($adress)){
                    $query  = "UPDATE manager SET  
                        lname_user = '$lname' , 
                        fname_user = '$fname' ,
                        email_user = '$email' , 
                        cin_user   = '$cin'   , 
                        city_user  = '$city'  ,
                        image_user = '$imageName'
                        WHERE id_user = '$id'";
                    $result = mysqli_query($connect , $query) ;
                    
                    move_uploaded_file($imageTmp ,"../Files/managers/".$cin."/".$cin.".".$imageExtansion ) ;
                    
                    $_SESSION['succ']  ="Data was Updated" ;
                    header('location:/admin/profile'.$direction ) ;   
                }elseif(empty($city)){
                    $query  = "UPDATE manager SET  
                        lname_user = '$lname' , 
                        fname_user = '$fname' ,
                        email_user = '$email' , 
                        cin_user   = '$cin'   , 
                        adress_user= '$adress', 
                        image_user = '$imageName'
                        WHERE id_user = '$id'";
                    $result = mysqli_query($connect , $query) ;
                    
                    move_uploaded_file($imageTmp ,"../Files/managers/".$cin."/".$cin.".".$imageExtansion ) ;
                    
                    $_SESSION['succ']  ="Data was Updated" ;
                    header('location:/admin/profile'.$direction ) ;  
                }else{
                    
                    $query  = "UPDATE manager SET  
                        lname_user = '$lname' , 
                        fname_user = '$fname' ,
                        email_user = '$email' , 
                        cin_user   = '$cin'   , 
                        adress_user= '$adress', 
                        city_user  = '$city'  ,
                        image_user = '$imageName'
                        WHERE id_user = '$id'";
                    $result = mysqli_query($connect , $query) ;
                    
                    move_uploaded_file($imageTmp ,"../Files/managers/".$cin."/".$cin.".".$imageExtansion ) ;
                    
                    $_SESSION['succ']  ="Data was Updated" ;
                    header('location:/admin/profile'.$direction ) ;           
                }
            }
        }else{
            $query_email = "SELECT * FROM manager WHERE email_user = '$email'";
            $result_email = mysqli_query($connect , $query_email);
            $arr_email = mysqli_fetch_assoc($result_email);

            $query_old = "SELECT * FROM manager WHERE id_user = '$id' ";
            $result_old = mysqli_query($connect , $query_old);
            $arr_old = mysqli_fetch_assoc($result_old) ;
            
             if(mysqli_num_rows($result_email) == 1 && $arr_email['id_user'] != $id){
                
                $_SESSION['err']  ="Email already token" ;
                header('location:/admin/profile'.$direction ) ;
            }elseif($arr_old['cin_user'] != $cin){
                
                $_SESSION['err']  ="Can't change the CIN.it is UNIQUE." ;
                header('location:/admin/profile'.$direction ) ;
            }elseif(empty($city) && empty($city)){
                $query  = "UPDATE manager SET  
                            lname_user = '$lname' , 
                            fname_user = '$fname' ,
                            email_user = '$email' , 
                            cin_user   = '$cin'  
                            WHERE id_user = '$id'";
                 $result = mysqli_query($connect , $query) ;
                 
                
                $_SESSION['succ']  ="Your Data was Updated" ;
                header('location:/admin/profile'.$direction ) ;    
            }elseif(empty($adress)){
                $query  = "UPDATE manager SET  
                    lname_user = '$lname' , 
                    fname_user = '$fname' ,
                    email_user = '$email' , 
                    cin_user   = '$cin'   , 
                    city_user  = '$city'  
                    WHERE id_user = '$id'";
                $result = mysqli_query($connect , $query) ;
                
                
                $_SESSION['succ']  ="Your Data was Updated" ;
                header('location:/admin/profile'.$direction ) ;    
            }elseif(empty($city)){
                $query  = "UPDATE manager SET  
                    lname_user = '$lname' , 
                    fname_user = '$fname' ,
                    email_user = '$email' , 
                    cin_user   = '$cin'   , 
                    adress_user= '$adress'
                    WHERE id_user = '$id'";
                $result = mysqli_query($connect , $query) ;

                
                $_SESSION['succ']  ="Your Data was Updated" ;
                header('location:/admin/profile'.$direction ) ;   
            }else{
                
                $query  = "UPDATE manager SET  
                    lname_user = '$lname' , 
                    fname_user = '$fname' ,
                    email_user = '$email' , 
                    cin_user   = '$cin'   , 
                    adress_user= '$adress', 
                    city_user  = '$city'  
                    WHERE id_user = '$id'";
                $result = mysqli_query($connect , $query) ;
                
                
                $_SESSION['succ']  ="Your Data was Updated" ;
                header('location:/admin/profile'.$direction ) ;           
            }
        }
    }

}
// ------------- Update Manager to super user ----------
if(isset($_POST['to_super'])){
    $id = unhash_str($_POST['to_super']);
    $q = mysqli_fetch_assoc(
        mysqli_query($connect,"SELECT * FROM manager 
         WHERE is_deleted = 0 AND id_user = '$id' ")
    );
    $is_super = $q['is_super'] ;
    if($is_super){
        $q = mysqli_query($connect,
                "UPDATE manager SET is_super = 0 WHERE is_deleted = 0
                 AND id_user = '$id'") ;
        $_SESSION['succ'] = 'manager is now marked not as a super admin';
    }else{
        $q = mysqli_query($connect,
                "UPDATE manager SET is_super = 1 WHERE is_deleted = 0
                 AND id_user = '$id'") ;
        $_SESSION['succ'] = 'manager is now marked as a super admin';
    }
    header("location:/admin/managers");
}
// ------------- Update Teacher ----------
if(isset($_POST['update-teacher'])){
    if(isset($_POST['id'])){
        $id = unhash_str($_POST['id']) ;
        $lname = validate_input($_POST['lname'] ) ;
        $fname = validate_input($_POST['fname'] ) ;
        $cin = validate_input($_POST['cin'] ) ;
        $adress = validate_input($_POST['adress'] ) ;
        $city = validate_input($_POST['city'] ) ;
        $email = validate_input($_POST['email'] ) ;
        $image = $_FILES['image'] ;
        $imageName = $_FILES['image']['name'] ;
        $imageSize = $_FILES['image']['size']  ;
        $imageTmp = $_FILES['image']['tmp_name']  ;
        $imageExtansion = explode('.', $imageName ) ;
        $imageExtansion = strtolower(end($imageExtansion));
        $extansions = array('jpg','jpeg','png') ;

        if(isset($_SESSION['manager'])) $direction = "?teacher=".$id ;
        elseif(isset($_SESSION['teacher'])) $direction = "" ;

        if(empty($lname) || empty($fname) || empty($cin)  ||  empty($email)   ){
            $_SESSION['err']  ="All fields are required" ;
            header('location:/admin/profile'.$direction) ;
        }elseif(!filter_var($email , FILTER_VALIDATE_EMAIL)){
            $_SESSION['err']  ="Invalid Email."."<br>Exemple : abc@xyz.exp" ;
            header('location:/admin/profile'.$direction) ;
        }elseif(isset($imageName) && !empty($imageName)){
            $imageName = $cin.".".$imageExtansion ;
            if(!is_in($imageExtansion , $extansions)){
                
                $_SESSION['err']  ="File type is not allowed.<br>Only : jpeg, jpg, png." ;
                header('location:/admin/profile'.$direction) ;
            } else{
                $query_email = "SELECT * FROM teacher WHERE email_user = '$email'";
                $result_email = mysqli_query($connect , $query_email);
                $arr_email = mysqli_fetch_assoc($result_email);

                $query_old = "SELECT * FROM teacher WHERE id_user = '$id' ";
                $result_old = mysqli_query($connect , $query_old);
                $arr_old = mysqli_fetch_assoc($result_old) ;
                
                if(mysqli_num_rows($result_email) == 1 && $arr_email['id_user'] != $id){
                    
                    $_SESSION['err']  ="Email already token" ;
                    header('location:/admin/profile'.$direction) ;
                }elseif($arr_old['cin_user'] != $cin){
                    
                    $_SESSION['err']  ="Can't change the CIN.it is UNIQUE." ;
                    header('location:/admin/profile'.$direction) ;
                }elseif(empty($city) && empty($adress)){
                    $query  = "UPDATE teacher SET  
                                lname_user = '$lname' , 
                                fname_user = '$fname' ,
                                email_user = '$email' , 
                                cin_user   = '$cin'   , 
                                image_user = '$imageName'
                                WHERE id_user = '$id'";
                    $result = mysqli_query($connect , $query) ;
                    move_uploaded_file($imageTmp ,"../Files/teachers/".$cin."/".$cin.".".$imageExtansion ) ;
                    
                    $_SESSION['succ']  ="Data was Updated" ;
                    header('location:/admin/profile'.$direction) ;
                }elseif(empty($adress)){
                    $query  = "UPDATE teacher SET  
                        lname_user = '$lname' , 
                        fname_user = '$fname' ,
                        email_user = '$email' , 
                        cin_user   = '$cin'   , 
                        city_user  = '$city'  ,
                        image_user = '$imageName'
                        WHERE id_user = '$id'";
                    $result = mysqli_query($connect , $query) ;
                    move_uploaded_file($imageTmp ,"../Files/teachers/".$cin."/".$cin.".".$imageExtansion ) ;
                    
                    $_SESSION['succ']  ="Data was Updated" ;
                    header('location:/admin/profile'.$direction) ;
                }elseif(empty($city)){
                    $query  = "UPDATE teacher SET  
                        lname_user = '$lname' , 
                        fname_user = '$fname' ,
                        email_user = '$email' , 
                        cin_user   = '$cin'   , 
                        adress_user= '$adress', 
                        image_user = '$imageName'
                        WHERE id_user = '$id'";
                    $result = mysqli_query($connect , $query) ;
                    move_uploaded_file($imageTmp ,"../Files/teachers/".$cin."/".$cin.".".$imageExtansion ) ;
                    
                    $_SESSION['succ']  ="Data was Updated" ;
                    header('location:/admin/profile'.$direction) ;
                }else{
                    $query  = "UPDATE teacher SET  
                        lname_user = '$lname' , 
                        fname_user = '$fname' ,
                        email_user = '$email' , 
                        cin_user   = '$cin'   , 
                        adress_user= '$adress', 
                        city_user  = '$city'  ,
                        image_user = '$imageName'
                        WHERE id_user = '$id'";
                    $result = mysqli_query($connect , $query) ;
                    move_uploaded_file($imageTmp ,"../Files/teachers/".$cin."/".$cin.".".$imageExtansion ) ;
                    $_SESSION['succ']  ="Data was Updated" ;
                    header('location:/admin/profile'.$direction) ;          
                }
            }
        }else{
            $query_email = "SELECT * FROM teacher WHERE email_user = '$email'";
            $result_email = mysqli_query($connect , $query_email);
            $arr_email = mysqli_fetch_assoc($result_email);

            $query_old = "SELECT * FROM teacher WHERE id_user = '$id' ";
            $result_old = mysqli_query($connect , $query_old);
            $arr_old = mysqli_fetch_assoc($result_old) ;

            if(mysqli_num_rows($result_email) == 1 && $arr_email['id_user'] != $id){
                $_SESSION['err']  ="Email already token" ;
                header('location:/admin/profile'.$direction) ;
            }elseif($arr_old['cin_user'] != $cin){
                
                $_SESSION['err']  ="Can't change the CIN.it is UNIQUE." ;
                header('location:/admin/profile'.$direction) ;
            }elseif(empty($city) && empty($city)){
                $query  = " UPDATE teacher SET  
                            lname_user = '$lname' , 
                            fname_user = '$fname' ,
                            email_user = '$email' , 
                            cin_user   = '$cin'   
                            WHERE id_user = '$id'";
                 $result = mysqli_query($connect , $query) ;
                 
                $_SESSION['succ']  ="Your Data was Updated" ;
                header('location:/admin/profile'.$direction) ;
            }elseif(empty($adress)){
                $query  = "UPDATE teacher SET  
                    lname_user = '$lname' , 
                    fname_user = '$fname' ,
                    email_user = '$email' , 
                    cin_user   = '$cin'   , 
                    city_user  = '$city'  
                    WHERE id_user = '$id'";
                $result = mysqli_query($connect , $query) ;
                
                $_SESSION['succ']  ="Your Data was Updated" ;
                header('location:/admin/profile'.$direction) ;
            }elseif(empty($city)){
                $query  = "UPDATE teacher SET  
                    lname_user = '$lname' , 
                    fname_user = '$fname' ,
                    email_user = '$email' , 
                    cin_user   = '$cin'   , 
                    adress_user= '$adress'
                    WHERE id_user = '$id'";
                $result = mysqli_query($connect , $query) ;
                
                $_SESSION['succ']  ="Your Data was Updated" ;
                header('location:/admin/profile'.$direction) ;
            }else{
                
                $query  = "UPDATE teacher SET  
                    lname_user = '$lname' , 
                    fname_user = '$fname' ,
                    email_user = '$email' , 
                    cin_user   = '$cin'   , 
                    adress_user= '$adress', 
                    city_user  = '$city'  
                    WHERE id_user = '$id'";
                $result = mysqli_query($connect , $query) ;
                
                
                $_SESSION['succ']  ="Your Data was Updated" ;
                header('location:/admin/profile'.$direction) ;     
            }
        }
    }

}
// ------------- Update Student ----------
if(isset($_POST['update-student'])){
    if(isset($_POST['id'])){
        $id = unhash_str($_POST['id']) ;
        $lname = validate_input($_POST['lname'] ) ;
        $fname = validate_input($_POST['fname'] ) ;
        $cin = validate_input($_POST['cin'] ) ;
        $cne = validate_input($_POST['cne'] ) ;
        $adress = validate_input($_POST['adress'] ) ;
        $city = validate_input($_POST['city'] ) ;
        $email = validate_input($_POST['email'] ) ;
        $image = $_FILES['image'] ;
        $imageName = $_FILES['image']['name'] ;
        $imageSize = $_FILES['image']['size']  ;
        $imageTmp = $_FILES['image']['tmp_name']  ;
        $imageExtansion = explode('.', $imageName ) ;
        $imageExtansion = strtolower(end($imageExtansion));
        $extansions = array('jpg','jpeg','png') ;
        if(isset($_SESSION['manager'])) $direction = "?student=".$id ;
        elseif(isset($_SESSION['student'])) $direction = "" ;
        if(empty($lname) || empty($fname) || empty($cin) || empty($cne)  ||  empty($email)  ){
            
            $_SESSION['err']  =" fields with * are required" ;
            header('location:/admin/profile'.$direction) ;
        }elseif(!filter_var($email , FILTER_VALIDATE_EMAIL)){
            $_SESSION['err']  ="Invalid Email."."<br>Exemple : abc@xyz.exp" ;
            header('location:/admin/profile'.$direction) ;
        }elseif(isset($imageName) && !empty($imageName)){
            $imageName = $cin.".".$imageExtansion ;
            if(!is_in($imageExtansion , $extansions)){
                
                $_SESSION['err']  ="File type is not allowed.<br>Only : jpeg, jpg, png." ;
                header('location:/admin/profile'.$direction) ;
            } else{
                
                $query_email = "SELECT * FROM student WHERE email_user = '$email'";
                $result_email = mysqli_query($connect , $query_email);
                $arr_email = mysqli_fetch_assoc($result_email);

                $query_old = "SELECT * FROM student WHERE id_user = '$id' ";
                $result_old = mysqli_query($connect , $query_old);
                $arr_old = mysqli_fetch_assoc($result_old) ;
                
                if(mysqli_num_rows($result_email) == 1 && $arr_email['id_user'] != $id){
                    
                    $_SESSION['err']  ="Email already token" ;
                    header('location:/admin/profile'.$direction) ;
                }elseif($arr_old['cin_user'] != $cin){
                    
                    $_SESSION['err']  ="Can't change the CIN.it is UNIQUE." ;
                    header('location:/admin/profile'.$direction) ;
                }elseif(empty($city) && empty($city)){
                    $query  = "UPDATE student SET  
                                lname_user = '$lname' , 
                                fname_user = '$fname' ,
                                email_user = '$email' , 
                                cin_user   = '$cin'   , 
                                cne_student   = '$cne', 
                                image_user = '$imageName'
                                WHERE id_user = '$id'";
                     $result = mysqli_query($connect , $query) ;
                   
                     move_uploaded_file($imageTmp ,"../Files/students/".$cin."/".$cin.".".$imageExtansion ) ;
                     
                     $_SESSION['succ']  ="Data was Updated" ;
                     header('location:/admin/profile'.$direction) ;
                }elseif(empty($adress)){
                    $query  = "UPDATE student SET  
                        lname_user = '$lname' , 
                        fname_user = '$fname' ,
                        email_user = '$email' , 
                        cin_user   = '$cin'   ,
                        cne_student   = '$cne' ,  
                        city_user  = '$city'  ,
                        image_user = '$imageName' 
                        WHERE id_user = '$id'";
                    $result = mysqli_query($connect , $query) ;
                    
                    move_uploaded_file($imageTmp ,"../Files/students/".$cin."/".$cin.".".$imageExtansion ) ;
                    
                    $_SESSION['succ']  ="Data was Updated" ;
                    header('location:/admin/profile'.$direction) ;
                }elseif(empty($city)){
                    $query  = "UPDATE student SET  
                        lname_user = '$lname' , 
                        fname_user = '$fname' ,
                        email_user = '$email' , 
                        cin_user   = '$cin'   ,
                        cne_student   = '$cne' ,  
                        adress_user= '$adress' , 
                        image_user = '$imageName'
                        WHERE id_user = '$id'";
                    $result = mysqli_query($connect , $query) ;
                  
                    move_uploaded_file($imageTmp ,"../Files/students/".$cin."/".$cin.".".$imageExtansion ) ;
                    
                    $_SESSION['succ']  ="Data was Updated" ;
                    header('location:/admin/profile'.$direction) ;   
                }else{
                    
                    $query  = "UPDATE student SET  
                        lname_user = '$lname' , 
                        fname_user = '$fname' ,
                        email_user = '$email' , 
                        cin_user   = '$cin'   , 
                        cne_student   = '$cne' , 
                        adress_user= '$adress', 
                        city_user  = '$city'  ,
                        image_user = '$imageName' 
                        WHERE id_user = '$id'";
                    $result = mysqli_query($connect , $query) ;
                  
                    move_uploaded_file($imageTmp ,"../Files/students/".$cin."/".$cin.".".$imageExtansion ) ;
                    
                    $_SESSION['succ']  ="Data was Updated" ;
                    header('location:/admin/profile'.$direction) ;           
                }
            }
        }else{
            $query_email = "SELECT * FROM student WHERE email_user = '$email'";
            $result_email = mysqli_query($connect , $query_email);
            $arr_email = mysqli_fetch_assoc($result_email);

            $query_old = "SELECT * FROM student WHERE id_user = '$id' ";
            $result_old = mysqli_query($connect , $query_old);
            $arr_old = mysqli_fetch_assoc($result_old) ;
            
            if(mysqli_num_rows($result_email) == 1 && $arr_email['id_user'] != $id){
                
                $_SESSION['err']  ="Email already token" ;
                header('location:/admin/profile'.$direction) ;
            }elseif($arr_old['cin_user'] != $cin){
                
                $_SESSION['err']  ="Can't change the CIN.it is UNIQUE." ;
                header('location:/admin/profile'.$direction) ;
            }elseif(empty($city) && empty($city)){
                $query  = "UPDATE student SET  
                            lname_user = '$lname' , 
                            fname_user = '$fname' ,
                            email_user = '$email' , 
                            cin_user   = '$cin'   , 
                            cne_student   = '$cne' 
                            WHERE id_user = '$id'";
                 $result = mysqli_query($connect , $query) ;
                 
                 
                $_SESSION['succ']  ="Your Data was Updated" ;
                header('location:/admin/profile'.$direction) ;  
            }elseif(empty($adress)){
                $query  = "UPDATE student SET 
                    lname_user = '$lname' , 
                    fname_user = '$fname' ,
                    email_user = '$email' , 
                    cin_user   = '$cin'   , 
                    cne_student   = '$cne' , 
                    city_user  = '$city'  
                    WHERE id_user = '$id'";
                $result = mysqli_query($connect , $query) ;
                
                $_SESSION['succ']  ="Your Data was Updated" ;
                header('location:/admin/profile'.$direction) ; 
            }elseif(empty($city)){
                $query  = "UPDATE student SET  
                    lname_user = '$lname' , 
                    fname_user = '$fname' ,
                    email_user = '$email' , 
                    cin_user   = '$cin'   , 
                    cne_student   = '$cne' , 
                    adress_user= '$adress' 
                    WHERE id_user = '$id'";
                $result = mysqli_query($connect , $query) ;

                
                $_SESSION['succ']  ="Your Data was Updated" ;
                header('location:/admin/profile'.$direction) ;
            }else{
                
                $query  = "UPDATE student SET  
                    lname_user = '$lname' , 
                    fname_user = '$fname' ,
                    email_user = '$email' , 
                    cin_user   = '$cin'   ,
                    cne_student   = '$cne' ,  
                    adress_user= '$adress', 
                    city_user  = '$city'  
                    WHERE id_user = '$id'";
                $result = mysqli_query($connect , $query) ;
              
                $_SESSION['succ']  ="Your Data was Updated" ;
                header('location:/admin/profile'.$direction) ;        
            }
        }
    }

}
/* ---------------- Update Branch ---------------- */
if(isset($_POST['update-branch']) && isset($_POST['branch']) ){
    $id_branch = unhash_str($_POST['branch'] ) ;
    $branch = validate_input($_POST['title'] ) ;
    $descript =  $_POST['description'] ;

    if(empty($branch) || empty($descript)){
        
        $_SESSION['err']  ="All fields are required" ;
        header('location:/admin/branches?branch='.hash_str($id_branch).'&edit') ;
        
    }else{
        $query = "SELECT * FROM branch 
                    WHERE title_branch = '$branch' 
                    AND id_branch != '$id_branch'";
        $result = mysqli_query($connect,$query) ;
        if(mysqli_num_rows($result) != 0){
            
            $_SESSION['err']  ="This Branch Already Exist" ;
            header('location:/admin/branches?branch='.$id_branch.'&edit') ;
        }else{
            $query  = "UPDATE branch 
                        SET title_branch = '$branch', description_branch = '$descript' 
                        WHERE id_branch='$id_branch'";
            $result = mysqli_query($connect , $query) ;
            
            $_SESSION['succ']  =" Branch was Updated" ;
            header('location:/admin/branches') ;
        }
    }
}

/* ---------------- Update Classroom ---------------- */
if(isset($_POST['update-classroom'])){
    $classroom = validate_input($_POST['classroom'] ) ;
    $id_classroom = validate_input(unhash_str($_POST['cr']) ) ;
    if(empty($classroom)){
        
        $_SESSION['err']  ="This field is required" ;
        header('location:/admin/classrooms?cr='.$id_classroom."&edit") ;
    }else{
        $query = "SELECT * FROM classroom 
                    WHERE title_classroom = '$classroom' 
                    AND id_classroom != '$id_classroom'";
        $result = mysqli_query($connect,$query) ;
        if(mysqli_num_rows($result) != 0){
            
            $_SESSION['err']  ="This Classroom Already Exist" ;
            header('location:/admin/classrooms?cr='.$id_classroom."&edit") ;
        }else{
            $query  = "UPDATE classroom 
                        SET title_classroom = '$classroom' 
                        WHERE id_classroom = '$id_classroom'";
            $result = mysqli_query($connect , $query) ;
            
            $_SESSION['succ']  =" Classroom was Updated" ;
            header('location:/admin/classrooms') ;
        }
    }
}

/* ---------------- Update Class ---------------- */
if(isset($_POST['update-class'])){
    $class = validate_input($_POST['class'] ) ;
    $id_class = validate_input(unhash_str($_POST['cl']) ) ;
    $branch = validate_input(unhash_str($_POST['branch']) ) ;

    $query_branch = "SELECT * FROM branch WHERE id_branch ='$branch' "; 
    $result_branch = mysqli_query($connect , $query_branch) ;
    $arr_branch = mysqli_fetch_assoc($result_branch);
    $id_branch = $arr_branch['id_branch'] ;

    if(empty($class) || empty($branch)){
        
        $_SESSION['err']  ="All fields are required" ;
        header('location:/admin/classes?cl='.$id_class.'&edit') ;
    }else{
        $query_class = "SELECT * FROM class 
                        WHERE title_class ='$class' 
                        AND id_branch = '$id_branch' 
                        AND id_class != '$id_class' "; 
        $result_class = mysqli_query($connect , $query_class) ;
        if(mysqli_num_rows($result_class) != 0 ){
            
            $_SESSION['err']  ="Class Already Exist." ;
            header('location:/admin/classes?cl='.$id_class.'&edit') ; 
        }else{
            $query  = "UPDATE class 
                        SET title_class = '$class' , id_branch = '$id_branch' 
                        WHERE id_class = '$id_class'";
            $result = mysqli_query($connect , $query) ;
            
            $_SESSION['succ']  ="Class was Updated" ;
            header('location:/admin/classes') ;
        }
    }
}

/* ---------------- update Module ---------------- */
if(isset($_POST['update-module'])){
    $module = $_POST['module'] ;
    $id = unhash_str($_POST['id'] ) ;
    $q = mysqli_query($connect,"SELECT * from module 
                        where is_deleted=0 AND title = '$module'
                        AND id_module != '$id' ") ;
    if(mysqli_num_rows($q)){
        $_SESSION['err']  ="Module Title already exist" ;
        header('location:/admin/modules?edit&module='.$id) ;
    }else{
        mysqli_query($connect,
                "UPDATE module SET title = '$module'  WHERE id_module = '$id' ") ;
        $_SESSION['succ']  =" module was updated" ;
        header('location:/admin/modules') ;
    }
}
/* ---------------- update Subject ---------------- */
if(isset($_POST['update-subject']) && isset($_POST['sbj'] )){
    $subject = validate_input($_POST['subject'] ) ;
    $id_subject = validate_input( unhash_str($_POST['sbj']) ) ;
    if(isset($_POST['module'])){
         $module = $_POST['module'] ;
         $percentage = $_POST['percentage'] ;
    }else{
        $module = 0 ;
        $percentage = 0 ;
    } 
    if(isset($_POST['coefficient'])){
        $coefficient = $_POST['coefficient'] ;
   }else{
       $coefficient = 0 ;
   } 

    if(empty($subject) ){
        $_SESSION['err']  ="All fields are required" ;
        header('location:/admin/subjects?sbj='.$id_subject.'&edit') ;
    }else{
        $query = "SELECT * FROM subject 
                    WHERE title_subject='$subject' 
                    AND id_subject != '$id_subject'" ;
        $result = mysqli_query($connect , $query) ;
        if(mysqli_num_rows($result) != 0 ){
            $_SESSION['err']  ="Subject Already Exist." ;
            header('location:/admin/subjects?sbj='.$id_subject.'&edit') ;
        }else{
            $query  = "UPDATE subject 
                        SET title_subject = '$subject', 
                         id_module = '$module',
                         coefficient = '$coefficient',
                         percentage = '$percentage'
                        WHERE id_subject = '$id_subject'";
            $result = mysqli_query($connect , $query) ;
            
            $_SESSION['succ']  ="Subject was Updated" ;
            header('location:/admin/subjects') ;
    
        }
    }
}
/* ---------------- Update Unite ---------------- */
if(isset($_POST['update-unit'])){
    $unit = $_POST['unit'] ;
    $subject = $_POST['subject'] ;
    $id_unit = unhash_str( $_POST['id'] ) ;
    $q = mysqli_query($connect,"SELECT * from unit where is_deleted=0 AND title_unit = '$unit' AND id_unit != '$id_unit' ") ;
    if(mysqli_num_rows($q)){
        $_SESSION['err']  ="Unit Title already exist" ;
        header('location:/admin/unites?edit&unit='.$_POST['id']) ;
    }else{
        mysqli_query($connect,
            "UPDATE unit SET title_unit = '$unit' , id_subject = '$subject' WHERE id_unit = '$id_unit' "
                ) ;
        $_SESSION['succ']  =" unit was updated" ;
        header('location:/admin/unites') ;
    }
}
/* ---------------- Update Session ---------------- */
if(isset($_POST['update-session']) && isset($_POST['session']) && !empty($_POST['session']) ){
    $id_session = unhash_str($_POST['session']) ;
    $start = validate_input($_POST['start'] ) ;
    $end = validate_input( $_POST['end'] ) ;

    if(empty($start) || empty($end)){
        
        $_SESSION['err']  ="All fields are required" ;
        header('location:/admin/sessions?session='.$id_session.'&edit') ;
        
    }else{
        $query = "SELECT * FROM session 
                    WHERE date_start = '$start' 
                    AND date_end = '$end'
                    AND id_session != '$id_session'";
        $result = mysqli_query($connect,$query) ;
        if(mysqli_num_rows($result) != 0){
            
            $_SESSION['err']  ="This Session Already Exist" ;
            header('location:/admin/sessions?session='.$id_session.'&edit') ;
        }elseif($end - $start != 1){
            
            $_SESSION['err']  ="dates does'nt matched" ;
            header('location:/admin/sessions?session='.$id_session.'&edit') ;
        }else{
            $query  = "UPDATE session 
                        SET date_start = '$start', date_end = '$end' 
                        WHERE id_session='$id_session'";
            $result = mysqli_query($connect , $query) ;
            
            $_SESSION['succ']  =" Session was Updated" ;
            header('location:/admin/sessions') ;
        }
    }
}

/* ---------------- Update Semester ---------------- */
if(isset($_POST['update-semester'])){
    $id_semester = unhash_str($_POST['smstr']);
    $semester = validate_input($_POST['semester'] ) ;
    $id_session = validate_input(unhash_str($_POST['session'] )) ;
    $session = mysqli_fetch_assoc(mysqli_query($connect,
        "SELECT * FROM session WHERE id_session = '$id_session' AND is_deleted = 0"
    ));
    $start = $session['date_start'] ;
    $end = $session['date_end'] ;

    $query_session = "SELECT * FROM session WHERE date_start ='$start' AND date_end= '$end' "; 
    $result_session = mysqli_query($connect , $query_session) ;
    $arr_session = mysqli_fetch_assoc($result_session);
    $id_session = $arr_session['id_session'] ;

    if(empty($semester) || empty($session)){
        
        $_SESSION['err']  ="All fields are required" ;
        header('location:/admin/semesters?smstr='.$id_semester.'&edit') ;
    }else{
        $query_semester = "SELECT * FROM semester 
                        WHERE title_semester ='$semester' 
                        AND id_session = '$id_session' 
                        AND id_semester != '$id_semester' "; 
        $result_semester = mysqli_query($connect , $query_semester) ;
        if(mysqli_num_rows($result_semester) != 0 ){
            
            $_SESSION['err']  ="Semester Already Exist." ;
            header('location:/admin/semesters?smstr='.$id_semester.'&edit') ;
        }else{
            $query  = "UPDATE semester 
                        SET title_semester = '$semester' , id_session = '$id_session' 
                        WHERE id_semester = '$id_semester'";
            $result = mysqli_query($connect , $query) ;
            
            $_SESSION['succ']  ="Semester was Updated" ;
           header('location:/admin/semesters') ;
        }
    }
}



// ------------- Allow Insert Marks ----------
if(isset($_POST['allow-insert-marks'])){
    $q = mysqli_query($connect,
                "UPDATE setting SET allow_insert_marks = 1");
    $_SESSION['succ']  = "Now teachers can insert Marks";
    header('location:../setting?marks-setting');
}

// ------------- Prevent Insert Marks ----------
if(isset($_POST['prevent-insert-marks'])){
    $q = mysqli_query($connect,
                "UPDATE setting SET allow_insert_marks = 0");
    $_SESSION['succ']  = "Now teachers can't insert Marks";
    header('location:../setting?marks-setting');
}

// ------------- Allow Showing Marks ----------
if(isset($_POST['allow-show-marks'])){
    $q = mysqli_query($connect,
                "UPDATE setting SET allow_showing_marks = 1");
    $_SESSION['succ']  = "Now teachers can insert Marks";
    header('location:../setting?marks-setting');
}

// ------------- Prevent Showing Marks ----------
if(isset($_POST['prevent-show-marks'])){
    $q = mysqli_query($connect,
                "UPDATE setting SET allow_showing_marks = 0");
    $_SESSION['succ']  = "Now teachers can't insert Marks";
    header('location:../setting?marks-setting');
}

// ------------- Allow Inscription ----------
if(isset($_POST['allow-inscription'])){
    $q = mysqli_query($connect,
                "UPDATE setting SET allow_inscription = 1");
    $_SESSION['succ']  = "Inscription is Start";
    header('location:../setting?inscription');
}

// ------------- Prevent Inscription ----------
if(isset($_POST['prevent-inscription'])){
    $q = mysqli_query($connect,
                "UPDATE setting SET allow_inscription = 0");
    $_SESSION['succ']  = "Inscription is End";
    header('location:../setting?inscription');
}

/* ---------------- Update Marks ---------------- */
if(isset($_POST['update-mark'])){

    $subject = unhash_str($_POST['subj'])  ;
    $group = unhash_str($_POST['group'])  ;
    $students = $_POST['user'] ;
    $marks = $_POST['mark']  ;

    if(isset($_POST['user']) && !empty($_POST['user'])
        && isset($_POST['subj']) && !empty($_POST['subj'])
        && isset($_POST['group']) && !empty($_POST['group'])
        && isset($_POST['mark']) && !empty($_POST['mark'])){
        for($i = 0 ; $i < count($students); $i++){
            $student =unhash_str($students[$i] ) ; 
            $mark = $marks[$i] ; 

            if( $mark == ''){
                continue ;
            }elseif($mark > 20 || $mark < 0 ){
                $_SESSION['err'] = "mark should be between 0 and 20 ";
                header("location:/admin/marks?subj=".hash_str($subject)."&group=".hash_str($group)."&edit" );
            }else{
                $result = mysqli_query($connect ,
                        "UPDATE mark_subject 
                        SET  mark_subject = '$mark'
                        WHERE id_subject = '$subject'
                        AND id_user = '$student'
                         ") ;
                
                $_SESSION['succ'] = "Well done";
                header("location:/admin/marks?subj=".hash_str($subject)."&group=".hash_str($group));
            }
        } 

    }else{
            
            $_SESSION['err'] = "Enter Mark First";
            header("location:/admin/marks?subj=".hash_str($subject)."&group=".hash_str($group)."&edit");
        
    }
}

/* ---------------- Update Event ---------------- */
if(isset($_POST['update-event'])){
    $event = unhash_str($_POST['event']) ;
    $title = validate_input($_POST['title']) ;
    $date = validate_input($_POST['date']) ;
    $time = validate_input($_POST['time']) ;
    $locate = validate_input($_POST['location']) ;
    $description = $_POST['description'] ;
    
    $imageName = $_FILES['image']['name'] ;
    $imageSize = $_FILES['image']['size'] ;
    $imageTmp = $_FILES['image']['tmp_name'] ;
    $extansions = array('jpg','jpeg','png') ;
    if(empty($title) || empty($date) || empty($time)  ||  empty($locate) || empty($description) ){
        $_SESSION['err'] = "fields with * are required ";
        header("location:/admin/events?edit&event=".$_POST['event'] );
    }else{
        if(empty($imageName)){
            echo $title ;
            $q = mysqli_query($connect , 
                    "UPDATE  events 
                     SET event_title  = '$title',
                      event_date = '$date',
                      event_time = '$time',
                      event_location = '$locate',
                      description = '$description'
                     WHERE id_event = '$event' "
                ) ;
                print_r( mysqli_error($connect) );
            $_SESSION['succ'] = "Event Updated Successfully " ;
            header("location:/admin/events" );
        }else{
            $img_to_array = explode('.',$imageName);
            $imageExtansion = end($img_to_array) ;
            if(!is_in($imageExtansion , $extansions)){
                $_SESSION['err'] = "thumbnail type is not allowed";
                header("location:/admin/events?edit&event=".$_POST['event'] );
            }else{
                $q = mysqli_query($connect , 
                    "UPDATE  events 
                     SET event_title  = '$title',
                      event_date = '$date',
                      event_time = '$time',
                      event_location = '$locate',
                      description = '$description' ,
                      event_image = '$imageName'
                     WHERE id_event = '$event' "
                ) ;
                move_uploaded_file($imageTmp , "../Files/events/".$imageName);
                $_SESSION['succ'] = "Event updated Successfully " ;
                header("location:/admin/events?edit&event=".$_POST['event'] );
                }
        }
    }
}

/* ---------------- Update Password ---------------- */
if(isset($_POST['change-password'])){
    $new = $_POST['new'] ;
    $confirm = $_POST['confirm'] ;
    $user = $_POST['user']; 
    $id = unhash_str($_POST['id']) ;
    if(isset($_SESSION['manager'])){
        if($user == 'manager' && $id == $_SESSION['manager']){
            $direction = "";
        }elseif($user == 'manager' && $id != $_SESSION['manager'] ){
            $direction = "&manager=".$id;
        }elseif($user == 'teacher'){
            $direction = "&teacher=".$id;
        }if($user == 'student'){
            $direction = "&student=".$id;
        }
    }else{
        $direction = "";
    }

    if(strlen($new) < 8 ){
        $_SESSION['err'] = "password lentgh should be 8 caractere at least";
        header('location:/admin/profile?password'.$direction);
    }elseif($new != $confirm){
        $_SESSION['err'] = "Passwords dosnt matched";
        header('location:/admin/profile?password'.$direction);
    }else{
        $pass = password_hash($new,PASSWORD_DEFAULT);
        if($user == 'manager'){
            $q = mysqli_query($connect,
                "UPDATE manager SET password = '$pass' WHERE id_user = '$id'");
        }elseif($user == 'teacher'){
            $q = mysqli_query($connect,
                "UPDATE teacher SET password = '$pass' WHERE id_user = '$id'");
        }elseif($user == 'student'){
            $q = mysqli_query($connect,
                "UPDATE student SET password = '$pass' WHERE id_user = '$id'");
        }
        
        $_SESSION['succ'] = "Password was changed successfully";
        header('location:/admin/profile?password'.$direction);
    }
}

if(isset($_POST['read-notificfation'])){
    $notifications = $_POST['notification'] ;
    print_r($notifications) ;
    for($i=0 ; $i< count($notifications); $i++){
        mysqli_query(
            $connect ,
            "UPDATE notification SET is_read = 1 
             WHERE id_notification = ".$notifications[$i]
        );
    }
    header('location:/admin/dashboard') ;
}






}
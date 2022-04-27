<?php
session_start();
require_once('../../connection.php') ;
include('functions.php') ;
include('../fpdf/fpdf.php');

$school = mysqli_fetch_assoc(
    mysqli_query($connect, "SELECT * FROM school")
) ;
if(isset($_SESSION['user'])){


/* ---------------- Build the school  ---------------- */
if(isset($_POST['build-school'])){

    $name = validate_input($_POST['name'] ) ;
    $city = validate_input($_POST['city'] ) ;
    $adress = validate_input($_POST['adress' ]) ;
    $type = validate_input($_POST['type'] ) ;
    $email = validate_input($_POST['email'])  ;
    $tele = validate_input($_POST['tele'] ) ;

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
            " INSERT INTO school (name,city,adress,type,email)
              VALUES('$name','$city','$adress','$type','$email')");
        $_SESSION['succ'] = "Now You can use your Website.";
        header('location:/admin/setting?school') ;
    }elseif(empty($logoName)){
        $q = mysqli_query($connect,
            " INSERT INTO school (name,city,adress,type,email,tele)
              VALUES('$name','$city','$adress','$type','$email','$tele')");
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
                " INSERT INTO school (name,city,adress,type,email,tele,logo)
                VALUES('$name','$city','$adress','$type','$email','$tele','$logoName')");
            $_SESSION['succ'] = "Now You can use your Website.";
            move_uploaded_file($logoTemp, "../Files/Custom/".$logoName);
            header('location:/admin/setting?school') ;
        }
    }
    


    


}
/* ---------------- Insert New Module ---------------- */
if(isset($_POST['insert-module'])){
    $module = $_POST['module'] ;
    $q = mysqli_query($connect,"SELECT * from module where is_deleted=0 AND title = '$module' ") ;
    if(mysqli_num_rows($q)){
        $_SESSION['err']  ="Module Title already exist" ;
        header('location:/admin/modules?add') ;
    }else{
        mysqli_query($connect,
                "INSERT INTO module(title )
                 VALUES ('$module')") ;
        $_SESSION['succ']  ="New module was Added" ;
        header('location:/admin/modules') ;
    }
}
/* ---------------- Insert New Subject ---------------- */
if(isset($_POST['insert-subject'])){
    $subject = validate_input($_POST['subject'] ) ;
    if(isset($_POST['module'])){ 
        $module = $_POST['module'] ; 
    }else{
        $module = 0 ;
    }
    if(isset($_POST['coefficient'])){ 
        $coefficient = $_POST['coefficient'] ; 
    }else{
        $coefficient = 0 ;
    }
    if(isset($_POST['percentage'])){ 
        $percentage = $_POST['percentage'] ; 
    }else{
        $percentage = 0 ;
    }
    
        $query = "SELECT * FROM subject WHERE title_subject='$subject'"; ;
        $result = mysqli_query($connect , $query) ;
        if(mysqli_num_rows($result) != 0 ){
            $_SESSION['err']  ="Subject Already Exist." ;
            header('location:/admin/subjects?add') ; 
        }else{
            $query  = "INSERT INTO subject (title_subject, id_module,coefficient,percentage) 
                        VALUES('$subject','$module','$coefficient','$percentage')";
                        
            $result = mysqli_query($connect, $query) ;
            $_SESSION['succ']  ="New Subject was Added" ;
            header('location:/admin/subjects') ;
        }
}
/* ---------------- Insert New Unite ---------------- */
if(isset($_POST['insert-unit'])){
    $unit = $_POST['unit'] ;
    $subject = $_POST['subject'] ;
    $q = mysqli_query($connect,"SELECT * from unit where is_deleted=0 AND title_unit = '$unit' ") ;
    if(mysqli_num_rows($q)){
        $_SESSION['err']  ="Unit Title already exist" ;
        header('location:/admin/unites?add') ;
    }else{
        mysqli_query($connect,
                "INSERT INTO unit(title_unit , id_subject)
                 VALUES ('$unit','$subject')") ;
        $_SESSION['succ']  ="New unit was Added" ;
        header('location:/admin/unites') ;
    }
}
/* ---------------- Insert New Branch ---------------- */
if(isset($_POST['insert-branch'])){
    $branch = validate_input($_POST['title'] ) ;
    $descript =  $_POST['description']  ;
    
    if( empty($branch) || empty($descript)){
        
        $_SESSION['err']  ="All fields are required" ;
        header('location:/admin/branches?add') ;
    }else{
        $query = "SELECT * FROM branch WHERE title_branch='$branch'"; ;
        $result = mysqli_query($connect , $query) ;
        if(mysqli_num_rows($result) != 0 ){
            
            $_SESSION['err']  ="Branch Already Exist." ;
            header('location:/admin/branches?add') ; 
        }else{
            $query  = "INSERT INTO branch(title_branch,description_branch) VALUES('$branch','$descript')";
            $result = mysqli_query($connect , $query) ;
            
            $_SESSION['succ']  ="New Branch was Added" ;
            header('location:/admin/branches') ;
        }
    }
}

/* ---------------- Insert New Class ---------------- */
if(isset($_POST['insert-class'])){
    $class = validate_input($_POST['class'] ) ;
    $branch = validate_input(unhash_str($_POST['branch']) ) ;

    if(empty($class) || empty($branch)){
        
        $_SESSION['err']  ="All fields are required" ;
        // header('location:/admin/classes?add') ;
    }else{
        $query_branch = "SELECT * FROM branch WHERE id_branch ='$branch' "; 
        $result_branch = mysqli_query($connect , $query_branch) ;
        $arr_branch = mysqli_fetch_assoc($result_branch);
        $id_branch = $arr_branch['id_branch'] ;

        $query_class = "SELECT * FROM class WHERE title_class='$class' AND id_branch = '$id_branch' "; 
        $result_class = mysqli_query($connect , $query_class) ;

        if(mysqli_num_rows($result_class) != 0 ){
            
            $_SESSION['err']  ="Class Already Exist." ;
            header('location:/admin/classes?add') ; 
        }else{
            $query  = "INSERT INTO class( title_class,id_branch ) VALUES('$class','$id_branch')";
            $result = mysqli_query($connect , $query) ;
            
            $_SESSION['succ']  ="New Class was Added" ;
            header('location:/admin/classes') ;
        }
    }
}

/* ---------------- Insert New Classroom ---------------- */
if(isset($_POST['insert-classroom'])){
    $classroom = validate_input($_POST['classroom'] ) ;

    if(empty($classroom)){
        
        $_SESSION['err']  ="This field is required" ;
        header('location:/admin/classrooms?add') ;
    }else{
        $query = "SELECT * FROM classroom WHERE title_classroom='$classroom'"; ;
        $result = mysqli_query($connect , $query) ;
        if(mysqli_num_rows($result) != 0 ){
            
            $_SESSION['err']  ="Classrom Already Exist." ;
            header('location:/admin/classrooms?add') ; 
        }else{
            $query  = "INSERT INTO classroom( title_classroom ) VALUES('$classroom')";
            $result = mysqli_query($connect , $query) ;
            
            $_SESSION['succ']  ="New Classroom was Added" ;
            header('location:/admin/classrooms') ;
        }
    }
}

/* ---------------- Insert New Manager ---------------- */
if(isset($_POST['insert-manager'])){
    $lname = validate_input($_POST['lname'] ) ;
    $fname = validate_input($_POST['fname'] ) ;
    $cin = validate_input($_POST['cin'] ) ;
    $adress = validate_input($_POST['adress'] ) ;
    $city = validate_input($_POST['city'] ) ;
    $email = validate_input($_POST['email'] ) ;
    $password = password_hash( validate_input($_POST['password'] ) , PASSWORD_DEFAULT) ;
    $image = $_FILES['image'] ;
    $imageName = $_FILES['image']['name'] ;
    $imageSize = $_FILES['image']['size']  ;
    $imageTmp = $_FILES['image']['tmp_name']  ;
   
    $extansions = array('jpg','jpeg','png') ;

    if(empty($lname) || empty($fname) || empty($cin)  ||  empty($email) || empty($password) ){
        
        $_SESSION['err']  ="fields with (*) are required" ;
        header('location:/admin/managers?add') ;
    }elseif(!filter_var($email , FILTER_VALIDATE_EMAIL)){
        
        $_SESSION['err']  ="Invalid Email."."<br>Exemple : abc@xyz.exp" ;
        header('location:/admin/managers?add') ;
    }elseif(strlen($password) < 8){
        
        $_SESSION['err']  ="Password's lenght should be at least 8 characters." ;
        header('location:/admin/managers?add') ;
    }elseif(isset($imageName) && !empty($imageName)){
        $imageExtansion = end(explode('.', $_FILES['image']['name'] ) );
        if( !is_in($imageExtansion , $extansions)){
            
            $_SESSION['err']  ="Invalid file."."<br>Allowed : jpg, jpeg, png" ;
            header('location:/admin/managers?add') ;
        }else{
            $mail = "SELECT email_user FROM manager WHERE email_user = '$email'" ;
            $result_mail = mysqli_query($connect , $mail) ;
            $imageName = $cin.".".$imageExtansion ;
            if(mysqli_num_rows($result_mail) == 1){
                
                $_SESSION['err']  ="Email already token" ;
                header('location:/admin/managers?add') ;
            }else{
                $query  = "INSERT INTO 
                    manager( lname_user , fname_user ,email_user , cin_user , adress_user , city_user ,image_user , password)
                VALUES('$lname','$fname','$email','$cin','$adress','$city','$imageName','$password')";
                $result = mysqli_query($connect , $query) ;
                mkdir("../Files/managers/".$cin) ;
                move_uploaded_file($imageTmp ,"../Files/managers/".$cin."/".$cin.".".$imageExtansion ) ;
                
                $_SESSION['succ']  ="New Manager was Added" ;
                header('location:/admin/managers') ;            
            }
        }
    }else{
        $mail = "SELECT email_user FROM manager WHERE email_user = '$email'" ;
        $result_mail = mysqli_query($connect , $mail) ;
        if(mysqli_num_rows($result_mail) == 1){
            
            $_SESSION['err']  ="Email already token" ;
            header('location:/admin/managers?add') ;
        }else{
            $query  = "INSERT INTO 
                manager( lname_user , fname_user ,email_user , cin_user , adress_user , city_user  , password)
            VALUES('$lname','$fname','$email','$cin','$adress','$city','$password')";
            $result = mysqli_query($connect , $query) ;
            mkdir("../Files/managers/".$cin) ;
            
            $_SESSION['succ']  ="New Manager was Added" ;
            header('location:/admin/managers') ;            
        }
    }
    
    

}
/* ---------------- Insert New Teacher ---------------- */
if(isset($_POST['insert-teacher'])){
    $lname = validate_input($_POST['lname'] ) ;
    $fname = validate_input($_POST['fname'] ) ;
    $cin = validate_input($_POST['cin'] ) ;
    $adress = validate_input($_POST['adress'] ) ;
    $city = validate_input($_POST['city'] ) ;
    $email = validate_input($_POST['email'] ) ;
    $password = password_hash( validate_input($_POST['password'] ) , PASSWORD_DEFAULT) ;
    $image = $_FILES['image'] ;
    $imageName = $_FILES['image']['name'] ;
    $imageSize = $_FILES['image']['size']  ;
    $imageTmp = $_FILES['image']['tmp_name']  ;
   
    $extansions = array('jpg','jpeg','png') ;

    if(empty($lname) || empty($fname) || empty($cin)  ||  empty($email) || empty($password) ){
        
        $_SESSION['err']  ="fields with (*) are required" ;
        header('location:/admin/teachers?add') ;
    }elseif(!filter_var($email , FILTER_VALIDATE_EMAIL)){
        
        $_SESSION['err']  ="Invalid Email."."<br>Exemple : abc@xyz.exp" ;
        header('location:/admin/teachers?add') ;
    }elseif(strlen($password) < 8){
        
        $_SESSION['err']  ="Password's lenght should be at least 8 characters." ;
        header('location:/admin/managers?add') ;
    }elseif(isset($imageName) && !empty($imageName)){
        $imageExtansion = end(explode('.', $_FILES['image']['name'] ) );
        if( !is_in($imageExtansion , $extansions)){
            $_SESSION['err']  ="Invalid file."."<br>Allowed : jpg, jpeg, png" ;
            header('location:/admin/teachers?add') ;
        }else{
            $mail = "SELECT email_user FROM teacher WHERE email_user = '$email'" ;
            $result_mail = mysqli_query($connect , $mail) ;
            $imageName = $cin.".".$imageExtansion ;
            if(mysqli_num_rows($result_mail) == 1){
                
                $_SESSION['err']  ="Email already token" ;
                header('location:/admin/teachers?add') ;
            }else{
                $query  = "INSERT INTO 
                    teacher( lname_user , fname_user ,email_user , cin_user , adress_user , city_user ,image_user , password)
                VALUES('$lname','$fname','$email','$cin','$adress','$city','$imageName','$password')";
                $result = mysqli_query($connect , $query) ;
                mkdir("../Files/teachers/".$cin) ;
                mkdir("../Files/teachers/".$cin."/subjects") ;
                move_uploaded_file($imageTmp ,"../Files/teachers/".$cin."/".$cin.".".$imageExtansion ) ;
                
                $_SESSION['succ']  ="New Teacher was Added" ;
                header('location:/admin/teachers') ;            
            }
        }
    }else{
        $mail = "SELECT email_user FROM teacher WHERE email_user = '$email'" ;
        $result_mail = mysqli_query($connect , $mail) ;
        if(mysqli_num_rows($result_mail) == 1){
            
            $_SESSION['err']  ="Email already token" ;
            header('location:/admin/teachers?add') ;
        }else{
            $query  = "INSERT INTO 
                teacher( lname_user , fname_user ,email_user , cin_user , adress_user , city_user  , password)
            VALUES('$lname','$fname','$email','$cin','$adress','$city','$password')";
            $result = mysqli_query($connect , $query) ;
            mkdir("../Files/teachers/".$cin) ;
            
            $_SESSION['succ']  ="New Teacher was Added" ;
            header('location:/admin/teachers') ;            
        }
    }
    
    

}

/* ---------------- Insert New Student ---------------- */
if(isset($_POST['insert-student'])){
    $lname = validate_input($_POST['lname'] ) ;
    $fname = validate_input($_POST['fname'] ) ;
    $cin = validate_input($_POST['cin'] ) ;
    $adress = validate_input($_POST['adress'] ) ;
    $cne = validate_input($_POST['cne'] ) ;
    $birth = validate_input($_POST['birth'] ) ;
    $city = validate_input($_POST['city'] ) ;
    $email = validate_input($_POST['email'] ) ;
    $password = password_hash( validate_input($_POST['password'] ) , PASSWORD_DEFAULT) ;
    $image = $_FILES['image'] ;
    $imageName = $_FILES['image']['name'] ;
    $imageSize = $_FILES['image']['size']  ;
    $imageTmp = $_FILES['image']['tmp_name']  ;
   
    $extansions = array('jpg','jpeg','png') ;

  
    if(empty($lname) || empty($fname) || empty($cin)  || empty($cne)  ||  empty($email) || empty($password) ){
        
        $_SESSION['err']  ="fields with * are required" ;
        header('location:/admin/students?add') ;
    }elseif(!filter_var($email , FILTER_VALIDATE_EMAIL)){
        
        $_SESSION['err']  ="Invalid Email." ;
        header('location:/admin/students?add') ;
    }elseif(strlen($password) < 8){
        
        $_SESSION['err']  ="Password's lenght should be at least 8 characters." ;
        header('location:/admin/students?add') ;
    }elseif(isset($imageName) && !empty($imageName)){
        $file_to_arr =  explode('.', $_FILES['image']['name'] ) ;
        $imageExtansion = end($file_to_arr) ;
        if( !is_in($imageExtansion , $extansions)){
            $_SESSION['err']  ="Invalid profilee image." ;
            header('location:/admin/students?add') ;
        }else{
            $mail = "SELECT email_user FROM student WHERE email_user = '$email'" ;
            $result_mail = mysqli_query($connect , $mail) ;
            $imageName = $cin.".".$imageExtansion ;
            if(mysqli_num_rows($result_mail) != 0){
                $_SESSION['err']  ="Email already token" ;
                header('location:/admin/students?add') ;
            }else{

                $query  = "INSERT INTO 
                            student( 
                                lname_user , 
                                fname_user ,
                                email_user , 
                                cin_user,
                                cne_student,
                                adress_user , 
                                city_user ,
                                image_user , 
                                password)
                            VALUES(
                                '$lname',
                                '$fname',
                                '$email',
                                '$cin',
                                '$cne',
                                '$adress',
                                '$city',
                                '$imageName',
                                '$password')" ;
                $result = mysqli_query($connect , $query) ;
               
                mkdir("../Files/students/".$cin) ;
                move_uploaded_file($imageTmp ,"../Files/students/".$cin."/".$cin.".".$imageExtansion ) ;
                
                $_SESSION['succ']  ="Data was saved " ;
                $r = mysqli_fetch_assoc(mysqli_query($connect , 
                         "SELECT id_user FROM student ORDER BY id_user DESC"
                ));
                header('location:/admin/students?inscrit&nb='.hash_str($r['id_user'])) ;            
           }
        }
    }else{
        $mail = "SELECT email_user FROM student WHERE email_user = '$email'" ;
        $result_mail = mysqli_query($connect , $mail) ;
        if(mysqli_num_rows($result_mail) != 0){
            
            $_SESSION['err']  ="Email already token" ;
            header('location:/admin/students?add') ;
        }else{
            $query  = "INSERT INTO 
                student( lname_user , fname_user ,email_user , cin_user ,cne_student, adress_user , city_user , password)
            VALUES('$lname','$fname','$email','$cin','$cne' ,'$adress','$city','$password')";
            $result = mysqli_query($connect , $query) ;
            if(!file_exists("../Files/students/".$cin))
                mkdir("../Files/students/".$cin) ;
            $_SESSION['succ']  ="Data was saved Successfully" ;
            $r = mysqli_fetch_assoc(mysqli_query($connect , 
                    "SELECT id_user FROM student ORDER BY id_user DESC"
                ));
            header('location:/admin/students?inscrit&nb='.hash_str($r['id_user'])) ;           
        }
    }

}

/* ---------------- Insert New Session ---------------- */
if(isset($_POST['insert-session'])){
    $start = validate_input($_POST['start'] ) ;
    $end = validate_input($_POST['end'] ) ;
    if(empty($start) || empty($end) ){
        
        $_SESSION['err']  ="All fields are required" ;
        header('location:/admin/sessions?add') ;
    }elseif($start > $end){
        
        $_SESSION['err']  ="Invalid Session.<br>it seem like the start larger than or equal the end." ;
        header('location:/admin/sessions?add') ;
    }else{
        $query = "SELECT * FROM session WHERE date_start='$start' AND date_end = '$end'"; ;
        $result = mysqli_query($connect , $query) ;
        if(mysqli_num_rows($result) != 0 ){
            
            $_SESSION['err']  ="Session Already Exist." ;
            header('location:/admin/sessions?add') ; 
        }elseif($end - $start != 1){
            
            $_SESSION['err']  ="dates does'nt matched" ;
            header('location:/admin/sessions?add') ;
        }else{
            $query  = "INSERT INTO session( date_start , date_end ) VALUES('$start','$end')";
            $result = mysqli_query($connect , $query) ;
            
            mkdir('../Files/sessions/'.$start.'-'.$end);
            $_SESSION['succ']  ="New Year was Added" ;
            header('location:/admin/sessions') ;
        }
    }
}
/* ---------------- Insert New Semester ---------------- */
if(isset($_POST['insert-semester'])){
    $semester = validate_input($_POST['semester'])  ;
    $id_session = validate_input(unhash_str($_POST['session']) ) ;
    $session = mysqli_fetch_assoc(mysqli_query($connect,
        "SELECT * FROM session WHERE id_session = '$id_session'"
    ));
    $start = $session['date_start'] ;
    $end = $session['date_end'] ;
    
    if(empty($semester) || empty($id_session) ){
        
        $_SESSION['err']  ="All fields are required" ;
       header('location:/admin/semesters?add') ;
    }else{
        $query = "SELECT * FROM session WHERE date_start ='$start' AND date_end = '$end'";
        $result = mysqli_query($connect, $query) ;
        $id_session = mysqli_fetch_assoc($result)['id_session'];
       
        $query = "SELECT * FROM semester WHERE title_semester='$semester' AND id_session = '$id_session'"; 
        $result = mysqli_query($connect , $query) ;
        if(mysqli_num_rows($result) != 0 ){
            
            $_SESSION['err']  ="Semester Already Exist." ;
            header('location:/admin/semesters?add') ; 
        }else{
            $query  = "INSERT INTO semester( title_semester , id_session ) VALUES('$semester','$id_session')";
            $result = mysqli_query($connect , $query) ;
            
            $_SESSION['succ']  ="New Semester was Added" ;
            header('location:/admin/semesters') ;
        }
    }
}
/* ---------------- Insert New inscription ---------------- */
if(isset($_POST['insert-inscription'])){
    $student = $_POST['student'] ;
    $id_student = unhash_str($_POST['id']) ;
    $id_class = unhash_str($_POST['class']) ;
    $id_session = unhash_str($_POST['session']) ;
    if(empty($student) || empty($id_class) || empty($id_student)|| empty($id_session)){
        
        $_SESSION['err']  ="fields with * are required" ;
        header('location:/admin/students?inscrit&nb='.hash_str($id_student)) ;
    }else{
        if( mysqli_num_rows(mysqli_query($connect ,
            "SELECT * FROM inscription 
            WHERE is_deleted = 0
            AND id_user = '$id_student'
            AND id_class = '$id_class'
            AND id_session = '$id_session'")) != 0 ){
            
            $_SESSION['err']  ="You already registered" ;
            header('location:/admin/students?inscrit&nb='.hash_str($id_student)) ;
        }elseif( mysqli_num_rows(mysqli_query($connect , 
                "SELECT * FROM inscription 
                WHERE id_user = '$id_student'
                AND id_session = '$id_session'
                AND id_class != '$id_class' ")) != 0 ){
                
                $_SESSION['err']  ="You can't register in more than a class  by year." ;
                header('location:/admin/students?inscrit&nb='.hash_str($id_student)) ;;
        }else{
            $query = "INSERT INTO inscription(id_user,id_class,id_session)
                        VALUES('$id_student','$id_class','$id_session')";
            $result = mysqli_query($connect , $query);
            $session = mysqli_fetch_assoc(mysqli_query($connect ,
                        "SELECT * FROM session WHERE is_deleted=0
                         ORDER BY id_session DESC")) ;
            $class = mysqli_fetch_assoc(mysqli_query($connect ,
                    "SELECT * FROM class WHERE is_deleted=0
                    AND id_class = '$id_class'"))['title_class'] ;            
            $session_dir = $session['date_start']."-".$session['date_end'] ;
            $student = mysqli_fetch_assoc(
                mysqli_query($connect,
                        "SELECT * FROM student 
                         WHERE is_deleted = 0
                         AND id_user = '$id_student'")
            );
            $inscription = "#Inscription";
            $text = 'your Inscription is completely done';
            mysqli_query($connect,"INSERT INTO notification(id_user,title,text)
                VALUES('$id_student','$inscription','$text')") ;
            mkdir('../Files/students/'.$student['cin_user'].'/'.$session_dir);
            mkdir('../Files/students/'.$student['cin_user'].'/'.$session_dir.'/payements');
            mkdir('../Files/students/'.$student['cin_user'].'/'.$session_dir.'/bultins');
            if(!file_exists('../Files/sessions/'.$session_dir.'/'.$class)){
                mkdir('../Files/sessions/'.$session_dir.'/'.$class) ;
                mkdir('../Files/sessions/'.$session_dir.'/'.$class.'/tests');
                mkdir('../Files/sessions/'.$session_dir.'/'.$class.'/resources');
            }
            $_SESSION['succ'] = "Congratulations. Your inscription was completed Successfully";
            header('location:/admin/students?pay&nb='.hash_str($id_student)) ;
        }
    }
}

/* ---------------- Insert New Payement ---------------- */
if(isset($_POST['insert-payement'])){
    $student = $_POST['student'] ;
    $id_student = unhash_str($_POST['id']) ;
    $payed = $_POST['payed'] ;
    $session = unhash_str($_POST['s']);
    $not_payed = $_POST['still'] ;
    $date = $_POST['date_payment'];
    if(empty($_POST['student']) || empty($_POST['payed']) 
                || empty($_POST['id']) 
                || empty($_POST['date_payment'])){
        
        $_SESSION['err']  ="fields with * are required" ;
        if(isset($_POST['pay'])){
            header('location:/admin/students?pay&nb='.hash_str($id_student) );
        }else header('location:/admin/profile?more&student='.hash_str($id_student)."&s=".hash_str($session) );
    }else{
        if( mysqli_num_rows(mysqli_query($connect ,
            "SELECT * FROM payement 
            WHERE id_user = '$id_student'
            AND date_payement = '$date'")) != 0 ){
            
            $_SESSION['err']  ="You already Pay this month" ;
            if(isset($_POST['pay'])){
                header('location:/admin/students?pay&nb='.hash_str($id_student) );
            }else header('location:/admin/profile?more&student='.hash_str($id_student)."&s=".hash_str($session) );
        }else{
            $session = mysqli_fetch_assoc(mysqli_query($connect , 
                    " SELECT * FROM session WHERE is_deleted = 0 ORDER BY id_session DESC"));
            $id_session = $session['id_session'] ;
            $query = "INSERT INTO payement(id_user,sum_payed,sum_rest,id_session,date_payement)
                        VALUES('$id_student','$payed','$not_payed','$id_session','$date')";
            $result = mysqli_query($connect , $query);
            $student = mysqli_fetch_assoc(
                mysqli_query($connect,
                        "SELECT * FROM student 
                         WHERE is_deleted = 0
                         AND id_user = '$id_student'")
            );
            $session_dir = $session['date_start']."-".$session['date_end'] ;
            //  payment receipt  

            $pdf = new FPDF();
            $pdf->AddPage('P','Legal');
            $pdf -> SetTopMargin(20) ;
            $pdf -> SetLeftMargin(30);
            $pdf->SetFont('Arial','',16);
            $pdf->Cell('150','10','Payment Receipt','','','C');
            $pdf -> Ln(20);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell('200','10','Firse Name             ......................................'.$student["fname_user"].'................................................................................');
            $pdf -> Ln();
            $pdf->Cell('200','10','Last Name              ......................................'.$student["lname_user"].'................................................................................');
            $pdf -> Ln();
            $pdf->Cell('200','10','CIN                        ......................................'.$student["cin_user"].'................................................................................');
            $pdf -> Ln();
            $pdf->Cell('200','10','CNE                        ......................................'.$student["cne_student"].'................................................................................');
            $pdf -> Ln();
            $pdf->Cell('200','10','Sum Payed              ......................................'.$payed.'................................................................................');
            $pdf -> Ln();
            $pdf->Cell('200','10','Still                          ......................................'.$not_payed.'................................................................................');
            $pdf -> Ln();
            $pdf->Cell('200','10','Payed For     ......................................'.get_month($date).'................................................................................');
            $pdf -> Ln();
            $pdf->Cell('200','10','Date Payment       ......................................'.date('d-m-Y').'................................................................................');
            $pdf -> Ln();
            $pdf->Cell('130','10','Signature','','','R');
            $pdf -> Ln();
            ob_end_clean();
            $pdf->Output('F','../Files/students/'.$student['cin_user'].'/'.$session_dir.'/payements/'.get_month($date).'.pdf');

            $_SESSION['succ'] = " your payment is completly done.";
            $payement = "#Payement";
            $text = 'your payement is completely done';
            mysqli_query($connect,"INSERT INTO notification(id_user,title,text)
            VALUES('$id_student','$payement','$text')") ;
            if(isset($_POST['pay'])){
                header('location:/admin/students?pay&nb='.hash_str($id_student) );
            }else header('location:/admin/profile?more&student='.hash_str($id_student)."&s=".hash_str($id_session) );
        }
    }
}

/* ----------------  Go Schedules  ---------------- */
if(isset($_POST['go-schedules'])){
    if(isset($_POST['cls']) && isset($_POST['sess']) && isset($_POST['smstr'])
        && !empty($_POST['cls']) && !empty($_POST['sess']) && !empty($_POST['smstr'])
        ){
        header("location:/admin/schedules?create-schedules&cls=".$_POST['cls']."&sess=".$_POST['sess']."&smstr=".$_POST['smstr']);
    }else{
        $_SESSION['err'] = "All fields are Required";
        header("location:/admin/schedules?add");

    }
}

/* ---------------- Insert New Course ---------------- */
if(isset($_POST['insert-course'])){

    $id_teacher =  unhash_str($_POST['teacher']);
    $id_subject =  unhash_str($_POST['subject']);
    $id_classroom =  unhash_str($_POST['classroom']);
    $time = $_POST['time'];
    $day = $_POST['day'];
    $id_semester = unhash_str( $_POST['smstr']);
    $id_class = unhash_str( $_POST['cls'] ) ;
    if(empty($id_teacher) || empty($id_subject) || empty($id_classroom) ||
        empty($time) || empty($day)  
        || empty($id_semester)  || empty($id_class)  ){
            
            $_SESSION['err'] = "All fields are Required";
            header('location:/admin/schedules?create-schedules&cls='.$_POST['cls']."&smstr=".$_POST['smstr']);
    }else{
        if(mysqli_num_rows(mysqli_query($connect,
                "SELECT * FROM course WHERE
                id_semester = '$id_semester'
                AND id_class = '$id_class'
                AND date_course = '$day'
                AND time_course = '$time' ")) != 0){
                    
                    $_SESSION['err'] = "course Already Exist";
                    header('location:/admin/schedules?create-schedules&cls='.$_POST['cls']."&smstr=".$_POST['smstr']);
                }else{
            $result= mysqli_query($connect,
                        "INSERT INTO 
                        course(id_semester,
                                id_class,
                                id_subject,
                                id_classroom,
                                id_user,
                                time_course,
                                date_course)
                        VALUES(
                            '$id_semester',
                            '$id_class',
                            '$id_subject',
                            '$id_classroom',
                            '$id_teacher',
                            '$time',
                            '$day'
                        )");
            if(mysqli_num_rows(mysqli_query($connect,
                "SELECT * FROM prof_subject
                WHERE id_subject = '$id_subject'
                AND id_user = '$id_teacher' ")) != 0){
                    
            }else{
                $result= mysqli_query($connect,
                    "INSERT INTO 
                        prof_subject(
                                id_subject,
                                id_user
                                )
                    VALUES(
                        '$id_subject',
                        '$id_teacher'
                    )"
                );
            }
            header('location:/admin/schedules?create-schedules&cls='.$_POST['cls']."&smstr=".$_POST['smstr']);

        }

    }

}
/* ----------------  Show Schedules  ---------------- */

if(isset($_POST['show-schedules'])){
    if(isset($_POST['cls']) && isset($_POST['sess']) && isset($_POST['smstr'])
        && !empty($_POST['cls']) && !empty($_POST['sess']) && !empty($_POST['smstr'])
        ){
        $id_class = $_POST['cls'] ;
        $id_session = $_POST['sess'] ;
        $id_semester = $_POST['smstr'] ;
        header("location:/admin/schedules?cls=".$id_class."&sess=".$id_session."&smstr=".$id_semester);
    }else{
        
        $_SESSION['err'] = "All fields are Required";
        header("location:/admin/schedules?");

    }
}

/* ----------------  Insert Exam  ---------------- */
if(isset($_POST['insert-exam'])){
    $subject = validate_input(unhash_str($_POST['sub']));
    $start = validate_input($_POST['start'] );
    $end = validate_input($_POST['end'] );
    $class = validate_input(unhash_str($_POST['group']));
    $user = validate_input(unhash_str($_POST['user']));
    $descript = $_POST['description'];
    $file = $_FILES['test'] ;
    $file_name = $_FILES['test']['name'] ;
    $file_size = $_FILES['test']['size'] ;
    $file_error = $_FILES['test']['error'] ;
    $file_tmp = $_FILES['test']['tmp_name'] ;
    $file_ext_arr = explode('.',$file_name);
    $file_ext = strToLower(end($file_ext_arr));

    $thumbnail = $_FILES['thumbnail'] ;
    $thumbnail_name = $_FILES['thumbnail']['name'] ;
    $thumbnail_size = $_FILES['thumbnail']['size'] ;
    $thumbnail_tmp = $_FILES['thumbnail']['tmp_name'] ;
    $thumbnail_ext_arr = explode('.',$thumbnail_name);
    $thumbnail_ext = strToLower(end($thumbnail_ext_arr));
    $extansions = array('pdf','png','jpg','jpeg','rar','txt');
    if( isset($_POST['sub']) && !empty($_POST['sub'])
        && isset($_POST['start']) && !empty($_POST['start'])
        && isset($_POST['end']) && !empty($_POST['end'])
        && isset($_FILES['test']) && !empty($_FILES['test'])
        &&isset($_POST['group']) && !empty($_POST['group'])
        && isset($_POST['user']) && !empty($_POST['user']) ){
            
            if($file_size > 1000000){
                $_SESSION['err'] = "File is too long";
                header("location:/admin/dashboard?group=".hash_str($class));
            }elseif(!is_in($file_ext, $extansions )){
                $_SESSION['err'] = "File doesnt Allowed";
                header("location:/admin/classes?group=".hash_str($class));
            }else{
                if(isset($_POST['description']) && !empty($_POST['description'])
                    && $thumbnail_size != 0){
                    if(is_in($thumbnail_ext , array('jpg','jpeg','png'))){
                        $file_name = "start_".$start."_end_".$end."_teacher_".$user.".".$file_ext ;
                        $test_dir = "start_".$start."_end_".$end."_teacher_".$user ;
                        $session = mysqli_fetch_assoc(mysqli_query($connect ,
                                    "SELECT * FROM session WHERE is_deleted=0
                                    ORDER BY id_session DESC")) ;
                        $class = mysqli_fetch_assoc(mysqli_query($connect ,
                                    "SELECT * FROM class WHERE is_deleted=0
                                    AND id_class = '$class'")) ;
                        $title_class = $class['title_class'];
                        $id_class = $class['id_class'];
                        $session_dir = $session['date_start']."-".$session['date_end'] ;
                        mkdir("../Files/sessions/".$session_dir."/".$title_class."/tests/".$test_dir);
                        move_uploaded_file($file_tmp , "../Files/sessions/".$session_dir."/".$title_class."/tests/".$test_dir."/".$file_name);
                        move_uploaded_file($thumbnail_tmp , "../Files/sessions/".$session_dir."/".$title_class."/tests/".$test_dir."/".$thumbnail_name);
                        $result = mysqli_query($connect,
                            "INSERT INTO exam(id_subject,id_class,id_user,exam_file,exam_start, exam_end,description,thumbnail)
                            VALUES('$subject','$id_class','$user','$file_name','$start','$end','$descript','$thumbnail_name')");
                        
                        $_SESSION['succ'] = "Test was added successfuly";
                        header("location:/admin/classes?group=".hash_str($id_class));
                    }else{
                        $_SESSION['err'] = "Thumbnail should be an image 'jpg','jpeg' or 'png'";
                        header("location:/admin/dashboard?group=".hash_str($class));
                    }
                }elseif(isset($_POST['description']) && !empty($_POST['description']) 
                         && $thumbnail_size == 0){
                    $file_name = "start_".$start."_end_".$end."_teacher_".$user.".".$file_ext ;
                    $test_dir = "start_".$start."_end_".$end."_teacher_".$user ;
                    $session = mysqli_fetch_assoc(mysqli_query($connect ,
                                "SELECT * FROM session WHERE is_deleted=0
                                ORDER BY id_session DESC")) ;
                    $class = mysqli_fetch_assoc(mysqli_query($connect ,
                                "SELECT * FROM class WHERE is_deleted=0
                                AND id_class = '$class'")) ;
                    $title_class = $class['title_class'] ;
                    $id_class = $class['id_class'] ;
                    $session_dir = $session['date_start']."-".$session['date_end'] ;
                    mkdir("../Files/sessions/".$session_dir."/".$title_class."/tests/".$test_dir);
                    move_uploaded_file($file_tmp , "../Files/sessions/".$session_dir."/".$title_class."/tests/".$test_dir."/".$file_name);
                    $result = mysqli_query($connect,
                        "INSERT INTO exam(id_subject,id_class,id_user,exam_file,exam_start, exam_end,description)
                        VALUES('$subject','$id_class','$user','$file_name','$start','$end','$descript')");
                   
                    $_SESSION['succ'] = "Test was added successfuly";
                    header("location:/admin/classes?group=".hash_str($id_class));
                }elseif(isset($_POST['description']) && empty($_POST['description'])
                       &&  $thumbnail_size != 0 ){
                    if(is_in($thumbnail_ext , array('jpg','jpeg','png'))){
                        $file_name = "start_".$start."_end_".$end."_teacher_".$user.".".$file_ext ;
                        $test_dir = "start_".$start."_end_".$end."_teacher_".$user ;
                        $session = mysqli_fetch_assoc(mysqli_query($connect ,
                                    "SELECT * FROM session WHERE is_deleted=0
                                    ORDER BY id_session DESC")) ;
                        $class = mysqli_fetch_assoc(mysqli_query($connect ,
                                    "SELECT * FROM class WHERE is_deleted=0
                                    AND id_class = '$class'")) ;
                        $title_class = $class['title_class'] ;
                        $id_class = $class['id_class'] ;
                        $session_dir = $session['date_start']."-".$session['date_end'] ; 
                        mkdir("../Files/sessions/".$session_dir."/".$title_class."/tests/".$test_dir);
                        move_uploaded_file($file_tmp , "../Files/sessions/".$session_dir."/".$title_class."/tests/".$test_dir."/".$file_name);
                        move_uploaded_file($thumbnail_tmp , "../Files/sessions/".$session_dir."/".$title_class."/tests/".$test_dir."/".$thumbnail_name);
                        $result = mysqli_query($connect,
                            "INSERT INTO exam(id_subject,id_class,id_user,exam_file,exam_start, exam_end,thumbnail)
                            VALUES('$subject','$id_class','$user','$file_name','$start','$end','$thumbnail_name')");
                       
                        $_SESSION['succ'] = "Test was added successfuly";
                        header("location:/admin/classes?group=".hash_str($id_class));
                    }else{
                        $_SESSION['err'] = "Thumbnail should be an image 'jpg','jpeg' or 'png'";
                  
                        // header("location:/admin/dashboard?group=".hash_str($class));
                    }
                }else{
                    $file_name = "start_".$start."_end_".$end."_teacher_".$user.".".$file_ext ;
                    $test_dir = "start_".$start."_end_".$end."_teacher_".$user ;
                    $session = mysqli_fetch_assoc(mysqli_query($connect ,
                                "SELECT * FROM session WHERE is_deleted=0
                                ORDER BY id_session DESC")) ;
                    $session_dir = $session['date_start']."-".$session['date_end'] ;
                    $class = mysqli_fetch_assoc(mysqli_query($connect ,
                        "SELECT * FROM class WHERE is_deleted=0
                        AND id_class = '$class'")) ; 
                    $title_class = $class['title_class'] ;
                    $id_class = $class['id_class'] ;
                    mkdir("../Files/sessions/".$session_dir."/".$title_class."/tests/".$test_dir);
                    move_uploaded_file($file_tmp , "../Files/sessions/".$session_dir."/".$title_class."/tests/".$test_dir."/".$file_name);
                    move_uploaded_file($thumbnail_tmp , "../Files/sessions/".$session_dir."/".$title_class."/tests/".$test_dir."/".$thumbnail_name);
                    $result = mysqli_query($connect,
                        "INSERT INTO exam(id_subject,id_class,id_user,exam_file,exam_start, exam_end)
                        VALUES('$subject','$id_class','$user','$file_name','$start','$end')");

                    $_SESSION['succ'] = "Test was added successfuly";
                    header("location:/admin/classes?group=".hash_str($id_class));
                }
            }
            
        }else{  
            $_SESSION['err'] = "All fields Required";
            header("location:/admin/classes?group=".hash_str($class));
        }
}
/* ----------------  Insert Exam Solution ---------------- */
if(isset($_POST['insert-solution'])){

    $exam = validate_input(unhash_str($_POST['exam']));
    $user = validate_input(unhash_str($_POST['user']));
    $file = $_FILES['exam-solution'] ;
    $file_name = $_FILES['exam-solution']['name'] ;
    $file_size = $_FILES['exam-solution']['size'] ;
    $file_tmp = $_FILES['exam-solution']['tmp_name'] ;
    $file_ext_arr = explode('.',$file_name);
    $file_ext = strToLower(end($file_ext_arr));
    $extansions = array('pdf','png','jpg','jpeg','rar','txt');


    if( isset($_POST['exam']) && !empty($_POST['exam'])
        && isset($_POST['user']) && !empty($_POST['user'])
        && isset($_FILES['exam-solution']['name']) && !empty($_FILES['exam-solution']['name']) ){
            if($file_size > 1000000){
                $_SESSION['err'] = "File is too long";
                header("location:/admin/tests?t=".hash_str($exam));
            }elseif(!is_in($file_ext, $extansions )){
                $_SESSION['err'] = "File doesnt Allowed";
                header("location:/admin/tests?t=".hash_str($exam));
            }else{
                $session = mysqli_fetch_assoc(mysqli_query($connect ,
                            "SELECT * FROM session WHERE is_deleted=0
                             ORDER BY id_session DESC")) ;
                $class   = mysqli_fetch_assoc(mysqli_query($connect,
                            "SELECT * FROM inscription WHERE is_deleted = 0 
                                AND id_user = '$user'
                                AND id_session = ".$session['id_session']))['id_class'] ;                
                $exam_all = mysqli_fetch_assoc(mysqli_query($connect,
                            "SELECT * FROM exam WHERe is_deleted = 0
                                AND id_exam = '$exam'"));
                $user_all = mysqli_fetch_assoc(mysqli_query($connect,
                            "SELECT * FROM student WHERe is_deleted = 0
                                AND id_user = '$user'"));
                $file_name = $user_all['fname_user']."_".$user_all['lname_user'].".".$file_ext ;
                $test_dir = "start_".$exam_all['exam_start']."_end_".$exam_all['exam_end']."_teacher_".$exam_all['id_user'] ;
                
                $session_dir = $session['date_start']."-".$session['date_end'] ;
                $class = mysqli_fetch_assoc(mysqli_query($connect ,
                        "SELECT * FROM class WHERE is_deleted=0
                        AND id_class = '$class'"))['title_class'] ; 
                move_uploaded_file($file_tmp , "../Files/sessions/".$session_dir."/".$class."/tests/".$test_dir."/".$file_name);
                $result = mysqli_query($connect,
                    "INSERT INTO  exam_solution (id_exam,id_user,exam_solution)
                    VALUES($exam,'$user','$file_name')");

                $_SESSION['succ'] = "Solution was added successfuly";
                header("location:/admin/tests?t=".hash_str($exam));
            }
            
        }else{
            
                $_SESSION['err'] = "All fields Required";
                header("location:/admin/tests?t=".hash_str($exam));
    }
}

/* ----------------  Go / Insert Absence  ---------------- */
if(isset($_POST['goto-absence'])){
    if(isset($_POST['subj']) && !empty($_POST['subj'])
    && isset($_POST['grp'])&& !empty($_POST['grp']) ){
        header("location:/admin/classes?abs&group=".$_POST['grp']."&subj=".$_POST['subj']);
    }else{
        
        $_SESSION['err'] = "You need to choose a Subject";
        header("location:/admin/classes?abs&group=".$_POST['grp']);
    } 
}
if(isset($_POST['insert-abs'])){
    if(isset($_POST['std']) && !empty($_POST['std'])
        && isset($_POST['sbj']) && !empty($_POST['sbj'])
        && isset($_POST['grp']) && !empty($_POST['grp'])){
            $student = unhash_str($_POST['std']) ;
            $subject = unhash_str($_POST['sbj'])  ;
            $group = unhash_str($_POST['grp']) ;
            $date = date('Y')."-".date('m')."-".date('d') ;
            $n_r = mysqli_num_rows(mysqli_query($connect,
                    "SELECT * FROM absence_course
                    WHERE id_subject = '$subject'
                    AND id_user = '$student' 
                    AND date_absence = '$date' ")) ;
            if($n_r != 0){
                
                $_SESSION['err'] = "Already registered as Absent";
                header("location:/admin/classes?subj=".hash_str($subject)."&group=".hash_str($group) );
            }else{
                $result = mysqli_query($connect ,
                        "INSERT INTO absence_course(id_subject,id_user,is_absent) 
                        VALUES ('$subject','$student',true)") ;
                
                $_SESSION['succ'] = "Well done";
                header("location:/admin/classes?subj=".hash_str($subject)."&group=".hash_str($group));
            }
        }
}

/* ----------------  Go / Insert Marks  ---------------- */
if(isset($_POST['goto-marks'])){
    if(isset($_POST['subj']) && !empty($_POST['subj'])
    && isset($_POST['grp'])&& !empty($_POST['grp']) ){
        header("location:/admin/marks?group=".$_POST['grp']."&subj=".$_POST['subj']);
    }else{
        
        $_SESSION['err'] = "You need to choose a Subject";
        header("location:/admin/classes?group=".$_POST['grp']);
    } 
}

if(isset($_POST['insert-mark'])){
    $err ="" ;

    $subject = unhash_str($_POST['subj'])  ;
    $group = unhash_str($_POST['group'])  ;
    $students = $_POST['users'] ;
    $marks = $_POST['marks']  ;
    $current_semester =mysqli_fetch_assoc( mysqli_query($connect,
        "SELECT * FROM semester WHERE is_deleted=0 ORDER BY id_semester DESC") ) ;
    $id_semester = $current_semester['id_semester'] ;
    
    for($i=0;$i<count($students);$i++){

            $id_user = unhash_str($students[$i]) ;
            $mark = $marks[$i];
            
            $inserted_mark = mysqli_query($connect,
                    "SELECT * FROM mark_subject WHERE id_subject = '$subject' 
                     AND id_semester='$id_semester' AND id_user = '$id_user'") ;
            if( $mark<=20 && $mark>=0 ){
                if(mysqli_num_rows($inserted_mark)){
                    mysqli_query($connect,
                        "UPDATE mark_subject SET mark_subject = '$mark' 
                        WHERE id_subject ='$subject' AND id_user = '$id_user' AND id_semester ='$id_semester' ");
                }else{
                    mysqli_query($connect,
                            "INSERT INTO mark_subject (id_subject,id_user,id_semester,mark_subject)
                            VALUES ('$subject','$id_user','$id_semester','$mark')");
                }
            }else{
                $err = "all marks should be numbers between 0 and 20" ;
            }
       
    }
   
    if(!empty($err)) $_SESSION['err'] = $err ;
    else $_SESSION['succ'] = "Changes was saved " ;
    header('location:/admin/marks?group='.$_POST['group']."&subj=".$_POST['subj']) ;

}

if(isset($_POST['insert-mark-unit'])){
    $err = "";

    $id_semester = mysqli_fetch_assoc(
        mysqli_query($connect,"SELECT * FROM semester WHERE is_deleted=0 ORDER BY id_semester DESC")
    )['id_semester'];
    $users = $_POST['users'] ;
    $id_subject = unhash_str($_POST['subject']) ;
    $units = mysqli_query($connect,"SELECT * from unit where is_deleted=0
                    AND id_subject='$id_subject'") ;
    $all_units_marks = [] ;
    $ids = [] ;
    while($unit = mysqli_fetch_assoc($units)){
        $id_unit=$unit['id_unit'];
        array_push($ids,$id_unit);
        array_push($all_units_marks,$_POST['unit_'.$unit['id_unit'] ]);
    }
    for($i=0;$i<count($users);$i++){
        $j=0 ;
        while ($j < count($all_units_marks)) {
            $id_unit = $ids[$j];
            $id_user = $users[$i];
            $mark = $all_units_marks[$j][$i];
            $j++;
            $inserted_mark = mysqli_query($connect,
                    "SELECT * FROM mark_unit WHERE id_unit = '$id_unit' 
                     AND id_semester='$id_semester' AND id_user = '$id_user'") ;
            if( $mark<=10 && $mark>=0 ){
                if(mysqli_num_rows($inserted_mark)){
                    mysqli_query($connect,
                        "UPDATE mark_unit SET mark_unit = '$mark' 
                        WHERE id_unit ='$id_unit' AND id_user = '$id_user' AND id_semester ='$id_semester' ");
                }else{
                    mysqli_query($connect,
                            "INSERT INTO mark_unit (id_unit,id_user,id_semester,mark_unit)
                            VALUES ('$id_unit','$id_user','$id_semester','$mark')");
                }
            }else{
                $err = "all marks should be numbers between 0 and 20" ;
            }
        }
    }
    if(!empty($err)) $_SESSION['err'] = $err ;
    header('location:/admin/marks?group='.$_POST['group']."&subj=".$_POST['subject']) ;
}
/* ----------------   Insert Semester Marks  ---------------- */
if(isset($_POST['marks-semester'])){

    $id_class = $_POST['class'];
    $current_semester =mysqli_fetch_assoc( mysqli_query($connect,
            "SELECT * FROM semester WHERE is_deleted=0 ORDER BY id_semester DESC") ) ;
    $id_semester = $current_semester['id_semester'] ;
    $current_session = mysqli_fetch_assoc( mysqli_query($connect,
        "SELECT * FROM session WHERE is_deleted=0 ORDER BY id_session DESC")) ;
    $id_session = $current_session['id_session'] ;

    
    $students = mysqli_query($connect, 
            "SELECT * FROM student,inscription 
             WHERE student.is_deleted=0 AND inscription.is_deleted=0
             AND student.id_user = inscription.id_user
             AND inscription.id_class = '$id_class'
             AND inscription.id_session = '$id_session' ") ;
    while($student = mysqli_fetch_assoc($students)){
       
        $id_user = $student['id_user'] ;
        if($school['type'] == 3){
            $modules = mysqli_query($connect,
                "SELECT * FROM module 
                WHERE is_deleted=0
                AND id_module IN (SELECT id_module FROM subject,course 
                                    WHERE course.is_deleted=0 AND subject.is_deleted=0
                                    AND subject.id_subject = course.id_subject
                                    AND course.id_semester = '$id_semester' 
                                    AND course.id_class = '$id_class'
                                    )
                
                                    
                "); 
            while($module = mysqli_fetch_assoc($modules)){
               
                $id_module = $module['id_module'] ;
                $mark_module = 0 ;
                $subjects = mysqli_query($connect ,
                    "SELECT * FROM subject,course 
                    WHERE course.is_deleted=0 AND subject.is_deleted=0
                    AND subject.id_subject = course.id_subject
                    AND course.id_class = '$id_class'
                    AND course.id_semester = '$id_semester' 
                    AND subject.id_module = '$id_module'
                    GROUP BY course.id_subject");
                while($subject = mysqli_fetch_assoc($subjects)){
                    $mark_subject = mysqli_fetch_assoc(
                        mysqli_query( $connect , 
                            "SELECT * FROM mark_subject 
                                WHERE id_user = '$id_user'
                                AND id_subject = ".$subject['id_subject']." 
                                AND id_semester = '$id_semester' ")
                    ) ;
                    $mark_module += $mark_subject['mark_subject']*$subject['percentage']; 
                    
                }
                $is_mark_inserted = mysqli_num_rows(
                    mysqli_query($connect,
                            "SELECT * FROM mark_module WHERE is_deleted=0
                             AND id_user='$id_user'
                             AND id_semester='$id_semester'
                             AND id_module = '$id_module'")
                ); 
                if($is_mark_inserted){
                    mysqli_query($connect,
                        "UPDATE mark_module set mark_module = '$mark_module'
                         WHERE  id_user='$id_user'
                         AND id_semester='$id_semester'
                         AND id_module=".$module['id_module']);
                }else{
                    mysqli_query($connect,
                    "INSERT INTO mark_module(id_module,id_user,mark_module,id_semester)
                     VALUES('$id_module' , '$id_user' , '$mark_module','$id_semester')") ;
                }
                
                
            }

            $mark_modules = mysqli_query($connect, 
                    "SELECT * FROM mark_module
                     WHERE id_user = '$id_user'
                     AND id_semester = '$id_semester'") ;
            $mark_semester = 0 ;
            $module_number = 0 ;
            while($mark = mysqli_fetch_assoc($mark_modules)){
                $module_number++ ;
                $mark_semester  += $mark['mark_module'] ;
            }
            $mark_semester =  $mark_semester /$module_number ;
            $is_mark_inserted = mysqli_num_rows(
                mysqli_query($connect,
                        "SELECT * FROM mark_semester WHERE is_deleted=0
                         AND id_user='$id_user'
                         AND id_semester='$id_semester'")
            );
            if($is_mark_inserted){
                mysqli_query($connect,
                    "UPDATE mark_semester set mark_semester = '$mark_semester'
                     WHERE  id_user='$id_user'
                     AND id_semester='$id_semester'
                     ");
            }else{
                mysqli_query($connect,
                    "INSERT INTO mark_semester(id_user,mark_semester,id_semester)
                     VALUES( '$id_user' , '$mark_semester','$id_semester')") ;
            }

        }elseif($school['type'] == 2){
            $mark_semester = 0 ;
            $coeff_subjects =0 ;
            $subjects = mysqli_query($connect ,
                "SELECT * FROM subject,course 
                WHERE course.is_deleted=0 AND subject.is_deleted=0
                AND subject.id_subject = course.id_subject
                AND course.id_class = '$id_class'
                AND course.id_semester IN (
                        SELECT id_semester FROM semester WHERE is_deleted=0
                        AND id_session = '$id_session'
                    ) 
                GROUP BY course.id_subject");
            while($subject = mysqli_fetch_assoc($subjects)){
                $coeff_subjects += $subject['coefficient']; 
                $mark_subject = mysqli_fetch_assoc(
                    mysqli_query( $connect , 
                        "SELECT * FROM mark_subject 
                            WHERE id_user = '$id_user'
                            AND id_subject = ".$subject['id_subject']." 
                            AND id_semester = '$id_semester' ")
                ) ;
                $mark_semester += $mark_subject['mark_subject']*$subject['coefficient'] ;
            }
            $mark_semester = $mark_semester/$coeff_subjects ;
            $is_mark_inserted = mysqli_num_rows(
                mysqli_query($connect,
                        "SELECT * FROM mark_semester WHERE is_deleted=0
                         AND id_user='$id_user'
                         AND id_semester='$id_semester'")
            ); 
            if($is_mark_inserted){
                mysqli_query($connect,
                    "UPDATE mark_semester set mark_semester = '$mark_semester'
                     WHERE  id_user='$id_user'
                     AND id_semester='$id_semester'
                    ");
            }else{
                mysqli_query($connect,
                    "INSERT INTO mark_semester(id_user,mark_semester,id_semester)
                    VALUES( '$id_user' , '$mark_semester','$id_semester')") ;
            }
            
        }elseif($school['type'] == 1){
            $subjects = mysqli_query($connect ,
                "SELECT * FROM subject,course 
                    WHERE course.is_deleted=0 AND subject.is_deleted=0
                    AND subject.id_subject = course.id_subject
                    AND course.id_class = '$id_class'
                    AND course.id_semester IN (
                        SELECT id_semester FROM semester WHERE is_deleted=0
                        AND id_session = '$id_session'
                    ) 
                    GROUP BY course.id_subject");
            while($subject = mysqli_fetch_assoc($subjects)){
                $id_subject = $subject['id_subject'] ;
                // echo " - Subject N° : ".$subject['id_subject']."<br>" ;
                $mark_subject = 0 ;
                $units = mysqli_query($connect,
                    "SELECT * FROM unit,mark_unit 
                    WHERE unit.is_deleted=0 AND mark_unit.is_deleted=0
                    AND unit.id_unit = mark_unit.id_unit
                    AND mark_unit.id_semester = '$id_semester'
                    AND unit.id_subject = '$id_subject'
                    AND mark_unit.id_user = '$id_user' ");
                $number_units = 0 ;
                while($unit = mysqli_fetch_assoc($units)){
                    // echo "   *** Unit N°  ".$unit['id_unit']." :".$unit['mark_unit']."<br>" ;
                    $number_units++;
                    $mark_subject += $unit['mark_unit'] ;
                }
                // echo "   ** Total Units  ".$mark_subject."<br>" ;
                $mark_subject = $mark_subject/$number_units; 
                // echo "   ==> Mark Subject N°  ".$subject['id_subject']." :".$mark_subject."<br>" ;
                $is_mark_inserted = mysqli_num_rows(
                    mysqli_query($connect,
                            "SELECT * FROM mark_subject WHERE is_deleted=0
                             AND id_user='$id_user'
                             AND id_subject='$id_subject'
                             AND id_semester='$id_semester'")
                ); 
                if($is_mark_inserted){
                    mysqli_query($connect,
                        "UPDATE mark_subject set mark_subject = '$mark_subject'
                         WHERE  id_user='$id_user'
                         AND id_subject='$id_subject'
                         AND id_semester='$id_semester'");
                }else{
                    mysqli_query($connect,
                        "INSERT INTO mark_subject(id_user,id_subject,id_semester,mark_subject)
                        VALUES('$id_user','$id_subject','$id_semester',$mark_subject)");
                }
            }
            $subjects = mysqli_query($connect ,
                "SELECT * FROM subject,course 
                WHERE course.is_deleted=0 AND subject.is_deleted=0
                AND subject.id_subject = course.id_subject
                AND course.id_class = '$id_class'
                AND course.id_semester IN (
                        SELECT id_semester FROM semester WHERE is_deleted=0
                        AND id_session = '$id_session'
                    ) 
                GROUP BY course.id_subject
                ");
            $mark_semester = 0 ;
            $number_subjects =0 ;
            $mark_subject = "" ;
            while($subject = mysqli_fetch_assoc($subjects)){
                $number_subjects+=1; 
                $mark_subject = mysqli_fetch_assoc(
                    mysqli_query( $connect , 
                        "SELECT * FROM mark_subject 
                            WHERE id_user = '$id_user'
                            AND id_subject = ".$subject['id_subject']." 
                            AND id_semester = '$id_semester' ")
                ) ;
                $mark_semester += $mark_subject['mark_subject'] ;
            }
            $mark_semester = $mark_semester/$number_subjects ;
            // echo "   ==> Number of subjects :  ".$number_subjects."<br>" ;
            // echo "   ==> Mark Susemester N°  ".$id_semester." :".$mark_semester."<br><br><br>" ;
            $is_mark_inserted = mysqli_num_rows(
                mysqli_query($connect,
                        "SELECT * FROM mark_semester WHERE is_deleted=0
                         AND id_user='$id_user'
                         AND id_semester='$id_semester'")
            );
            if($is_mark_inserted){
                mysqli_query($connect,
                    "UPDATE mark_semester set mark_semester = '$mark_semester'
                     WHERE  id_user='$id_user'
                     AND id_semester='$id_semester'");
            }else{
                mysqli_query($connect,
                    "INSERT INTO mark_semester(id_user,mark_semester,id_semester)
                     VALUES( '$id_user' , '$mark_semester','$id_semester')") ;
            }
            
        }
    }

    $_SESSION['succ'] = "So well, Semester mark well generated ";
    header('location:/admin/setting?marks-setting&semester-marks') ;
}

/* ----------------   Insert Session Marks  ---------------- */
if(isset($_POST['marks-session'])){
    $id_class = $_POST['class'];
    $current_session = mysqli_fetch_assoc( mysqli_query($connect,
        "SELECT * FROM session WHERE is_deleted=0 ORDER BY id_session DESC")) ;
    $id_session = $current_session['id_session'] ;   

    
    $students = mysqli_query($connect, 
        "SELECT * FROM student,inscription 
        WHERE student.is_deleted=0 AND inscription.is_deleted=0
        AND student.id_user = inscription.id_user
        AND inscription.id_class = '$id_class'
        AND inscription.id_session = '$id_session' ") ;
    while($student = mysqli_fetch_assoc($students)){
        $id_user = $student['id_user'] ;
        $semesters = mysqli_query(
            $connect,
            "SELECT * FROM semester,mark_semester
             WHERE semester.is_deleted=0 AND mark_semester.is_deleted=0
             AND semester.id_semester = mark_semester.id_semester
             AND semester.id_session = '$id_session' 
             AND mark_semester.id_user = '$id_user'"
        );
        $global_mark = 0 ;
        while ($semeseter = mysqli_fetch_assoc($semesters)) {
            $global_mark += $semeseter['mark_semester']/2 ;
        }
        $is_mark_inserted = mysqli_num_rows(
            mysqli_query($connect,
                    "SELECT * FROM global_mark WHERE is_deleted=0
                     AND id_user='$id_user'
                     AND id_session='$id_session'")
        );
        if($is_mark_inserted){
            mysqli_query($connect,
                "UPDATE global_mark SET global_mark = '$global_mark'
                 WHERE  id_user='$id_user'
                 AND id_session='$id_session'");
        }else{
            mysqli_query($connect,
                "INSERT INTO global_mark(id_user,global_mark,id_session)
                 VALUES( '$id_user' , '$global_mark','$id_session')") ;
        }
        
    }
    $_SESSION['succ'] = "So well, Session mark well generated ";
    header('location:/admin/setting?marks-setting&session-marks') ;
}
/* ---------------- Insert New Event ---------------- */
if(isset($_POST['insert-event'])){
    $title = validate_input($_POST['title']) ;
    $date = validate_input($_POST['date']) ;
    $time = validate_input($_POST['time']) ;
    $description = $_POST['description'] ;
    $locate = validate_input($_POST['locate']) ;
    
    $imageName = $_FILES['image']['name'] ;
    $imageSize = $_FILES['image']['size'] ;
    $imageTmp = $_FILES['image']['tmp_name']  ;
    $extansions = array('jpg','jpeg','png') ;
  
    if(empty($title) || empty($date) || empty($time)  ||  empty($locate) || empty($description) ){
        $_SESSION['err'] = "fields with * are required ";
        header("location:/admin/events?add" );
    }else{
        if(empty($imageName)){
            $q = mysqli_query($connect , 
                "INSERT INTO events(event_title , event_date ,event_time , event_location, description)
                 VALUES('$title','$date' ,'$time', '$locate', '$description')"
            ) ;
            $_SESSION['succ'] = "Event Created Successfully " ;
            header("location:/admin/events" );
        }else{
            $imageExtansion = end(explode('.',$imageName)) ;
            if(!is_in($imageExtansion , $extansions)){
                $_SESSION['err'] = "thumbnail type is not allowed";
                header("location:/admin/events?add" );
            }else{
                $q = mysqli_query($connect , 
                    "INSERT INTO events(event_title ,event_date ,event_time ,event_location, description, event_image)
                     VALUES('$title','$date' ,'$time', '$locate', '$description', '$imageName')"
                ) ;
                move_uploaded_file($imageTmp , "../Files/events/".$imageName);
                $_SESSION['succ'] = "Event Created Successfully " ;
                header("location:/admin/events" );
                }
        }
    }
}
/* ---------------- Insert About Us ---------------- */
if(isset($_POST['about'])){
    $descript = $_POST['description'] ;
    mysqli_query($connect,
        "UPDATE school SET about = '$descript' "
    );
    header('location:/admin/setting?front-end&about') ;
}
/* ---------------- Insert director word ---------------- */
if(isset($_POST['director'])){
    $descript = $_POST['description'] ;
    mysqli_query($connect,
        "UPDATE school SET director = '$descript' "
    );
    header('location:/admin/setting?front-end&director') ;
}
/* ---------------- Insert Internal low ---------------- */
if(isset($_POST['internal-low'])){
    $descript = $_POST['description'] ;
    mysqli_query($connect,
        "UPDATE school SET low = '$descript' "
    );
    header('location:/admin/setting?front-end&internal-low') ;
}

if(isset($_POST['file-course'])){
    $title = validate_input($_POST['title']) ;
    $description = $_POST['description'] ;
    $id_user = $_POST['user'] ;
    $id_subject = $_POST['subject'] ;
    $file = $_FILES['file'] ;
    $file_name = $_FILES['file']['name'] ;
    $file_size = $_FILES['file']['size'] ;
    $file_error = $_FILES['file']['error'] ;
    $file_tmp = $_FILES['file']['tmp_name'] ;
    $file_ext_arr = explode('.',$file_name);
    $file_ext = strToLower(end($file_ext_arr));
    $extansions = array('pdf','png','jpg','jpeg','rar','txt');



    if(  isset($_POST['description']) && !empty($_POST['description']) ){
            
            if($file_size > 2000000){
                $_SESSION['err'] = "File is too long";
                header("location:/admin/subjects?subject=".$id_subject);
            }elseif(!is_in($file_ext, $extansions )){
                $_SESSION['err'] = "File doesnt Allowed";
                header("location:/admin/subjects?subject=".$id_subject);
            }else{
               $user = mysqli_fetch_assoc(
                   mysqli_query(
                       $connect,
                       "SELECT * FROM teacher WHERE is_deleted=0
                        AND id_user = ".$id_user
                   )
               ) ;
               

               $subject =  mysqli_fetch_assoc(
                    mysqli_query(
                        $connect,
                        "SELECT * FROM subject WHERE is_deleted=0
                        AND id_subject = ".$id_subject
                    )
                ) ;
                $dir = $subject['title_subject'] ;
                if(!file_exists("../Files/resources/".$dir))
                 mkdir("../Files/resources/".$dir) ;
                move_uploaded_file($file_tmp,"../Files/resources/".$dir."/".$file_name);
                mysqli_query(
                    $connect,
                    "INSERT INTO course_file (id_subject,id_user,file,title,description)
                     VALUES('$id_subject','$id_user','$file_name','$title','$description')"
                ) ;
                $_SESSION['succ'] = " file was added" ;
                header('location:/admin/subjects?subject='.$id_subject);
            }
            
        }else{  
            $_SESSION['err'] = "Add short Description ";
            header("location:/admin/subjects?subject=".$id_subject);
        }
}



}
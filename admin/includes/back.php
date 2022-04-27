<?php
session_start();
require_once('functions.php') ;
require_once('../../connection.php');
$r = mysqli_fetch_assoc(mysqli_query($connect,
                "SELECT * FROM manager WHERE id_user = ".$_SESSION['manager']));
if(isset($_SESSION['manager']) && $r['is_super'] == 1){
/*---------------- retrieve branch and related tables -----------------*/
    if(isset($_POST['br']) && !empty($_POST['br'])) {
        $id_branch = unhash_str($_POST['br']) ;
        $ret_branch = mysqli_query($connect,"UPDATE branch SET is_deleted = 0 WHERE id_branch = ".$id_branch);
        $ret_class = mysqli_query($connect,"UPDATE class SET is_deleted = 0 WHERE id_branch = ".$id_branch);
        $res_class = mysqli_query($connect,
            "SELECT * FROM class WHERE id_branch = ".$id_branch);
        while($tab = mysqli_fetch_assoc($res_class)){
            $ret_inscript = mysqli_query($connect,"UPDATE inscription SET is_deleted = 0 WHERE id_class = ".$tab['id_class']);
            $ret_inscript = mysqli_query($connect,"UPDATE exam SET is_deleted = 0 WHERE id_class = ".$tab['id_class']);
            $ret_inscript = mysqli_query($connect,"UPDATE course SET is_deleted = 0 WHERE id_class = ".$tab['id_class']);
        }
        $_SESSION['succ'] = "Data was Retrieved successfully";
        header("location:/admin/setting?deleted-data&branches");
    }
/*---------------- retrieve Class and related tables -----------------*/
    if(isset($_POST['cl']) && !empty($_POST['cl'])) {
        $id_class = unhash_str($_POST['cl']) ;
        $ret_class = mysqli_query($connect,"UPDATE class SET is_deleted = 0 WHERE id_class= ".$id_class);
        
        $ret_inscript = mysqli_query($connect,"UPDATE inscription SET is_deleted = 0 WHERE id_class = '$id_class'");
        $ret_inscript = mysqli_query($connect,"UPDATE exam SET is_deleted = 0 WHERE id_class = '$id_class'");
        $ret_inscript = mysqli_query($connect,"UPDATE course SET is_deleted = 0 WHERE id_class = '$id_class'");
       
        $_SESSION['succ'] = "Dara was Retrieved successfully";
        header("location:/admin/setting?deleted-data&classes");
    }
/*---------------- retrieve Classroom and related tables -----------------*/
    if(isset($_POST['cr']) && !empty($_POST['cr'])) {
        $id_classroom = unhash_str($_POST['cr']) ;
        $ret_classroom = mysqli_query($connect,"UPDATE classroom SET is_deleted = 0 WHERE id_classroom= ".$id_classroom);

        $ret_inscript = mysqli_query($connect,"UPDATE course SET is_deleted = 0 WHERE id_classroom = '$id_classroom'");
       
        $_SESSION['succ'] = "Dara was retrieved successfully";
        header("location:/admin/setting?deleted-data&classrooms");
    }
/*---------------- retrieve Student and related tables -----------------*/
    if(isset($_POST['st']) && !empty($_POST['st'])) {
        $id_user = unhash_str($_POST['st']) ;
        $ret_user = mysqli_query($connect,"UPDATE student SET is_deleted = 0 WHERE id_user = ".$id_user);
        $ret_payement = mysqli_query($connect,"UPDATE payement SET is_deleted = 0 WHERE id_user = ".$id_user);
        $ret_inscript = mysqli_query($connect,"UPDATE inscription SET is_deleted = 0 WHERE id_user = ".$id_user);
        $ret_global_mark = mysqli_query($connect,"UPDATE global_mark SET is_deleted = 0 WHERE id_user = ".$id_user);
        $ret_mark_semester = mysqli_query($connect,"UPDATE mark_semester SET is_deleted = 0 WHERE id_user = ".$id_user);
        $ret_mark_subject = mysqli_query($connect,"UPDATE mark_subject SET is_deleted = 0 WHERE id_user = ".$id_user);
        $ret_absence_course = mysqli_query($connect,"UPDATE absence_course SET is_deleted = 0 WHERE id_user = ".$id_user);

        $_SESSION['succ'] = "Data was retrieved successfully";
        header("location:/admin/setting?deleted-data&students");
    }
/*---------------- retrieve Teacher and related tables -----------------*/
    if(isset($_POST['tr']) && !empty($_POST['tr'])) {
        $id_user = unhash_str($_POST['tr']) ;
        $ret_user = mysqli_query($connect,"UPDATE teacher SET is_deleted = 0 WHERE id_user = ".$id_user);
        $ret_prof_subject = mysqli_query($connect,"UPDATE prof_subject SET is_deleted = 0 WHERE id_user = ".$id_user);
        $ret_course = mysqli_query($connect,"UPDATE course SET is_deleted = 0 WHERE id_user = ".$id_user); 
        $ret_exam = mysqli_query($connect,"UPDATE exam SET is_deleted = 0 WHERE id_user = ".$id_user);
       
        $_SESSION['succ'] = "Data was retrieved successfully";
        header("location:/admin/setting?deleted-data&teachers");
    }
/*---------------- retrieve Manager and related tables -----------------*/
    if(isset($_POST['mg']) && !empty($_POST['mg'])) {
        $id_user = unhash_str($_POST['mg']) ;
        $ret_user = mysqli_query($connect,"UPDATE manager SET is_deleted = 0 WHERE id_user = ".$id_user);
        
        $_SESSION['succ'] = "Data was retrieved successfully";
        header("location:/admin/setting?deleted-data&managers");
    }
/*---------------- retrieve Semester and related tables -----------------*/
    if(isset($_POST['sm']) && !empty($_POST['sm'])) {
        $id_semester = unhash_str($_POST['sm']) ;
        $ret_semester = mysqli_query($connect,"UPDATE semester SET is_deleted = 0 WHERE id_semester = ".$id_semester);

        $ret_course = mysqli_query($connect,"UPDATE course SET is_deleted = 0 WHERE id_semester = ".$id_semester);

        $_SESSION['succ'] = "Data was retrieved successfully";
        header("location:/admin/setting?deleted-data&semesters");
    }
/*---------------- retrieve Session and related tables -----------------*/
    if(isset($_POST['se']) && !empty($_POST['se'])) {
        $id_session = unhash_str($_POST['se']) ;
        $ret_session = mysqli_query($connect,"UPDATE session SET is_deleted = 0 WHERE id_session = ".$id_session);
        $ret_inscription = mysqli_query($connect,"UPDATE inscription SET is_deleted = 0 WHERE id_session = ".$id_session);
        $ret_semester = mysqli_query($connect,"UPDATE semester SET is_deleted = 0 WHERE id_session = ".$id_semester);
        $id_semester = mysqli_fetch_assoc(mysqli_query($connect,
            "SELECT id_semester FROM semester WHERE id_session = ".$id_session))['id_semester'];
        $ret_semester = mysqli_query($connect,"UPDATE semester SET is_deleted = 0 WHERE id_semester = ".$id_semester);
        $ret_course = mysqli_query($connect,"UPDATE course SET is_deleted = 0 WHERE id_semester = ".$id_semester);
    
        $_SESSION['succ'] = "Data was retrieved successfully";
        header("location:/admin/setting?deleted-data&sessions");
    }
/*---------------- retrieve Subject and related tables -----------------*/
     if(isset($_POST['sb']) && !empty($_POST['sb'])) {
        $id_subject = unhash_str($_POST['sb']) ;
        $ret_subject = mysqli_query($connect,"UPDATE subject SET is_deleted = 0 WHERE id_subject = ".$id_subject);
        $ret_mark_subject = mysqli_query($connect,"UPDATE mark_subject SET is_deleted = 0 WHERE id_subject = ".$id_subject);
        $ret_mark_absence_subject = mysqli_query($connect,"UPDATE absence_subject SET is_deleted = 0 WHERE id_subject = ".$id_subject);
        $ret_course = mysqli_query($connect,"UPDATE course SET is_deleted = 0 WHERE id_subject = ".$id_subject);
        $ret_absence_course = mysqli_query($connect,"UPDATE absence_course SET is_deleted = 0 WHERE id_subject = ".$id_subject);
        
        $_SESSION['succ'] = "Data was retrieved successfully";
        header("location:/admin/setting?deleted-data&subjects");
    }
}




<?php
session_start();
require_once('functions.php') ;
require_once('../../connection.php');
if(isset($_SESSION['manager'])){
/*---------------- delete branch and related tables -----------------*/
    if(isset($_POST['branch']) && !empty($_POST['branch'])) {
        $id_branch = unhash_str($_POST['branch']) ;
        $del_branch = mysqli_query($connect,"UPDATE branch SET is_deleted = 1 WHERE id_branch = ".$id_branch);
        $del_class = mysqli_query($connect,"UPDATE class SET is_deleted = 1 WHERE id_branch = ".$id_branch);
        $res_class = mysqli_query($connect,
            "SELECT * FROM class WHERE id_branch = ".$id_branch);
        while($tab = mysqli_fetch_assoc($res_class)){
            $del_inscript = mysqli_query($connect,"UPDATE inscription SET is_deleted = 1 WHERE id_class = ".$tab['id_class']);
            $del_inscript = mysqli_query($connect,"UPDATE exam SET is_deleted = 1 WHERE id_class = ".$tab['id_class']);
            $del_inscript = mysqli_query($connect,"UPDATE course SET is_deleted = 1 WHERE id_class = ".$tab['id_class']);
        }
        $_SESSION['succ'] = "Data was deleted successfully";
        header("location:/admin/branches");
    }
/*---------------- delete Class and related tables -----------------*/
    if(isset($_POST['cl']) && !empty($_POST['cl'])) {
        $id_class = unhash_str($_POST['cl']) ;
        $del_class = mysqli_query($connect,"UPDATE class SET is_deleted = 1 WHERE id_class= ".$id_class);
        
        $del_inscript = mysqli_query($connect,"UPDATE inscription SET is_deleted = 1 WHERE id_class = '$id_class'");
        $del_inscript = mysqli_query($connect,"UPDATE exam SET is_deleted = 1 WHERE id_class = '$id_class'");
        $del_inscript = mysqli_query($connect,"UPDATE course SET is_deleted = 1 WHERE id_class = '$id_class'");
       
        $_SESSION['succ'] = "Dara was deleted successfully";
        header("location:/admin/classes");
    }
/*---------------- delete Classroom and related tables -----------------*/
    if(isset($_POST['cr']) && !empty($_POST['cr'])) {
        $id_classroom = unhash_str($_POST['cr']) ;
        $del_classroom = mysqli_query($connect,"UPDATE classroom SET is_deleted = 1 WHERE id_classroom= ".$id_classroom);

        $del_inscript = mysqli_query($connect,"UPDATE course SET is_deleted = 1 WHERE id_classroom = '$id_classroom'");
       
        $_SESSION['succ'] = "Dara was deleted successfully";
        header("location:/admin/classrooms");
    }
/*---------------- delete Student and related tables -----------------*/
    if(isset($_POST['student']) && !empty($_POST['student'])) {
        $id_user = unhash_str($_POST['student']) ;
        $del_user = mysqli_query($connect,"UPDATE student SET is_deleted = 1 WHERE id_user = ".$id_user);
        $del_payement = mysqli_query($connect,"UPDATE payement SET is_deleted = 1 WHERE id_user = ".$id_user);
        $del_inscript = mysqli_query($connect,"UPDATE inscription SET is_deleted = 1 WHERE id_user = ".$id_user);
        $del_global_mark = mysqli_query($connect,"UPDATE global_mark SET is_deleted = 1 WHERE id_user = ".$id_user);
        $del_mark_semester = mysqli_query($connect,"UPDATE mark_semester SET is_deleted = 1 WHERE id_user = ".$id_user);
        $del_mark_subject = mysqli_query($connect,"UPDATE mark_subject SET is_deleted = 1 WHERE id_user = ".$id_user);
        $del_absence_course = mysqli_query($connect,"UPDATE absence_course SET is_deleted = 1 WHERE id_user = ".$id_user);

        $_SESSION['succ'] = "Data was deleted successfully";
        header("location:/admin/students");
    }
/*---------------- delete Teacher and related tables -----------------*/
    if(isset($_POST['teacher']) && !empty($_POST['teacher'])) {
        $id_user = unhash_str($_POST['teacher']) ;
        $del_user = mysqli_query($connect,"UPDATE teacher SET is_deleted = 1 WHERE id_user = ".$id_user);
        $del_prof_subject = mysqli_query($connect,"UPDATE prof_subject SET is_deleted = 1 WHERE id_user = ".$id_user);
        $del_course = mysqli_query($connect,"UPDATE course SET is_deleted = 1 WHERE id_user = ".$id_user); 
        $del_exam = mysqli_query($connect,"UPDATE exam SET is_deleted = 1 WHERE id_user = ".$id_user);
       
        $_SESSION['succ'] = "Data was deleted successfully";
        header("location:/admin/teachers");
    }
/*---------------- delete Manager and related tables -----------------*/
    if(isset($_POST['manager']) && !empty($_POST['manager'])) {
        $id_user = unhash_str($_POST['manager']) ;
        $del_user = mysqli_query($connect,"UPDATE manager SET is_deleted = 1 WHERE id_user = ".$id_user);
        
        $_SESSION['succ'] = "Data was deleted successfully";
        header("location:/admin/managers");
    }
/*---------------- delete Semester and related tables -----------------*/
    if(isset($_POST['smstr']) && !empty($_POST['smstr'])) {
        $id_semester = unhash_str($_POST['smstr']) ;
        $del_semester = mysqli_query($connect,"UPDATE semester SET is_deleted = 1 WHERE id_semester = ".$id_semester);

        $del_course = mysqli_query($connect,"UPDATE course SET is_deleted = 1 WHERE id_semester = ".$id_semester);

        $_SESSION['succ'] = "Data was deleted successfully";
        header("location:/admin/semesters");
    }
/*---------------- delete Session and related tables -----------------*/
    if(isset($_POST['session']) && !empty($_POST['session'])) {
        $id_session = unhash_str($_POST['session']) ;
        $del_session = mysqli_query($connect,"UPDATE session SET is_deleted = 1 WHERE id_session = ".$id_session);
        $del_inscription = mysqli_query($connect,"UPDATE inscription SET is_deleted = 1 WHERE id_session = ".$id_session);
        $del_semester = mysqli_query($connect,"UPDATE semester SET is_deleted = 1 WHERE id_session = ".$id_semester);
        $id_semester = mysqli_fetch_assoc(mysqli_query($connect,
            "SELECT id_semester FROM semester WHERE id_session = ".$id_session))['id_semester'];
        $del_semester = mysqli_query($connect,"UPDATE semester SET is_deleted = 1 WHERE id_semester = ".$id_semester);
        $del_course = mysqli_query($connect,"UPDATE course SET is_deleted = 1 WHERE id_semester = ".$id_semester);
    
        $_SESSION['succ'] = "Data was deleted successfully";
        header("location:/admin/sessions");
    }
/*---------------- delete Subject and related tables -----------------*/
     if(isset($_POST['sbj']) && !empty($_POST['sbj'])) {
        $id_subject = unhash_str($_POST['sbj']) ;
        $del_subject = mysqli_query($connect,"UPDATE subject SET is_deleted = 1 WHERE id_subject = ".$id_subject);
        $del_mark_subject = mysqli_query($connect,"UPDATE mark_subject SET is_deleted = 1 WHERE id_subject = ".$id_subject);
        $del_mark_absence_subject = mysqli_query($connect,"UPDATE absence_subject SET is_deleted = 1 WHERE id_subject = ".$id_subject);
        $del_course = mysqli_query($connect,"UPDATE course SET is_deleted = 1 WHERE id_subject = ".$id_subject);
        $del_absence_course = mysqli_query($connect,"UPDATE absence_course SET is_deleted = 1 WHERE id_subject = ".$id_subject);
        
        $_SESSION['succ'] = "Data was deleted successfully";
        header("location:/admin/subjects");
    }
/*---------------- delete Event -----------------*/
    if(isset($_POST['event']) && !empty($_POST['event'])){
        $event = unhash_str($_POST['event']) ;
        $delete_event = mysqli_query($connect,
                "UPDATE events SET is_deleted = 1 where id_event = '$event'");
        header("location:/admin/events");
    }
}

if(isset($_SESSION['teacher'])){
/*---------------- delete Absence  -----------------*/
    if(isset($_POST['std']) && !empty($_POST['std'])
        && isset($_POST['sbj']) && !empty($_POST['sbj'])
        && isset($_POST['grp']) && !empty($_POST['grp'])
        ){
            $student = unhash_str($_POST['std']) ;
            $subject = unhash_str($_POST['sbj']) ;
            $group = unhash_str($_POST['grp']) ;
            $date = date('Y')."-".date('m')."-".date('d') ;
            $del_abs = mysqli_query($connect,"DELETE FROM  absence_course
                    WHERE id_subject = '$subject'
                    AND id_user = '$student'
                    AND date_absence = '$date'");
        $_SESSION['succ'] = "Student is marked now as present";
        header("location:/admin/classes?subj=".$_POST['sbj']."&group=".$_POST['grp']);
    }
/*---------------- delete Mark  -----------------*/
    if(isset($_POST['user']) && !empty($_POST['user'])
        && isset($_POST['subj']) && !empty($_POST['subj'])
        && isset($_POST['group']) && !empty($_POST['group'])
        ){
            $student = unhash_str($_POST['user']) ;
            $subject = unhash_str($_POST['subj']) ;
            $group = unhash_str($_POST['group']) ;
            $del_mark = mysqli_query($connect,"DELETE FROM  mark_subject
                    WHERE id_subject = '$subject'
                    AND id_user = '$student'");
        $_SESSION['succ'] = "Well deleted";
        header("location:/admin/marks?subj=".$_POST['subj']."&group=".$_POST['group']);
    }
}


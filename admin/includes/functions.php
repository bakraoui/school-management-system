<?php

function validate_input($data){
    $data = htmlspecialchars($data) ;
    $data = htmlentities($data) ;
    $data = stripslashes($data) ;
    $data = trim($data) ;
    return $data ;
}

function is_in($key ,array $array) {
    for($i = 0 ; $i < count($array) ; $i++){
        if($key == $array[$i]){
             return true ;
             break ;
        }else{
            continue ;
        }
        return false ;
    }
}

function get_course($connect , $class , $semester , $time , $date){
    $school = mysqli_fetch_assoc(
        mysqli_query($connect,"SELECT * FROM school") 
    );
    if($school['type']==3){
        $result = mysqli_query($connect ,
        "SELECT * FROM course 
        WHERE id_class = '$class'
        AND id_semester = '$semester'
        AND time_course = '$time'
        AND date_course = '$date'");
    }else{
        $session = mysqli_fetch_assoc(
            mysqli_query(
                 $connect,
            "SELECT * FROM session WHERE is_deleted=0 ORDER BY id_session DESC "
            )
           
        )['id_session'] ;
        $result = mysqli_query($connect ,
            "SELECT * FROM course 
            WHERE id_class = '$class'
            AND id_semester IN (
                    SELECT id_semester FROM semester WHERE is_deleted=0 AND id_session = '$session'
                )
            AND time_course = '$time'
            AND date_course = '$date'");
    }
    
    $arr = mysqli_fetch_assoc($result);
    if(isset($arr)){
        $sub = mysqli_fetch_assoc(mysqli_query($connect,
            "SELECT * FROM subject WHERE id_subject = ".$arr['id_subject'] 
        ));
        $clsroom = mysqli_fetch_assoc(mysqli_query($connect,
            "SELECT * FROM classroom WHERE id_classroom = ".$arr['id_classroom'] 
        ));
        $teach = mysqli_fetch_assoc(mysqli_query($connect,
            "SELECT * FROM teacher WHERE id_user = ".$arr['id_user'] 
        ));
        echo "<h6>".$sub['title_subject']."</h6>";
        echo "<span>".$teach['fname_user']." ".$teach['lname_user']."</span><br>";
        echo "<span>".$clsroom['title_classroom']."</span>";
    }else{
        echo "-";
    }
}
function _isset(){
    if(isset($_GET['cls']) && isset($_GET['smstr']) &&isset($_GET['sess'])  ) return true ;
    else return false ;
}

function hash_str($data){
    $data = substr(md5($data),0,10).$data.substr(md5($data),strlen(md5($data))-10,strlen(md5($data))) ;
    return $data ;
}
function unhash_str($data){
    $data = substr($data , 0 , strlen($data)-10);
    $data = substr($data , 10 , strlen($data));
    return $data ;
}

function get_month(int $data){
    $month = "";
    switch($data){
        case 1 : {
            $month = "January" ;
            break ;
        }
        case 2 : {
            $month = "February" ;
            break ;
        }
        case 3 : {
            $month = "March" ;
            break ;
        }
        case 4 : {
            $month = "April" ;
            break ;
        }
        case 5 : {
            $month = "May" ;
            break ;
        }
        case 6 : {
            $month = "June" ;
            break ;
        }
        case 7 : {
            $month = "Jully" ;
            break ;
        }
        case 8 : {
            $month = "August" ;
            break ;
        }
        case 9 : {
            $month = "September" ;
            break ;
        }
        case 10 : {
            $month = "October" ;
            break ;
        }
        case 11 : {
            $month = "November" ;
            break ;
        }
        case 12 : {
            $month = "December" ;
            break ;
        }
    }
    return $month;
}

function get_day($day){
    switch($day){
        case '1' : {
            return "Monday";
            break;
        }
        case '2' :{
            return "Tuesday" ;
            break;
        } 
        case '3' :{
            return "Wednesday" ;
            break;
        } 
        case '4' :{
            return "Thursday" ;
            break;
        }
        case '5' :{
            return "Friday" ;
            break;
        } 
        case '6' :{
            return "Saturday" ;
            break;
        } 
        case '7' :{
            return "Sunday" ;
            break;
        }
    }
}

function get_hour($hour){
    switch($hour){
        case '1' : {
            return "08-10h";
            break;
        }
        case '2' :{
            return "10-12h" ;
            break;
        } 
        case '3' :{
            return "14-16h" ;
            break;
        } 
        case '4' :{
            return "16-18h" ;
            break;
        }
    }
}

function current_page($str){
    $url = $_SERVER['REQUEST_URI'] ;
    $url = explode('/',$url) ;
   foreach($url as $word){
       $list = explode('?',$word) ;
   }
    if(is_in($str , $list)) echo "active";
    else echo "bg-dark";
}

function current_day($day){
    switch($day){
        case 'Mon' : {
            return 1;
            break;
        }
        case 'Tues' :{
            return 2 ;
            break;
        } 
        case 'Wed' :{
            return 3 ;
            break;
        } 
        case 'Thu' :{
            return 4 ;
            break;
        }
        case 'Fri' :{
            return 5 ;
            break;
        } 
        case 'Sat' :{
            return 6 ;
            break;
        } 
        case 'Sun' :{
            return 7 ;
            break;
        }
    }
}

function next_page($current_page){
    return $current_page+1 ;
}

function previous_page($current_page){
    return $current_page-1 ;
}
// include('../../connection.php');


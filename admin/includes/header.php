<?php
require_once("includes/functions.php");
require_once('../connection.php') ;
?>

<?php 
    $school = mysqli_query($connect, "SELECT * FROM school");
    $school_prop = mysqli_fetch_assoc($school) ;
    $sessions = mysqli_query($connect , "SELECT * FROM session WHERE is_deleted = 0") ;
    $semesters = mysqli_query($connect , "SELECT * FROM semester WHERE is_deleted =0") ;
    $classes = mysqli_query($connect , "SELECT * FROM class WHERE is_deleted =0") ;
    $sessions = mysqli_query($connect , "SELECT * FROM session WHERE is_deleted = 0") ;
    $subjects = mysqli_query($connect , "SELECT * FROM subject WHERE is_deleted = 0") ;
    $teachers = mysqli_query($connect , "SELECT * FROM teacher WHERE is_deleted = 0") ;
    $branches = mysqli_query($connect , "SELECT * FROM branch WHERE is_deleted = 0") ;
    $students = mysqli_query($connect , "SELECT * FROM student WHERE is_deleted = 0") ;
    $classrooms = mysqli_query($connect , "SELECT * FROM classroom WHERE is_deleted = 0") ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="/admin/css/style.css">
    <title><?php echo TITLE ; ?></title>
</head>
<body>
    <div class="theme">
       
        <div class="sidebar bg-dark">
            <button class ="sidebar-toggle btn btn-dark "><span><i class="fa fa-bars"></i></span></button>
            <div class="sidebar-container">
                <div class="row">
                    <div class="col ">
                        <div class="user ">
                            <div class="user-img">
                                <img src="<?php 
                                            if($row['image_user'] == NULL) echo "Files/Custom/user.png" ;
                                            elseif(isset($_SESSION['manager'])) echo "Files/managers/".$row['cin_user']."/".$row['image_user'] ;
                                            elseif(isset($_SESSION['teacher'])) echo "Files/teachers/".$row['cin_user']."/".$row['image_user'] ;
                                            elseif(isset($_SESSION['student'])) echo "Files/students/".$row['cin_user']."/".$row['image_user'] ;
                                        ?>"
                                    alt="Profile"
                                    class="rounded-circle"
                                > 
                            </div>
                            <div class="user-name">
                                <h3 class="text-light p-2"><?php echo $row['lname_user']." ".$row['fname_user'] ?></h3>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
            <ul class="sidebar-items list-group ">
                <li class="list-group-item <?php current_page("dashboard") ?>">
                    <a href="/admin/dashboard" >
                        <span class="pr-3"><i class="fa fa-tachometer" aria-hidden="true"></i></span>
                        <span>
                            <?php if(isset($_SESSION['student'])) echo "Home";
                                    else echo "Dashboard"
                            ?>
                        </span>
                    </a>
                </li>
                <?php if(mysqli_num_rows($school)){ ?>

                    <?php if(isset($_SESSION['manager'])){ ?>
                        <li class="list-group-item <?php current_page("managers") ?> ">
                            <a href="/admin/managers" class="text-light">
                                <span class="pr-3"><i class="fa fa-users"></i></span>
                                <span>Managers</span>
                            </a>
                        </li>
                        <li class="list-group-item <?php current_page("teachers") ?>">
                            <a href="/admin/teachers">
                                <span class="pr-3"><i class="fa fa-users"></i></span>
                                <span> Teachers</span>
                            </a>
                        </li>
                        <?php if(mysqli_num_rows($classes)){ ?>
                            <li class="list-group-item <?php current_page("students") ?>">
                                <a href="/admin/students" >
                                    <span class="pr-3"><i class="fa fa-users"></i></span>
                                    <span>Students</span>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="list-group-item <?php current_page("branches") ?>">
                            <a href="/admin/branches" >
                                <span class="pr-3"><i class="fa fa-home"></i></span>
                                <span>
                                    <?php
                                        if($school_prop['type']==0) echo 'Level' ;
                                        else echo "Branches" ;
                                    ?>
                                </span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if(!isset($_SESSION['student']) ){ ?>
                        <?php if(mysqli_num_rows($branches)){ ?> 
                            <li class="list-group-item <?php current_page("classes") ?>">
                                <a href="/admin/classes" >
                                    <span class="pr-3"><i class="fa fa-home"></i></span>
                                    <span>Classes</span>
                                </a>
                            </li>
                         <?php } ?> 
                    <?php } ?>
                    <?php if(isset($_SESSION['manager'])){ ?>
                        <li class="list-group-item <?php current_page("classrooms") ?>">
                            <a href="/admin/classrooms">
                                <span class="pr-3"><i class="fa fa-building"></i></span>
                                <span>Classrooms</span>
                            </a>
                        </li>
                    <?php } ?>
               
                    <?php if($school_prop['type'] == 3 && isset($_SESSION['manager'])){ ?>
                        <li class="list-group-item <?php current_page("modules") ?>">
                            <a href="/admin/modules">
                                <span class="pr-3"><i class="fa fa-book"></i></span>    
                                <span>Modules</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if(!isset($_SESSION['student'])){ ?>
                        <li class="list-group-item <?php current_page("subjects") ?>">
                            <a href="/admin/subjects">
                                <span class="pr-3"><i class="fa fa-book"></i></span>    
                                <span>Subjects</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if(isset($_SESSION['manager']) && $school_prop['type'] == 1 && mysqli_num_rows($subjects)){ ?>
                        <li class="list-group-item <?php current_page("unites") ?>">
                            <a href="/admin/unites">
                                <span class="pr-3"><i class="fa fa-book"></i></span>    
                                <span>Unites</span>
                            </a>
                        </li>
                    <?php } ?>
                
                    <?php if(isset($_SESSION['manager'])){ ?>
                        <?php if(mysqli_num_rows($sessions)){ ?>
                            <li class="list-group-item <?php current_page("inscriptions") ?>">
                                <a href="/admin/inscriptions" >
                                    <span class="pr-3"><i class="fa fa-home"></i></span> 
                                    <span>Inscription</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if(mysqli_num_rows($sessions)){ ?>
                            <li class="list-group-item <?php current_page("semesters") ?>">
                                <a href="/admin/semesters" > 
                                    <span class="pr-3"><i class="fa fa-home"></i></span>
                                    <span>Semester</span>
                                </a>
                            </li>
                        <?php } ?>
                            <li class="list-group-item <?php current_page("sessions") ?>">
                                <a href="/admin/sessions">
                                    <span class="pr-3"><i class="fa fa-home"></i></span>
                                    <span>Session</span>
                                </a>
                            </li>
                            <li class="list-group-item <?php current_page("events") ?>">
                                <a href="/admin/events">
                                    <span class="pr-3"><i class="fa fa-home"></i></span>
                                    <span>Events</span>
                                </a>
                            </li>
                        <?php } ?>
                    
                    <?php if(mysqli_num_rows($teachers) && mysqli_num_rows($classes) 
                            && mysqli_num_rows($subjects) && mysqli_num_rows($semesters)  ){ ?>
                        <li class="list-group-item <?php current_page("schedules") ?>">
                            <a href="/admin/schedules" >
                                <span class="pr-3"><i class="fa fa-table"></i></span> 
                                <span>Schedules</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if(!isset($_SESSION['manager'])){ ?>
                        <li class="list-group-item <?php current_page("tests") ?>">
                            <a href="/admin/tests" >
                                <span class="pr-3"><i class="fa fa-file"></i></span>
                                <span>Tests</span>
                            </a>
                        </li>
                    <?php } ?>
                    
                    <?php 
                        $r = mysqli_fetch_assoc(mysqli_query($connect , 
                                "SELECT allow_showing_marks FROM setting"))['allow_showing_marks'];
                        $bool = false ;

                        if(isset($_SESSION['manager']) && $r == true) $bool = true ;
                        elseif(isset($_SESSION['student']) && $r == true) $bool = true ;
                        else $bool = false ;
                        if($bool  ){ ?>
                            <li class="list-group-item <?php current_page("marks") ?>">
                                <a href="/admin/marks" >
                                    <span class="pr-3"><i class="fa fa-table"></i></span> 
                                    <span>Marks</span>
                                </a>
                            </li>
                    <?php } ?>
                <?php } ?>
                <?php 
                    if(isset($_SESSION['manager'])){
                        $manager = mysqli_fetch_assoc(mysqli_query($connect , 
                                "SELECT * FROM manager WHERE id_user = ".$_SESSION['manager'])) ;
                        if($manager['is_super'] == 1){
                
                ?>
                    <li class="list-group-item dropdown <?php current_page("setting") ?>">
                        <a  href="#" class="dropdown-btn mb-3" >
                            <span class="pr-3"><i class="fa fa-wrench" aria-hidden="true"></i></span> 
                            <span>Setting</span>
                        </a>
                        <div class="dropdown-content">
                            <a href="/admin/setting?school" class="list-group-item " >
                                <span class="pr-3"><i class="fa fa-building "></i></span> 
                                <span>School</span>
                            </a> 
                            <?php if(mysqli_num_rows($school)){ ?>
                                <a href="/admin/setting?front-end" class="list-group-item " >
                                    <span class="pr-3"><i class="fa fa-building "></i></span> 
                                    <span>Front End</span>
                                </a> 
                                <a href="/admin/setting?deleted-data" class="list-group-item " >
                                    <span class="pr-3"><i class="fa fa-trash"></i></span> 
                                    <span>Deleted Data</span>
                                </a>
                                <a href="/admin/setting?marks-setting" class="list-group-item " >
                                    <span class="pr-3"><i class="fa fa-cog "></i></span> 
                                    <span>Marks setting</span>
                                </a>
                                <a href="/admin/setting?inscription" class="list-group-item " >
                                    <span class="pr-3"><i class="fa fa-cog "></i></span> 
                                    <span>Inscription setting</span>
                                </a>
                            <?php } ?>
                        </div>
                    </li>
                <?php }} ?>
                
            </ul>

        </div>
        <div class="main-content">
            <div class="error-success">
                <?php 
                    if(isset($_SESSION['err'])){
                        echo "<p class='alert alert-danger p-2'>".$_SESSION['err']."</p>" ;
                        unset($_SESSION['err']) ;
                    }
                    if(isset($_SESSION['succ'])){
                        echo "<p class='alert alert-success p-2'>".$_SESSION['succ']."</p>" ;
                        unset($_SESSION['succ']) ;
                    }
                ?>
            </div>
            <section class=" p-4"> 
                <div class="p-2 space-between d-flex align-items-center">
                    <p class="text-info">
                        session : 
                        <?php
                            echo "<b>";
                                if(isset($_SESSION['manager'])) echo "Admin";
                                elseif(isset($_SESSION['teacher'])) echo "teacher";
                                elseif(isset($_SESSION['student'])) echo "student";
                            echo "</b>";
                        ?>
                    </p>
                    <div class="user-options">
                        <ul class="user-options-list ">
                            <?php if(isset($_SESSION['student'])){ ?>
                            <li class="notifications-container">
                                <button class="btn notification-toggle"><span> <i class="fa fa-bell"></i> </span></button>
                                <div class="notifications">
                                   <form action="includes/update" method="post">
                                       <input type="submit" name="read-notificfation" value="mark all as read">
                                       <div class="notifications-content">
                                            <?php 
                                                $notifications = mysqli_query(
                                                    $connect,
                                                    "SELECT * FROM notification 
                                                     WHERE is_deleted=0 AND id_user=".$_SESSION['user']."
                                                     ORDER BY id_notification DESC"
                                                ) ;
                                                if(mysqli_num_rows($notifications)){
                                                    while($notify = mysqli_fetch_assoc($notifications)){
                                            ?>
                                                <div class="notificaion">
                                                    <b><?php echo $notify['title'] ?></b>
                                                    <p><?php echo $notify['text'] ?></p>
                                                    <input type="hidden" value="<?php echo $notify['id_notification'] ?>" name="notification[]">
                                                </div>
                                            <?php }} ?>
                                       </div>
                                   </form>
                                </div>
                            </li>
                            <?php } ?>
                            <li class="user-option ">
                                <a href="profile"><span><i class="fa fa-user text-dark"></i></span> </a>
                            </li>                               
                            <li class="user-option ">
                                <form action="includes/logout" method="post">
                                    <input type="hidden" name="logout" value="<?php echo $_SESSION['user']; ?>">
                                    <button type="submit"><span><i class="fa fa-sign-out text-dark"></i></span></button>
                                    
                                </form>
                            </li>
                        </ul> 
                    </div>  
                </div>
                <div class="separator"></div>

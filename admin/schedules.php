<?php
define('TITLE','Schedules : SMS');
define('SUB_TITLE','Schedules');
    require_once('../connection.php') ;
    require_once('includes/functions.php') ;
    session_start();
    if(isset($_SESSION['user'])){
        $id = $_SESSION['user'] ;
        if(isset($_SESSION['manager'])) $query = "SELECT * FROM manager WHERE id_user = '$id' AND is_deleted = 0 ";
        elseif(isset($_SESSION['teacher'])) $query = "SELECT * FROM teacher WHERE id_user = '$id' AND is_deleted = 0 ";
        elseif(isset($_SESSION['student'])) $query = "SELECT * FROM student WHERE id_user = '$id' AND is_deleted = 0 ";
        $result = mysqli_query($connect , $query) ;
        $row = mysqli_fetch_assoc($result) ;
?>

        <?php require_once('includes/header.php') ?>
        
        <?php if(isset($_SESSION['manager'])){  ?>
            <div class="container mb-4">
                <div class="row d-flex justify-content-space-between"> 
                    <div class="col d-flex ">
                        <div class="border btn mr-1">
                            <a href="/admin/schedules" class="p-2 d-block">All</a>
                        </div>
                        
                        <div class="border btn">
                            <a href="/admin/schedules?add" class="p-2 d-block">New</a>
                        </div>
                    </div>  
                </div>
            </div>
        <?php } ?>

        <div class="schedules mb-5">
            <div class="container">
                <?php if(isset($_GET['add']) && isset($_SESSION['manager']) ){ ?>
                    <div class="add ">
                        <h4>Choose class / semester</h4>
                        <div class="card p-3">
                            <div class="d-flex justify-content-center">
                                <form action="includes/insert.php" method="post"class=" col-lg-8 col-md-10 col-sm-12">
                                    
                                    <div class="form-group">
                                        <label for="cls">Class</label>
                                        <select name="cls"  class="form-control" required>
                                            <option ></option>
                                            <?php 
                                                $q = "SELECT * FROM class WHERE is_deleted = 0 ";
                                                $r = mysqli_query($connect , $q);
                                                while($arr = mysqli_fetch_assoc($r)){
                                                    $br = mysqli_fetch_assoc(mysqli_query($connect,
                                                        "SELECT * FROM branch WHERE id_branch=".$arr['id_branch']."  AND is_deleted = 0"
                                                    ))
                                            ?>
                                            <option value="<?php echo hash_str($arr['id_class']); ?>"><?php echo $arr['title_class']." : ".$br['title_branch'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <?php 
                                        $q = "SELECT * FROM session  WHERE is_deleted = 0 ORDER BY id_session DESC";
                                        $r = mysqli_query($connect , $q);
                                        $arr = mysqli_fetch_assoc($r); 
                                    ?>
                                    <div class="form-group">
                                        <label for="smstr">Semester</label>
                                        <select name="smstr" id="" class="form-control" required>
                                            <?php 
                                                $q = "SELECT * FROM semester 
                                                      WHERE is_deleted = 0 
                                                      AND id_session = ".$arr['id_session']."
                                                      ORDER BY id_semester DESC";
                                                $r = mysqli_query($connect , $q);
                                                $arr = mysqli_fetch_assoc($r)
                                            ?>
                                            <option value="<?php echo hash_str($arr['id_semester']); ?>"><?php echo $arr['title_semester'] ?></option>
                                            
                                        </select>
                                    </div>
                                    <?php 
                                        $q = "SELECT * FROM session WHERE is_deleted = 0 ORDER BY id_session DESC";
                                        $r = mysqli_query($connect , $q);
                                    ?>
                                    <input type="hidden" value="<?php 
                                            echo  hash_str(mysqli_fetch_assoc($r)['id_session'] ); 
                                            
                                            ?>" name="sess" id="">
                                
                                    <input type="submit" value="next" name="go-schedules" class="form-control bg-primary text-light">
                                </form>                             
                            </div>
                        </div>
                    </div>     
                <?php }elseif(isset($_GET['create-schedules']) && isset($_SESSION['manager']) ){ ?>
                        
                        <div class="col">  
                            <div>
                                <button class="btn btn-outline-info mb-3 popup-modal">Add seance</button>
                                <div class="modal">
                                    <div class="modal-content">
                                        <button class="close-btn"><span><i class="fa fa-close"></i></span></button>
                                        <form action="includes/insert" method="post">
                                            <div class="form-group">
                                                <label for="subject">subject</label>
                                                <select name="subject" class="form-control"  required>
                                                    <option value=""></option>
                                                    <?php 
                                                        $r = mysqli_query($connect,
                                                        "SELECT * FROM subject WHERE is_deleted = 0");
                                                        while($arr = mysqli_fetch_assoc($r)){
                                                    ?>
                                                    <option value="<?php echo hash_str($arr['id_subject']) ?>"><?php echo $arr['title_subject'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="teacher">Teacher</label>
                                                <select name="teacher" class="form-control" required>
                                                    <option value=""></option>
                                                    <?php 
                                                        $r = mysqli_query($connect,
                                                        "SELECT * FROM teacher WHERE is_deleted = 0");
                                                        while($arr = mysqli_fetch_assoc($r)){
                                                    ?>
                                                    <option value="<?php echo hash_str($arr['id_user']) ?>"><?php echo $arr['fname_user']." ".$arr['lname_user'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="classroom">Classroom</label>
                                                <select name="classroom" class="form-control" required>
                                                    <option value=""></option>
                                                    <?php 
                                                        $r = mysqli_query($connect,
                                                        "SELECT * FROM classroom WHERE is_deleted = 0");
                                                        while($arr = mysqli_fetch_assoc($r)){
                                                    ?>
                                                    <option value="<?php echo hash_str($arr['id_classroom']) ?>"><?php echo $arr['title_classroom'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="time">Time</label>
                                                <select name="time" class="form-control" required>
                                                    <option value=""></option>
                                                    <option value="1">08-10</option>
                                                    <option value="2">10-12</option>
                                                    <option value="3">14-16</option>
                                                    <option value="4">16-18</option>                                        
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="day">Day</label>
                                                <select name="day" class="form-control" required>
                                                    <option value=""></option>
                                                    <option value="1">Monday</option>
                                                    <option value="2">Tuesday</option>
                                                    <option value="3">Wednesday</option>
                                                    <option value="4">Thursday</option>
                                                    <option value="5">Friday</option>
                                                    <option value="6">Saturday</option>                                        
                                                </select>
                                            </div>
                                            <input type="hidden" name="cls" 
                                                value="<?php if(isset($_GET['cls'])) echo $_GET['cls'] ?>"
                                                >
                                            <input type="hidden" name="smstr" 
                                                value="<?php if(isset($_GET['smstr'])) echo $_GET['smstr'] ?>"
                                                >
                                            <input type="submit" value="Add Course" name="insert-course" class="form-control bg-primary text-light">
                                        </form>                                        
                                    </div>

                                </div>
                            </div>
                                
                            <div class="overflow-x shadow">
                                <table  cellspacing="0" class="table table-striped">
                                    <thead >
                                        <tr>
                                            <th></th>
                                            <th>8-10</th>
                                            <th>10-12</th>
                                            <th>12-14</th>
                                            <th>14-16</th>
                                            <th>16-18</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Monday</td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),1,1) ?></td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),2,1) ?></td>
                                            <td> </td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),3,1) ?></td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),4,1) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tuesday</td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),1,2) ?></td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),2,2) ?></td>
                                            <td> </td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),3,2) ?></td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),4,2) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Wednesday</td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),1,3) ?></td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),2,3) ?></td>
                                            <td> </td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),3,3) ?></td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),4,3) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Thirsday</td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),1,4) ?></td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),2,4) ?></td>
                                            <td> </td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),3,4) ?></td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),4,4) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Friday</td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),1,5) ?></td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),2,5) ?></td>
                                            <td> </td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),3,5) ?></td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),4,5) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Saturday</td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),1,6) ?></td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),2,6) ?></td>
                                            <td> </td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),3,6) ?></td>
                                            <td> <?php get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),4,6) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Sunday</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>         
                            </div>
                        </div>
                 <?php }elseif(isset($_SESSION['student'])){ ?>     
                    <div class="overflow-x shadow">
                        <table cellspacing="0" class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>8-10</th>
                                    <th>10-12</th>
                                    <th>12-14</th>
                                    <th>14-16</th>
                                    <th>16-18</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $id = $_SESSION['student'] ;
                                    $class = hash_str(mysqli_fetch_assoc(mysqli_query($connect , 
                                                "SELECT * FROM inscription WHERE is_deleted = 0
                                                    AND id_session = (SELECT id_session FROM session 
                                                            WHERE is_deleted = 0 
                                                            ORDER BY id_session DESC) 
                                                    AND id_user = '$id'"))['id_class']) ;
                                    $semester = hash_str(mysqli_fetch_assoc(mysqli_query($connect , 
                                                "SELECT id_semester FROM semester WHERE is_deleted = 0  ORDER BY id_semester DESC"))['id_semester']);
                                    
                                ?>
                                <tr>
                                    <td>Monday</td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),1,1); ?></td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),2,1) ?></td>
                                    <td> </td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),3,1) ?></td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),4,1) ?></td>
                                </tr>
                                <tr>
                                    <td>Tuesday</td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),1,2) ?></td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),2,2) ?></td>
                                    <td> </td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),3,2) ?></td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),4,2) ?></td>
                                </tr>
                                <tr>
                                    <td>Wednesday</td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),1,3) ?></td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),2,3) ?></td>
                                    <td> </td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),3,3) ?></td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),4,3) ?></td>
                                </tr>
                                <tr>
                                    <td>Thirsday</td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),1,4) ?></td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),2,4) ?></td>
                                    <td> </td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),3,4) ?></td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),4,4) ?></td>
                                </tr>
                                <tr>
                                    <td>Friday</td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),1,5) ?></td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),2,5) ?></td>
                                    <td> </td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),3,5) ?></td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),4,5) ?></td>
                                </tr>
                                <tr>
                                    <td>Saturday</td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),1,6) ?></td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),2,6) ?></td>
                                    <td> </td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),3,6) ?></td>
                                    <td> <?php  get_course($connect,unhash_str($class),unhash_str($semester),4,6) ?></td>
                                </tr>
                                <tr>
                                    <td>Sunday</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table> 
                    </div>  
                <?php }else{ ?>
                        <?php if(!isset($_SESSION['student'])){ 
                                $course = mysqli_num_rows(
                                    mysqli_query($connect,
                                        "SELECT * FROM course WHERE is_deleted=0")
                                );
                                if($course){
                            ?>

                                <div class="container">
                                    <button class=" popup-modal btn btn-success mb-4">show schedules</button>
                                    <div class="modal">
                                        <div class="modal-content">
                                            <button class="close-btn"><span><i class="fa fa-close"></i></span></button>
                                            <form action="includes/insert.php" method="post">
                                                <div class="form-group">
                                                    <label for="cls">Class</label>
                                                    <select name="cls" id="" class="form-control" required>
                                                        <option ></option>
                                                        <?php 
                                                            $id_sess = mysqli_fetch_assoc(mysqli_query($connect,
                                                                "SELECT id_session FROM session 
                                                                    WHERE is_deleted = 0 
                                                                    ORDER BY id_session DESC") )['id_session'];
                                                            if(isset($_SESSION['manager'])) 
                                                                $q = "SELECT * FROM class,course
                                                                        WHERE class.is_deleted = 0 AND course.is_deleted = 0
                                                                        AND class.id_class = course.id_class
                                                                        AND course.id_semester IN (SELECT id_semester FROM semester  WHERE id_session = '$id_sess') 
                                                                        GROUP BY course.id_class ";
                                                            elseif(isset($_SESSION['teacher'])){ 
                                                                
                                                                $q = "SELECT * FROM class,course 
                                                                        WHERE   class.is_deleted = 0 AND course.is_deleted = 0 
                                                                        AND class.id_class=course.id_class
                                                                        AND course.id_semester IN (SELECT id_semester FROM semester  WHERE id_session = '$id_sess')
                                                                        AND course.id_user = ".$_SESSION['teacher']." GROUP BY course.id_class";
                                                            
                                                                }
                                                            $r = mysqli_query($connect , $q);
                                                            while($arr = mysqli_fetch_assoc($r)){
                                                                $br = mysqli_fetch_assoc(mysqli_query($connect,
                                                                    "SELECT * FROM branch WHERE id_branch=".$arr['id_branch']." AND is_deleted = 0"
                                                                ))
                                                        ?>
                                                        <option value="<?php echo hash_str($arr['id_class']); ?>"
                                                                <?php  if(isset($_GET['cls']) && unhash_str($_GET['cls']) == $arr['id_class'] ) echo 'selected'; ?>>
                                                                <?php echo $arr['title_class']." : ".$br['title_branch'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                
                                                <?php 
                                                    $q = "SELECT * FROM session WHERE is_deleted = 0 ORDER BY id_session DESC";
                                                    $r = mysqli_query($connect , $q);
                                                    $arr = mysqli_fetch_assoc($r); 
                                                ?>
                                                
                                                    
                                                <div class="form-group"> 
                                                    <label for="smstr">Semester</label>
                                                    <select name="smstr" id="" class="form-control" required>
                                                        <?php 
                                                            $q = "SELECT * FROM semester  
                                                                  WHERE is_deleted = 0 
                                                                  AND id_session =".$arr['id_session']."
                                                                  ORDER BY id_semester DESC";
                                                            $r = mysqli_query($connect , $q);
                                                            $ar = mysqli_fetch_assoc($r) ;
                                                        ?>
                                                        <option value="<?php echo hash_str($ar['id_semester']) ?>">
                                                            <?php echo $ar['title_semester'] ?>
                                                        </option>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="sess" value="<?php echo hash_str($arr['id_session']); ?>">
                                                <div class="form-group">
                                                    <label >Session</label>
                                                    <input type="text" disabled value="<?php echo $arr['date_start']."-".$arr['date_end'] ?>" class="form-control">
                                                </div>
                                                <input type="submit" value="next" name="show-schedules" class="form-control bg-primary text-light">
                                            </form>                            
                                        </div>

                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>

                    <div class="overflow-x shadow">
                        <table cellspacing="0" class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>8-10</th>
                                    <th>10-12</th>
                                    <th>12-14</th>
                                    <th>14-16</th>
                                    <th>16-18</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr>
                                    <td>Monday</td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),1,1); ?></td>
                                    <td> <?php if(_isset() ) get_course($connect,$_GET['cls'],$_GET['smstr'],2,1) ?></td>
                                    <td> </td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),3,1) ?></td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),4,1) ?></td>
                                </tr>
                                <tr>
                                    <td>Tuesday</td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),1,2) ?></td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),2,2) ?></td>
                                    <td> </td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),3,2) ?></td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),4,2) ?></td>
                                </tr>
                                <tr>
                                    <td>Wednesday</td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),1,3) ?></td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),2,3) ?></td>
                                    <td> </td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),3,3) ?></td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),4,3) ?></td>
                                </tr>
                                <tr>
                                    <td>Thirsday</td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),1,4) ?></td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),2,4) ?></td>
                                    <td> </td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),3,4) ?></td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),4,4) ?></td>
                                </tr>
                                <tr>
                                    <td>Friday</td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),1,5) ?></td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),2,5) ?></td>
                                    <td> </td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),3,5) ?></td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),4,5) ?></td>
                                </tr>
                                <tr>
                                    <td>Saturday</td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),1,6) ?></td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),2,6) ?></td>
                                    <td> </td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),3,6) ?></td>
                                    <td> <?php if(_isset() ) get_course($connect,unhash_str($_GET['cls']),unhash_str($_GET['smstr']),4,6) ?></td>
                                </tr>
                                <tr>
                                    <td>Sunday</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table> 
                    </div>
                        

                <?php } ?>
                

            </div>
            
        </div>

        <?php require_once('includes/footer.php') ?>

    <?php }else{  header('location:/admin/login');} ?>

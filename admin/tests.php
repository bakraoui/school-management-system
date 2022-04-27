<?php
    define('TITLE','Tests : SMS');
    define('SUB_TITLE','Tests');
    require_once('../connection.php') ;
    require_once('includes/functions.php') ;
    session_start();
    if(isset($_SESSION['user']) && isset($_SESSION['student'])){
        $id = $_SESSION['student'] ;
        $query = "SELECT * FROM student WHERE id_user = '$id' AND is_deleted = 0";
        $result = mysqli_query($connect , $query) ;
        $row = mysqli_fetch_assoc($result) ;
     ?>

        <?php require_once('includes/header.php') ?>
        <div class="mb-3">
            <?php if(isset($_GET['test']) && !empty($_GET['test'])){ 
                $test = unhash_str($_GET['test']);
                $act_date = date('Y-m-d') ;
                $class = mysqli_fetch_assoc(
                            mysqli_query($connect , 
                                "SELECT * FROM inscription,class
                                WHERE inscription.id_user = '$id'
                                AND inscription.id_class=class.id_class
                                AND inscription.id_session = (SELECT id_session FROM session 
                                                    WHERE is_deleted = 0 
                                                    ORDER BY id_session DESC)
                                AND inscription.is_deleted = 0 AND class.is_deleted=0
                                ") 
                        );
                $id_class = $class['id_class'] ;
                $q = mysqli_fetch_assoc(mysqli_query($connect , 
                                "SELECT * FROM exam WHERE is_deleted = 0 
                                AND id_exam = '$test' ")) ;
                $session = mysqli_fetch_assoc(mysqli_query($connect,
                                "SELECT * FROM session WHERE is_deleted =0 
                                ORDER BY id_session DESC")) ;
                $session_dir = $session['date_start'].'-'.$session['date_end'];
                $exam_dir = explode('.',$q['exam_file']);
             ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="exam-card">
                                    <div class="face">
                                        <div class="image">
                                            <?php if($q['thumbnail'] != "") { ?>
                                                <img style="width: 15rem;" src="Files/sessions/<?php echo $session_dir."/".$class['title_class']."/tests/".$exam_dir[0]."/".$q['thumbnail'];?>"  alt="Test">
                                            <?php }else{ ?>
                                                <img style="width: 15rem;" src="Files/Custom/test.jpg"  alt="Test">
                                            <?php } ?>
                                        </div>
                                    </div>                                
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Teacher</td>
                                            <td>
                                                <?php
                                                        $teacher = mysqli_fetch_assoc(mysqli_query($connect,
                                                                        "SELECT * FROM teacher 
                                                                        WHERE is_deleted =0
                                                                        AND id_user = ".$q['id_user']));
                                                        echo $teacher['fname_user']." ".$teacher['lname_user']
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>From</td>
                                            <td><?php echo $q['exam_start'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>To</td>
                                            <td><?php echo $q['exam_end'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td><?php echo $q['description'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?php
                                    $class = mysqli_fetch_assoc(
                                        mysqli_query($connect,
                                                "SELECT * FROM class WHERE is_deleted = 0
                                                 AND id_class = '$id_class'")
                                        ) ;
                                ?>
                                <a href="Files/sessions/<?php echo $session_dir."/".$class['title_class']."/tests/".$exam_dir[0] ?>/<?php echo $q['exam_file'] ?>" download class="btn btn-primary">Download</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                        $arr = mysqli_fetch_assoc(mysqli_query($connect,
                                    "SELECT id_exam_solution FROM exam_solution 
                                    WHERE is_deleted = 0 
                                    AND id_exam = '$test'
                                    AND id_user = ".$_SESSION['student'])) ;
                        if(isset($arr) && !empty($arr)){
                    ?>
                        <div class="col-md-4 mt-2">
                            <div class="card">
                                <div class="card-header">Add Solution</div>
                                <div class="card-body">
                                    <form action="includes/insert" method="post"  enctype="multipart/form-data">
                                        <input type="hidden" name="user" value="<?php echo hash_str($_SESSION['student']) ?>">
                                        <input type="hidden" name="exam" value="<?php echo hash_str($q['id_exam']) ?>">
                                        <div class="form-group">
                                            <input type="file" name="exam-solution" id="" class="form-control" required>
                                        </div>
                                        <input type="submit" name="insert-solution" value="Send" class="form-control bg-primary">
                                    </form>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="col-md-4 mt-2">
                            <div class="card">
                                <div class="card-header">Add Solution</div>
                                <div class="card-body">
                                    <form action="includes/insert" method="post"  enctype="multipart/form-data">
                                        <input type="hidden" name="user" value="<?php echo hash_str($_SESSION['student']) ?>">
                                        <input type="hidden" name="exam" value="<?php echo hash_str($q['id_exam']) ?>">
                                        <div class="form-group">
                                            <input type="file" name="exam-solution" id="" class="form-control" required>
                                        </div>
                                        <input type="submit" name="insert-solution" value="Send" class="form-control bg-primary">
                                    </form>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php }else{ ?>
                <div class="mb-5">
                    
                        <?php
                            $act_date = date('Y-m-d') ;
                            $session = mysqli_fetch_assoc(mysqli_query($connect,
                                            "SELECT * FROM session WHERE is_deleted =0 
                                            ORDER BY id_session DESC")) ;
                            $id_session = $session['id_session'] ;
                            $class = mysqli_fetch_assoc(
                                        mysqli_query($connect , 
                                            "SELECT id_class FROM inscription
                                            WHERE id_user = '$id'
                                            AND id_session = (SELECT id_session FROM session 
                                                                WHERE is_deleted = 0 
                                                                ORDER BY id_session DESC)
                                            AND is_deleted = 0
                                            ") 
                                    );
                            $id_class = $class['id_class'] ;
                            $q = mysqli_query($connect , 
                                        "SELECT * FROM exam 
                                            WHERE id_class = '$id_class'
                                            AND is_deleted = 0 ") ;
                            
                            
                            $session_dir = $session['date_start'].'-'.$session['date_end'];

                            if(mysqli_num_rows($q) > 0){

                        ?>
                        <div class="row">
                            <?php
                                while ($tab = mysqli_fetch_assoc($q)) {
                                    $exam_dir = explode('.',$tab['exam_file']);
                            ?>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="card  p-1 ">
                                            <div class="card-body exam-card">
                                                <div class="pile">
                                                    <a class="bg-light p-2 border rounded pr-4 pl-4" href="tests?test=<?php echo hash_str($tab['id_exam']) ?>">more</a>
                                                </div>
                                                <div class="face">
                                                    <div class="image">
                                                       <?php if($tab['thumbnail'] != NULL) { ?>
                                                            <img style="" src="Files/sessions/<?php echo $session_dir."/".$class['title_class']."/tests/".$exam_dir[0]."/".$tab['thumbnail'];?>"  alt="Test">
                                                        <?php }else{ ?>
                                                            <img src="Files/Custom/test.jpg"  alt="Test">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-center">
                                                <?php
                                                    $class = mysqli_fetch_assoc(
                                                        mysqli_query($connect,
                                                                "SELECT * FROM class WHERE is_deleted = 0
                                                                AND id_class = '$id_class'")
                                                        ) ;
                                                ?>
                                                <a href="Files/sessions/<?php echo $session_dir."/".$class['title_class']."/tests/".$exam_dir[0] ?>/<?php echo $tab['exam_file'] ?>" download >Download</a>
                                            </div>                 
                                        </div>
                                    </div>
                                <?php }  ?>  
                        </div>
                        <?php }else{
                                echo "<div class='card'>" ;
                                echo "<h1 class='text-center mt-5 pt-5'> No Test Availible </h1>" ;
                                echo "<h1 class='text-center mt-5 mb-5 pt-5'> Enjoy your day </h1>" ;
                                echo "</div>";
                         }  ?>            
                </div>
            <?php } ?>
        </div>
        <?php require_once('includes/footer.php') ; ?>
    
<?php }elseif(isset($_SESSION['user']) && isset($_SESSION['teacher'])){ 
    $id = $_SESSION['teacher'] ;
    $query = "SELECT * FROM teacher WHERE id_user = '$id' AND is_deleted = 0";
    $result = mysqli_query($connect , $query) ;
    $row = mysqli_fetch_assoc($result) ;
 ?>
        <?php require_once('includes/header.php') ?>
        <div class="mb-3">
         <?php if(isset($_GET['test']) && !empty($_GET['test'])){ 
                $test = unhash_str($_GET['test']);
                $act_date = date('Y-m-d') ;
                $id_class =  unhash_str($_GET['cl']);
                $class = mysqli_fetch_assoc(
                    mysqli_query($connect , 
                        "SELECT * FROM class
                         WHERE class.is_deleted=0
                         AND id_class = '$id_class'
                        ") 
                );
                $q = mysqli_fetch_assoc(mysqli_query($connect , 
                                "SELECT * FROM exam WHERE is_deleted = 0 
                                AND id_exam = '$test' ")) ;
                $session = mysqli_fetch_assoc(mysqli_query($connect,
                                "SELECT * FROM session WHERE is_deleted =0 
                                ORDER BY id_session DESC")) ;
                $id_session = $session['id_session'];
                
                $session_dir = $session['date_start'].'-'.$session['date_end'];
                $exam_dir = explode('.',$q['exam_file']);
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="exam-card">
                                    <div class="face">
                                        <div class="image">
                                            <?php if($q['thumbnail'] != NULL) {  ?>
                                                <img style="width: 15rem;" src="Files/sessions/<?php echo $session_dir."/".$class['title_class']."/tests/".$exam_dir[0]."/".$q['thumbnail'];?>"  alt="Test">                                            
                                                
                                            <?php }else{ ?>
                                                <img style="width: 15rem;" src="Files/Custom/test.jpg"  alt="Test">
                                            <?php } ?>
                                        </div>
                                    </div>                                
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Teacher</td>
                                            <td>
                                                <?php
                                                    $teacher = mysqli_fetch_assoc(mysqli_query($connect,
                                                                    "SELECT * FROM teacher 
                                                                    WHERE is_deleted =0
                                                                    AND id_user = ".$q['id_user']));
                                                    echo $teacher['fname_user']." ".$teacher['lname_user']
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>From</td>
                                            <td><?php echo $q['exam_start'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>To</td>
                                            <td><?php echo $q['exam_end'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td><?php echo $q['description'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                               
                                
                    </div>
                </div>

                <?php
                    $class = mysqli_fetch_assoc(
                        mysqli_query($connect,
                                "SELECT * FROM class WHERE is_deleted = 0
                                    AND id_class = '$id_class'")
                        ) ;
                ?>

                <div class="">
                    <?php 
                        $exams = mysqli_query($connect,
                                "SELECT * FROM exam_solution 
                                WHERE is_deleted = 0 
                                AND id_exam = '$test'
                                AND id_user IN (SELECT id_user FROM  inscription
                                        WHERE is_deleted = 0
                                        AND id_class = ".$class['id_class']."
                                        AND id_session = '$id_session')"
                                        ) ;
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <a href="Files/sessions/<?php echo $session_dir."/".$class['title_class']."/tests/".$exam_dir[0] ?>/<?php echo $q['exam_file'] ?>" download class="btn btn-primary">Download</a>
                        </div>
                        <div class="card-body">
                            <div class="overflow-x">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>First Name </th>
                                            <th>Last Name</th>
                                            <th>CIN</th>
                                            <th>Download</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            while ($exam = mysqli_fetch_assoc($exams)) {
                                                $student = mysqli_fetch_assoc(
                                                    mysqli_query($connect ,"SELECT * FROM student 
                                                                WHERE id_user = ".$exam['id_user'])
                                                    );
                                        ?>
                                        <tr>
                                            <td><?php echo $student['lname_user'] ; ?></td>
                                            <td><?php echo $student['fname_user']  ; ?></td>
                                            <td><?php echo $student['cin_user']  ; ?></td>
                                            <td> <a href="Files/sessions/<?php echo $session_dir."/".$class['title_class']."/tests/".$exam_dir[0] ?>/<?php echo $exam['exam_solution'] ?>" download class="btn btn-primary"><span><i class="fa fa-download"></i></span></a></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        <?php }else{ ?>
                <div class="row">
                    <?php
                        $exams = mysqli_query($connect , 
                                    "SELECT * FROM exam WHERE id_user = '$id' AND is_deleted = 0") ;
                        $session = mysqli_fetch_assoc(
                            mysqli_query($connect , 
                                    "SELECT * FROM session WHERE is_deleted = 0
                                    ORDER BY id_session DESC") 
                        );
                        $session_dir = $session['date_start'].'-'.$session['date_end'];
                        while ($exam = mysqli_fetch_assoc($exams)) {
                            $exam_dir = explode('.',$exam['exam_file']);
                            $id_class = $exam['id_class'];
                            $id_subject = $exam['id_subject'];
                            $class = mysqli_fetch_assoc(
                                mysqli_query($connect , 
                                    "SELECT * FROM class WHERE id_class = '$id_class' AND is_deleted = 0") 
                            ) ;
                            $subject = mysqli_fetch_assoc(
                                mysqli_query($connect , 
                                    "SELECT * FROM subject WHERE id_subject = '$id_subject' AND is_deleted = 0") 
                            );
                    ?>
                        <div class="card test m-1 ">
                            <div class="row">
                                <div class="col-sm-4 p-0">
                                    <div class="image ">
                                        <img src="Files/<?php 
                                            if($exam['thumbnail']== "" ) echo "Custom/test.jpg";
                                            else echo "sessions/".$session_dir."/".$class['title_class']."/tests/".$exam_dir['0']."/".$exam['thumbnail'] ;
                                            ?>" alt="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-1">
                                        <p><?php echo $class['title_class'] ?></p>
                                        <p><?php echo $subject['title_subject'] ?></p>
                                        <p><?php echo $exam['exam_start'] ?></p>
                                        <p><?php echo $exam['exam_end'] ?></p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="">
                                        <a class="btn btn-primary m-1" href="tests?test=<?php echo hash_str($exam['id_exam']); ?>&cl=<?php echo hash_str($class['id_class']) ?>"><span><i class="fa fa-plus"></i></span></a>
                                        <a class="btn btn-danger m-1" href="includes/delete?exam="<?php echo hash_str($exam['id_exam']); ?>><span><i class="fa fa-trash"></i></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
        <?php } ?>
        </div>
        <?php require_once('includes/footer.php') ?>
<?php }else{  header('location:/admin/login');} ?>
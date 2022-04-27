<?php
session_start();
define('TITLE','Marks : SMS');
define('SUB_TITLE','Marks');
    require_once('../connection.php') ;
    include('includes/functions.php') ;
    if(isset($_SESSION['user'])){
        $id = $_SESSION['user'] ;
        if(isset($_SESSION['manager'])) $query = "SELECT * FROM manager WHERE id_user = '$id ' ";
        if(isset($_SESSION['teacher'])) $query = "SELECT * FROM teacher WHERE id_user = '$id ' ";
        if(isset($_SESSION['student'])) $query = "SELECT * FROM student WHERE id_user = '$id ' ";
        $result = mysqli_query($connect , $query) ;
        $row = mysqli_fetch_assoc($result) ;
?>

        <?php require_once('includes/header.php') ?>
        <?php 
            $setting = mysqli_fetch_assoc(
                mysqli_query($connect,"SELECT * FROM setting")
            );
        ?>
<div class="mb-4">
    <?php if(isset($_SESSION['teacher'])) {  ?>
        
       <?php if(isset($_GET['group']) && isset($_GET['subj'])){ ?>
            <?php 
                $classes = mysqli_query($connect, 
                    "SELECT * FROM class,course 
                     WHERE class.is_deleted = 0  AND course.is_deleted = 0 
                     AND class.id_class = course.id_class
                     AND course.id_user = ".$_SESSION['teacher']." 
                     GROUP BY course.id_class" );
                while($classe = mysqli_fetch_assoc($classes)){
                    
                    if(unhash_str($_GET['group']) == $classe['id_class'] ){
            ?>
                <div class="container mb-5">
                    <?php 
                        $r = mysqli_query($connect,"SELECT * FROM course,subject 
                                WHERE subject.is_deleted = 0  AND course.is_deleted = 0 
                                AND course.id_class = ".unhash_str($_GET['group'])."
                                AND course.id_user = ".$_SESSION['teacher']."
                                AND course.id_subject = subject.id_subject GROUP BY course.id_subject"); 
                    ?>
                    <div class="row border   mb-4">
                        <div class="space-between p-2">
                            <?php 
                                $group_arr = mysqli_fetch_assoc(mysqli_query($connect,
                                   "SELECT * FROM class, branch 
                                    WHERE class.is_deleted=0 AND branch.is_deleted=0
                                     AND class.id_class = ".unhash_str($_GET['group'])." 
                                    AND class.id_branch = branch.id_branch 
                                    ")) ;
                            ?>
                            <div class="col">
                                <span><?php echo $group_arr['title_class'] ?></span>
                            </div>
                            <div class="col">
                                <?php echo date("d"."-"."m"."-"."Y") ?>
                            </div>
                            <?php 
                                $s = mysqli_fetch_assoc(mysqli_query($connect,
                                "SELECT * FROM subject WHERE is_deleted = 0 
                                AND id_subject = ".unhash_str($_GET['subj']))) ;
                            ?>
                            <div class="col">
                                <?php echo $s['title_subject']; ?>
                            </div>
                        </div>
                    </div>
                    <?php if($school_prop['type']==1){ ?>
                            <?php 
                                $unites = mysqli_query($connect,
                                    "SELECT * FROM unit WHERE is_deleted=0 AND id_subject=".unhash_str($_GET['subj']))
                            ?>
                            <div class="shadow">
                                <form action="includes/insert" method="post">
                                    <input type="hidden" name="subject" value="<?php echo $_GET['subj']; ?>" >
                                    <input type="hidden" name="group" value="<?php echo $_GET['group']; ?>" >
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <?php
                                                    while($unit = mysqli_fetch_assoc($unites)){
                                                ?>
                                                        <th class="rotateY"><?php echo $unit['title_unit'] ?></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $s =mysqli_fetch_assoc(mysqli_query($connect,
                                                        "SELECT * FROM session WHERE is_deleted = 0 
                                                            ORDER BY id_session DESC "));
                                                $students = mysqli_query($connect,
                                                        "SELECT * FROM student,inscription
                                                        WHERE student.is_deleted = 0  AND inscription.is_deleted = 0
                                                        AND student.id_user = inscription.id_user 
                                                        AND inscription.id_session = ".$s['id_session']."
                                                        AND inscription.id_class =  ".unhash_str($_GET['group'])) ;
                                                
                                                while($student = mysqli_fetch_assoc($students) ){
                                                    $unites = mysqli_query($connect,
                                                        "SELECT * FROM unit WHERE is_deleted=0 AND id_subject=".unhash_str($_GET['subj']));
                                            ?>
                                                <tr>
                                                    <input type="hidden" name="users[]" value="<?php echo $student['id_user']?>">
                                                    <td><?php echo $student['fname_user']." ".$student['lname_user'] ?></td>
                                                    <?php
                                                        while($unit = mysqli_fetch_assoc($unites)){
                                                    ?>
                                                            <td class="rotateY">
                                                                <?php 
                                                                        $current_semester = mysqli_fetch_assoc(mysqli_query($connect , 
                                                                        "SELECT * FROM semester ORDER BY id_semester DESC"))['id_semester'] ;
                                                                        $unit_mark = mysqli_query($connect,
                                                                        "SELECT * FROM mark_unit WHERE is_deleted=0
                                                                        AND id_unit=".$unit['id_unit']."
                                                                        AND id_user =".$student['id_user']."
                                                                        AND id_semester=".$current_semester);
                                                                    
                                                                    ?>
                                                                <input type="reel" 
                                                                        class="border  w-50 p-2
                                                                        <?php 
                                                                            if(mysqli_num_rows($unit_mark)){
                                                                                echo "border-0";
                                                                            }else{ 
                                                                                echo "border-info";
                                                                            }
                                                                       ?>
                                                                                "
                                                                       name="<?php echo 'unit_'.$unit['id_unit'].'[]'; ?>"
                                                                       value="<?php 
                                                                            if(mysqli_num_rows($unit_mark)){
                                                                                echo mysqli_fetch_assoc($unit_mark)['mark_unit'];
                                                                            }
                                                                       ?>"
                                         
                                                                >    
                                                            </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="form-group">
                                        <input type="submit" 
                                                class="form-control bg-success text-light text-center" 
                                                name="insert-mark-unit"
                                                value="Submit" >
                                    </div>
                                </form>
                            </div>
                    <?php }else{ ?>
                        <form action="/admin/includes/insert" method="post">
                            <div class="overflow-x ">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>CNE</th>
                                            <th>CIN</th>
                                            <th>Mark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" name="subj" value="<?php echo $_GET['subj']; ?>">
                                        <input type="hidden" name="group" value="<?php echo $_GET['group']; ?>">
                                        <?php 
                                            $s =mysqli_fetch_assoc(mysqli_query($connect,
                                                    "SELECT * FROM session WHERE is_deleted = 0 
                                                        ORDER BY id_session DESC "));
                                            $students = mysqli_query($connect,
                                                    "SELECT * FROM student,inscription
                                                    WHERE student.is_deleted = 0  AND inscription.is_deleted = 0
                                                    AND student.id_user = inscription.id_user 
                                                    AND inscription.id_session = ".$s['id_session']."
                                                    AND inscription.id_class =  ".unhash_str($_GET['group'])) ;
                                            
                                            while($student = mysqli_fetch_assoc($students) ){
                                        ?>
                                            <tr>
                                                <td><?php echo $student['fname_user']." ".$student['lname_user']; ?></td>
                                                <td><?php echo $student['cin_user']; ?> </td>
                                                <td><?php echo $student['cne_student']; ?></td>
                                                <?php
                                                    $semester = mysqli_fetch_assoc(
                                                            mysqli_query($connect,
                                                                    "SELECT * FROM semester WHERE is_deleted=0
                                                                    ORDER BY id_semester DESC ")
                                                        );
                                                    $id_semester = $semester['id_semester'] ;
                                                    $q = mysqli_query($connect,
                                                        "SELECT * FROM mark_subject WHERE is_deleted = 0
                                                        AND id_subject = ".unhash_str($_GET['subj'])." 
                                                        AND id_user = ".$student['id_user']."
                                                        AND id_semester = '$id_semester'
                                                        ") ;
                                                    $note = mysqli_fetch_assoc($q) ;
                                                ?>
                                                <td>
                                                    <input  
                                                        type="text" name="marks[]" 
                                                        class="border w-25 p-2
                                                            <?php
                                                                if(mysqli_num_rows($q)) echo 'border-light';
                                                                else echo 'border-info';
                                                            ?>
                                                        " 
                                                        value=" <?php
                                                                if(mysqli_num_rows($q)) echo $note['mark_subject'];
                                                            ?>"
                                                    >
                                                </td>
                                                <input type="hidden" name="users[]" value="<?php echo hash_str($student['id_user']); ?>">
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <input type="submit" 
                                            value="Save Change" class="btn bg-success text-light " 
                                            name="insert-mark"
                                    >
                                </div>
                            </div>
                            
                        </form>
                    <?php } ?>
                </div>
                 <?php } ?> 
            <?php } ?> 
        <?php } ?>  
    <?php }elseif(isset($_SESSION['student'])){ ?> 
        <?php  
            if($setting['allow_showing_marks'] == 1){
        ?>
            <div class="container mb-5">
                <div class="card">
                    <?php
                        $student = mysqli_fetch_assoc(
                            mysqli_query($connect,
                                "SELECT * FROM student 
                                WHERE is_deleted= 0
                                AND id_user = ".$_SESSION['student'])
                        ) ;
                    ?>
                    <div class="card-header">
                            <div class=" d-flex justify-content-center">
                                <img src="Files/<?php 
                                            if($student['image_user']!= NULL){
                                                echo "students/".$student['cin_user']."/".$student['image_user'];
                                            }else{
                                                echo "Custom/user.png";
                                            }
                                        ?>" style="width: 100px;height:100px;border-radius:50%">
                            </div>
                            <div class="mt-3 d-flex justify-content-center">
                                <p><?php echo strtoupper($student['lname_user'])." ".strtoupper($student['fname_user']) ?></p>
                            </div>
                            <span class="text-secondary d-flex justify-content-center">
                                <?php
                                    $current_session = mysqli_fetch_assoc(
                                        mysqli_query($connect,
                                                "SELECT * FROM session WHERE is_deleted = 0
                                                ORDER BY id_session DESC")
                                    );
                                    echo $current_session['date_start']."-".$current_session['date_end']
                                    ?>
                            </span>
                    </div>
                    <div class="card-body">
                        <div class="space-between">
                            <span>
                                    CNE
                            </span>
                            <span class="mt-2 text-primary">
                                    <?php echo $student['cne_student'] ?>
                            </span>
                        </div>
                        <div class="space-between">
                            <span>
                                    Branch
                            </span>
                            <span class="mt-2 text-primary">
                                    <?php 
                                        $my_class = mysqli_fetch_assoc(mysqli_query($connect , 
                                            "SELECT * FROM class,inscription,branch 
                                            WHERE class.is_deleted = 0 
                                            AND inscription.is_deleted = 0
                                            AND branch.is_deleted = 0
                                            AND inscription.id_class = class.id_class
                                            AND class.id_branch = branch.id_branch
                                            AND inscription.id_session = ".$current_session['id_session']."
                                            AND inscription.id_user = ".$_SESSION['student'])) ;
                                        if($my_class)
                                        echo $my_class['title_branch']
                                    ?>
                            </span>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-lg-8 col-md-10 col-sm-12">
                        <h5 class="text-center p-3"></h5>
                        <?php
                            $current_session = mysqli_fetch_assoc(
                                mysqli_query($connect,
                                        "SELECT * FROM session WHERE is_deleted = 0
                                        ORDER BY id_session DESC")
                            )['id_session'];
                            $semesters =mysqli_query($connect , 
                                                "SELECT * FROM semester 
                                                 WHERE is_deleted=0
                                                 AND id_session = '$current_session'
                                                "
                                        ) ;
                            $my_class = mysqli_fetch_assoc(mysqli_query($connect , 
                                            "SELECT * FROM class,inscription 
                                            WHERE class.is_deleted = 0 AND inscription.is_deleted = 0
                                            AND inscription.id_class = class.id_class
                                            AND inscription.id_session = '$current_session'
                                            AND inscription.id_user = ".$_SESSION['student'])) ;
                            if($my_class){
                                $my_class =  $my_class['id_class'] ;
                                $q = mysqli_query($connect , 
                                    "SELECT * FROM mark_subject ,subject 
                                    WHERE subject.is_deleted = 0 
                                    AND subject.id_subject = mark_subject.id_subject
                                    AND mark_subject.id_semester IN (
                                            SELECT id_semester FROM semester
                                            WHERE is_deleted=0
                                            AND id_session = '$current_session'
                                        )
                                    AND mark_subject.id_user = '$id'
                                    
                                    GROUP BY mark_subject.id_subject ") ;
                            }else die
 
                        ?>
                        <?php if($school_prop['type'] == 3){ ?>
                                    <?php
                                        $modules = mysqli_query($connect,
                                        "SELECT * FROM module,mark_module 
                                          WHERE module.is_deleted=0
                                          AND mark_module.is_deleted=0
                                          AND module.id_module=mark_module.id_module
                                          AND mark_module.id_semester IN (SELECT id_semester
                                                    FROM semester 
                                                    WHERE is_deleted=0
                                                    AND id_session = '$current_session')
                                          AND mark_module.id_user = ".$_SESSION['student']) ;

                                          while($module = mysqli_fetch_assoc($modules)){
                                             $id_module = $module['id_module'];
                                              $subjects = mysqli_query(
                                                  $connect,
                                                  "SELECT * FROM mark_subject ,subject 
                                                  WHERE subject.is_deleted = 0 
                                                  AND subject.id_subject = mark_subject.id_subject
                                                  AND subject.id_module= '$id_module'
                                                  AND mark_subject.id_user = ".$_SESSION['student']
                                              ) ;
                                              $mark_module = $module['mark_module'] ;
                                    ?>
                                    <div class="card border rounded-0 mb-2">
                                        <div class="p-3 space-between text-center  accord
                                                <?php
                                                    if($mark_module >= 10) echo "bg-success" ;
                                                    else echo "bg-danger"
                                                ?>
                                        ">
                                            <p><?php echo $module['title'] ?></p>
                                            <h3><?php echo $mark_module ?></h3>
                                        </div>
                                        <div class="collapsed">
                                            <?php while($subject=mysqli_fetch_assoc($subjects)){ ?>
                                                <div class="pr-5 pl-4 p-2 space-between">
                                                    <p><?php echo $subject['title_subject'] ?></p>
                                                    <h5><?php echo $subject['mark_subject'] ?></h5>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>


                                    <?php } ?>
                        <?php }else{ ?>
                            <div class="shadow ">
                                <table class="table table-responsive-sm ">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <?php if($school_prop['type']==2){ ?>
                                                <th>coefficient ( C )</th>
                                            <?php } ?>
                                            <?php while($semester = mysqli_fetch_assoc($semesters)){ ?>
                                                <th><?php echo $semester['title_semester'] ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($arr = mysqli_fetch_assoc($q)){ ?>
                                            <tr>
                                                <td><?php echo $arr['title_subject'] ; ?></td>
                                                <?php if($school_prop['type']==2){ ?>
                                                    <td><?php echo $arr['coefficient'] ; ?></td>
                                                <?php } ?>
                                                <?php
                                                    $semesters =mysqli_query($connect , 
                                                            "SELECT * FROM semester 
                                                            WHERE is_deleted=0
                                                            AND id_session = '$current_session'
                                                            "
                                                    ) ;
                                                ?>
                                                <?php while($semester = mysqli_fetch_assoc($semesters)){ ?>
                                                    <td>
                                                        
                                                        <?php
                                                            $mark = mysqli_fetch_assoc(
                                                                mysqli_query(
                                                                    $connect ,
                                                                    "SELECT * FROM mark_subject 
                                                                    WHERE is_deleted=0
                                                                    AND id_semester = ".$semester['id_semester']."
                                                                    AND id_user = ".$_SESSION['student']."
                                                                    AND id_subject = ".$arr['id_subject']
                                                                )
                                                            ) ;

                                                            echo $mark['mark_subject'];
                                                        ?>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                            
                                           
                                           
                                            
                                        <?php } ?>
                                    </tbody>
                                    <tfoot class="bg-secondary text-light">
                                        <tr>
                                            <td>M.semester</td>
                                            <?php if($school_prop['type']==2) echo "<td></td>" ?>
                                            
                                            <?php
                                                $semesters =mysqli_query($connect , 
                                                        "SELECT * FROM semester 
                                                        WHERE is_deleted=0
                                                        AND id_session = '$current_session'
                                                        "
                                                ) ;
                                            ?>
                                            <?php while($semester = mysqli_fetch_assoc($semesters)){ ?>
                                                <td>
                                                    <?php 
                                                        $semester_mark = mysqli_fetch_assoc(
                                                            mysqli_query(
                                                                $connect ,
                                                                "SELECT * FROM mark_semester
                                                                WHERE is_deleted=0
                                                                AND id_semester = ".$semester['id_semester']."
                                                                AND id_user = ".$_SESSION['student']
                                                            )
                                                        ) ;
                                                        echo $semester_mark['mark_semester']
                                                    ?>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        <?php } ?>

                        <?php
                            $mark_session = mysqli_query($connect ,
                                                "SELECT * FROM global_mark 
                                                 WHERE is_deleted=0 
                                                 AND id_session = '$current_session'
                                                 AND id_user = ".$_SESSION['student']
                            ) ;
                            if(mysqli_num_rows($mark_session)){
                        ?>
                            <div class="row"> 
                                <?php 
                                    $mark_session = mysqli_fetch_assoc($mark_session)['global_mark'] ;
                                ?>
                                <div class="p-3 text-info w-100 ">
                                   <b>Global Mark</b>
                                    <h3 class=" text-center ">
                                        <?php 
                                            echo $mark_session ;
                                        ?>
                                    </h3>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>

            </div>
        <?php }else{
             echo "<div class='card'>";
             echo "<h1 class='text-center mt-5 pt-5'> Ooops...! </h1>" ;
             echo "<h1 class='text-center mt-5 mb-5 pt-5'> Page not Availible Now </h1>" ;
             echo "</div>";
             } ?>
    <?php } ?>
</div>
        <?php require_once('includes/footer.php') ?>

    <?php }else{  header('location:/admin/login');} ?>

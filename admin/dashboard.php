
<?php
    define('TITLE','Home : SMS');
    define('SUB_TITLE','Dashboard');
    require_once('../connection.php') ;
    require_once('includes/functions.php') ;
    session_start();
    if(isset($_SESSION['user'])){
        $id = $_SESSION['user'] ;
        if(isset($_SESSION['manager'])) $query = "SELECT * FROM manager WHERE id_user = '$id' AND is_deleted = 0 ";
        if(isset($_SESSION['teacher'])) $query = "SELECT * FROM teacher WHERE id_user = '$id' AND is_deleted = 0  ";
        if(isset($_SESSION['student'])) $query = "SELECT * FROM student WHERE id_user = '$id' AND is_deleted = 0  ";
        $result = mysqli_query($connect , $query) ;
        $row = mysqli_fetch_assoc($result) ;
?>

        <?php require_once('includes/header.php') ?>
         

           <?php if(mysqli_num_rows($school)){ ?>
            <div class="dashboard mb-5">
                <?php if(isset($_SESSION['manager'])) { ?>
                    <div class="row ">
                        <?php if(mysqli_num_rows($students)){ ?>
                            <a href="students"  class="mb-2 text-light col-lg-3 col-md-4 col-sm-6">
                                <div class="card p-2 bg-primary">
                                    <h5>
                                        <?php 
                                            echo mysqli_num_rows(mysqli_query($connect , "SELECT * FROM student WHERE is_deleted = 0 ")); 
                                        ?>
                                    </h5>  
                                    <p>Students</p>                              
                                </div>
                            </a>
                        <?php } ?>

                        <?php if(mysqli_num_rows($teachers)){ ?>
                            <a href="teachers" class="mb-2 text-light col-lg-3 col-md-4 col-sm-6">
                                <div class="card p-2 bg-danger">
                                    <h5>
                                        <?php 
                                            echo mysqli_num_rows(mysqli_query($connect , "SELECT * FROM teacher WHERE is_deleted = 0 ")); 
                                        ?>
                                    </h5> 
                                    <p>Teachers</p>                               
                                </div>
                            </a>
                        <?php } ?>
                        <a href="managers" class="mb-2 text-light col-lg-3 col-md-4 col-sm-6">
                            <div class="card p-2 bg-success">
                                <h5>
                                    <?php 
                                        echo mysqli_num_rows(mysqli_query($connect , "SELECT * FROM manager WHERE is_deleted = 0 ")); 
                                    ?>
                                </h5>
                                <p>Managers</p>
                            </div>
                        </a>

                        <?php if(mysqli_num_rows($classes)){ ?>
                            <a href="classes" class="mb-2 text-light col-lg-3 col-md-4 col-sm-6">
                                <div class="card p-2 bg-warning">
                                    <h5>
                                        <?php 
                                            echo mysqli_num_rows(mysqli_query($connect , "SELECT * FROM class WHERE is_deleted = 0 ")); 
                                        ?>
                                    </h5>
                                    <p>Classes</p>
                                </div>
                            </a>
                        <?php } ?>
                        <?php if(mysqli_num_rows($branches)){ ?>
                            <a href="branches" class="mb-2 text-light col-lg-3 col-md-4 col-sm-6">
                                <div class="card p-2 bg-secondary">
                                    <h5>
                                        <?php 
                                            echo mysqli_num_rows(mysqli_query($connect , "SELECT * FROM branch WHERE is_deleted = 0 ")); 
                                        ?>
                                    </h5>
                                    <p>Branches</p>
                                </div>
                            </a>
                        <?php } ?>
                        <?php if(mysqli_num_rows($subjects)){ ?>
                            <a href="subjects" class="mb-2 text-light col-lg-3 col-md-4 col-sm-6">
                                <div class="card p-2 bg-success">
                                    <h5>
                                        <?php 
                                            echo mysqli_num_rows(mysqli_query($connect , "SELECT * FROM subject WHERE is_deleted = 0 ")); 
                                        ?>
                                    </h5>
                                    <p>Subjects</p>
                                </div>
                            </a>
                        <?php } ?>
                        <?php if(mysqli_num_rows($sessions)){ ?>
                            <a href="sessions" class="mb-2 text-light col-lg-3 col-md-4 col-sm-6">
                                <div class="card p-2 bg-info">
                                    <h5>
                                        <?php 
                                            echo mysqli_num_rows(mysqli_query($connect , "SELECT * FROM session WHERE is_deleted = 0  ")) ;
                                            
                                        ?>
                                    </h5>
                                    <p>Sessions</p>
                                </div>
                            </a>
                        <?php } ?>
                        <?php if(mysqli_num_rows($classrooms)){ ?>
                            <a href="classrooms" class="mb-2 text-light col-lg-3 col-md-4 col-sm-6">
                                <div class="card p-2 bg-dark">
                                    <h5>
                                        <?php 
                                            echo mysqli_num_rows(mysqli_query($connect , "SELECT * FROM classroom WHERE is_deleted = 0 ")); 
                                        ?>
                                    </h5>
                                    <p>classrooms</p>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                    <div class="row mt-4">
                        <?php  
                            $query_semester = mysqli_num_rows(
                                mysqli_query($connect,
                                        "SELECT * FROM semester WHERE is_deleted=0")
                            ) ;
                            if($query_semester){
                        ?>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Today's Statistics</div>
                                <div class="card-body">
                                    <div class="row space-between">
                                        <p>Seances</p>
                                        <p>
                                            <?php 
                                                $today = current_day(date('D'));
                                                $id_semester =mysqli_fetch_assoc(
                                                    mysqli_query($connect,
                                                            "SELECT * FROM semester 
                                                             WHERE is_deleted = 0
                                                             ORDER BY id_semester DESC")
                                                )['id_semester'];
                                                echo mysqli_num_rows(mysqli_query($connect,
                                                        "SELECT * FROM course
                                                         WHERE is_deleted = 0
                                                         AND id_semester = '$id_semester'
                                                         AND date_course = '$today'
                                                            
                                                        "))
                                            ?>
                                        </p>
                                    </div>
                                    <div class="row space-between">
                                        <p>Total Students</p>
                                        <p>
                                            <?php 
                                                $today = current_day(date('D'));
                                                $q = mysqli_query($connect , 
                                                    "SELECT id_class FROM course
                                                    WHERE is_deleted = 0
                                                    AND id_semester = '$id_semester'
                                                    AND date_course = '$today'
                                                  ") ;
                                                $id_sess = mysqli_fetch_assoc(
                                                    mysqli_query($connect , 
                                                    "SELECT id_session FROM session
                                                    WHERE is_deleted = 0
                                                    ORDER BY id_session DESC
                                                  ") 
                                                )['id_session'];
                                                $total = 0 ;
                                                while ($class = mysqli_fetch_assoc($q)) {
                                                    $id_class = $class['id_class'];
                                                    $inscript = mysqli_num_rows(
                                                        mysqli_query($connect , 
                                                            "SELECT * FROM inscription 
                                                             WHERE id_session = '$id_sess'
                                                             AND id_class = '$id_class'
                                                             AND is_deleted = 0")
                                                     );
                                                     $total += $inscript ;
                                                }
                                                echo $total
                                            ?>
                                        </p>
                                    </div>
                                    <div class="row space-between">
                                        <p>Absence Percentage</p>
                                        <p>
                                            <?php
                                                $date = date('Y-m-d');
                                                $abs = mysqli_num_rows(
                                                        mysqli_query($connect,
                                                            "SELECT * FROM  absence_course 
                                                            WHERE is_deleted = 0
                                                            AND is_absent = 1 
                                                            AND date_absence = '$date'")
                                                        );
                                                if($total)
                                                echo ($abs/$total)*100 ."%";
                                                else echo '-';
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <canvas id="mychart" width="250" height="150"></canvas>
                            <script src="/node_modules/chart.js/dist/chart.js"></script>
                            <script>
                                var classes = [] ;
                                var students = [] ;
                                <?php
                                    $id_session = mysqli_fetch_assoc(
                                        mysqli_query(
                                            $connect ,
                                            "SELECT * FROM session WHERE is_deleted=0
                                             ORDER BY id_session DESC"
                                        )
                                    )['id_session'] ;
                                    $query_classes = mysqli_query(
                                        $connect ,
                                        "SELECT * FROM class,inscription 
                                         WHERE class.is_deleted=0 AND inscription.is_deleted=0
                                         AND inscription.id_class=class.id_class
                                         AND inscription.id_session='$id_session' "
                                    ); 
                                    while($class = mysqli_fetch_assoc($query_classes)){
                                                $query_inscript = mysqli_num_rows(
                                                mysqli_query(
                                                    $connect ,
                                                    "SELECT * FROM inscription 
                                                    WHERE inscription.is_deleted=0
                                                    AND inscription.id_session='$id_session' 
                                                    AND inscription.id_class=".$class['id_class']
                                                )
                                        ); 
                                ?>
                                    classes.push("<?php echo $class['title_class']; ?>")
                                    students.push("<?php echo $query_inscript ; ?>")
                                <?php } ?>

                                var ct = document.getElementById('mychart').getContext('2d') ;
                                const mychart = new Chart(ct,{
                                    type : 'bar',
                                    data : {
                                        labels : classes ,
                                        datasets : [
                                            {
                                                label :' nombre d\'etudiants par classe ',
                                                data : students,
                                                backgroundColor : ['red','green','blue','yellow','dark','cyan'],
                                                hoverBackgroundColor : 'darkblue',
                                                borderWidth : 0 ,
                                                barThickness : 8
                                            }
                                        ]
                                    },
                                    options :{
                                        showAllTooltips : false ,
                                        tooltips :{
                                            custom : function(tooltip){
                                                if(!tooltip) return ;
                                                tooltip.displayColor = false
                                            }
                                        },
                                        scales : {
                                            y : {
                                                beginAtZero : true
                                            }
                                            
                                        }
                                    }
                                });
                            </script>
                        </div>

                        <?php } ?>
                    </div>
                <?php }elseif(isset($_SESSION['teacher'])) { 
                        $r = mysqli_query($connect, 
                                " SELECT * FROM class,course 
                                    WHERE class.is_deleted = 0  AND course.is_deleted = 0 
                                    AND class.id_class = course.id_class
                                    AND course.id_user = ".$_SESSION['teacher']." GROUP BY course.id_class" );
                    ?>
                        <div class="container mb-3 mt-3">
                            <div class="row space-between ">
                                <div  class="mb-2 text-light col-lg-3 col-md-4 col-sm-6">
                                    <div class="card p-2 bg-info">
                                        <h5>
                                            <?php 
                                                $id_sess = mysqli_fetch_assoc(mysqli_query($connect,
                                                    "SELECT id_session FROM session 
                                                        WHERE is_deleted = 0 
                                                        ORDER BY id_session DESC") )['id_session'];
                                                echo mysqli_num_rows(mysqli_query($connect , 
                                                    "SELECT * from course 
                                                    WHERE is_deleted = 0  
                                                    AND id_semester IN (SELECT id_semester FROM semester  WHERE id_session = '$id_sess')
                                                    AND id_user = ".$_SESSION['teacher']." group by id_class"
                                                )); 
                                            ?>
                                        </h5>
                                        <p>Classes</p>
                                    </div>
                                </div>
                                <div class="mb-2 text-light col-lg-3 col-md-4 col-sm-6">
                                    <div class="card p-2 bg-danger">
                                        <h5>
                                            <?php 
                                                echo mysqli_num_rows(mysqli_query($connect , 
                                                    "SELECT * FROM prof_subject, subject, course 
                                                    WHERE subject.is_deleted = 0 AND course.is_deleted = 0 
                                                    AND  subject.id_subject = prof_subject.id_subject
                                                    AND  subject.id_subject = course.id_subject
                                                    AND course.id_semester IN(SELECT id_semester FROM semester  WHERE id_session = '$id_sess')
                                                    AND  prof_subject.id_user = ".$_SESSION['teacher']."
                                                    GROUP BY course.id_subject")); 
                                            ?>
                                        </h5>
                                        <p>Subject</p>
                                    </div>
                                </div>
                                <div class="mb-2 text-light col-lg-3 col-md-4 col-sm-6">
                                    <div class="card p-2 bg-success">
                                        <h5>
                                            <?php 
                                            $r = mysqli_fetch_assoc(mysqli_query($connect , "SELECT * FROM session WHERE is_deleted =0 ORDER BY id_session DESC ")) ;
                                                echo $r['date_start']."-".$r['date_end']; 
                                            ?>
                                        </h5>
                                        <p>Current Session</p>
                                    </div>
                                </div>
                            </div>                            
                        </div>

                        <div class="row">
                            <div class="col">
                                <h4>Subjects I teach</h4>
                                <div class="p-2">
                                    <?php 
                                        $q = mysqli_query($connect , 
                                                "SELECT * FROM prof_subject, subject, course 
                                                WHERE subject.is_deleted = 0 AND course.is_deleted = 0 
                                                AND  subject.id_subject = prof_subject.id_subject
                                                AND  subject.id_subject = course.id_subject
                                                AND course.id_semester IN(SELECT id_semester FROM semester  WHERE id_session = '$id_sess')
                                                AND  prof_subject.id_user = ".$_SESSION['teacher']."
                                                GROUP BY course.id_subject");
                                        if(mysqli_num_rows($q) != 0){
                                          while($arr = mysqli_fetch_assoc($q)){
                                    ?>
                                            <div class="card mb-2">
                                                <p  class="p-2 mb-0"><?php echo $arr['title_subject'] ?></p>
                                            </div>    
                                           <?php } ?>
                                        <?php }else{ ?>
                                            <div class="card p-2">
                                                <p>
                                                    you dont have any subject yet
                                                </p>
                                            </div>
                                        <?php } ?>
                                </div>
                            </div>
                            <div class="col">
                                <h4>My Classes</h4>
                                <div class="p-2">
                                    <?php 
                                        $id_sess = mysqli_fetch_assoc(mysqli_query($connect,
                                                "SELECT id_session FROM session 
                                                WHERE is_deleted = 0 
                                                ORDER BY id_session DESC") )['id_session'];
                                        if($school_prop['type']==3){
                                            $semester =  mysqli_query($connect,
                                                    "SELECT id_semester
                                                    FROM semester 
                                                    WHERE is_deleted=0 
                                                    AND id_session = '$id_sess'
                                                    ORDER BY id_semester DESC");
                                        }else{
                                            $semester =  mysqli_query($connect,
                                                    "SELECT id_semester
                                                    FROM semester 
                                                    WHERE id_session = '$id_sess'");
                                        }
                                        if(mysqli_num_rows($semester) != 0){

                                            $id_semester = mysqli_fetch_assoc($semester)['id_semester'];
                                            $r = mysqli_query($connect, 
                                                    "SELECT * FROM class,course 
                                                    WHERE class.is_deleted = 0  AND course.is_deleted = 0
                                                    AND class.id_class = course.id_class
                                                    AND course.id_semester = '$id_semester'
                                                    AND course.id_user = ".$_SESSION['teacher']." GROUP BY course.id_class" );
                                        
                                            while($arr = mysqli_fetch_assoc($r)){                    
                                    ?>
                                        <div class="card mb-2">
                                            <a href="/admin/classes?group=<?php echo hash_str($arr['id_class']); ?>" class="p-2"><?php echo $arr['title_class'] ?></a>
                                        </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>   
                        
                <?php }elseif(isset($_SESSION['student'])){ ?>
                        <div class="row mb-5">
                            <div class="col">
                                <h5 class="text-dark m-3">today's Courses </h5>
                                <div class="row container">
                                    <?php 
                                        $semester = mysqli_fetch_assoc(
                                            mysqli_query($connect,
                                                "SELECT * FROM semester
                                                WHERE is_deleted = 0
                                                ORDER BY id_semester DESC")
                                        )['id_semester'] ;
                                        $session = mysqli_fetch_assoc(
                                            mysqli_query($connect,
                                                "SELECT * FROM session
                                                WHERE is_deleted = 0
                                                ORDER BY id_session DESC")
                                        )['id_session'] ;
                                        $class = mysqli_fetch_assoc(
                                            mysqli_query($connect,
                                                "SELECT * FROM inscription
                                                WHERE is_deleted = 0
                                                AND id_session = '$session'
                                                AND id_user = ".$_SESSION['student']
                                                )
                                        );
                                        if($class) $class = $class['id_class']  ;
                                        else die ;
                                        $today = current_day(date('D'));
                                        $q = mysqli_query($connect,
                                                "SELECT * FROM course, subject, classroom, teacher
                                                WHERE course.is_deleted = 0 
                                                AND subject.is_deleted = 0
                                                AND classroom.is_deleted = 0
                                                AND teacher.is_deleted = 0
                                                AND course.id_semester = '$semester'
                                                AND date_course ='$today' 
                                                AND course.id_class = '$class'
                                                AND subject.id_subject = course.id_subject
                                                AND classroom.id_classroom = course.id_classroom
                                                AND teacher.id_user = course.id_user");
                                        
                                        if(mysqli_num_rows($q)){
                                        
                                            while ($course = mysqli_fetch_assoc($q)) {
                                    ?>
                                        <div class="col-sm-6 col-md-4 col-lg-3">        
                                            <div class="card mb-3">
                                                <div class="card-header"><?php echo $course['title_subject'] ?></div>
                                                <div class="card-body">
                                                    <p class="h6 text-secondary"><?php echo $course['fname_user']." ".$course['lname_user'] ?></p>
                                                    <p class="h6 text-secondary"><?php echo date('D-m-y') ?></p>
                                                    <p class="h6 text-secondary"><?php echo get_hour($course['time_course']) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                      <?php } ?>
                                    <?php }else{ ?>
                                        <div class="col">
                                            <div class='card p-2'>No courses today</div>
                                        </div>
                                            
                                    <?php  } ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <h5 class="text-dark m-3">Subjects <hr></h5>
                                <div class="subject-container">
                                <?php
                                    $id_session = mysqli_fetch_assoc(
                                        mysqli_query(
                                            $connect ,
                                            "SELECT * FROM session WHERE is_deleted=0
                                            ORDER BY id_session DESC"
                                        )
                                    )['id_session'] ;
                                    $my_classe = mysqli_query(
                                        $connect ,
                                        "SELECT * FROM class,inscription 
                                        WHERE class.is_deleted=0 AND inscription.is_deleted=0
                                        AND inscription.id_class=class.id_class
                                        AND inscription.id_session='$id_session'
                                        AND inscription.id_user = ".$_SESSION['student'] );
                                    if(mysqli_num_rows($my_classe))
                                        $id_class = mysqli_fetch_assoc( $my_classe)['id_class'] ;
                                    else die ;

                                    $subjects = mysqli_query(
                                        $connect,
                                        "SELECT * FROM course,subject
                                        WHERE course.is_deleted=0 AND subject.is_deleted=0
                                        AND course.id_subject = subject.id_subject
                                        AND course.id_class = '$id_class'
                                        AND id_semester IN (
                                            SELECT id_semester FROM semester 
                                            WHERE is_deleted=0
                                            AND id_session = '$id_session'
                                        )
                                        GROUP BY subject.id_subject
                                        "
                                    ) ;
                                    while($subject = mysqli_fetch_assoc($subjects)){
                                        $teacher = $subject['id_user'] ;
                                        $id_subject = $subject['id_subject'] ;
                                        $file = mysqli_fetch_assoc(
                                            mysqli_query(
                                                $connect,
                                                "SELECT * FROM course_file WHERE is_deleted=0
                                                AND id_user='$teacher' 
                                                AND id_subject = '$id_subject' "
                                            )
                                        )
                                ?>
                                
                                    <div class="subject-card">
                                        <a href="subjects?id=<?php echo $subject['id_subject'] ?>">
                                            <img src="/admin/Files/Custom/test.jpg" alt=""><br>
                                            <p><?php echo $subject['title_subject'] ?></p>
                                        </a>
                                    </div>
                                <?php } ?>
                                    <div class="subject-card-0"></div>
                                </div>
                            </div>
                        </div>
                <?php } ?>
            </div>
            <?php } ?>

        <?php require_once('includes/footer.php') ?>

    <?php }else{  header('location:/admin/login');} ?>








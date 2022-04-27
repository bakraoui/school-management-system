<?php
define('TITLE','Classes : SMS');
define('SUB_TITLE','Classes');
    require_once('../connection.php') ;
    require_once('includes/functions.php') ;
    session_start();
        if(isset($_SESSION['user']) && isset($_SESSION['manager'])){
            $id = $_SESSION['user'] ;
            $query = "SELECT * FROM manager WHERE id_user = '$id' AND is_deleted = 0";
            $result = mysqli_query($connect , $query) ;
            $row = mysqli_fetch_assoc($result) ;
    ?>

        <?php require_once('includes/header.php') ?>

        <div class="container mb-4">
            <div class="row d-flex justify-content-space-between"> 
                <div class="col d-flex ">
                    <div class="btn border mr-1">
                        <a href="/admin/classes" class="p-2 d-block">All</a>
                    </div>
                    <div class="btn border">
                        <a href="/admin/classes?add" class="p-2 d-block" >New</a>
                    </div>
                </div>    

            </div>
        </div>

        <div class="container mb-5">
            <?php  if(isset($_GET['add'])){ ?>
                <div class="add">
                    <h4>New class</h4>
                    <div class="card p-3">
                        <div class="d-flex justify-content-center">
                            <form action="includes/insert.php" method="post" enctype="multipart/form-data" class=" col-lg-8 col-md-10 col-sm-12">
                                
                                <div class="form-group">
                                    <label for="class">class <span class="text-danger">*</span> </label>
                                    <input 
                                            type="text" 
                                            id="class" 
                                            name="class" 
                                            class="form-control"
                                            value="<?php if(isset($_SESSION['title'])) echo $_SESSION['title'] ?>"
                                            required>
                                </div>
                                <div class="form-group">
                                    <label for="branch">Branch <span class="text-danger">*</span> </label>
                                    <select name="branch" id="branch" class="form-control" required>
                                        <option></option>
                                        <?php 
                                            $query_branch = "SELECT * FROM branch WHERE is_deleted = 0";
                                            $result_branch = mysqli_query($connect , $query_branch);
                                            while($arr_branch = mysqli_fetch_assoc($result_branch)){
                                        ?>
                                        <option value="<?php echo hash_str($arr_branch['id_branch']); ?>"> <?php echo $arr_branch['title_branch']; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <input type="submit" value="Add class" name="insert-class" class="form-control bg-primary text-light">
                            
                            </form>                             
                        </div>
                    </div>
                </div>           
            <?php }elseif(isset($_GET['class']) && !empty($_GET['class'])
                            && isset($_GET['edit']) && empty($_GET['edit'])){
                        $id_class =  ($_GET['class']);
                        $query_class = "SELECT * FROM  class WHERE id_class = '$id_class' AND is_deleted = 0";
                        $result_class = mysqli_query($connect , $query_class); 
                        if(mysqli_num_rows($result_class) != 0){ 
                         $arr_class = mysqli_fetch_assoc($result_class) ;                
                ?>
                            <div class="add">
                                <h4>Update class</h4>
                                <div class="card p-3">
                                    <div class="d-flex justify-content-center">
                                        <form action="includes/update" method="post" class=" col-lg-6 col-md-8 col-sm-12">                          
                                            <div class="form-group">
                                                <label for="class">class <span class="text-danger">*</span> </label>
                                                <input type="text" id="class" name="class" class="form-control" 
                                                        value="<?php echo $arr_class['title_class']; ?>"
                                                        required
                                                    >
                                            </div>
                                            <div class="form-group">
                                                <label for="branch">Branch <span class="text-danger">*</span> </label>
                                                <select name="branch" id="branch" class="form-control" required>
                                                    <option></option>
                                                    <?php 
                                                        $query_branch = "SELECT * FROM branch WHERE is_deleted = 0";
                                                        $result_branch = mysqli_query($connect , $query_branch);
                                                        while($arr_branch = mysqli_fetch_assoc($result_branch)){
                                                    ?>
                                                    <option value="<?php echo hash_str($arr_branch['id_branch']); ?>"
                                                            <?php if($arr_branch['id_branch']== $arr_class['id_branch'] ) echo "selected"; ?>
                                                        > <?php echo $arr_branch['title_branch']; ?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <input type="hidden" name="cl" value="<?php echo hash_str($arr_class['id_class']); ?>">
                                            <input type="submit" value="Update class" name="update-class" class="form-control bg-primary text-light">
                                            
                                        </form>                                         
                                    </div>
                                </div>
                            </div>
                        <?php }else {
                            echo "<script> 
                                        window.location.href='classes'
                                  </script>" ;
                            
                        
                                }  ?>
            <?php }else{ ?>
                        <?php   
                            if(isset($_GET['search']) && !empty($_GET['search'])){
                                $search = $_GET['search'] ;
                                $q = "SELECT * FROM branch WHERE  title_branch LIKE '%$search%' AND is_deleted = 0  ";
                                $r = mysqli_query($connect , $q);
                                $arr = mysqli_fetch_assoc($r) ;
                                if(mysqli_num_rows($r) > 0 )
                                {
                                    $i = $arr['id_branch'];
                                    $query = "SELECT * FROM class
                                                WHERE is_deleted = 0 AND title_class like '%$search%' 
                                                OR id_branch = '$i' AND is_deleted = 0  " ;
                                }else{
                                    $query = "SELECT * FROM class
                                                WHERE title_class like '%$search%'  AND is_deleted = 0 " ;
                                }
                            }else{
                                $query = "SELECT * FROM class WHERE is_deleted = 0 " ;
                            }
                            $result = mysqli_query($connect , $query) ;
                            $total = mysqli_num_rows($result) ;
                            $total_lines = mysqli_num_rows($result) ;
                            $lines_page = 10 ;
                            $nbr_pages = ceil($total_lines/$lines_page) ;
                        ?>
                        <div class="row">
                            <div class="col-md-6 col-sm-4">
                                <p> Total : <b><?php echo $total ?></b>
                                </p>
                            </div>
                            <div class="col-md-6 col-sm-8">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <input type="search" name="search" class="form-control" placeholder="search">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="overflow-x">
                            <table cellspacing="0" class="table table-striped shadow">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>class</th>
                                        <th>Branch</th>
                                        <th>Plus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php  
                                    if(!isset($_GET['page'])){
                                        $cp =0 ;
                                        $i =1 ;
                                        while($tab = mysqli_fetch_assoc($result) ){
                                                if($cp <  $lines_page ){
                                                ?>
                                                <tr>
                                                    <td><?php echo $i ; $i++ ; ?></td>
                                                    <td><?php echo $tab['title_class'] ; ?></td>
                                                    <?php 
                                                        $q = "SELECT * from branch where  is_deleted = 0 AND id_branch = ".$tab['id_branch'] ;
                                                        $r = mysqli_query($connect , $q);
                                                        $arr =mysqli_fetch_assoc($r) ;
                                                    ?>
                                                    <td><?php echo $arr['title_branch'] ; ?></td>
                                                    <td> 
                                                        <table class="child-table"> 
                                                            <tr>
                                                                <td>
                                                                    <a href="classes?class=<?php echo $tab['id_class']; ?>&edit" class="btn btn-info"><i class="fa fa-refresh"></i></a>
                                                                </td>
                                                                <td>
                                                                    <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                                    <div class="permission">
                                                                        <div class="permission-content">
                                                                            <p>Sure you want to delete That ?</p>
                                                                            <div class="options">
                                                                                <form action="includes/delete" method="post">
                                                                                    <input type="hidden" name="cl" value="<?php echo hash_str($tab['id_class']); ?>">
                                                                                    <input type="submit" class="btn btn-success" value="Yes">
                                                                                </form>
                                                                                <a   class="btn btn-warning close-btn" style="position: unset; cursor:pointer">No</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            <?php }else{ break ; }
                                                $cp++ ;
                                        }

                                    }else{
                                        $num_pg = $_GET['page'] ;
                                        $cp = 0 ;
                                        $i =1 ;
                                        while($tab = mysqli_fetch_assoc($result)){
                                            if($cp >= $num_pg*$lines_page) {$cp++;continue ; }
                                            elseif ($cp < ($num_pg-1)*$lines_page) {$cp++;continue ; }
                                            else{$cp++;
                                            ?>
                                                <tr>
                                                    <td><?php echo $i ; $i++ ; ?></td>
                                                    <td><?php echo $tab['title_class'] ; ?></td>
                                                    <?php 
                                                        $q = "SELECT * from branch where  is_deleted = 0 AND id_branch = ".$tab['id_branch'] ;
                                                        $r = mysqli_query($connect , $q);
                                                        $arr =mysqli_fetch_assoc($r) ;
                                                    ?>
                                                    <td><?php echo $arr['title_branch'] ; ?></td>
                                                    <td> 
                                                        <table class="child-table"> 
                                                            <tr>
                                                                <td>
                                                                    <a href="classes?class=<?php echo $tab['id_class']; ?>&edit" class="btn btn-info"><i class="fa fa-refresh"></i></a>
                                                                </td>
                                                                <td>
                                                                    <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                                    <div class="permission">
                                                                        <div class="permission-content">
                                                                            <p>Sure you want to delete That ?</p>
                                                                            <div class="options">
                                                                                <form action="includes/delete" method="post">
                                                                                    <input type="hidden" name="cl" value="<?php echo hash_str($tab['id_class']); ?>">
                                                                                    <input type="submit" class="btn btn-success" value="Yes">
                                                                                </form>
                                                                                <a   class="btn btn-warning close-btn" style="position: unset; cursor:pointer">No</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                <?php       }
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>                            
                        </div>

                <?php 
                    if( $nbr_pages > 1 ){
                        if(isset($_GET['page'])) $active_page = $_GET['page'] ;
                        else $active_page = 1
                ?>
                    <nav  aria-label="Page pagination example">
                        <ul class="pagination">
                            <li class="page-item  <?php if( $active_page == 1) echo "disabled" ?>">
                                <a href="/admin/classes?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo previous_page($active_page); ?>" class="page-link" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item  <?php if($nbr_pages < $active_page-1 || $active_page == 1) echo "disabled" ?>">
                                <a href="/admin/classes?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page-1; ?>" class="page-link">
                                    <?php echo $active_page-1 ;?>
                                </a>
                            </li>
                            <li class="page-item active <?php if($nbr_pages < $active_page) echo "disabled" ?>">
                                <a href="/admin/classes?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page ; ?>" class="page-link">
                                    <?php echo $active_page;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+1) echo "disabled" ?>">
                                <a href="/admin/classes?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page+1 ; ?>" class="page-link">
                                    <?php echo $active_page+1;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+2) echo "disabled" ?>">
                                <a href="/admin/classes?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo next_page($active_page); ?>" class="page-link" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php } ?>
            <?php } ?>
        </div>

        <?php require_once('includes/footer.php') ?>

    <?php }elseif(isset($_SESSION['user']) && isset($_SESSION['teacher'])){
        $id = $_SESSION['user'] ;
        $query = "SELECT * FROM teacher WHERE id_user = '$id' AND is_deleted = 0 ";
        $result = mysqli_query($connect , $query) ;
        $row = mysqli_fetch_assoc($result) ;
     ?>
   
        <?php require_once('includes/header.php') ; ?>

        <?php $r = mysqli_query($connect, 
            " SELECT * FROM class,course 
                WHERE class.is_deleted = 0  AND course.is_deleted = 0 
                AND class.id_class = course.id_class
                AND course.id_user = ".$_SESSION['teacher']." GROUP BY course.id_class" );
        ?>
        <div class="container mb-5 "> 


            <?php if(isset($_GET['group']) && !empty($_GET['group']) 
                    && isset($_GET['subj']) && !empty($_GET['subj'])  ){ ?>
                <?php 
                    while($ar = mysqli_fetch_assoc($r)){
                        if(unhash_str($_GET['group']) == $ar['id_class'] ){
                ?>
                        
                        <div class="space-between p-2 border border-warning rounded mb-3">
                            <div class="d-flex">
                                <?php 
                                    $group_arr = mysqli_fetch_assoc(mysqli_query($connect,
                                    "SELECT * FROM class, branch 
                                        WHERE class.id_class = ".unhash_str($_GET['group'])." 
                                        AND class.id_branch = branch.id_branch 
                                        AND class.is_deleted = 0  AND branch.is_deleted = 0
                                        ")) ;
                                ?>
                                <div class=" border border-warning border-top-0 border-bottom-0 border-left-0">
                                    <span class="mr-3"><?php echo $group_arr['title_class'] ?></span>
                                </div>
                                <div class="border border-warning border-top-0 border-bottom-0 border-left-0">
                                     <span class="mr-3 ml-3"><?php echo date("d"."-"."m"."-"."Y") ?></span>
                                </div>
                            </div>
                            <p>
                                Total Absences : 
                                <strong>
                                    <?php
                                        $date = date('Y')."-".date('m')."-".date('d') ;
                                        echo mysqli_num_rows(mysqli_query($connect,
                                        "SELECT * FROM absence_course 
                                        WHERE id_subject =  ".unhash_str($_GET['subj'])."
                                        AND date_absence = '$date'"));
                                    ?>
                                </strong>
                            </p>
                        </div>
                        <div class="overflow-x shadow">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th> CIN</th>
                                        <th>CNE</th>
                                        <th>Absence</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $s =mysqli_fetch_assoc(mysqli_query($connect,
                                                "SELECT * FROM session WHERE is_deleted = 0  ORDER BY id_session "));
                                        $r = mysqli_query($connect,
                                                "SELECT * FROM student,inscription
                                                WHERE student.is_deleted = 0  AND inscription.is_deleted = 0 
                                                AND student.id_user = inscription.id_user 
                                                AND inscription.id_session = ".$s['id_session']."
                                                AND inscription.id_class =  ".unhash_str($_GET['group'])) ;

                                        while($arr = mysqli_fetch_assoc($r) ){
                                    ?>
                                        <tr>
                                            <td><?php echo $arr['fname_user']." ".$arr['lname_user']; ?></td>
                                            <td> <?php echo $arr['cin_user']; ?></td>
                                            <td><?php echo $arr['cne_student']; ?></td>
                                            <td>
                                                <?php
                                                    $student =  $arr['id_user'];
                                                    $subject = unhash_str($_GET['subj'])  ;
                                                    $group = unhash_str($_GET['group']) ;
                                                    $date = date('Y')."-".date('m')."-".date('d') ;
                                                    $n_r = mysqli_num_rows(mysqli_query($connect,
                                                            "SELECT * FROM absence_course
                                                            WHERE id_subject = '$subject'
                                                            AND id_user = '$student' 
                                                            AND date_absence = '$date' ")) ;

                                                ?>
                                                <form action="/admin/includes/<?php 
                                                    if($n_r == 0 ) echo "insert";
                                                    else echo "delete";
                                                
                                                ?>" method="post">
                                                    <input type="hidden" name="std" value="<?php echo hash_str($arr['id_user']); ?>">
                                                    <input type="hidden" name="sbj" value="<?php echo $_GET['subj']; ?>">
                                                    <input type="hidden" name="grp" value="<?php echo $_GET['group']; ?>">
                                                    <input type="submit" name="<?php 
                                                        if($n_r == 0 ) echo "insert-abs";
                                                        else echo "delete-abs"; 

                                                        ?>" value="&check;" class="check-abs <?php 
                                                        if($n_r == 0 ) echo "btn  ";
                                                        else echo "btn btn-success "; 

                                                        ?>">
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php }elseif(isset($_GET['group']) ){?>
                
                <?php 
                    $group = unhash_str($_GET['group']);
                    while($ar = mysqli_fetch_assoc($r)){
                        if($group == $ar['id_class'] ){
                ?>
                    <div class="container">
                        <?php 
                            $current_semester = mysqli_fetch_assoc(
                                mysqli_query(
                                    $connect,
                                    "SELECT * FROM  semester WHERE is_deleted=0
                                     ORDER BY id_semester DESC "
                                )
                            )['id_semester']; 
                            if($school_prop['type']==3){
                                $r = mysqli_query($connect,"SELECT * FROM course,subject
                                    WHERE subject.is_deleted = 0  AND course.is_deleted = 0
                                    AND course.id_class = ".$group."
                                    AND course.id_user = ".$_SESSION['teacher']."
                                    AND course.id_semester = '$current_semester'
                                    AND course.id_subject = subject.id_subject GROUP BY course.id_subject"); 
                            }else{
                                $r = mysqli_query($connect,"SELECT * FROM course,subject
                                        WHERE subject.is_deleted = 0  AND course.is_deleted = 0
                                        AND course.id_class = ".$group."
                                        AND course.id_user = ".$_SESSION['teacher']."
                                        AND course.id_subject = subject.id_subject GROUP BY course.id_subject"); 
                            }
                        
                        ?>
                            <div class=" mb-4 border border-warning p-2 rounded">
                                <div class="row space-between">
                                    <div class="ml-3 mb-2">
                                        <div class="d-flex">
                                            <?php 
                                                $group_arr = mysqli_fetch_assoc(mysqli_query($connect,
                                                "SELECT * FROM class, branch 
                                                    WHERE class.id_class = ".$group." 
                                                    AND class.id_branch = branch.id_branch 
                                                    ")) ;
                                            ?>
                                            <div class="pr-2">
                                                <span><?php echo $group_arr['title_class'] ?></span>
                                            </div>
                                            <div class="pl-2">
                                                <?php echo date("d"."-"."m"."-"."Y") ?>
                                            </div>
                                        </div>                                    
                                    </div>
                                    <div class="ml-3">
                                        <div class="options">
                                            <button class="btn btn-danger popup-modal" id="addTest">Add Test</button>
                                            <div class="modal">
                                                <div class="modal-content">
                                                    <button class="close-btn"><span><i class="fa fa-close"></i></span></button>
                                                    <form class="form" action="/admin/includes/insert" method="post" enctype="multipart/form-data" class=" col-lg-6 col-md-8 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="sub">Subject <span class="text-danger">*</span> </label>
                                                            <select name="sub" class="form-control" required>
                                                                <option value=""></option>
                                                                <?php while($ar = mysqli_fetch_assoc($r)){ ?>
                                                                    <option value="<?php echo hash_str($ar['id_subject']); ?>"><?php echo $ar['title_subject']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="start"> Start <span class="text-danger">*</span> </label>
                                                            <input type="date" name="start" id="" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="end"> End <span class="text-danger">*</span> </label>
                                                            <input type="date" name="end" id="" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="test">Upload test <span class="text-danger">*</span> </label>
                                                            <input type="file" name="test"  class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="test">Thumbnail</label>
                                                            <input type="file" name="thumbnail"  class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="description">Optional Description</label>
                                                            <textarea  name="description" id="description"  class="form-control"></textarea>

                                                        </div>
                                                        <input type="hidden" name="group" value="<?php echo $_GET['group']; ?>">
                                                        <input type="hidden" name="user" value="<?php echo hash_str($_SESSION['teacher']); ?>">
                                                        <input type="submit" name="insert-exam" value="Add Test" class="form-control bg-primary text-light">
                                                    </form>                                            
                                                </div>

                                            </div>
                                            <?php 
                                                $current_semester = mysqli_fetch_assoc(
                                                    mysqli_query(
                                                        $connect,
                                                        "SELECT * FROM  semester WHERE is_deleted=0
                                                         ORDER BY id_semester DESC "
                                                    )
                                                )['id_semester']; 
                                                if($school_prop['type']==3){
                                                    $r = mysqli_query($connect,"SELECT * FROM course,subject
                                                        WHERE subject.is_deleted = 0  AND course.is_deleted = 0
                                                        AND course.id_class = ".$group."
                                                        AND course.id_user = ".$_SESSION['teacher']."
                                                        AND course.id_semester = '$current_semester'
                                                        AND course.id_subject = subject.id_subject GROUP BY course.id_subject"); 
                                                }else{
                                                    $r = mysqli_query($connect,"SELECT * FROM course,subject
                                                            WHERE subject.is_deleted = 0  AND course.is_deleted = 0
                                                            AND course.id_class = ".$group."
                                                            AND course.id_user = ".$_SESSION['teacher']."
                                                            AND course.id_subject = subject.id_subject GROUP BY course.id_subject"); 
                                                }
                                                $current_day = current_day(date('D'));
                                                $id_semester = mysqli_fetch_assoc(mysqli_query($connect,
                                                            "SELECT id_semester FROM semester
                                                            WHERE is_deleted = 0
                                                            ORDER BY id_semester DESC"))['id_semester'] ;
                                                $abs = mysqli_query($connect,"SELECT * FROM course
                                                        WHERE  course.is_deleted = 0
                                                        AND id_semester = '$id_semester'
                                                        AND id_class = '$group'
                                                        AND date_course = '$current_day'
                                                        AND id_user = ".$_SESSION['teacher']);
                                                if(mysqli_num_rows($abs) != 0){    
                                            ?>
                                            
                                                    <button class="btn btn-warning popup-modal" id="NoteAbsence">Note Absence</button>
                                                    <div class="modal">
                                                        <div class="modal-content">
                                                            <button class="close-btn"><span><i class="fa fa-close"></i></span></button>
                                                            <form class="absence" action="/admin/includes/insert" method="post" class=" col-lg-6 col-md-8 col-sm-12"> 
                                                                <div class="form-group">
                                                                    <label for="subj">Subject</label>
                                                                    <select name="subj" class="form-control">
                                                                        <?php while($ar = mysqli_fetch_assoc($r)){ ?>
                                                                            <option value="<?php echo hash_str($ar['id_subject']) ?>"><?php echo $ar['title_subject'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <input type="hidden" name="grp" value="<?php echo hash_str($group); ?>">
                                                                <input type="submit" name="goto-absence" value="Next" class="form-control bg-primary text-light">
                                                            </form>                                            
                                                        </div>

                                                    </div>
                                                <?php } ?>
                                            <?php 
                                                $current_semester = mysqli_fetch_assoc(
                                                    mysqli_query(
                                                        $connect,
                                                        "SELECT * FROM  semester WHERE is_deleted=0
                                                         ORDER BY id_semester DESC "
                                                    )
                                                )['id_semester']; 
                                                if($school_prop['type']==3){
                                                    $r = mysqli_query($connect,"SELECT * FROM course,subject
                                                        WHERE subject.is_deleted = 0  AND course.is_deleted = 0
                                                        AND course.id_class = ".$group."
                                                        AND course.id_user = ".$_SESSION['teacher']."
                                                        AND course.id_semester = '$current_semester'
                                                        AND course.id_subject = subject.id_subject GROUP BY course.id_subject"); 
                                                }else{
                                                    $r = mysqli_query($connect,"SELECT * FROM course,subject
                                                            WHERE subject.is_deleted = 0  AND course.is_deleted = 0
                                                            AND course.id_class = ".$group."
                                                            AND course.id_user = ".$_SESSION['teacher']."
                                                            AND course.id_subject = subject.id_subject GROUP BY course.id_subject"); 
                                                }
                                                $set = mysqli_fetch_assoc(mysqli_query($connect , 
                                                            "SELECT * FROM setting"))['allow_insert_marks'] ;
                                                if($set){
                                            ?>
                                                    <button class="btn btn-success popup-modal" id="NoteAbsence">Marks</button>
                                                    <div class="modal">
                                                        <div class="modal-content">
                                                            <button class="close-btn"><span><i class="fa fa-close"></i></span></button>
                                                            <form class="absence" action="/admin/includes/insert" method="post" >
                                                                <div class="form-group">
                                                                    <label for="subj">Subject</label>
                                                                    <select name="subj" class="form-control">
                                                                        <?php while($ar = mysqli_fetch_assoc($r)){ ?>
                                                                            <option value="<?php echo hash_str($ar['id_subject']) ?>"><?php echo $ar['title_subject'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <input type="hidden" name="grp" value="<?php echo $_GET['group']; ?>">
                                                                <input type="submit" value="next" name="goto-marks"class="form-control bg-primary text-light">
                                                            </form>
                                                        </div>

                                                    </div>
                                                <?php } ?>
                                        </div>                                    
                                    </div>                                    
                                </div>
                            </div>
                            <div class="overflow-x shadow">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Full Name</th>
                                            <th>CIN</th>
                                            <th>CNE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $s =mysqli_fetch_assoc(mysqli_query($connect,
                                                    "SELECT * FROM session WHERE is_deleted = 0   ORDER BY id_session DESC "));
                                            $r = mysqli_query($connect,
                                                    "SELECT * FROM student,inscription
                                                    WHERE student.is_deleted = 0  AND inscription.is_deleted = 0
                                                    AND student.id_user = inscription.id_user 
                                                    AND inscription.id_session = ".$s['id_session']."
                                                    AND inscription.id_class =  ".$group ) ;
                                            $i = 1 ;
                                            while($arr = mysqli_fetch_assoc($r) ){
                                        ?>
                                            <tr>
                                                <td><?php echo $i ; $i++ ; ?></td>
                                                <td><?php echo $arr['fname_user']." ".$arr['lname_user']; ?></td>
                                                <td><?php echo $arr['cin_user']; ?></td>
                                                <td><?php echo $arr['cne_student']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    <?php } ?>
                <?php } ?>
            <?php }else{ ?>
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
            <?php } ?>
        </div>
        <?php require_once('includes/footer.php') ; ?>
    
    
    
    
    
    
    
    
    
    <?php }else{  header('location:/admin/login');} ?>

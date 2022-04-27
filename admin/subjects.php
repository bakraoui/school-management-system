<?php
define('TITLE','Subjects : SMS');
define('SUB_TITLE','Subjects');
    require_once('../connection.php') ;
    include('includes/functions.php');
    session_start();
    if(isset($_SESSION['user']) ){
        if(isset($_SESSION['manager'])){
            $id = $_SESSION['user'] ;
            $query = "SELECT * FROM manager WHERE id_user = '$id' AND is_deleted = 0";
        }elseif(isset($_SESSION['teacher'])){
            $id = $_SESSION['user'] ;
            $query = "SELECT * FROM teacher WHERE id_user = '$id' AND is_deleted = 0";
        }elseif(isset($_SESSION['student'])){
            $id = $_SESSION['user'] ;
            $query = "SELECT * FROM student WHERE id_user = '$id' AND is_deleted = 0";
        }
        $result = mysqli_query($connect , $query) ;
        $row = mysqli_fetch_assoc($result) ;
?>

        <?php require_once('includes/header.php') ?>
        
    <?php if(isset($_SESSION['manager'])){ ?>
        <div class="mb-4">
            <div class="row d-flex justify-content-space-between"> 
                <div class="col d-flex ">
                    <div class="border btn mr-1">
                        <a href="/admin/subjects" class="p-2 d-block" >All</a>
                    </div>
                    <div class="border btn">
                        <a href="/admin/subjects?add" class="p-2 d-block" >New</a>
                    </div>
                </div> 
            </div>
        </div>
    <?php } ?>

        <div class="container mb-5">
            <?php if(isset($_SESSION['manager'])){ ?>
                <?php  if(isset($_GET['add'])){ ?>
                    <div class="col">
                        <div class="add">
                            <h4>New subject</h4>
                            <div class="card p-3">
                                <div class="d-flex justify-content-center">
                                    <form action="includes/insert.php" method="post" enctype="multipart/form-data" class=" col-lg-8 col-md-10 col-sm-12">
                                        
                                        <div class="form-group">
                                            <label for="subject">subject <span class="text-danger">*</span> </label>
                                            <input type="text" id="subject" name="subject" class="form-control" required>
                                        </div>
                                        <?php if($school_prop['type'] == 2){ ?>
                                            <div class="form-group">
                                                <label for="coefficient">Coefficient <span class="text-danger">*</span> </label>
                                               
                                                <select  id="coefficient" name="coefficient" class="form-control" required>
                                                    <option></option>
                                                    <?php for($i=1;$i<10;$i++){ ?>
                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        <?php }elseif($school_prop['type'] == 3){ ?>
                                            <div class="form-group">
                                                <label for="module">Module <span class="text-danger">*</span> </label>
                                                <select name="module" class="form-control" required>
                                                    <option></option>
                                                    <?php
                                                        $modules = mysqli_query($connect,
                                                            "SELECT * FROM module WHERE is_deleted=0");
                                                        while($module = mysqli_fetch_assoc($modules)){
                                                    ?>
                                                        <option value="<?php echo $module['id_module'] ?>">
                                                            <?php echo $module['title']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="percentage">Percentage <span class="text-danger">*</span> </label>
                                                <select id="percentage" name="percentage" class="form-control" required>
                                                    <option></option>
                                                    <option value="0.25">25%</option>
                                                    <option value="0.3">30%</option>
                                                    <option value="0.4">40%</option>
                                                    <option value="0.5">50%</option>
                                                    <option value="0.6">60%</option>
                                                    <option value="0.7">70%</option>
                                                    <option value="0.75">75%</option>
                                                    <option value="1">100%</option>
                                                </select>
                                            </div>
                                        <?php } ?>
                                        <input type="submit" value="Add Subject" name="insert-subject" class="form-control bg-primary text-light">
                                        
                                    </form>  
                                </div>     
                            </div>         
                        </div>
                    </div>               
                <?php }elseif(isset($_GET['sbj']) && !empty($_GET['sbj'])
                            && isset($_GET['edit']) && empty($_GET['edit'])){
                            $id_subject = $_GET['sbj'] ;
                            $query_subject = "SELECT * FROM  subject WHERE id_subject = '$id_subject'";
                            $result_subject = mysqli_query($connect , $query_subject);
                            if(mysqli_num_rows($result_subject)){
                             $arr_subject = mysqli_fetch_assoc($result_subject) ;                
                    ?>
                        <div class="add">
                            <h4>Update subject</h4>
                            <div class="card p-3">
                                <div class="d-flex justify-content-center">
                                    <form action="includes/update" method="post" class=" col-lg-8 col-md-10 col-sm-12">                           
                                        <div class="form-group">
                                            <label for="subject">subject <span class="text-danger">*</span> </label>
                                            <input type="text" id="subject" name="subject" class="form-control" 
                                                    value="<?php echo $arr_subject['title_subject']; ?>"
                                                >
                                        </div>
                                        <?php if($school_prop['type'] == 2){ ?>
                                            <div class="form-group">
                                                <label for="coefficient">Coefficient <span class="text-danger">*</span> </label>
                                                 <select  id="coefficient" name="coefficient" class="form-control" required>
                                                    <option></option>
                                                    <?php for($i=1;$i<10;$i++){ ?>
                                                        <option value="<?php echo $i; ?>"
                                                            <?php if($i==$arr_subject['coefficient']) echo "selected" ?>
                                                            >
                                                            <?php echo $i; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        <?php }elseif($school_prop['type'] == 3){ ?>
                                            <div class="form-group">
                                                <label for="module">Module <span class="text-danger">*</span> </label>
                                                <select name="module" class="form-control" required>
                                                    <option></option>
                                                    <?php
                                                        $modules = mysqli_query($connect,
                                                            "SELECT * FROM module WHERE is_deleted=0");
                                                        while($module = mysqli_fetch_assoc($modules)){
                                                    ?>
                                                        <option value="<?php echo $module['id_module'] ?>"
                                                                <?php if($arr_subject['id_module']==$module['id_module']) echo "selected"; ?>
                                                            >
                                                            <?php echo $module['title']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="percentage">Percentage <span class="text-danger">*</span> </label>
                                                <select id="percentage" name="percentage" class="form-control" required>
                                                    <option></option>
                                                    <option value="0.25" <?php if($arr_subject['percentage']==0.25) echo "selected"; ?>>25%</option>
                                                    <option value="0.3" <?php if($arr_subject['percentage']==0.3) echo "selected"; ?>>30%</option>
                                                    <option value="0.4" <?php if($arr_subject['percentage']==0.4) echo "selected"; ?>>40%</option>
                                                    <option value="0.5" <?php if($arr_subject['percentage']==0.5) echo "selected"; ?>>50%</option>
                                                    <option value="0.6" <?php if($arr_subject['percentage']==0.6) echo "selected"; ?>>60%</option>
                                                    <option value="0.7" <?php if($arr_subject['percentage']==0.7) echo "selected"; ?>>70%</option>
                                                    <option value="0.75" <?php if($arr_subject['percentage']==0.75) echo "selected"; ?>>75%</option>
                                                    <option value="1" <?php if($arr_subject['percentage']==1) echo "selected"; ?>>100%</option>
                                                </select>
                                            </div>
                                        <?php } ?>
                                        <input type="hidden" name="sbj" value="<?php echo hash_str($arr_subject['id_subject']); ?>">
                                        <input type="submit" value="Update subject" name="update-subject" class="form-control bg-primary text-light">
                                    
                                    </form>  
                                </div>     
                            </div>             
                        </div>

                        <?php }else{
                            echo "<script> 
                                        window.location.href='subjects'
                                  </script>" ;
                            
                        
                                }
                                ?>
                <?php }else{ ?>
                    <?php   
                        if(isset($_GET['search']) ){
                            $search = $_GET['search'] ;
                            $query = "SELECT * FROM subject
                                            WHERE  is_deleted = 0
                                            AND title_subject like '%$search%' " ;
                        }else{
                            $query = "SELECT * FROM subject WHERE  is_deleted = 0" ;
                        }
                        $result = mysqli_query($connect , $query) ;
                        $total = mysqli_num_rows($result) ;
                        $total_lines = mysqli_num_rows($result) ;
                        $lines_page = 10 ;
                        $nbr_pages = ceil($total_lines/$lines_page) ;
                    ?>
                    <div class="row">
                        <div class="col-md-6 col-sm-4">
                            <p>Total : <b><?php echo $total ?></b></p>
                        </div>
                        <div class="col-md-6 col-sm-8">
                            <form action="" method="get">
                                <div class="form-group">
                                    <input type="search" name="search" id="" class="form-control" placeholder="search">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="overflow-x shadow">
                        <table cellspacing="0" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>subject</th>
                                    <?php if($school_prop['type']==2){ ?>
                                        <th>Coefficient</th>
                                    <?php }elseif ($school_prop['type']==3) { ?>
                                        <th>module</th>
                                        <th>Percentage</th>
                                    <?php } ?>
                                    <th>Plus</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php  
                                if(!isset($_GET['page'])){
                                    $cp =0 ;
                                    $i = 1 ;
                                    while($tab = mysqli_fetch_assoc($result) ){
                                            if($cp <  $lines_page ){
                                            ?>
                                            <tr>
                                                <td><?php echo $i ; $i++; ?></td>
                                                <td><?php echo $tab['title_subject'] ; ?></td>
                                                <?php if($school_prop['type']==2){ ?>
                                                    <td><?php echo $tab['coefficient']  ?></td>
                                                <?php }elseif ($school_prop['type']==3) { ?>
                                                    <?php 
                                                        $module = mysqli_fetch_assoc(
                                                            mysqli_query(
                                                                $connect ,
                                                                "SELECT * FROM module 
                                                                 WHERE is_deleted=0
                                                                 AND id_module = ".$tab['id_module']
                                                            )
                                                        )    
                                                    ?>
                                                    <td><?php echo $module['title']  ?></td>
                                                    <td><?php echo $tab['percentage']*100  ?></td>
                                                <?php } ?>
                                                <td>
                                                    <table class="child-table">
                                                        <tr>
                                                            <td> 
                                                                <a href="subjects?sbj=<?php echo $tab['id_subject'] ; ?>&edit" class="btn btn-info"><i class="fa fa-refresh"></i></a>
                                                            </td>
                                                            <td>
                                                                <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                                <div class="permission">
                                                                    <div class="permission-content">
                                                                        <p>Sure you want to delete That ?</p>
                                                                        <div class="options">
                                                                            <form action="includes/delete" method="post">
                                                                                <input type="hidden" name="sbj" value="<?php echo hash_str($tab['id_subject']); ?>">
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
                                    $i = 1 ; 
                                    while($tab = mysqli_fetch_assoc($result)){
                                        if($cp >= $num_pg*$lines_page) {$cp++;continue ; }
                                        elseif ($cp < ($num_pg-1)*$lines_page) {$cp++;continue ; }
                                        else{$cp++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i ; $i++; ?></td>
                                            <td><?php echo $tab['title_subject'] ; ?></td>
                                            <?php if($school_prop['type']==2){ ?>
                                                <td><?php echo $tab['coefficient']  ?></td>
                                            <?php }elseif ($school_prop['type']==3) { ?>
                                                <?php 
                                                    $module = mysqli_fetch_assoc(
                                                        mysqli_query(
                                                            $connect ,
                                                            "SELECT * FROM module 
                                                                WHERE is_deleted=0
                                                                AND id_module = ".$tab['id_module']
                                                        )
                                                    )    
                                                ?>
                                                <td><?php echo $module['title']  ?></td>
                                                <td><?php echo $tab['percentage']*100  ?></td>
                                            <?php } ?>
                                            <td>
                                                <table class="child-table">
                                                    <tr>
                                                        <td> 
                                                            <a href="subjects?sbj=<?php echo $tab['id_subject'] ; ?>&edit" class="btn btn-info"><i class="fa fa-refresh"></i></a>
                                                        </td>
                                                        <td>
                                                            <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                            <div class="permission">
                                                                <div class="permission-content">
                                                                    <p>Sure you want to delete That ?</p>
                                                                    <div class="options">
                                                                        <form action="includes/delete" method="post">
                                                                            <input type="hidden" name="sbj" value="<?php echo hash_str($tab['id_subject']); ?>">
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
                                <?php  }}
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
                                    <a href="/admin/subjects?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo previous_page($active_page); ?>" class="page-link" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item  <?php if($nbr_pages < $active_page-1 || $active_page == 1) echo "disabled" ?>">
                                    <a href="/admin/subjects?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page-1; ?>" class="page-link">
                                        <?php echo $active_page-1 ;?>
                                    </a>
                                </li>
                                <li class="page-item active <?php if($nbr_pages < $active_page) echo "disabled" ?>">
                                    <a href="/admin/subjects?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page ; ?>" class="page-link">
                                        <?php echo $active_page;?>
                                    </a>
                                </li>
                                <li class="page-item <?php if($nbr_pages < $active_page+1) echo "disabled" ?>">
                                    <a href="/admin/subjects?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page+1 ; ?>" class="page-link">
                                        <?php echo $active_page+1;?>
                                    </a>
                                </li>
                                <li class="page-item <?php if($nbr_pages < $active_page+2) echo "disabled" ?>">
                                    <a href="/admin/subjects?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo next_page($active_page); ?>" class="page-link" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    <?php } ?>
                <?php } ?>
            <?php }elseif(isset($_SESSION['teacher'])){ ?>
                
                <?php if(isset($_GET['subject'])){ ?>
                    <?php  
                        $id_subject = $_GET['subject'] ;
                        $query = mysqli_query(
                            $connect,
                            "SELECT * FROM prof_subject WHERE is_deleted=0
                             AND id_subject = '$id_subject'
                             AND id_user = ".$_SESSION['teacher']
                        );
                        if(mysqli_num_rows($query)==1){
                    ?>
                        <div class="row">
                            <div class="col">
                                
                                    <?php
                                        $subject = $_GET['subject'] ;
                                        
                                        $subject = mysqli_fetch_assoc(
                                            mysqli_query(
                                                $connect,
                                                "SELECT * FROM subject WHERE is_deleted=0
                                                AND id_subject = '$subject'"
                                            )
                                        ) ;
                                    ?>
                                    <div class="row  ">
                                        <div class="col-lg-8">
                                            <h2 class="pb-3"><?php echo $subject['title_subject'] ?></h2>
                                            <hr>
                                            <?php
                                                $files = mysqli_query(
                                                    $connect,
                                                    "SELECT * FROM course_file 
                                                     WHERE is_deleted=0
                                                     AND id_subject = '$id_subject'
                                                     AND id_user = ".$_SESSION['teacher']
                                                ) ;
                                                $user = mysqli_fetch_assoc(
                                                    mysqli_query(
                                                        $connect,
                                                        "SELECT * FROM teacher WHERE is_deleted=0
                                                         AND id_user = ".$_SESSION['teacher']
                                                    )
                                                ) ;
                                                while($file = mysqli_fetch_assoc($files)){
                                            ?>
                                                <div class="file-course">
                                                    <a href="/admin/Files/resources/<?php echo $subject['title_subject']."/".$file['file'] ?>" download="download">
                                                        <span class="h4"><?php echo $file['title'] ?></span><small class="ml-2">[ PDF ]</small>                                                
                                                    </a>
                                                    <p>
                                                        <?php echo $file['description'] ?>
                                                    </p>
                                                </div>
                                                <hr>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card p-2">
                                                <form action="includes/insert" method="post" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="title">Title <span class="text-danger">*</span></label>
                                                                <input type="text" name="title" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="file">File <span class="text-danger">*</span></label>
                                                                <input type="file" name="file" class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="description">Description <span class="text-danger">*</span></label>
                                                                <textarea name="description"  id="description" cols="30" rows="10" class="form-control"></textarea>
                                                            </div>                                                            
                                                        </div>

                                                    </div>
                                                    <input type="hidden" name="subject" value="<?php echo $id_subject ?>">
                                                    <input type="hidden" name="user" value="<?php echo $_SESSION['teacher'] ?>">
                                                    <input type="submit" value="add file" name="file-course" class="btn btn-success">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            
                            </div>
                        </div>
                        <?php }else{
                           echo  "<script> 
                                    window.location.href='subjects'
                            </script>" ;
                        }
                        ?>
                <?php }else{ ?>
                    <div class="row">
                        <div class="col">
                            <h4>Subjects I teach</h4>
                            <div class="p-2">
                                <?php 
                                    $id_sess = mysqli_fetch_assoc(mysqli_query($connect,
                                        "SELECT id_session FROM session 
                                        WHERE is_deleted = 0 
                                        ORDER BY id_session DESC") )['id_session'];
                                    $q = mysqli_query($connect , 
                                        "SELECT * FROM prof_subject, subject, course 
                                            WHERE subject.is_deleted = 0 AND course.is_deleted = 0 
                                            AND  subject.id_subject = prof_subject.id_subject
                                            AND  subject.id_subject = course.id_subject
                                            AND course.id_semester IN(SELECT id_semester FROM semester  WHERE id_session = '$id_sess')
                                            AND  prof_subject.id_user = ".$_SESSION['teacher']."
                                            GROUP BY course.id_subject");
                                    while($arr = mysqli_fetch_assoc($q)){
                                ?>
                                    <div class="card mb-2">
                                        <p  class="p-2"> 
                                            <a href="/admin/subjects?subject=<?php echo $arr['id_subject'] ; ?>" >
                                                <?php echo $arr['title_subject'] ?>
                                            </a> 
                                        </p>
                                    </div>    
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php }elseif(isset($_SESSION['student'])){ ?>
                <?php if(isset($_GET['id']) && !empty($_GET['id'])){ ?>
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

                        $subject = mysqli_query(
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
                            AND subject.id_subject = ".$_GET['id']
                        ) ;
                        if(mysqli_num_rows($subject)){
                            $subject = mysqli_fetch_assoc($subject) ;
                            $teacher = $subject['id_user'] ;
                            $id_subject = $subject['id_subject'] ;
                            $files =  mysqli_query(
                                    $connect,
                                    "SELECT * FROM course_file WHERE is_deleted=0
                                    AND id_user='$teacher' 
                                    AND id_subject = '$id_subject' "
                                 ) ;
                            echo "<h2 class='pb-3'>".$subject['title_subject']."</h2>" ;
                            echo "<hr>" ;
                            while($file = mysqli_fetch_assoc($files)){
                    ?>

                                <div class="file-course">
                                    <a href="/admin/Files/resources/<?php echo $subject['title_subject']."/".$file['file'] ?>" download="download">
                                        <span class="h4"><?php echo $file['title'] ?></span><small class="ml-2">[ PDF ]</small>                                                
                                    </a>
                                    <p>
                                        <?php echo $file['description'] ?>
                                    </p>
                                </div>
                                <hr>
                            <?php } ?>
                        <?php }else{
                            echo "<script> 
                                            window.location.href='dashboard'
                                    </script>" ;
                            }
                        ?>
                <?php }else{ ?> 
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="p-2 rounded" style="background-color: pink; color:red">
                                    <p>It seem like there is a missed Id or id's value </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>   
        </div>


        <?php require_once('includes/footer.php') ?>

    <?php }else{  header('location:/admin/login');} ?>

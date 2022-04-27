<?php
define('TITLE','Semester : SMS');
define('SUB_TITLE','Semester');
    require_once('../connection.php') ;
    include("includes/functions.php");
    session_start();
    if(isset($_SESSION['user']) && isset($_SESSION['manager'])){
        $id = $_SESSION['user'] ;
        $query = "SELECT * FROM manager WHERE id_user = '$id' AND is_deleted = 0 ";
        $result = mysqli_query($connect , $query) ;
        $row = mysqli_fetch_assoc($result) ;
?>
        <?php require_once('includes/header.php') ?>
   
        <div class="container mb-4">
            <div class="row d-flex justify-content-space-between"> 
                <div class="col d-flex ">
                    <div class="border btn mr-1">
                        <a href="/admin/semesters" class="p-2 d-block" >All</a>
                    </div>
                    <div class="border btn">
                        <a href="/admin/semesters?add" class="p-2 d-block">New</a>
                    </div>
                </div>      
            </div>
        </div>

        <div class="container mb-5">
            <?php  if(isset($_GET['add']) && empty($_GET['add'])){ ?>
                    <div class="add">
                        <h4>New semester</h4>
                        <div class="card p-3">
                            <div class="d-flex justify-content-center">
                                <form action="includes/insert.php" method="post" enctype="multipart/form-data" class=" col-lg-8 col-md-10 col-sm-12">

                                    <div class="form-group">
                                        <label for="semester">Semester <span class="text-danger">*</span> </label>
                                        <select name="semester" id="semester" class="form-control" required>
                                            <option value=""></option>
                                            <option value="first semester">First Semester</option>
                                            <option value="second semester">Second Semester</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="session">Session <span class="text-danger">*</span> </label>
                                        <select name="session" id="session" class="form-control" required>
                                            <?php 
                                                $sess = "SELECT * FROM session WHERE is_deleted = 0 " ;
                                                $result_sess = mysqli_query($connect , $sess) ;
                                                $arr = mysqli_fetch_assoc($result_sess)
                                            ?>
                                            <option value="<?php echo hash_str($arr['id_session']); ?>"><?php echo $arr['date_start']."-".$arr['date_end']; ?></option>
                                            
                                        </select>
                                    </div>
                                    <input type="submit" value="Add semester" name="insert-semester" class="form-control bg-primary text-light">
                                
                                </form>                             
                            </div>
                        </div>
                    </div>             
            <?php }elseif(isset($_GET['semester']) && isset($_GET['edit'])){
                        $id_semester = $_GET['semester'] ;
                        $query_semester = "SELECT * FROM  semester 
                                            WHERE id_semester = '$id_semester'
                                            AND is_deleted = 0 ";
                        $result_semester = mysqli_query($connect , $query_semester);
                        if(mysqli_num_rows($result_semester)){
                        $arr_semester = mysqli_fetch_assoc($result_semester) ;                
                ?>
                    <div class="add">
                        <h4>Update semester</h4>
                        <div class="card p-3">
                            <div class="d-flex justify-content-center">
                                <form action="includes/update" method="post" class=" col-lg-6 col-md-8 col-sm-12">                          
                                    <div class="form-group">
                                        <label for="semester">Semester <span class="text-danger">*</span> </label>
                                        <select name="semester" id="semester" class="form-control" required>
                                            <option value="first semester"
                                                <?php if($arr_semester['title_semester']=="first semester") echo "selected"; ?>
                                            >First Semester</option>
                                            <option value="second semester"
                                                <?php if($arr_semester['title_semester']=="second semester") echo "selected"; ?>
                                            >Second Semester</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="session">Session <span class="text-danger">*</span> </label>
                                        <select name="session" id="session" class="form-control" required>
                                            <option></option>
                                            <?php 
                                                $sess = "SELECT * FROM session WHERE is_deleted = 0 " ;
                                                $result_sess = mysqli_query($connect , $sess) ;
                                                while($arr = mysqli_fetch_assoc($result_sess)){
                                            ?>
                                            <option <?php if($_GET['semester'] == $arr_semester['id_semester']) echo "selected"; ?> 
                                                    value="<?php echo hash_str($arr['id_session']); ?>">
                                                    <?php echo $arr['date_start']."-".$arr['date_end']; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <input type="hidden" name="smstr" value="<?php echo hash_str($arr_semester['id_semester']); ?>">
                                    
                                    <input type="submit" value="Update Semester" name="update-semester" class="form-control bg-primary text-light">
                                    
                                </form>                              
                            </div>
                        </div>
                    </div>

                    <?php }else{
                            echo "<script> 
                                        window.location.href='semesters'
                                  </script>" ;
                        } 
                    ?>
            <?php }else{ ?>
                <?php   
                   if(isset($_GET['search']) ){
                        $search = $_GET['search'] ;
                        $q = "SELECT * FROM session 
                                WHERE  is_deleted = 0 
                                AND date_start LIKE '%$search%' 
                                OR date_end LIKE '%$search%'";
                        $r = mysqli_query($connect , $q);
                        $arr = mysqli_fetch_assoc($r) ;
                        if(mysqli_num_rows($r) > 0 )
                        {
                            $i = $arr['id_session'];
                            $query = "SELECT * FROM semester
                                        WHERE  is_deleted = 0 
                                        AND title_semester like '%$search%' 
                                        OR id_session = '$i' " ;
                        }else{
                            $query = "SELECT * FROM semester
                                        WHERE   is_deleted = 0  AND title_semester like '%$search%'  " ;
                        }
                    }else{
                        $query = "SELECT * FROM semester WHERE   is_deleted = 0 " ;
                    }
                    $result = mysqli_query($connect , $query) ;
                    $total = mysqli_num_rows($result);
                    $total_lines = mysqli_num_rows($result) ;
                    $lines_page = 10 ;
                    $nbr_pages = ceil($total_lines/$lines_page) ;
                ?>
                <div class="row">
                    <div class="col-md-6 col-sm-4">
                        <p>Total : <b><?php echo $total ?></b></p>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <form action="" method="post">
                            <div class="form-group">
                                <input type="search" name="search" class="form-control" placeholder="search">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="overflow-x shadow">
                    <table cellspacing="0" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Semester</th>
                                <th>Session</th>
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
                                            <td><?php echo $tab['title_semester'] ; ?></td>
                                            <?php 
                                                $q = "SELECT * FROM session 
                                                    WHERE   is_deleted = 0 
                                                    AND id_session = ".$tab['id_session'] ;
                                                $r = mysqli_query($connect , $q);
                                                $arr =mysqli_fetch_assoc($r) ;
                                            ?>
                                            <td><?php echo $arr['date_start']."-".$arr['date_end'] ; ?></td>
                                            <td>
                                                <table class="child-table"> 
                                                    <tr>
                                                        <td> 
                                                            <a href="semesters?semester=<?php echo $tab['id_semester']; ?>&edit" class="btn btn-info"><i class="fa fa-refresh"></i></a>
                                                        </td>
                                                        <td>
                                                            <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                            <div class="permission">
                                                                <div class="permission-content">
                                                                    <p>Sure you want to delete That ?</p>
                                                                    <div class="options">
                                                                        <form action="includes/delete" method="post">
                                                                            <input type="hidden" name="smstr" value="<?php echo hash_str($tab['id_semester']); ?>">
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
                                while($tab = mysqli_fetch_assoc($result)){
                                    if($cp >= $num_pg*$lines_page) {$cp++;continue ; }
                                    elseif ($cp < ($num_pg-1)*$lines_page) {$cp++;continue ; }
                                    else{$cp++;
                                    ?>
                                    <tr>
                                        <td><?php echo $tab['id_semester'] ; ?></td>
                                        <td><?php echo $tab['title_semester'] ; ?></td>
                                        <?php 
                                                $q = "SELECT * FROM session 
                                                    WHERE   is_deleted = 0
                                                        AND id_session = ".$tab['id_session'] ;
                                                $r = mysqli_query($connect , $q);
                                                $arr =mysqli_fetch_assoc($r) ;
                                            ?>
                                        <td><?php echo $arr['date_start']."-".$arr['date_end'] ; ?></td>
                                        <td>
                                            <table class="child-table"> 
                                                <tr>
                                                    <td> 
                                                        <a href="semesters?semester=<?php echo $tab['id_semester']; ?>&edit" class="btn btn-info"><i class="fa fa-refresh"></i></a>
                                                    </td>
                                                    <td>
                                                        <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                        <div class="permission">
                                                            <div class="permission-content">
                                                                <p>Sure you want to delete That ?</p>
                                                                <div class="options">
                                                                    <form action="includes/delete" method="post">
                                                                        <input type="hidden" name="smstr" value="<?php echo hash_str($tab['id_semester']); ?>">
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
                                <a href="/admin/semesters?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo previous_page($active_page); ?>" class="page-link" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item  <?php if($nbr_pages < $active_page-1 || $active_page == 1) echo "disabled" ?>">
                                <a href="/admin/semesters?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page-1; ?>" class="page-link">
                                    <?php echo $active_page-1 ;?>
                                </a>
                            </li>
                            <li class="page-item active <?php if($nbr_pages < $active_page) echo "disabled" ?>">
                                <a href="/admin/semesters?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page ; ?>" class="page-link">
                                    <?php echo $active_page;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+1) echo "disabled" ?>">
                                <a href="/admin/semesters?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page+1 ; ?>" class="page-link">
                                    <?php echo $active_page+1;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+2) echo "disabled" ?>">
                                <a href="/admin/semesters?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo next_page($active_page); ?>" class="page-link" aria-label="Next">
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

    <?php }else{  header('location:/admin/login');} ?>

<?php
    define('TITLE','Inscriptions : SMS');
    define('SUB_TITLE','Inscriptions');
    require_once('../connection.php') ;
    require_once('includes/functions.php') ;
    session_start();
    if(isset($_SESSION['user']) && isset($_SESSION['manager'])){
        $id = $_SESSION['user'] ;
        $query = "SELECT * FROM manager WHERE id_user = '$id' AND is_deleted = 0 ";
        $result = mysqli_query($connect , $query) ;
        $row = mysqli_fetch_assoc($result) ;
?>

        <?php require_once('includes/header.php') ?>
        
  


        <div class=" mb-4">
            <div class="row d-flex justify-content-space-between"> 
                <div class="col d-flex ">
                    <div class="btn border">
                        <a href="/admin/inscriptions" class="p-2 d-block" >All</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-5">
       
            <?php   
                if(isset($_GET['search']) ){
                    $search = $_GET['search'] ;
                    $q = "SELECT * FROM student 
                            WHERE cne_student = '$search' AND is_deleted = 0";
                    $r = mysqli_query($connect , $q);
                    $arr = mysqli_fetch_assoc($r) ;
                    if(mysqli_num_rows($r) > 0 ){
                        $i = $arr['id_user'];
                        $query = "SELECT * FROM inscription
                                    WHERE id_user = '$i'  AND is_deleted = 0 " ;
                    }else{
                        $query = "SELECT * FROM inscription  WHERE is_deleted = 0" ;
                    }
                    
                }else{
                    $query = "SELECT * FROM inscription  WHERE is_deleted = 0" ;
                }
                $result = mysqli_query($connect , $query) ;
                $total = mysqli_num_rows($result);
                $total_lines = mysqli_num_rows($result) ;
                $lines_page = 10 ;
                $nbr_pages = ceil($total_lines/$lines_page) ;
            ?>
            <div class="row">
                <div class="col-md-6 col-sm-4">
                    <p>Total : <b> <?php echo $total ?> </b> </p>
                </div>
                <div class="col-md-6 col-sm-8">
                    <form action="" method="get">
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
                            <th>Student</th>
                            <th>Class</th>
                            <th>Session</th>
                            <th>Inscription Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php  
                        if(!isset($_GET['page'])){
                            $cp =0 ;
                            $i = 1 ;
                            while($tab = mysqli_fetch_assoc($result) ){
                                $std = mysqli_fetch_assoc(mysqli_query($connect,
                                    "SELECT * FROM student 
                                    WHERE id_user=".$tab['id_user']." AND is_deleted = 0"));
                                $cls = mysqli_fetch_assoc(mysqli_query($connect,
                                    "SELECT * FROM class 
                                    WHERE id_class=".$tab['id_class']." AND is_deleted = 0"));
                                $sess = mysqli_fetch_assoc(mysqli_query($connect,
                                    "SELECT * FROM session 
                                    WHERE id_session=".$tab['id_session']." AND is_deleted = 0"));
                                    if($cp <  $lines_page ){
                                    ?>
                                    <tr>
                                        <td><?php echo $i ; $i++; ?></td>
                                        <td><?php echo $std['fname_user']." ".$std['lname_user'] ; ?></td>
                                        <td><?php echo $cls['title_class']; ?></td>
                                        <td><?php echo $sess['date_start']." ".$sess['date_end']; ?></td>
                                        <td><?php echo $tab['date_inscription'] ; ?></td>
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
                                    $std = mysqli_fetch_assoc(mysqli_query($connect,
                                    "SELECT * FROM student WHERE id_user=".$tab['id_user']." AND is_deleted = 0"));
                                    $cls = mysqli_fetch_assoc(mysqli_query($connect,
                                    "SELECT * FROM class WHERE id_class=".$tab['id_class']." AND is_deleted = 0"));
                                    $sess = mysqli_fetch_assoc(mysqli_query($connect,
                                    "SELECT * FROM session WHERE id_session=".$tab['id_session']." AND is_deleted = 0"));
                                ?>
                                <tr>
                                    <td><?php echo $i ; $i++ ; ?></td>
                                    <td><?php echo $std['fname_user']." ".$std['lname_user'] ; ?></td>
                                    <td><?php echo $cls['title_class']; ?></td>
                                    <td><?php echo $sess['date_start']."-".$sess['date_end']; ?></td>
                                    <td><?php echo $tab['date_inscription'] ; ?></td>
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
                                <a href="/admin/inscriptions?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo previous_page($active_page); ?>" class="page-link" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item  <?php if($nbr_pages < $active_page-1 || $active_page == 1) echo "disabled" ?>">
                                <a href="/admin/inscriptions?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page-1; ?>" class="page-link">
                                    <?php echo $active_page-1 ;?>
                                </a>
                            </li>
                            <li class="page-item active <?php if($nbr_pages < $active_page) echo "disabled" ?>">
                                <a href="/admin/inscriptions?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page ; ?>" class="page-link">
                                    <?php echo $active_page;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+1) echo "disabled" ?>">
                                <a href="/admin/inscriptions?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page+1 ; ?>" class="page-link">
                                    <?php echo $active_page+1;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+2) echo "disabled" ?>">
                                <a href="/admin/inscriptions?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo next_page($active_page); ?>" class="page-link" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php } ?>
            
            

        </div>


        <?php require_once('includes/footer.php') ?>

    <?php }else{  header('location:/admin/login');} ?>

<?php
define('TITLE','Session : SMS');
define('SUB_TITLE','Session');
    require_once('../connection.php') ;
    include('includes/functions.php');
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
                        <a href="/admin/sessions" class="p-2 d-block" >All</a>
                    </div>
                    <?php  if( $row['is_super']==1){ ?>
                    <div class="border btn">
                        <a href="/admin/sessions?add" class="p-2 d-block" >New</a>
                    </div>
                    <?php } ?>
                </div>   
            </div>
        </div>

        <div class="container mb-5">
            <?php  if(isset($_GET['add']) && empty($_GET['add']) && $row['is_super']==1){ ?>
                <div class="add">
                    <h4>New session</h4>
                    <div class="card p-3">
                        <div class="d-flex justify-content-center">
                            <form action="includes/insert" method="post" enctype="multipart/form-data" class=" col-lg-8 col-md-10 col-sm-12">
                                                                
                                <div class="form-group" >
                                    <label  for="start">Start <span class="text-danger">*</span> </label>
                                    <input type="number" value="<?php echo date('Y') ?>" id="start" name="start" class="form-control" required>
                                </div>

                                <div class="form-group" >
                                    <label  for="end">End <span class="text-danger">*</span> </label>
                                    <input type="number" value="<?php echo date('Y')+1 ?>" min="2018" id="end" name="end" class="form-control" required>
                                </div>
                                <input type="submit" value="Add session" name="insert-session" class="form-control bg-primary text-light">
                                
                            </form>                            
                        </div>
                    </div>
            
                </div>              
            <?php }elseif(isset($_GET['session']) && !empty($_GET['session'])
                            && isset($_GET['edit']) && empty($_GET['edit'])){
                        $id_session = $_GET['session'] ;
                        $query_session = "SELECT * FROM  session WHERE id_session = '$id_session' AND is_deleted = 0";
                        $result_session = mysqli_query($connect , $query_session);
                        if(mysqli_num_rows($result_session)){
                        $arr_session = mysqli_fetch_assoc($result_session) ;                
                ?>
                    <div class="add">
                        <h4>Update session</h4>
                        <div class="card p-3">
                            <div class="d-flex justify-content-center">
                                <form action="includes/update" method="post" class=" col-lg-6 col-md-8 col-sm-12">                           
                                    <div class="form-group" >
                                        <label  for="start">Start <span class="text-danger">*</span> </label>
                                        <input type="number" value="<?php echo $arr_session['date_start']; ?>" id="start" name="start" class="form-control" required>
                                    </div>

                                    <div class="form-group" >
                                        <label  for="end">End <span class="text-danger">*</span> </label>
                                        <input type="number" value="<?php echo $arr_session['date_end']; ?>" min="2018" id="end" name="end" class="form-control" required>
                                    </div>
                                    <input type="hidden" name="session" value="<?php echo hash_str($id_session) ?>">
                                    
                                    <input type="submit" value="Update session" name="update-session" class="form-control bg-primary text-light">
                                    
                                </form>                            
                            </div>
                        </div>
                    </div>
                    <?php }else{
                            echo "<script> 
                                        window.location.href='sessions'
                                  </script>" ;
                            } 
                    ?>
            <?php }else{ ?>
                <?php   
                    if(isset($_GET['search']) ){
                        $search = $_GET['search'] ;
                        $query = "SELECT * FROM session
                                    WHERE  is_deleted = 0
                                    AND date_start like '%$search%'
                                    OR date_end like '%$search%' " ;
                    }else{
                        $query = " SELECT * FROM session WHERE is_deleted = 0 " ;
                    }
                    $result = mysqli_query($connect , $query) ;
                    $total = mysqli_num_rows($result) ;
                    $total_lines = mysqli_num_rows($result) ;
                    $lines_page = 10 ;
                    $nbr_pages = ceil($total_lines/$lines_page) ;
                ?>
                <div class="row">
                    <div class="col-md-6 col-sm-4">
                        <p>Total : <?php echo $total ?></p>
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
                                <th>session</th>
                                <th>Starts</th>
                                <th>Ends</th>
                                <?php  if( $row['is_super']==1){ ?>
                                <th>Plus</th>
                                <?php } ?>
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
                                            <td><?php echo $i ; $i++ ; ?></td>
                                            <td><?php echo $tab['date_start'] ; ?></td>
                                            <td><?php echo $tab['date_end'] ; ?></td>
                                            <?php  if( $row['is_super']==1){ ?>
                                            <td>
                                                <table class="child-table"> 
                                                    <tr>
                                                        <td> 
                                                            <a href="sessions?session=<?php echo $tab['id_session']; ?>&edit" class="btn btn-info"><i class="fa fa-refresh"></i></a>
                                                        </td>
                                                        <td>
                                                            <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                            <div class="permission">
                                                                <div class="permission-content">
                                                                    <p>Sure you want to delete That ?</p>
                                                                    <div class="options">
                                                                        <form action="includes/delete" method="post">
                                                                            <input type="hidden" name="session" value="<?php echo hash_str($tab['id_session']); ?>">
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
                                            <?php } ?>
                                        </tr>
                                    <?php }else{ break ; }
                                        $cp++ ;
                                }

                            }else{
                                $num_pg = $_GET['page'] ;
                                $cp = 0 ;
                                $i = 0 ;
                                while($tab = mysqli_fetch_assoc($result)){
                                    if($cp >= $num_pg*$lines_page) {$cp++;continue ; }
                                    elseif ($cp < ($num_pg-1)*$lines_page) {$cp++;continue ; }
                                    else{$cp++;$i++ ;
                                    ?>
                                        <tr>
                                            <td><?php echo $i ; $i++ ; ?></td>
                                            <td><?php echo $tab['date_start'] ; ?></td>
                                            <td><?php echo $tab['date_end'] ; ?></td>
                                            <?php  if( $row['is_super']==1){ ?>
                                            <td>
                                                <table class="child-table"> 
                                                    <tr>
                                                        <td> 
                                                            <a href="sessions?session=<?php echo $tab['id_session'] ?>&edit" class="btn btn-info"><i class="fa fa-refresh"></i></a>
                                                        </td>
                                                        <td>
                                                            <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                            <div class="permission">
                                                                <div class="permission-content">
                                                                    <p>Sure you want to delete That ?</p>
                                                                    <div class="options">
                                                                        <form action="includes/delete" method="post">
                                                                            <input type="hidden" name="session" value="<?php echo hash_str($tab['id_session']); ?>">
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
                                            <?php } ?>
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
                                <a href="/admin/sessions?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo previous_page($active_page); ?>" class="page-link" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item  <?php if($nbr_pages < $active_page-1 || $active_page == 1) echo "disabled" ?>">
                                <a href="/admin/sessions?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page-1; ?>" class="page-link">
                                    <?php echo $active_page-1 ;?>
                                </a>
                            </li>
                            <li class="page-item active <?php if($nbr_pages < $active_page) echo "disabled" ?>">
                                <a href="/admin/sessions?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page ; ?>" class="page-link">
                                    <?php echo $active_page;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+1) echo "disabled" ?>">
                                <a href="/admin/sessions?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page+1 ; ?>" class="page-link">
                                    <?php echo $active_page+1;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+2) echo "disabled" ?>">
                                <a href="/admin/sessions?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo next_page($active_page); ?>" class="page-link" aria-label="Next">
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

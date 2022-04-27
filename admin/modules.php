<?php
    define('TITLE','modules : SMS');
    define('SUB_TITLE','module');
    require_once('includes/functions.php') ;
     require_once('../connection.php') ;
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
                        <a href="/admin/modules" class="p-2 d-block">All</a>
                    </div>
                    <div class="btn border">
                        <a href="/admin/modules?add" class="p-2 d-block">New</a>
                    </div>
                </div>         
            </div>
        </div>

        <div class="container mb-5">
            <?php  if(isset($_GET['add'])){ ?>
                <div class="add">
                    <h4>New module</h4>
                    <div class="card p-3">
                        <div class="d-flex justify-content-center">
                            <form action="includes/insert" method="post" enctype="multipart/form-data" class=" col-lg-8 col-md-10 col-sm-12">
                                
                                <div class="form-group">
                                    <label for="module">module <span class="text-danger">*</span> </label>
                                    <input type="text" id="module" name="module" class="form-control" required>
                                </div>
                                <input type="submit" value="Add New module" name="insert-module" class="form-control bg-primary text-light">
                            
                            </form>                              
                        </div>
                    </div>
                </div>            
            <?php }elseif(isset($_GET['module']) && !empty($_GET['module'])
                            &&  isset($_GET['edit'])){
                        $id_module = $_GET['module'] ;
                        $query_module = "SELECT * FROM  module WHERE id_module = '$id_module' AND is_deleted = 0";
                        $result_module = mysqli_query($connect , $query_module);
                        $arr_module = mysqli_fetch_assoc($result_module) ;
                        if(mysqli_num_rows($result_module) > 0){                  
                ?>
                            <div class="add">
                                <h4>Update module</h4>
                                <div class="card p-3">
                                    <div class="d-flex justify-content-center">
                                        <form action="includes/update" method="post" class=" col-lg-6 col-md-8 col-sm-12">                           
                                            <div class="form-group">
                                                <label for="module">module <span class="text-danger">*</span> </label>
                                                <input type="text" id="module" name="module" class="form-control" 
                                                        value="<?php echo $arr_module['title']; ?>"
                                                        required
                                                    >
                                            </div>
                                            <input type="hidden" name='id' value="<?php echo hash_str($arr_module['id_module']); ?>">
                                            <input type="submit" value="Update module" name="update-module" class="form-control bg-primary text-light">
                                        </form>                                         
                                    </div>
                                </div>
                            </div>
                        <?php }else{
                            echo "<script> 
                                        window.location.href='modules'
                                  </script>" ;
                            
                        
                                }  ?>
            <?php }else{ ?>
                <?php   
                    if(isset($_GET['search']) ){
                        $search = $_GET['search'] ;
                        $query = "SELECT * FROM module
                                        WHERE title like '%$search%' AND is_deleted = 0" ;
                    }else{
                        $query = "SELECT * FROM module WHERE is_deleted = 0" ;
                    }
                    $result = mysqli_query($connect , $query) ;
                    $total = mysqli_num_rows($result) ;
                    $total_lines = mysqli_num_rows($result) ;
                    $lines_page = 10 ;
                    $nbr_pages = ceil($total_lines/$lines_page) ;
                ?>
                <div class="row">
                    <div class="col-md-6 col-sm-4">
                        <p>Total : <b><?php echo $total?></b></p>
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
                                <th>module</th>
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
                                            <td><?php echo $i ; $i++ ; ?></td>
                                            <td><?php echo $tab['title'] ; ?></td>
                                            <td>
                                                <table class="child-table"> 
                                                    <tr>
                                                        <td> 
                                                            <a href="modules?module=<?php echo $tab['id_module']; ?>&edit" class="btn btn-info"><i class="fa fa-refresh"></i></a>
                                                        </td>
                                                        <td>
                                                            <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                            <div class="permission">
                                                                <div class="permission-content">
                                                                    <p>Sure you want to delete That ?</p>
                                                                    <div class="options">
                                                                        <form action="includes/delete" method="post">
                                                                            <input type="hidden" name="module" value="<?php echo hash_str($tab['id_module']); ?>">
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
                                        <td><?php echo $i ; $i++ ; ?></td>
                                        <td><?php echo $tab['title'] ; ?></td>
                                        <td>
                                            <table class="child-table"> 
                                                <tr>
                                                    <td> 
                                                        <a href="modules?module=<?php echo $tab['id_module']; ?>&edit" class="btn btn-info"><i class="fa fa-refresh"></i></a>
                                                    </td>
                                                    <td>
                                                        <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                        <div class="permission">
                                                            <div class="permission-content">
                                                                <p>Sure you want to delete That ?</p>
                                                                <div class="options">
                                                                    <form action="includes/delete" method="post">
                                                                        <input type="hidden" name="module" value="<?php echo hash_str($tab['id_module']); ?>">
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
                                <a href="/admin/modules?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo previous_page($active_page); ?>" class="page-link" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item  <?php if($nbr_pages < $active_page-1 || $active_page == 1) echo "disabled" ?>">
                                <a href="/admin/modules?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page-1; ?>" class="page-link">
                                    <?php echo $active_page-1 ;?>
                                </a>
                            </li>
                            <li class="page-item active <?php if($nbr_pages < $active_page) echo "disabled" ?>">
                                <a href="/admin/modules?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page ; ?>" class="page-link">
                                    <?php echo $active_page;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+1) echo "disabled" ?>">
                                <a href="/admin/modules?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page+1 ; ?>" class="page-link">
                                    <?php echo $active_page+1;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+2) echo "disabled" ?>">
                                <a href="/admin/modules?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo next_page($active_page); ?>" class="page-link" aria-label="Next">
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

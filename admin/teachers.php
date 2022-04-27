<?php
define('TITLE','Teachers : SMS');
define('SUB_TITLE','Teachers');
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
            <div class="row mb-3"> 
                <div class="border btn mr-1">
                        <a href="/admin/teachers" class="p-2 d-block" >All</a>
                </div>
                <div class="border btn">
                    <a href="/admin/teachers?add" class="p-2 d-block" >New</a>
                </div>
            </div>  
        </div>

        <div class=" mb-5">
            <?php  if(!isset($_GET['add'])){ ?>
                <?php   
                    if(isset($_GET['search']) ){
                        $search = $_GET['search'] ;
                        $query = "SELECT * FROM teacher
                                    WHERE is_deleted = 0
                                    AND ( fname_user like '%$search%' 
                                    OR lname_user like '%$search%'
                                    OR email_user like '%$search%'
                                    OR city_user  like '%$search%') " ;
                    }else{
                        $query = "SELECT * FROM teacher WHERE is_deleted = 0" ;
                    }
                    $result = mysqli_query($connect , $query) ;
                    $total = mysqli_num_rows($result) ;
                    $total_lines = mysqli_num_rows($result) ;
                    $lines_page = 10 ;
                    $nbr_pages = ceil($total_lines/$lines_page) ;
                ?>
                <div class="row">  
                    <div class=" col-md-6 col-sm-4 mb-2">
                       <p>Total : <b><?php echo $total ?></b></p>  
                    </div>  
                    <div class=" col-md-6 col-sm-8">
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
                                <th>Image</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Email</th>
                                <th>actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                                if(!isset($_GET['page'])){
                                    $cp =0 ;
                                    while($tab = mysqli_fetch_assoc($result) ){
                                            if($cp <  $lines_page ){
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php if($tab['image_user']==null){ ?>
                                                        <img  src="Files/Custom/user.png" >
                                                    <?php }else{ ?>
                                                        <img  src="Files/teachers/<?php echo $tab['cin_user']."/".$tab['image_user'] ; ?>" >
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $tab['lname_user'] ; ?></td>
                                                <td><?php echo $tab['fname_user'] ; ?></td>
                                                <td><?php echo $tab['email_user'] ; ?></td>
                                                <td> 
                                                    <table class="child-table">
                                                        <tr>
                                                            <td>
                                                                <a href="profile?teacher=<?php echo $tab['id_user']; ?>" class="btn btn-info"><i class="fa fa-user"></i></a>
                                                            </td>
                                                            <td>
                                                                <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                                <div class="permission">
                                                                    <div class="permission-content">
                                                                        <p>Sure you want to delete That ?</p>
                                                                        <div class="options">
                                                                            <form action="includes/delete" method="post">
                                                                                <input type="hidden" name="teacher" value="<?php echo hash_str($tab['id_user']); ?>">
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
                                            <td>
                                                <?php if($tab['image_user']==null){ ?>
                                                    <img  src="Files/Custom/user.png" >
                                                <?php }else{ ?>
                                                    <img  src="Files/teachers/<?php echo $tab['cin_user']."/".$tab['image_user'] ; ?>" >
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $tab['lname_user'] ; ?></td>
                                            <td><?php echo $tab['fname_user'] ; ?></td>
                                            <td><?php echo $tab['email_user'] ; ?></td>
                                            <td> 
                                                <table class="child-table">
                                                    <tr>
                                                        <td>
                                                            <a href="profile?teacher=<?php echo $tab['id_user']; ?>" class="btn btn-info"><i class="fa fa-user"></i></a>
                                                        </td>
                                                        <td>
                                                            <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                            <div class="permission">
                                                                <div class="permission-content">
                                                                    <p>Sure you want to delete That ?</p>
                                                                    <div class="options">
                                                                        <form action="includes/delete" method="post">
                                                                            <input type="hidden" name="teacher" value="<?php echo hash_str($tab['id_user']); ?>">
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
                                <a href="/admin/teachers?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo previous_page($active_page); ?>" class="page-link" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item  <?php if($nbr_pages < $active_page-1 || $active_page == 1) echo "disabled" ?>">
                                <a href="/admin/teachers?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page-1; ?>" class="page-link">
                                    <?php echo $active_page-1 ;?>
                                </a>
                            </li>
                            <li class="page-item active <?php if($nbr_pages < $active_page) echo "disabled" ?>">
                                <a href="/admin/teachers?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page ; ?>" class="page-link">
                                    <?php echo $active_page;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+1) echo "disabled" ?>">
                                <a href="/admin/teachers?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page+1 ; ?>" class="page-link">
                                    <?php echo $active_page+1;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+2) echo "disabled" ?>">
                                <a href="/admin/teachers?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo next_page($active_page); ?>" class="page-link" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php } ?>
            <?php }else{ ?>
                    <div class="add">
                        <h4>New Teacher</h4>
                        <div class="d-flex justify-content-center">
                            <form action="includes/insert.php" method="post" enctype="multipart/form-data" class=" col-lg-8 col-md-10 col-sm-12">
                                <div class="card p-3 mb-3">
                                    <fieldset>
                                        <legend><h5>Personal Information  <span class="text-danger">*</span></h5></legend>
                                        <div class="pl-3 row">
                                            <div class="col-lg-4 form-group">
                                                <input type="text" placeholder="Last Name" id="lname" name="lname" class="form-control" required>
                                            </div>
                                            <div class="col-lg-4 form-group">
                                                <input type="text" placeholder="First Name " id="fname" name="fname" class="form-control" required>
                                            </div>
                                            <div class="col-lg-4 form-group">
                                                <input type="text" placeholder="CIN" id="cin" name="cin" class="form-control" required>
                                            </div>                               
                                        </div>                                    
                                    </fieldset>
                                </div>
                                <div class="card p-3 mb-3">
                                    <fieldset>
                                        <legend> <h5> Adress</h5></legend>
                                        <div class="pl-3 row">
                                            <div class="form-group col-lg-8">
                                                <input type="text" placeholder="Adress" id="adress" name="adress" class="form-control" placeholder="street ...">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <input type="text" placeholder="City" id="city" name="city" class="form-control">
                                            </div>                                
                                        </div>
                                    </fieldset>
                                </div>    
                                <div class="card p-3 mb-3">
                                    <fieldset>
                                        <legend><h5>Login Information <span class="text-danger">*</span></h5></legend> 
                                        <div class="pl-3 row">
                                            <div class="form-group col-lg-6">
                                                <input type="text" placeholder="Email" id="email" name="email" class="form-control" placeholder="exemple@gmail.xyz" required>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <input type="password" placeholder="Password" id="password" name="password" class="form-control" required>
                                            </div>                                
                                        </div>
                                    </fieldset>
                                </div>   
                                <div class="card p-3 mb-3">
                                    <fieldset>
                                        <legend><h5>Photo </h5></legend> 
                                        <div class="form-group">
                                            <input type="file"  id="image" name="image" class="form-control">
                                        </div> 
                                    </fieldset>
                                </div>
                                <input type="submit" value="Add New Teacher" name="insert-teacher" class="form-control bg-primary text-light">
                            </form> 
                        </div>              
                    </div>
            <?php } ?>
            

        </div>


        <?php require_once('includes/footer.php') ?>

    <?php }else{  header('location:/admin/login');} ?>

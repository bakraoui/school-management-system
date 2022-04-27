<?php
    define('TITLE','Managers : SMS');
    define('SUB_TITLE','Managers');
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

        <div class=" mb-4">
            <div class="row mb-3"> 
                <div class="border btn mr-1">
                    <a href="/admin/managers" class="p-lg-2 d-block">All</a>
                </div>
                <?php if(isset($_SESSION['manager']) && $row['is_super'] == 1){ ?>
                    <div class="border btn">
                        <a href="/admin/managers?add" class="p-lg-2 d-block">New</a>
                    </div>
                <?php } ?>
            </div>
        </div>


        <div class="mb-5">
            <?php  if(isset($_GET['add']) && empty($_GET['add'])
                        && isset($_SESSION['manager']) 
                        && $row['is_super']==1){ ?>

                <div class="add">
                    <h4>New Manager</h4>
                    <div class="d-flex justify-content-center">
                        <form action="includes/insert.php" method="post" enctype="multipart/form-data" class=" col-lg-8 col-md-10 col-sm-12">
                            <div class="card p-3 mb-3">
                                <fieldset>
                                    <legend><h5>Personal Information <span class="text-danger">*</span> </h5></legend>
                                    <div class="pl-3 row">
                                        <div class="form-group col-lg-4">
                                            <input type="text" placeholder="Last Name" id="lname" name="lname" class="form-control" required>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <input type="text" placeholder="First Name" id="fname" name="fname" class="form-control" required>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <input type="text" placeholder="CIN" id="cin" name="cin" class="form-control" required>
                                        </div>                              
                                    </div>                                    
                                </fieldset>
                            </div>
                            <div class="card p-3 mb-3">
                                <fieldset>
                                    <legend> <h5> Adress </h5></legend>
                                    <div class="pl-3 row">
                                        <div class="form-group col-lg-8">
                                            <input type="text" placeholder="Adress" id="adress" name="adress" class="form-control" placeholder="street ...">
                                        </div>
                                        <div class="form-group  col-lg-4">
                                            <input type="text" placeholder="City" id="city" name="city" class="form-control">
                                        </div>                                
                                    </div>
                                </fieldset>
                            </div>
                            <div class="card p-3 mb-3">
                                <fieldset>
                                    <legend><h5>Login Information <span class="text-danger">*</span> </h5></legend> 
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
                            <div class="card p-3">
                                <fieldset>
                                    <legend><h5>Photo </h5></legend>
                                    <div class="form-group">
                                        <input type="file" id="image" name="image" class="form-control">
                                    </div>  
                                </fieldset>
                            </div>
                            <input type="submit" value="Add New Manager" name="insert-manager" class="form-control bg-primary text-light">
                            
                        </form> 
                    </div>               
                </div>

            <?php }else{ ?>
                <?php   
                    if(isset($_GET['search']) ){
                        $search = $_GET['search'] ;
                        $query = "SELECT * FROM manager
                                    WHERE is_deleted = 0
                                    AND ( fname_user like '%$search%' 
                                    OR lname_user like '%$search%'
                                    OR email_user like '%$search%'
                                    OR city_user  like '%$search%' )" ;
                        
                    }else{
                        $query = "SELECT * FROM manager WHERE is_deleted = 0 " ;
                    }
                    $result = mysqli_query($connect , $query) ;
                    $total = mysqli_num_rows($result);
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
                                <th>#</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Email</th>
                                <th>City</th>
                                <?php if(isset($_SESSION['manager']) && $row['is_super']==1){ ?>
                                    <th>actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php  
                            if(!isset($_GET['page'])){
                                $cp =0 ;
                                while($tab = mysqli_fetch_assoc($result) ){
                                        if($cp <  $lines_page ){
                                        ?>
                                        <tr class="<?php if($row['id_user'] == $tab['id_user']) echo "me"  ?>">
                                            <td>
                                                <?php if($tab['image_user']==null){ ?>
                                                    <img  src="Files/Custom/user.png" >
                                                <?php }else{ ?>
                                                    <img  src="Files/managers/<?php echo $tab['cin_user']."/".$tab['image_user'] ; ?>" >
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $tab['lname_user'] ; ?></td>
                                            <td><?php echo $tab['fname_user'] ; ?></td>
                                            <td><?php echo $tab['email_user'] ; ?></td>
                                            <td><?php echo $tab['city_user'] ; ?></td>
                                            <?php if(isset($_SESSION['manager']) && $row['is_super']==1){ ?>
                                            <td> 
                                                <table class="child-table"> 
                                                    <tr>
                                                        <?php if($tab['id_user'] != $_SESSION['manager']){    ?>
                                                            <td>
                                                                <a href="profile?manager=<?php echo $tab['id_user']; ?>" class="btn btn-info"><i class="fa fa-user"></i></a>
                                                            </td>
                                                            <td>
                                                                <form action="includes/update" method="post">
                                                                    <input type="hidden" name="to_super" value="<?php echo hash_str($tab['id_user']); ?>">
                                                                    <button class="btn btn-<?php if($tab['is_super']==1) echo "success"; else echo "warning" ?>">
                                                                         <span><i class="fa fa-chevron-<?php if($tab['is_super']==1) echo "up"; else echo "down" ?>"></i></span> 
                                                                    </button>
                                                                </form>
                                                            </td>
                                                            <td>
                                                                <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                                <div class="permission">
                                                                    <div class="permission-content">
                                                                        <p>Sure you want to delete That ?</p>
                                                                        <div class="options">
                                                                            <form action="includes/delete" method="post">
                                                                                <input type="hidden" name="manager" value="<?php echo hash_str($tab['id_user']); ?>">
                                                                                <input type="submit" class="btn btn-success" value="Yes">
                                                                            </form>
                                                                             <a   class="btn btn-warning close-btn" style="position: unset; cursor:pointer">No</a>
                                                                        </div> 
                                                                    </div>
                                                                
                                                                </div>
                                                            </td>
                                                        <?php } ?>
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
                                                <img  src="Files/managers/<?php echo $tab['cin_user']."/".$tab['image_user'] ; ?>" >
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $tab['lname_user'] ; ?></td>
                                        <td><?php echo $tab['fname_user'] ; ?></td>
                                        <td><?php echo $tab['email_user'] ; ?></td>
                                        <td><?php echo $tab['city_user'] ; ?></td>
                                        <?php if(isset($_SESSION['manager']) && $row['is_super']==1){ ?>
                                            <td> 
                                                <table class="child-table"> 
                                                    <tr>
                                                        <?php if($tab['id_user'] != $_SESSION['manager']){    ?>
                                                            <td>
                                                                <a href="profile?manager=<?php echo $tab['id_user']; ?>" class="btn btn-info"><i class="fa fa-user"></i></a>
                                                            </td>
                                                            <td>
                                                                <a href="includes/update?to_super=<?php echo hash_str($tab['id_user']); ?>" class="btn btn-warning"><i class="fa fa-chevron-<?php if($tab['is_super']) echo 'up'; else echo 'down' ?>"></i></a>
                                                            </td>
                                                            <td>
                                                                <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                                <div class="permission">
                                                                    <div class="permission-content">
                                                                        <p>Sure you want to delete That ?</p>
                                                                        <div class="options">
                                                                            <form action="includes/delete" method="post">
                                                                                <input type="hidden" name="manager" value="<?php echo hash_str($tab['id_user']); ?>">
                                                                                <input type="submit" class="btn btn-success" value="Yes">
                                                                            </form>
                                                                             <a   class="btn btn-warning close-btn" style="position: unset; cursor:pointer">No</a>
                                                                        </div> 
                                                                    </div>
                                                                
                                                                </div>
                                                            </td>
                                                        <?php } ?>
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
                                <a href="/admin/managers?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo previous_page($active_page); ?>" class="page-link" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item  <?php if($nbr_pages < $active_page-1 || $active_page == 1) echo "disabled" ?>">
                                <a href="/admin/managers?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page-1; ?>" class="page-link">
                                    <?php echo $active_page-1 ;?>
                                </a>
                            </li>
                            <li class="page-item active <?php if($nbr_pages < $active_page) echo "disabled" ?>">
                                <a href="/admin/managers?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page ; ?>" class="page-link">
                                    <?php echo $active_page;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+1) echo "disabled" ?>">
                                <a href="/admin/managers?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page+1 ; ?>" class="page-link">
                                    <?php echo $active_page+1;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+2) echo "disabled" ?>">
                                <a href="/admin/managers?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo next_page($active_page); ?>" class="page-link" aria-label="Next">
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

    <?php }else{  header('location:/admin/includes/logout');} ?>

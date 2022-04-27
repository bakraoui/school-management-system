<?php
define('TITLE','Student : SMS');
define('SUB_TITLE','Student');
require_once("includes/functions.php");
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
            <div class="row mb-3"> 
                <div class="border btn mr-1">
                    <a href="/admin/students" class="p-2 d-block" >All</a>
                </div>
                <div class="border btn">
                    <a href="/admin/students?add" class="p-2 d-block" >New</a>
                </div>   
            </div>
        </div>

        <div class="mb-5">
            <?php  if(isset($_GET['add']) && empty($_GET['add'])){ ?>
                
                <div class="add">
                    <h4>New student</h4>
                    <div class="d-flex justify-content-center">
                        <form action="includes/insert.php" method="post" enctype="multipart/form-data" class=" col-lg-8 col-md-10 col-sm-12">     
                            <div class="card p-3 mb-3">  
                                <fieldset>
                                    <legend><h5> Personal Information <span class="text-danger">*</span> </h5></legend>
                                    <div class="p-3">
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <input type="text" placeholder="Last Name" id="lname" name="lname" class="form-control" required>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <input type="text" placeholder="First Name " id="fname" name="fname" class="form-control" required>
                                            </div>                                        
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <input type="text" placeholder="CIN" id="cin" name="cin" class="form-control" required>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <input type="text" placeholder="CNE" id="cne" name="cne" class="form-control" required>
                                            </div>                                          
                                        </div>
                                    
                                    </div>
                                </fieldset>
                            </div>
                            <div class="card p-3 mb-3">
                                <fieldset>
                                    <legend> <h5><span><i class="fa fa-plus text-primary pr-3"></i></span>Adress</h5></legend>
                                    <div class="p-3 row">
                                        <div class="form-group col-lg-8">
                                            <label for="adress">Adress</label>
                                            <input type="text" id="adress" name="adress" class="form-control" placeholder="street ...">
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="city">City</label>
                                            <input type="text" id="city" name="city" class="form-control">
                                        </div>                                    
                                    </div>
                                </fieldset>
                            </div>
                            <div class="card p-3 mb-3">
                                <fieldset>
                                    <legend><h5>Login Information <span class="text-danger">*</span></h5></legend>
                                    <div class="p-3 row">
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
                                        <input type="file" id="image" name="image" class="form-control">
                                    </div> 
                                </fieldset>
                            
                            <input type="submit" value="Add Student" name="insert-student" class="form-control bg-primary text-light">
                            
                        </form>                              
                    </div>
            
                </div>
             
            <?php }elseif(isset($_GET['inscrit']) && empty($_GET['inscrit']) 
                    && isset($_GET['nb']) && !empty($_GET['nb']) ){ ?>
                    <div class="add">
                        <h4>Inscription</h4>
                        <div class="d-flex justify-content-center">
                            <form action="includes/insert.php" method="post" enctype="multipart/form-data" class=" col-lg-8 col-md-10 col-sm-12">
                                <?php 
                                        $id_std = unhash_str($_GET['nb']);
                                        $std = mysqli_fetch_assoc(mysqli_query($connect,
                                                    "SELECT * FROM student WHERE id_user ='$id_std' AND is_deleted = 0 "
                                                ));
                                ?>
                                <div class="form-group">
                                    <label for="student">Student</label>
                                    <input type="text" id="student" name="student" 
                                        value="<?php echo $std['fname_user']." ".$std['lname_user']; ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="class">Class</label>
                                    <select name="class" id="class" class="form-control">
                                        <option></option>
                                        <?php 
                                            $query_cls = "SELECT * FROM class  WHERE is_deleted = 0" ;
                                            $result_cls = mysqli_query($connect , $query_cls   );
                                            while( $cls = mysqli_fetch_assoc($result_cls) ) {
                                                $branch =  mysqli_fetch_assoc(mysqli_query($connect , 
                                                    "SELECT * FROM branch WHERE id_branch=".$cls['id_branch']."  AND is_deleted = 0"));
                                        ?>
                                        <option value="<?php echo hash_str($cls['id_class']) ?>">
                                            <?php echo $cls['title_class']." : ".$branch['title_branch']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="session">Session</label>
                                    <select name="session" id="session" class="form-control">
                                        <?php 
                                            $query_sess = "SELECT * FROM session WHERE is_deleted = 0 ORDER BY id_session DESC";
                                            $result_sess = mysqli_query($connect,$query_sess);
                                            $session = mysqli_fetch_assoc($result_sess) ;
                                            ?>
                                            <option value="<?php echo hash_str($session['id_session']) ?>">
                                                <?php echo $session['date_start']." ".$session['date_end']; ?>
                                            </option>
                                    </select>
                                </div>
                                <input type="hidden" name="id" value="<?php echo hash_str($std['id_user']) ?>" >
                                <input type="submit" value="Register" name="insert-inscription" class="form-control bg-primary text-light">
                            
                            </form>                             
                        </div>

               
                    </div>
            <?php }elseif(isset($_GET['pay']) && empty($_GET['pay'])
                            && isset($_GET['nb']) && !empty($_GET['nb'])){ ?>
                        <div class="add">
                            <h4>Payement</h4>
                            <div class="d-flex justify-content-center">
                                <form action="includes/insert" method="post" enctype="multipart/form-data" class=" col-lg-6 col-md-8 col-sm-12">
                                    <?php
                                        $std = mysqli_fetch_assoc(mysqli_query($connect,
                                                "SELECT * FROM student WHERE id_user = ".unhash_str($_GET['nb'])."  AND is_deleted = 0"
                                            ))
                                    ?>
                                    <div class="form-group">
                                        <label for="student">Student</label>
                                        <input type="text" id="student" name="student"
                                            value="<?php echo $std['fname_user']." ".$std['lname_user'] ?>"
                                            class="form-control">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="payed">Payed</label>
                                        <input type="text" id="payed" name="payed" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="still">Still </label>
                                        <input type="text" id="still" name="still" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="date_payment">Payement Date </label>
                                        <select name="date_payment" id="date_payment" class="form-control">
                                            <option value=""></option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">Jully</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo hash_str($std['id_user']); ?>">
                                    <input type="hidden" name="pay">
                                    <input type="submit" value="Confirm Payement" name="insert-payement" class="form-control bg-primary text-light">
                                
                                </form>  
                            </div>
              
                        </div>
            <?php }else{ ?>
                    <?php   
                            if(isset($_GET['class']) && isset($_GET['session'])){
                                $class = $_GET['class'] ;
                                $session = $_GET['session'];
                                $query= "SELECT * FROM student,inscription 
                                        WHERE student.id_user = inscription.id_user
                                        AND student.is_deleted = 0 AND inscription.is_deleted =0
                                        AND inscription.id_class ='$class'
                                        AND inscription.id_session = '$session' ";
                            }
                            elseif(isset($_GET['search']) ){
                                $search = $_GET['search'] ;
                                $query = "SELECT * FROM student
                                            WHERE   is_deleted = 0
                                            AND ( fname_user like '%$search%' 
                                            OR lname_user like '%$search%'
                                            OR email_user like '%$search%'
                                            OR city_user  like '%$search%'
                                            OR cin_user  like '%$search%'
                                            OR cne_student  like '%$search%' ) " ;
                            }else{
                                $query = "SELECT * FROM student  WHERE is_deleted = 0" ;
                            }
                            $result = mysqli_query($connect , $query) ;
                            $total = mysqli_num_rows($result);
                            $total_lines = mysqli_num_rows($result) ;
                            $lines_page = 10 ;
                            $nbr_pages = ceil($total_lines/$lines_page) ;
                        ?>
                <div class="row ">
                    <div class="col-md-5 col-sm-4">
                        <p>Total : <b><?php echo $total ?></b></p>
                    </div>
                    <div class="col-md-7 col-sm-8 ">
                        <div class="row">
                            <div class="mr-1">
                                <button class="popup-modal btn btn-outline btn-outline-secondary">search by class</button>
                                <div class="modal">
                                    <div class="modal-content">
                                        <div class=" close-btn"><i class="fa fa-close"></i></div>
                                        <form  class="mt-5">
                                            <div class="form-group">
                                                <select name="session" id="" class="form-control">
                                                    <?php
                                                        $q = "SELECT * from session WHERE is_deleted = 0";
                                                        $r = mysqli_query($connect , $q);
                                                        while($ar = mysqli_fetch_assoc($r)){
                                                    ?>
                                                        <option value="<?php echo $ar['id_session'] ?>" 
                                                        <?php if(isset($_GET['session'])) if($ar['id_session'] == $_GET['session']) echo "selected" ?>>
                                                            <?php echo $ar['date_start']."-".$ar['date_end'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <select name="class" id="" class="form-control">
                                                    <?php
                                                        $q = "SELECT * from class  WHERE is_deleted = 0";
                                                        $r = mysqli_query($connect , $q);
                                                        while($ar = mysqli_fetch_assoc($r)){
                                                            $br = mysqli_fetch_assoc(mysqli_query($connect, 
                                                            "SELECT * FROM branch WHERE id_branch = ".$ar['id_branch']."  AND is_deleted = 0 "))
                                                    ?>
                                                    <option value="<?php echo $ar['id_class'] ?>"
                                                    <?php if(isset($_GET['class'])) if($ar['id_class'] == $_GET['class']) echo "selected" ?>>
                                                            <?php echo $ar['title_class']."-".$br['title_branch'] ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            
                                            <input type="submit" name='show' value="Search" class="form-control bg-primary text-light">
                                        </form> 
                                    </div>
                                </div>
                            </div>      
                            <div class="">
                                <form action="" method="get">
                                    <div class="form-group">
                                        <?php 
                                            if(isset($_GET['class']) && isset($_GET['session'])){
                                        ?>
                                            <input type="hidden" value="<?php echo hash_str($_GET['class']) ?> " name="class">
                                            <input type="hidden" value="<?php echo hash_str($_GET['session']) ?> " name="session">
                                        <?php } ?>
                                        <input type="search" name="search" id="" class="form-control" placeholder="search">
                                    </div>
                                </form>
                            </div>                             
                        </div>
                       
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
                                <th>CNE </th>
                                <th>CIN</th>
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
                                                    <img  src="Files/students/<?php echo $tab['cin_user']."/".$tab['image_user'] ; ?>" >
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $tab['lname_user'] ; ?></td>
                                            <td><?php echo $tab['fname_user'] ; ?></td>
                                            <td><?php echo $tab['email_user'] ; ?></td>
                                            <td><?php echo $tab['cne_student'] ; ?></td>
                                            <td><?php echo $tab['cin_user'] ; ?></td>
                                            <td> 
                                                <table class="child-table"> 
                                                    <tr> 
                                                        <td>
                                                            <a href="profile?student=<?php echo $tab['id_user']; ?>" class="btn btn-info"><i class="fa fa-user"></i></a>
                                                        </td>
                                                        <td>
                                                            <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                            <div class="permission">
                                                                <div class="permission-content">
                                                                    <p>Sure you want to delete That ?</p>
                                                                    <div class="options">
                                                                        <form action="includes/delete" method="post">
                                                                            <input type="hidden" name="student" value="<?php echo hash_str($tab['id_user']); ?>">
                                                                            <input type="submit" class="btn btn-success" value="Yes">
                                                                        </form>
                                                                        <a   class="btn btn-warning close-btn" style="position: unset; cursor:pointer">No</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <?php 
                                                        $q = mysqli_fetch_assoc(mysqli_query($connect ,
                                                            "SELECT allow_inscription FROM setting"))['allow_inscription'];
                                                        if($q){ ?>
                                                            <td>
                                                                <a href="students?nb=<?php echo hash_str($tab['id_user']); ?>&inscrit" class="btn btn-primary"><i class="fa fa-retweet"></i></a>
                                                            </td>
                                                        <?php } ?>
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
                                        <td><img  src="Files/students/<?php echo $tab['cin_user']."/".$tab['image_user'] ; ?>" ></td>
                                        <td><?php echo $tab['lname_user'] ; ?></td>
                                        <td><?php echo $tab['fname_user'] ; ?></td>
                                        <td><?php echo $tab['email_user'] ; ?></td>
                                        <td><?php echo $tab['cne_student'] ; ?></td>
                                        <td><?php echo $tab['cin_user'] ; ?></td>
                                        <td> 
                                            <table class="child-table"> 
                                                <tr> 
                                                    <td>
                                                        <?php if($tab['image_user']==null){ ?>
                                                            <img  src="Files/Custom/user.png" >
                                                        <?php }else{ ?>
                                                            <img  src="Files/students/<?php echo $tab['cin_user']."/".$tab['image_user'] ; ?>" >
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                        <div class="permission">
                                                            <div class="permission-content">
                                                                <p>Sure you want to delete That ?</p>
                                                                <div class="options">
                                                                    <form action="includes/delete" method="post">
                                                                        <input type="hidden" name="student" value="<?php echo hash_str($tab['id_user']); ?>">
                                                                        <input type="submit" class="btn btn-success" value="Yes">
                                                                    </form>
                                                                    <a   class="btn btn-warning close-btn" style="position: unset; cursor:pointer">No</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <?php 
                                                    $q = mysqli_fetch_assoc(mysqli_query($connect ,
                                                        "SELECT allow_inscription FROM setting"))['allow_inscription'];
                                                    if($q){ ?>
                                                        <td>
                                                            <a href="students?nb=<?php echo $tab['id_user']; ?>&inscrit" class="btn btn-primary"><i class="fa fa-retweet"></i></a>
                                                        </td>
                                                    <?php } ?>
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
                                <a href="/admin/students?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo previous_page($active_page); ?>" class="page-link" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item  <?php if($nbr_pages < $active_page-1 || $active_page == 1) echo "disabled" ?>">
                                <a href="/admin/students?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page-1; ?>" class="page-link">
                                    <?php echo $active_page-1 ;?>
                                </a>
                            </li>
                            <li class="page-item active <?php if($nbr_pages < $active_page) echo "disabled" ?>">
                                <a href="/admin/students?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page ; ?>" class="page-link">
                                    <?php echo $active_page;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+1) echo "disabled" ?>">
                                <a href="/admin/students?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page+1 ; ?>" class="page-link">
                                    <?php echo $active_page+1;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+2) echo "disabled" ?>">
                                <a href="/admin/students?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo next_page($active_page); ?>" class="page-link" aria-label="Next">
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

    
        
                  
 <?php   }else{  header('location:/admin/login');} ?>

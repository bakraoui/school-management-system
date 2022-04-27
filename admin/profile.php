
<?php
define('TITLE','profile : SMS');
define('SUB_TITLE','profile ');
    require_once('../connection.php') ;
    include("includes/functions.php");
    session_start();
    if(isset($_SESSION['user'])){
        $id = $_SESSION['user'] ;
        if(isset($_SESSION['manager'])) $query = "SELECT * FROM manager WHERE id_user = '$id ' AND is_deleted= 0 ";
        if(isset($_SESSION['teacher'])) $query = "SELECT * FROM teacher WHERE id_user = '$id ' AND is_deleted= 0 ";
        if(isset($_SESSION['student'])) $query = "SELECT * FROM student WHERE id_user = '$id ' AND is_deleted= 0 ";
        $result = mysqli_query($connect , $query) ;
        $row = mysqli_fetch_assoc($result) ;
?>
        <?php require_once('includes/header.php'); ?>
        <?php 
            if(!isset($_GET)){
                $tab = $row ;
            }elseif(isset($_SESSION['manager']) && isset($_GET['student']) && !empty($_GET['student'])){
                $id_user = $_GET['student'] ;
                $update = "update-student" ;
                $user = "student";
                $query = mysqli_query($connect ,"SELECT * FROM student WHERE  is_deleted= 0 " );
                if($id_user <= mysqli_num_rows($query) && $id_user !=0) 
                    $query = "SELECT * FROM student WHERE id_user = '$id_user ' AND is_deleted= 0 ";
                else 
                echo "<script> window.location.href='profile' </script>" ;
                
       
            }elseif(isset($_SESSION['manager']) && isset($_GET['teacher']) && !empty($_GET['teacher'])){
                $id_user = $_GET['teacher'] ;
                $update = "update-teacher" ;
                $user = "teacher";
                $query = mysqli_query($connect ,"SELECT * FROM teacher WHERE  is_deleted= 0 " );
                if($id_user <= mysqli_num_rows($query) && $id_user !=0) 
                    $query = "SELECT * FROM teacher WHERE id_user = '$id_user ' AND is_deleted= 0 ";
                else 
                echo "<script> window.location.href='profile' </script>" ;
                
            }elseif(isset($_SESSION['manager']) && isset($_GET['manager']) && $row['is_super']==1 && !empty($_GET['manager'])){
                $id_user = $_GET['manager'] ;
                $update = "update-manager" ;
                $user = "manager";
                $query = mysqli_query($connect ,"SELECT * FROM manager WHERE  is_deleted= 0 " );
                if($id_user <= mysqli_num_rows($query) && $id_user !=0) 
                    $query = "SELECT * FROM manager WHERE id_user = '$id_user ' AND is_deleted= 0 ";
                else 
                echo "<script> window.location.href='profile' </script>" ;
                
            }else{
                $id_user = $id ;
                $tab = $row ;
                if(isset($_SESSION['manager'])) { $update = "update-manager" ; $user = "manager"; } 
                if(isset($_SESSION['teacher'])) { $update = "update-teacher" ; $user = "teacher"; }
                if(isset($_SESSION['student'])) { $update = "update-student" ; $user = "student";}
                
            }

            $result = mysqli_query($connect , $query) ;
            $tab = mysqli_fetch_assoc($result) ;
        ?>
    
        
      
  

       
                <?php if(!isset($_GET['password'])){ ?>
                    <div class="container mb-5">
                        <?php if(!isset($_GET['more'])){ ?>
                            <form action="includes/update" method="post" enctype="multipart/form-data">
                                <div class="card">
                                    <div class="card-header">
                                        <span class="h5"><i class="fa fa-user mr-4"></i>profile</span>
                                    </div>
                                    <div class="card-body">
                                        <h5>Personal Information</h5>
                                        <div class="form-group ">
                                            <label for="lname">Last Name</label>
                                            <input type="text" id="lname" name="lname" class="form-control" value="<?php echo $tab['lname_user']; ?>" required>
                                        </div>
                                        <div class="form-group ">
                                            <label for="fname">First Name</label>
                                            <input type="text" id="fname" name="fname" class="form-control" value="<?php echo $tab['fname_user']; ?>" required>
                                        </div>
                                        <div class="form-group ">
                                            <label for="cin">CIN</label>
                                            <input  type="text" id="cin" name="cin" class="form-control" value="<?php echo $tab['cin_user']; ?>" required>
                                        </div>
                                        <?php if( (isset($_SESSION['manager']) && isset($_GET['student']) && !empty($_GET['student']) ) || isset($_SESSION['student'])){ ?>
                                            <div class="form-group ">
                                                <label for="cne">CNE</label>
                                                <input type="text"  id="cne" name="cne" class="form-control" value="<?php echo $tab['cne_student']; ?>" required>
                                            </div>
                                        <?php } ?>
                                        <div class="form-group ">
                                            <label for="image">Photo</label>
                                            <input type="file"  id="image" name="image" class="form-control" value="<?php echo $tab['image_user']; ?>">
                                        </div>
                                        <h5>Adress </h5>
                                        <div class="form-group ">
                                            <label for="adress">Adress</label>
                                            <input type="text" id="adress" name="adress" class="form-control" placeholder="street ..." value="<?php echo $tab['adress_user']; ?>">
                                        </div>
                                        
                                        <div class="form-group ">
                                            <label for="city">City</label>
                                            <input type="text" id="city" name="city" class="form-control" value="<?php echo $tab['city_user']; ?>">
                                        </div>
                                        <h5>Login Information</h5>
                                        <div class="form-group ">
                                            <label for="email">Email</label>
                                            <input type="text" id="email" name="email" class="form-control" placeholder="exemple@gmail.xyz" value="<?php echo $tab['email_user']; ?>" required>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo hash_str($id_user) ; ?>">
                                    <div class="card-footer space-between">
                                        <input type="submit" 
                                            value="save change" 
                                            name="<?php echo $update ; ?>" 
                                            class="btn btn-success text-light"
                                        >
                                        <a href="profile?<?php 
                                                if(isset($_GET['manager'])) echo "manager=".$_GET['manager'];
                                                elseif(isset($_GET['teacher'])) echo "teacher=".$_GET['teacher'];
                                                elseif(isset($_GET['student'])) echo "student=".$_GET['student'];
                                                ?>&password" class="btn btn-primary">Change Password ?</a>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                <?php }else{ ?>
                    <div class="add">
                        <h4>Change Password</h4>
                        <div class="d-flex justify-content-center">
                            <div class="col-lg-6 col-md-8 col-sm-10">
                                <form action="includes/update.php" method="post">
                                    <div class="form-group">
                                        <label for="new"> New Password</label>
                                        <input type="password" name="new" id="new" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm"> Confirm Password</label>
                                        <input type="password" name="confirm" id="confirm" class="form-control">
                                    </div>
                                    <input type="hidden" name="user" value="<?php echo $user; ?>">
                                    <input type="hidden" name="id" value="<?php echo hash_str($id_user) ?>" > 
                                    <input type="submit" name="change-password" value="Change Password" class="form-control bg-success text-light">
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
        

                <?php if(isset($_GET['student'])){ ?>
                            
                    <?php if(isset($_SESSION['manager'])){ ?>
                        <?php if(isset($_GET['more']) 
                                && isset($_GET['student']) && !empty($_GET['student'])
                                && isset($_GET['s']) && !empty($_GET['s'])){ 
                                $student = mysqli_fetch_assoc(
                                    mysqli_query($connect , "SELECT * FROM student 
                                                WHERE is_deleted = 0 
                                                AND id_user = ".$_GET['student']) 
                                );
                            ?>
                                <div class="card mt-3">
                                    <div class="card-header space-between">
                                        <h3 class="btn btn-outline btn-outline-dark"><span><i class="fa fa-credit-card"></i></span> Payements : <?php 
                                                echo mysqli_fetch_assoc(
                                                        mysqli_query($connect,"SELECT * FROM session
                                                    WHERE id_session = ".$_GET['s']))['date_start']."-"
                                                    .mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM session
                                                    WHERE id_session = ".$_GET['s']))['date_end']
                                            ?> 
                                        </h3>
                                        <?php 
                                            $q = mysqli_fetch_assoc(mysqli_query($connect,
                                                    "SELECT * FROM session WHERE is_deleted = 0
                                                    ORDER BY id_session DESC")) ;
                                            if($q['id_session']== $_GET['s']){
                                        ?>
                                            <?php if(isset($_SESSION['manager'])){ ?>
                                                <a  class="popup-modal btn btn-success">Add Payement</a>
                                                <div class="modal">
                                                    <div class="modal-content">
                                                        <button class="close-btn"><i class="fa fa-close"></i></button>
                                                        <form action="includes/insert.php" method="post" enctype="multipart/form-data">
                                                            <h4>Payement</h4>
                                                            <?php
                                                                $std = mysqli_fetch_assoc(mysqli_query($connect,
                                                                        "SELECT * FROM student WHERE id_user = ".$_GET['student']."  AND is_deleted = 0"
                                                                    ))
                                                            ?>
                                                            <div class="form-group ">
                                                                <label for="student">Student</label>
                                                                <input type="text" id="student" name="student"
                                                                    value="<?php echo $std['fname_user']." ".$std['lname_user'] ?>"
                                                                    class="form-control">
                                                            </div>
                                                            
                                                            <div class="form-group ">
                                                                <label for="payed">Payed</label>
                                                                <input type="text" id="payed" name="payed" class="form-control">
                                                            </div>
                                                            <div class="form-group ">
                                                                <label for="still">Still </label>
                                                                <input type="text" id="still" name="still" class="form-control">
                                                            </div>
                                                            <div class="form-group ">
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
                                                            <input type="hidden" name="s" value="<?php echo hash_str($_GET['s']); ?>">
                                                            <input type="submit" value="Confirm Payement" name="insert-payement" class="form-control bg-primary text-light">
                                                        
                                                        </form>                                               
                                                    </div>
                        
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>

                                    <div class="card-body">
                                        <div class="overflow-x">
                                            <table cellspacing="0" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Month</th>
                                                        <th> sum Payed</th>
                                                        <th>Sum still</th> 
                                                        <th>Payed on</th>
                                                        <th><i class="fa fa-download"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $sess = $_GET['s'] ;
                                                    $std = $_GET['student'];
                                                    $session = mysqli_fetch_assoc(
                                                        mysqli_query($connect,
                                                                "SELECT * FROM session WHERE is_deleted =0 ORDER BY id_session DESC")
                                                    );
                                                    $session_dir = $session['date_start'].'-'.$session['date_end'] ;
                                                    
                                                    $r = mysqli_query($connect,
                                                            "SELECT * FROM payement 
                                                            WHERE id_user = '$std' AND id_session = '$sess'");
                                                        while($tr = mysqli_fetch_assoc($r)){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo get_month($tr['date_payement']); ?></td>
                                                        <td><?php echo $tr['sum_payed']; ?></td>
                                                        <td><?php echo $tr['sum_rest']; ?></td>
                                                        <td><?php if(isset($tr['day_payement'])) echo $tr['day_payement']; ?></td>
                                                        <td><a download href="Files/students/<?php echo $student['cin_user'] ?>/<?php echo $session_dir ?>/payements/<?php echo get_month($tr['date_payement']).'.pdf' ?>"><i class="fa fa-download"></i></a></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer"></div>
                                </div>
                                <?php 
                                    $set = mysqli_fetch_assoc(mysqli_query($connect,
                                            "SELECT * FROM setting
                                            "));
                                ?>
                                    <div class="card mt-5">
                                        <div class="card-header">
                                            <h3 class="btn btn-outline btn-outline-dark">Subjects / Marks : <?php 
                                                echo mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM session
                                                    WHERE id_session = ".$_GET['s']))['date_start']."-"
                                                    .mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM session
                                                    WHERE id_session = ".$_GET['s']))['date_end']
                                                ?> 
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="overflow-x">
                                                <table cellspacing="0" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Subject</th>
                                                            <th>Abs</th>
                                                            <th>Note</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        <?php
                                                            $result_sbj = mysqli_query($connect,
                                                            "SELECT * FROM course , class , inscription 
                                                            WHERE inscription.id_user = '$std' 
                                                            AND inscription.id_session = '$sess'
                                                            AND inscription.id_class = class.id_class
                                                            AND class.id_class = course.id_class
                                                            ");
                                                            while($sub = mysqli_fetch_assoc($result_sbj)){
                                                                $tr_1 = mysqli_fetch_assoc(mysqli_query($connect,
                                                                        "SELECT * FROM mark_subject
                                                                        WHERE is_deleted = 0  
                                                                        AND id_subject = ".$sub['id_subject']." 
                                                                        AND id_user = ".$std));
                                                                $tr_2 = mysqli_query($connect,
                                                                        "SELECT * FROM absence_course
                                                                        WHERE is_deleted = 0 
                                                                        AND id_subject = ".$sub['id_subject']." 
                                                                        AND id_user = ".$std);
                                                                $tr_3 = mysqli_fetch_assoc(mysqli_query($connect,
                                                                        "SELECT * FROM subject
                                                                        WHERE is_deleted = 0 
                                                                        AND id_subject = ".$sub['id_subject'] ));
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $sub['id_subject']; ?></td>
                                                            <td><?php echo $tr_3['title_subject']; ?></td>
                                                            <td><?php echo mysqli_num_rows($tr_2); ?></td>
                                                            <td>
                                                                <?php 
                                                                    if(!empty($tr_1)) echo $tr_1['mark_subject']; 
                                                                    else echo "-";
                                                                    ?>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>                                    
                                            </div>
                                        </div>
                                        <div class="card-footer"></div>
                                    </div>
                        <?php }else{ ?>
                            <div class="card mt-5">
                                <div class="card-header">
                                    <h3 class="btn btn-outline btn-outline-dark">Inscriptions</h3>
                                </div>
                                <div class="card-body">
                                    <div class="overflow-x ">
                                        <table cellspacing="0" class="table ">
                                            <thead class="theade-dark">
                                                <tr>
                                                    <th>Session</th>
                                                    <th>Class</th>
                                                    <th>Note</th>
                                                    <th>Situation</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $inscript = mysqli_query($connect, "SELECT * FROM inscription 
                                                            WHERE  is_deleted = 0  
                                                            AND id_user = '$id_user'  
                                                            ORDER BY id_session DESC"); 
                                                    while($t = mysqli_fetch_assoc($inscript)){
                                                        $tr = mysqli_fetch_assoc(mysqli_query($connect,
                                                                " SELECT * FROM session,class 
                                                                WHERE session.is_deleted = 0 AND class.is_deleted = 0
                                                                AND id_session = ".$t['id_session']." AND id_class=".$t['id_class']." 
                                                            ")) ;
                                                    $note_query = mysqli_query($connect,
                                                            "SELECT * FROM global_mark WHERE is_deleted=0
                                                                AND id_user = '$id_user'
                                                                AND id_session = ".$tr['id_session']) ;
                                                    if(mysqli_num_rows($note_query)){
                                                        $note = mysqli_fetch_assoc($note_query  );
                                                    
                                                        $type = $school_prop['type'] ;
                                                        $global_mark =  $note['global_mark']  ;
                                                        
                                                    }else{
                                                        $global_mark = "-" ;
                                                        
                                                    }
                                                    $status = "" ;
                                                
                                                ?>
                                                    <tr>
                                                        <td><?php echo $tr['date_start']."-".$tr['date_end'] ?></td>
                                                        <td><?php echo $tr['title_class'] ?></td>
                                                        <td><?php echo $global_mark; ?></td>
                                                        <td>
                                                            <?php if(mysqli_num_rows($note_query)){ ?>
                                                                <p><b>
                                                                    <?php 
                                                                        if($type == 1 && $global_mark < 5){
                                                                            $status = "NV";
                                                                        }elseif($type == 1 && $global_mark >= 5){
                                                                            $status = "V";
                                                                        }elseif($type != 1 && $global_mark < 10){
                                                                            $status = "NV";
                                                                        }elseif($type != 1 && $global_mark >= 10){
                                                                            $status = "V";
                                                                        }
                                                                        echo $status ;
                                                                    ?></b>
                                                                </p>
                                                            <?php } ?>
                                                        </td>
                                                        <td><a href="/admin/profile?more&student=<?php echo $_GET['student'] ;?>&s=<?php echo $tr['id_session'] ?>" ><i class="fa fa-plus"></i></a></td>
                                                        
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>                    
                                    </div>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>

    
    <?php require_once('includes/footer.php') ?>
    <?php }else{  header('location:/admin/login');} ?>
 
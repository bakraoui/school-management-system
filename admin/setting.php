<?php
    define('TITLE', 'Setting : SMS');
    define('SUB_TITLE', 'Setting');
    require_once('../connection.php');
    include('includes/functions.php');
    session_start();

    $manager = mysqli_fetch_assoc(mysqli_query(
            $connect,
            "SELECT * FROM manager WHERE id_user = " . $_SESSION['manager']
    ));

    if (isset($_SESSION['user']) && isset($_SESSION['manager']) && $manager['is_super'] == 1) {
        $id = $_SESSION['user'];
        $query = "SELECT * FROM manager WHERE id_user = '$id' AND is_deleted = 0 ";
        $result = mysqli_query($connect, $query);
        $row = mysqli_fetch_assoc($result);
     ?>

        <?php require_once('includes/header.php') ?>
        <?php
            $setting = mysqli_fetch_assoc(mysqli_query($connect,
                        "SELECT * FROM setting")) ;
        ?>
        <div class="container mb-4">
            <?php  if (isset($_GET['deleted-data'])) {  ?>
                <div class="container mb-5">
                    <div class="row flex-row-reverse">
                        <div class="col-lg-3 col-md-4 mb-5">
                            <div class="card row">
                                <ul class="nav flex-column ">
                                    <li class="nav-item">
                                        <a href="setting?deleted-data&managers" class="nav-link"> Managers</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="setting?deleted-data&teachers" class="nav-link"> Teachers</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="setting?deleted-data&students" class="nav-link"> Students</a>
                                    </li>
                                
                                
                                    <li class="nav-item">
                                        <a href="setting?deleted-data&subjects" class="nav-link">Deleted Subjects</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="setting?deleted-data&branches" class="nav-link">Deleted Branches</a>
                                    </li>
                                
                               
                                    <li class="nav-item ">
                                        <a href="setting?deleted-data&sessions" class="nav-link">Deleted Sessions</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="setting?deleted-data&semesters" class="nav-link">Deleted Semester</a>
                                    </li>
                               
                              
                                    <li class="nav-item">
                                        <a href="setting?deleted-data&classrooms" class="nav-link">Deleted Classrooms</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="setting?deleted-data&classes" class="nav-link">Deleted Classes</a>
                                    </li>
                              
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 ">
                            <?php if (isset($_GET['managers']) && empty($_GET['managers'])) { ?>
                                    
                                <p class="h5 mb-3">Deleted Managers</p>
                                <div class="overflow-x shadow">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>F.Name</th>
                                                <th>L.Name</th>
                                                <th>CIN</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $q = mysqli_query($connect,
                                                        "SELECT * FROM manager WHERE is_deleted = 1");
                                                while ($manager = mysqli_fetch_assoc($q)) {
                                            ?>
                                                
                                                <tr>
                                                    <td><?php echo $manager['fname_user'] ; ?></td>
                                                    <td><?php echo $manager['lname_user'] ; ?></td>
                                                    <td><?php echo $manager['cin_user'] ; ?></td>
                                                    <td>
                                                        <form action="includes/back" method="post">
                                                            <input type="hidden" name="mg" value="<?php echo hash_str($manager['id_user']) ?>">
                                                            <button class="btn btn-success" type="submit">retrieve</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } elseif (isset($_GET['teachers']) && empty($_GET['teachers'])) { ?>
                                    
                                    <p class="h5 mb-3">Deleted Teachers</p>
                                    <div class="overflow-x shadow">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>F.Name</th>
                                                    <th>L.Name</th>
                                                    <th>CIN</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $q = mysqli_query($connect,
                                                            "SELECT * FROM teacher WHERE is_deleted = 1");
                                                    while ($teacher = mysqli_fetch_assoc($q)) {
                                                ?>
                                                    
                                                    <tr>
                                                        <td><?php echo $teacher['fname_user'] ; ?></td>
                                                        <td><?php echo $teacher['lname_user'] ; ?></td>
                                                        <td><?php echo $teacher['cin_user'] ; ?></td>
                                                        <td>
                                                            <form action="includes/back" method="post">
                                                                <input type="hidden" name="tr" value="<?php echo hash_str($teacher['id_user']) ?>">
                                                                <button class="btn btn-success" type="submit">retrieve</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>

                            <?php } elseif (isset($_GET['students']) && empty($_GET['students'])) { ?>
                                <p class="h5 mb-3">Deleted Students</p>
                                <div class="overflow-x shadow">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>F.Name</th>
                                                <th>L.Name</th>
                                                <th>CIN</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $q = mysqli_query($connect,
                                                        "SELECT * FROM student WHERE is_deleted = 1");
                                                while ($student = mysqli_fetch_assoc($q)) {
                                            ?>
                                                
                                                <tr>
                                                    <td><?php echo $student['fname_user'] ; ?></td>
                                                    <td><?php echo $student['lname_user'] ; ?></td>
                                                    <td><?php echo $student['cin_user'] ; ?></td>
                                                    <td>
                                                        <form action="includes/back" method="post">
                                                            <input type="hidden" name="st" value="<?php echo hash_str($student['id_user']) ?>">
                                                            <button class="btn btn-success" type="submit">retrieve</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php }elseif (isset($_GET['subjects']) && empty($_GET['subjects'])) { ?>
                                    <div class="row">
                                        <div class="col">
                                            <p class="h4">Deleted Subjects</p>
                                            <div class="overflow-x shadow">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td>#</td>
                                                            <td>subject</td>
                                                            <td>Action</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $q = mysqli_query($connect,
                                                                    "SELECT * FROM subject WHERE is_deleted = 1");
                                                            $i = 1 ;
                                                            while ($subject = mysqli_fetch_assoc($q)) {
                                                        ?>
                                                            <tr>
                                                                
                                                                <td><?php echo $i ; $i++ ; ?></td>
                                                                <td><?php echo $subject['title_subject'] ; ?></td>
                                                                <td>
                                                                    <form action="includes/back" method="post">
                                                                        <input type="hidden" name="sb" value="<?php echo hash_str($subject['id_subject']) ?>">
                                                                        <button class="btn btn-success" type="submit">retrieve</button>
                                                                    </form>
                                                                </td>
                                                                
                                                                
                                                            </tr>
                                                            <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                            <?php } elseif (isset($_GET['classrooms']) && empty($_GET['classrooms'])) { ?>
                                    <div class="row">
                                        <div class="col">
                                            <p class="h5">Deleted Classrooms</p>
                                            <div class="overflow-x shadow">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td>#</td>
                                                            <td>Classroom</td>
                                                            <td>Action</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $q = mysqli_query($connect,
                                                                    "SELECT * FROM classroom WHERE is_deleted = 1");
                                                            $i=1;
                                                            while ($classroom = mysqli_fetch_assoc($q)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $i ; $i++ ; ?></td>
                                                                <td><?php echo $classroom['title_classroom'] ; ?></td>
                                                                <td>
                                                                    <form action="includes/back" method="post">
                                                                        <input type="hidden" name="cr" value="<?php echo hash_str($classroom['id_classroom']) ?>">
                                                                        <button class="btn btn-success" type="submit">retrieve</button>
                                                                    </form>
                                                                </td>
                                                                
                                                                
                                                            </tr>
                                                            <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>                                
                                    </div>
                            <?php } elseif (isset($_GET['classes']) && empty($_GET['classes'])) { ?>
                               
                                    <p class="h54">Deleted Classes</p>
                                    <div class="overflow-x shadow">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <td>#</td>
                                                    <td>class</td>
                                                    <td>Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $q = mysqli_query($connect,
                                                            "SELECT * FROM class WHERE is_deleted = 1");
                                                    $i = 1 ;
                                                    while ($class = mysqli_fetch_assoc($q)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $i ; $i++ ; ?></td>
                                                        <td><?php echo $class['title_class'] ; ?></td>
                                                        <td>
                                                            <form action="includes/back" method="post">
                                                                <input type="hidden" name="cl" value="<?php echo hash_str($class['id_class']) ?>">
                                                                <button class="btn btn-success" type="submit">retrieve</button>
                                                            </form>
                                                        </td>
                                                        
                                                        
                                                    </tr>
                                                    <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                            <?php } elseif (isset($_GET['sessions']) && empty($_GET['sessions'])) { ?>
                              
                                    <p class="h5">Deleted Sessions</p>
                                    <div class="overflow-x shadow">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <td>#</td>
                                                    <td>session</td>
                                                    <td>Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $q = mysqli_query($connect,
                                                            "SELECT * FROM session WHERE is_deleted = 1");
                                                    $i = 1 ;
                                                    while ($session = mysqli_fetch_assoc($q)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $i ; $i++ ; ?></td>
                                                        <td><?php echo $session['date_start']."-".$session['date_end'] ; ?></td>
                                                        <td>
                                                            <form action="includes/back" method="post">
                                                                <input type="hidden" name="se" value="<?php echo hash_str($session['id_session']) ?>">
                                                                <button class="btn btn-success" type="submit">retrieve</button>
                                                            </form>
                                                        </td>
                                                        
                                                        
                                                    </tr>
                                                    <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                            <?php } elseif (isset($_GET['semesters']) && empty($_GET['semesters'])) { ?>
                             
                                    <p class="h4">Deleted Semesters</p>
                                    <div class="overflow-x shadow">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <td>#</td>
                                                    <td>semester</td>
                                                    <td>Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $q = mysqli_query($connect,
                                                            "SELECT * FROM semester WHERE is_deleted = 1");
                                                    $i = 1 ;
                                                    while ($semester = mysqli_fetch_assoc($q)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $i ; $i++ ; ?></td>
                                                        <td><?php echo $semester['title_semester'] ; ?></td>
                                                        <td>
                                                            <form action="includes/back" method="post">
                                                                <input type="hidden" name="sm" value="<?php echo hash_str($semester['id_semester']) ?>">
                                                                <button class="btn btn-success" type="submit">retrieve</button>
                                                            </form>
                                                        </td>
                                                        
                                                        
                                                    </tr>
                                                    <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                            <?php } elseif (isset($_GET['branches']) && empty($_GET['branches'])) { ?>
                                
                                        <p class="h5">Deleted Branches</p>
                                        <div class="overflow-x shadow">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td>#</td>
                                                        <td>branch</td>
                                                        <td>Action</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $q = mysqli_query($connect,
                                                                "SELECT * FROM branch WHERE is_deleted = 1");
                                                        $i = 1 ;
                                                        while ($branch = mysqli_fetch_assoc($q)) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i ; $i++ ; ?></td>
                                                            <td><?php echo $branch['title_branch'] ; ?></td>
                                                            <td>
                                                                <form action="includes/back" method="post">
                                                                    <input type="hidden" name="br" value="<?php echo hash_str($branch['id_branch']) ?>">
                                                                    <button class="btn btn-success" type="submit">retrieve</button>
                                                                </form>
                                                            </td>
                                                            
                                                            
                                                        </tr>
                                                        <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                            
                            <?php }else{ ?>
                                <p class="h4">
                                    Deleted Data
                                </p>
                                <p class="text-center p-4">
                                    Hello, Here you can see all deleted Accounts, 
                                    Managers, Teachers, Students. To see it you can serf using the right Navbar.
                                    you can also retrieve All deleted data from this page .
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php }elseif(isset($_GET['marks-setting'])) { ?>
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-lg-3" >
                        <div class="card">
                            <div class="card-body">
                                <p> Allow teachers To insert marks </p>
                            </div>
                            <div class="card-footer">
                                <form action="includes/update" method="post">
                                    <input type="submit" 
                                            name="<?php 
                                                if($setting['allow_insert_marks']==0) echo "allow-insert-marks";
                                                else echo "prevent-insert-marks";
                                                ?>" 
                                            class="btn <?php 
                                                    if($setting['allow_insert_marks']==0) echo "btn-success";
                                                    else echo "btn-primary";
                                                ?>" 
                                            value="<?php 
                                                    if($setting['allow_insert_marks']==0) echo "Allow";
                                                    else echo "Prevent";
                                                ?>">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3" >
                        <div class="card">
                            <div class="card-body">
                                <p> Allow Students To Show marks </p>
                            </div>
                            <div class="card-footer">
                                <form action="includes/update" method="post">
                                    <input type="submit" 
                                            name="<?php 
                                                if($setting['allow_showing_marks']==0) echo "allow-show-marks";
                                                else echo "prevent-show-marks";
                                                ?>" 
                                            class="btn <?php 
                                                    if($setting['allow_showing_marks']==0) echo "btn-success";
                                                    else echo "btn-primary";
                                                ?>" 
                                            value="<?php 
                                                    if($setting['allow_showing_marks']==0) echo "Allow";
                                                    else echo "Prevent";
                                                ?>">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3" >
                        <div class="card">
                            <div class="card-body">
                                <p>  marks for the current Semester  </p>
                            </div>
                            <div class="card-footer">
                                <a href="/admin/setting.php?marks-setting&semester-marks" class="btn btn-success"> Generate</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3" >
                        <div class="card">
                            <div class="card-body">
                                <p>  marks for the current session </p>
                            </div>
                            <div class="card-footer">
                                <a href="/admin/setting.php?marks-setting&session-marks"  class="btn btn-success"> Generate </a>
                            </div>
                        </div>
                    </div>
                </div>  
                <?php 
                    $query_session = mysqli_query($connect,"SELECT id_session FROM session 
                                            WHERE is_deleted=0
                                            ORDER BY id_session DESC") ;
                    
                    if(mysqli_num_rows($query_session)){
                        $current_session= mysqli_fetch_assoc($query_session )['id_session'];
                        
                        $classes = mysqli_query($connect,
                                "SELECT * FROM class,inscription
                                WHERE class.is_deleted=0 AND  inscription.is_deleted=0
                                AND inscription.id_class = class.id_class
                                AND inscription.id_session = '$current_session'
                                GROUP BY class.id_class") ;
                ?>
                    <div class="container mt-4">
                        <div class="overflow-x">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>class</td>
                                        <td>action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i=0;
                                        if(mysqli_num_rows($classes)){
                                        while($class = mysqli_fetch_assoc($classes)){
                                            $id_class = $class['id_class'] ;
                                            $i++;
                                    ?>
                                        <tr>
                                            <td><?php echo $i ; ?></td>
                                            <td><?php echo $class['title_class'] ; ?></td>
                                            <td>
                                                <form action="includes/insert.php" method="post">
                                                    <input type="hidden" name="class" value="<?php echo $class['id_class'] ?>">
                                                    <?php if(isset($_GET['semester-marks'])) {
                                                        $current_session=mysqli_query(
                                                            $connect,
                                                            "SELECT * FROM session WHERE is_deleted=0
                                                                ORDER BY id_session DESC"
                                                        );
                                                        $current_session = mysqli_fetch_assoc($current_session)['id_session'] ;
                                                        $current_semester=mysqli_query(
                                                            $connect,
                                                            "SELECT * FROM semester WHERE is_deleted=0
                                                                ORDER BY id_semester DESC"
                                                        );
                                                        $current_semester = mysqli_fetch_assoc($current_semester)['id_semester'] ;
                                                        $resultat = mysqli_query(
                                                            $connect ,
                                                            "SELECT * FROM mark_semester WHERE is_deleted=0
                                                             AND id_semester ='$current_semester'
                                                             AND id_user IN (
                                                                 SELECT id_user FROM inscription WHERE is_deleted=0
                                                                 AND id_semester = '$current_semester' AND id_class = '$id_class' )
                                                             "
                                                        )
                                                        ?>
                                                        <input type="submit" 
                                                               name="marks-semester" 
                                                               class="btn <?php if(mysqli_num_rows($resultat)) echo 'btn-primary'; else echo 'btn-dark'; ?>"
                                                               value="Semester">
                                                    <?php }elseif(isset($_GET['session-marks'])){ ?>
                                                        <input  type="submit" 
                                                                name="marks-session" 
                                                                class="btn btn-info"
                                                                value="Session">
                                                    <?php } ?>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php } ?>  
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php }else{
                    echo "<h3 class='mt-4'>There is no opened session Now </h3>" ;
                } ?>
            <?php }elseif(isset($_GET['inscription'])) { ?>
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-lg-3" >
                        <div class="card">
                            <div class="card-body">
                                <p> Allow Inscription </p>
                            </div>
                            <div class="card-footer">
                                <form action="includes/update" method="post">
                                    <input 
                                        type="submit" 
                                        name="<?php 
                                            if($setting['allow_inscription']==0) echo "allow-inscription";
                                            else echo "prevent-inscription";
                                            ?>" 
                                        class="btn <?php 
                                                if($setting['allow_inscription']==0) echo "btn-success";
                                                else echo "btn-primary";
                                            ?>" 
                                        value="<?php 
                                                if($setting['allow_inscription']==0) echo "Allow";
                                                else echo "Prevent";
                                            ?>"
                                    >
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            <?php }elseif(isset($_GET['school'])) { ?>

                <?php
                    $q = mysqli_query($connect,
                            "SELECT * FROM school");  
                    $num = mysqli_num_rows($q);
                    $school = mysqli_fetch_assoc($q);
                ?>
                    <div class="card p-3">
                        <div class="d-flex justify-content-center">
                            <form action="includes/<?php 
                                    if($num ==1) echo 'update'; else echo 'insert';
                                ?>.php" method="POST" enctype="multipart/form-data" class=" col-lg-8 col-md-10 col-sm-12">
                                <div class="form-group ">
                                    <label for="name">School Name <span class="text-danger">*</span></label>
                                    <?php if($num == 1){ ?>
                                        <input type="text" value="<?php echo $school['name']; ?>" name="name" class="form-control" required>
                                    <?php }else{ ?>
                                        <input type="text"name="name" class="form-control">
                                    <?php } ?>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        <label for="city">City <span class="text-danger">*</span></label>
                                        <?php if($num==1){ ?>
                                            <input type="text" value="<?php echo $school['city'] ?>" name="city" class="form-control" required>
                                        <?php }else{ ?>
                                            <input type="text" name="city" class="form-control">
                                        <?php } ?>
                                    </div>
                                    <div class="form-group col-lg-8">
                                        <label for="adress">Adress <span class="text-danger">*</span></label>
                                        <?php if($num==1){ ?>
                                            <input type="text" value="<?php echo $school['adress'] ?>" name="adress" class="form-control" required>
                                        <?php }else{ ?>
                                            <input type="text" name="adress" class="form-control">
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="type">Type <span class="text-danger">*</span></label>
                                    <select name="type" id="" class="form-control" <?php if($num==1 ) echo "disabled "; ?> required>
                                        <option ></option>
                                        <option value="1" <?php if($num==1 && $school['type'] ==1 ) echo "selected "; ?>>Primary</option>
                                        <option value="2" <?php if($num==1 && $school['type'] ==2 ) echo "selected"; ?>>College</option>
                                        <option value="3" <?php if($num==1 && $school['type'] ==3 ) echo "selected"; ?>>Hight</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <?php if($num==1){ ?>
                                        <input type="text"  value="<?php echo $school['email'] ?>" name="email" class="form-control" required>
                                    <?php }else{ ?>
                                        <input type="text" name="email" class="form-control">
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="tele">Phone  <span class="text-danger">*</span></label>
                                    <?php if($num==1){ ?>
                                        <input type="text" value="<?php echo $school['tele'] ?>" name="tele" class="form-control" required>
                                    <?php }else{ ?>
                                        <input type="text" name="tele" class="form-control">
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" name="logo" class="form-control">
                                </div>
                                <?php if($num==1){ ?>
                                    <input type="hidden" name="id" value="<?php echo $school['id_school'] ?>">
                                    <input type="submit" name="update-school" value="Update your school" class="form-control bg-success mt-5 mb-5 text-light">
                                <?php }else{ ?>
                                    <input type="submit" name="build-school" value="Build school infos" class="form-control bg-success mt-5 mb-5 text-light">
                                <?php } ?>
                            </form>
                        </div>
                    </div>
            <?php }elseif(isset($_GET['front-end'])) { ?>
                <div class="front-end">
                    <?php
                        $q = mysqli_query($connect,
                                "SELECT * FROM school");  
                        $num = mysqli_num_rows($q);
                        $school = mysqli_fetch_assoc($q);
                    ?>
                    
                    <div class="container">
                        <div class="row d-flex  flex-row-reverse ">
                            <div class="col-lg-3  col-md-4">
                                <div class="card p-3 h-100">
                                    <div class="menu">
                                        <a href="setting?front-end&about">About us</a>
                                        <a href="setting?front-end&social-media">Social media</a>
                                        <a href="setting?front-end&director">director word</a>
                                        <a href="setting?front-end&internal-low">Internal Low</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-8">
                                <?php if($num == 1){ ?>
                                    <?php if(isset($_GET['about'])){ ?>
                                            <div class="card p-3">
                                                <form  action="includes/insert.php" method="post">
                                                    <div class="form-group">
                                                        <label for="about" class="h4 p-3"> About Us Page</label>
                                                        <textarea  class=" form-control" name="description" id="description" cols="20" rows=""  ><?php 
                                                            if(isset($school_prop['about'])) echo $school_prop['about'] ;
                                                        ?></textarea>
                                                    </div>
                                                    <input type="submit" name="about" value="Add" class="form-control">
                                                </form>                            
                                            </div>

                                    <?php }elseif(isset($_GET['social-media'])){ ?>
                                                <div class="card p-3">
                                                    <form  action="includes/insert.php" method="post">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="facebook"> Facebook</label>
                                                                    <input type="url" name="facebook" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="twitter"> Twitter</label>
                                                                    <input type="url" name="twitter" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="instagram"> Instagram</label>
                                                                    <input type="url" name="instagram" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="linkedin"> Linkedin</label>
                                                                    <input type="url" name="linkedin" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="submit" name="social-media" value="Add" class="form-control">
                                                    </form>                                
                                                </div>
                                    <?php }elseif(isset($_GET['director'])){ ?>
                                            <div class="card p-3">
                                                <form  action="includes/insert.php" method="post">
                                                    <div class="form-group">
                                                        <label for="word" class="h4 p-3"> Director</label>
                                                        <textarea  class=" form-control" name="description" id="description" cols="20" rows=""  ><?php 
                                                            if(isset($school_prop['director'])) echo $school_prop['director'] ;
                                                        ?></textarea>
                                                    </div>
                                                    <input type="submit" name="director" value="Add" class="form-control">
                                                </form>                            
                                            </div>
                                    <?php }elseif(isset($_GET['internal-low'])){ ?>
                                            <div class="card p-3">
                                                <form  action="includes/insert.php" method="post">
                                                    <div class="form-group">
                                                        <label for="low" class="h4 p-3"> Internal Low</label>
                                                        <textarea  class=" form-control" name="description" id="description" cols="20" rows=""  ><?php 
                                                            if(isset($school_prop['low'])) echo $school_prop['low'] ;
                                                        ?></textarea>
                                                    </div>
                                                    <input type="submit" name="internal-low" value="Add" class="form-control">
                                                </form>                            
                                            </div>

                                    <?php }else{?>
                                            <p class="text-center p-2">
                                                In this Interface You can Create and edit the Public Interface Content.
                                            </p>
                                    <?php }?>

                                <?php }?>
                            </div>
                        </div>
                    </div> 
                    
                </div>
            <?php }else { ?>
                <p class="text-center p-4">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Hic dolorem aliquam, deserunt quam enim maxime quisquam labore id architecto nobis rerum perferendis facere. Blanditiis neque, reiciendis sed asperiores ut cupiditate.
                </p>
                <p class="text-center p-4">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Hic dolorem aliquam, deserunt quam enim maxime quisquam labore id architecto nobis rerum perferendis facere. Blanditiis neque, reiciendis sed asperiores ut cupiditate.
                </p>
                <p class="text-center p-4">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Hic dolorem aliquam, deserunt quam enim maxime quisquam labore id architecto nobis rerum perferendis facere. Blanditiis neque, reiciendis sed asperiores ut cupiditate.
                </p>
                <p class="text-center p-4">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Hic dolorem aliquam, deserunt quam enim maxime quisquam labore id architecto nobis rerum perferendis facere. Blanditiis neque, reiciendis sed asperiores ut cupiditate.
                </p>
            <?php } ?>
        </div>


                        


        <?php require_once('includes/footer.php') ?>

<?php } else {
        header('location:/admin/login');
} ?>
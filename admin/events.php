<?php
define('SUB_TITLE','Events');
define('TITLE','Events : SMS');
    require_once('../connection.php') ;
    require_once('includes/functions.php') ;
    session_start();
    if(isset($_SESSION['user']) && isset($_SESSION['manager'])){
        $id = $_SESSION['user'] ;
        $query = "SELECT * FROM manager WHERE id_user = '$id ' AND is_deleted = 0 ";
        
        $result = mysqli_query($connect , $query) ;
        $row = mysqli_fetch_assoc($result) ;
?>

        <?php require_once('includes/header.php') ?>
      

     
        <div class="container mb-4">
            <div class="row d-flex justify-content-space-between"> 
                <div class="col d-flex mb-2">
                    <div class="btn border mr-1">
                        <a href="/admin/events" class="p-2 d-block">All</a>
                    </div>
                    <div class="btn border ">
                        <a href="/admin/events?add" class="p-2 d-block ">New</a>
                    </div>
                </div>     

            </div>
        </div>

        <div class="container mb-5">
            <?php  if(isset($_GET['add'])){ ?>
                    <div class="add">
                        <h4 >New Event</h4>
                        <div class="card p-3">
                            <div class="d-flex justify-content-center">
                                <form action="includes/insert" method="post" class=" col-lg-8 col-md-10 col-sm-12" enctype="multipart/form-data">                           
                                    <div class="form-group">
                                        <label for="title">Event Title <span class="text-danger">*</span> </label>
                                        <input type="text" id="title" name="title" class="form-control"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Event date <span class="text-danger">*</span> </label>
                                        <input type="date" id="date" name="date" class="form-control"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="time">Event Time <span class="text-danger">*</span> </label>
                                        <input type="time" id="time" name="time" class="form-control"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="locate">Event Location <span class="text-danger">*</span> </label>
                                        <input type="text" id="locate" name="locate" class="form-control"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description <span class="text-danger">*</span> </label>
                                        <textarea id="description" name="description" class="form-control"> </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Thumbnail</label>
                                        <input type="file" name="image" id="image" class="form-control">
                                    </div>
                                    <input type="submit" value="Add Event" name="insert-event" class="form-control bg-primary text-light">
                                </form>                                          
                            </div>  
                        </div>             
                    </div>              
            <?php }elseif(isset($_GET['event']) && !empty($_GET['event'])
                        && isset($_GET['edit']) && empty($_GET['edit'])){
                        $id_event = unhash_str($_GET['event']) ;
                        $r = mysqli_query($connect,"SELECT * FROM events");
                        
                            $query_event = "SELECT * FROM  events WHERE id_event = '$id_event' AND is_deleted = 0 ";
                            $result_event = mysqli_query($connect , $query_event);
                            $arr_event = mysqli_fetch_assoc($result_event) ;     
                            if(mysqli_num_rows($result_event) > 0){           
                ?>

                            <div class="add">
                                <h4>Update Event</h4>
                                <div class="card p-3">
                                    <div class="d-flex justify-content-center">
                                        <form action="includes/update?" method="post" class=" col-lg-6 col-md-8 col-sm-12" enctype="multipart/form-data">                           
                                            <div class="form-group">
                                                <label for="title">Event Title <span class="text-danger">*</span> </label>
                                                <input type="text" id="title" name="title" class="form-control" 
                                                        value="<?php echo $arr_event['event_title']; ?>"
                                                    >
                                            </div>
                                            <div class="form-group">
                                                <label for="date">Event date <span class="text-danger">*</span> </label>
                                                <input type="date" id="date" name="date" class="form-control" 
                                                        value="<?php echo $arr_event['event_date']; ?>"
                                                    >
                                            </div>
                                            <div class="form-group">
                                                <label for="time">Event Time <span class="text-danger">*</span> </label>
                                                <input type="time" id="time" name="time" class="form-control" 
                                                        value="<?php echo $arr_event['event_time']; ?>"
                                                    >
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description <span class="text-danger">*</span> </label>
                                                <textarea id="description" name="description" class="form-control"><?php echo $arr_event['description']; ?> </textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="location">Location <span class="text-danger">*</span> </label>
                                                <textarea id="location" name="location" class="form-control"><?php echo $arr_event['event_location']; ?> </textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="image">Thumbnail  </label>
                                                <input type="file" name="image" id="image" class="form-control" value="<?php echo $arr_event['event_image']; ?>"> 
                                            </div>
                                            <input type="hidden" name="event" value="<?php echo hash_str($arr_event['id_event']); ?>">
                                            <input type="submit" value="Update Event" name="update-event" class="form-control bg-primary text-light">
                                        </form>                                          
                                    </div>
                                </div>
            
                            </div>
                        <?php }else include('error404.php') ; ?>

            <?php }else{ ?>
                <?php   
                    if(isset($_GET['search']) && !empty($_GET['search']) ){
                        $search = $_GET['search'] ;
                        $query = "SELECT * FROM events
                                    WHERE title_event like '%$search%' AND is_deleted = 0 " ;
                    }else{
                        $query = "SELECT * FROM events WHERE is_deleted = 0 " ;
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
                    <div class=" col-md-6 col-sm-8">
                        <form action="" method="get">
                            <div class="form-group">
                                <input type="search" name="search" class="form-control" placeholder="search">
                            </div>
                        </form>
                    </div>
                </div>                 

                <div class="overflow-x">
                    <table cellspacing="0" class="table table-striped shadow">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Event</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <?php if(mysqli_num_rows($result) >0){ ?>
                            <tbody>
                                <?php  
                                    if(!isset($_GET['page'])){
                                        $cp =0 ;
                                        $i =1 ;
                                        while($tab = mysqli_fetch_assoc($result) ){
                                                if($cp <  $lines_page ){
                                                ?>
                                                <tr>
                                                    <td><?php echo $i ; $i++ ; ?></td>
                                                    <td><?php echo $tab['event_title'] ; ?></td>
                                                    <td>
                                                        <table class="child-table"> 
                                                            <tr>
                                                                <td> 
                                                                    <a href="events?event=<?php echo hash_str($tab['id_event']); ?>&edit" class="btn btn-info"> <i class="fa fa-refresh"></i></a>
                                                                </td>
                                                                <td>
                                                                    <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                                    <div class="permission">
                                                                        <div class="permission-content">
                                                                            <p>Sure you want to delete That ?</p>
                                                                            <div class="options">
                                                                                <form action="includes/delete" method="post">
                                                                                    <input type="hidden" name="event" value="<?php echo hash_str($tab['id_event']); ?>">
                                                                                    <input type="submit" class="btn btn-success" value="Yes">
                                                                                </form>
                                                                                <a   class="close-btn btn btn-warning" style="position: unset; cursor:pointer">No</a>
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
                                                <td><?php echo $tab['event_title'] ; ?></td>
                                                <td>
                                                    <table class="child-table"> 
                                                        <tr>
                                                            <td> 
                                                                <a href="events?event=<?php echo hash_str($tab['id_event']); ?>&edit" class="btn btn-info"> <i class="fa fa-refresh"></i></a>
                                                            </td>
                                                            <td>
                                                                <a  class="popup-modal btn btn-danger"><i class="fa fa-trash"></i></a>
                                                                <div class="permission">
                                                                    <div class="permission-content">
                                                                        <p>Sure you want to delete That ?</p>
                                                                        <div class="options">
                                                                            <form action="includes/delete" method="post">
                                                                                <input type="hidden" name="event" value="<?php echo hash_str($tab['id_event']); ?>">
                                                                                <input type="submit" class="btn btn-success" value="Yes">
                                                                            </form>
                                                                            <a   class="close-btn btn btn-warning" style="position: unset; cursor:pointer">No</a>
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
                        <?php } ?>
                    </table>                    
                </div>

                <?php 
                    if( $nbr_pages >1 ){
                        if(isset($_GET['page'])) $active_page = $_GET['page'] ;
                        else $active_page = 1
                ?>
                    <nav  aria-label="Page pagination example">
                        <ul class="pagination">
                            <li class="page-item  <?php if( $active_page == 1) echo "disabled" ?>">
                                <a href="/admin/events?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo previous_page($active_page); ?>" class="page-link" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item  <?php if($nbr_pages < $active_page-1 || $active_page == 1) echo "disabled" ?>">
                                <a href="/admin/events?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page-1; ?>" class="page-link">
                                    <?php echo $active_page-1 ;?>
                                </a>
                            </li>
                            <li class="page-item active <?php if($nbr_pages < $active_page) echo "disabled" ?>">
                                <a href="/admin/events?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page ; ?>" class="page-link">
                                    <?php echo $active_page;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+1) echo "disabled" ?>">
                                <a href="/admin/events?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo $active_page+1 ; ?>" class="page-link">
                                    <?php echo $active_page+1;?>
                                </a>
                            </li>
                            <li class="page-item <?php if($nbr_pages < $active_page+2) echo "disabled" ?>">
                                <a href="/admin/events?<?php if(isset($_GET['search'])) echo "search=".$_GET['search']."&"; ?>page=<?php echo next_page($active_page); ?>" class="page-link" aria-label="Next">
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
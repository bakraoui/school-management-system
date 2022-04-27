<?php define('TITLE', 'Events'); ?>
<?php require_once('../connection.php') ;?> 
<?php require_once('../inc/header.php') ;?> 


<?php if(isset($_GET['event'])){?>
    <?php
        $event = $_GET['event'] ;
        $event = mysqli_fetch_assoc(
            mysqli_query(
                $connect,
                "SELECT * FROM events WHERE is_deleted=0
                 AND id_event = '$event' "
            )
        )
    ?>
    <div class=" about-event container">
        <div class="row">
            <div class="img">
                <?php  if($event['event_image'] != null){ ?>
                    <img  src="../admin/Files/events/<?php echo $event['event_image'] ?>" alt="">
                <?php }else{?>
                    <img  src="/images/event.jpg" alt="">
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="h4"><?php echo $event['event_title'] ?></p>
                <small><?php echo $event['event_location'] ?></small>
                <small><?php echo $event['event_date'] ?></small>
            </div>
        </div>
        <div class="row description">
            <div class="col">
                <div class="text">
                    <?php echo $event['description'] ?>
                </div>
            </div>
        </div>
    </div>
<?php }else{ ?>
    <div class="container">
        <div class="row">
            
        <?php

        $events = mysqli_query(
            $connect,
            "SELECT * FROM events WHERE is_deleted=0
            ORDER BY id_event DESC LIMIT 10"
        ) ;
        while($event = mysqli_fetch_assoc($events)){
        ?>
            <div class="col-12 pr-5 pl-5 p-2 m-2">
                <div class="row w-100">
                    <div class="col-lg-4 ">
                        <div class="image w-100">
                            <?php  if($event['event_image'] != null){ ?>
                                <img class="w-100" src="../admin/Files/events/<?php echo $event['event_image'] ?>" alt="">
                            <?php }else{?>
                                <img class="w-100" src="/images/event.jpg" alt="">
                               
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <b><?php echo $event['event_title'] ?></b><br>
                        <small><?php echo $event['event_date'] ?></small><br>
                        <small><?php echo $event['event_location'] ?></small>
                        <p><?php echo substr( $event['description'],0,100 ) ?>
                            ...
                            <a href="/others/events?event=<?php echo $event['id_event'] ?> ">more</a> 
                        </p>
                    </div>
                </div>
            </div>
        

        <?php } ?> 

        </div>
    </div>
<?php } ?>





<?php require_once('../inc/footer.php') ;?>
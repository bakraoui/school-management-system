<?php require_once('connection.php') ;?>
<?php require_once('admin/includes/functions.php') ;?>
<?php define('TITLE', 'Index'); ?>
<?php require_once('inc/header.php') ;?> 


   

        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner ">
                <div class="carousel-item active">
                    <img src="images/slide-1.jpg" class="d-block w-100 " alt="...">
                </div>
                <div class="carousel-item">
                    <img src="images/slide-1.jpg" class="d-block w-100 " alt="...">
                </div>
                <div class="carousel-item">
                    <img src="images/slide-1.jpg" class="d-block w-100 " alt="...">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="pt-5">
            <h1 class="container title">
                 <span class="text-bold text-danger">O</span>ur <span class="text-bold text-danger">S</span>ervices
            </h1>
            <div class="services  pb-5">
                <div class="container pt-5">    
                    <div class="row service align-items-center" >
                        <div class="col-md-8  p-3 ">
                            <h4>Teachers</h4>
                            <p>
                            Our Teachers are with hight quality. They teach in very Hight universities around the world. 
                            they will help you build your career. 
                            </p> 
                        </div>
                        <div class="col-md-4 text-center">
                            <img class="rounded-circle" src="images/teacher.png" alt="">
                        </div> 
                    </div>
                    <div class="row service align-items-center" >
                        <div class="col-md-8  p-3 ">
                            <h4>Technologies</h4>
                            <p>
                                We use new and Different technologies to educate our Students, OUR FUTURE of course. 
                            </p> 
                        </div>
                        <div class="col-md-4 text-center">
                            <img class="rounded-circle" src="images/techno.png" alt="">
                        </div> 
                    </div>
                    <div class="row service align-items-center" >
                        <div class="col-md-8  p-3 ">
                            <h4>Partnership</h4>
                            <p>
                                We make Partnership with hight universities in Morocco and Abroad to share Experiences And help students to discover and take new challenges.
                            </p> 
                        </div>
                        <div class="col-md-4 text-center">
                            <img class="rounded-circle" src="images/partnership.jpg" alt="">
                        </div> 
                    </div>
                    <div class="row service align-items-center" >
                        <div class="col-md-8  p-3 ">
                            <h4>Transport</h4>
                            <p>
                            We offer to our Students News Cars to get confort in their studies. and of course for their Parents, you will not get affraid about your child anymore.
                            </p> 
                        </div>
                        <div class="col-md-4 text-center">
                            <img class="rounded-circle" src="images/transport.png" alt="">
                        </div> 
                    </div>
                </div>
            </div>
        </div>

    
        <div class="container  pt-5 pb-5">
            <h1 class="title"> <span class="text-bold text-danger">B</span>ranches</h1>
            <div class="row">
                <div class="col">
                    <p class="text-center">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Id illo veniam totam, est nam molestias debitis fugiat aspernatur obcaecati sequi ratione cumque minus eum nemo voluptate blanditiis assumenda dicta. Sapiente.
                    </p>
                </div>
            </div>
            <div class="accordion" id="accordionExample">
            <?php  
                    $branches = mysqli_query(
                        $connect ,
                        "SELECT * FROM branch WHERE is_deleted=0 "
                    ) ;
                    $i = 0 ;
                    while($branch = mysqli_fetch_assoc($branches)){
                        $i++ ;
                ?>
                    <div class="card">
                        <div class="card-header" id="heading_<?php echo $i ; ?>">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse_<?php echo $i ; ?>" aria-expanded="true" aria-controls="collapseOne">
                                    <?php echo $branch['title_branch'] ?>
                                </button>
                            </h2>
                        </div>
                        <div id="collapse_<?php echo $i ; ?>" class="collapse " aria-labelledby="heading_<?php echo $i ; ?>" data-parent="#accordionExample">
                            <div class="card-body ">
                            <?php echo $branch['description_branch'] ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>            
        </div>
        <?php 
            $date = date('Y-m-d') ;
            $events = mysqli_query($connect , "SELECT * FROM events 
                        WHERE is_deleted = 0  ORDER BY id_event DESC") ;
            $cp = 0 ;
            if(mysqli_num_rows($events) != 0){ 
        ?>
            <div class="bg-dark mb-5">
                <div class="events container pt-5 pb-5">
                    <h1 class="title text-light"> <span class="text-bold text-danger">E</span>vents</h1>
                        
                    <div class="row p-2">
                        <?php   while($event = mysqli_fetch_assoc($events) ){ 
                                 if($cp < 4){
                            ?>
                            <div class=" event mb-2 col-lg-3 col-md-4 col-sm-6">
                                <div class="event-img">
                                    <?php  if($event['event_image'] != NULL){ ?>
                                    <img src="admin/Files/events/<?php echo $event['event_image']; ?>" alt="">
                                    <?php }else{ ?>
                                        <img src="images/event.jpg" alt="">
                                    <?php } ?>
                                </div>
                                <div class="event-body ">
                                    <a href="others/events?event=<?php echo $event['id_event'] ?>" class="btn btn-light">See more</a>
                                </div>
                                <div class="event-footer">
                                    <span><i class="fa fa-calendar pr-2" aria-hidden="true"></i><?php echo $event['event_date']?></span><br>
                                    <span><i class="fa fa-map-marker pr-2" aria-hidden="true"></i> <?php echo $event['event_location']?></span>
                                </div>
                            </div>
                        <?php   }
                                $cp++ ;
                            } ?>
                    </div>           
                </div>
            </div>
        <?php } ?>        
   

        <div class="partenariats">
            <h1 class="container title">
                 <span class="text-bold text-danger">I</span>nterprenariat
            </h1>
            <div class="partenariat-content">
                <div class="overlay"></div>
                <div class="partenariat">
                    <div class="item">
                        <div class="img">
                            <img src="/images/teacher.png" alt="">
                        </div>
                    </div>
                    <div class="item">
                        <div class="img">
                            <img src="/images/teacher.png" alt="">
                        </div>
                    </div>
                    <div class="item">
                        <div class="img">
                            <img src="/images/teacher.png" alt="">
                        </div>
                    </div>
                    <div class="item">
                        <div class="img">
                            <img src="/images/teacher.png" alt="">
                        </div>
                    </div>
                    <div class="item">
                        <div class="img">
                            <img src="/images/teacher.png" alt="">
                        </div>
                    </div>
                    <div class="item">
                        <div class="img">
                            <img src="/images/teacher.png" alt="">
                        </div>
                    </div>
                    <!-- <div class="item">
                        <div class="img">
                            <img src="/images/teacher.png" alt="">
                        </div>
                    </div>
                    
                    <div class="item">
                        <div class="img">
                            <img src="/images/teacher.png" alt="">
                        </div>
                    </div>
                    
                    <div class="item">
                        <div class="img">
                            <img src="/images/teacher.png" alt="">
                        </div>
                    </div>
                    
                    <div class="item">
                        <div class="img">
                            <img src="/images/teacher.png" alt="">
                        </div>
                    </div> -->
                </div>
                <button id="prev"><span><i class="fa fa-chevron-left"></i></span></button>
                <button id="next"><span><i class="fa fa-chevron-right"></i></span></button>
            </div>
        </div>

<?php require_once('inc/footer.php') ;?>
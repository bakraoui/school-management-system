

    </div>
    <footer class="text-light">
        <div class="container">
            <div class="row  pt-3 pb-3">
                <div class="col-md-6">
                    <h4>About Us</h4>
                    <hr>
                    <p class="about-us">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
                        Non porro ad dolorum rerum, at aperiam ipsum. 
                        Ad, ullam, expedita aperiam atque numquam praesentium est commodi 
                        totam molestias repudiandae iure blanditiis.
                    </p>
                    <div>
                        <p>
                            <?php 
                                if($school['adress']){
                                    echo $school['adress'];
                                }else{ echo 'Lorem, ipsum dolor sit amet consectetur adipisicing elit.' ; } 
                             ?>
                        </p>
                        <p>
                            <?php 
                                if($school['city']){
                                    echo $school['city'];
                                }else{ echo 'Agadir.' ; } 
                             ?>
                        </p>                        
                    </div>
                </div>
                <div class="col-md-6">
                    <h4>Contact Us</h4>
                    <hr>
                    <div class="d-flex space-between">
                        <div class="contact" >
                            <p>
                                <span><i class=" pr-2 fa fa-phone"></i></span>
                                <?php 
                                    if($school['tele']){
                                        echo $school['tele'];
                                    }else{ echo '+212 600663388' ; } 
                                ?>
                            </p>
                            <p>
                                <span><i class=" pr-2 fa fa-envelope-open-o"></i></span>
                                <?php 
                                    if($school['email']){
                                        echo $school['email'];
                                    }else{ echo 'school@contact.com ' ; } 
                                ?>
                            </p>
                        </div>
                        <div class="google-map" >
                            <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3440.9136219467223!2d-9.575109085460877!3d30.41019250815773!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xdb3b712c8d2bb4f%3A0xea87380a84a2eb31!2sSMART%20SOLUCE%20%3A%20Cr%C3%A9ation%20site%20internet%20Agadir!5e0!3m2!1sen!2sma!4v1633443832720!5m2!1sen!2sma" 
                            width="300" 
                            height="250" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                            </iframe>                                
                        </div>
                    </div>
                </div>
            </div>

            <div class="row  pt-3 ">
                <div class="col-lg-3 col-md-4 col-sm-6" >
                    <h5>
                        <?php 
                            if($school['name']){
                                echo $school['name'];
                            }else{ echo 'School' ; } 
                            ?>
                    </h5>
                    <hr>
                    <ul class="list-unstyled">
                        <li class="nav-item">
                            <a href="/school/About" class="nav-link">About Us </a>
                        </li>
                        <li class="nav-item">
                            <a href="/school/director" class="nav-link">Director word</a>
                        </li>
                        <li class="nav-item">
                            <a href="/school/access-conditions" class="nav-link">Access Conditions  </a>
                        </li>
                        <li class="nav-item">
                            <a href="/school/Internal-Low" class="nav-link">Internal Low </a>
                        </li>
                        <li class="nav-item">
                            <a href="/school/Stuff" class="nav-link">Stuff </a>
                        </li>
                        <li class="nav-item">
                            <a href="/school/gallery" class="nav-link">Gallery </a>
                        </li>
                    </ul>
                    
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6" >
                    <h5>Formation</h5>
                    <hr>
                    <ul class="list-unstyled">
                        <li class="nav-item">
                            <a href="/formation/Engineering" class="nav-link">Engineering </a>
                        </li>
                        <li class="nav-item">
                            <a href="/formation/Master" class="nav-link">Master </a>
                        </li>
                        <li class="nav-item">
                            <a href="/formation/preparatory-classes" class="nav-link">Preparatory Classes </a>
                        </li>
                        <li class="nav-item">
                            <a href="/formation/Engineering-cycle" class="nav-link">Engineering Cycle </a>
                        </li>
                    </ul>
                    
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6" >
                    <h5>Student</h5>
                    <hr>
                    <ul class="list-unstyled">
                        <li class="nav-item">
                            <a href="/student-space/gallery" class="nav-link">Gallery Photo </a>
                        </li>
                        <li class="nav-item">
                            <a href="/student-space/club" class="nav-link">Club </a>
                        </li>
                        <li class="nav-item">
                            <a href="/student-space/forum" class="nav-link">Forum </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="admin/login" class="nav-link">Login </a>
                        </li>
                    </ul>
                    
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6" >
                    <h5>Other</h5>
                    <hr>
                    <ul class="list-unstyled">
                        <li class="nav-item">
                            <a href="/others/statistics" class="nav-link">Statistics </a>
                        </li>
                        <li class="nav-item">
                            <a href="/others/covid-19" class="nav-link">Covid-19 </a>
                        </li>
                        <li class="nav-item">
                            <a href="/others/events" class="nav-link">Events </a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col pb-2 text-center">
                    &copy;<?php 
                                if($school['name']){
                                    echo $school['name'];
                                }else{ echo 'School System Management.' ; } 
                                echo "  ".date('Y');
                             ?> 
                </div>
            </div>
        </div>

    </footer>

    <script src="/js/jquery-3.5.1.slim.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/script.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title><?php echo TITLE ; ?></title>
</head>
<body >

    <?php  
        $school = mysqli_fetch_assoc(
            mysqli_query($connect, "SELECT * FROM school")
        ); 
        
    ?>

    
    <header >
        <div class="bg-dark text-light">
            <div class=" d-flex">
                <div class="contact p-3 mr-auto">
                    <span class="mr-3">
                        <i class=" pr-2 fa fa-envelope-open-o"></i>
                        <?php 
                            if($school['email']){
                                echo $school['email'];
                            }else{ echo 'school@contact.com' ; } 
                            ?>
                        
                    </span>
                    <span>
                        <i class="fa fa-phone pr-2"></i>
                        <?php 
                            if($school['tele']){
                                echo $school['tele'];
                            }else{ echo '+212 600663388' ; } 
                            ?>
                        
                    </span>
                </div>
                <div class="social-media p-2 ml-auto">
                    <a href="">
                        <span class="btn btn-primary"><i class="fa fa-facebook"></i></span>
                    </a>
                    <a href="">
                        <span class="btn btn-info"><i class="fa fa-linkedin"></i></span>
                    </a>
                    <a href="">
                        <span class="btn btn-primary"><i class="fa fa-twitter"></i></span>
                    </a>
                    <a href="">
                        <span class="btn btn-danger"><i class="fa fa-instagram"></i></span>
                    </a>
                </div>
            </div>            
        </div>
    </header>
    <div id="top" class=" navbar navbar-extend">
        <div class="container space-between">
            <div class="navbar-brand">
                <h1><a href="/">
                    <?php 
                        if($school['name']){
                            echo $school['name'];
                        }else{ echo 'School' ; } 
                    ?>
                </a></h1>
            </div>
            <button class="navbar-toggler"><span><i class="fa fa-bars"></i></span></button>
            <div class="navbar-menu">
                <ul class="nav menu ">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            School
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/school/director">Director's word</a>
                            <a class="dropdown-item" href="/school/about">About Us</a>
                            <a class="dropdown-item" href="/school/internal-low">Internal Low</a>
                            <a class="dropdown-item" href="/school/stuff">Stuff</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Formation
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/formation/engineering">Engineering</a>
                            <a class="dropdown-item" href="/formation/master">Master</a>
                            <a class="dropdown-item" href="/formation/preparatory-classes">Preparatory Classes</a>
                            <a class="dropdown-item" href="/formation/engineering-cycle">Engineering Cycle</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/others/statistics">Statistics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/others/covid-19">Covid-19</a>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Student space
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/student-space/clubs">Clubs</a>
                            <a class="dropdown-item" href="/student-space/forum">Forum</a>
                            <a class="dropdown-item" href="/student-space/Gallery">Gallery</a>
                            <a class="dropdown-item" href="admin/login">Login</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <a href="#top" class="btn-top bg-light  text-danger  p-2" 
                   style="border: 2px darkred solid; border-radius : 50%"
    >
        <i class="fa fa-arrow-up"></i>
    </a>
    <div>
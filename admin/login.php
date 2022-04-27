<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>LOGIN</title>
    <style>
		.alerts{
			position : absolute ;
			width : 100% ;
		}
        .content{
            width: 100%;
            height: 100vh;
            display: flex;
            background-image: url('Files/Custom/bricks-g8517cf85d_1920.jpg');
            background-size: cover;
            align-items: center;
            justify-content: center;
        }
        .card{
            background-color: rgba(0, 0, 0, 0.5);
            box-shadow: 0px 0px 16px #111;
            color: #fff;
            font-weight: 500;
        }
    </style>
</head>
<body>
	<?php session_start(); ?>
	<div class="alerts">
		<?php 
			if(isset($_SESSION['err'])){
				echo "<p class='alert alert-danger'>".$_SESSION['err']."</p>" ;
				unset($_SESSION['err']) ;
				}
			if(isset($_SESSION['succ'])){
				echo "<p class='alert alert-success'>".$_SESSION['succ']."</p>" ;
				unset($_SESSION['succ']) ;
				}
		?>
	</div>
    <div class="content">
        <div  class="container ">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col col-lg-5 col-md-8  ">
                    <div class=" card rounded-lg ">
                        <h4 class="card-title text-center bg-info p-3 ">login </h4>
                        
                        <form class="card-body" method="POST" action="includes/check_login">  
                            <div class="form-group">
                                <label for="user">
                                    <?php 
                                            //if(isset($_GET['admin'])) echo "Code Identité National";
                                            //elseif(isset($_GET['student'])) echo "Code National Etudiant";
                                            //else echo "Code Identité National" ;
                                        ?>
										Email
                                </label>
                                <input type="text" name="user" id="user" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <?php if(isset($_GET['admin']) ){ ?>
                                <div class="select" style="display : flex ;justify-content : space-between ; align-items : center">
                                    <label for="password">Vous etes ?</label>
                                    <select name="role" id="role" class="form-control" style="font-size: 14px; width : 30%" >
                                        <option value="" selected></option>
                                        <option value="manager">Manager</option>
                                        <option value="teacher">Professeur</option>
                                    </select>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <input type="submit" 
                                        name="<?php if(isset($_GET['admin'])) echo 'submit-admin'; 
                                                    else echo 'submit-student';
                                                    ?>" 
                                        class="btn btn-primary  " value="login">
                            </div>
                        </form>
                    </div>                
                </div>
            </div>

        </div>
    </div>
</body>
</html>
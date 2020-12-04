<?php 
    require_once "pdo.php";
    session_start();
    
    
    
    if ( isset($_POST["uname"]) && isset($_POST["pass"]) ){
            
              
              if($_POST["uname"]=='admin' &&  $_POST["pass"]=='admin')
              {
                  $_SESSION['admin'] = 'admin';
                  header( 'Location: AdminPanel.php' ) ;
                  return;
              }
              else {
                $_SESSION['error'] = 'Incorrect username or password';
                header( 'Location: Admin.php' ) ;
                return;
              }


                        
        }
    
    
 ?>



<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!--    custom css-->
  <link rel="stylesheet" href="custom/style.css">
  <link rel="stylesheet" href="custom/responsive.css">

  <!--Fontawsome css-->
  <link rel="stylesheet" href="fontawesome/css/all.css" type="text/css">

  <!--    googlefonts-->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">


  <title>Admin Sign In</title>
</head>

<body>

  <!--  NavBar-->

  <section class="t-nav sticky-top">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#"><img src="img/logo1.png" class="img-fluid" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent ">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Departments</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">FAQ</a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="signin.php"> Admin Sign in</a>
                </li>
              </ul>
              
            </div>
          </nav>
        </div>

      </div>
    </div>
  </section>

  <!--  NavBar-->



  <!-- SignIn-->

  <section>
    <div class="container">

      <div class="row text-center mt-3">
        <div class="col-md-12">
          <h2>Admin Sign In</h2>
          <?php
              if ( isset($_SESSION["error"]) ) {
                  echo('<p style="color: red;">'.htmlentities($_SESSION["error"])."</p>\n");
                  unset($_SESSION['error']);
              }
           ?>
        </div>
      </div>

      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">


          <form action="Admin.php" method="post">


            <div class="form-group">
                <label for="uname-input" class="col-form-label">Username</label>
                  <input class="form-control" type="text" name="uname"  id="uname-input"  required>
            </div>

            <div class="form-group">
              <label for="password-input" class="col-form-label">Password</label>                    
                <input class="form-control" type="password" name="pass"  id="password-input" required>                    
            </div>


            <input type="submit" class="btn btn-primary" value="Sign in">
          </form>





        </div>


        <div class="col-md-2"></div>

      </div>



      



    </div>
  </section>




  <!--End of SignIn-->



  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>
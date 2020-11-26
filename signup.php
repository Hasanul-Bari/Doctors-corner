<?php 
    require_once "pdo.php";
    session_start();
    
    
    
    if ( isset($_POST["Pname"]) && isset($_POST["email"]) && isset($_POST["pass"]) && isset($_POST["dob"])
        && isset($_POST["phone"]) && isset($_POST["gender"]) && isset($_POST["weight"]) && isset($_POST["height"])  ){
            
              $re="~^[0-9]+(\.[0-9]+)?$~";
              
              if(preg_match($re, $_POST["weight"])==0){
                $_SESSION['error'] = 'Enter a valid weight';
                header( 'Location: signup.php' ) ;
                return;
              }
              if(preg_match($re, $_POST["height"])==0){
                $_SESSION['error'] = 'Enter a valid height';
                header( 'Location: signup.php' ) ;
                return;
              }
              
              $stmt = $pdo->prepare("SELECT Email FROM patients where Email= :em");
              $stmt->execute(array(
                  ":em" => $_POST["email"])
                );
              $row = $stmt->fetch(PDO::FETCH_ASSOC);
              
              if ( $row !== false ){
                $_SESSION['error'] = 'Id with this email already exist';
                header( 'Location: signup.php' ) ;
                return;
              }
              
              $sk='arrow/*/-';
              $pass=hash('md5', $sk.$_POST['pass']);
              
              
              $sql = "INSERT INTO patients (Name, Email, Pass, Phone, DOB, Gender, Weight, Height) VALUES (:nm, :em, :pw, :ph, :bd, :gn, :wt, :ht)";

              $stmt = $pdo->prepare($sql);
              $stmt->execute(array(
                ":nm" => $_POST["Pname"],
                ":em" => $_POST["email"],
                ":pw" => $pass,
                ":ph" => $_POST["phone"],
                ":bd" => $_POST["dob"],
                ":gn" => $_POST["gender"],
                ":wt" => $_POST["weight"],
                ":ht" => $_POST["height"])

              );
              
              $stmt = $pdo->prepare("SELECT Pid FROM patients where Email= :em");
              $stmt->execute(array(
                    ":em" => $_POST["email"])
              );
              $row = $stmt->fetch(PDO::FETCH_ASSOC);

             $_SESSION['patient'] = $row["Pid"];
             header( 'Location: index.php' ) ;
             return;
              
              
              
          
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


    <title>Sign Up</title>
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
                                <a class="nav-link" href="#">Department</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" href="#">FAQ</a>
                              </li>
                             <li class="nav-item active">
                                <a class="nav-link" href="signup.php">Sign up<span class="sr-only mr-1">(current)</span></a>
                              </li>
                            </ul>
                          
                          </div>
                        </nav>
                     </div>

                 </div>
             </div>
      </section>

    <!--  NavBar-->



<!-- SignUp-->

<section>
         <div class="container">

            <div class="row text-center mt-3">
              <div class="col-md-12">
                <h2>Create Profile</h2>
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


                   <form action="signup.php" method="post">

                      <div class="form-group">
                        <label  for="Name">Name</label>
                        <input type="text" class="form-control" id="Name" name="Pname"  placeholder="Enter Name" required>
                      </div>
                      
                      <div class="form-group">
                          <label for="email-input" class="col-form-label">Email</label>
                            <input class="form-control" type="email" name="email"  id="email-input" placeholder="Enter Email" required>
                      </div>

                      <div class="form-group">
                        <label for="password-input" class="col-form-label">Password</label>                    
                          <input class="form-control" type="password" name="pass"  id="password-input" required>                    
                      </div>
                    
                      
                      <div class="form-group">
                        <label for="date-input">Date of Birth</label>
                          <input class="form-control" type="date" name="dob" id="date-input" required>
                      </div>

                      <fieldset class="form-group">
                          <legend>Gender</legend>
                          <div class="form-check">
                             <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="gender" value="Male" required>Male
                              </label>
                          </div>
                          
                          <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="gender" value="Female">Female
                            </label>
                          </div>
                      </fieldset>


                      <div class="form-group">
                          <label for="tel-input" class="col-form-label">Contact No</label>
                          <div class="">
                            <input class="form-control" type="tel" name="phone"  id="tel-input" pattern="[0]{1}[1]{1}[0-9]{9}" placeholder="01XXXXXXXXX" required>
                          </div>
                      </div>


                      <div class="form-group">
                        <label  for="Weight">Weight in KG</label>
                        <input type="text" class="form-control" name="weight" id="Weight"  placeholder="Enter Weight" required>
                      </div>
                      
                      
                    <div class="form-group">
                        <label  for="Height">Height in cm</label>
                        <input type="text" class="form-control" name="height" id="Height"  placeholder="Enter Height" required>
                      </div>

                    <input type="submit" class="btn btn-primary" value="Sign Up">
                    
                  </form>





                 </div>


                <div class="col-md-2"></div>

             </div>



            <div class="row text-center">
              <div class="col-md-12">
                <p class="sign-in-text">Already have an account?&nbsp;<a href="signin.php">Sign in</a>.</p>
              </div>
            </div>



         </div>
</section>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>

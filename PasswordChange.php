<?php
    require_once "pdo.php";
    session_start();
    
    if(isset($_SESSION['patient'])){
      $stmt = $pdo->prepare("SELECT * FROM patients where Pid= :pid");
      $stmt->execute(array(
          ":pid" => $_SESSION['patient'])
        );
      $pt = $stmt->fetch(PDO::FETCH_ASSOC);
      
      $nm= htmlentities($pt['Name']);
      $ph= htmlentities($pt['Phone']);
      $bd= htmlentities($pt['DOB']);
      $gd= htmlentities($pt['Gender']);
      $wt= htmlentities($pt['Weight']);
      $ht= htmlentities($pt['Height']);
      
      $today = new DateTime();
      $bday = new DateTime($bd);
  
      $age = $today->diff($bday);
      //echo $age->y;
            
    }
    else{
      die("ACCESS DENIED");
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
  <link rel="stylesheet" href="custom/style_Pro.css">
  <link rel="stylesheet" href="custom/responsive.css">

  <!--Fontawsome css-->
  <link rel="stylesheet" href="fontawesome/css/all.css" type="text/css">



  <title>Patient-EditProfile</title>
</head>

<body>

  <!--  NavBar-->

  <header class="t-nav sticky-top">
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
                  <a class="nav-link" href="index.php">Home<span class="sr-only mr-1">(current)</span></a>
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
                
              
                      
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="img/profile.png" class="img-fluid" alt="">&nbsp; <?= $nm ?> </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="PatientProfile.php">Profile</a>
                      <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
                      
                      
                
                 
                
              </ul>
              
              
            </div>
          </nav>
        </div>

      </div>
    </div>
  </header>

  <!--  NavBar-->

  <!--Consult-->

  <section>
    <div class="container">

      <div class="row my-3">
        <div class="col-md-2"></div>
        <div class="col-md-8 border rounded border-dark py-3">
          <h5>Name: Donald Trump</h5>
          <h4>Contact : 01781XXXXXXXXX</h4>

        </div>
        <div class="col-md-2"></div>
      </div>
      <div class="row mt-3">
        <div class="col-md-2"></div>
        <div class="col-md-8 border border-dark rounded py-3 mb-3">
          <h3 class="text-center">ChangePassword</h3>

          <div class="form-group">
            <label for="OldPassword">Old Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
          </div>


          <div class="form-group">
            <label for="NewPassword">New Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
          </div>

          <button type="submit" class="btn btn-primary mt-2">Change Password</button>



        </div>
        <div class="col-md-2"></div>
      </div>


    </div>
  </section>


  <!--Consult-->
  
  <?php 
    require_once "footer.php";
   ?>



</body>

</html>
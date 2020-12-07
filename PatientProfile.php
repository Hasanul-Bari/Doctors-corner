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
    
    
    
    //fetching upcoming appointments
    
    $sql="SELECT  consultations.Cid, doctors.Name, consultations.Cdate
          FROM consultations JOIN doctors
          ON consultations.Did=doctors.Did 
          WHERE consultations.Pid= :pid
          ORDER BY consultations.Cdate";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
            ":pid" => $_SESSION["patient"])
          );
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    

    
    
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
  <link rel="stylesheet" href="custom/style_Pat.css">
  <link rel="stylesheet" href="custom/responsive.css">

  <!--Fontawsome css-->
  <link rel="stylesheet" href="fontawesome/css/all.css" type="text/css">



  <title>PatientHome</title>
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
                  <a class="nav-link" href="departments.php">Departments</a>
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
      <div class="row mt-3">
        <div class="col-md-5">
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 text-center">
              <h3>My Consultation List</h3>
            </div>
            <div class="col-md-1"></div>
          </div>
          
          <?php 
                foreach ( $rows as $row ){
                      
                      $consultDate=htmlentities($row['Cdate']);
                      $consultDate = substr_replace($consultDate, '-', 4 , 0);
                      $consultDate = substr_replace($consultDate, '-', 7 , 0);
                      $cdate=new DateTime($consultDate);
                      
                  
                    ?>
                          <div class="row border border-dark rounded my-3">
                            <div class="col-md-1"></div>
                            <div class="col-md-10 py-3">
                              
                              <h4><?=htmlentities($row['Name'])?></h4>
                              <h5>On <?= $cdate->format('l, jS  F Y') ?></h5>
                              
                              <button type="button" class="btn btn-primary">Details</button>
                              <button type="button" class="btn btn-success">Status</button>
                            
                            </div>
                            <div class="col-md-1"></div>
                          </div>                    
                    <?php 
                }
          
           ?>
          
          
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-5">
          <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 text-center">
              <h3>Details</h3>
              <?php 
                  if ( isset($_SESSION['success']) ) {
                      echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
                      unset($_SESSION['success']);
                  }
               ?>
            </div>
            <div class="col-md-1"></div>
          </div>
          <div class="row border border-dark rounded my-3">
            <div class="col-md-1"></div>
            <div class="col-md-10 py-3">
              
              <h4>Patient's Name : <?= $nm ?> </h4>
              <h5>Age : <?= $age->y.' years '.$age->m.' months '.$age->d.' days' ?></h5>
              <h5>Sex : <?= $gd ?></h5>
              <h5>Height : <?= $ht.' cm' ?> </h5>
              <h5>Weight : <?= $wt.' kg' ?> </h5>
              <h5>Contact : <?= $ph ?></h5>
              <h5>Date of Birth : <?= $bd ?></h5>

              <a type="button" class="btn btn-primary" href="PatientProfileEdit.php">Edit Profile</a>


            </div>
            <div class="col-md-1"></div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!--Consult-->

  <?php 
    require_once "footer.php";
   ?>




</body>

</html>
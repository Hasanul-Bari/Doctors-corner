<?php 
    require_once "pdo.php";
    session_start();
    
    //testing doctorid is set

    if ( ! isset($_GET['doctor_id']) && !isset($_SESSION['doctor'])) {
      die("Bad parameter");
    }
    
    
    
    
    if(isset($_SESSION['patient'])){
      $stmt = $pdo->prepare("SELECT Name FROM patients where Pid= :pid");
      $stmt->execute(array(
          ":pid" => $_SESSION['patient'])
        );
      $pt = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    if(isset($_SESSION['doctor'])){
        $stmt = $pdo->prepare("SELECT * FROM doctors where Did= :did");
        $stmt->execute(array(
            ":did" => $_SESSION['doctor'])
          );
        $userdr = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    
   if(isset($_GET['doctor_id'])){
       $stmt = $pdo->prepare("SELECT * FROM doctors where Did=:did");
       $stmt->execute(array(":did" => $_GET['doctor_id']));
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    else{
      $row=$userdr;
    }
    
    //select dept name
    $stmt = $pdo->prepare("SELECT dept_name FROM departments where dept_id=:dpid");
    $stmt->execute(array(":dpid" => $row['dept_id']));
    $dept = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    
    
    
  
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
  <link rel="stylesheet" href="custom/styleDocView.css">
  <link rel="stylesheet" href="custom/responsive.css">

  <!--Fontawsome css-->
  <link rel="stylesheet" href="fontawesome/css/all.css" type="text/css">



  <title>Doctor-Profile</title>
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
                  <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="departments.php">Departments</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="Appointments.php">My appointments</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="#">FAQ</a>
                </li>

                <?php 
                      if(isset($_SESSION['patient'])){
                        ?>
                            <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="img/profile.png" class="img-fluid" alt="">&nbsp; <?=htmlentities($pt['Name'])?> </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="PatientProfile.php">Profile</a>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                            </div></li>
                        <?php  
                      }
                      else if(isset($_SESSION['doctor'])){
                        ?>
                            <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="img/profile.png" class="img-fluid" alt="">&nbsp; <?=htmlentities($userdr['Name'])?> </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="doctorProfile.php">Profile</a>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                            </div></li>
                        <?php  
                      }
                      else{
                        ?>
                            <li class="nav-item">
                              <a class="nav-link" href="signin.php">Sign in</a>
                            </li>
                        <?php 
                      }
                
                 ?>

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

      <?php 
          if ( isset($_SESSION['error']) ) {
            echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
            unset($_SESSION['error']);
          }
          if ( isset($_SESSION['success']) ) {
              echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
              unset($_SESSION['success']);
          }
      ?>

      <div class="row my-3">

      
        <div class="col-md-1"></div>
        <div class="col-md-4">
          <img src="img/doctorIcon.jpg" class="img-fluid" alt="">



          <div class="input-group mt-3">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04">
              <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
            </div>
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Upload</button>
            </div>
          </div>

        </div>
              
        
        <div class="col-md-6 mt-5">
          <h4 class="text-primary">Doctor's name: <?=htmlentities($row['Name'])?></h4>
          <h5>Department : <?=htmlentities($dept['dept_name'])?></h5>
          <h5>Qualifications : <?=htmlentities($row['Qualification'])?></h5>
          <h5>Experience : <?=htmlentities($row['Experience'])?></h5>
          
          <p class="doc-bio mt-2"> <?=htmlentities($row['about'])?> </p>
          
          
          <?php 
              if(isset($_SESSION['patient'])) {
                  echo '<a href="BookAppointment.php?doctor_id='.$row['Did'].'" type="button" class="btn btn-success mt-2">Book Appoinment</a>';
              }
              if(isset($_SESSION['doctor']) &&  $_SESSION['doctor']===$row['Did'] )  {
                
                  echo '<a href="doctorProfileEdit.php" type="button" class="btn btn-success mt-2">Edit Profile</a>';
                  echo '&nbsp;';
                  echo '<a href="Appointments.php" type="button" class="btn btn-success mt-2">My Appointments</a>';
              }
           ?>
          

          


        </div>
        <div class="col-md-1"></div>
      </div>

    </div>
  </section>





  <!--Consult-->

  


  <?php 
    require_once "footer.php";
   ?>


</body>

</html>
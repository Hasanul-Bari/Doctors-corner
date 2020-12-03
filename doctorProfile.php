<?php 
    require_once "pdo.php";
    session_start();
    
    //testing doctorid is set
    if ( ! isset($_GET['doctor_id']) ) {
      die("Bad parameter");
    }
    
    
    
    
    if(isset($_SESSION['patient'])){
      $stmt = $pdo->prepare("SELECT Name FROM patients where Pid= :pid");
      $stmt->execute(array(
          ":pid" => $_SESSION['patient'])
        );
      $pt = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    $stmt = $pdo->prepare("SELECT * FROM doctors where Did=:did");
    $stmt->execute(array(":did" => $_GET['doctor_id']));
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
                <li class="nav-item active">
                  <a class="nav-link" href="departments.php">Departments</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">FAQ</a>
                </li>

                <?php 
                      if(isset($_SESSION['patient'])){
                        ?>
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="img/profile.png" class="img-fluid" alt="">&nbsp; <?=htmlentities($pt['Name'])?> </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="PatientProfile.php">Profile</a>
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
          <h4 class="text-primary">Doctor's name: Dr Shahriar Kabir</h4>
          <h5>Department : Cardiology</h5>
          <h5>Experience : Cardiology</h5>
          <h5>Qualifications : MBBS (DMC), FCPS (Medicine),BCS (Health)</h5>
          <button type="button" class="btn btn-success mt-2">Book Appoinment</button>

          <p class="doc-bio mt-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis error maxime esse vero, nam voluptatibus aperiam saepe iure nesciunt enim. Molestias dolores dolorum, blanditiis aperiam officiis voluptate vel
            saepe aut dolor, dignissimos voluptas, aliquam delectus veritatis. Quibusdam ex nulla nobis necessitatibus? Voluptatibus perspiciatis minima est dolore eum! Vero, fugit, culpa.</p>


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
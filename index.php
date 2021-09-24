<?php
    require_once "pdo.php";
    session_start();
    
    if(isset($_SESSION['patient'])){
      $stmt = $pdo->prepare("SELECT Name FROM patients where Pid= :pid");
      $stmt->execute(array(
          ":pid" => $_SESSION['patient'])
        );
      $pt = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    if(isset($_SESSION['doctor'])){
        $stmt = $pdo->prepare("SELECT Name FROM doctors where Did= :did");
        $stmt->execute(array(
            ":did" => $_SESSION['doctor'])
          );
        $userdr = $stmt->fetch(PDO::FETCH_ASSOC);
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



  <title>Doctor's Corner - Home</title>
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
                <li class="nav-item active">
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
                            <li class="nav-item dropdown">
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
                            <li class="nav-item dropdown">
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

  <!--  banner-->
  <section class="t-banner ">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-sm-12">
          <h2 class="text-primary t-head">Your Personal Doctor, Online</h2>
          <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi tempora quas, vero autem expedita hic beatae, dolorem consequuntur, dignissimos obcaecati aspernatur perspiciatis. Explicabo nam sed totam. Voluptatem
            voluptatibus fuga sint.</p>
          <button type="button" class="btn btn-outline-primary t-btn font-weight-bold">READ MORE</button>
          <!--                 <img src="img/banner.jpg" class="img-fluid" alt="">-->
        </div>
        
        <div class="col-md-4">
          
        </div>
        <div class="col-md-4">
          <?php 
                if(!isset($_SESSION['patient'])){
                  echo '<a type="button" class="btn btn-outline-primary t-head t-btn font-weight-bold" href="signup.php">Create Account</a><br>';
                  echo '<a type="button" class="btn btn-outline-primary t-head t-btn font-weight-bold" href="signinDoctor.php">Sign in as Docotor</a>';

                }
           ?>
        </div>
        
      </div>
    </div>
  </section>

  <!--  banner-->

  <!--  ABOUT-->
  <section>
    <div class="container">
      <div class="row mt-3">
        <div class="col-md-6 p-3">
          <h1 class="text-center">ABOUT US</h1>
          <p class="t-shad text-justify">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem quasi amet obcaecati, sapiente expedita iure beatae rem corporis eum suscipit odio nam assumenda, laborum! Facere voluptate voluptatibus omnis numquam, veritatis consectetur
            animi iste aut voluptatem vel repellat saepe cumque error eligendi ipsa maxime ullam provident praesentium enim. Odit ipsam explicabo similique, ipsa ut temporibus impedit, error dolore minus sunt quos, eveniet. Nihil, pariatur,
            laboriosam. Eveniet earum, nemo eius repellendus iste doloremque est aspernatur exercitationem reiciendis nisi veniam ipsum pariatur expedita culpa quisquam, reprehenderit maxime ipsam iure deserunt quaerat esse doloribus dolor explicabo
            ab voluptatum. Architecto ea deserunt labore fuga distinctio.

          </p>
          <button type="button" class="btn btn-outline-dark t-btn font-weight-bold">READ MORE</button>

        </div>
        <div class="col-md-6">
          <img src="img/about.jpg" class="img-fluid" alt="">
        </div>
      </div>
    </div>
  </section>
  <!--  ABOUT-->

  <!--  departments-->
  <section class="t-bg1">
    <div class="container">
      <div class="row pt-5">
        <div class="col-md-4">
          <div class="row">
            <div class="col-md-3">
              <img src="img/department-icon-cardiology.png" class="img-fluid" alt="">
            </div>
            <div class="col-md-9">
              <a href="#">
                <h4 class="text-primary">Asthma</h4>
              </a>
              <p class="t-shad">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis ducimus facere, in temporibus est et.
              </p>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-3">
              <img src="img/department-icon-dental.png" class="img-fluid" alt="">
            </div>
            <div class="col-md-9">
              <a href="#">
                <h4 class="text-primary">Dental</h4>
              </a>
              <p class="t-shad">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis ducimus facere, in temporibus est et.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="row">
            <div class="col-md-3">
              <img src="img/department-icon-gastroenterology.png" class="img-fluid" alt="">
            </div>
            <div class="col-md-9">
              <a href="#">
                <h4 class="text-primary">Gastroenterology</h4>
              </a>
              <h4 class="text-primary"></h4>
              <p class="t-shad">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis ducimus facere, in temporibus est et.
              </p>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-3">
              <img src="img/department-icon-gynecology.png" class="img-fluid" alt="">
            </div>
            <div class="col-md-9">
              <a href="#">
                <h4 class="text-primary">Gynecology</h4>
              </a>
              <p class="t-shad">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis ducimus facere, in temporibus est et.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="row">
            <div class="col-md-3">
              <img src="img/department-icon-pulmonology.png" class="img-fluid" alt="">
            </div>
            <div class="col-md-9">
              <a href="#">
                <h4 class="text-primary">Chest Medicine</h4>
              </a>
              <p class="t-shad">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis ducimus facere, in temporibus est et.
              </p>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-3">
              <img src="img/department-icon-hepatology.png" class="img-fluid" alt="">
            </div>
            <div class="col-md-9">
              <a href="#">
                <h4 class="text-primary">Hepatology</h4>
              </a>
              <p class="t-shad">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis ducimus facere, in temporibus est et.
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="row my-3 pb-5">
        <div class="col-md-12 text-center ">
          <a href=""><button type="button" class="btn btn-outline-primary t-btn font-weight-bold m-2">MORE DEPARTMENTS</button></a>

        </div>
      </div>
    </div>
  </section>


  <!--  departments-->


  <!--  doctors-->

  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center py-3">
          <hr>
          <h2>OUR SPECIALIST DOCTORS</h2>
          <hr>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 col-sm-12">
          <div class="card" style="width: 18rem;">
            <img src="img/doctor.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Dr. ABCD</h5>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere dolor distinctio fuga officia at qui..</p>
              <a href="#" class="btn btn-dark">Profile</a>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-12">
          <div class="card" style="width: 18rem;">
            <img src="img/doctor.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Dr. ABCD</h5>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere dolor distinctio fuga officia at qui..</p>
              <a href="#" class="btn btn-dark">Profile</a>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-12">
          <div class="card" style="width: 18rem;">
            <img src="img/doctor.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Dr. ABCD</h5>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere dolor distinctio fuga officia at qui..</p>
              <a href="#" class="btn btn-dark">Profile</a>
            </div>
          </div>
        </div>
      </div>

      <div class="row my-3">
        <div class="col-md-4 col-sm-12">
          <div class="card" style="width: 18rem;">
            <img src="img/doctor.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Dr. ABCD</h5>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere dolor distinctio fuga officia at qui..</p>
              <a href="#" class="btn btn-dark">Profile</a>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-12">
          <div class="card" style="width: 18rem;">
            <img src="img/doctor.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Dr. ABCD</h5>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere dolor distinctio fuga officia at qui..</p>
              <a href="#" class="btn btn-dark">Profile</a>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-12">
          <div class="card" style="width: 18rem;">
            <img src="img/doctor.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Dr. ABCD</h5>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere dolor distinctio fuga officia at qui..</p>
              <a href="#" class="btn btn-dark">Profile</a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!--  doctors-->




  <?php 
    require_once "footer.php";
   ?>




</body>

</html>
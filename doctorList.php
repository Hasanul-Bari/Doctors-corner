<?php 
    require_once "pdo.php";
    session_start();
    
    //testing deptid is set
    if ( ! isset($_GET['dept_id']) ) {
      die("Bad parameter");
    }
    
    $dept_id=$_GET['dept_id'];
    
    //getting dept name
    $stmt = $pdo->prepare("SELECT dept_name FROM departments where dept_id=:dpid");
    $stmt->execute(array(":dpid" => $_GET['dept_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $dept_name=htmlentities($row['dept_name']);
    
    
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
    
    $stmt = $pdo->prepare("SELECT Did, Name, consultDays FROM doctors where dept_id=:dpid");
    $stmt->execute(array(":dpid" => $_GET['dept_id']));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    
    $weekdays=array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
  
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



  <title>Doctor's List</title>
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

  <!--Consult-->

  <section>
    <div class="container">
      <div class="row mt-3 text-center">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <h4 class=""><?=$dept_name?> Doctors</h4>
        </div>
        <div class="col-md-2"></div>
      </div>
      
        
        
        
        <?php 
            foreach ( $rows as $row ){
              ?>
                  <div class="row my-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 border rounded border-dark py-3">
                      <h5>Doctor's name:</h5>
                      <h4><?= htmlentities($row['Name']) ?></h4>
                      
                      <a type="button" class="btn btn-primary" href="doctorProfile.php?doctor_id=<?=htmlentities($row['Did'])?>">Profile</a>
                      
                      <?php 
                            if(isset($_SESSION['patient'])) {
                                echo '<a href="BookAppointment.php?doctor_id='.$row['Did'].'" type="button" class="btn btn-success">Book Appoinment</a>';
                            }                
                       ?>
                      
                      
                      <p class="m-0"> Consult Day : <span class="t-ConsultingDay">
                        <?php 
                              $cd=$row['consultDays'];
                              for($i=0; $i<7; $i++){
                                  if($cd[$i]==1){
                                      echo $weekdays[$i].' ';
                                  }
                              }
                         ?>
                      
                      </span></p>
                      <p class=""> Consult Time : <span class="t-ConsultingTime">3pm to 8pm</span></p>
                    </div>

                    <div class="col-md-2"></div>
                    </div>
                    
              <?php  
          }
      ?>
        
        
      
    </div>
  </section>


  <!--Consult-->






  <?php 
    require_once "footer.php";
   ?>

</body>

</html>
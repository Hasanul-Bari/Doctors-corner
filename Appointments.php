<?php 
      require_once "pdo.php";
      session_start();

      if(!isset($_SESSION['doctor'])){
        die("ACCESS DENIED");
      }
      
      $stmt = $pdo->prepare("SELECT Name FROM doctors where Did= :did");
      $stmt->execute(array(
          ":did" => $_SESSION['doctor'])
        );
      $dr = $stmt->fetch(PDO::FETCH_ASSOC);
      
      date_default_timezone_set('Asia/Dhaka');
      $date=new DateTime();
      $today= $date->format('Ymd');

      if( isset($_POST["dt"])){
        
          //echo $_POST["dt"];

          $date=new DateTime($_POST["dt"]);
          $today= $date->format('Ymd');

          
      }

      //echo $today;


      
      
      $sql="SELECT  consultations.Cid, consultations.Pid, patients.Name, consultations.Cdate, consultations.Ctime, consultations.status_
            FROM consultations JOIN patients
            ON consultations.pid=patients.Pid 
            WHERE consultations.Did= :Did and consultations.Cdate= :today
            ORDER BY consultations.Btime";
  
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
              ":Did" => $_SESSION["doctor"],
              ":today" => $today)
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
  <link rel="stylesheet" href="custom/style_Doc.css">
  <link rel="stylesheet" href="custom/responsive.css">

  <!--Fontawsome css-->
  <link rel="stylesheet" href="fontawesome/css/all.css" type="text/css">



  <title>Appointments</title>
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

                <li class="nav-item active">
                  <a class="nav-link" href="Appointments.php">My appointments</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="#">FAQ</a>
                </li>

                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="img/profile.png" class="img-fluid" alt="">&nbsp; <?=htmlentities($dr['Name'])?> </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="doctorProfile.php">Profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
                </div></li>
                            
                    

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
        <div class="col-md-2"></div>
        <div class="col-md-8 text-center">
          <h3>Appointments on <?= $date->format('l, jS  F Y') ?> </h3>
        </div>
        <div class="col-md-2"></div>
      </div>
      <div class="row my-3">
        <div class="col-md-2"></div>
        <div class="col-md-8 text-center">
          <h3 class="t-status">Status</h3>
          <button type="button" class="btn btn-success">Start Consulting</button>
          <button type="button" class="btn btn-danger">Stop Consulting</button>
        </div>
        <div class="col-md-2"></div>
      </div>
      
        
        
        <?php 
              if($rows==false)
              {
                echo '<div class="row my-3">';
                echo '<div class="col-md-2"></div>';
                echo '<div class="col-md-8 text-center"> <h3> No consultation </h3> </div>';
                echo '<div class="col-md-2"></div>';

              }
              else
              {
                foreach ( $rows as $row ){

                  $status=htmlentities($row["status_"]);
  
                  ?>
                      <div class="row my-3">
                      <div class="col-md-2"></div>
                      <div class="col-md-8 border rounded border-dark py-3">
                        <h5>Patient name: <?= htmlentities($row['Name']) ?> </h5>
                        <h5>Time : <?= htmlentities($row['Ctime']) ?></h5>
  
                        <a href="PatientProfile.php?patient_id=<?= htmlentities($row['Pid']) ?>" type="button" class="btn btn-primary">Details</a>
  
                        <?php 
                          if($status==1){
                        
                        ?>
                            <button type="button" class="btn btn-outline-success" disabled>Finished</button>
                        <?php 
                          }
                          else{
                        ?>
                            
                            <a type="button" class="btn btn-primary" href="prescription.php?cid=<?= $row['Cid']?>">Write prescription</a>
                            <a type="button" class="btn btn-success">Meeting</a>
                        <?php 
                          }
                        ?>
                        
                        
                      </div>
                      <div class="col-md-2"></div>
                      </div>
                  <?php 
                }

              }

              
         ?>

        
        

        <div>

              <br><br>
              <h4>See appointments for a specific date</h4>
              <form action="Appointments.php" method="POST">

              <label for="dt"> <h4>Select date : </h4></label>
              <input type="date" id="dt" name="dt" min="1900-01-01" max="2099-01-01" required>

              <input type="submit"  class="btn btn-success" value="Go"> 


              </form>

        </div>
        
        
      
    </div>
  </section>


  <!--Consult-->
  
  <?php 
    require_once "footer.php";
   ?>


  </body>

</html>
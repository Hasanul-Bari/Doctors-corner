<?php
    require_once "pdo.php";
    session_start();

 
    if(!isset($_GET["cid"])){
      die("Bad parameter");
    }


    // fetching doctor and patient info

    $sql="SELECT  patients.Name AS Pname, patients.DOB,  doctors.Name AS Dname, departments.dept_name, prescription.date_, prescription.medicines
          FROM consultations JOIN patients JOIN doctors JOIN departments JOIN prescription
          ON consultations.Pid=patients.Pid AND consultations.Did=doctors.Did And doctors.dept_id=departments.dept_id And consultations.Cid=prescription.Cid
          WHERE consultations.Cid= :cid";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
            ":cid" => $_GET["cid"])
          );
    $info = $stmt->fetch(PDO::FETCH_ASSOC);

    // calculating age
    $bd=htmlentities($info["DOB"]);

    $today = new DateTime();
    $bday = new DateTime($bd);
  
    $age = $today->diff($bday);

    $meds=htmlentities($info['medicines']);
    $prescriptionDate=htmlentities($info['date_']);

    
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
  <link rel="stylesheet" href="custom/prescription.css">
  <link rel="stylesheet" href="custom/responsive.css">

  <!--Fontawsome css-->
  <link rel="stylesheet" href="fontawesome/css/all.css" type="text/css">



  <title>Prescription</title>
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
                <?php 
                    if(isset($_SESSION['doctor'])){
                ?>
                      <li class="nav-item">
                      <a class="nav-link" href="Appointments.php">My appointments</a>
                      </li>
                <?php 
                    }
                ?>

                <li class="nav-item">
                  <a class="nav-link" href="#">FAQ</a>
                </li>

                <?php 
                      if(isset($_SESSION['patient'])){
                        ?>
                            <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="img/profile.png" class="img-fluid" alt="">&nbsp; <?= htmlentities($info['Pname']) ?> </a>
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
                            <img src="img/profile.png" class="img-fluid" alt="">&nbsp; <?= htmlentities($info['Dname'])?> </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="doctorProfile.php">Profile</a>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                            </div></li>
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

  <div class="row my-3">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <h3>Doctor: <?=  htmlentities($info["Dname"])  ?></h3>
        <h4><?= htmlentities($info["dept_name"])  ?> specilist</h4>

        <hr>

        <div class="row my-3">
          <div class="col-md-7">Patient's Name: <?= htmlentities($info["Pname"])  ?> </div>
          <div class="col-md-3">Age: <?= $age->y ?> years <?= $age->m ?> months</div>
          <div class="col-md-2">Date: <?= $prescriptionDate ?></div>
          
        </div>
        <br>


        <ol>

          <?php 

            $medicines=explode(PHP_EOL, $meds);
          
            foreach($medicines as $medicine){

              if(strlen($medicine)!=0 ){

                $infoM=explode(" ",$medicine);

                echo '<li>';
                echo $infoM[0];
                  echo '<ul>';
                    echo '<li>';
                      echo 'for '.$infoM[1].' days';
                    echo '</li>';

                    echo '<li>';
                      echo $infoM[2].' eating';
                    echo '</li>';

                    echo '<li>';
                      echo $infoM[3];
                    echo '</li>';

                  echo '</ul>';

                echo '</li>';
              }

            }
          
          
          ?>

        </ol>

        



        

        

        


    </div>
    <div class="col-md-1"></div>
  </div>



    
  </section>


  <!--Consult-->

  <?php 
    require_once "footer.php";
   ?>



 

</body>

</html>
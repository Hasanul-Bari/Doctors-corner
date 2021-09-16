<?php
    require_once "pdo.php";
    session_start();
    
    if(isset($_SESSION['patient'])){
      $stmt = $pdo->prepare("SELECT Name FROM patients where Pid= :pid");
      $stmt->execute(array(
          ":pid" => $_SESSION['patient'])
        );
      $pt = $stmt->fetch(PDO::FETCH_ASSOC);
      
      $nm= htmlentities($pt['Name']);
      
            
    }
    else{
      die("ACCESS DENIED");
    }
    
    
    if( isset($_POST["Apntday"]) && isset($_POST["bkash"]) && isset($_POST["txid"]) && isset($_POST["pid"]) && isset($_POST["did"]) && isset($_POST["consultDays"]) && isset($_POST["confirm"]) ){
      
      

        $bookingTime=time();    //current time
        $appointmentDay=(int)($_POST["Apntday"]);

        // finding maximum no of appointments that day can have
        $Max_appointments= (int)$_POST[$_POST["Apntday"]];



        

        //cheching if the doctor has available consultations

        $stmt = $pdo->prepare("SELECT current_count FROM consultation_Count where Did= :did and date_= :dt");
              $stmt->execute(array(
                  ":did" => $_POST["did"],
                  ":dt" => $_POST["Apntday"])
                );
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $current_appointments=0;

        if ( $row !== false ){
          $current_appointments=(int)$row['current_count'];
        }


        //requested appointment can be accepted
        if($current_appointments+1 <= $Max_appointments){
          $current_appointments++;

          if($row === false){
            $sql = "INSERT INTO consultation_Count (Did, date_, current_count) VALUES (:did, :dt, :cn)";

              $stmt = $pdo->prepare($sql);
              $stmt->execute(array(
                ":did" => $_POST["did"],
                ":dt" => $_POST["Apntday"],
                ":cn" => $current_appointments)
              );
          }
          else{
            $sql = "UPDATE consultation_Count SET  current_count = :cn
                        WHERE Did = :did and date_= :dt";
                        
              $stmt = $pdo->prepare($sql);
              $stmt->execute(array(
                ":did" => $_POST["did"],
                ":dt" => $_POST["Apntday"],
                ":cn" => $current_appointments)
              );
          }
        }
        //requested appointment can't be accepted
        else{
          $_SESSION['error'] = 'Maximum appointments limit exceeds for requested day';
          header('Location: BookAppointment.php?doctor_id='.$_POST["did"]);
          return;
        }
        
        
        
        $sql = "INSERT INTO consultations (Pid, Did, Cdate, Btime, Bkash, Txid) VALUES (:pid, :did, :cdate, :btime, :bkash, :txid)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
          ":pid" => $_POST["pid"],
          ":did" => $_POST["did"],
          ":cdate" => $appointmentDay,
          ":btime" => $bookingTime,
          ":bkash" => $_POST["bkash"],
          ":txid" => $_POST["txid"])
        );
      
        $_SESSION['success'] = 'Appointment booked successfully';
        header('Location: BookAppointment.php?doctor_id='.$_POST["did"]);
        return;
      
    }
    
    
    
    
  
    
    if ( ! isset($_GET['doctor_id']) ){
        die("Bad parameter");
    }
    else{
      $stmt = $pdo->prepare("SELECT Name, consultDays FROM doctors where Did= :did");
      $stmt->execute(array(
          ":did" => $_GET['doctor_id'])
        );
      $dr = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    $consultDays=$dr['consultDays'];
    
    
    
    
  
    date_default_timezone_set('Asia/Dhaka');
    $date=new DateTime();
    $todayNo= $date->format('N');        // returns weekday number // monday=1
        
    
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
  <link rel="stylesheet" href="custom/style_Book.css">
  <link rel="stylesheet" href="custom/responsive.css">

  <!--Fontawsome css-->
  <link rel="stylesheet" href="fontawesome/css/all.css" type="text/css">



  <title>Book Appoinment</title>
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
                <li class="nav-item active">
                  <a class="nav-link" href="">Book Appointment</a>
                </li>
                
              
                      
                <li class="nav-item dropdown">
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
          
          <h5>Doctor's name: <?=htmlentities($dr['Name'])?></h5>
          <h4>Appointment available on</h4>
          
          
            <form  action="BookAppointment.php" method="post">
                  
                         
                  <fieldset class="form-group">
                    
                    <?php 
                    
                      for ($i=1, $d=$todayNo; $i<=7; $i++, $d++) {
                          
                          if($d===8){
                              $d=1;
                          }
                          
                          $displaydate=$date->format('l, jS  F Y');
                          $dbdate=$date->format('Ymd');
                                          
                          $date->modify( '+1 days' );
                          
                          if($consultDays[($d-1)*9]=='1'){

                            $index=($d-1)*9;
                            $time= substr($consultDays,$index+1,5);
                            $NoOfAppointment= substr($consultDays,$index+6,3);

                            $time_12hr=new DateTime($time);
                            $time= $time_12hr->format('h:i a');

                            $displaydate=$displaydate.' at '.$time;
                              
                              
                              echo '<div class="form-check">';
                              echo '<label class="form-check-label">';
                              echo '<input type="radio" class="form-check-input" name="Apntday" value="'.$dbdate.'" required>'.$displaydate.'</label></div>';

                              echo '<input type="hidden" name="'.$dbdate.'" value="'.$NoOfAppointment.'">';
                          }               
                          
                        }
                     ?>
                    
                  </fieldset>
                  
                  
                  <div class="input-group input-group-sm my-3">
                    <div class="input-group-prepend ">
                      <span class="input-group-text" id="inputGroup-sizing-sm">Enter Phone no.[Bkash]</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="bkash" required>
                  </div>
                  <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend ">
                      <span class="input-group-text" id="inputGroup-sizing-sm">Enter Transaction ID</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="txid" required>
                  </div>
                  
                  
                  <input type="hidden" name="pid" value="<?= $_SESSION['patient'] ?>">
                  <input type="hidden" name="did" value="<?= $_GET['doctor_id'] ?>">

                  <input type="hidden" name="consultDays" value="<?= $dr['consultDays'] ?>">
                  
                  
                  
        
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="inputGroupFile04">
                      <label class="custom-file-label" for="inputGroupFile04">Upload Reports (if required)</label>
                    </div>
                    <div class="input-group-append">
                      <button class="btn btn-outline-success" type="button">Upload</button>
                    </div>
                  </div>
        
                  <input type="submit" name="confirm" value="Confirm" class="btn btn-success mt-2">
                  
            </form>
            
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
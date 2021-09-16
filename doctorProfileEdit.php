<?php 
      require_once "pdo.php";
      session_start();
      
      if(!isset($_SESSION['doctor'])){
        die("ACCESS DENIED");
      }
  
      
      if(isset($_POST["Dname"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["quali"]) && isset($_POST["exp"]) && isset($_POST["about"]) &&isset($_POST["save"]) ){
            
            
          ///duplicate email check
          $stmt = $pdo->prepare("SELECT Email FROM doctors where Email= :em");
          $stmt->execute(array(
                  ":em" => $_POST["email"])
                );
          $row = $stmt->fetch(PDO::FETCH_ASSOC);



          $stmt = $pdo->prepare("SELECT Email FROM doctors where Did= :did");
          $stmt->execute(array(
                  ":did" => $_SESSION['doctor'])
                );
          $row2 = $stmt->fetch(PDO::FETCH_ASSOC);

          if ( $row !== false &&  $row['Email']!==$row2['Email'] ){
            
              $_SESSION['error'] = 'Id with this email already exist';
              header( 'Location: doctorProfileEdit.php' ) ;
              return;

          }  
          
          
          
                
          //generating consult days
          $cd='';
          for($i=1; $i<=7; $i++){

            // If the day is selected
            if( isset($_POST['day'.$i]) ){

              $NoOfAppointments=$_POST['Atno'.$i];

              if($NoOfAppointments<'10'){
                $NoOfAppointments='00'.$NoOfAppointments;
              }
              else if($NoOfAppointments<'100'){
                $NoOfAppointments='0'.$NoOfAppointments;
              }

                

                $cd=$cd.'1'.$_POST['tm'.$i].$NoOfAppointments;
               
            }
            //for days not selected
            else{
              $cd=$cd.'0tt:ttnnn';
            }
            /*echo $cd;
            echo "<br>";*/
          }
          
          
          $sql = "UPDATE doctors SET  Name = :nm, Email=:em, Phone=:ph, Qualification=:quali, Experience=:expr, about=:abt, consultDays=:cd
                  WHERE Did = :did";
                      
                      
          $stmt = $pdo->prepare($sql);
          $stmt->execute(array(
            ":nm" => $_POST["Dname"],
            ":em" => $_POST["email"],
            ":ph" => $_POST["phone"],
            ":quali" => $_POST["quali"],
            ":expr" => $_POST["exp"],
            ":cd" => $cd,
            ":abt" => $_POST["about"],
            ":did" => $_SESSION['doctor'])

          );
        
  
          header("Location: doctorProfile.php");
          return;
          
          
          
            
            
      }
      
      $stmt = $pdo->prepare("SELECT * FROM doctors where Did= :did");
      $stmt->execute(array(
          ":did" => $_SESSION['doctor'])
        );
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
      $name=htmlentities($row['Name']);
      $email=htmlentities($row['Email']);
      $ph=htmlentities($row['Phone']);
      $quali=htmlentities($row['Qualification']);
      $exp=htmlentities($row['Experience']);
      $abt=htmlentities($row['about']);
      $cd=htmlentities($row['consultDays']);
      
      
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
  <link rel="stylesheet" href="custom/style_Admin.css">
  <link rel="stylesheet" href="custom/responsive.css">

  <!--Fontawsome css-->
  <link rel="stylesheet" href="fontawesome/css/all.css" type="text/css">



  <title>Doctor-Edit Doctor</title>
</head>

<body>

  <!--  NavBar -->

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
                  <a class="nav-link" href="#">FAQ</a>
                </li>
                
                <li class="nav-item dropdown active">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="img/profile.png" class="img-fluid" alt="">&nbsp; <?=htmlentities($row['Name'])?> </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="doctorProfile.php">Profile</a>
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
  
  
  
  <section>
    <div class="container">
      <div class="row mt-3">
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <div class="row">
            
            <div class="col-md-12 text-center">
              <h3>Edit Profile</h3>
              <?php 
                    if ( isset($_SESSION['error']) ) {
                        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
                        unset($_SESSION['error']);
                    }
              ?>
            </div>
            
          </div>
          <div class="row border border-dark rounded my-3">
            <div class="col-md-1"></div>
            <div class="col-md-10 py-3">
              
              <form action="doctorProfileEdit.php" method="post">
                
                <div class="form-group">
                  <label for="DocName">Name</label>
                  <input type="text" class="form-control"  id="DocName" name="Dname" value="<?= $name?>" required >
                </div>
                
                <div class="form-group">
                  <label for="emailid">Email</label>
                  <input type="email" class="form-control" id="emailid" name="email" value="<?= $email?>" required>
                </div>
                
                <div class="form-group">
                    <label for="tel-input" class="col-form-label">Contact No</label>
                    <div class="">
                      <input class="form-control" type="tel" name="phone"  id="tel-input" pattern="[0]{1}[1]{1}[0-9]{9}" value="<?= $ph?>"  required>
                    </div>
                </div>
                
                

                <p class="mt-3">Qualifications</p>

                <div class="input-group">                                
                  <textarea class="form-control" name="quali" > <?= $quali?> </textarea>
                </div>
                
                <p class="mt-3">Experience</p>

                <div class="input-group">                                
                  <textarea class="form-control" name="exp" > <?= $exp?> </textarea>
                </div>



                <p class="mt-3">Consultation Dates</p>
                
                <?php 
                      for($i=1; $i<=7; $i++){

                        $index=($i-1)*9;
                        $ch= ($cd[$index]=='1') ? 'checked' : '';
                        $display= ($cd[$index]=='0') ? 'style="display:none"' : '';

                        $time= ($cd[$index]=='1') ? 'value="'.substr($cd,$index+1,5).'"' : '';
                        $NoOfAppointment= ($cd[$index]=='1') ? 'value="'.substr($cd,$index+6,3).'"' : '';


                        

                        
                          echo '<div class="form-check">';
                          echo '<input class="form-check-input" type="checkbox" value="'.$i.'" name="day'.$i.'" '.$ch.'>';
                          echo '<label class="form-check-label">'.$weekdays[$i-1].'</label></div>';



                          echo '<div id="toggleee'.$i.'" '.$display.'>';
                          echo '<div class="form-group">';
                          echo '<label for="timeinput">Enter time: </label>';
                          echo '<input type="time" class="form-control" '.$time.' name="tm'.$i.'"  >';
                          echo '</div>';
                          echo '<div class="form-group">';
                          echo '<label for="appntNo">Max appointment allowed: </label>';
                          echo '<input type="number" class="form-control" '.$NoOfAppointment.'  name="Atno'.$i.'"  min="1" max="100" >';
                          echo '</div>';
                          echo '</div>';


                          


                      }
                              
                 ?>
    
                
                <p class="mt-3">About</p>

                <div class="input-group">                                
                  <textarea class="form-control" name="about"> <?= $abt?> </textarea>
                </div>



                <input type="submit" name="save" value="Save" class="btn btn-success mt-2">
              </form>
            </div>
            <div class="col-md-1"></div>
          </div>
        </div>
        <div class="col-md-3"></div>

      </div>
    </div>
  </section>
  



  <?php 
    require_once "footer.php";
   ?>  


  <script type="text/javascript">

  $(document).ready(function() {

      $('input[type="checkbox"]').change(function(){

          var toggleid=$(this).attr("value");
          

          toggleid='#toggleee'+toggleid;

          //console.log(toggleid);
          
          $(toggleid).toggle();
      });

  });

  </script>

</body>

</html>
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
        
        
        if ( isset($_POST["Pname"]) &&  isset($_POST["dob"]) && isset($_POST["phone"]) && isset($_POST["gender"]) && isset($_POST["weight"]) && isset($_POST["height"])  ){
              
              $re="~^[0-9]+(\.[0-9]+)?$~";
              
              if(preg_match($re, $_POST["weight"])==0){
                $_SESSION['error'] = 'Enter a valid weight';
                header( 'Location: PatientProfileEdit.php' ) ;
                return;
              }
              if(preg_match($re, $_POST["height"])==0){
                $_SESSION['error'] = 'Enter a valid height';
                header( 'Location: PatientProfileEdit.php' ) ;
                return;
              }
              
              $sql = "UPDATE patients SET  Name = :nm, Phone=:ph, DOB = :bd, Gender = :gn, Weight = :wt, Height=:ht
                        WHERE Pid = :pid";
                        
              $stmt = $pdo->prepare($sql);
              $stmt->execute(array(
                ":nm" => $_POST["Pname"],
                ":ph" => $_POST["phone"],
                ":bd" => $_POST["dob"],
                ":gn" => $_POST["gender"],
                ":wt" => $_POST["weight"],
                ":ht" => $_POST["height"],
                ":pid" => $_SESSION['patient'])
                
                
              );
              
              $_SESSION['success'] = 'Profile updated successfully';
              header( 'Location: PatientProfile.php' ) ;
              return;
        }
        
              
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
          <h5>Name: <?= $nm ?></h5>
          <h4>Contact : <?= $ph ?></h4>

        </div>
        <div class="col-md-2"></div>
      </div>
      <div class="row mt-3">
        <div class="col-md-2"></div>
        <div class="col-md-8 border border-dark rounded py-3 mb-3">
          <h3 class="text-center">Edit Profile</h3>
          
          <?php
              if ( isset($_SESSION["error"]) ) {
                  echo('<p style="color: red;">'.htmlentities($_SESSION["error"])."</p>\n");
                  unset($_SESSION['error']);
              }
           ?>

          
          <form action="PatientProfileEdit.php" method="post">

               <div class="form-group">
                 <label  for="Name">Name</label>
                 <input type="text" class="form-control" id="Name" name="Pname"  value="<?= $nm ?>" required>
               </div>
               
               <div class="form-group">
                 <label for="date-input">Date of Birth</label>
                   <input class="form-control" type="date" name="dob" id="date-input" value="<?= $bd ?>" required>
               </div>

               <fieldset class="form-group">
                   <legend>Gender</legend>
                   <div class="form-check">
                      <label class="form-check-label">
                       <input type="radio" class="form-check-input" name="gender" value="Male" <?=$gd === 'Male' ? 'checked' : '';?> >Male
                       </label>
                   </div>
                   
                   <div class="form-check">
                     <label class="form-check-label">
                         <input type="radio" class="form-check-input" name="gender" value="Female" <?=$gd === 'Female' ? 'checked' : '';?>>Female
                     </label>
                   </div>
               </fieldset>


               <div class="form-group">
                   <label for="tel-input" class="col-form-label">Contact No</label>
                   <div class="">
                     <input class="form-control" type="tel" name="phone"  id="tel-input" pattern="[0]{1}[1]{1}[0-9]{9}" value="<?= $ph ?>" required>
                   </div>
               </div>


               <div class="form-group">
                 <label  for="Weight">Weight in KG</label>
                 <input type="text" class="form-control" name="weight" id="Weight"  value="<?= $wt ?>" required>
               </div>
             
             
               <div class="form-group">
                   <label  for="Height">Height in cm</label>
                   <input type="text" class="form-control" name="height" id="Height"  value="<?= $ht ?>" required>
               </div>


               <input type="submit" class="btn btn-primary" value="Save Profile">
         </form>

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
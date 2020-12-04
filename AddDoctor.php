<?php 
      require_once "pdo.php";
      session_start();
      
      if(!isset($_SESSION['admin'])){
        die("ACCESS DENIED");
      }
  
      
      if(isset($_POST["Dname"]) && isset($_POST["email"]) && isset($_POST["pass"]) && isset($_POST["dept"]) && isset($_POST["quali"]) &&isset($_POST["confirm"]) ){
            
            
            $stmt = $pdo->prepare("SELECT Email FROM doctors where Email= :em");
            $stmt->execute(array(
                ":em" => $_POST["email"])
              );
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ( $row !== false ){
              $_SESSION['error'] = 'Id with this email already exist';
              header( 'Location: AddDoctor.php' ) ;
              return;
            }
            
            $sk='arrow/*/-';
            $pass=hash('md5', $sk.$_POST['pass']);
            
            
            //generating consult days
            $cd='0000000';
            for($i=1; $i<=7; $i++){
              if( isset($_POST['day'.$i]) ){
                  $cd[$i-1]='1';
              }
            }
            
            
            $sql = "INSERT INTO doctors (Name, Email, Pass, dept_id, Qualification, consultDays) VALUES (:nm, :em, :pw, :dpid, :quali, :cd)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
              ":nm" => $_POST["Dname"],
              ":em" => $_POST["email"],
              ":pw" => $pass,
              ":dpid" => $_POST["dept"],
              ":quali" => $_POST["quali"],
              ":cd" => $cd)

            );
          
            $_SESSION['success'] = "Doctor added successfully";
            header("Location: AddDoctor.php");
            return;
            
            
        
      }
      
      $stmt = $pdo->query("SELECT * FROM departments");
      $depts = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
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



  <title>AdminPanel-Add Doctor</title>
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
                  <a class="nav-link" href="AdminPanel.php">Admin Panel</a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="AddDoctor.php">Add Doctor</a>
                </li>
                          
                <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="img/profile.png" class="img-fluid" alt="">&nbsp; Admin </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
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
              <h3>Add Doctor</h3>
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
            
          </div>
          <div class="row border border-dark rounded my-3">
            <div class="col-md-1"></div>
            <div class="col-md-10 py-3">
              
              <form action="AddDoctor.php" method="post">
                
                <div class="form-group">
                  <label for="DocName">Name of the Doctor</label>
                  <input type="text" class="form-control"  id="DocName" name="Dname" required >
                </div>
                
                <div class="form-group">
                  <label for="emailid">Email address</label>
                  <input type="email" class="form-control" id="emailid" name="email" required>
                </div>
                <div class="form-group">
                  <label for="pwid">Password</label>
                  <input type="password" class="form-control" id="pwid" name="pass" required>
                </div>
                
                <select class="form-control" name="dept" required>
                  <option value="">Select Department</option>
                  <?php 
                        foreach ($depts as $dept) {
                            echo "<option value=".$dept['dept_id'].">".htmlentities($dept['dept_name'])."</option>";
                        }
                   ?>
                </select>

                <p class="mt-3">Qualifications</p>

                <div class="input-group">                                
                  <textarea class="form-control" name="quali" ></textarea>
                </div>



                <p class="mt-3">Select Consultation Dates</p>

                
                <?php 
                      for($i=1; $i<=7; $i++){
                          echo '<div class="form-check">';
                          echo '<input class="form-check-input" type="checkbox" value="'.$i.'" name="day'.$i.'">';
                          echo '<label class="form-check-label">'.$weekdays[$i-1].'</label></div>';
                      }
                              
                 ?>


                <input type="submit" name="confirm" value="Confirm" class="btn btn-success mt-2">
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
      $date=new DateTime();
      //$date->modify( '+1 days' );
      //$date->modify( '+1 days' );
      //$date->modify( '+1 days' );
      $weekday= $date->format('N');
      echo $weekday;
      
   ?>








  
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>
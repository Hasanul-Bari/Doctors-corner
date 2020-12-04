<?php 
    require_once "pdo.php";
    session_start();

    if(!isset($_SESSION['admin'])){
      die("ACCESS DENIED");
    }
    
    if(isset($_POST["dept_name"]) && isset($_POST["about"]) && isset($_POST["add"]) ){
      
        $sql = "INSERT INTO departments (dept_name, about) VALUES (:dn, :abt)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
              ':dn' => $_POST['dept_name'],
              ':abt' => $_POST['about'])
        );

        $_SESSION['success'] = "Department added successfully";
        header("Location: AddDepartment.php");
        return;
      
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
  <link rel="stylesheet" href="custom/style_Admin.css">
  <link rel="stylesheet" href="custom/responsive.css">

  <!--Fontawsome css-->
  <link rel="stylesheet" href="fontawesome/css/all.css" type="text/css">



  <title>AdminPanel-Add Department</title>
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
                  <a class="nav-link" href="AdminPanel.php">Admin Panel</a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="AddDoctor.php">Add Department</a>
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
      <div class="row">
        <div class="col-md-12 text-center text-primary">
          <h3>Add Department</h3>
          <?php 
          if ( isset($_SESSION['success']) ) {
              echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
              unset($_SESSION['success']);
           }
          ?>
        </div>
      </div>
      
      
      <div class="row my-3">
        <div class="col-md-3"></div>
        <div class="col-md-6 py-3 border border-dark rounded">
          
          
          <form action="AddDepartment.php" method="post">
            <div class="form-group">
              <label>Name of the Department</label>
              <input type="text" class="form-control" name="dept_name">
            </div>
            
            <p class="mt-3">About</p>

            <div class="input-group">                                
              <textarea class="form-control" name="about" ></textarea>
            </div>

            <input type="submit" name="add" value="Add" class="btn btn-success mt-2">
          </form>
          
          
        </div>
        <div class="col-md-3"></div>
      </div>

    </div>
  </section>





  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>
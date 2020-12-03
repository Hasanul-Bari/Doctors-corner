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
  <link rel="stylesheet" href="custom/style_DeptList.css">
  <link rel="stylesheet" href="custom/responsive.css">

  <!--Fontawsome css-->
  <link rel="stylesheet" href="fontawesome/css/all.css" type="text/css">



  <title>Departments</title>
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
                        echo '<li class="nav-item dropdown">';
                        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                        echo '<img src="img/profile.png" class="img-fluid" alt="">&nbsp;'.htmlentities($pt['Name']).'</a>';
                        echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                        echo '<a class="dropdown-item" href="PatientProfile.php">Profile</a>';
                        echo '<a class="dropdown-item" href="logout.php">Logout</a>';
                        echo '</div></li>';
                    }
                    else{
                        echo '<li class="nav-item">';
                          echo '<a class="nav-link" href="signin.php">Sign in</a>';
                        echo '</li>';
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
      <div class="row mt-3">
        <div class="col-md-3"></div>
        <div class="col-md-6 border border-dark rounded my-3">
          <a href="#">
            <h4 class="mt-3">Cardiology</h4>
          </a>
          <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum fugit accusantium eos. Laborum aliquam, maxime explicabo nisi dolore aliquid eveniet impedit distinctio laudantium minus numquam doloremque veniam quaerat inventore
            at voluptatem autem eius dicta iusto aut animi! Maxime nesciunt natus corporis quaerat similique, facilis, fuga atque ducimus unde ipsum et?</p>
        </div>
        <div class="col-md-3"></div>
      </div>

    </div>
  </section>


  <!--Consult-->

    
  <?php 
    require_once "footer.php";
   ?>
    
    
</body>

</html>
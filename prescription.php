<?php
    require_once "pdo.php";
    session_start();

    if(!isset($_SESSION["doctor"])){
      die("ACCESS DENIED");
    }
    

    if(isset($_POST['save']) && isset($_POST['cid']) && isset($_POST['date'])){

      
      //print_r($_POST);

      $medicines="";

      for($i=1; $i<=20; $i++){

        if(isset($_POST['m'.$i])){

          $md=htmlentities($_POST['m'.$i]);
          $d=htmlentities($_POST['daysM'.$i]);
          $t=htmlentities($_POST['timeM'.$i]);
          $m=htmlentities($_POST['morningM'.$i]);
          $n=htmlentities($_POST['noonM'.$i]);
          $e=htmlentities($_POST['eveningM'.$i]);

            $medicine="";
            $medicine=$md.' '.$d.' '.$t.' '.$m.'+'.$n.'+'.$e;

            $medicines=$medicines.$medicine.PHP_EOL;
        }
      }
      echo $medicines;

      $sql = "INSERT INTO prescription (Cid, medicines, date_) VALUES (:cid, :md, :dt)";

      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
          ":cid" => $_POST["cid"],
          ":md" => $medicines,
          ":dt" => $_POST["date"])
      );

      $sql = "UPDATE consultations SET  status_=:s
                        WHERE Cid = :cid";
                        
              $stmt = $pdo->prepare($sql);
              $stmt->execute(array(
                ":s" => 1,
                ":cid" => $_POST['cid'])
              );

      //$_SESSION['success'] = 'Prescription saved successfully';
      header('Location: Appointments.php');
      return;

    }

    if(!isset($_GET["cid"])){
      die("Bad parameter");
    }


    // fetching doctor and patient info

    $sql="SELECT  patients.Name AS Pname, patients.DOB,  doctors.Name AS Dname, departments.dept_name
          FROM consultations JOIN patients JOIN doctors JOIN departments 
          ON consultations.Pid=patients.Pid AND consultations.Did=doctors.Did And doctors.dept_id=departments.dept_id
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
                <li class="nav-item active">
                  <a class="nav-link" href="Appointments.php">My appointments</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">FAQ</a>
                </li>

                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="img/profile.png" class="img-fluid" alt="">&nbsp; <?= htmlentities($info["Dname"]) ?> </a>
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
          <div class="col-md-2">Date: <?= $today->format("d/m/Y") ?></div>
          
        </div>
        <br>

        <form action="prescription.php" method="POST">

        <div id="medicines">
          
          <!-- <div id="medicine1">
            <h4>Medicine 1</h4>
            <p>
              <label for="m1">Medicine Name : </label>
              <input type="text" name="m1" id="m1" size="30"> &nbsp;&nbsp;

              <label for="days">For </label>
              <input type="number" name="days" id="days" size="10" min="1">
              <label for="days"> days </label> &nbsp; &nbsp; &nbsp;

              <input type="radio" id="beforeeat" name="Etime">
              <label for="beforeeat" name="Etime">Before Eating</label>

              &nbsp;
              <input type="radio" id="aftereat" name="Etime">
              <label for="aftereat" name="Etime">After Eating</label>

            </p>

            <p>
              <label for="morning">Morning:</label>
              <select name="morning" id="morning">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
              </select> &nbsp;&nbsp;&nbsp;

              <label for="noon">Noon:</label>
              <select name="noon" id="noon">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
              </select> &nbsp;&nbsp;&nbsp;



              <label for="evening">Evening:</label>
              <select name="evening" id="evening">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
              </select>

            </p>

            <p>
              
            </p>
            
          </div> -->

        </div>

        <input type="submit" class="btn btn-success" id="addMed" value="Add Medicine">
        <input type="submit" class="btn btn-danger" id="removeMed" value="-">

        <br><br>

        <input type="hidden" name="cid" value="<?= $_GET["cid"] ?>">
        <input type="hidden" name="date" value="<?= $today->format("d/m/Y") ?>">


        <input type="submit" class="btn btn-primary" name="save" value="Save Prescription">

        </form>

        

        


    </div>
    <div class="col-md-1"></div>
  </div>



    
  </section>


  <!--Consult-->

  <?php 
    require_once "footer.php";
   ?>



  <script>

    countMed=0;

    $(document).ready(function () {

      //add new medicine div
      $("#addMed").click(function (e) { 
        e.preventDefault();

        if(countMed>=20 ) {
            alert("Maximum of twenty medicine entries exceeded");
            return;
        }

        
        countMed++;
        $("#medicines").append(

          '<div id="medicine'+countMed+'">'+
          '<h4>Medicine '+countMed+'</h4>'+
            '<p>'+
                '<label for="m'+countMed+'">Medicine Name : &nbsp;</label>'+
                '<input type="text" name="m'+countMed+'" id="m'+countMed+'" size="30" required> &nbsp;&nbsp;&nbsp;'+

                '<label for="daysM'+countMed+'">For &nbsp;</label>'+
                '<input type="number" name="daysM'+countMed+'" id="daysM'+countMed+'" size="10" min="1" max="365" required>&nbsp;'+
                '<label abel for="daysM'+countMed+'"> days </label> &nbsp; &nbsp; &nbsp;'+

                '<input type="radio" id="bEat'+countMed+'" name="timeM'+countMed+'" value="before" required>'+
                '<label for="bEat'+countMed+'">&nbsp; Before Eating</label> &nbsp;'+

                '<input type="radio" id="aEat'+countMed+'" name="timeM'+countMed+'" value="after" required>'+
                '<label for="aEat'+countMed+'">&nbsp; After Eating</label>'+

              '</p>'+

              '<p>'+
                '<label for="morningM'+countMed+'">Morning:&nbsp;</label>'+
                '<select name="morningM'+countMed+'" id="morningM'+countMed+'">'+
                  '<option value="0">0</option>'+
                  '<option value="1">1</option>'+
                  '<option value="2">2</option>'+
                '</select> &nbsp;&nbsp;&nbsp;'+

                '<label for="noonM'+countMed+'">Noon:&nbsp;</label>'+
                '<select name="noonM'+countMed+'" id="noonM'+countMed+'">'+
                  '<option value="0">0</option>'+
                  '<option value="1">1</option>'+
                  '<option value="2">2</option>'+
                '</select> &nbsp;&nbsp;&nbsp;'+



                '<label for="eveningM'+countMed+'">Evening:&nbsp;</label>'+
                '<select name="eveningM'+countMed+'" id="eveningM'+countMed+'">'+
                  '<option value="0">0</option>'+
                  '<option value="1">1</option>'+
                  '<option value="2">2</option>'+
                '</select>'+

              '</p>'+

              '<p>'+
                
              '</p>'+

              '</div>'
        );
        
      });


      //remove last medicine div

      $("#removeMed").click(function (e) { 
        e.preventDefault();

        if(countMed>0){
          id="#medicine"+countMed;
          $(id).remove();

          countMed--;

        }


        
      });


      
    });



  </script>

</body>

</html>
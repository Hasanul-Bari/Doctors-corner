<?php

  $pdo=new PDO("mysql:host=localhost;port=3306;dbname=tmc","Hasan","arrow");

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/connectdb.php";?>
  <title>Admin | New Class</title>
</head>

<body>

  <header>
    <h1>New Class</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    //Process form input
    var_dump($_POST);
    //get array of dates and times
    $date = $_POST['start-date'];
    $end_date = $_POST['end-date'];
    while (strtotime($date) <= strtotime($end_date)) {
      $dayOfWeek = date('w', strtotime($date));
      echo $dayOfWeek;

      $date = date ('Y-m-d', strtotime('+1 day', strtotime($date)));
    }




    //Create SQL query
    $query = <<<EOT
    INSERT INTO classes (class_type, date_of_class, time_of_class, arena, horse, tack, special_tack, stirrup_leather_length, pad, clients, instructor, therapist, equine_specialist, leader, sidewalkers)
    VALUES ('{$_POST['class-type']}', {$specificDate}, {$specificTime}, '{$_POST['arena']}', {$horseID}, '{$_POST['tack']}', '{$_POST['special-tack']}', '{$_POST['stirrup-leather-length']}', '{$_POST['pad']}', {$clientIDList}, {$instructorID}, {$therapistID}, {$esID}, {$leaderID}, {$sidewalkerIDList});
EOT;

    //Modify database
    $result = pg_query($db_connection, $query);
    if ($result) {
      echo "<h3 class='main-content-header'>Success</h3";
    } else {
      echo "<h3 class='main-content-header>An error occured.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
    }
  ?>



</body>

</html>

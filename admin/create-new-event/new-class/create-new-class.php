<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | New Class</title>
</head>

<body>

  <header>
    <h1>New Class</h1>
    <nav>
      <a href="index.php"><button>Create Another</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php

    //Get Date/Time array of all class times.
    $dateTimeTriplets = getDateTimeArray($_POST['start-date'], $_POST['end-date'], $_POST['every-other-week']);



    //Convert other user selections to database ids
    $convertedData = convertSelectionsToDatabaseIDs($db_connection);



    //Check for double-booking
    $abort = checkForConflicts($convertedData);
    if ($abort) {
      $postString = serialize($_POST);
      echo "<h3 class='main-content-header'>No class has been added, the database has not been changed. Please <button form='retry-form' type='submit' style='width: 90pt;'>try again</button></h3>";
      echo "<form id='retry-form' method='post' action='index.php'><input name='old-post' value='{$postString}' style='visibility: hidden;'></form>";

      echo "<h3 class='main-content-header'>Override:</h3><p class='main-content-header'><button form='override-form' type='submit' style='width: 110pt;'>OVERRIDE</button> conflicts if you are sure.</p>";
      echo "<form id='override-form' method='post' action='create-new-class-override.php'><input name='override-post' value='{$postString}' style='visibility: hidden;'></form>";
      return;
    }


    //Convert class data to SQL-syntax arrays and escape the strings
    prepClassDataForSQL();



    //Create SQL query
    $query = "INSERT INTO classes (class_type, display_title, date_of_class, start_time, end_time, all_weekdays_times, arena, horses, tacks, tack_notes, client_equipment_notes, pads, clients, attendance, staff, volunteers) VALUES";
    foreach ($dateTimeTriplets as $date => $timeArray) {
      $query = $query . "('{$_POST['class-type']}', '{$displayTitle}', '{$date}', '{$timeArray[0]}', '{$timeArray[1]}', '$all_weekdays_times', '{$_POST['arena']}', '{$horseIDList}', '{$tackList}', '{$tackNotes}', '{$clientEquipmentNotes}', '{$padList}', '{$clientIDList}', '{$clientIDList}', '{$staffJSON}', '{$volunteerJSON}'),";
    }

    $query = chop($query, ",") . ";";



    //Modify database
    $result = pg_query($db_connection, $query);
    if ($result) {
      echo "<h3 class='main-content-header'>Success</h3";
    } else {
      $postString = serialize($_POST);
      echo "<h3 class='main-content-header'>An error occured.</h3><p class='main-content-header'>Please <button form='retry-form' type='submit' style='width: 90pt;'>try again.</button> Ensure that all data is correctly formatted.</p>";
      echo "<form id='retry-form' method='post' action='index.php'><input name='old-post' value='{$postString}' style='visibility: hidden;'></form>";
    }
  ?>



</body>

</html>

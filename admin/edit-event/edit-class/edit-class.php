<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/connectdb.php";?>
  <title>Admin | Edit Class</title>
</head>

<body>

  <header>
    <h1>Edit Class</h1>
    <nav>
      <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php

    if ($_POST['DELETE']) { //DELETE CLASS IF DELETE IS REQUESTED
      $query = "DELETE FROM classes WHERE class_type = '{$_POST['old-class-type']}' AND clients <@ '{$_POST['old-client-id-list']}';";
      $result = pg_query($db_connection, $query);
      if ($result) {
        echo "<h3 class='main-content-header'>Success</h3";
      } else {
        echo "<h3 class='main-content-header>An error occured.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
      }
      return;
    }

    if ($_POST['archive']) { //ARCHIVE CLASS IF REQUESTED
      $query = "UPDATE classes SET archived = 'TRUE' WHERE class_type = '{$_POST['old-class-type']}' AND clients <@ '{$_POST['old-client-id-list']}';";
      $result = pg_query($db_connection, $query);
      if ($result) {
        echo "<h3 class='main-content-header'>Success</h3";
      } else {
        echo "<h3 class='main-content-header>An error occured.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
      }
      return;
    }

    //ADD NEW VALUES

    //Process form input
    //get array of dates and times
    $date = $_POST['start-date'];
    $end_date = $_POST['end-date'];
    $dateTimeTriplets = array();

    $all_weekdays_times = "";
    $weekdaysAdded = array();
    while (strtotime($date) <= strtotime($end_date)) {
      $dayOfWeek = date('l', strtotime($date));
      if (in_array($dayOfWeek, $_POST)) {
        $startTime =  $_POST[strtolower($dayOfWeek).'-start-time'];
        $endTime = $_POST[strtolower($dayOfWeek).'-end-time'];
        $dateTimeTriplets[$date] = array($startTime, $endTime);
        if (!in_array($dayOfWeek, $weekdaysAdded)){
          $all_weekdays_times = $all_weekdays_times . $dayOfWeek . "," . $startTime . "," . $endTime . ";";
          $weekdaysAdded[] = $dayOfWeek;
        }
      }

      //looper
      $date = date ('Y-m-d', strtotime('+1 day', strtotime($date)));
    }
    //Convert other user selections to database ids

    function to_pg_array($set) {
      settype($set, 'array'); // can be called with a scalar or array
      $result = array();
      foreach ($set as $t) {
          if (is_array($t)) {
              $result[] = to_pg_array($t);
          } else {
              $t = str_replace('"', '\\"', $t); // escape double quote
              if (! is_numeric($t)) // quote only non-numeric values
                  $t = '"' . $t . '"';
              $result[] = $t;
          }
      }
      return '{' . implode(",", $result) . '}'; // format
    }

    $horseID = pg_fetch_row(pg_query($db_connection, "SELECT id FROM horses WHERE name LIKE '{$_POST['horse']}'"))[0];
    if (!$horseID) {
      $horseID = 'null';
    }
    $clientIDList = array();
    foreach ($_POST['clients'] as $key => $value) {
      $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM clients WHERE name LIKE '{$value}'"))[0];
      $clientIDList[] = $id;
    }
    $clientIDList = to_pg_array($clientIDList);

    $instructorID = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$_POST['instructor']}'"))[0];
    if (!$instructorID) {
      $instructorID = 'null';
    }
    $therapistID = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$_POST['therapist']}'"))[0];
    if (!$therapistID) {
      $therapistID = 'null';
    }
    $esID = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$_POST['equine-specialist']}'"))[0];
    if (!$esID) {
      $esID = 'null';
    }
    $leaderID = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$_POST['leader']}'"))[0];
    if (!$leaderID) {
      $leaderID = 'null';
    }
    $sidewalkerIDList = array();
    foreach ($_POST['sidewalkers'] as $key => $value) {
      $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$value}'"))[0];
      $sidewalkerIDList[] = $id;
    }
    $sidewalkerIDList = to_pg_array($sidewalkerIDList);



    //Check for double-booking
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/checkAvailability.php";
    $abort = false;
    foreach ($dateTimeTriplets as $date => $timeArray) {
      if ($_POST['arena'] != "") {
        $result = checkAvailability($_POST['arena'], 'arena', $date, $timeArray[0], $timeArray[1]);
        if ($result) {
          $abort = true;
          echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$_POST['arena']} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
        }
      }
      if ($_POST['horse'] != "") {
        $result = checkAvailability($horseID, 'horses', $date, $timeArray[0], $timeArray[1]);
        if ($result) {
          $abort = true;
          echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$_POST['horse']} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
        }
      }
      if ($_POST['tack'] != "") {
        $result = checkAvailability($_POST['tack'], 'tack', $date, $timeArray[0], $timeArray[1]);
        if ($result) {
          $abort = true;
          echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$_POST['tack']} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
        }
      }
      if ($_POST['pad'] != "") {
        $result = checkAvailability($_POST['pad'], 'pad', $date, $timeArray[0], $timeArray[1]);
        if ($result) {
          $abort = true;
          echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$_POST['pad']} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
        }
      }
      if ($_POST['instructor'] != "") {
        $result = checkAvailability($instructorID, 'workers', $date, $timeArray[0], $timeArray[1]);
        if ($result) {
          $abort = true;
          echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$_POST['instructor']} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
        }
      }
      if ($_POST['therapist'] != "") {
        $result = checkAvailability($therapistID, 'workers', $date, $timeArray[0], $timeArray[1]);
        if ($result) {
          $abort = true;
          echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$_POST['therapist']} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
        }
      }
      if ($_POST['equine-specialist'] != "") {
        $result = checkAvailability($esID, 'workers', $date, $timeArray[0], $timeArray[1]);
        if ($result) {
          $abort = true;
          echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$_POST['equine-specialist']} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
        }
      }
      if ($_POST['leader'] != "") {
        $result = checkAvailability($leaderID, 'workers', $date, $timeArray[0], $timeArray[1]);
        if ($result) {
          $abort = true;
          echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$_POST['leader']} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
        }
      }
      if ($sidewalkerIDList != "{1}") {
        foreach ($_POST['sidewalkers'] as $sidewalkerName) {
          $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$sidewalkerName}'"))[0];
          $result = checkAvailability($id, 'workers', $date, $timeArray[0], $timeArray[1]);
          if ($result) {
            $abort = true;
            echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$sidewalkerName} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
          }
        }
      }
    }
    if ($abort) {
      echo "<h3 class='main-content-header'>The database has not been changed. Please <button onclick='window.history.back();' style='width: 80pt;'>resolve</button> double-bookings and try again.</h3>";
      return;
    }

    //If no conflicts, delete current database entries and replace with new ones.

    //DELETE ALL ROWS OF SELECTED CLASS SO THEY CAN BE REPLACED WITH THE NEW ONES
    $getClassIDsQuery = "SELECT id FROM classes WHERE class_type = '{$_POST['old-class-type']}' AND clients <@ '{$_POST['old-client-id-list']}';";
    $classIDSQLObject = pg_fetch_all(pg_query($db_connection, $getClassIDsQuery));
    foreach ($classIDSQLObject as $row => $data) {
      pg_query($db_connection, "DELETE FROM classes WHERE classes.id = {$data['id']}");
    }




    //Create SQL query
    $query = "INSERT INTO classes (class_type, date_of_class, start_time, end_time, all_weekdays_times, arena, horse, tack, special_tack, stirrup_leather_length, pad, clients, instructor, therapist, equine_specialist, leader, sidewalkers) VALUES";
    foreach ($dateTimeTriplets as $date => $timeArray) {
      $query = $query . "('{$_POST['class-type']}', '{$date}', '{$timeArray[0]}', '{$timeArray[1]}', '$all_weekdays_times', '{$_POST['arena']}', {$horseID}, '{$_POST['tack']}', '{$_POST['special-tack']}', '{$_POST['stirrup-leather-length']}', '{$_POST['pad']}', '{$clientIDList}', {$instructorID}, {$therapistID}, {$esID}, {$leaderID}, '{$sidewalkerIDList}'),";
    }

    $query = chop($query, ",") . ";";


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

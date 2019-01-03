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
    var_dump($_POST);
    //Process form input
    //get array of dates and times
    $date = $_POST['start-date'];
    $end_date = $_POST['end-date'];
    $dateTimeTriplets = array();
    if ($_POST['every-other-week'] == "TRUE") {
      $everyOtherWeek = true;
    } else {$everyOtherWeek = false;}

    $all_weekdays_times = "";
    if ($everyOtherWeek) {
      $all_weekdays_times = "EO;";
    }
    $weekdaysAdded = array();
    $datesAdded = array();
    while (strtotime($date) <= strtotime($end_date)) {
      $dayOfWeek = date('l', strtotime($date));
      if (in_array($dayOfWeek, $_POST) and (!$everyOtherWeek or !in_array(date('Y-m-d', strtotime("-1 week" . $date)), $datesAdded))) {
        $startTime =  $_POST[strtolower($dayOfWeek).'-start-time'];
        $endTime = $_POST[strtolower($dayOfWeek).'-end-time'];
        $dateTimeTriplets[$date] = array($startTime, $endTime);
        $datesAdded[] = $date;
        if (!in_array($dayOfWeek, $weekdaysAdded)){
          $all_weekdays_times .= $dayOfWeek . "," . $startTime . "," . $endTime . ";";
          $weekdaysAdded[] = $dayOfWeek;
        }
      }
      //looper
      $date = date ('Y-m-d', strtotime("+1 day", strtotime($date)));
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


    $horseIDList = array();
    foreach ($_POST['horses'] as $key => $value) {
      $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM horses WHERE name LIKE '{$value}' AND (archived IS NULL OR archived = '');"))[0];
      $horseIDList[] = $id;
    }

    $clientIDList = array();
    foreach ($_POST['clients'] as $key => $value) {
      $value = pg_escape_string($value);
      $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM clients WHERE name LIKE '{$value}' AND (archived IS NULL OR archived = '');"))[0];
      $clientIDList[] = $id;
    }
    $clientIDList = to_pg_array($clientIDList);

    $staffIDList = array();
    foreach ($_POST['staff'] as $key => $value) {
      $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$value}' AND (archived IS NULL OR archived = '');"))[0];
      $staffIDList[] = $id;
    }


    $leaderIDList = array();
    foreach ($_POST['leaders'] as $key => $value) {
      $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$value}' AND (archived IS NULL OR archived = '');"))[0];
      $leaderIDList[] = $id;
    }

    $sidewalkerIDList = array();
    foreach ($_POST['sidewalkers'] as $key => $value) {
      $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$value}' AND (archived IS NULL OR archived = '');"))[0];
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
      if ($_POST['horses'] != array()) {
        foreach ($horseIDList as $key => $horseID) {
          $result = checkAvailability($horseID, 'horses', $date, $timeArray[0], $timeArray[1]);
          if ($result) {
            $abort = true;
            if (is_array($result)) {
              echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$_POST['horses'][$key]} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
            } else {
              echo "<br><h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red);'>{$result}</p>";
            }
          }
        }
      }
      if ($_POST['tacks'] != array()) {
        foreach ($_POST['tacks'] as $key => $tackName) {
          $result = checkAvailability($tackName, 'tack', $date, $timeArray[0], $timeArray[1]);
          if ($result) {
            $abort = true;
            echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$tackName} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
          }
        }
      }
      if ($_POST['pads'] != array()) {
        foreach ($_POST['pads'] as $key => $padName) {
          $result = checkAvailability($padName, 'pad', $date, $timeArray[0], $timeArray[1]);
          if ($result) {
            $abort = true;
            echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$padName} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
          }
        }
      }
      if ($_POST['staff'] != array()) {
        foreach ($staffIDList as $key => $staffID) {
          $result = checkAvailability($staffID, 'workers', $date, $timeArray[0], $timeArray[1]);
          if ($result) {
            $abort = true;
            echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$_POST['staff'][$key]} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
          }
        }
      }
      if ($_POST['leaders'] != array()) {
        foreach ($leaderIDList as $key => $leaderID) {
          $result = checkAvailability($leaderID, 'workers', $date, $timeArray[0], $timeArray[1]);
          if ($result) {
            $abort = true;
            echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$_POST['leaders'][$key]} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
          }
        }
      }
      if ($sidewalkerIDList != "{1}") {
        foreach ($_POST['sidewalkers'] as $sidewalkerName) {
          $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$sidewalkerName}' AND (archived IS NULL OR archived = '');"))[0];
          $result = checkAvailability($id, 'workers', $date, $timeArray[0], $timeArray[1]);
          if ($result) {
            $abort = true;
            echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$sidewalkerName} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
          }
        }
      }
    }
    if ($abort) {
      $postString = to_pg_array($_POST);
      echo "<h3 class='main-content-header'>No class has been added, the database has not been changed. Please <button form='retry-form' type='submit' style='width: 90pt;'>try again</button></h3>";
      echo "<form id='retry-form' method='post' action='index.php'><input name='old-post' value='{$postString}' style='visibility: hidden;'></form>";
      return;
    }

    $horseIDList = to_pg_array($horseIDList);
    $tackList = to_pg_array($_POST['tacks']);
    $padList = to_pg_array($_POST['pads']);

    $leaderIDList = to_pg_array($leaderIDList);

    $staffJSON = "{";
    foreach ($staffIDList as $key => $staffID) {
      $staffJSON .= "\"{$_POST['staff-roles'][$key]}\": {$staffID},";
    }
    $staffJSON = rtrim($staffJSON, ',') . "}";




    //If no conflicts, create SQL query
    $query = "INSERT INTO classes (class_type, date_of_class, start_time, end_time, all_weekdays_times, arena, horses, tacks, special_tack, stirrup_leather_length, pads, clients, attendance, staff, leaders, sidewalkers) VALUES";
    foreach ($dateTimeTriplets as $date => $timeArray) {
      $query = $query . "('{$_POST['class-type']}', '{$date}', '{$timeArray[0]}', '{$timeArray[1]}', '$all_weekdays_times', '{$_POST['arena']}', '{$horseIDList}', '{$tackList}', '{$_POST['special-tack']}', '{$_POST['stirrup-leather-length']}', '{$padList}', '{$clientIDList}', '{$clientIDList}', '{$staffJSON}', '{$leaderIDList}', '{$sidewalkerIDList}'),";
    }

    $query = chop($query, ",") . ";";



    //Modify database
    $result = pg_query($db_connection, $query);
    if ($result) {
      echo "<h3 class='main-content-header'>Success</h3";
    } else {
      $postString = serialize($_POST);
      var_dump($postString);
      echo "<h3 class='main-content-header>An error occured.</h3><p class='main-content-header'>Please <button form='retry-form' type='submit' style='width: 90pt;'>try again.</button> Ensure that all data is correctly formatted.</p>";
      echo "<form id='retry-form' method='post' action='index.php'><input name='old-post' value='{$postString}' style='visibility: hidden;'></form>";
    }
  ?>



</body>

</html>

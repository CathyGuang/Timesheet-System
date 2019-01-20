<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
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
      $query = "DELETE FROM classes WHERE class_type = '{$_POST['old-class-type']}' AND clients <@ '{$_POST['old-client-id-list']}' AND (archived IS NULL OR archived = '');";
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




    //GET TODAYS' DATE AND ONLY MODIFY CLASSES AFTER TODAYS DATE
    $todaysDate = date('Y-m-d');
    //ARCHIVE ALL ROWS OF SELECTED CLASS SO THEY CAN BE REPLACED WITH THE NEW ONES
    $getClassIDsQuery = "SELECT id FROM classes WHERE class_type = '{$_POST['old-class-type']}' AND clients <@ '{$_POST['old-client-id-list']}' AND date_of_class >= '{$todaysDate}' AND (archived IS NULL OR archived = '');";
    $oldClassIDSQLObject = pg_fetch_all(pg_query($db_connection, $getClassIDsQuery));
    if ($oldClassIDSQLObject) {
      foreach ($oldClassIDSQLObject as $row => $data) {
        pg_query($db_connection, "UPDATE classes SET archived = 'true' WHERE classes.id = {$data['id']};");
      }
    }

    //ADD NEW VALUES

    //Process form input
    //get array of dates and times
    $date = $todaysDate;
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


    $volunteerIDList = array();
    foreach ($_POST['volunteers'] as $key => $value) {
      $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$value}' AND (archived IS NULL OR archived = '');"))[0];
      $volunteerIDList[] = $id;
    }




    //Check for double-booking
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/checkAvailability.php";
    //initialize check horse use by week function
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/getHorseUsesByDateRange.php";

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
      if ($_POST['volunteers'] != array()) {
        foreach ($volunteerIDList as $key => $volunteerID) {
          $result = checkAvailability($volunteerID, 'workers', $date, $timeArray[0], $timeArray[1]);
          if ($result) {
            $abort = true;
            echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$_POST['leaders'][$key]} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
          }
        }
      }
    }
    if ($abort) {
      //RESTORE OLD CLASS DATA SINCE NO CHANGES ARE BEING MADE
      if ($oldClassIDSQLObject) {
        foreach ($oldClassIDSQLObject as $row => $data) {
          pg_query($db_connection, "UPDATE classes SET archived = null WHERE classes.id = {$data['id']};");
        }
      }
      echo "<h3 class='main-content-header'> No changes to the class have been made. It is safe to leave this page. To edit the class, please <button onclick='window.history.back();' style='width: 90pt;'>revert</button> your changes and try again.</h3>";
      return;
    }



    $horseIDList = to_pg_array($horseIDList);
    $tackList = to_pg_array($_POST['tacks']);
    $padList = to_pg_array($_POST['pads']);
    $tackNotes = to_pg_array($_POST['tack-notes']);
    $clientEquipmentNotes = to_pg_array($_POST['client-equipment-notes']);


    $staffJSON = "{";
    foreach ($staffIDList as $key => $staffID) {
      $staffJSON .= "\"{$_POST['staff-roles'][$key]}\": {$staffID},";
    }
    $staffJSON = rtrim($staffJSON, ',') . "}";

    $volunteerJSON = "{";
    foreach ($volunteerIDList as $key => $volunteerID) {
      $volunteerJSON .= "\"{$_POST['volunteer-roles'][$key]}\": {$volunteerID},";
    }
    $volunteerJSON = rtrim($volunteerJSON, ',') . "}";


    $displayTitle = pg_escape_string(trim($_POST['display-title']));


    //If no conflicts, create new entries.

    //Create SQL query
    $query = "INSERT INTO classes (class_type, display_title, date_of_class, start_time, end_time, all_weekdays_times, arena, horses, tacks, tack_notes, client_equipment_notes, pads, clients, attendance, staff, volunteers) VALUES";
    foreach ($dateTimeTriplets as $date => $timeArray) {
      $query = $query . "('{$_POST['class-type']}', '{$displayTitle}', '{$date}', '{$timeArray[0]}', '{$timeArray[1]}', '$all_weekdays_times', '{$_POST['arena']}', '{$horseIDList}', '{$tackList}', '{$tackNotes}', '{$clientEquipmentNotes}', '{$padList}', '{$clientIDList}', '{$clientIDList}', '{$staffJSON}', '{$volunteerJSON}'),";
    }

    $query = chop($query, ",") . ";";


    //Modify database
    $result = pg_query($db_connection, $query);
    if ($result) {
      //DELETE OLD CLASS DATA TO BE REPLACED WITH NEW DATA
      if ($oldClassIDSQLObject) {
        foreach ($oldClassIDSQLObject as $row => $data) {
          pg_query($db_connection, "DELETE FROM classes WHERE classes.id = {$data['id']};");
        }
      }
      echo "<h3 class='main-content-header'>Success</h3";
    } else {
      //UNARCHIVE OLD CLASS DATA IF ERROR OCCURRED
      if ($oldClassIDSQLObject) {
        foreach ($oldClassIDSQLObject as $row => $data) {
          pg_query($db_connection, "UPDATE classes SET archived = null WHERE classes.id = {$data['id']};");
        }
      }
      echo "<h3 class='main-content-header>An error occured.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
    }
  ?>



</body>

</html>

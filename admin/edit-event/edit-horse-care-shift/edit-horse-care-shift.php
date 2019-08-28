<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | Edit Horse Care Shift</title>
</head>

<body>

  <header>
    <h1>Edit Horse Care Shift</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    //Get shift code
    $shiftCode = $_POST['shift-code'];

    if ($_POST['DELETE']) { //DELETE SHIFT IF DELETE IS REQUESTED
      $query = "DELETE FROM horse_care_shifts WHERE shift_code = '{$shiftCode}' AND (archived IS NULL OR archived = '');";
      $result = pg_query($db_connection, $query);
      if ($result) {
        echo "<h3 class='main-content-header'>Success</h3";
      } else {
        echo "<h3 class='main-content-header'>An error occurred.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
      }
      return;
    }

    if ($_POST['archive']) { //ARCHIVE SHIFT IF REQUESTED
      $query = "UPDATE horse_care_shifts SET archived = 'TRUE' WHERE shift_code = '{$shiftCode}' AND (archived IS NULL OR archived = '');";
      $result = pg_query($db_connection, $query);
      if ($result) {
        echo "<h3 class='main-content-header'>Success</h3";
      } else {
        echo "<h3 class='main-content-header'>An error occurred.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
      }
      return;
    }



    //ONLY EDIT FUTURE SHIFTS
    $todaysDate = date('Y-m-d');
    //get array of dates and times
    $dates = getDateTimeArray($todaysDate, $_POST['end-date'], false);
    $dateTimeTriplets = $dates[0];
    $all_weekdays_times = $dates[1];



    //Get list of old shift IDs
    $getShiftIDsQuery = "SELECT id FROM horse_care_shifts WHERE shift_code = '{$shiftCode}' AND (archived IS NULL OR archived = '');";
    $oldShiftIDSQLObject = pg_fetch_all(pg_query($db_connection, $getShiftIDsQuery));
    $oldShiftIDList = array();
    if ($oldShiftIDSQLObject) {
      foreach ($oldShiftIDSQLObject as $row => $data) {
        $oldShiftIDList[] = $data['id'];
      }
    }


    //ARCHIVE ALL ROWS OF SELECTED SHIFT SO THEY CAN BE REPLACED WITH THE NEW ONES
    if ($oldShiftIDList) {
      foreach ($oldShiftIDList as $id) {
        pg_query($db_connection, "UPDATE horse_care_shifts SET archived = 'true' WHERE horse_care_shifts.id = {$id} AND date_of_shift >= '{$todaysDate}';");
      }
    }



    //Convert other user selections to database ids
    $leaderID = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$_POST['leader']}' AND (archived IS NULL OR archived = '');"))[0];
    if (!$leaderID) {
      $leaderID = 'null';
    }
    $volunteerIDList = array();
    foreach ($_POST['volunteers'] as $key => $value) {
      $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$value}' AND (archived IS NULL OR archived = '');"))[0];
      $volunteerIDList[] = $id;
    }
    $volunteerIDList = to_pg_array($volunteerIDList);

    $horseID = pg_fetch_row(pg_query($db_connection, "SELECT id FROM horses WHERE name LIKE '{$_POST['horse']}' AND (archived IS NULL OR archived = '');"))[0];



    //Check for double-booking
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/checkAvailability.php";
    //initialize check horse use by week function
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/getHorseUsesByDateRange.php";

    $abort = false;
    foreach ($dateTimeTriplets as $date => $timeArray) {
      if ($_POST['leader'] != "") {
        $result = checkAvailability($leaderID, 'workers', $date, $timeArray[0], $timeArray[1]);
        if ($result) {
          $abort = true;
          echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$_POST['leader']} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
        }
      }
      if ($volunteerIDList != "{1}") {
        foreach ($_POST['volunteers'] as $volunteerName) {
          $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$volunteerName}' AND (archived IS NULL OR archived = '');"))[0];
          $result = checkAvailability($id, 'workers', $date, $timeArray[0], $timeArray[1]);
          if ($result) {
            $abort = true;
            echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$volunteerName} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
          }
        }
      }
      if ($horseID) {
        $result = checkAvailability($horseID, 'horses', $date, $timeArray[0], $timeArray[1]);
        if ($result) {
          $abort = true;
          if (is_array($result)) {
            echo "<h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red)'>CONFLICT: {$_POST['horse']} has another event on {$date} from {$result[0]} to {$result[1]}.</h3>";
          } else {
            echo "<br><h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red);'>{$result}</p>";
          }
        }
      }
    }
    if ($abort) {
      echo "<h3 class='main-content-header'>The database has not been changed. Please <button onclick='window.history.back();' style='width: 80pt;'>resolve</button> double-bookings and try again.</h3>";
      return;
    }



    //Create SQL query
    $query = "INSERT INTO horse_care_shifts (shift_code, care_type, date_of_shift, start_time, end_time, all_weekdays_times, leader, volunteers, horse) VALUES";
    foreach ($dateTimeTriplets as $date => $timeArray) {
      $query = $query . "('{$shiftCode}', '{$_POST['shift-type']}', '{$date}', '{$timeArray[0]}', '{$timeArray[1]}', '$all_weekdays_times', {$leaderID}, '{$volunteerIDList}', '{$horseID}'),";
    }

    $query = chop($query, ",") . ";";



    //Modify database
    $result = pg_query($db_connection, $query);
    if ($result) {
      //DELETE OLD SHIFT DATA TO BE REPLACED WITH NEW DATA
      foreach ($oldShiftIDList as $id) {
        pg_query($db_connection, "DELETE FROM horse_care_shifts WHERE horse_care_shifts.id = {$id} AND date_of_shift >= '{$todaysDate}';");
      }
      echo "<h3 class='main-content-header'>Success</h3";
    } else {
      //UNARCHIVE OLD CLASS DATA IF ERROR OCCURRED
      if ($oldShiftIDList) {
        foreach ($oldShiftIDList as $id) {
          pg_query($db_connection, "UPDATE horse_care_shifts SET archived = null WHERE horse_care_shifts.id = {$id};");
        }
      }
      echo "<h3 class='main-content-header'>An error occurred.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
    }
  ?>



</body>

</html>

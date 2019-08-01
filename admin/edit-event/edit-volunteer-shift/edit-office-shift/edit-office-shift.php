<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | Edit Office Shift</title>
</head>

<body>

  <header>
    <h1>Edit Office Shift</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php


    if ($_POST['DELETE']) { //DELETE SHIFT IF DELETE IS REQUESTED
      $query = "DELETE FROM office_shifts WHERE office_shift_type = '{$_POST['old-shift-type']}' AND leader = (SELECT id FROM workers WHERE name LIKE '{$_POST['old-leader']}' AND (archived IS NULL OR archived = '')) AND (archived IS NULL OR archived = '');";
      $result = pg_query($db_connection, $query);
      if ($result) {
        echo "<h3 class='main-content-header'>Success</h3";
      } else {
        echo "<h3 class='main-content-header'>An error occured.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
      }
      return;
    }

    if ($_POST['archive']) { //ARCHIVE SHIFT IF REQUESTED
      $query = "UPDATE office_shifts SET archived = 'TRUE' WHERE office_shift_type = '{$_POST['old-shift-type']}' AND leader = (SELECT id FROM workers WHERE name LIKE '{$_POST['old-leader']}' AND (archived IS NULL OR archived = ''));";
      $result = pg_query($db_connection, $query);
      if ($result) {
        echo "<h3 class='main-content-header'>Success</h3";
      } else {
        echo "<h3 class='main-content-header'>An error occured.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
      }
      return;
    }



    //ONLY EDIT FUTURE CLASSES
    $todaysDate = date('Y-m-d');
    //get array of dates and times
    $dates = getDateTimeArray($todaysDate, $_POST['end-date'], false);
    $dateTimeTriplets = $dates[0];
    $all_weekdays_times = $dates[1];



    //ARCHIVE ALL ROWS OF SELECTED CLASS SO THEY CAN BE REPLACED WITH THE NEW ONES
    $getShiftIDsQuery = "SELECT id FROM office_shifts WHERE office_shift_type = '{$_POST['old-shift-type']}' AND leader = '{$_POST['old-leader']}' AND date_of_shift >= '{$todaysDate}' AND (archived IS NULL OR archived = '');";
    $oldShiftIDSQLObject = pg_fetch_all(pg_query($db_connection, $getShiftIDsQuery));
    if ($oldShiftIDSQLObject) {
      foreach ($oldShiftIDSQLObject as $row => $data) {
        pg_query($db_connection, "UPDATE office_shifts SET archived = 'true' WHERE office_shifts.id = {$data['id']};");
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



    //Check for double-booking
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/checkAvailability.php";
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
    }
    if ($abort) {
      echo "<h3 class='main-content-header'>The database has not been changed. Please <button onclick='window.history.back();' style='width: 80pt;'>resolve</button> double-bookings and try again.</h3>";
      return;
    }



    //DELETE ALL ROWS OF SELECTED CLASS SO THEY CAN BE REPLACED WITH THE NEW ONES
    $getShiftIDsQuery = "SELECT DISTINCT office_shifts.id FROM office_shifts, workers WHERE office_shift_type = '{$_POST['old-shift-type']}' AND leader = (SELECT id FROM workers WHERE name LIKE '{$_POST['old-leader']}' AND (workers.archived IS NULL OR workers.archived = '')) AND date_of_shift >= '{$todaysDate}' AND (office_shifts.archived IS NULL OR office_shifts.archived = '');";
    $shiftIDSQLObject = pg_fetch_all(pg_query($db_connection, $getShiftIDsQuery));
    foreach ($shiftIDSQLObject as $row => $data) {
      pg_query($db_connection, "DELETE FROM office_shifts WHERE office_shifts.id = {$data['id']}");
    }



    //Create SQL query
    $query = "INSERT INTO office_shifts (office_shift_type, date_of_shift, start_time, end_time, all_weekdays_times, leader, volunteers) VALUES";
    foreach ($dateTimeTriplets as $date => $timeArray) {
      $query = $query . "('{$_POST['shift-type']}', '{$date}', '{$timeArray[0]}', '{$timeArray[1]}', '$all_weekdays_times', {$leaderID}, '{$volunteerIDList}'),";
    }

    $query = chop($query, ",") . ";";



    //Modify database
    $result = pg_query($db_connection, $query);
    if ($result) {
      //DELETE OLD SHIFT DATA TO BE REPLACED WITH NEW DATA
      if ($oldShiftIDSQLObject) {
        foreach ($oldShiftIDSQLObject as $row => $data) {
          pg_query($db_connection, "DELETE FROM office_shifts WHERE office_shifts.id = {$data['id']};");
        }
      }
      echo "<h3 class='main-content-header'>Success</h3";
    } else {
      //UNARCHIVE OLD CLASS DATA IF ERROR OCCURRED
      if ($oldShiftIDSQLObject) {
        foreach ($oldShiftIDSQLObject as $row => $data) {
          pg_query($db_connection, "UPDATE office_shifts SET archived = null WHERE office_shifts.id = {$data['id']};");
        }
      }
      echo "<h3 class='main-content-header'>An error occured.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
    }
  ?>



</body>

</html>

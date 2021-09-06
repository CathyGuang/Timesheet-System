<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <link rel="stylesheet" href="/full-time-staff/enter-hours/css/added.css">
  <script type="text/javascript" src="jspdf.js"></script>
  <script type="text/javascript" src="/full-time-staff/enter-hours/js/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
  
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>View Staff Hours</title>
  <style type="text/css">
    table {
      border-collapse: collapse;
      width: 100%;
    }
    
    
    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    tr:hover {background-color: #f5f5f5;}
  </style>
</head>

<body>


  <header>
    <h1><?php echo $_POST['staff']; ?>'s Total Hours: 
    <?php
      $staffName = pg_escape_string(trim($_POST['staff']));
      $staffID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$staffName}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];
  
      $totalHourQuery = <<<EOT
      SELECT * FROM full_total_hours
      WHERE full_total_hours.staff = '{$staffID}' AND
      '{$_POST['start-date']}' <= full_total_hours.date_of_shift AND
      '{$_POST['end-date']}' >= full_total_hours.date_of_shift
      ;
      EOT;
      $totalHourData = pg_fetch_all(pg_query($db_connection, $totalHourQuery));
      $totalHour = 0;
      foreach($totalHourData as $day){
          $totalHour = $totalHour + $day['total_hour'];
      }
      $holidayHourQuery = <<<EOT
      SELECT * FROM holiday_hours
      WHERE holiday_hours.staff = '{$staffID}' AND
      '{$_POST['start-date']}' <= holiday_hours.date_of_shift AND
      '{$_POST['end-date']}' >= holiday_hours.date_of_shift
      ;
      EOT;
      $holidayHourData = pg_fetch_all(pg_query($db_connection, $holidayHourQuery));
      foreach($holidayHourData as $hour){
        $totalHour = $totalHour + $hour['hours'];
    }
      echo $totalHour;
    ?>
     
    </h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <form>
        <input type="button" class="check_pay_period_button" value="Pay Periods" onclick= "window.location.href='\../enter-hours/payPeriod.php';">
      </form>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class = "full_view_note">

  <p>  NOTE: If you want to modify data, you can only change data from one row each time!</p>
  <p>  If there is no changes, click the blue Submit button at the bottom.</p>

  </div >
  <table id="HoursTable" style = "margin:15px;font-size:20px;">
    <tr>
    <th>Date</th>
    <th>Work Types</th>
    <th>Hours</th>
    <th>Total Hours This Day</th>
    <th> <th>
    <th> <th>

  <?php

    $staffName = pg_escape_string(trim($_POST['staff']));
    $staffID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$staffName}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];
    session_start();
    $_SESSION['staffName'] = $staffName;
    $_SESSION['staffID'] = $staffID;

      $query = <<<EOT
    SELECT * FROM full_job_hours, full_total_hours
    WHERE full_job_hours.staff = '{$staffID}' AND
    '{$_POST['start-date']}' <= full_job_hours.date_of_shift AND
    '{$_POST['end-date']}' >= full_job_hours.date_of_shift AND
    full_job_hours.date_of_shift = full_total_hours.date_of_shift AND
    full_job_hours.staff = full_total_hours.staff
    ;
    EOT;

      $inOutQuery = <<<EOT
    SELECT * FROM in_out_times
    WHERE in_out_times.staff = '{$staffID}' AND
    '{$_POST['start-date']}' <= in_out_times.date_of_shift AND
    '{$_POST['end-date']}' >= in_out_times.date_of_shift
    ;
    EOT;

      $holidayQuery = <<<EQT
    SELECT * FROM holiday_hours
    WHERE holiday_hours.staff = '{$staffID}' AND
    '{$_POST['start-date']}' <= holiday_hours.date_of_shift AND
    '{$_POST['end-date']}' >= holiday_hours.date_of_shift
    ;
    EQT;
    
    $coreData = pg_fetch_all(pg_query($db_connection, $query));
    $inOutData = pg_fetch_all(pg_query($db_connection, $inOutQuery));
    $holidayData = pg_fetch_all(pg_query($db_connection, $holidayQuery));

    if (!$coreData) {
        echo "<h3 class='main-content-header'>No data.</h3><p class='main-content-header'>There are no hour entries for this time period.</p>";
        return;
    }

    foreach ($coreData as $line) {
      echo <<<EOT
      <form action='delete_data.php' method='POST'>
        <tr>
          <td>{$line['date_of_shift']}</td>
          <td><input type="text" name="work_type" id="selected-job" list="work-type-list" value="{$line['work_type']}" required></td>
          <td>{$line['hours']}</td>
          <td>{$line['total_hour']}</td>
          <td><button type ="submit">Submit</button></td>
        </tr>
        <input type='number' name='id' value='{$line['id']}' hidden>
        <input type='number' name='idd' value='{$line['idd']}' hidden>
        <input type='number' name='type_hours' value='{$line['hours']}' hidden>
      </form>
      EOT;
    }
  ?>
  </table>
  <script type="text/javascript">
    var someone=<?php echo json_encode($_POST['staff']); ?>;
    var hours=<?php echo json_encode($totalHour); ?>;
  </script>
  <script type="text/javascript" src="print.js"></script>

   <!-- generate PDF Javascript -->

  <a href="javascript:genPDF()"><button id="cmd" class = "genPDFButton">generate PDF</button></a>

  <h3>

  <table style = "margin:15px;font-size:20px;">
  <tr>
    <th>Date</th>
    <th>In Time</th>
    <th>Out Time</th>
    <th> </th>
    <th> </th>
  </tr>
  <div class = "full_view_note">
  <p>  NOTE: Deleting any one row, all hours on that day will be deleted!</p>
  </div>

  <?php

    foreach ($inOutData as $row) {
      echo <<<EOT
      <form action='delete_in_out.php' method='POST'>
        <tr>
          <td>{$row['date_of_shift']}</td>
          <td>{$row['in_time']}</td>
          <td>{$row['out_time']}</td>
          <td>DELETE<input type="checkbox" id="delete-checkbox" name="delete" value="FALSE"></td>
          <td><button type ="submit">Submit</button></td>
        </tr>
        <input type='number' name='id' value='{$row['id']}' hidden>
        <input type='number' name='staff' value='{$row['staff']}' hidden>
        <input type='date' name='date_of_shift' value='{$row['date_of_shift']}' hidden>
      </form>
      EOT;
    }
    
  ?>

  </table>
  <br>
  <?php
    if (!$holidayData) {
      echo "<p class='main-content-header'>There are no holiday data for this time period.</p>";
      return;
    }
  ?>

  <table style = "margin:15px;font-size:20px;">
  <tr>
    <th>Date</th>
    <th>Holiday Type</th>
    <th>Hours</th>
    <th> </th>
    <th> </th>
  </tr>

  <?php
    //Sort holidayData array according to date
    $sortarray = array();
    foreach ($holidayData as $key => $row){
      $sortarray[$key] = strtotime($row['date_of_shift']);
    }

    array_multisort($sortarray, SORT_DESC, $holidayData);

    foreach ($holidayData as $holidayDay) {
      echo <<<EOT
      <form action='delete_holiday.php' method='POST'>
        <tr>
          <td>{$holidayDay['date_of_shift']}</td>
          <td>{$holidayDay['holiday_type']}</td>
          <td>{$holidayDay['hours']}</td>
          <td>DELETE<input type="checkbox" id="delete-checkbox" name="delete" value="FALSE"></td>
          <td><button type ="submit">Submit</button></td>
        </tr>
        <input type='number' name='id' value='{$holidayDay['id']}' hidden>
      </form>
      EOT;
    }
    
  ?>
  </table>

  <div class="form-container">
    <form autocomplete="off" class="standard-form" action="hours-complete.php" method="post">

      <div class="form-section">
        <div class="form-element" style = "font-size:18px;">
          <p>Hours complete for pay period: <input type="checkbox" name="send-email" value="true"></p>
        </div>
      </div>


      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <button type="submit">Submit</button>
      </div>

    </form>
  </div>

  <datalist id="work-type-list">
    <?php
      $staffShiftTypes = pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::STAFF_WORK_TYPE))::text EXCEPT SELECT name FROM archived_enums;"));
      foreach ($staffShiftTypes as $value) {
        echo "<option value='{$value}'>";
      }
    ?>
  </datalist>




</body>

</html>

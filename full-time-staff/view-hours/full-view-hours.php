<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
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

  <div id="editor"></div>
  <button id="cmd">generate PDF</button>

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

  <table>
    <tr>
    <th>Date</th>
    <th>Work Types</th>
    <th>Hours</th>
    <th>Total Hours This Day</th>
    <th>ID</th>
    <th>IDD</th>
    <th> </th>
    <th> </th>

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
    
        echo "<tr id = "{$line['id']}">";
        echo "<td>{$line['date_of_shift']}</td>";
        echo "<td>{$line['work_type']}</td>";
        echo "<td>{$line['hours']}</td>";
        echo "<td>{$line['total_hour']}</td>";
        echo "<td>{$line['id']}</td>";
        echo "<td>{$line['idd']}</td>";
        echo "<td><button value="{$line['id']}_{$line['idd']}">Change</button></td>";
        echo "<td><button>Delete</button></td>";
        echo "</tr>";
    }

  ?>
  </table>
  <br>

  <h3>

  <table>
  <tr>
    <th>Date</th>
    <th>In Time</th>
    <th>Out Time</th>
  </tr>

  <?php

    foreach ($inOutData as $row) {

      echo "<tr>";
      echo "<td>{$row['date_of_shift']}</td>";
      echo "<td>{$row['in_time']}</td>";
      echo "<td>{$row['out_time']}</td>";
      echo "</tr>";
    }
    
  ?>
  </table>
  <br>
  <table>
  <tr>
    <th>Date</th>
    <th>Holiday Type</th>
    <th>Hours</th>
  </tr>

  <?php
    //Sort holidayData array according to date
    $sortarray = array();
    foreach ($holidayData as $key => $row){
      $sortarray[$key] = strtotime($row['date_of_shift']);
    }

    array_multisort($sortarray, SORT_DESC, $holidayData);

    foreach ($holidayData as $holidayDay) {

      echo "<tr>";
      echo "<td>{$holidayDay['date_of_shift']}</td>";
      echo "<td>{$holidayDay['holiday_type']}</td>";
      echo "<td>{$holidayDay['hours']}</td>";
      echo "</tr>";
    }
    
  ?>
  </table>

  <div class="form-container">
    <form autocomplete="off" class="standard-form" action="hours-complete.php" method="post">

      <div class="form-section">
        <div class="form-element">
          <p>Hours complete for pay period: <input type="checkbox" name="send-email" value="true"></p>
        </div>
      </div>


      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <button type="submit">Submit</button>
      </div>

    </form>
  </div>

</body>

<script type="text/javascript" src="print.js"></script>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Admin | Generate Report</title>
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
    <h1>Generate Core Staff Report</h1>
    <nav> <a href="./"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <table>
    <tr>
    <th>Name</th>
    <th>Date</th>
    <th>Work Types</th>
    <th>Hours</th>
    <th>Total Hours This Day</th>

  <?php
    $staffName = pg_escape_string(trim($_POST['staff']));

    if (empty($staffName)){
        //Get table data without name restriction
        $query = <<<EOT
    SELECT * FROM full_job_hours, full_total_hours
    WHERE '{$_POST['start-date-of-hours']}' <= full_job_hours.date_of_shift AND
    '{$_POST['end-date-of-hours']}' >= full_job_hours.date_of_shift AND
    full_job_hours.date_of_shift = full_total_hours.date_of_shift AND
    full_job_hours.staff = full_total_hours.staff
    ;
    EOT;
        $inOutQuery = <<<EOT
    SELECT * FROM in_out_times
    WHERE '{$_POST['start-date-of-hours']}' <= in_out_times.date_of_shift AND
    '{$_POST['end-date-of-hours']}' >= in_out_times.date_of_shift
    ;
    EOT;

    } else{
        $staffID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$staffName}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];

      //Get table data with certain staff name
        $query = <<<EOT
    SELECT * FROM full_job_hours, full_total_hours
    WHERE full_job_hours.staff = '{$staffID}' AND
    '{$_POST['start-date-of-hours']}' <= full_job_hours.date_of_shift AND
    '{$_POST['end-date-of-hours']}' >= full_job_hours.date_of_shift AND
    full_job_hours.date_of_shift = full_total_hours.date_of_shift AND
    full_job_hours.staff = full_total_hours.staff
    ;
    EOT;

        $inOutQuery = <<<EOT
    SELECT * FROM in_out_times
    WHERE in_out_times.staff = '{$staffID}' AND
    '{$_POST['start-date-of-hours']}' <= in_out_times.date_of_shift AND
    '{$_POST['end-date-of-hours']}' >= in_out_times.date_of_shift
    ;
    EOT;
    }
    
    $coreData = pg_fetch_all(pg_query($db_connection, $query));
    $inOutData = pg_fetch_all(pg_query($db_connection, $inOutQuery));

    if (!$coreData) {
        echo "<h3 class='main-content-header'>No data.</h3><p class='main-content-header'>There are no hour entries for this time period.</p>";
        return;
    }
    
    foreach ($coreData as &$line) {
        $name = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = '{$line['staff']}' AND (archived IS NULL OR archived = '');"), 0, 1)['name'];
        $line['staff'] = $name;
        unset($line['id']);
    
        echo "<tr>";
        echo "<td>$name</td>";
        echo "<td>{$line['date_of_shift']}</td>";
        echo "<td>{$line['work_type']}</td>";
        echo "<td>{$line['hours']}</td>";
        echo "<td>{$line['total_hour']}</td>";
        echo "</tr>";
    }
    unset($line);

    foreach ($inOutData as &$row) {
        $name = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = '{$row['staff']}' AND (archived IS NULL OR archived = '');"), 0, 1)['name'];
        $row['staff'] = $name;
    }
    unset($row);
  ?>
  </table>

  <form method="post" action="core-csv-download.php">
    <input type="hidden" name="core_data" value= "<?php echo htmlentities(serialize($coreData)); ?>">
    <button class="blue-button" type="submit">Export Table Data</button>
  </form>

  <form method="post" action="in-out-csv-download.php">
    <input type="hidden" name="in_out_data" value= "<?php echo htmlentities(serialize($inOutData)); ?>">
  <button class="blue-button" type="submit">Export In Out Time</button>
  </form>

</body>

</html>

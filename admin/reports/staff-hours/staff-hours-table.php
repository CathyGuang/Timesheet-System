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
    <h1>Generate Staff Hour Report</h1>
    <nav> <a href="./"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <table>
    <tr>
    <th>Name</th>
    <th>Date</th>
    <th>Work Type</th>
    <th>Hours</th>
    <th>Notes</th>

  <?php
    $staffName = pg_escape_string(trim($_POST['staff']));
    if (empty($staffName)){
      //Get table data without name restriction
      $query = <<<EOT
    SELECT * FROM staff_hours
    WHERE '{$_POST['start-date-of-hours']}' <= date_of_hours AND
    '{$_POST['end-date-of-hours']}' >= date_of_hours
    ;
    EOT;
    } else{
      $staffID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$staffName}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];
      
      //Get table data with certain staff name
      $query = <<<EOT
    SELECT * FROM staff_hours
    WHERE staff = '{$staffID}' AND
    '{$_POST['start-date-of-hours']}' <= date_of_hours AND
    '{$_POST['end-date-of-hours']}' >= date_of_hours
    ;
    EOT;
    }
    
    $hourData = pg_fetch_all(pg_query($db_connection, $query));

    if (!$hourData) {
      echo "<h3 class='main-content-header'>No data.</h3><p class='main-content-header'>There are no hour entries for this time period.</p>";
      return;
    }
    
    $sortarray = array();
    foreach ($hourDate as $key => $row){
      $sortarray[$key] = $row['date_of_hours'];
      echo $sortarray[$key];
    }
    array_multisort($date, SORT_ASC, $hourDate);

    foreach ($hourData as &$line) {
      $name = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = '{$line['staff']}' AND (archived IS NULL OR archived = '');"), 0, 1)['name'];

      $line['staff'] = $name;
      
      echo "<tr>";
      echo "<td>$name</td>";
      echo "<td>{$line['date_of_hours']}</td>";
      echo "<td>{$line['work_type']}</td>";
      echo "<td>{$line['hours']}</td>";
      echo "<td>{$line['notes']}</td>";
      echo "</tr>";
    }
  ?>
  </table>

  <form method="post" action="staff-csv-download.php">
    <input type="hidden" name="hour_data" value= "<?php echo htmlentities(serialize($hourData)); ?>">
    <button class="blue-button" type="submit">Export Staff Hours Data</button>
  </form>

</body>

</html>

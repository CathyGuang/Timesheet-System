<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Admin | Generate Report</title>
  <style type="text/css">
    table, th, td {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      border: 1px solid #ddd;
      margin: 0 auto;
      margin-bottom: 100px;
}

</style>
</head>

<body>
  <header>
    <h1>Generate Staff Hour Report</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <table>
    <tr>
    <td>Name</td>
    <td>Date</td>
    <td>Work Type</td>
    <td>Hours</td>
    <td>Notes</td>

<?php

  $staffName = pg_escape_string(trim($_POST['staff']));
  $staffID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$staffName}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];
  $startDate = $_POST['start-date-of-hours'];
  $endDate = $_POST['end-date-of-hours'];

  echo $startDate."<br>";
  echo $endDate." <br>";
  echo $staffName."<br>";
  echo $staffID." <br>";
  $workType = $_POST['work-type'];
  echo $workType;

  //initialize target table name
  $tableName = "staff_hours";
  //Connect to database
  include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php";

  //delete tempfiles from previous reports
  if (file_exists("/tmp/DHStempfile.csv")) {
    unlink("/tmp/DHStempfile.csv");
  }

  //Get table columns for CSV file
  $metadata = array();
  $metadata[0] = pg_fetch_all_columns(pg_query($db_connection, "SELECT column_name FROM information_schema.columns WHERE table_schema = 'public' AND table_name = '{$tableName}';"));

  //Get table data
  $query = <<<EOT
  SELECT * FROM staff_hours
  WHERE staff = '{$staffID}' AND
  '{$_POST['start-date-of-hours']}' <= date_of_hours AND
  '{$_POST['end-date-of-hours']}' >= date_of_hours
  ;
EOT;

  $hourData = pg_fetch_all(pg_query($db_connection, $query));

  if (!$hourData) {
    echo "<h3 class='main-content-header'>No data.</h3><p class='main-content-header'>There are no hour entries for this time period.</p>";
    return;
  }
  
  foreach ($hourData as $uniqueShift) {
    echo "<p style='margin-left: 2vw;'>{$uniqueShift['date_of_hours']}: {$uniqueShift['work_type']}, {$uniqueShift['hours']} hrs, {$uniqueShift['notes']}</p><br>";
  }
  
  // foreach ($queryResult as $key => $dataString) {
  //   $queryResult[$key] = explode('%', trim($dataString));
  //   print_r($queryResult[$key]);
  //   echo "<br>";
  // }

  // $rawData = array_merge($metadata, $hourData);
  // print_r($rawData);
  // print_r($hourData);
  // echo "<table border=1>";
  // echo "<tr>";
  // echo "<td>Name</td>";
  // echo "<td>Date</td>";
  // echo "<td>Work Type</td>";
  // echo "<td>Hours</td>";
  // echo "<td>Notes</td>";
  
  foreach ($hourData as $line) {
    $allStaff = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = '{$line['staff']}' AND (archived IS NULL OR archived = '');"), 0, 1)['name'];
  
    echo "<tr>";
    echo "<td>$allStaff</td>";
    echo "<td>{$line['date_of_hours']}: </td>";
    echo "<td>{$line['work_type']}</td>";
    echo "<td>{$line['hours']}</td>";
    echo "<td>{$line['notes']}</td>";
    echo "</tr>";
  }

  echo "</table>";


  // //Write data to temporary CSV file on the server
  // $tempfile = fopen('/tmp/DHStempfile.csv', 'w');

  // //Add column title
  // fputcsv($tempfile, $rawData[0]);
  
  // foreach ($data as $line) {
  //   if ($_POST['start-date-of-hours'] <= $line[4]  )
    
  // }


  // foreach ($data as $line) {
  //   fputcsv($tempfile, $line);
  // }

  // fclose($tempfile);

  // //Send file to client browser
  // $filename = "/tmp/DHStempfile.csv";

  // if(file_exists($filename)){

  //     //Get file type and set it as Content Type
  //     header('Content-Type: application/csv');

  //     $date = date('Y-m-d');
  //     //Use Content-Disposition: attachment to specify the filename
  //     header("Content-Disposition: attachment; filename={$tableName}-table-{$date}.csv");

  //     //No cache
  //     header('Expires: 0');
  //     header('Cache-Control: must-revalidate');
  //     header('Pragma: public');

  //     //Define file size
  //     header('Content-Length: ' . filesize($filename));

  //     ob_clean();
  //     flush();
  //     readfile($filename);
  //     exit;
  // }

?>

</body>

</html>

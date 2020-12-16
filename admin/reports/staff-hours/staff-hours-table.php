<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Admin | Generate Report</title>
</head>

<body>

  <header>
    <h1>Generate Staff Hour Report</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

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
  print_r($metadata);
  //Get table data
  $query = "SELECT id FROM staff_hours WHERE work_type = $workType";
  $test = pg_query($db_connection, $query);
  
  $status = pg_result_status($test);

  // Determine status
  if ($status == PGSQL_COPY_IN)
     echo "Copy began.";
  else
     echo "Copy failed.";

  // while ($row = pg_fetch_row($test)) {
  //   echo "$row[0] $row[1] $row[2]\n";
  // }
  // print_r($test[0]);

  // foreach ($result as $key => $dataString) {
  //   $result[$key] = explode('%', trim($dataString));
  //   print_r($result[$key]);
  //   echo "<br>";
  // }

  // $rawData = array_merge($metadata, $result);

  // echo "<table>";
  // echo "<tr>";
  // echo "<td>Staff Name</td>";
  // echo "<td>Hours</td>";
  // echo "<td>Work Type</td>";
  // echo "<td>Date</td>";
  // echo "<td>Note</td>";
  
  // array_shift($rawData);
  // foreach ($rawData as $line) {
  //   $allStaff = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = '$line[1]' AND (archived IS NULL OR archived = '');"), 0, 1)['name'];
    
  
  //   echo "<tr>";
  //   echo "<td>$allStaff</td>";
  //   echo "<td>$line[2]</td>";
  //   echo "<td>$line[3]</td>";
  //   echo "<td>$line[4]</td>";
  //   echo "<td>$line[5]</td>";
  //   echo "<td>$line[6]</td>";
  //   echo "</tr>";
  // }
  // echo "</table>";


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

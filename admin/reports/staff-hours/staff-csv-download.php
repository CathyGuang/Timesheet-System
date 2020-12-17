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
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

<?php
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

  $result = unserialize($_POST['hourData']);
  print_r($result);
  echo "haha";
  foreach ($result as $line) {
    $allStaff = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = '{$line['staff']}' AND (archived IS NULL OR archived = '');"), 0, 1)['name'];
  
    echo "<tr>";
    echo "<td>$allStaff</td>";
    echo "<td>{$line['date_of_hours']}</td>";
    echo "<td>{$line['work_type']}</td>";
    echo "<td>{$line['hours']}</td>";
    echo "<td>{$line['notes']}</td>";
    echo "</tr>";
  }
  echo $result[0]['hours'];
  echo "success. <br>";
  print_r($metadata);
  echo "success2. <br>";
  $data = array_merge($metadata, $result);

  print_r($data);
  
//   //Write data to temporary CSV file on the server
//   $tempfile = fopen('/tmp/DHStempfile.csv', 'w');

//   foreach ($data as $line) {
//     fputcsv($tempfile, $line);
//   }

//   fclose($tempfile);

//   //Send file to client browser
//   $filename = "/tmp/DHStempfile.csv";

//   if(file_exists($filename)){

//       //Get file type and set it as Content Type
//       header('Content-Type: application/csv');

//       $date = date('Y-m-d');
//       //Use Content-Disposition: attachment to specify the filename
//       header("Content-Disposition: attachment; filename={$tableName}-table-{$date}.csv");

//       //No cache
//       header('Expires: 0');
//       header('Cache-Control: must-revalidate');
//       header('Pragma: public');

//       //Define file size
//       header('Content-Length: ' . filesize($filename));

//       ob_clean();
//       flush();
//       readfile($filename);
//       exit;
//   }

?>
</body>

</html>
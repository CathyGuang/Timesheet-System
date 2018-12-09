<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/connectdb.php"; ?>
  <title>Admin | Generate Report</title>
</head>

<body>

  <header>
    <h1>Workers Table</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <?php
    $query = "copy workers to 'workers.csv' csv header";
    $result = pg_copy_to($db_connection, "workers", ",");

    var_dump($result);

    $tempfile = fopen('tempfile.csv', 'w');

    foreach ($result as $line) {
      $fields = explode(',', $line);
      fputcsv($tempfile, $fields);
    }

    fclose($tempfile);




    $filename = "tempfile.csv";

    if(file_exists($filename)){

        //Get file type and set it as Content Type
        header('Content-Type: application/csv');

        //add date to filename
        //Use Content-Disposition: attachment to specify the filename
        header('Content-Disposition: attachment; filename="workers-table.csv"');

        //No cache
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        //Define file size
        header('Content-Length: ' . filesize($filename));

        ob_clean();
        flush();
        readfile($filename);
        exit;
    }

  ?>





</body>

</html>

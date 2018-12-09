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


  ?>





</body>

</html>

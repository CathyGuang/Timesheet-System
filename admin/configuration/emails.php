<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Admin | System Emails</title>
</head>

<body>

  <header>
    <h1>Configure System Emails</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">

  <?php
    $volunteerCoordinatorEmail = pg_fetch_array(pg_query($db_connection, "SELECT value FROM misc_data WHERE key LIKE 'volunteer-coordinator-email';"));
    var_dump($volunteerCoordinatorEmail);

  ?>


  </div>


</body>

</html>

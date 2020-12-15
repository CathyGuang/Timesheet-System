<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <title>Admin | Generate Report</title>
</head>

<body>

  <header>
    <h1>Generate Report</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">

    <a href="workers-table.php"><button class="blue-button">Export Staff/Volunteer Data</button></a>
    <a href="volunteer-hours-table.php"><button class="blue-button">Export Volunteer Hours Data</button></a>
    <a href="staff-hours-table"><button class="blue-button">Export Staff Hours Data</button></a>

  </div>

  <?php
    //delete tempfiles from previous reports
    if (file_exists("/tmp/DHStempfile.csv")) {
      unlink("/tmp/DHStempfile.csv");
    }

  ?>




</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
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
    <a href="classes-table.php"><button class="blue-button">Export Class Data</button></a>
    <a href="clients-table.php"><button class="blue-button">Export Client Data</button></a>
    <a href="volunteer-hours-table.php"><button class="blue-button">Export Volunteer Hours Data</button></a>
    <a href="staff-hours-table.php"><button class="blue-button">Export Staff Hours Data</button></a>
    <a href="horses-table.php"><button class="blue-button">Export Horses Data</button></a>
    <a href="horse-care-shifts-table.php"><button class="blue-button">Export Horse Care Shifts Data</button></a>
    <a href="office-shifts-table.php"><button class="blue-button">Export Office Shifts Data</button></a>



  </div>

  <?php
    //delete tempfiles from previous reports
    if (file_exists("tempfile.csv")) {
      unlink("tempfile.csv");
    }

  ?>




</body>

</html>

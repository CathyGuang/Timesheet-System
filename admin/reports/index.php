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



  </div>

  <?php
    //delete tempfiles from previous reports
    if (file_exists("tempfile.csv")) {
      unlink("tempfile.csv");
    }

  ?>




</body>

</html>

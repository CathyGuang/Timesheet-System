<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>View Staff Hours</title>
</head>

<body>

  <header>
    <h1><?php echo $_POST['staff']; ?>'s Hours</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php

    $staffName = pg_escape_string(trim($_POST['staff']));
    $staffID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$staffName}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];
    
    $_SESSION['staffName'] = $staffName;
    $_SESSION['staffID'] = $staffID;
    
    $query = <<<EOT
    SELECT * FROM staff_hours
    WHERE staff = '{$staffID}' AND
    '{$_POST['start-date']}' <= date_of_hours AND
    '{$_POST['end-date']}' >= date_of_hours
    ;
EOT;

    $hourData = pg_fetch_all(pg_query($db_connection, $query));
    if (!$hourData) {
      echo "<h3 class='main-content-header'>No data.</h3><p class='main-content-header'>There are no hour entries for this time period.</p>";
      return;
    }

    $totalHours = 0;
    foreach ($hourData as $uniqueShift) {
      $totalHours += $uniqueShift['hours'];
      echo "<p style='margin-left: 2vw;'>{$uniqueShift['date_of_hours']}: {$uniqueShift['work_type']}, {$uniqueShift['hours']} hrs, {$uniqueShift['notes']}</p><br>";
    }

    echo "<h3 style='position: absolute; top: 25vh; right: 20vw'>Total Hours: {$totalHours}</h3>";

  ?>

  <div class="form-container">
    <form autocomplete="off" class="standard-form" action="hours-complete.php" method="post">

      <div class="form-section">
        <div class="form-element">
          <p>Hours complete for pay period: <input type="checkbox" name="send-email" value="true"></p>
        </div>
      </div>


      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <button type="submit">Submit</button>
      </div>

    </form>
  </div>


</body>

</html>

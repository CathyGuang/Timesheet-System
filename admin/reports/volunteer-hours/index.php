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
    <h1>Generate Volunteer Hour Report</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="form-container">
    <form autocomplete="off" class="standard-form" action="volunteer-hours-table.php" method="post">
      <div class="form-section">
        <div class="form-element">
          <label>Name:</label>
          <input name="volunteer" list="volunteer-list" id="selected-name">
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label>Start Date:</label>
          <input type="date" name="start-date-of-hours" value="<?php echo date('Y-m-d', strtotime('-2 weeks')); ?>">
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label>End Date:</label>
          <input type="date" name="end-date-of-hours" value="<?php echo date('Y-m-d'); ?>">
        </div>
      </div>

      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <button type="submit">Submit</button>
      </div>

    </form>
  </div>



  <!-- DATALISTS -->
  <datalist id="volunteer-list">
    <?php
      $staffNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM workers WHERE volunteer = TRUE;"));
      foreach ($staffNames as $name) {
        $name = htmlspecialchars($name, ENT_QUOTES);
        echo "<option value='{$name}'>";
      }
    ?>
  </datalist>

  <?php
    //delete tempfiles from previous reports
    if (file_exists("/tmp/DHStempfile.csv")) {
      unlink("/tmp/DHStempfile.csv");
    }

  ?>

</body>

</html>

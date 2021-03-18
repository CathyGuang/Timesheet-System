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
    <h1>Staff Hours</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <div class="form-container">
    <form autocomplete="off" class="standard-form" action="full-view-hours.php" method="post">

      <div class="form-section">
        <div class="form-element">
          <label for="staff">Name:</label>
          <input type="text" name="staff" list="staff-list" required>
        </div>
      </div>
          
      <div class="form-section">
        <div class="form-element">
          <label for="start-date">Start Date:</label>
          <input type="date" name="start-date" value="<?php echo date('Y-m-d', strtotime('-2 weeks')); ?>" required>
        </div>
      </div>
          
      <div class="form-section">
        <div class="form-element">
          <label for="end-date">End Date:</label>
          <input type="date" name="end-date" value="<?php echo date('Y-m-d'); ?>" required>
        </div>
      </div>
      
      
      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <button type="submit">Go</button>
      </div>

    </form>
  </div>


  <!-- DATALISTS -->
  <datalist id="staff-list">
    <?php
      $staffNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM workers WHERE staff = TRUE AND (archived IS NULL OR archived = '');"));
      foreach ($staffNames as $name) {
        $name = htmlspecialchars($name, ENT_QUOTES);
        echo "<option value='{$name}'>";
      }
    ?>
  </datalist>


</body>

</html>

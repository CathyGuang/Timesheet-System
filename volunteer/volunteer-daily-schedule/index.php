<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Volunteer Daily Schedule</title>
</head>

<body>

  <header>
    <h1>Volunteer Daily Schedule</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="form-container">
    <form autocomplete="off" action="schedule.php" method="post" class="standard-form standard-form">
      
      <div class="form-section">
        <div class="form-element">
          <label for="selected name">Select your name:</label>
          <input name="selected-name" list="volunteers">
        </div>
      </div>
      
      <div class="form-section">
        <div class="form-element">
          <input type="date" name="selected-date" value="<?php echo date('Y-m-d') ?>">
        </div>
      </div>

      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <button type="submit">Go</button>
      </div>
    
    </form>
  </div>


  <!-- DATALISTS -->
  <datalist id="volunteers">
    <?php
      $volunteerNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM workers WHERE volunteer = TRUE AND (archived IS NULL OR archived = '');"));
      foreach ($volunteerNames as $name) {
        $name = htmlspecialchars($name, ENT_QUOTES);
        echo "<option value='$name'>";
      }
    ?>
  </datalist>


</body>

</html>

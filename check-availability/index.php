<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Check Availability</title>
</head>

<body>

  <header>
    <h1>Check Availability</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <div class="form-container">
    <form autocomplete="off" action="check.php" method="post" class="standard-form standard-form">
      
      <div class="form-section">
        <div class="form-element">
          <label for="target-name">Search for any person/arena/resource:</label>
          <input type="text" name="target-name" id="target-name" list="all-objects-list" required>
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label for="target-date">Select date to check:</label>
          <input type="date" name="target-date" id="target-date" value="<?php echo date('Y-m-d'); ?>" required>
        </div>
      </div>


      <div class="form-section">
        <div class="form-element">
          <label for="start-time">from:</label>
          <input type="time" id="start-time" name="start-time" value="<?php echo date('H:i') ?>" required>
        </div>
        <div class="form-element">
          <label for="end-time">to:</label>
          <input type="time" id="end-time" name="end-time" value="<?php echo date('H:i', strtotime('+1 hour')) ?>" required>
        </div>
      </div>

      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <button type="submit">Check Availability</button>
      </div>
    
    </form>
  </div>


  <!-- DATALISTS -->
  <datalist id="all-objects-list">
    <?php
      $allResources = array();
      $allResources = array_merge($allResources, pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM workers WHERE (archived IS NULL OR archived = '');")));
      $allResources = array_merge($allResources, pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM horses WHERE (archived IS NULL OR archived = '');")));
      $allResources = array_merge($allResources, pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::ARENA))")));
      $allResources = array_merge($allResources, pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::TACK))")));
      $allResources = array_merge($allResources, pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::PAD))")));

      foreach ($allResources as $key => $name) {
        $name = htmlspecialchars($name, ENT_QUOTES);
        echo "<option value='$name'>";
      }
    ?>
  </datalist>




</body>

</html>

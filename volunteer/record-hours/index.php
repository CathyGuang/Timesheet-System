<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Record Volunteer Hours</title>
</head>

<body>

  <header>
    <h1>Volunteer Hours</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <div class="form-container">
    <form autocomplete="off" class="standard-form" action="volunteer-record-hours.php" method="post">


      <div class="form-section">
        <div class="form-element">
          <label>Name:</label>
          <input type="text" name="volunteer" list="volunteer-list" value="<?php echo $_POST['name']; ?>" required>
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label for="shift-type">Type of shift:</label>
          <input type="text" name="shift-type" id="shift-type" list="shift-type-list" required>
        </div>
      </div>

     <div class="form-section">
        <div class="form-element">
          <label>Date:</label>
          <input type="date" name="date-of-hours" value="<?php echo date('Y-m-d'); ?>" required>
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label>Number of hours:</label>
          <input type="text" name="hours" required>
        </div>
      </div>
<!-- 
      <div class="form-section">
        <div class="form-element">
          <label>Notes:</label>
          <input type="text" name="notes">
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <p>Notify supervisor: <input type="checkbox" name="send-email" value="true"></p>
        </div>
      </div> -->


      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <button type="submit">Submit</button>
      </div>

    </form>
  </div>


  <!-- DATALISTS -->
  <datalist id="volunteer-list">
    <?php
      $volunteerNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM workers WHERE volunteer = TRUE AND (archived IS NULL OR archived = '');"));
      foreach ($volunteerNames as $name) {
        $name = htmlspecialchars($name, ENT_QUOTES);
        echo "<option value='{$name}'>";
      }
    ?>
  </datalist>

  <datalist id="shift-type-list">
    <?php
      $horseCareShiftTypes = pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::CARE_TYPE));"));
      foreach ($horseCareShiftTypes as $value) {
        echo "<option value='{$value}'>";
      }
      $officeShiftTypes = pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::OFFICE_SHIFT_TYPE));"));
      foreach ($officeShiftTypes as $value) {
        echo "<option value='{$value}'>";
      }
      $classShiftTypes = pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::VOLUNTEER_CLASS_ROLE));"));
      foreach ($classShiftTypes as $value) {
        echo "<option value='{$value}'>";
      }
    ?>
  </datalist>



</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Staff Timesheet</title>
</head>

<body>

  <header>
    <h1>Staff Timesheet</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="form-container">
    <form autocomplete="off" class="standard-form" id="myform" action="staff-record-hours.php" method="post">

      <div class="form-section">
        <div class="form-element">
          <label>Name:<div id="name_select_reminder"></div></label>
          <input type="text" name="staff" id = "selected-name" list="staff-list" value="<?php echo $_POST['name']; ?>" required>
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label>Type of Work:</label>
          <input type="text" name="work-type" list="work-type-list" required>
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

      <div class="form-section">
        <div class="form-element">
          <label>Notes:</label>
          <input type="text" name="notes">
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <p>Hours complete for pay period: <input type="checkbox" name="send-email" value="true"></p>
        </div>
      </div>


      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <button type="submit" onclick="submitted();">Submit</button>
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

  <datalist id="work-type-list">
    <?php
      $staffShiftTypes = pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::STAFF_WORK_TYPE));"));
      foreach ($staffShiftTypes as $value) {
        echo "<option value='{$value}'>";
      }
    ?>
  </datalist>

  <datalist id="work-type-list">
    <?php
      $staffShiftTypes = pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::STAFF_WORK_TYPE));"));
      foreach ($staffShiftTypes as $value) {
        echo "<option value='{$value}'>";
      }
    ?>
  </datalist>

</body>

<script type="text/javascript" src="query.js"></script>


</html>

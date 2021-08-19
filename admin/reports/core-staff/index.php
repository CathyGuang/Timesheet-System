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
    <h1>Generate Core Staff Report</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="form-container">
    <form autocomplete="off" class="standard-form" action="core-hour-table.php" method="post">
      <div class="form-section">
        <div class="form-element">
          <label>Name:</label>
          <input name="staff" list="staff-list" id="selected-name">
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
        <div class="form-element">
          <label>Sort Method:</label>
          <input name="sort" list="sort-list">
        </div>
      </div>

      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <button type="submit">Submit</button>
      </div>

    </form>
  </div>



  <!-- DATALISTS -->
  <datalist id="staff-list">
    <?php
      $staffNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM workers WHERE staff = TRUE;"));
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

  <datalist id="sort-list">
    <option value='date_of_shift'>
    <option value='staff'>
    <option value='work_type'>
  </datalist>

  <?php
    //delete tempfiles from previous reports
    if (file_exists("/tmp/DHStempfile.csv")) {
      unlink("/tmp/DHStempfile.csv");
    }

  ?>

</body>

</html>

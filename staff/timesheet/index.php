<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/connectdb.php"; ?>
  <title>Staff Timesheet</title>
</head>

<body>

  <header>
    <h1>Staff Timesheet</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


      <form class="main-form" action="staff-record-hours.php" method="post">

        <p>Name:</p>
        <input type="text" name="staff" list="staff-list" required>
          <datalist id="staff-list">
            <?php
              $staffNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM workers WHERE staff = TRUE;"));
              foreach ($staffNames as $name) {
                echo "<option value='{$name}'>";
              }
            ?>
          </datalist>

        <p>Type of Work:</p>
        <input type="text" name="work-type" list="work-type-list" required>
          <datalist id="work-type-list">
            <?php
              //POTENTIALLY CHANGE THIS SECTION TO DISPLAY A LIST OF STAFF WORK OPTIONS INSTEAD OF VOLUNTEER ONES
              //-------------------------------------------------------------------------
              $classTypes = pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::CLASS_TYPE));"));
              foreach ($classTypes as $value) {
                echo "<option value='{$value} &#8212 Leader'>";
                echo "<option value='{$value} &#8212 Sidewalker'>";
              }
              $horseCareShiftTypes = pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::CARE_TYPE));"));
              foreach ($horseCareShiftTypes as $value) {
                echo "<option value='{$value}'>";
              }
              $officeShiftTypes = pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::OFFICE_SHIFT_TYPE));"));
              foreach ($officeShiftTypes as $value) {
                echo "<option value='{$value}'>";
              }
              //-----------------------------------------------------------------
            ?>
          </datalist>

        <p>Date:</p>
        <input type="date" name="date-of-hours" value="<?php echo date('Y-m-d'); ?>" required>

        <p>Number of hours</p>
        <input type="number" name="hours" required>

        <br><br>
        <input type="submit" value="Submit">
      </form>



</body>

</html>

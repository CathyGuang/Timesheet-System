<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
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



    <form autocomplete="off" class="main-form" action="volunteer-record-hours.php" method="post">

      <p>Name:</p>
      <input type="text" name="volunteer" list="volunteer-list" required>
        <datalist id="volunteer-list">
          <?php
            $volunteerNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM workers WHERE volunteer = TRUE AND (archived IS NULL OR archived = '');"));
            foreach ($volunteerNames as $name) {
              $name = htmlspecialchars($name, ENT_QUOTES);
              echo "<option value='{$name}'>";
            }
          ?>
        </datalist>

      <p>Type of shift:</p>
      <input type="text" name="shift-type" list="shift-type-list" required>
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

      <p>Date:</p>
      <input type="date" name="date-of-hours" value="<?php echo date('Y-m-d'); ?>" required>

      <p>Number of hours:</p>
      <input type="text" name="hours" required>

      <p>Notes:</p>
      <input type="text" name="notes">

      <p>Notify Supervisor: <input type="checkbox" name="send-email" value="true"></p>


      <br><br>
      <input type="submit" value="Submit">
    </form>


</body>

</html>

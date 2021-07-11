<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <script type="text/javascript" src="/static/jquery.min.js"></script>
  <script type="text/javascript" src="/static/jquery-ui.js"></script>
  <link rel="stylesheet" href="/static/enter_hour.css">
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
    <form autocomplete="off" id = "myform" class="standard-form" action="volunteer-record-hours.php" method="post">


      <div class="form-section">
        <div class="form-element">
          <label>Name:<div class="name_select_reminder" id="name_select_reminder"></div></label>
          <input type="text" name="volunteer" id="selected-name" list="volunteer-list" value="<?php echo $_POST['name']; ?>" required>
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label for="shift-type">Type of shift:<div class="work_select_reminder" id="work_select_reminder"></div></label>
          <input type="text" name="shift-type" id="selected-job" list="shift-type-list" required>
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
          <label>Number of hours:<div class="hour_select_reminder" id="hour_select_reminder"></div></label>
          <input type="text" id = "selected-hour" name="hours" required>
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
        <button type="button" class="purplebut" id="purplebut" onclick="submitted();">Submit</button>
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
      $horseCareShiftTypes = pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::CARE_TYPE))::text EXCEPT SELECT name FROM archived_enums;"));
      foreach ($horseCareShiftTypes as $value) {
        echo "<option value='{$value}'>";
      }
      $officeShiftTypes = pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::OFFICE_SHIFT_TYPE))::text EXCEPT SELECT name FROM archived_enums;"));
      foreach ($officeShiftTypes as $value) {
        echo "<option value='{$value}'>";
      }
      $classShiftTypes = pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::VOLUNTEER_CLASS_ROLE))::text EXCEPT SELECT name FROM archived_enums;"));
      foreach ($classShiftTypes as $value) {
        echo "<option value='{$value}'>";
      }
    ?>
  </datalist>



</body>

<script type="text/javascript" src="/static/query5.js"></script>

</html>

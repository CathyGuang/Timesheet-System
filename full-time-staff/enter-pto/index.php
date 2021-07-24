<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <script type="text/javascript" src="/static/jquery.min.js"></script>
  <script type="text/javascript" src="/static/jquery-ui.js"></script>
  <link rel="stylesheet" href="/static/enter_hour.css">
  <link rel="stylesheet" href="\../enter-hours/css/slider.css">
  <link rel="stylesheet" href="\../enter-hours/css/jquery-ui.css">
  <link rel="stylesheet" href="\../enter-hours/css/rangeslider.css">
  <link rel="stylesheet" href="\../enter-hours/css/added.css">
  <link rel="stylesheet" href="\../enter-hours/css/choices.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>PTO/Holiday Hours</title>
</head>

<body class= "full-time-report" style="background-color:#D0BDF4;min-width:1226px;background-image: url('\../enter-hours/hor.png')">

    <div class="full-time-header">
    <p class="full-time-title">Enter PTO/Holiday Hours</p>
    <nav class="button-container"> 
      `<button onclick="history.back()" class="back-button">Back</button>
      <a href="/"><button class="home-button">Home</button></a>
    </nav>
    </div>

  <div class="form-container">
    <form autocomplete="off" id = "myform" class="standard-form" action="staff-record-hours.php" method="post">

      <div class="form-section">
        <div class="form-element">
          <label>Name:<div class="name_select_reminder" id="name_select_reminder"></div></label>
          <input type="text" name="staff" id="selected-name" list="staff-list" value="<?php echo $_POST['name']; ?>" required>
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label>Type of Work:<div class="work_select_reminder" id="work_select_reminder"></div></label>
          <input type="text" name="work-type" id="selected-job" list="work-type-list" required>
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
          <input type="text" name="hours" id = "selected-hour" required>
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label>Notes:</label>
          <input type="text" name="notes">
        </div>
      </div>
       
<!-- Below content moved to View Hour
      <div class="form-section">
        <div class="form-element">
          <p>Hours complete for pay period: <input type="checkbox" name="send-email" value="true"></p>
        </div>
      </div> -->


      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <button type="button" class="purplebut" id="purplebut"onclick="submitted();">Submit</button>
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
      $staffShiftTypes = pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::STAFF_WORK_TYPE))::text EXCEPT SELECT name FROM archived_enums;"));
      foreach ($staffShiftTypes as $value) {
        echo "<option value='{$value}'>";
      }
    ?>
  </datalist>

</body>

<script type="text/javascript" src="/static/query.js"></script>


</html>

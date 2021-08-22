<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <script type="text/javascript" src="/static/jquery.min.js"></script>
  <script type="text/javascript" src="/static/jquery-ui.js"></script>
  <link rel="stylesheet" href="/static/enter_hour.css">
  <!-- The javascript passing data list id and idd to this page from perivous selection -->
  <script type="text/javascript" src="change_data.js"></script>
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Change Data</title>
</head>

<body>

  <header>
    <h1>Change Hours</h1>
    <nav> 
      <button onclick="history.back()" >Back</button>
      <form>
        <input type="button" class="check_pay_period_button" value="Pay Periods" onclick= "window.location.href='\../enter-hours/payPeriod.php';">
      </form>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <div class="form-container">
    <form autocomplete="off"  id = "myform" class="standard-form" action="change_complete.php" method="post">

      <?php 
      session_start();
      $iDD = $_POST['idd'];
      $staff = $_SESSION['staff'];
      $date = $_SESSION[$iDD.'shift_date'];
      $hours = $_SESSION[$iDD.'hours'];
      $work = $_SESSION[$iDD.'work_type'];


      echo $iDD;
      echo $_SESSION['staff'];
      echo $_SESSION[$iDD.'shift_date'];
      ?>
      
          
      <div class="form-section">
        <div class="form-element">
          <label>Type of Work:<div class="work_select_reminder" id="work_select_reminder"></div></label>
          <input type="text" name="work-type" value="<?php echo $work?>" id="selected-job" list="work-type-list" required>
        </div>
      </div>


      <div class="form-section">
        <div class="form-element">
          <label>Number of hours:<div class="hour_select_reminder" id="hour_select_reminder"></div></label>
          <input type="text" name="hours" value="<?php echo $hours?>" id = "selected-hour" required>
        </div>
      </div>
      
      
      
      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <button type="button" class="purplebut" id="purplebut" onclick="submitted();">Go</button>
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
        echo "{$value},";
      }
    ?>
  </datalist>


</body>



</html>

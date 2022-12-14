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
  <title>View Staff Hours</title>
</head>

<body>

  <header>
    <h1>Staff Hours</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
    <form>
        <input type="button" class="check_pay_period_button" value="Pay Periods" onclick= "window.location.href='\../\../full-time-staff/enter-hours/payPeriodPart.php';">
      </form>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <div class="form-container">
    <form autocomplete="off" id = "myform" class="standard-form" action="view-hours.php" method="post">

      <div class="form-section">
        <div class="form-element">
          <label for="staff">Name:<div class="name_select_reminder" id="name_select_reminder"></div></label>
          <input type="text" name="staff" id="selected-name" list="staff-list" required>
        </div>
      </div>
          
      <div class="form-section">
        <div class="form-element">
          <label for="start-date">Start Date:</label>
          <input type="date" name="start-date" value="<?php echo date('Y-m-d', strtotime('-2 weeks')); ?>" required>
        </div>
      </div>
          
      <div class="form-section">
        <div class="form-element">
          <label for="end-date">End Date:</label>
          <input type="date" name="end-date" value="<?php echo date('Y-m-d'); ?>" required>
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


</body>

<script type="text/javascript" src="/static/query2.js"></script>


</html>

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
  <title>View Staff Hours</title>
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
    <form autocomplete="off"  id = "myform" class="standard-form" action="full-view-hours.php" method="post">
      
      
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



</html>

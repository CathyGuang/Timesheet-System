<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <script type="text/javascript" src="/full-time-staff/enter-hours/js/jquery.min.js"></script>
  <script type="text/javascript" src="/full-time-staff/enter-hours/js/jquery-ui.js"></script>
  <script type="text/javascript" src="/full-time-staff/enter-hours/js/rangeslider.min.js"></script>
  <script type="text/javascript" src="/full-time-staff/enter-hours/js/choices.js"></script>
  <link rel="stylesheet" href="/full-time-staff/enter-hours/css/jquery-ui.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Alter Pay Period | <?php echo $organizationName; ?> Web Portal</title>
</head>

<body>

  <header>
    <h1>Alter Pay Period</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="form-container">
    <form autocomplete="off" action="alter_pay.php" id="myform" class="standard-form" method="post">

    <div class="form-section">
        <div class="form-element" style = "padding-top: 10px;">
          <label>Current Pay Cycle:</label>
          Start Date: <div id = "start-date"></div>    
          End Date:<div id = "end-date"></div>   
          Pay Date:<div id = "pay-date"></div> 
        </div>
      </div>


    <div class="form-section">
        <div class="form-element">
          <label>New Start Date:</label>
          <input type="date" name="date-of-hours" id="new-start-date" value="<?php echo date('Y-m-d'); ?>" required>
        </div>
      </div>


      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <button type="submit" onclick="submitted();">Submit</button>
      </div>

    </form>
  </div>

  <script type="text/javascript" src="alter_pay.js"></script>


  
  <!-- DATALISTS -->
  <datalist id="recipient-list">
    <option value="Staff">
    <option value="Volunteers">
    <option value="Staff and Volunteers">
    <option value="Clients">
    <option value="Horse Owners">
    <option value="All">
  </datalist>




</body>

</html>
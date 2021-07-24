<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <script src="https://kit.fontawesome.com/22bba2cae7.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="/static/main.css">
  <script type="text/javascript" src="/static/jquery.min.js"></script>
  <script type="text/javascript" src="/static/jquery-ui.js"></script>
  <script type="text/javascript" src="/full-time-staff/enter-hours/js/rangeslider.min.js"></script>
  <script type="text/javascript" src="/full-time-staff/enter-hours/js/choices.js"></script>
  <link rel="stylesheet" href="/full-time-staff/enter-hours/css/slider.css">
  <link rel="stylesheet" href="/full-time-staff/enter-hours/css/jquery-ui.css">
  <link rel="stylesheet" href="/full-time-staff/enter-hours/css/rangeslider.css">
  <link rel="stylesheet" href="/full-time-staff/enter-hours/css/added.css">
  <link rel="stylesheet" href="/full-time-staff/enter-hours/css/choices.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>PTO/Holiday Hours</title>
</head>

<body class= "full-time-report" style="background-color:#D0BDF4;min-width:1226px;background-image: url('/full-time-staff/enter-hours/hor.png')">
   
  <img src="holiday.png" class= "horse" alt="horse picture">

  <div class="full-time-header">
    <p class="full-time-title">Enter PTO/Holiday Hours</p>
    <div class="PTO-button-container"> 
      <button class="back-button"onclick="history.back()">Back</button>
      <button class="home-button">Home</button>
    </div>
  </div>


  <div class= "fulltime-form-container" >

    <form class="white-background" method="post" name="myform" id="myform" action="full-time.php">

        <div class="form-inline" >
            <div id="name_select_reminder"></div>

            <div class="labelBar">
            <label for="Name" class="label-element"  >Name:</label>
            <input name="selected-name" list="staff-list" id="selected-name"  placeholder="Enter name" class="input-element"  value="<?php echo $_POST['name']; ?>" required>
            </div>
            
            <div class="labelBar" style="left:350px;">
            <label for="Date" class="label-element" >Date:</label>
            <input type="Date" id="work_date"  name="Date" value="<?php echo date('Y-m-d'); ?>" required class="input-element" >
            </div>
                
            
        </div>
     
          
        

    
    </form>




          
   

  </div>

  <div style="height:100px;"></div>   

  <!-- data list -->

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

<script type="text/javascript" src="/full-time-staff/enter-hours/js/query.js"></script>

</html>

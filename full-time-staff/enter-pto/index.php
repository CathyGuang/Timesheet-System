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

<body class= "full-time-report" style="background-color:#bddff4;min-width:1226px;background-image: url('/full-time-staff/enter-hours/hor.png')">
   
  <img src="ho.png" class= "holiday_horse" alt="horse picture">

  <div class="full-time-header">
    <p class="full-time-title">Enter PTO/Holiday Hours</p>
    <div class="PTO-button-container"> 
      <button class="back-button" onclick="history.back()">Back</button>
      <button class="home-button" onclick="window.location.href='https://scheduledev.forwardstride.org/'">Home</button>
    </div>
  </div>


  <div class= "fulltime-form-container" >

    <form class="white-background" method="post" name="myform" id="myform" action="full-time.php" style = "border-radius: 20px;border: 2px solid #A0D2EB;">

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
        <hr class="line_below_form_inline">

        <div class="time-range-container"style="height:100px">
            <div class = "time-range-title" style="top:-0.5em;">
                Select Hour Type
                
            </div>
            <div class = "PTO-choice-button">
                <input type="radio" name="choice" value="PTO" id="choice-pto"> 
                <label for="choice-pto" style="width:90px;margin-left:275px;">PTO</label>
                <input type="radio" name="choice" value="Holiday" id="choice-holiday" >
                <label for="choice-holiday">Holiday</label>
                <!-- <button id="btn" onclick = "clicked();">Show Selected Value</button> -->
            </div>

        
        </div>
        <hr class="line_below_form_inline" style="top:1em;">
        <div class="time-range-container" style="top:-1em;">
            <div class = "time-range-title" style="height:45px;">
                Enter Hours<br>
                <span id="pto_hour_reminder">Entree must be a number</span>
            </div>
            <div class = "enter-hours-pto">
                <input type="number" id="quantity" name="quantity" min="0" max="50">
            </div>
        </div>

        <hr class="line_below_form_inline" style="top:-4.4em;">
        <div class= "job_notes" style="top:-4em;">
          <div class="job_notes_title"> 
            Notes
  
          </div>

          <div class="note-box">
          <input type="text" name="notes" class="note-input" id="notes" placeholder="Your notes...">
          </div>

        </div>


        <div class="PTO-button-container"> 

            <div class="submit_and_cancel">
            <button type="button" class="cancel" >Cancel</button>
            <button type="button" class="submit" >Submit</button>
        
            </div>

            <div class = "check_pay_period">

                <button type="button" class = "payPeriod" >Check Pay Periods</button>

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

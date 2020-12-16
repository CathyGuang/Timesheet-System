<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <script src="https://kit.fontawesome.com/22bba2cae7.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui.js"></script>
  <script type="text/javascript" src="js/rangeslider.min.js"></script>
  <script type="text/javascript" src="js/choices.js"></script>
  <link rel="stylesheet" href="css/slider.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/rangeslider.css">
  <link rel="stylesheet" href="css/added.css">
  <link rel="stylesheet" href="css/choices.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?> 
  <title>Full time</title>
 
</head>

<body class= "full-time-report" style="background-color:#D0BDF4;min-width:1226px;background-image: url('hor.png')">
   
  <img src="horse_pattern.png" class= "horse" alt="horse picture">

  <div class="full-time-header">
    <p class="full-time-title">Full-time Staff Timesheet</p>
    <nav class="button-container"> 
      <a href="../"><button class="back-button">Back</button></a>
      <a href="/"><button class="home-button">Home</button></a>
    </nav>
  </div>

  <div class= "fulltime-form-container" >

    <form class="white-background" method="post" name="myform" action="full-time.php">

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

      <div class="time-range-container">
        <div class="time-range-title"> 
          Select work time<br>
          <span class="selected_worktime" id="worktime_reminder" style="color:#EA7186">Please select the time you have worked</span>

        </div>

        

        <div class = "add_minus_button">
            <button class= "add_button" onclick="addTimeRange()" id = "add_button"><i class="fas fa-plus"></i></button>
        
      
            <button class= "delete_button" onclick="minusTimeRange()" id = "delete_button" ><i class="fas fa-minus"></i></button>
    
        </div>


        <div class="purple_background">
          <div class="time-range-display">
            Range 6AM - 10PM
          </div>

          <div class="time-range" id = "range1"style="left:2em; top:-2em;">
            <p class="time-range-time"> <span class="slider-time"></span><span class="slider-time2">N/A</span>

            </p>
            <div class="sliders_step1">
                <div id="slider-range" class="a_slider"></div>
            </div>
          </div>


          <div class="time-range" id = "range2"style="left:5em;top:-2em;" >
            <p class="time-range-time"> <span class="slider-time1">N/A</span><span class="slider-time3"></span>

            </p>
            <div class="sliders_step1">
                <div id="slider-range1" class="a_slider"></div>
            </div>
          </div>  


          <div class="time-range" id = "range3"style="left:2em; top:-3em;">
            <p class="time-range-time"> <span class="slider-time4"></span><span class="slider-time5">N/A</span>

            </p>
            <div class="sliders_step1">
                <div id="slider-range2" class="a_slider"></div>
            </div>
          </div>


          <div class="time-range" id = "range4"style="left:5em; top:-3em;" >
            <p class="time-range-time"> <span class="slider-time6"></span><span class="slider-time7">N/A</span>

            </p>
            <div class="sliders_step1">
                <div id="slider-range3" class="a_slider"></div>
            </div>
          </div>  


          <div class="time-range" id = "range5" style="left:2em; top:-4em;">
            <p class="time-range-time"> <span class="slider-time8"></span><span class="slider-time9">N/A</span>

            </p>
            <div class="sliders_step1">
                <div id="slider-range4" class="a_slider"></div>
            </div>
          </div>


          <div class="time-range" id = "range6" style="left:5em; top:-4em;" >
            <p class="time-range-time"> <span class="slider-time10"></span><span class="slider-time11">N/A</span>

            </p>
            <div class="sliders_step1">
                <div id="slider-range5" class="a_slider"></div>
            </div>
          </div>  


        </div>
        

      </div>

      <hr class="line_below_form_inline" style="top:2em;">


      <!-- slider hour bars for different types of work -->
      <div class= "worktype_row_container">
        <div class="job-select-title"> 
          Select job(s) to Report<br>
          <span id="job_reminder" style="color:#EA7186; top:0em;">Please select the jobs to report</span>

        </div>
        <div class="job_selector" style="top:5em;">
          
            <select
              class="form-control"
              name="choices-multiple-remove-button"
              id="choices-multiple-remove-button"
              placeholder="This is a search placeholder"

              multiple
            > 

            <option value="">Click to type or select</option>
      
            
        
            </select>
          
        </div>



        <div class="worktype1" >

          <section class="worktype_hour_slider">

              <label>worktype_hour_slider</label>

              <input
              name="range1"
              type="range"
              min="0"                   
              max="720"                  
              step="15"                   
              value="0"                 
              data-orientation="horizontal" 
              >

              <div class="output_hours"></div>

          </section> 

          <section class="worktype_hour_slider">
              <label></label>
              <input
              name="range2"
              type="range"
              min="0"                   
              max="720"                  
              step="15"                   
              value="0"                 
              data-orientation="horizontal" 
              >

              <div class="output_hours"></div>

          </section> 

          <section class="worktype_hour_slider" >
              <label>worktype_hour_slider</label>
              <input
              name="range3"
              type="range"
              min="0"                   
              max="720"                  
              step="15"                   
              value="0"                 
              data-orientation="horizontal" 
              >

              <div class="output_hours"></div>

          </section> 

          <section class="worktype_hour_slider" >
              <label></label>
              <input
              name="range4"
              type="range"
              min="0"                   
              max="720"                  
              step="15"                   
              value="0"                 
              data-orientation="horizontal" 
              >

              <div class="output_hours"></div>

          </section>

          <section class="worktype_hour_slider">
              <label></label>
              <input
              name="range5"
              type="range"
              min="0"                   
              max="720"                  
              step="15"                   
              value="0"                 
              data-orientation="horizontal" 
              >

              <div class="output_hours"></div>

          </section> 

          <section class="worktype_hour_slider">
              <label></label>
              <input
              name="range6"
              type="range"
              min="0"                   
              max="720"                  
              step="15"                   
              value="0"                 
              data-orientation="horizontal" 
              >

              <div class="output_hours"></div>

          </section> 

          <section class="worktype_hour_slider">
              <label></label>
              <input
              name="range7"
              type="range"
              min="0"                   
              max="720"                  
              step="15"                   
              value="0"                 
              data-orientation="horizontal" 
              >

              <div class="output_hours"></div>

          </section> 

          <section class="worktype_hour_slider" >
              <label></label>
              <input
              name="range8"
              type="range"
              min="0"                   
              max="720"                  
              step="15"                   
              value="0"                 
              data-orientation="horizontal" 
              >

              <div class="output_hours"></div>

          </section>

        </div>

        <hr class="line_below_form_inline" style="top:6em;">

        <div class= "job_notes">
          <div class="job_notes_title"> 
            Notes
  

          </div>

          <div class="note-box">
          <input type="text" name="notes" class="note-input" id="notes" placeholder="Your notes...">
          </div>

        </div>

        
      </div>
      
        

      <div class="payroll_complete_check">
        <p class="payroll_text">Hours complete for pay period: 
          <input type="checkbox" name="send-email" value="true">
          <span class="checkmark"></span>
        </p>
      </div>

            
      <input type="hidden" name="StaffName" id="StaffName" value = "NAME">
      <input type="hidden" name="StaffDate" id="StaffDate" value="DATE">
      <input type="hidden" name="Notes" id="Notes" value="NOTES">
      <input type="hidden" name="TotalTime" id="TotalTime" value="Total Hours">

      <div class="submit_and_cancel">
          <button type="button" class="cancel" >Cancel</button>
          <button type="submit" class="submit" onclick="submitted();" >Submit</button>
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
</body>

<script type="text/javascript" src="js/query.js"></script>

</html>

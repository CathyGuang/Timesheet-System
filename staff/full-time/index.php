<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <script type="text/javascript" src="//code.jquery.com/jquery-2.0.2.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script type="text/javascript" src="https://rangeslider.js.org/assets/rangeslider.js/dist/rangeslider.min.js"></script>
  <script type="text/javascript" src="/static/rangeslider.js"></script>
  <link rel="stylesheet" href="/static/slider.css">
  <link rel="stylesheet" href="/static/jquery-ui.css">
  <link rel="stylesheet" href="/static/rangeslider.css">
  <link rel="stylesheet" href="/static/added.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?> 
  <title>Full time</title>

  </head>

<body style="background-color:#D0BDF4">


  <header class="full-time-header">
    <p class="full-time-title">Full-time Staff Timesheet</p>
    <nav class="button-container"> 
      <a href="../"><button class="back-button">Back</button></a>
      <a href="/"><button class="home-button">Home</button></a>
    </nav>
  </header>

  <div class= "fulltime-form-container">
          
    <form class="form-inline" action="/full-time.php">
      <label for="Name">Name:</label>
      <input type="text" id="Name" name="staff" list="staff-list" value="<?php echo $_POST['name']; ?>" required>
      <input type="Name" id="Name" placeholder="Enter name" name="Name">
      <label for="Date">Date:</label>
      <input type="Date" name="Date" value="<?php echo date('Y-m-d'); ?>" required>
    
    </form>

    <div class="time-range-container">
      <div class="time-range">
        <p class="time-range-time"> <span class="slider-time">10:00 AM</span> - <span class="slider-time2">12:00 PM</span>

        </p>
        <div class="sliders_step1">
            <div id="slider-range"></div>
        </div>
      </div>

      <div class="time-range" style="left:26em;">
        <p class="time-range-time"> <span class="slider-time1">10:00 AM</span> - <span class="slider-time3">12:00 PM</span>

        </p>
        <div class="sliders_step1">
            <div id="slider-range1"></div>
        </div>
      </div>

    </div>
    <div class= "worktype_row_container">
      <div class="worktype" style="left:22em">
        <section class="indirectadmin">
            <input
            name="range1"
            type="range"
            min="0"                   
            max="720"                  
            step="10"                   
            value="0"                 
            data-orientation="horizontal" 
            >

            <div class="output_hours"></div>

        </section> 

        <section class="riding">
            <input
            name="range2"
            type="range"
            min="0"                   
            max="720"                  
            step="10"                   
            value="0"                 
            data-orientation="horizontal" 
            >

            <div class="output_hours"></div>

        </section> 

        <section class="vaulting admin" >
            <input
            name="range3"
            type="range"
            min="0"                   
            max="720"                  
            step="10"                   
            value="0"                 
            data-orientation="horizontal" 
            >

            <div class="output_hours"></div>

        </section> 
      </div>
      <div class="worktype" style="left:42em">
        <section class="vaulting">
        <input type="text" name="work-type" list="work-type-list" required>
            <input
            name="range4"
            type="range"
            min="0"                   
            max="720"                  
            step="10"                   
            value="0"                 
            data-orientation="horizontal" 
            >

            <div class="output_hours"></div>

        </section> 

        <section class="PTO">
            <input
            name="range5"
            type="range"
            min="0"                   
            max="720"                  
            step="10"                   
            value="0"                 
            data-orientation="horizontal" 
            >

            <div class="output_hours"></div>

        </section> 

        <section class="Holiday">
            <input
            name="range6"
            type="range"
            min="0"                   
            max="720"                  
            step="10"                   
            value="0"                 
            data-orientation="horizontal" 
            >

            <div class="output_hours"></div>

        </section> 



      </div>

    </div>
    
  
  </div>

  
  



</body>

<script type="text/javascript" src="/static/query.js"></script>

</html>

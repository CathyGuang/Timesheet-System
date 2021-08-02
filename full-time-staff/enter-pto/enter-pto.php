<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
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
  <title>PTO/Holiday time</title>
</head>

<body class= "full-time-report" style="background-color:#bddff4;min-width:1226px;background-image: url('/full-time-staff/enter-hours/hor.png')">

  <img src="ho.png" class= "holiday_horse" alt="horse picture">

  <?php

    $staffName = pg_escape_string(trim($_POST['selected-name']));
    $staffID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$staffName}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];

    $date = $_POST['Date'];
    $type = $_POST['choice'];
    $hours = $_POST['quantity'];
    $notes = $_POST['notes'];

  ?>

 <div class="full-time-header">
    <p class="full-time-title"><?php echo $type?> Hours Successfully Submitted</p>
    <div class="PTO-button-container"> 
      <button class="back-button" onclick="history.back()">Back</button>
      <button class="home-button" onclick="window.location.href='\../\..'">Home</button>
    </div>
  </div>

  <div class="submit_background" style= "border-radius: 10px;">
    
    <div class = "submitted_date_and_hours">
      <div class = "submitted_grid">
        <p class="submitted_hours_title">DATE:</p>
        <p class="submitted_info"><?php echo $date ?></p>
      </div>

      <div class = "submitted_grid">
        <p class="submitted_hours_title">HOURS:</p>
        <p class="submitted_info"><?php echo $hours ?></p>
      </div>

      <div class = "submitted_grid">
        <p class="submitted_hours_title">TYPE:</p>
        <p class="submitted_info"><?php echo $type ?></p>
      </div>
    </div>
    

  <?php

    $holidayHourQuery = <<<EOT
      INSERT INTO holiday_hours
      VALUES ('{$staffID}', '{$date}', '{$type}', '{$hours}', '{$notes}')
      ;
  EOT;

    $holidayHourResult = pg_query($db_connection, $holidayHourQuery);

  ?>
    </tbody>
    </table>
    <br>
    </div>
  </div>
  
</body>
<form action='index.php' class= 'submit_another_container'method='post'>
  <button  class='submit_another' type='submit' onclick="window.location.href='index.php'" >Submit Another</button>
  <button  onclick="checkPeriod();"> Check Pay Period </button>
  <button  class='view_hours' type='button' onclick="window.location.href='\../view-hours'" >View My Hours</button>
</form>

</html>
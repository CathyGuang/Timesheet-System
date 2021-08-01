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
      <a href="../view-hours"><button class="view-hours">View Hours</button></a> 
      <button class="home-button" onclick="window.location.href='https://scheduledev.forwardstride.org/'">Home</button>
    </div>
  </div>

  <div class="submit_background">
    
    <div class = "submitted_date_and_hours">
      <p class="submitted_date"><?php echo $date ?></p>
      <p class="submitted_hours_title">HOURS</p>
      <p class="submitted_hours"><?php echo $hours ?></p>
    </div>
    
    <div class="tables">
    <table class="table-fill">
    <thead>
    <tr>
    <th class="text-left">Type</th>
    <th class="text-left">Hours</th>
    </tr>
    </thead>
    <tbody class="table-hover">

  <?php

    $holidayHourQuery = <<<EOT
      INSERT INTO holiday_hours
      VALUES ('{$staffID}', '{$date}', '{$type}', '{$hours}', '{$notes}')
      ;
  EOT;

    $holidayHourResult = pg_query($db_connection, $holidayHourQuery);

    echo "<tr><td class='text-left'>".$type."</td>
    <td class='text-left'>".$hours."</td>
    </tr>";
  ?>
    </tbody>
    </table>
    <br>
    </div>
  </div>
  
  </body>

</html>
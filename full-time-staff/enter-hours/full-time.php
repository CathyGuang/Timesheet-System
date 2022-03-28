<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/added.css">
<link rel="stylesheet" href="css/table.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Full time</title>
</head>

<body style="background-color:#D0BDF4;min-width:1226px;background-image: url('hor.png')">

  <header class="full-time-header">
    <p class="full-time-title">Hours successfully submitted</p>
    <nav class="button-container"> 
      <a href="../"><button class="back-button">Back</button></a>
      <a href="/"><button class="home-button">Home</button></a>
    </nav>

    
  </header>

  <?php

    $staffName = pg_escape_string(trim($_POST['selected-name']));
    $staffID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$staffName}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];

    $date = $_POST['Date'];
    $notes = $_POST['notes'];
    $totalMin = $_POST['TotalTime'];
    $totalHour = $totalMin/60; 
    $inOutTimeRaw = $_POST['InOutTime'];
    $workTypeHourRaw = $_POST['WorkTypeHour'];



  ?>

  

    
  <div class="submit_background">
    
    <div class = "submitted_date_and_hours">
      <p class="submitted_date"><?php echo $date ?></p>
      <p class="submitted_hours_title">TOTAL HOURS</p>
      <p class="submitted_hours"><?php echo $totalHour ?></p>
    </div>
    
    <div class="tables">
    <table class="table-fill">
    <thead>
    <tr>
    <th class="text-left">Work</th>
    <th class="text-left">Hours</th>
    </tr>
    </thead>
    <tbody class="table-hover">
    <!-- <tr>
    <td class="text-left">January</td>
    <td class="text-left">$ 50,000.00</td>
    </tr> -->
  

    

  

  <?php

    $inOutTimeArray = explode("\"},{\"", trim($inOutTimeRaw, "[{\"}]"));
    $order1 = array("intime\":","\"","outtime:");
    $replace = '';
    foreach ($inOutTimeArray as &$line) {
      $line = explode(",", str_replace($order1, $replace, $line));
    }
    unset($line);


    $workTypeHourArray = explode("},{\"", trim($workTypeHourRaw,"[{\"}]"));
    $order2 = array("worktype",":","\"","time");
    foreach ($workTypeHourArray as &$row) {
      $row = explode(",", str_replace($order2, $replace, $row));
    }
    unset($row);

    $totalDayHourQuery = <<<EOT
    SELECT * FROM full_total_hours
    WHERE full_total_hours.staff = '{$staffID}' AND
    full_total_hours.date_of_shift = '{$date}'
    ;
    EOT;
    $totalHourData = pg_fetch_all(pg_query($db_connection, $totalDayHourQuery));
    $totalDayHour = 0;
    foreach($totalHourData as $day){
        $totalDayHour = $totalDayHour + $day['total_hour'];
    }

    $totalDayFinalHour = $totalDayHour + $totalHour;

    // echo $totalDayFinalHour;

    $totalHourQuery = <<<EOT
      INSERT INTO full_total_hours (staff, date_of_shift, total_hour, notes)
      VALUES ('{$staffID}', '{$date}', '{$totalDayFinalHour}', '{$notes}')
      ;
  EOT;
    
    $deleteExcessHourQuery = <<<EOT
    DELETE FROM full_total_hours 
    WHERE full_total_hours.staff = '{$staffID}' AND
    full_total_hours.date_of_shift = '{$date}'
    ;
  EOT;

  pg_query($db_connection, $deleteExcessHourQuery);

  $totalHourResult = pg_query($db_connection, $totalHourQuery);

    foreach ($workTypeHourArray as $data){
      $workType = $data[0];
      $hours = $data[1];
      echo "<tr><td class='text-left'>".$workType."</td>
      <td class='text-left'>".$hours."</td>
      </tr>";
      // echo "";
      $workTypeQuery = <<<EOT
          INSERT INTO full_job_hours (staff, date_of_shift, work_type, hours)
          VALUES ('{$staffID}', '{$date}', '{$workType}', '{$hours}')
          ;
    EOT;
      $workTypeResult = pg_query($db_connection, $workTypeQuery);
    }

  ?>

  </tbody>
  </table>
  <br>

  <table class="table-fill">
    <thead>
    <tr>
    <th class="text-left">In-time</th>
    <th class="text-left">Out-time</th>
    </tr>
    </thead>
    <tbody class="table-hover">

   
  <?php

    foreach ($inOutTimeArray as $value){
      $inTime = $value[0];
      $outTime = $value[1];
      echo "<tr><td class='text-left'>".$inTime."</td>
      <td class='text-left'>".$outTime."</td>
      </tr>";
      // echo $inTime."+".$outTime;
      $inOutQuery = <<<EOT
          INSERT INTO in_out_times (staff, date_of_shift, in_time, out_time)
          VALUES ('{$staffID}', '{$date}', '{$inTime}', '{$outTime}')
          ;
    EOT;
      $inOutResult = pg_query($db_connection, $inOutQuery);
    }



  ?>

  </tbody>
  </table>
  </div>


  <?php
        if ($totalHourResult) {
          echo "<form action='index.php' class= 'submit_another_container'method='post'><input name='name' value='{$_POST['selected-name']}' hidden><button  class='submit_another' type='submit'>Submit another</button><a href='/full-time-staff/view-hours'><button  class='view_hours' type='button'>View my hours</button></a></form>";
        }if ($_POST['send-email'] == 'true') {
          $currentDate = date('j-m-Y, g:iA');
          $emailBody = <<<EOT
      Automatic Message from DHS:
      
      Staff hours recorded by: {$_POST['selected-name']} 
      on {$currentDate}.
      
      Full time staff hours complete for pay period.
      
      EOT;
          $emailBody = wordwrap($emailBody, 70);
      
          $recipient = pg_fetch_array(pg_query($db_connection, "SELECT value FROM misc_data WHERE key LIKE 'staff_coordinator_email';"), 0, PGSQL_ASSOC)['value'];
          if (!$recipient) {
            echo "<p class='main-content-header'>No staff coordinator email found. Contact an administrator to change this.</p>";
          }
      
          $mail = mail($recipient, "Full Time Staff Hours Recorded", $emailBody, "From: no-reply@darkhorsescheduling.com");
          if ($mail) {
            echo "<p class='main-content-header'>Email sent successfully.</p>";
          } else {
            echo "<p class='main-content-header'>Email failed to send.</p>";
          }
        }
       else {
        }


?>

</div>


</body>

</html>
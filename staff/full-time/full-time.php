<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/static/added.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Full time</title>
</head>

<body style="background-color:#D0BDF4;min-width:1226px;background-image: url('hor.png')">

<header class="full-time-header">
    <p class="full-time-title">Full-time Staff Timesheet</p>
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

    echo $staffName;
    echo "<br>";

    echo $staffID;
    echo "<br>";


    echo $date;
    echo "<br>";
    
    echo $notes;
    echo "<br>";
    echo $totalHour." hrs";
    echo $inOutTimeRaw;

    $inOutTimeArray = explode("\"},{\"", trim($inOutTimeRaw, "[{\"}]"));
    $order1 = array("intime\":","\"","outtime:");
    $replace = '';
    foreach ($inOutTimeArray as &$line) {
      $line = explode(",", str_replace($order1, $replace, $line));
    }
    print_r($inOutTimeArray);

    echo "<br>";
    echo $workTypeHourRaw;
    
    echo "<br>";
    $workTypeHourArray = explode("},{\"", trim($workTypeHourRaw,"[{\"}]"));
    $order2 = array("worktype",":","\"","time");
    foreach ($workTypeHourArray as &$line) {
      $line = explode(",", str_replace($order2, $replace, $line));
    }

    echo count($order2);

    // for($x = 0; $x < count($order2),$x++){

    //   echo "wow";
    // }

    print_r($workTypeHourArray);

        // query to be implemented------------------
        $totalHourQuery = <<<EOT
          INSERT INTO full_total_hours (staff, date_of_shift, total_hour, notes)
          VALUES ('{$staffID}', '{$date}', '{$totalHour}', '{$notes}')
          ;
    EOT;

        $totalHourResult = pg_query($db_connection, $totalHourQuery);
        if ($totalHourResult) {
          echo "<div class='another_shift_title'>Hours recorded successfully.</div>";
          echo "<form class='submit_and_cancel' action='index.php' method='post'><input name='name' value='{$_POST['selected-name']}' hidden><button type='submit'>Submit another shift</button></form>";
          if ($_POST['send-email'] == 'true') {
            $currentDate = date('j-m-Y, g:iA');
            $emailBody = <<<EOT
    Automatic Message from DHS:

    Staff hours recorded by: {$_POST['selected-name']} 
    on {$currentDate}.

    Full time staff hours complete for pay period.

    Date: {$_POST['Date']}
    In and Out Time: {$inOutTime}
    Note: {$notes}
    EOT;
            $emailBody = wordwrap($emailBody, 70);

            $recipient = "guangc2@carleton.edu";
            // $recipient = pg_fetch_array(pg_query($db_connection, "SELECT value FROM misc_data WHERE key LIKE 'staff_coordinator_email';"), 0, PGSQL_ASSOC)['value'];
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
        } else {
          echo "<h3 class='main-content-header'>An error occurred.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
        }


?>


</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Hours complete</title>
</head>

<body>

  <header>
    <h1>Staff Timesheet</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    session_start();
    $staffName = $_SESSION['staffName'];
    $staffID = $_SESSION['staffID'];
    echo $staffName;
    echo $staffID;
    echo "here";
    date_default_timezone_set('America/Los_Angeles');
    $timezone = date_default_timezone_get();
    $date = date('m/d/Y h:i:s a', time());
    echo $date;

    $query = <<<EOT
      INSERT INTO staff_hours (staff, hours, work_type, date_of_hours, notes)
      VALUES ('{$staffID}', 0, NULL, '{$date}', 'Hours complete for pay period')
      ;
EOT;

    if ($_POST['send-email'] == 'true') {
        $result = pg_query($db_connection, $query);
        if ($result) {

            echo "hahaha";
            echo "<h3 class='main-content-header'>Hours completed successfully.</h3>";

            $currentDate = date('j-m-Y, g:iA');
            $emailBody = <<<EOT
Automatic Message from DHS:

Staff hours recorded by: {$staffName}

Hours complete for pay period.
EOT;
            $emailBody = wordwrap($emailBody, 70);

            $recipient = pg_fetch_array(pg_query($db_connection, "SELECT value FROM misc_data WHERE key LIKE 'staff_coordinator_email';"), 0, PGSQL_ASSOC)['value'];
            if (!$recipient) {
                echo "<p class='main-content-header'>No staff coordinator email found. Contact an administrator to change this.</p>";
            }

            $mail = mail($recipient, "Staff Hours Recorded", $emailBody, "From: no-reply@darkhorsescheduling.com");
            if ($mail) {
                echo "<p class='main-content-header'>Email sent successfully.</p>";
            } else {
                echo "<p class='main-content-header'>Email failed to send.</p>";
            }
        }
    }else{
        echo "<p class='main-content-header'>If you intended to select 'hours completed for the pay period', you failed to do so; if you are just viewing hours, welcome!</p>";
    }


  ?>


</body>

</html>

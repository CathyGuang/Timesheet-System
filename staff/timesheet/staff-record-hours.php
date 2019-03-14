<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Staff Timesheet</title>
</head>

<body>

  <header>
    <h1>Staff Timesheet</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php

    $staffID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$_POST['staff']}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];

    $notes = pg_escape_string(trim($_POST['notes']));

    $query = <<<EOT
      INSERT INTO staff_hours (staff, hours, work_type, date_of_hours, notes)
      VALUES ('{$staffID}', '{$_POST['hours']}', '{$_POST['work-type']}', '{$_POST['date-of-hours']}', '{$notes}')
      ;
EOT;

    $result = pg_query($db_connection, $query);
    if ($result) {
      echo "<h3 class='main-content-header'>Hours recorded successfully.</h3>";
      echo "<form class='main-form' action='index.php' method='post'><input name='name' value='{$_POST['staff']}' style='visibility: hidden;'><button type='submit'>Submit another shift</button></form>";
      if ($_POST['send-email'] == 'true') {
        $currentDate = date('j-m-Y, g:iA');
        $emailBody = <<<EOT
Automatic Message from DHS:

Staff hours recorded by: {$_POST['staff']}
on {$currentDate}

Shift: {$_POST['work-type']}
Date: {$_POST['date-of-hours']}
Hours: {$_POST['hours']}

Note: {$notes}
EOT;
        $emailBody = wordwrap($emailBody, 70);

        $recipient = pg_fetch_array(pg_query($db_connection, "SELECT value FROM misc_data WHERE key LIKE 'staff-coordinator-email';"), 0, PGSQL_ASSOC)['value'];
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
    } else {
      echo "<h3 class='main-content-header>An error occured.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
    }


  ?>


</body>

</html>

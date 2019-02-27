<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Record Volunteer Hours</title>
</head>

<body>

  <header>
    <h1>Volunteer Hours</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php

    $volunteerID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$_POST['volunteer']}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];

    $notes = pg_escape_string(trim($_POST['notes']));

    $query = <<<EOT
      INSERT INTO volunteer_hours (volunteer, hours, shift_type, date_of_hours, notes)
      VALUES ('{$volunteerID}', '{$_POST['hours']}', '{$_POST['shift-type']}', '{$_POST['date-of-hours']}', '{$notes}')
      ;
EOT;

    $result = pg_query($db_connection, $query);
    if ($result) {
      echo "<h3 class='main-content-header'>Success</h3>";
      if ($_POST['send-email'] == 'true') {
        echo "TRUEEUEUEUE";
        $currentDate = Date();
        $emailBody = <<<EOT
Automatic Message from DHS:

Volunteer hours recorded by: {$_POST['volunteer']}
at {$currentDate}

Shift: {$_POST['shift-type']}
Date: {$_POST['date-of-hours']}
Hours: {$_POST['hours']}

Note: {$notes}
EOT;
        $emailBody = wordwrap($emailBody, 70);
        mail("shinimaninima@gmail.com", "Volunteer Hours Recorded", $emailBody);
      }

    } else {
      echo "<h3 class='main-content-header>An error occured.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
    }


  ?>


</body>

</html>

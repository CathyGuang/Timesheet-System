<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/added.css">
<link rel="stylesheet" href="css/table.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>PTO/Holiday time</title>
</head>

<body style="background-color:#D0BDF4;min-width:1226px;background-image: url('hor.png')">

  <header class="full-time-header">
    <p class="full-time-title">Holiday Hours successfully submitted</p>
    <nav class="button-container"> 
      <a href="../"><button class="back-button">Back</button></a>
      <a href="/"><button class="home-button">Home</button></a>
    </nav>
    
  </header>

  <?php

    $staffName = pg_escape_string(trim($_POST['selected-name']));
    $staffID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$staffName}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];

    $date = $_POST['Date'];
    $type = $_POST['choice'];
    $hours = $_POST['quantity'];
    $notes = $_POST['notes'];

  ?>

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
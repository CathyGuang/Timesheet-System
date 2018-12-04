<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php INCLUDE $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/connectdb.php"; ?>
  <title>Staff Manage Classes</title>
</head>

<body>

  <header>
    <h1>Manage Classes</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    // PROCESS USER INPUT
    var_dump($_POST);
    if ($_POST['attendance']) {
      $attendance = "{" . implode(",", $_POST['attendance']) . "}";
    } else {
      $attendance = "{}";
    }

    $therapistID = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$_POST['therapist']}';"))[0];
    $esID = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$_POST['equine-specialist']}';"))[0];
    $leaderID = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$_POST['leader']}';"))[0];

    $sidewalkerIDPGArray = "{";
    foreach ($_POST['sidewalkers'] as $name) {
      $sidewalkerID = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$name}';"))[0];
      $sidewalkerIDPGArray .= $sidewalkerID . ",";
    }
    $sidewalkerIDPGArray = rtrim($sidewalkerIDPGArray, ",") . "}";


    // ADD TO DATABASE
    $query = <<<EOT
      UPDATE classes SET
      lesson_plan = '{$_POST['lesson-plan']}', horse_behavior = '{$_POST['horse-behavior']}', horse_behavior_notes = '{$_POST['horse-behavior-notes']}', attendance = '{$attendance}', client_notes = '{$_POST['client-notes']}', therapist = '{$therapistID}', equine_specialist = '{$esID}', leader = '{$leaderID}', sidewalkers = '{$sidewalkerIDPGArray}'
      WHERE id = {$_POST['id']};
EOT;

    $result = pg_query($db_connection, $query);

    if ($result) {
      echo "<h3 class='main-content-header'>Success</h3";
    } else {
      echo "<h3 class='main-content-header>An error occured.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
    }
  ?>

</body>

</html>

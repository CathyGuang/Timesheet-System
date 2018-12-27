<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php INCLUDE $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Staff Manage Classes</title>
</head>

<body>

  <header>
    <h1>Manage Classes</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    // PROCESS USER INPUT
    if ($_POST['attendance']) {
      $attendance = "{" . implode(",", $_POST['attendance']) . "}";
    } else {
      $attendance = "{}";
    }

    $staffJSON = "{";
    foreach ($staffIDList as $key => $staffID) {
      $staffJSON .= "\"{$_POST['staff-roles'][$key]}\": {$staffID},";
    }
    $staffJSON = rtrim($staffJSON, ',') . "}";

    $leaderIDPGArray = "{";
    foreach ($_POST['leaders'] as $name) {
      $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$name}' AND (archived IS NULL OR archived = '');"))[0];
      $leaderIDPGArray .= $id . ",";
    }
    $leaderIDPGArray = rtrim($leaderIDPGArray, ",") . "}";

    $sidewalkerIDPGArray = "{";
    foreach ($_POST['sidewalkers'] as $name) {
      $sidewalkerID = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$name}' AND (archived IS NULL OR archived = '');"))[0];
      $sidewalkerIDPGArray .= $sidewalkerID . ",";
    }
    $sidewalkerIDPGArray = rtrim($sidewalkerIDPGArray, ",") . "}";

    if ($_POST['cancel'] == "TRUE") {
      $cancel = 'TRUE';
    } else {
      $cancel = 'FALSE';
    }


    // ADD TO DATABASE
    $query = <<<EOT
      UPDATE classes SET
      lesson_plan = '{$_POST['lesson-plan']}', cancelled = '{$cancel}', horse_behavior = '{$_POST['horse-behavior']}', horse_behavior_notes = '{$_POST['horse-behavior-notes']}', attendance = '{$attendance}', client_notes = '{$_POST['client-notes']}', therapist = '{$therapistID}', equine_specialist = '{$esID}', leaders = '{$leaderIDPGArray}', sidewalkers = '{$sidewalkerIDPGArray}'
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php INCLUDE $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Staff Manage Classes</title>
</head>

<body>

  <header>
    <h1>Manage Classes</h1>
    <nav> <button id="back-button" onclick="window.history.go(-2);">Back</button>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    // PROCESS USER INPUT

    # Get date and time
    $dateOfClass = $_POST['date-of-class'];
    $startTime = $_POST['start-time'];
    $endTime = $_POST['end-time'];

    $classType = $_POST['class-type'];
    $displayTitle = pg_escape_string($_POST['display-title']);



    $horseIDList = array();
    foreach ($_POST['horses'] as $name) {
      $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM horses WHERE name LIKE '{$name}' AND (archived IS NULL OR archived = '');"))[0];
      $horseIDList[] = $id;
      $horseIDPGList = to_pg_array($horseIDList);
    }

    $clientIDList = array();
    foreach ($_POST['clients'] as $name) {
      $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM clients WHERE name LIKE '{$name}' AND (archived IS NULL OR archived = '');"))[0];
      $clientIDList[] = $id;
      $clientIDPGList = to_pg_array($clientIDList);
    }

    $attendance = array();
    foreach ($clientIDList as $index => $id) {
      if (in_array($index, $_POST['attendance'])) {
        $attendance[] = $id;
      }
    }
    $attendance = to_pg_array($attendance);

    $staffIDList = array();
    foreach ($_POST['staff'] as $name) {
      $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$name}' AND (archived IS NULL OR archived = '');"))[0];
      $staffIDList[] = $id;
    }
    $staffJSON = "{";
    foreach ($staffIDList as $key => $staffID) {
      if ($staffID == 1) {continue;}
      $staffJSON .= "\"{$_POST['staff-roles'][$key]}\": {$staffID},";
    }
    $staffJSON = rtrim($staffJSON, ',') . "}";

    $volunteerIDList = array();
    foreach ($_POST['volunteers'] as $name) {
      $id = pg_fetch_row(pg_query($db_connection, "SELECT id FROM workers WHERE name LIKE '{$name}' AND (archived IS NULL OR archived = '');"))[0];
      $volunteerIDList[] = $id;
    }
    $volunteerJSON = "{";
    foreach ($volunteerIDList as $key => $volunteerID) {
      if ($volunteerID == 1) {continue;}
      $volunteerJSON .= "\"{$_POST['volunteer-roles'][$key]}\": {$volunteerID},";
    }
    $volunteerJSON = rtrim($volunteerJSON, ',') . "}";

    if ($_POST['cancel'] == "TRUE") {
      $cancel = 'TRUE';
    } else {
      $cancel = 'FALSE';
    }


    // Other simple fields
    $arena = $_POST['arena'];


    // Escape user input strings for postgres
    $escapedLessonPlan = pg_escape_string($_POST['lesson-plan']);
    $escapedHorseBehaviorNotes = pg_escape_string($_POST['horse-behavior-notes']);
    $escapedClientNotes = pg_escape_string($_POST['client-notes']);
    $tackList = pg_escape_string(to_pg_array($_POST['tacks']));
    $padList = pg_escape_string(to_pg_array($_POST['pads']));

    //Notes
    $SQLData = prepTackNotesForSQL();
    $tackNotes = $SQLData[0];
    $clientEquipmentNotes = $SQLData[1];



    // Check for conflicts unless class is being cancelled
    if ($cancel == "FALSE") {
      //archive class temporarily
      pg_query($db_connection, "UPDATE classes SET archived = 'true' WHERE classes.id = {$_POST['id']};");

      #$classTimeData = pg_fetch_row(pg_query($db_connection, "SELECT date_of_class, start_time, end_time FROM classes WHERE classes.id = '{$_POST['id']}';"), 0);
      $classTimeData = array($dateOfClass, $startTime, $endTime);
      $dateTimeTriplets = array($classTimeData[0]=>[$classTimeData[1], $classTimeData[2]]);
      $convertedData = array($horseIDList, $clientIDList, $staffIDList, $volunteerIDList);
      $abort = checkForConflicts($dateTimeTriplets, $convertedData);

      //unarchive class
      pg_query($db_connection, "UPDATE classes SET archived = NULL WHERE classes.id = {$_POST['id']};");

      if ($abort) {
        $postString = base64_encode(serialize($_POST));
        echo "<h3 class='main-content-header'>The database has not been changed. Please <button style='width: 90pt;' onclick='window.history.back()'>try again</button></h3>";

        echo "<h3 class='main-content-header'>Override:</h3><p class='main-content-header'><button form='override-form' type='submit' style='width: 110pt;'>OVERRIDE</button> conflicts if you are sure.</p>";
        echo "<form id='override-form' method='post' action='manage-class-override.php'><input name='override-post' value='{$postString}' hidden></form>";
        return;
      }
    }


    // ADD TO DATABASE
    $query = <<<EOT
      UPDATE classes SET
      date_of_class = '{$dateOfClass}',
      start_time = '{$startTime}',
      end_time = '{$endTime}',
      class_type = '{$classType}',
      display_title = '{$displayTitle}',
      lesson_plan = '{$escapedLessonPlan}',
      cancelled = '{$cancel}',
      arena = '{$arena}',
      horses = '{$horseIDPGList}',
      tacks = '{$tackList}',
      pads = '{$padList}',
      tack_notes = '{$tackNotes}',
      client_equipment_notes = '{$clientEquipmentNotes}',
      clients = '{$clientIDPGList}',
      horse_behavior = '{$_POST['horse-behavior']}',
      horse_behavior_notes = '{$escapedHorseBehaviorNotes}',
      attendance = '{$attendance}',
      client_notes = '{$escapedClientNotes}',
      staff = '{$staffJSON}',
      volunteers = '{$volunteerJSON}'
      WHERE id = {$_POST['id']};
EOT;

    $result = pg_query($db_connection, $query);

    if ($result) {
      echo "<h3 class='main-content-header'>Success</h3";
    } else {
      echo "<h3 class='main-content-header'>An error occurred.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
    }
  ?>

</body>

</html>

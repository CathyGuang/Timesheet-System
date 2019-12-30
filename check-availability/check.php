<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Check Availability</title>
</head>

<body>

  <header>
    <h1>Check Availability</h1>
    <nav>
      <a href="index.php"><button>Check Another</button></a>
      <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>



    <?php

      if (in_array($_POST['target-name'], pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM workers WHERE (archived IS NULL OR archived = '');")))) {
        $target = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE name = '{$_POST['target-name']}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];
        $targetType = "workers";
      }

      if (in_array($_POST['target-name'], pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM horses WHERE (archived IS NULL OR archived = '');")))) {
        $target = pg_fetch_array(pg_query($db_connection, "SELECT id FROM horses WHERE name = '{$_POST['target-name']}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];
        $targetType = "horses";
      }

      if (in_array($_POST['target-name'], pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::ARENA))")))) {
        $target = $_POST['target-name'];
        $targetType = "arena";
      }

      if (in_array($_POST['target-name'], pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::TACK))")))) {
        $target = $_POST['target-name'];
        $targetType = "tack";
      }

      if (in_array($_POST['target-name'], pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::PAD))")))) {
        $target = $_POST['target-name'];
        $targetType = "pad";
      }

      //initialize checkAvailability function
      include $_SERVER['DOCUMENT_ROOT']."/static/scripts/checkAvailability.php";
      //initialize check horse use by week function
      include $_SERVER['DOCUMENT_ROOT']."/static/scripts/getHorseUsesByDateRange.php";

      $result = checkAvailability($target, $targetType, $_POST['target-date'], $_POST['start-time'], $_POST['end-time']);
      if (!$result) {
        echo "<br><h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-green);'>{$_POST['target-name']} is available on {$_POST['target-date']} from {$_POST['start-time']} to {$_POST['end-time']}.</h3>";
      } else if (is_array($result)) {
        echo "<br><h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red);'>{$_POST['target-name']} is NOT available, there is an event from {$result[0]} to {$result[1]} on {$_POST['target-date']}.</p>";
      } else {
        echo "<br><h3 class='main-content-header' style='font-size: 25pt; color: var(--dark-red);'>{$result}</p>";
      }
    ?>



</body>

</html>

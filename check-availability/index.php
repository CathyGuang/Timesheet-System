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
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <h3 class="main-content-header">Search for anything to check its availability!</h3>

  <div class="main-content-div">

    <form autocomplete="off" action="check.php" method="post" class="standard-form standard-form">
      <p>Select any person/arena/resource:</p>
      <input type="text" name="target-name" list="all-objects-list" required>
        <datalist id="all-objects-list">
          <?php
            $allResources = array();
            $allResources = array_merge($allResources, pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM workers WHERE (archived IS NULL OR archived = '');")));
            $allResources = array_merge($allResources, pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM horses WHERE (archived IS NULL OR archived = '');")));
            $allResources = array_merge($allResources, pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::ARENA))")));
            $allResources = array_merge($allResources, pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::TACK))")));
            $allResources = array_merge($allResources, pg_fetch_all_columns(pg_query($db_connection, "SELECT unnest(enum_range(NULL::PAD))")));

            foreach ($allResources as $key => $name) {
              $name = htmlspecialchars($name, ENT_QUOTES);
              echo "<option value='$name'>";
            }
          ?>
        </datalist>

      <p>Select date to check:</p>
      <input type="date" name="target-date" value="<?php echo date('Y-m-d'); ?>" required>

      <div>
        <label for="start-time">from:</label>
        <input type="time" id="start-time" name="start-time" value="<?php echo date('h:i') ?>" required>
        <label for="end-time">to:</label>
        <input type="time" id="end-time" name="end-time" value="<?php echo date('h:i', strtotime('+1 hour')) ?>" required>
      </div>

      <input type="submit" value="Check Availability">
    </form>

  </div>


</body>

</html>

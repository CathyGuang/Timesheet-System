<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>View Volunteer Hours</title>
</head>

<body>

  <header>
    <h1>Volunteer Hours</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>



    <form autocomplete="off" class="main-form" action="view-hours.php" method="post">

      <p>Name:</p>
      <input type="text" name="volunteer" list="volunteer-list" required>
        <datalist id="volunteer-list">
          <?php
            $volunteerNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM workers WHERE volunteer = TRUE AND (archived IS NULL OR archived = '');"));
            foreach ($volunteerNames as $name) {
              echo "<option value='{$name}'>";
            }
          ?>
        </datalist>


      <p>Start Date:</p>
      <input type="date" name="start-date" value=">" required>

      <p>End Date:</p>
      <input type="date" name="end-date" value="<?php echo date('Y-m-d'); ?>" required>

      <br><br>
      <input type="submit" value="Submit">
    </form>


</body>

</html>

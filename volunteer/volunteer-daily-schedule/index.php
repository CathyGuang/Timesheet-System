<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/connectdb.php";?>
  <title>Volunteer Daily Schedule</title>
</head>

<body>

  <header>
    <h1>Volunteer Daily Schedule</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">

    <form action="schedule.php" method="post" class="main-form">
      <p>Select your name:</p>
      <input name="selected-name" list="volunteers">
      <datalist id="volunteers">
        <?php
          $volunteerNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM workers WHERE volunteer = TRUE;"));
          foreach ($volunteerNames as $name) {
            echo "<option value='$name'>";
          }
        ?>
      </datalist>
      <input type="date" name="selected-date" value="<?php echo date('Y-m-d') ?>">

      <input type="submit" value="Search">
    </form>

  </div>


</body>

</html>

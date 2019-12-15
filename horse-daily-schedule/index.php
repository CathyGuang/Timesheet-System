<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Horse Daily Schedule</title>
</head>

<body>

  <header>
    <h1>Horse Daily Schedule</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">

    <form autocomplete="off" action="schedule.php" method="post" class="standard-form standard-form">
      <p>Select horse's name:</p>
      <input name="selected-name" list="horses">
      <datalist id="horses">
        <?php
          $horseNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM horses WHERE (archived IS NULL OR archived = '');"));
          foreach ($horseNames as $name) {
            $name = htmlspecialchars($name, ENT_QUOTES);
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

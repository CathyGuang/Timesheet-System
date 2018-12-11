<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/connectdb.php";?>
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

    <form action="schedule.php" method="post" class="main-form small-form">
      <p>Select horse's name:</p>
      <input name="selected-name" list="horses">
      <datalist id="horses">
        <?php
          $horseNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM horses WHERE (archived IS NULL OR archived = '');"));
          foreach ($horseNames as $name) {
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

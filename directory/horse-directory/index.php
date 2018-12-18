<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/connectdb.php"; ?>
  <title>Horse Directory | Forward Stride Web Portal</title>
</head>

<body>

  <header>
    <h1>Horse Directory</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <form action="horse-directory.php" method="post" class="main-form">
    <?php
      $query = "SELECT * FROM horses WHERE name != '' AND name != 'HORSE NEEDED' AND (archived IS NULL OR archived = '');";
      $allHorses = pg_fetch_all(pg_query($db_connection, $query));

      foreach ($allHorses as $horse) {
        echo "<button type='submit' name='buttonInfo' value='{$horse['id']}'>{$horse['name']}</button>";
      }
    ?>

  </form>

</body>

</html>

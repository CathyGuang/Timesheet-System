<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Horse Directory | <?php echo $organizationName; ?> Web Portal</title>
</head>

<body>

  <header>
    <h1>Horse Directory</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <form autocomplete="off" action="horse-directory.php" method="post" class="main-form">
    <?php
      $query = "SELECT * FROM horses WHERE name != '' AND name != 'HORSE NEEDED' AND (archived IS NULL OR archived = '');";
      $horseData = pg_fetch_all(pg_query($db_connection, $query));
      $allHorses = array();
      foreach ($horseData as $key => $data) {
        $allHorses[$data['id']] = $data['name'];
      }
      var_dump($allHorses);
      asort($allHorses);
      var_dump($allHorses);

      foreach ($allHorses as $horse) {
        echo "<button type='submit' name='buttonInfo' value='{$horse['id']}'>{$horse['name']}</button>";
      }
    ?>

  </form>

</body>

</html>

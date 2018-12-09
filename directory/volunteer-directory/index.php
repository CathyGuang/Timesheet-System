<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/connectdb.php"; ?>
  <title>Volunteer Directory | Forward Stride Web Portal</title>
</head>

<body>

  <header>
    <h1>Volunteer Directory</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <form action="volunteer-directory.php" method="post" class="main-form">
    <?php
      $query = "SELECT * FROM workers WHERE volunteer = TRUE AND (archived IS NULL OR archived = '');";
      $allPeople = pg_fetch_all(pg_query($db_connection, $query));

      foreach ($allPeople as $person) {
        echo "<button type='submit' name='buttonInfo' value='{$person['id']}'>{$person['name']}<br><i>{$person['title']}</i></button>";
      }
    ?>

  </form>

</body>

</html>

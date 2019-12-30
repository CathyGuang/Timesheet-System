<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Staff Directory | <?php echo $organizationName; ?> Web Portal</title>
</head>

<body>

  <header>
    <h1>Staff Directory</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <form autocomplete="off" action="staff-directory.php" method="post" class="standard-form">
    <?php
      $query = "SELECT * FROM workers WHERE staff = TRUE AND (archived IS NULL OR archived = '') ORDER BY name;";
      $allPeople = pg_fetch_all(pg_query($db_connection, $query));

      foreach ($allPeople as $person) {
        echo "<button class='directory-button' type='submit' name='buttonInfo' value='{$person['id']}'>{$person['name']}<br><i>{$person['title']}</i></button>";
      }
    ?>

  </form>

</body>

</html>

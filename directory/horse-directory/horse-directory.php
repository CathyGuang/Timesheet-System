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
    <nav> <a href="index.php"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">
    <form autocomplete="off" class="main-content-form" style="width: 500px;">
      <?php
        $query = "SELECT * FROM horses WHERE id = {$_POST['buttonInfo']};";
        $horseInfo = pg_fetch_all(pg_query($db_connection, $query))[0];

        echo <<<EOT
          <p>Name: {$horseInfo['name']}</p>
          <p>Owner: {$horseInfo['owner']}</p>
          <p>Owner email address: {$horseInfo['owner_email']}</p>
          <p>Organization Uses per Day: {$horseInfo['org_uses_per_day']}</p>
          <p>Owner Uses per Day: {$horseInfo['owner_uses_per_day']}</p>
          <p>Notes: {$horseInfo['notes']}</p>
EOT;

      ?>
    </form>
  </div>

</body>

</html>

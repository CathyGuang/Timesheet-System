<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php INCLUDE $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Staff Manage Classes</title>
</head>

<body>

  <header>
    <h1>Manage Classes</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    // PROCESS USER INPUT
    if ($_POST['attendance']) {
      $attendance = "{" . implode(",", $_POST['attendance']) . "}";
    } else {
      $attendance = "{}";
    }

    // Escape user input for postgres
    $escapedHorseBehaviorNotes = pg_escape_string($_POST['horse-behavior-notes']);


    // ADD TO DATABASE
    $query = <<<EOT
      UPDATE classes SET
      horse_behavior = '{$_POST['horse-behavior']}', horse_behavior_notes = '{$escapedHorseBehaviorNotes}', attendance = '{$attendance}'
      WHERE id = {$_POST['id']};
EOT;

    $result = pg_query($db_connection, $query);

    if ($result) {
      echo "<h3 class='main-content-header'>Success</h3";
    } else {
      echo "<h3 class='main-content-header'>An error occurred.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
    }
  ?>

</body>

</html>

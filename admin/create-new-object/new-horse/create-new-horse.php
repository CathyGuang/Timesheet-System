<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | New Horse</title>
</head>

<body>

  <header>
    <h1>New Horse</h1>
    <nav>
      <a href="index.php"><button>Create Another</button></a>
      <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <?php
    $name = pg_escape_string(trim($_POST['name']));
    $owner = pg_escape_string(trim($_POST['owner']));
    $notes = pg_escape_string(trim($_POST['notes']));

    $query = "INSERT INTO horses(name, owner, org_uses_per_day, owner_uses_per_day, horse_uses_per_week, notes) VALUES ('{$name}', '{$owner}', '{$_POST['org_uses_per_day']}', '{$_POST['owner_uses_per_day']}', '{$_POST['horse_uses_per_week']}', '{$notes}');";

    $result = pg_query($db_connection, $query);

    if ($result) {
      echo "<h3 class='main-content-header'>Success</h3";
    } else {
      echo "<h3 class='main-content-header'>An error occurred.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
    }
  ?>




</body>

</html>

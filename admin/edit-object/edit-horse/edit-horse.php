<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | Edit Horse</title>
</head>

<body>

  <header>
    <h1>Edit Horse</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <?php
    if ($_POST['archive']) {$archived = "TRUE";} else {$archived = "";}
    $name = trim($_POST['name']);
    $owner = trim($_POST['name']);
    $notes = trim($_POST['notes']);

    $query = "UPDATE horses SET name = '{$name}', owner = '{$owner}', org_uses_per_day = '{$_POST['org_uses_per_day']}', owner_uses_per_day = '{$_POST['owner_uses_per_day']}', notes = '{$notes}', archived = '{$archived}' WHERE id = {$_POST['id']};";

    $result = pg_query($db_connection, $query);

    if ($result) {
      echo "<h3 class='main-content-header'>Success</h3";
    } else {
      echo "<h3 class='main-content-header>An error occured.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
    }
  ?>




</body>

</html>

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
    //Delete horse if delete requested:
    if ($_POST['delete']) {
      $query = "DELETE FROM horses WHERE id = {$_POST['id']};";
      $result = pg_query($db_connection, $query);
      if ($result) {
        echo "<h3 class='main-content-header'>Success</h3";
      } else {
        echo "<h3 class='main-content-header'>An error occurred.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
      }
      return;
    }

    //Edit the horse
    if ($_POST['archive']) {$archived = "TRUE";} else {$archived = "";}
    $name = pg_escape_string(trim($_POST['name']));
    $owner = pg_escape_string(trim($_POST['owner']));
    $owner_email = pg_escape_string(trim($_POST['owner-email']));
    $notes = pg_escape_string(trim($_POST['notes']));

    $query = "UPDATE horses SET name = '{$name}', owner = '{$owner}', owner_email = '{$owner_email}', org_uses_per_day = '{$_POST['org_uses_per_day']}', owner_uses_per_day = '{$_POST['owner_uses_per_day']}', horse_uses_per_week = '{$_POST['horse_uses_per_week']}', notes = '{$notes}', archived = '{$archived}' WHERE id = {$_POST['id']};";

    $result = pg_query($db_connection, $query);

    if ($result) {
      echo "<h3 class='main-content-header'>Success</h3";
    } else {
      echo "<h3 class='main-content-header'>An error occurred.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
    }
  ?>




</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | New Misc. Object</title>
</head>

<body>

  <header>
    <h1>New Object</h1>
    <nav>
      <a href="index.php"><button>Create Another</button></a>
      <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    $objectName = trim($_POST['new-object-name']);
    $query = "ALTER TYPE {$_POST['object-type']} ADD VALUE '{$objectName}';";

    $result = pg_query($db_connection, $query);

    if ($result) {
      echo "<h3 class='main-content-header'>Success</h3";
    } else {
      echo "<h3 class='main-content-header>An error occured.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
    }
  ?>


</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | Edit Worker</title>
</head>

<body>

  <header>
    <h1>Edit Worker</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <?php
    $staffbool = 'FALSE';
    $volunteerbool = 'FALSE';
    if ($_POST['staff']) {
      $staffbool = 'TRUE';
    }
    if ($_POST['volunteer']) {
      $volunteerbool = 'TRUE';
    }

    if ($_POST['archive']) {$archived = "TRUE";} else {$archived = "";}
    $name = pg_escape_string(trim($_POST['name']));
    $title = pg_escape_string(trim($_POST['title']));
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $query = "UPDATE workers SET NAME = '{$name}', title = '{$title}', email = '{$email}', phone = '{$phone}', staff = $staffbool, volunteer = $volunteerbool, archived = '{$archived}' WHERE id = {$_POST['id']};";

    $result = pg_query($db_connection, $query);

    if ($result) {
      echo "<h3 class='main-content-header'>Success</h3";
    } else {
      echo "<h3 class='main-content-header>An error occured.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
    }
  ?>




</body>

</html>

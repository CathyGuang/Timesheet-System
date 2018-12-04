<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php INCLUDE $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/connectdb.php"; ?>
  <title>Staff Manage Classes</title>
</head>

<body>

  <header>
    <h1>Manage Classes</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    echo "<b>_POST</b><br>";
    var_dump($_POST);
    $classID = explode(';', $_POST['buttonInfo'])[0];
    $clientString = explode(';', $_POST['buttonInfo'])[1];

    $getClassInfoQuery = "SELECT class_type, date_of_class, lesson_plan, horse, horse_behavior, clients, attendance, client_notes, therapist, equine_specialist, leader, sidewalkers FROM classes WHERE id = {$classID}";
    $classInfo = pg_fetch_all(pg_query($db_connection, $getClassInfoQuery))[0];

    echo "<br><b>classInfo</b><br>";
    var_dump($classInfo);
    echo "<br>";

    echo "<h3 class='main-content-header'>{$classInfo['class_type']}, {$clientString} {$classInfo['date_of_class']}</h3>";
  ?>

  <form action="manage-class-back-end.php" method="post" class="main-form">



    <input type="submit" value="Submit">
  </form>


</body>

</html>

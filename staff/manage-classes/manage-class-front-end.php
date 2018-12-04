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

    <p>Lesson Plan:</p>
    <textarea name="lesson-plan" rows="15" cols="30">
      <?php
        echo $classInfo['lesson_plan'];
      ?>
    </textarea>

    <?php $horseName = pg_fetch_row(pg_query($db_connection, "SELECT name FROM horses WHERE id = '{$classInfo['horse']}'"))[0]; ?>
    <p>Horse:</p>
    <input type="text" list="horse-list" value="<?php echo $horseName?>" onclick="select()">
      <datalist id="horse-list">
        <?php
          $query = "SELECT name FROM horses;";
          $result = pg_query($db_connection, $query);
          $horseNames = pg_fetch_all_columns($result);
          foreach ($horseNames as $key => $value) {
            echo "<option value='$value'>";
          }
        ?>
      </datalist>

      <p>Horse Behavior:</p>
      <textarea name="horse-behavior" rows="10" cols="30">
        <?php
          echo $classInfo['horse_behavior'];
        ?>
      </textarea>

      <p>Attendance:</p>
      <?php
        $clientIDList = explode(',', rtrim(ltrim($classInfo['clients'], '{'), '}'));
        $clientNameList = explode(',', $clientString);
        foreach ($clientIDList as $index => $id) {
          echo <<<EOT
          <div>
            <label>{$clientNameList[$index]}</label>
            <input type="checkbox" name="attendance[]" value="$id" style="position: absolute; margin-left: 15px;">
          </div>
EOT;
        }
      ?>


    <br><br>
    <input type="submit" value="Submit">
  </form>


</body>

</html>

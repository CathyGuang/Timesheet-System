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

    $getClassInfoQuery = "SELECT class_type, date_of_class, lesson_plan, horse, horse_behavior, horse_behavior_notes, clients, attendance, client_notes, therapist, equine_specialist, leader, sidewalkers FROM classes WHERE id = {$classID}";
    $classInfo = pg_fetch_all(pg_query($db_connection, $getClassInfoQuery))[0];
    echo "<h3 class='main-content-header'>{$classInfo['class_type']}, {$clientString} {$classInfo['date_of_class']}</h3>";
  ?>

  <form action="manage-class-back-end.php" method="post" class="main-form">

    <input type="text" name="id" value="<?php echo $classID ?>" style="visibility: hidden; height: 1px;">

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
      <input type="text" name="horse-behavior" list="horse-behavior-form" value="">
        <datalist id="horse-behavior-form">
          <?php
            $query = "SELECT unnest(enum_range(NULL::HORSE_BEHAVIOR))";
            $result = pg_query($db_connection, $query);
            $behaviorNames = pg_fetch_all_columns($result);
            foreach ($behaviorNames as $key => $value) {
              echo "<option value='$value'>";
            }
          ?>
        </datalist>

      <br>
      <p>Horse Behavior Notes:</p>
      <textarea name="horse-behavior-notes" rows="10" cols="30">
        <?php
          echo $classInfo['horse_behavior_notes'];
        ?>
      </textarea>

      <p>Attendance:</p>
      <?php
        $clientIDList = explode(',', rtrim(ltrim($classInfo['clients'], '{'), '}'));
        $clientNameList = explode(',', $clientString);
        $clientAttendanceList = explode(',', rtrim(ltrim($classInfo['attendance'], '{'), '}'));
        foreach ($clientIDList as $index => $id) {
          $checked = "";
          if (in_array($id, $clientAttendanceList)) {
            $checked = "checked";
          }
          echo <<<EOT
          <div>
            <label>{$clientNameList[$index]}</label>
            <input type="checkbox" name="attendance[]" value="$id" style="position: absolute; margin-left: 15px;" {$checked}>
          </div>
EOT;
        }
      ?>

      <p>Client Notes:</p>
      <textarea name="client-notes" rows="10" cols="30">
        <?php
          echo $classInfo['client_notes'];
        ?>
      </textarea>

      <?php $therapistName = pg_fetch_row(pg_query($db_connection, "SELECT name FROM workers WHERE id = '{$classInfo['therapist']}'"))[0]; ?>
      <p>Therapist:</p>
      <input type="text" list="therapist-list" name="therapist" value="<?php echo $therapistName?>" onclick="select()">
        <datalist id="therapist-list">
          <?php
            $query = "SELECT name FROM workers;";
            $result = pg_query($db_connection, $query);
            $workerNames = pg_fetch_all_columns($result);
            foreach ($workerNames as $key => $name) {
              echo "<option value='$name'>";
            }
          ?>
        </datalist>

        <?php $equineSpecialistName = pg_fetch_row(pg_query($db_connection, "SELECT name FROM workers WHERE id = '{$classInfo['equine_specialist']}'"))[0]; ?>
        <p>Equine Specialist:</p>
        <input type="text" list="equine-specialist-list" name="equine-specialist" value="<?php echo $equineSpecialistName?>" onclick="select()">
          <datalist id="equine-specialist-list">
            <?php
              $query = "SELECT name FROM workers;";
              $result = pg_query($db_connection, $query);
              $workerNames = pg_fetch_all_columns($result);
              foreach ($workerNames as $key => $name) {
                echo "<option value='$name'>";
              }
            ?>
          </datalist>

          <?php $leaderName = pg_fetch_row(pg_query($db_connection, "SELECT name FROM workers WHERE id = '{$classInfo['leader']}'"))[0]; ?>
          <p>Leader:</p>
          <input type="text" list="leader-list" name="leader" value="<?php echo $leaderName?>" onclick="select()">
            <datalist id="leader-list">
              <?php
                $query = "SELECT name FROM workers;";
                $result = pg_query($db_connection, $query);
                $workerNames = pg_fetch_all_columns($result);
                foreach ($workerNames as $key => $name) {
                  echo "<option value='$name'>";
                }
              ?>
            </datalist>

          <p>Sidewalkers:</p>
            <datalist id="sidewalker-list">
              <?php
                $query = "SELECT name FROM workers;";
                $result = pg_query($db_connection, $query);
                $workerNames = pg_fetch_all_columns($result);
                foreach ($workerNames as $key => $name) {
                  echo "<option value='$name'>";
                }
              ?>
            </datalist>
          <?php
            $sidewalkerIDList = explode(',', rtrim(ltrim($classInfo['sidewalkers'], "{"), "}"));
            foreach ($sidewalkerIDList as $index => $id) {
              $name = pg_fetch_row(pg_query($db_connection, "SELECT name FROM workers WHERE id = '{$id}'"))[0];
              echo "<input type='text' name='sidewalkers[]' list='sidewalker-list' value='{$name}'>";
            }
          ?>
          <br>



    <br><br>
    <input type="submit" value="Submit">
  </form>


</body>

</html>

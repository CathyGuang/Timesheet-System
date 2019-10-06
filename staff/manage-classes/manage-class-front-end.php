<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php INCLUDE $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Staff Manage Classes</title>
</head>

<body>

  <header>
    <h1>Manage Classes</h1>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/includes/nav.php"?>
  </header>

  <?php
    $classID = explode(';', $_GET['buttonInfo'])[0];
    $clientString = explode(';', $_GET['buttonInfo'])[1];

    $getClassInfoQuery = "SELECT display_title, class_type, cancelled, date_of_class, lesson_plan, horses, horse_behavior, horse_behavior_notes, clients, attendance, client_notes, staff, volunteers FROM classes WHERE id = {$classID}";
    $classInfo = pg_fetch_all(pg_query($db_connection, $getClassInfoQuery))[0];
    echo "<h3 class='main-content-header'>{$classInfo['display_title']}, {$classInfo['date_of_class']}</h3>";
  ?>

  <form autocomplete="off" action="manage-class-back-end.php" method="post" class="main-form">

    <input type="text" name="id" value="<?php echo $classID ?>" style="visibility: hidden; height: 1px;">

    <p>Lesson Plan:</p>
    <textarea name="lesson-plan" rows="8" cols="30">
      <?php
        echo trim($classInfo['lesson_plan']);
      ?>
    </textarea>

    <?php $horseNameList = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM horses WHERE id = ANY('{$classInfo['horses']}');")); ?>
    <p>Horse(s):</p>
    <?php
      foreach ($horseNameList as $name) {
        $name = htmlspecialchars($name, ENT_QUOTES);
        echo "<input type='text' list='horse-list' name='horses[]' value='{$name}' onclick='select()'>";
      }
    ?>
      <datalist id="horse-list">
        <?php
          $query = "SELECT name FROM horses WHERE (archived IS NULL OR archived = '');";
          $result = pg_query($db_connection, $query);
          $horseNames = pg_fetch_all_columns($result);
          foreach ($horseNames as $key => $value) {
            $value = htmlspecialchars($value, ENT_QUOTES);
echo "<option value='$value'>";
          }
        ?>
      </datalist>

      <p>Horse Behavior:</p>
      <input type="text" name="horse-behavior" list="horse-behavior-enum" value="<?php echo $classInfo['horse_behavior']; ?>">
        <datalist id="horse-behavior-enum">
          <?php
            $query = "SELECT unnest(enum_range(NULL::HORSE_BEHAVIOR))::text EXCEPT SELECT name FROM archived_enums;";
            $result = pg_query($db_connection, $query);
            $behaviorNames = pg_fetch_all_columns($result);
            foreach ($behaviorNames as $key => $value) {
              $value = htmlspecialchars($value, ENT_QUOTES);
echo "<option value='$value'>";
            }
          ?>
        </datalist>

      <br><br>
      <p>Horse Behavior Notes:</p>
      <textarea name="horse-behavior-notes" rows="8" cols="30">
        <?php
          echo trim($classInfo['horse_behavior_notes']);
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
            <input type='text' list='client-list' name='clients[]' value='{$clientNameList[$index]}' onclick='select()'>
            <input type="checkbox" name="attendance[]" value="$index" style="position: absolute; margin-left: 15px;" {$checked}>
          </div>
EOT;
        }
      ?>
      <datalist id="client-list">
        <?php
          $query = "SELECT name FROM clients WHERE (archived IS NULL OR archived = '');";
          $result = pg_query($db_connection, $query);
          $clientNames = pg_fetch_all_columns($result);
          foreach ($clientNames as $key => $value) {
            $value = htmlspecialchars($value, ENT_QUOTES);
            echo "<option value='$value'>";
          }
        ?>
      </datalist>


      <p>Client Notes:</p>
      <textarea name="client-notes" rows="10" cols="30">
        <?php
          echo $classInfo['client_notes'];
        ?>
      </textarea>
      <br>

      <?php
        $rawArray = explode(",", ltrim(rtrim($classInfo['staff'], '}'), '{'));
        $classInfo['staff'] = array();
        foreach ($rawArray as $roleIDString) {
          $roleIDString = trim($roleIDString);
          $role = rtrim(ltrim(explode(':', $roleIDString)[0], '"'), '"');
          $staffID = trim(explode(':', $roleIDString)[1]);
          $classInfo['staff'][$role] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = {$staffID} ;"))['name'];
        }

        foreach ($classInfo['staff'] as $role => $name) {
          $name = htmlspecialchars($name, ENT_QUOTES);

          echo <<<EOT
          <p>{$role}:</p>
          <input type="text" name="staff[]" list="staff-list" value="{$name}" onclick="select()">
          <input type="text" name="staff-roles[]" value="{$role}" style="visibility:hidden;">
EOT;
        }
      ?>
      <datalist id="staff-list">
        <?php
          $query = "SELECT name FROM workers WHERE staff = TRUE AND (archived IS NULL OR archived = '');";
          $result = pg_query($db_connection, $query);
          $workerNames = pg_fetch_all_columns($result);
          foreach ($workerNames as $key => $name) {
            $name = htmlspecialchars($name, ENT_QUOTES);
            echo "<option value='$name'>";
          }
        ?>
      </datalist>


      <?php
        $rawArray = explode(",", ltrim(rtrim($classInfo['volunteers'], '}'), '{'));
        $classInfo['volunteers'] = array();
        foreach ($rawArray as $roleIDString) {
          $roleIDString = trim($roleIDString);
          $role = rtrim(ltrim(explode(':', $roleIDString)[0], '"'), '"');
          $volunteerID = trim(explode(':', $roleIDString)[1]);
          $classInfo['volunteers'][$role] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = {$volunteerID} ;"))['name'];
        }

        foreach ($classInfo['volunteers'] as $role => $name) {
          $name = htmlspecialchars($name, ENT_QUOTES);

          echo <<<EOT
          <p>{$role}:</p>
          <input type="text" name="volunteers[]" list="volunteer-list" value="{$name}" onclick="select()">
          <input type="text" name="volunteer-roles[]" value="{$role}" style="visibility:hidden;">
EOT;
        }
      ?>
      <datalist id="volunteer-list">
        <?php
          $query = "SELECT name FROM workers WHERE volunteer = TRUE AND (archived IS NULL OR archived = '');";
          $result = pg_query($db_connection, $query);
          $workerNames = pg_fetch_all_columns($result);
          foreach ($workerNames as $key => $name) {
            $name = htmlspecialchars($name, ENT_QUOTES);
            echo "<option value='$name'>";
          }
        ?>
      </datalist>


      <br>

    <?php if ($classInfo['cancelled'] == "t") {$checked = "checked";} else {$checked = "";} ?>
    <p>Cancel Class: <input type="checkbox" name="cancel" value="TRUE" <?php echo $checked; ?>></p>


    <br><br>
    <input type="submit" value="Submit">
  </form>


</body>

</html>

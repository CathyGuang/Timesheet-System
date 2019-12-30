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
    <nav> <button id="back-button" onclick="window.history.back()">Back</button>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    $classID = explode(';', $_GET['buttonInfo'])[0];
    $clientString = explode(';', $_GET['buttonInfo'])[1];

    $getClassInfoQuery = "SELECT * FROM classes WHERE id = {$classID}";
    $classInfo = pg_fetch_all(pg_query($db_connection, $getClassInfoQuery))[0];
    echo "<h3 class='main-content-header'>{$classInfo['display_title']}, {$classInfo['date_of_class']}</h3>";
  ?>

  <form autocomplete="off" id="class-form" action="manage-class-back-end.php" method="post" class="standard-form">

    <input type="text" name="id" value="<?php echo $classID; ?>" hidden>



    <p>Date of Class:</p>
    <input type="date" id="date-of-class" name="date-of-class" value="<?php echo $classInfo['date_of_class']; ?>" required>



    <label for="start-time">from:</label>
    <input type="time" id="start-time" name="start-time" value="<?php echo $classInfo['start_time']; ?>">
    <label for="end-time">to:</label>
    <input type="time" id="end-time" name="end-time" value="<?php echo $classInfo['end_time']; ?>">




    <p>Lesson Plan:</p>
    <textarea name="lesson-plan" rows="8" cols="30">
      <?php
        echo trim($classInfo['lesson_plan']);
      ?>
    </textarea>




    <p>Arena:</p>
    <input type="text" name="arena" list="arena-list" value="<?php echo $classInfo['arena']; ?>" onclick="select();">
      <datalist id="arena-list">
        <?php
          $query = "SELECT unnest(enum_range(NULL::ARENA))::text EXCEPT SELECT name FROM archived_enums;";
          $result = pg_query($db_connection, $query);
          $arenaNames = pg_fetch_all_columns($result);
          foreach ($arenaNames as $key => $value) {
            $value = htmlspecialchars($value, ENT_QUOTES);
            echo "<option value='$value'>";
          }
        ?>
      </datalist>






    <?php $horseNameList = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM horses WHERE id = ANY('{$classInfo['horses']}');")); ?>
    <div id="horse-section">
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
    </div>
    <br>
    <button type="button" id="add-horse-button" onclick="newHorseFunction();">Add Horse</button>




    <div id="tack-section">
      <p>Tack(s):</p>
      <?php
        $tackList = explode(',', ltrim(rtrim($classInfo['tacks'], "}"), '{'));
        foreach ($tackList as $name) {
          $name = ltrim(rtrim($name, '\"'), '\"');
          echo <<<EOT
          <input form='class-form' type="text" name="tacks[]" list="tack-list" value="{$name}" onclick="select();">
EOT;
        }
      ?>
      <datalist id="tack-list">
        <?php
          $query = "SELECT unnest(enum_range(NULL::TACK))::text EXCEPT SELECT name FROM archived_enums;";
          $result = pg_query($db_connection, $query);
          $tackNames = pg_fetch_all_columns($result);
          foreach ($tackNames as $key => $value) {
            $value = htmlspecialchars($value, ENT_QUOTES);
            echo "<option value='$value'>";
          }
        ?>
      </datalist>
    </div>
    <br>
    <button type="button" id="add-tack-button" onclick="newTackFunction();">Add Tack</button>




    <div id="pad-section">
      <p>Pad(s):</p>
      <?php
        $padList = explode(',', ltrim(rtrim($classInfo['pads'], "}"), '{'));
        foreach ($padList as $key => $name) {
          $padList[$key] = rtrim(ltrim($name, "\""), "\"");
          echo <<<EOT
          <input form='class-form' type="text" name="pads[]" list="pad-list" value="{$padList[$key]}" onclick="select();">
EOT;
        }
      ?>
      <datalist id="pad-list">
        <?php
          $query = "SELECT unnest(enum_range(NULL::PAD))::text EXCEPT SELECT name FROM archived_enums;";
          $result = pg_query($db_connection, $query);
          $padNames = pg_fetch_all_columns($result);
          foreach ($padNames as $key => $value) {
            $value = htmlspecialchars($value, ENT_QUOTES);
            echo "<option value='$value'>";
          }
        ?>
      </datalist>
    </div>
    <br>
    <button type="button" id="add-pad-button" onclick="newPadFunction();">Add Additional Pad</button>





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


      <br>
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









      <!-- STAFF -->
      <?php
        $rawArray = explode(",", ltrim(rtrim($classInfo['staff'], '}'), '{'));
        $classInfo['staff'] = array();
        foreach ($rawArray as $roleIDString) {
          $roleIDString = trim($roleIDString);
          $role = rtrim(ltrim(explode(':', $roleIDString)[0], '"'), '"');
          $staffID = trim(explode(':', $roleIDString)[1]);
          $classInfo['staff'][$role] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = {$staffID} ;"))['name'];
        }

        echo "<div id='staff-section'><p>Staff:</p>";
        foreach ($classInfo['staff'] as $role => $name) {
          $name = htmlspecialchars($name, ENT_QUOTES);

          echo <<<EOT
            <input type="text" name="staff-roles[]" list="staff-role-list" value="{$role}" onclick="select()">
            <input type="text" name="staff[]" list="staff-list" value="{$name}" onclick="select()">
            <br><br>
EOT;
        }
        echo "</div><button type='button' id='add-staff-button' onclick='newStaffFunction();'>Add Staff Member</button>";
      ?>
      <datalist id="staff-role-list">
        <?php
          $query = "SELECT unnest(enum_range(NULL::STAFF_CLASS_ROLE))::text EXCEPT SELECT name FROM archived_enums;";
          $result = pg_query($db_connection, $query);
          $classTypeNames = pg_fetch_all_columns($result);
          foreach ($classTypeNames as $key => $value) {
            $value = htmlspecialchars($value, ENT_QUOTES);
            echo "<option value='$value'>";
          }
        ?>
      </datalist>
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







      <!-- VOLUNTEERS -->
      <?php
        $rawArray = explode(",", ltrim(rtrim($classInfo['volunteers'], '}'), '{'));
        $classInfo['volunteers'] = array();
        foreach ($rawArray as $roleIDString) {
          $roleIDString = trim($roleIDString);
          $role = rtrim(ltrim(explode(':', $roleIDString)[0], '"'), '"');
          $volunteerID = trim(explode(':', $roleIDString)[1]);
          $classInfo['volunteers'][$role] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = {$volunteerID} ;"))['name'];
        }

        echo "<div id='volunteer-section'><p>Volunteer:</p>";
        foreach ($classInfo['volunteers'] as $role => $name) {
          $name = htmlspecialchars($name, ENT_QUOTES);

          echo <<<EOT
            <input type="text" name="volunteer-roles[]" list="volunteer-role-list" value="{$role}" onclick="select()">
            <input type="text" name="volunteers[]" list="volunteer-list" value="{$name}" onclick="select()">
            <br><br>
EOT;
        }
        echo "</div><button type='button' id='add-volunteer-button' onclick='newVolunteerFunction();'>Add Volunteer</button>";
      ?>

      <datalist id="volunteer-role-list">
        <?php
          $query = "SELECT unnest(enum_range(NULL::VOLUNTEER_CLASS_ROLE))::text EXCEPT SELECT name FROM archived_enums;";
          $result = pg_query($db_connection, $query);
          $roleNames = pg_fetch_all_columns($result);
          foreach ($roleNames as $key => $value) {
            $value = htmlspecialchars($value, ENT_QUOTES);
            echo "<option value='$value'>";
          }
        ?>
      </datalist>
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









    <?php if ($classInfo['cancelled'] == "t") {$checked = "checked";} else {$checked = "";} ?>
    <p>Cancel Class: <input type="checkbox" name="cancel" value="TRUE" <?php echo $checked; ?>></p>







    <br><br>
    <button type="submit">Submit</button>
  </form>


  <footer>
    <script type="text/javascript">
    function newStaffFunction() {
        var staffSection = document.getElementById('staff-section');
        newInput = document.createElement('br');
        staffSection.appendChild(newInput);
        newInput = document.createElement('br');
        staffSection.appendChild(newInput);
        //add role selector
        newInput = document.createElement('input');
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'staff-roles[]');
        newInput.setAttribute('list', 'staff-role-list');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        staffSection.appendChild(newInput);
        //add name selector
        newInput = document.createElement('input');
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'staff[]');
        newInput.setAttribute('list', 'staff-list');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        staffSection.appendChild(newInput);
    };

    function newHorseFunction() {
        newInput = document.createElement('input');
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'horses[]');
        newInput.setAttribute('list', 'horse-list');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        var horseSection = document.getElementById('horse-section');
        horseSection.appendChild(newInput);
    };

    function newTackFunction() {
        newInput = document.createElement('input');
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'tacks[]');
        newInput.setAttribute('list', 'tack-list');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        var tackSection = document.getElementById('tack-section');
        tackSection.appendChild(newInput);
    };

    function newPadFunction() {
        newInput = document.createElement('input');
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'pads[]');
        newInput.setAttribute('list', 'pad-list');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        var padSection = document.getElementById('pad-section');
        padSection.appendChild(newInput);
    };
    function newTackNotesFunction() {
        newInput = document.createElement('input');
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'tack-notes[]');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        var padSection = document.getElementById('tack-notes-section');
        padSection.appendChild(newInput);
    };
    function newClientEquipmentNotesFunction() {
        newInput = document.createElement('input');
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'client-equipment-notes[]');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        var padSection = document.getElementById('client-equipment-section');
        padSection.appendChild(newInput);
    };
    function newClientFunction() {
        newInput = document.createElement('input');
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'clients[]');
        newInput.setAttribute('list', 'client-list');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        var clientSection = document.getElementById('client-section');
        clientSection.appendChild(newInput);
    };

    function newVolunteerFunction() {
        var volunteerSection = document.getElementById('volunteer-section');
        newInput = document.createElement('br');
        volunteerSection.appendChild(newInput);
        //Add role selector
        newInput = document.createElement('input');
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'volunteer-roles[]');
        newInput.setAttribute('list', 'volunteer-role-list');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        volunteerSection.appendChild(newInput);
        //Add name selector
        newInput = document.createElement('input');
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'volunteers[]');
        newInput.setAttribute('list', 'volunteer-list');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        volunteerSection.appendChild(newInput);
    };


    </script>
  </footer>




</body>

</html>

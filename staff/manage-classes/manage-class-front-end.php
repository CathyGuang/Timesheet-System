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
    $classData = pg_fetch_all(pg_query($db_connection, $getClassInfoQuery))[0];
    echo "<h3 class='main-content-header'>{$classData['display_title']}, {$classData['date_of_class']}</h3>";
  ?>

  <div class="form-container">
    <form autocomplete="off" id="class-form" action="manage-class-back-end.php" method="post" class="standard-form">

      <input type="text" name="id" value="<?php echo $classID; ?>" hidden>


      <div class="form-section">
        <h3>Class Info:</h3>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label for="date-of-class">Date of Class:</label>
          <input type="date" id="date-of-class" name="date-of-class" value="<?php echo $classData['date_of_class']; ?>" required>
        </div>
        <div class="form-element">
          <label for="start-time">from:</label>
          <input type="time" id="start-time" name="start-time" value="<?php echo $classData['start_time']; ?>">
        </div>
        <div class="form-element">
          <label for="end-time">to:</label>
          <input type="time" id="end-time" name="end-time" value="<?php echo $classData['end_time']; ?>">
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label for="class-type">Class Type:</label>
          <input type="text" name="old-class-type" value="<?php echo $classData['class_type']; ?>" hidden>
          <input type="text" name="class-type" list="class-type-list" value="<?php echo $classData['class_type']; ?>" onclick="select()" required>
        </div>
        <div class="form-element">
          <label for="display-title">Display Title:</label>
          <input type="text" name="display-title" id="display-title" value="<?php echo $classData['display_title']; ?>" onclick="select();" required>
        </div>
      </div>


      <div class="form-section">
        <div class="form-element">
          <label for="lesson-plan">Lesson Plan:</label>
          <textarea name="lesson-plan"><?php
              echo trim($classData['lesson_plan']);
            ?></textarea>
        </div>
      </div>




      <div class="form-section">
        <h3>Location: </h3>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label>Arena:</label>
          <input type="text" name="arena" list="arena-list" value="<?php echo $classData['arena']; ?>" onclick="select();">
        </div>
      </div>



      


      

      <div>
        <div id="client-horse-section">
          <div class="form-section">
            <h3>Client(s)/Horse(s):</h3>
          </div>

          <?php
              // INITIALIZE LISTS OF VALUES

              $oldClientIDListPGArray = '{';
              $clientIDList = explode(',', ltrim(rtrim($classData['clients'], '}'), '{'));
              foreach ($clientIDList as $id) {
                  $oldClientIDListPGArray .= $id .',';
                  }
              $oldClientIDListPGArray = rtrim($oldClientIDListPGArray, ',') . '}';
          

              $horseIDList = explode(',', ltrim(rtrim($classData['horses'], '}'), '{'));

              $tackList = explode(',', ltrim(rtrim($classData['tacks'], '}'), '{'));
              foreach ($tackList as $index => $name) {
                $tackList[$index] = ltrim(rtrim($name, '\"'), '\"');
              }

              $padList = explode(',', ltrim(rtrim($classData['pads'], '}'), '{'));
              foreach ($padList as $index => $name) {
                  $padList[$index] = rtrim(ltrim($name, '\"'), '\"');
              }

              $tackNotesList = explode(',', ltrim(rtrim($classData['tack_notes'], "}"), '{'));

              $clientEquipmentNotesList = explode(',', ltrim(rtrim($classData['client_equipment_notes'], "}"), '{'));

          ?>
          <!-- hidden id list of original clients for class identification if clients change -->
          <input type="text" name="old-client-id-list" value="<?php echo $oldClientIDListPGArray; ?>" hidden>

          <?php 
          $index = 0;
          while (true) {
            

            if ($clientIDList[$index]) {
              $clientName = pg_fetch_array(pg_query($db_connection, "SELECT name FROM clients WHERE clients.id = {$clientIDList[$index]}") , 0, 1)['name'];
              $client = htmlspecialchars($clientName, ENT_QUOTES);
            } else {
              $client = "";
            }

            if ($horseIDList[$index]) {
              $horseName = pg_fetch_array(pg_query($db_connection, "SELECT name FROM horses WHERE id = {$horseIDList[$index]} AND (archived IS NULL OR archived = '');") , 0, 1)['name'];
              $horse = htmlspecialchars($horseName, ENT_QUOTES);
            } else {
              $horse = "";
            }

            if ($tackList[$index]) {
              $tack = htmlspecialchars($tackList[$index], ENT_QUOTES);
            } else {
              $tack = "";
            }

            if ($padList[$index]) {
              $pad = htmlspecialchars($padList[$index], ENT_QUOTES);
            } else {
              $pad = "";
            }

            if ($tackNotesList[$index]) {
              $note = ltrim(rtrim($tackNotesList[$index], '"'), '"');
              $note = htmlspecialchars($note, ENT_QUOTES);
            } else {
              $note = "";
            }

            if ($clientEquipmentNotesList[$index]) {
              $clientNote = ltrim(rtrim($clientEquipmentNotesList[$index], '"'), '"');
              $clientNote = htmlspecialchars($clientNote, ENT_QUOTES);
            } else {
              $clientNote = "";
            }


            echo "<div class='client-horse-form-section'><div class='form-element'>";
            if ($index == 0) {echo "<label>Client:</label>";}
            echo "<input type='text' name='clients[]' list='client-list' value='{$client}' onclick='select();'>";
            
            echo "</div><div class='form-element'>";
            if ($index == 0) {echo "<label>Horse:</label>";}
            echo "<input type='text' name='horses[]' list='horse-list' value='{$horse}' onclick='select();'>";
              
            echo "</div><div class='form-element'>";
            if ($index == 0) {echo "<label>Tack:</label>";}
            echo "<input type='text' name='tacks[]' list='tack-list' value='{$tack}' onclick='select();'>";
            
            echo "</div><div class='form-element'>";
            if ($index == 0) {echo "<label>Pad:</label>";}
            echo "<input type='text' name='pads[]' list='pad-list' value='{$pad}' onclick='select();'>";
            
            echo "</div><div class='form-element'>";
            if ($index == 0) {echo "<label>Tack Notes:</label>";}
            echo "<input type='text' name='tack-notes[]' value='{$note}' onclick='select();'>";
            
            echo "</div><div class='form-element'>";
            if ($index == 0) {echo "<label>Equipment Notes:</label>";}
            echo "<input type='text' name='client-equipment-notes[]' value='{$clientNote}' onclick='select();'>";
            
            echo "</div></div>";

            // Check for remaining POST data, if done, exit loop
            if (empty($clientIDList[$index+1]) && empty($horseIDList[$index+1]) && empty($tackList[$index+1]) && empty($padList[$index+1]) && empty($tackNotesList[$index+1]) && empty($clientEquipmentNotesList[$index+1])) {
              break;
            }
            $index++;
          }
          ?>

        </div>
        <div class="form-section">

          <div class="form-element">
            <button type="button" id="add-client-horse-section-button" onclick="newClientHorseSection();">Add Client/Horse</button>
          </div>

        </div>
      </div>





















      <?php $horseNameList = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM horses WHERE id = ANY('{$classData['horses']}');")); ?>
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
          $tackList = explode(',', ltrim(rtrim($classData['tacks'], "}"), '{'));
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
          $padList = explode(',', ltrim(rtrim($classData['pads'], "}"), '{'));
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
        <input type="text" name="horse-behavior" list="horse-behavior-enum" value="<?php echo $classData['horse_behavior']; ?>">
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
            echo trim($classData['horse_behavior_notes']);
          ?>
        </textarea>





        <p>Attendance:</p>
        <?php
          $clientIDList = explode(',', rtrim(ltrim($classData['clients'], '{'), '}'));
          $clientNameList = explode(',', $clientString);
          $clientAttendanceList = explode(',', rtrim(ltrim($classData['attendance'], '{'), '}'));
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
            echo $classData['client_notes'];
          ?>
        </textarea>
        <br>









        <!-- STAFF -->
        <?php
          $rawArray = explode(",", ltrim(rtrim($classData['staff'], '}'), '{'));
          $classData['staff'] = array();
          foreach ($rawArray as $roleIDString) {
            $roleIDString = trim($roleIDString);
            $role = rtrim(ltrim(explode(':', $roleIDString)[0], '"'), '"');
            $staffID = trim(explode(':', $roleIDString)[1]);
            $classData['staff'][$role] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = {$staffID} ;"))['name'];
          }

          echo "<div id='staff-section'><p>Staff:</p>";
          foreach ($classData['staff'] as $role => $name) {
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
          $rawArray = explode(",", ltrim(rtrim($classData['volunteers'], '}'), '{'));
          $classData['volunteers'] = array();
          foreach ($rawArray as $roleIDString) {
            $roleIDString = trim($roleIDString);
            $role = rtrim(ltrim(explode(':', $roleIDString)[0], '"'), '"');
            $volunteerID = trim(explode(':', $roleIDString)[1]);
            $classData['volunteers'][$role] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = {$volunteerID} ;"))['name'];
          }

          echo "<div id='volunteer-section'><p>Volunteer:</p>";
          foreach ($classData['volunteers'] as $role => $name) {
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









      <?php if ($classData['cancelled'] == "t") {$checked = "checked";} else {$checked = "";} ?>
      <p>Cancel Class: <input type="checkbox" name="cancel" value="TRUE" <?php echo $checked; ?>></p>







      <br><br>
      <button type="submit">Submit</button>
    </form>
  </div>






  <!-- DATA LISTS -->

  <datalist id="class-type-list">
  <?php
      $query = "SELECT unnest(enum_range(NULL::CLASS_TYPE))::text EXCEPT SELECT name FROM archived_enums;";
      $result = pg_query($db_connection, $query);
      $classTypeNames = pg_fetch_all_columns($result);
      foreach ($classTypeNames as $key => $value) {
      $value = htmlspecialchars($value, ENT_QUOTES);
      echo "<option value='{$value}'>";
      }
  ?>
  </datalist>

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
      $staffNames = pg_fetch_all_columns($result);
      foreach ($staffNames as $key => $name) {
      $name = htmlspecialchars($name, ENT_QUOTES);
      echo "<option value='$name'>";
      }
  ?>
  </datalist>
  
  <datalist id="client-list">
  <?php
      $query = "SELECT name FROM clients WHERE (archived IS NULL OR archived = '');";
      $result = pg_query($db_connection, $query);
      $clientNames = pg_fetch_all_columns($result);
      foreach ($clientNames as $key => $value) {
      $value = htmlspecialchars($value, ENT_QUOTES);
      echo "<option value='{$value}'>";
      }
  ?>
  </datalist>

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
      $query = "SELECT name FROM workers WHERE (archived IS NULL OR archived = '');";
      $result = pg_query($db_connection, $query);
      $workerNames = pg_fetch_all_columns($result);
      foreach ($workerNames as $key => $value) {
      $value = htmlspecialchars($value, ENT_QUOTES);
      echo "<option value='$value'>";
      }
  ?>
  </datalist>






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

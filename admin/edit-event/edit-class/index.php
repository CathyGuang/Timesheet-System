<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | Edit Class</title>
</head>

<body>

  <header>
    <h1>Edit Class</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>



  <?php
    if ($_POST['selected-class']) {
      echo "<h3 class='main-content-header'>{$_POST['selected-class']}</h3>";

      //$selectedClassType = explode('; ', $_POST['selected-class'])[2];
      //$selectedClientNames = explode(', ', explode('; ', $_POST['selected-class'])[3]);
      $selectedClassCode = explode(': ', explode('; ', $_POST['selected-class'])[4])[1];

      echo "<br>CLASS CODE:";
      var_dump($selectedClassCode);

      /*
      $clientIDList = array();
      foreach ($selectedClientNames as $name) {
        if ($name == "") {continue;}
        $IDQuery = "SELECT id FROM clients WHERE name LIKE '{$name}' AND (archived IS NULL OR archived = '');";
        $id = pg_fetch_row(pg_query($db_connection, $IDQuery))[0];
        $clientIDList[] = $id;
      }
      if (!$clientIDList) {
        $clientIDList[] = 1;
      }
      $clientIDPGArray = to_pg_array($clientIDList);
      */

      //Get class IDs
      $getClassIDsQuery = "SELECT id FROM classes WHERE class_code = '{$selectedClassCode}' AND (archived IS NULL OR archived = '');";
      $classIDSQLObject = pg_fetch_all(pg_query($db_connection, $getClassIDsQuery));
      $classIDList = array();
      foreach ($classIDSQLObject as $row => $data) {
        $classIDList[] = $data['id'];
      }

      //Get data from the next occurring class so that display information is accurate to edits already made
      $todaysDate = date('Y-m-d');
      $classIDList = to_pg_array($classIDList);
      $classDataQuery = "SELECT * FROM classes WHERE classes.id = ANY('{$classIDList}') AND classes.date_of_class >= '{$todaysDate}';";
      $classData = pg_fetch_row(pg_query($db_connection, $classDataQuery), 0, PGSQL_ASSOC);

      //If all class dates have past, do something???



      //get start and end dates for entire class range
      $startDate = pg_fetch_array(pg_query($db_connection, "SELECT MIN (date_of_class) AS start_date FROM classes WHERE class_type = '{$selectedClassType}' AND clients <@ '{$clientIDPGArray}' AND (archived IS NULL OR archived = '');"), 0, 1)['start_date'];
      $endDate = pg_fetch_array(pg_query($db_connection, "SELECT MAX (date_of_class) AS end_date FROM classes WHERE class_type = '{$selectedClassType}' AND clients <@ '{$clientIDPGArray}' AND (archived IS NULL OR archived = '');"), 0, 1)['end_date'];


      $weekdaysBlocks = explode(";", $classData['all_weekdays_times']);
      if ($weekdaysBlocks[0] == "EO") {
        $everyOtherWeek = true;
        $everyOtherWeekCheckbox = "checked";
      } else {$everyOtherWeek = false; $everyOtherWeekCheckbox = "";}
      $allWeekdaysTimesList = array();
      foreach ($weekdaysBlocks as $weekdayString) {
        if ($weekdayString == "") {continue;}
        if ($weekdayString == "EO") {continue;}
        $weekdayTriple = explode(",", $weekdayString);
        $allWeekdaysTimesList[$weekdayTriple[0]] = array($weekdayTriple[1], $weekdayTriple[2]);
      }

      $checkboxList = array("Monday" => "", "Tuesday" => "", "Wednesday" => "", "Thursday" => "", "Friday" => "", "Saturday" => "", "Sunday" => "", );
      foreach ($allWeekdaysTimesList as $day => $times) {
        $checkboxList[$day] = "checked";
      }

      echo <<<EOT

      <form id="class-form" autocomplete="off" action="edit-class.php" method="post" class="main-form full-page-form">



        <p>Class Type:</p>
        <input type="text" name="old-class-type" value="{$classData['class_type']}" style="visibility: hidden;">
        <input type="text" name="class-type" list="class-type-list" value="{$classData['class_type']}" onclick="select()" required>
          <datalist id="class-type-list">
EOT;

              $query = "SELECT unnest(enum_range(NULL::CLASS_TYPE))::text EXCEPT SELECT name FROM archived_enums;";
              $result = pg_query($db_connection, $query);
              $classTypeNames = pg_fetch_all_columns($result);
              foreach ($classTypeNames as $key => $value) {
                $value = htmlspecialchars($value, ENT_QUOTES);
                echo "<option value='$value'>";
              }

      echo <<<EOT
          </datalist>

        <p>Display Title:</p>
        <input type="text" name="display-title" value="{$classData['display_title']}" onclick="select();" required>


        <p>Dates:</p>
        <p style="font-size: 12pt; margin-top: 0; margin-bottom: 12px;">Every other week: <input type="checkbox" name="every-other-week" value="TRUE" {$everyOtherWeekCheckbox}></p>
        <div style="max-width: 500px;">
          <label for="start-date">Start date:</label>
          <input type="date" id="start-date" name="start-date" value="{$startDate}" placeholder="from" required>
          <label for="end-date">End date:</label>
          <input type="date" id="end-date" name="end-date" value="{$endDate}" placeholder="to" required>
        </div>

        <div style="max-width: 430px;">
          <!-- MONDAY-->
          <label for="monday-checkbox">Monday: </label>
          <input type="checkbox" id="monday-checkbox" name="monday-checkbox" value="Monday" {$checkboxList['Monday']}>
          <label for="monday-start-time">from:</label>
          <input type="time" id="monday-start-time" name="monday-start-time" value="{$allWeekdaysTimesList['Monday'][0]}">
          <label for="monday-end-time">to:</label>
          <input type="time" id="monday-end-time" name="monday-end-time" value="{$allWeekdaysTimesList['Monday'][1]}">
          <!-- TUESDAY-->
          <label for="tuesday-checkbox">Tuesday: </label>
          <input type="checkbox" id="tuesday-checkbox" name="tuesday-checkbox" value="Tuesday" {$checkboxList['Tuesday']}>
          <label for="tuesday-start-time">from:</label>
          <input type="time" id="tuesday-start-time" name="tuesday-start-time" value="{$allWeekdaysTimesList['Tuesday'][0]}">
          <label for="tuesday-end-time">to:</label>
          <input type="time" id="tuesday-end-time" name="tuesday-end-time" value="{$allWeekdaysTimesList['Tuesday'][1]}">
          <!-- WEDNESDAY-->
          <label for="wednesday-checkbox">Wednesday: </label>
          <input type="checkbox" id="wednesday-checkbox" name="wednesday-checkbox" value="Wednesday" {$checkboxList['Wednesday']}>
          <label for="wednesday-start-time">from:</label>
          <input type="time" id="wednesday-start-time" name="wednesday-start-time" value="{$allWeekdaysTimesList['Wednesday'][0]}">
          <label for="wednesday-end-time">to:</label>
          <input type="time" id="wednesday-end-time" name="wednesday-end-time" value="{$allWeekdaysTimesList['Wednesday'][1]}">
          <!-- THURSDAY-->
          <label for="thursday-checkbox">Thursday: </label>
          <input type="checkbox" id="thursday-checkbox" name="thursday-checkbox" value="Thursday" {$checkboxList['Thursday']}>
          <label for="thursday-start-time">from:</label>
          <input type="time" id="thursday-start-time" name="thursday-start-time" value="{$allWeekdaysTimesList['Thursday'][0]}">
          <label for="thursday-end-time">to:</label>
          <input type="time" id="thursday-end-time" name="thursday-end-time" value="{$allWeekdaysTimesList['Thursday'][1]}">
          <!-- FRIDAY-->
          <label for="friday-checkbox">Friday: </label>
          <input type="checkbox" id="friday-checkbox" name="friday-checkbox" value="Friday" {$checkboxList['Friday']}>
          <label for="friday-start-time">from:</label>
          <input type="time" id="friday-start-time" name="friday-start-time" value="{$allWeekdaysTimesList['Friday'][0]}">
          <label for="friday-end-time">to:</label>
          <input type="time" id="friday-end-time" name="friday-end-time" value="{$allWeekdaysTimesList['Friday'][1]}">
          <!-- SATURDAY-->
          <label for="saturday-checkbox">Saturday: </label>
          <input type="checkbox" id="saturday-checkbox" name="saturday-checkbox" value="Saturday" {$checkboxList['Saturday']}>
          <label for="saturday-start-time">from:</label>
          <input type="time" id="saturday-start-time" name="saturday-start-time" value="{$allWeekdaysTimesList['Saturday'][0]}">
          <label for="saturday-end-time">to:</label>
          <input type="time" id="saturday-end-time" name="saturday-end-time" value="{$allWeekdaysTimesList['Saturday'][1]}">
          <!-- SUNDAY-->
          <label for="sunday-checkbox">Sunday: </label>
          <input type="checkbox" id="sunday-checkbox" name="sunday-checkbox" value="Sunday" {$checkboxList['Sunday']}>
          <label for="sunday-start-time">from:</label>
          <input type="time" id="sunday-start-time" name="sunday-start-time" value="{$allWeekdaysTimesList['Sunday'][0]}">
          <label for="sunday-end-time">to:</label>
          <input type="time" id="sunday-end-time" name="sunday-end-time" value="{$allWeekdaysTimesList['Sunday'][1]}">
        </div>

        <p>Arena:</p>
        <input type="text" name="arena" list="arena-list" value="{$classData['arena']}" onclick="select();">
          <datalist id="arena-list">
EOT;

              $query = "SELECT unnest(enum_range(NULL::ARENA))::text EXCEPT SELECT name FROM archived_enums;";
              $result = pg_query($db_connection, $query);
              $arenaNames = pg_fetch_all_columns($result);
              foreach ($arenaNames as $key => $value) {
                $value = htmlspecialchars($value, ENT_QUOTES);
                echo "<option value='$value'>";
              }
        echo <<<EOT
          </datalist>


        <div>
          <div id="staff-section">
            <p>Staff:</p>

              <datalist id="staff-role-list">
EOT;
                  $query = "SELECT unnest(enum_range(NULL::STAFF_CLASS_ROLE))::text EXCEPT SELECT name FROM archived_enums;";
                  $result = pg_query($db_connection, $query);
                  $classTypeNames = pg_fetch_all_columns($result);
                  foreach ($classTypeNames as $key => $value) {
                    $value = htmlspecialchars($value, ENT_QUOTES);
                    echo "<option value='$value'>";
                  }
        echo <<<EOT
              </datalist>

              <datalist id="staff-list">
EOT;
                  $query = "SELECT name FROM workers WHERE staff = TRUE AND (archived IS NULL OR archived = '');";
                  $result = pg_query($db_connection, $query);
                  $staffNames = pg_fetch_all_columns($result);
                  foreach ($staffNames as $key => $value) {
                    $value = htmlspecialchars($value, ENT_QUOTES);
                    echo "<option value='$value'>";
                  }
        echo <<<EOT
              </datalist>
EOT;
        $staffData = json_decode($classData['staff']);
        foreach ($staffData as $role => $staffID) {
          $staffName = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE workers.id = {$staffID};"), 0, 1)['name'];
          $staffName = htmlspecialchars($staffName, ENT_QUOTES);


          echo <<<EOT
          <label>Role: </label>
          <input form="class-form" type="text" name="staff-roles[]" list="staff-role-list" value="{$role}" onclick="select();">
          <br>
          <label>Staff Member: </label>
          <input form="class-form" type="text" name="staff[]" list="staff-list" value="{$staffName}" onclick="select();">

EOT;
        }

        echo <<<EOT
          </div>
          <br>
          <button type="button" id="add-staff-button" onclick="newStaffFunction();">Add Additional Staff Member</button>
        </div>



        <p style='font-size: 12pt; color: var(--dark-red)'>Archive: <input type="checkbox" name="archive" value="TRUE"> Saves class in database but removes from all schedules and menus</p>

        <div>
          <p style='font-size: 12pt; color: var(--dark-red)'>Delete Class?
          <input type="checkbox" id="delete-checkbox" name="DELETE" value="TRUE">
          WARNING: this will permanently delete all record of the class</p>
        </div>

        <br><br>
        <input type="submit" value="Submit Changes">

      </form>




      <div style="display:flex; justify-content:space-around; max-height: 20vh;">

      <div>
      <div id="client-section">
        <p>Client(s):</p>
EOT;
  $oldClientIDListPGArray = "{";
  foreach ($classData['clients'] as $id) {
    $clientName = pg_fetch_array(pg_query($db_connection, "SELECT name FROM clients WHERE clients.id = {$id}") , 0, 1)['name'];
    $oldClientIDListPGArray .= $id .',';
    echo <<<EOT
      <input form='class-form' type="text" name="clients[]" list="client-list" value="{$clientName}" onclick="select();">
EOT;
  }
  $oldClientIDListPGArray = rtrim($oldClientIDListPGArray, ',') . "}";

  echo <<<EOT

      <datalist id="client-list">
EOT;
          $query = "SELECT name FROM clients WHERE (archived IS NULL OR archived = '');";
          $result = pg_query($db_connection, $query);
          $clientNames = pg_fetch_all_columns($result);
          foreach ($clientNames as $key => $value) {
            $value = htmlspecialchars($value, ENT_QUOTES);
            echo "<option value='$value'>";
          }
  echo <<<EOT
      </datalist>
  </div>
  <input form='class-form' type="text" name="old-client-id-list" value="{$oldClientIDListPGArray}" style="visibility: hidden; height: 1px;">
  <button type="button" id="add-client-button" onclick="newClientFunction();">Add Additional Client</button>
  </div>


      <div>
      <div id="horse-section">
        <p>Horse(s):</p>

EOT;
      $horseIDList = explode(',', ltrim(rtrim($classData['horses'], "}"), '{'));
      foreach ($horseIDList as $id) {
        $horseName = pg_fetch_array(pg_query($db_connection, "SELECT name FROM horses WHERE id = {$id} AND (archived IS NULL OR archived = '');") , 0, 1)['name'];
        echo <<<EOT
        <input form='class-form' type="text" name="horses[]" list="horse-list" value="{$horseName}" onclick="select();">
EOT;
      }

      echo <<<EOT
          <datalist id="horse-list">
EOT;

              $query = "SELECT name FROM horses WHERE (archived IS NULL OR archived = '');";
              $result = pg_query($db_connection, $query);
              $horseNames = pg_fetch_all_columns($result);
              foreach ($horseNames as $key => $value) {
                $value = htmlspecialchars($value, ENT_QUOTES);
                echo "<option value='$value'>";
              }

      echo <<<EOT
          </datalist>
        </div>
        <br>
        <button type="button" id="add-horse-button" onclick="newHorseFunction();">Add Additional Horse</button>
        </div>

        <div>
        <div id="tack-section">
          <p>Tack(s):</p>

EOT;
        $tackList = explode(',', ltrim(rtrim($classData['tacks'], "}"), '{'));
        foreach ($tackList as $name) {
          $name = ltrim(rtrim($name, '\"'), '\"');
          echo <<<EOT
          <input form='class-form' type="text" name="tacks[]" list="tack-list" value="{$name}" onclick="select();">
EOT;
        }

        echo <<<EOT
            <datalist id="tack-list">
EOT;

                $query = "SELECT unnest(enum_range(NULL::TACK))::text EXCEPT SELECT name FROM archived_enums;";
                $result = pg_query($db_connection, $query);
                $tackNames = pg_fetch_all_columns($result);
                foreach ($tackNames as $key => $value) {
                  $value = htmlspecialchars($value, ENT_QUOTES);
                  echo "<option value='$value'>";
                }

        echo <<<EOT
            </datalist>
          </div>
          <br>
          <button type="button" id="add-tack-button" onclick="newTackFunction();">Add Additional Tack</button>
          </div>


          <div>
          <div id="pad-section">
            <p>Pad(s):</p>

EOT;
          $padList = explode(',', ltrim(rtrim($classData['pads'], "}"), '{'));
          foreach ($padList as $key => $name) {
            $padList[$key] = rtrim(ltrim($name, "\""), "\"");
            echo <<<EOT
            <input form='class-form' type="text" name="pads[]" list="pad-list" value="{$padList[$key]}" onclick="select();">
EOT;
          }

          echo <<<EOT
              <datalist id="pad-list">
EOT;

                  $query = "SELECT unnest(enum_range(NULL::PAD))::text EXCEPT SELECT name FROM archived_enums;";
                  $result = pg_query($db_connection, $query);
                  $padNames = pg_fetch_all_columns($result);
                  foreach ($padNames as $key => $value) {
                    $value = htmlspecialchars($value, ENT_QUOTES);
                    echo "<option value='$value'>";
                  }

          echo <<<EOT
              </datalist>
            </div>
            <br>
            <button type="button" id="add-pad-button" onclick="newPadFunction();">Add Additional Pad</button>
            </div>



            <div>
              <div id="tack-notes-section">
                <p>Tack Note(s):</p>
EOT;
                  $tackNotesData = explode(',', ltrim(rtrim($classData['tack_notes'], "}"), '{'));
                  if ($tackNotesData) {
                    foreach ($tackNotesData as $note) {
                      $note = ltrim(rtrim($note, '"'), '"');
                      echo "<input form='class-form' type='text' name='tack-notes[]' value='{$note}' onclick='select();'>";
                    }
                  } else {
                    echo "<input form='class-form' type='text' name='tack-notes[]' value='' onclick='select();'>";
                  }
            echo <<<EOT
              </div>
              <br>
              <button type="button" id="add-tack-notes-button" onclick="newTackNotesFunction();">Add Additional Tack Note</button>
            </div>

            <div>
              <div id="client-equipment-section">
                <p>Client Equipment:</p>
EOT;
                  $clientEquipmentNotesData = explode(',', ltrim(rtrim($classData['client_equipment_notes'], "}"), '{'));
                  if ($clientEquipmentNotesData) {
                    foreach ($clientEquipmentNotesData as $note) {
                      $note = ltrim(rtrim($note, '"'), '"');
                      echo "<input form='class-form' type='text' name='client-equipment-notes[]' value='{$note}' onclick='select();'>";
                    }
                  } else {
                    echo "<input form='class-form' type='text' name='client-equipment-notes[]' value='' onclick='select();'>";
                  }
          echo <<< EOT
              </div>
              <br>
              <button type="button" id="add-client-equipment-notes-button" onclick="newClientEquipmentNotesFunction();">Add Client Equipment Note</button>
            </div>




        <div>
        <div id="volunteer-role-section">
          <p>Volunteer Role(s):</p>

EOT;
        $volunteerData = json_decode($classData['volunteers']);
        foreach ($volunteerData as $role => $volunteerID) {
          $volunteerName = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE workers.id = {$volunteerID};"), 0, 1)['name'];

          echo <<<EOT
          <input form="class-form" type="text" name="volunteer-roles[]" list="volunteer-role-list" value="{$role}" onclick="select();">

EOT;
        }

        echo <<<EOT
            <datalist id="volunteer-role-list">
EOT;

              $query = "SELECT unnest(enum_range(NULL::VOLUNTEER_CLASS_ROLE))::text EXCEPT SELECT name FROM archived_enums;";
              $result = pg_query($db_connection, $query);
              $roleNames = pg_fetch_all_columns($result);
              foreach ($roleNames as $key => $value) {
                $value = htmlspecialchars($value, ENT_QUOTES);
                echo "<option value='$value'>";
              }

        echo <<<EOT
            </datalist>
          </div>
          <br>
          <button type="button" id="add-volunteer-button" onclick="newVolunteerFunction();">Add Additional Volunteer</button>
          </div>


          <div>
          <div id="volunteer-section">
            <p>Volunteer(s):</p>

EOT;
          foreach ($volunteerData as $role => $volunteerID) {
            $volunteerName = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE workers.id = {$volunteerID} AND (archived IS NULL OR archived = '');") , 0, 1)['name'];
            echo <<<EOT
            <input form='class-form' type="text" name="volunteers[]" list="volunteer-list" value="{$volunteerName}" onclick="select();">
EOT;
          }

          echo <<<EOT
              <datalist id="volunteer-list">
EOT;

                  $query = "SELECT name FROM workers WHERE (archived IS NULL OR archived = '');";
                  $result = pg_query($db_connection, $query);
                  $workerNames = pg_fetch_all_columns($result);
                  foreach ($workerNames as $key => $value) {
                    $value = htmlspecialchars($value, ENT_QUOTES);
echo "<option value='$value'>";
                  }

          echo <<<EOT
              </datalist>
            </div>
            <br>
            </div>

      </div>





      <footer>
        <script type="text/javascript">
        function newStaffFunction() {
            newInput = document.createElement('br');
            var staffSection = document.getElementById('staff-section');
            staffSection.appendChild(newInput);
            newInput = document.createElement('br');
            staffSection.appendChild(newInput);
            //add role selector
            newInput = document.createElement('label');
            newInput.innerHTML = "Role: ";
            staffSection.appendChild(newInput);
            newInput = document.createElement('input');
            newInput.setAttribute('type', 'text');
            newInput.setAttribute('name', 'staff-roles[]');
            newInput.setAttribute('list', 'staff-role-list');
            newInput.setAttribute('value', '');
            newInput.setAttribute('onclick', 'select()');
            newInput.setAttribute('form', 'class-form');
            var staffSection = document.getElementById('staff-section');
            staffSection.appendChild(newInput);
            //Add name selector
            newInput = document.createElement('br');
            staffSection.appendChild(newInput);
            newInput = document.createElement('label');
            newInput.innerHTML = "Staff Member: ";
            staffSection.appendChild(newInput);
            newInput = document.createElement('input');
            newInput.setAttribute('type', 'text');
            newInput.setAttribute('name', 'staff[]');
            newInput.setAttribute('list', 'staff-list');
            newInput.setAttribute('value', '');
            newInput.setAttribute('onclick', 'select()');
            newInput.setAttribute('form', 'class-form');
            var staffSection = document.getElementById('staff-section');
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
              //Add role selector
              newInput = document.createElement('input');
              newInput.setAttribute('type', 'text');
              newInput.setAttribute('name', 'volunteer-roles[]');
              newInput.setAttribute('list', 'volunteer-role-list');
              newInput.setAttribute('value', '');
              newInput.setAttribute('onclick', 'select()');
              newInput.setAttribute('form', 'class-form');
              var volunteerRoleSection = document.getElementById('volunteer-role-section');
              volunteerRoleSection.appendChild(newInput);
              //Add name selector
              newInput = document.createElement('input');
              newInput.setAttribute('type', 'text');
              newInput.setAttribute('name', 'volunteers[]');
              newInput.setAttribute('list', 'volunteer-list');
              newInput.setAttribute('value', '');
              newInput.setAttribute('onclick', 'select()');
              newInput.setAttribute('form', 'class-form');
              var volunteerSection = document.getElementById('volunteer-section');
              volunteerSection.appendChild(newInput);
            };

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();

        if(dd<10) {
            dd = '0'+dd
        }

        if(mm<10) {
            mm = '0'+mm
        }

        today = yyyy + '-' + mm + '-' + dd;

        var startDateSelector = document.getElementById('start-date');
        var endDateSelector = document.getElementById('end-date');
        startDateSelector.onchange = function() {
          if (this.value < today) {
            alert("Please select a valid start date \u2014 cannot start in the past!");
            this.value = "";
          } else if (this.value > endDateSelector.value) {
            alert("Check your dates \u2014 end date cannot be before the start date!");
            this.value = "";
            endDateSelector.value = "";
          }
        };

        endDateSelector.onchange = function() {
          if (this.value < startDateSelector.value) {
            alert("Please select a valid end date \u2014 cannot end before the start date!");
            this.value = "";
          }
        };

        </script>
      </footer>
EOT;

} else { //IF CLASS HAS NOT YET BEEN SELECTED

    echo <<<EOT
      <form autocomplete="off" action="" method="post" class="main-form">
        <p>Select a class to edit:</p>
        <input type="text" name="selected-class" list="class-list" onclick='select();'>
          <datalist id="class-list">
EOT;
          $query = "SELECT DISTINCT class_type, clients, display_title, staff, class_code FROM classes WHERE (archived IS NULL OR archived = '');";
          $result = pg_query($db_connection, $query);
          while ($row = pg_fetch_row($result)) {
            //Get client names
            $getClientsQuery = <<<EOT
              SELECT clients.name FROM clients WHERE
              clients.id = ANY('{$row[1]}')
              ;
EOT;
            $clients = pg_fetch_all_columns(pg_query($db_connection, $getClientsQuery));
            $clientString = "";
            foreach ($clients as $name) {
              $clientString .= $name . ", ";
            }
            $clientString = rtrim($clientString, ", ");

            //Get staff names
            $staffJSON = json_decode($row[3], true);
            $staffIDList = [];
            foreach ($staffJSON as $key => $id) {
              $staffIDList[] = $id;
            }
            $staffIDList = to_pg_array($staffIDList);
            $getStaffQuery = <<<EOT
              SELECT workers.name FROM workers WHERE
              workers.id = ANY('{$staffIDList}')
              ;
EOT;
            $staffData = pg_fetch_all_columns(pg_query($db_connection, $getStaffQuery));
            $staffString = "";
            foreach ($staffData as $name) {
              $staffString .= $name . ", ";
            }
            $staffString = rtrim($staffString, ", ");
            echo "<option value='$staffString; $row[2]; $row[0]; $clientString; class code: $row[4]'>";
          }

    echo <<<EOT
          </datalist>

          <br><br>
          <input type="submit" value="Submit">
      </form>
EOT;
    }
  ?>


</body>

</html>

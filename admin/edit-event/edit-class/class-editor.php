<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | Edit Class</title>
</head>

<body>

  <header>
    <h1>Edit Class</h1>
    <nav> <a href="../../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>



  <h3 class='main-content-header'><?php echo $_POST['selected-class']; ?></h3>

  <?php 
    $selectedClassCode = explode(': ', $_POST['selected-class'])[1];


    //Get class IDs
    $getClassIDsQuery = "SELECT id FROM classes WHERE class_code = '{$selectedClassCode}' AND (archived IS NULL OR archived = '');";
    $classIDSQLObject = pg_fetch_all(pg_query($db_connection, $getClassIDsQuery));
    $classIDList = array();
    foreach ($classIDSQLObject as $row => $data) {
      $classIDList[] = $data['id'];
    }

    //get start and end dates for entire class range
    $startDate = pg_fetch_array(pg_query($db_connection, "SELECT MIN (date_of_class) AS start_date FROM classes WHERE class_code = '{$selectedClassCode}' AND (archived IS NULL OR archived = '');"), 0, 1)['start_date'];
    $endDate = pg_fetch_array(pg_query($db_connection, "SELECT MAX (date_of_class) AS end_date FROM classes WHERE class_code = '{$selectedClassCode}' AND (archived IS NULL OR archived = '');"), 0, 1)['end_date'];


    //Get data from the next occurring class so that display information is accurate to edits already made
    $todaysDate = date('Y-m-d');
    $classIDList = to_pg_array($classIDList);
    $classDataQuery = "SELECT * FROM classes WHERE classes.id = ANY('{$classIDList}') AND classes.date_of_class >= '{$todaysDate}';";
    $classData = pg_fetch_row(pg_query($db_connection, $classDataQuery), 0, PGSQL_ASSOC);


    //If all class dates have past, do something???
    // Automatically archive class?
    if (!$classData) {
      $pastClass = true;
      $classDataQuery = "SELECT * FROM classes WHERE classes.id = ANY('{$classIDList}') AND classes.date_of_class = '{$endDate}';";
      $classData = pg_fetch_row(pg_query($db_connection, $classDataQuery), 0, PGSQL_ASSOC);
    }



    

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
  ?>

  <div class="form-container">
    <form id="class-form" autocomplete="off" action="edit-class.php" method="post" class="standard-form">

      <input type="text" name="class-code" value="<?php echo $selectedClassCode; ?>" hidden>

      <div class="form-section">
        <h3>Class Info: </h3>
        <div class="form-element" style="color: red;">
          <h3>This Class Is Over.</h3>
        </div>
        <div class="form-element" style="color: red;">
          <p>You cannot edit this class. Consider archiving this class to remove it from menus.</p>
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label for="class-type">Class Type:</label>
          <input type="text" name="old-class-type" value="<?php echo $classData['class_type']; ?>" hidden>
          <input type="text" name="class-type" list="class-type-list" value="<?php echo $classData['class_type']; ?>" onclick="select()" required>
        </div>
      </div>

      <div class="form-section">
        <div class="form-element">
          <label for="display-title">Display Title:</label>
          <input type="text" name="display-title" id="display-title" value="<?php echo $classData['display_title']; ?>" onclick="select();" required>
        </div>
      </div>


      <div class="form-section">
        <h3>Dates: </h3>
      </div>
      <div class="form-section">
        <div class="form-element">
          <label>Every other week: <input type="checkbox" name="every-other-week" value="TRUE" <?php echo $everyOtherWeekCheckbox; ?>></label>
        </div>
          <div class="form-element">
          <label for="start-date">Start date:</label>
          <input type="date" id="start-date" name="start-date" value="<?php echo $startDate; ?>" placeholder="from" required>
        </div>
        <div class="form-element">
          <label for="end-date">End date:</label>
          <input type="date" id="end-date" name="end-date" value="<?php echo $endDate; ?>" placeholder="to" required>
        </div>
      </div>



      <div class="form-section">         
          <!-- MONDAY-->
        <div class="form-element">
          <label for="monday-checkbox">Monday: </label>
          <input type="checkbox" id="monday-checkbox" name="monday-checkbox" value="Monday" <?php echo $checkboxList['Monday']; ?>>
        </div>
        <div class="form-element">
          <label for="monday-start-time">from:</label>
          <input type="time" id="monday-start-time" name="monday-start-time" value="<?php echo $allWeekdaysTimesList['Monday'][0]; ?>">
        </div>
        <div class="form-element">
          <label for="monday-end-time">to:</label>
          <input type="time" id="monday-end-time" name="monday-end-time" value="<?php echo $allWeekdaysTimesList['Monday'][1]; ?>">
        </div>
      </div>
      <div class="form-section">
          <!-- TUESDAY-->
        <div class="form-element">
          <label for="tuesday-checkbox">Tuesday: </label>
          <input type="checkbox" id="tuesday-checkbox" name="tuesday-checkbox" value="Tuesday" <?php echo $checkboxList['Tuesday']; ?>>
        </div>
        <div class="form-element">
          <label for="tuesday-start-time">from:</label>
          <input type="time" id="tuesday-start-time" name="tuesday-start-time" value="<?php echo $allWeekdaysTimesList['Tuesday'][0]; ?>">
        </div>
        <div class="form-element">
          <label for="tuesday-end-time">to:</label>
          <input type="time" id="tuesday-end-time" name="tuesday-end-time" value="<?php echo $allWeekdaysTimesList['Tuesday'][1]; ?>">
        </div>
      </div>
      <div class="form-section">
          <!-- WEDNESDAY-->
        <div class="form-element">
          <label for="wednesday-checkbox">Wednesday: </label>
          <input type="checkbox" id="wednesday-checkbox" name="wednesday-checkbox" value="Wednesday" <?php echo $checkboxList['Wednesday']; ?>>
        </div>
        <div class="form-element">
          <label for="wednesday-start-time">from:</label>
          <input type="time" id="wednesday-start-time" name="wednesday-start-time" value="<?php echo $allWeekdaysTimesList['Wednesday'][0]; ?>">
        </div>
        <div class="form-element">
          <label for="wednesday-end-time">to:</label>
          <input type="time" id="wednesday-end-time" name="wednesday-end-time" value="<?php echo $allWeekdaysTimesList['Wednesday'][1]; ?>">
        </div>
        </div>
      <div class="form-section">
          <!-- THURSDAY-->
        <div class="form-element">
          <label for="thursday-checkbox">Thursday: </label>
          <input type="checkbox" id="thursday-checkbox" name="thursday-checkbox" value="Thursday" <?php echo $checkboxList['Thursday']; ?>>
        </div>
        <div class="form-element">
          <label for="thursday-start-time">from:</label>
          <input type="time" id="thursday-start-time" name="thursday-start-time" value="<?php echo $allWeekdaysTimesList['Thursday'][0]; ?>">
        </div>
        <div class="form-element">
          <label for="thursday-end-time">to:</label>
          <input type="time" id="thursday-end-time" name="thursday-end-time" value="<?php echo $allWeekdaysTimesList['Thursday'][1]; ?>">
        </div>
      </div>
      <div class="form-section">
          <!-- FRIDAY-->
        <div class="form-element">
          <label for="friday-checkbox">Friday: </label>
          <input type="checkbox" id="friday-checkbox" name="friday-checkbox" value="Friday" <?php echo $checkboxList['Friday']; ?>>
        </div>
        <div class="form-element">
          <label for="friday-start-time">from:</label>
          <input type="time" id="friday-start-time" name="friday-start-time" value="<?php echo $allWeekdaysTimesList['Friday'][0]; ?>">
        </div>
        <div class="form-element">
          <label for="friday-end-time">to:</label>
          <input type="time" id="friday-end-time" name="friday-end-time" value="<?php echo $allWeekdaysTimesList['Friday'][1]; ?>">
        </div>
      </div>
      <div class="form-section">
          <!-- SATURDAY-->
        <div class="form-element">
          <label for="saturday-checkbox">Saturday: </label>
          <input type="checkbox" id="saturday-checkbox" name="saturday-checkbox" value="Saturday" <?php echo $checkboxList['Saturday']; ?>>
        </div>
        <div class="form-element">
          <label for="saturday-start-time">from:</label>
          <input type="time" id="saturday-start-time" name="saturday-start-time" value="<?php echo $allWeekdaysTimesList['Saturday'][0]; ?>">
        </div>
        <div class="form-element">
          <label for="saturday-end-time">to:</label>
          <input type="time" id="saturday-end-time" name="saturday-end-time" value="<?php echo $allWeekdaysTimesList['Saturday'][1]; ?>">
        </div>
      </div>
      <div class="form-section">
          <!-- SUNDAY-->
        <div class="form-element">
          <label for="sunday-checkbox">Sunday: </label>
          <input type="checkbox" id="sunday-checkbox" name="sunday-checkbox" value="Sunday" <?php echo $checkboxList['Sunday']; ?>>
        </div>
        <div class="form-element">
          <label for="sunday-start-time">from:</label>
          <input type="time" id="sunday-start-time" name="sunday-start-time" value="<?php echo $allWeekdaysTimesList['Sunday'][0]; ?>">
        </div>
        <div class="form-element">
          <label for="sunday-end-time">to:</label>
          <input type="time" id="sunday-end-time" name="sunday-end-time" value="<?php echo $allWeekdaysTimesList['Sunday'][1]; ?>">
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
        <div id="staff-section">
          <div class="form-section">
            <h3>Staff:</h3>
          </div>

          <?php
            $staffData = json_decode($classData['staff']);
            if ($staffData) {
              $firstIndex = true;
              foreach ($staffData as $role => $staffID) {
                $staffName = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE workers.id = {$staffID};"), 0, 1)['name'];
                $staffName = htmlspecialchars($staffName, ENT_QUOTES);
                echo "<div class='form-section'><div class='form-element'>";
                if ($firstIndex) {echo "<label>Role:</label>";}
                echo "<input type='text' name='staff-roles[]' list='staff-role-list' value='{$role}' onclick='select();'>";
                echo "</div><div class='form-element'>";
                if ($firstIndex) {echo "<label>Staff Member:</label>";}
                echo "<input type='text' name='staff[]' list='staff-list' value='{$staffName}' onclick='select();'>";
                echo "</div></div>";
                $firstIndex = false;
              }
            } else {
              echo "<div class='form-section'><div class='form-element'>";
              echo "<label>Role: </label><input type='text' name='staff-roles[]' list='staff-role-list' value='' onclick='select();'>";
              echo "</div><div class='form-element'";
              echo "<label>Staff Member: </label><input type='text' name='staff[]' list='staff-list' value='' onclick='select();'>";
              echo "</div></div>";
            }
          ?>
        </div>
        <div class="form-section">
          <div class="form-element">
            <button type="button" id="add-staff-button" onclick="newStaffFunction();">Add Staff</button>
          </div>
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




      <div class="form-section">
        <div class="form-element">
          <p>Ignore horse use for this class: <input type="checkbox" name="ignore-horse-use" <?php if ($classData['ignore_horse_use'] == 't') {echo "checked";} ?>></p>
        </div>
      </div>








      <div>
        <div id="volunteer-section">
          <div class="form-section">
            <h3>Volunteers:</h3>
          </div>
          <?php
            $volunteerData = convert_object_to_array(json_decode($classData['volunteers']));
            if ($volunteerData) {
              $firstIndex = true;
              foreach ($volunteerData as $role => $volunteerID) {
                $volunteerName = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE workers.id = {$volunteerID};"), 0, 1)['name'];
                $volunteer = htmlspecialchars($volunteerName, ENT_QUOTES);
                $role = htmlspecialchars($role, ENT_QUOTES);
                echo "<div class='form-section'><div class='form-element'>";
                if ($firstIndex) {echo "<label>Role:</label>";}
                echo "<input type='text' name='volunteer-roles[]' list='volunteer-role-list' value='{$role}' onclick='select();'>";
                echo "</div><div class='form-element'>";
                if ($firstIndex) {echo "<label>Volunteer:</label>";}
                echo "<input type='text' name='volunteers[]' list='volunteer-list' value='{$volunteer}' onclick='select();'>";
                echo "</div></div>";
                $firstIndex = false;
              }
            } else {
              echo "<div class='form-section'><div class='form-element'>";
              echo "<label>Role:</label><input type='text' name='volunteer-roles[]' list='volunteer-role-list' value='' onclick='select();'>";
              echo "</div><div class='form-element'>";
              echo "<label>Volunteer:</label><input type='text' name='volunteers[]' list='volunteer-list' value='' onclick='select();'>";
              echo "</div></div>";
            }
          ?>
        </div>
        <div class="form-section">
          <div class="form-element">
            <button type="button" id="add-volunteer-button" onclick="newVolunteerFunction();">Add Volunteer</button>
          </div>
        </div>
      </div>





      <div class="form-section">
        <h3>Remove Class:</h3>
      </div>
      <div class="form-section remove-section">
        <div class="form-element">
          <h4>Archive:
            <input type="checkbox" name="archive" value="TRUE">
          </h4>
          <p>Saves class in database but removes from all schedules and menus</p>
        </div>
        <div class="form-element">
          <h4>
            Delete:
            <input type="checkbox" id="delete-checkbox" name="DELETE" value="TRUE">
          </h4>
          <p>WARNING: this will permanently delete all record of the class</p>
        </div>
      </div>



      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.location.href = ../">Cancel</button>
        <button type="submit" <?php if ($pastClass) {echo "disabled";} ?>>Submit</button>
      </div>      


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
        newFormSection = document.createElement('div');
        newFormSection.setAttribute('class', 'form-section');
        var staffSection = document.getElementById('staff-section');
        staffSection.appendChild(newFormSection);
        //add role selector
        newFormElement = document.createElement('div');
        newFormElement.setAttribute('class', 'form-element');
        newFormSection.appendChild(newFormElement);
        newInput = document.createElement('input');
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'staff-roles[]');
        newInput.setAttribute('list', 'staff-role-list');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        newFormElement.appendChild(newInput);
        //Add name selector
        newFormElement2 = document.createElement('div');
        newFormElement2.setAttribute('class', 'form-element');
        newFormSection.appendChild(newFormElement2);
        newInput2 = document.createElement('input');
        newInput2.setAttribute('type', 'text');
        newInput2.setAttribute('name', 'staff[]');
        newInput2.setAttribute('list', 'staff-list');
        newInput2.setAttribute('value', '');
        newInput2.setAttribute('onclick', 'select()');
        newInput2.setAttribute('form', 'class-form');
        newFormElement2.appendChild(newInput2);
      };

    



    function newClientHorseSection() {
        newSection = document.createElement('div');
        newSection.setAttribute('class', 'client-horse-form-section');
        parent = document.getElementById('client-horse-section');
        parent.appendChild(newSection);
        //Add client
        newClient(newSection);
        //Add Horse
        newHorse(newSection);
        //Add Tack
        newTack(newSection);
        //Add Pad
        newPad(newSection);
        //Add Tack Notes
        newTackNotes(newSection);
        //Add Equipment Notes
        newEquipmentNotes(newSection);
    };


    function newClient(section) {
        newFormElement = document.createElement('div');
        newFormElement.setAttribute('class', 'form-element');
        newInput = document.createElement('input');
        newFormElement.appendChild(newInput);
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'clients[]');
        newInput.setAttribute('list', 'client-list');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        section.appendChild(newFormElement);
    };

    function newHorse(section) {
        newFormElement = document.createElement('div');
        newFormElement.setAttribute('class', 'form-element');
        newInput = document.createElement('input');
        newFormElement.appendChild(newInput);
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'horses[]');
        newInput.setAttribute('list', 'horse-list');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        section.appendChild(newFormElement);
    };

    function newTack(section) {
        newFormElement = document.createElement('div');
        newFormElement.setAttribute('class', 'form-element');
        newInput = document.createElement('input');
        newFormElement.appendChild(newInput);
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'tacks[]');
        newInput.setAttribute('list', 'tack-list');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        section.appendChild(newFormElement);
    };

    function newPad(section) {
        newFormElement = document.createElement('div');
        newFormElement.setAttribute('class', 'form-element');
        newInput = document.createElement('input');
        newFormElement.appendChild(newInput);
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'pads[]');
        newInput.setAttribute('list', 'pad-list');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        section.appendChild(newFormElement);
    };
    function newTackNotes(section) {
        newFormElement = document.createElement('div');
        newFormElement.setAttribute('class', 'form-element');
        newInput = document.createElement('input');
        newFormElement.appendChild(newInput);
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'tack-notes[]');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        section.appendChild(newFormElement);
    };
    function newEquipmentNotes(section) {
        newFormElement = document.createElement('div');
        newFormElement.setAttribute('class', 'form-element');
        newInput = document.createElement('input');
        newFormElement.appendChild(newInput);
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'client-equipment-notes[]');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        section.appendChild(newFormElement);
    };






    function newVolunteerFunction() {
        newFormSection = document.createElement('div');
        newFormSection.setAttribute('class', 'form-section');
        //Add role selector
        newFormElement = document.createElement('div');
        newFormSection.appendChild(newFormElement);
        newFormElement.setAttribute('class', 'form-element');
        newInput = document.createElement('input');
        newFormElement.appendChild(newInput);
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'volunteer-roles[]');
        newInput.setAttribute('list', 'volunteer-role-list');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        newInput.setAttribute('form', 'class-form');
        //Add name selector
        newFormElement2 = document.createElement('div');
        newFormSection.appendChild(newFormElement2);
        newFormElement2.setAttribute('class', 'form-element');
        newInput2 = document.createElement('input');
        newFormElement2.appendChild(newInput2);
        newInput2.setAttribute('type', 'text');
        newInput2.setAttribute('name', 'volunteers[]');
        newInput2.setAttribute('list', 'volunteer-list');
        newInput2.setAttribute('value', '');
        newInput2.setAttribute('onclick', 'select()');
        newInput2.setAttribute('form', 'class-form');
        var volunteerSection = document.getElementById('volunteer-section');
        volunteerSection.appendChild(newFormSection);
    };






    // VALIDATE START AND END DATE SELECTIONS
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



</body>

</html>
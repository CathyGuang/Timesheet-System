<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | New Class</title>
</head>

<body>

  <header>
    <h1>New Class</h1>
    <nav> <a href="../../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    // CREATE ARRAY FROM OLD POST DATA TO FILL IN FIELDS
    $oldPostData = unserialize(base64_decode($_POST['old-post']));
  ?>

  <div class="form-container">
  <form autocomplete="off" id="class-form" action="create-new-class.php" method="post" class="standard-form standard-form">
    
    <div class="form-section">
      <h3 class="form-header">Class Info: </h3>
    </div>

    <div class="form-section">
      <div class="form-element">
        <label for="class-type">Class Type:</label>
        <input type="text" name="class-type" id="class-type"value="<?php echo $oldPostData['class-type']; ?>" list="class-type-list" onclick="select();" required>
      </div>
    </div>

    <div class="form-section">
      <div class="form-element">
        <label for="display-title">Display Title:</label>
        <input type="text" name="display-title" id="display-title" value="<?php echo htmlspecialchars($oldPostData['display-title'], ENT_QUOTES); ?>" onclick="select();" required>
      </div>
    </div>

    <div class="form-section">
      <h3 class="form-header">Dates: </h3>
    </div>
    <div class="form-section">
      <div class="form-element">
        <label>Every other week: <input type="checkbox" name="every-other-week" value="TRUE"></label>
      </div>
        <div class="form-element">
        <label for="start-date">Start date:</label>
        <input type="date" id="start-date" name="start-date" value="<?php echo $oldPostData['start-date']; ?>" placeholder="from" required>
      </div>
      <div class="form-element">
        <label for="end-date">End date:</label>
        <input type="date" id="end-date" name="end-date" value="<?php echo $oldPostData['end-date']; ?>" placeholder="to" required>
      </div>
    </div>

    <div class="form-section">         
        <!-- MONDAY-->
      <div class="form-element">
        <label for="monday-checkbox">Monday: </label>
        <input type="checkbox" id="monday-checkbox" name="monday-checkbox" value="Monday" <?php if ($oldPostData['monday-checkbox']) {echo "checked";} ?>>
      </div>
      <div class="form-element">
        <label for="monday-start-time">from:</label>
        <input type="time" id="monday-start-time" name="monday-start-time" value="<?php echo $oldPostData['monday-start-time']; ?>">
      </div>
      <div class="form-element">
        <label for="monday-end-time">to:</label>
        <input type="time" id="monday-end-time" name="monday-end-time" value="<?php echo $oldPostData['monday-end-time']; ?>">
      </div>
    </div>
    <div class="form-section">
        <!-- TUESDAY-->
      <div class="form-element">
        <label for="tuesday-checkbox">Tuesday: </label>
        <input type="checkbox" id="tuesday-checkbox" name="tuesday-checkbox" value="Tuesday" <?php if ($oldPostData['tuesday-checkbox']) {echo "checked";} ?>>
      </div>
      <div class="form-element">
        <label for="tuesday-start-time">from:</label>
        <input type="time" id="tuesday-start-time" name="tuesday-start-time" value="<?php echo $oldPostData['tuesday-start-time']; ?>">
      </div>
      <div class="form-element">
        <label for="tuesday-end-time">to:</label>
        <input type="time" id="tuesday-end-time" name="tuesday-end-time" value="<?php echo $oldPostData['tuesday-end-time']; ?>">
      </div>
    </div>
    <div class="form-section">
        <!-- WEDNESDAY-->
      <div class="form-element">
        <label for="wednesday-checkbox">Wednesday: </label>
        <input type="checkbox" id="wednesday-checkbox" name="wednesday-checkbox" value="Wednesday" <?php if ($oldPostData['wednesday-checkbox']) {echo "checked";} ?>>
      </div>
      <div class="form-element">
        <label for="wednesday-start-time">from:</label>
        <input type="time" id="wednesday-start-time" name="wednesday-start-time" value="<?php echo $oldPostData['wednesday-start-time']; ?>">
      </div>
      <div class="form-element">
        <label for="wednesday-end-time">to:</label>
        <input type="time" id="wednesday-end-time" name="wednesday-end-time" value="<?php echo $oldPostData['wednesday-end-time']; ?>">
      </div>
      </div>
    <div class="form-section">
        <!-- THURSDAY-->
      <div class="form-element">
        <label for="thursday-checkbox">Thursday: </label>
        <input type="checkbox" id="thursday-checkbox" name="thursday-checkbox" value="Thursday" <?php if ($oldPostData['thursday-checkbox']) {echo "checked";} ?>>
      </div>
      <div class="form-element">
        <label for="thursday-start-time">from:</label>
        <input type="time" id="thursday-start-time" name="thursday-start-time" value="<?php echo $oldPostData['thursday-start-time']; ?>">
      </div>
      <div class="form-element">
        <label for="thursday-end-time">to:</label>
        <input type="time" id="thursday-end-time" name="thursday-end-time" value="<?php echo $oldPostData['thursday-end-time']; ?>">
      </div>
    </div>
    <div class="form-section">
        <!-- FRIDAY-->
      <div class="form-element">
        <label for="friday-checkbox">Friday: </label>
        <input type="checkbox" id="friday-checkbox" name="friday-checkbox" value="Friday" <?php if ($oldPostData['friday-checkbox']) {echo "checked";} ?>>
      </div>
      <div class="form-element">
        <label for="friday-start-time">from:</label>
        <input type="time" id="friday-start-time" name="friday-start-time" value="<?php echo $oldPostData['friday-start-time']; ?>">
      </div>
      <div class="form-element">
        <label for="friday-end-time">to:</label>
        <input type="time" id="friday-end-time" name="friday-end-time" value="<?php echo $oldPostData['friday-end-time']; ?>">
      </div>
    </div>
    <div class="form-section">
        <!-- SATURDAY-->
      <div class="form-element">
        <label for="saturday-checkbox">Saturday: </label>
        <input type="checkbox" id="saturday-checkbox" name="saturday-checkbox" value="Saturday" <?php if ($oldPostData['saturday-checkbox']) {echo "checked";} ?>>
      </div>
      <div class="form-element">
        <label for="saturday-start-time">from:</label>
        <input type="time" id="saturday-start-time" name="saturday-start-time" value="<?php echo $oldPostData['saturday-start-time']; ?>">
      </div>
      <div class="form-element">
        <label for="saturday-end-time">to:</label>
        <input type="time" id="saturday-end-time" name="saturday-end-time" value="<?php echo $oldPostData['saturday-end-time']; ?>">
      </div>
    </div>
    <div class="form-section">
        <!-- SUNDAY-->
      <div class="form-element">
        <label for="sunday-checkbox">Sunday: </label>
        <input type="checkbox" id="sunday-checkbox" name="sunday-checkbox" value="Sunday" <?php if ($oldPostData['sunday-checkbox']) {echo "checked";} ?>>
      </div>
      <div class="form-element">
        <label for="sunday-start-time">from:</label>
        <input type="time" id="sunday-start-time" name="sunday-start-time" value="<?php echo $oldPostData['sunday-start-time']; ?>">
      </div>
      <div class="form-element">
        <label for="sunday-end-time">to:</label>
        <input type="time" id="sunday-end-time" name="sunday-end-time" value="<?php echo $oldPostData['sunday-end-time']; ?>">
      </div>
    </div>



    <div class="form-section">
      <h3 class="form-header">Location: </h3>
    </div>

    <div class="form-section">
      <div class="form-element">
        <label>Arena:</label>
        <input type="text" name="arena" list="arena-list" value="<?php echo $oldPostData['arena']; ?>" onclick="select();">
      </div>
    </div>


    <div>
      <div id="staff-section">
        <div class="form-section">
          <h3>Staff:</h3>
        </div>

        <?php
          if ($oldPostData['staff-roles']) {
            foreach ($oldPostData['staff-roles'] as $index => $role) {
              $staffName = htmlspecialchars($oldPostData['staff'][$index], ENT_QUOTES);
              echo "<div class='form-section'><div class='form-element'>";
              echo "<label>Role: </label><input form='class-form' type='text' name='staff-roles[]' list='staff-role-list' value='{$role}' onclick='select();'>";
              echo "</div><div class='form-element'";
              echo "<label>Staff Member: </label><input form='class-form' type='text' name='staff[]' list='staff-list' value='{$staffName}' onclick='select();'>";
              echo "</div></div>";
            }
          } else {
            echo "<div class='form-section'><div class='form-element'>";
            echo "<label>Role: </label><input form='class-form' type='text' name='staff-roles[]' list='staff-role-list' value='' onclick='select();'>";
            echo "</div><div class='form-element'";
            echo "<label>Staff Member: </label><input form='class-form' type='text' name='staff[]' list='staff-list' value='' onclick='select();'>";
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
        $index = 0;
        while (true) {
          

          if ($oldPostData['clients'][$index]) {
            $client = htmlspecialchars($oldPostData['clients'][$index], ENT_QUOTES);
          } else {
            $client = "";
          }

          if ($oldPostData['horses']) {
            $horse = htmlspecialchars($oldPostData['horses'][$index], ENT_QUOTES);
          } else {
            $horse = "";
          }

          if ($oldPostData['tacks']) {
            $tack = htmlspecialchars($oldPostData['tacks'][$index], ENT_QUOTES);
          } else {
            $tack = "";
          }

          if ($oldPostData['pads']) {
            $pad = htmlspecialchars($oldPostData['pads'][$index], ENT_QUOTES);
          } else {
            $pad = "";
          }

          if ($oldPostData['tack-notes']) {
            $note = htmlspecialchars($oldPostData['tack-notes'][$index], ENT_QUOTES);
          } else {
            $note = "";
          }

          if ($oldPostData['client-equipment-notes']) {
            $clientNote = htmlspecialchars($oldPostData['client-equipment-notes'][$index], ENT_QUOTES);
          } else {
            $clientNote = "";
          }


          echo <<<EOF
          <div class="client-horse-form-section">
            
            <div class="form-element">
              <label>Client:</label>
              <input form='class-form' type='text' name='clients[]' list='client-list' value='{$client}' onclick='select();'>
            </div>

            <div class="form-element">
              <label>Horse:</label>
              <input form='class-form' type='text' name='horses[]' list='horse-list' value='{$horse}' onclick='select();'>
            </div>

            <div class="form-element">
              <label>Tack:</label>
              <input form='class-form' type='text' name='tacks[]' list='tack-list' value='{$tack}' onclick='select();'>
            </div>

            <div class="form-element">
              <label>Pad:</label>
              <input form='class-form' type='text' name='pads[]' list='pad-list' value='{$pad}' onclick='select();'>
            </div>

            <div class="form-element">
              <label>Tack Notes:</label>
              <input form='class-form' type='text' name='tack-notes[]' value='{$note}' onclick='select();'>
            </div>

            <div class="form-element">
              <label>Equipment Notes:</label>
              <input form='class-form' type='text' name='client-equipment-notes[]' value='{$note}' onclick='select();'>
            </div>


          </div>
EOF;

          // Check for remaining POST data, if done, exit loop
          if (empty($oldPostData['clients'][$index]) && empty($oldPostData['horses'][$index]) && empty($oldPostData['tacks'][$index]) && empty($oldPostData['pads'][$index]) && empty($oldPostData['tack-notes'][$index]) && empty($oldPostData['client-equipment-notes'][$index])) {
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


     

    <div>
      <div id="volunteer-section">
        <div class="form-section">
          <h3>Volunteers:</h3>
        </div>
        <?php
          if ($oldPostData['volunteer-roles']) {
            foreach ($oldPostData['volunteer-roles'] as $index => $role) {
              $volunteer = htmlspecialchars($oldPostData['volunteers'][$index], ENT_QUOTES);
              $role = htmlspecialchars($role, ENT_QUOTES);
              echo "<div class='form-section'><div class='form-element'>";
              echo "<label>Role:</label><input form='class-form' type='text' name='volunteer-roles[]' list='volunteer-role-list' value='{$role}' onclick='select();'>";
              echo "</div><div class='form-element'>";
              echo "<label>Volunteer:</label><input form='class-form' type='text' name='volunteers[]' list='volunteer-list' value='{$volunteer}' onclick='select();'>";
              echo "</div></div>";
            }
          } else {
            echo "<div class='form-section'><div class='form-element'>";
              echo "<label>Role:</label><input form='class-form' type='text' name='volunteer-roles[]' list='volunteer-role-list' value='' onclick='select();'>";
              echo "</div><div class='form-element'>";
              echo "<label>Volunteer:</label><input form='class-form' type='text' name='volunteers[]' list='volunteer-list' value='' onclick='select();'>";
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
        <button type="button" class="cancel-form" onclick="window.history.back(2)">Cancel</button>
        <button type="submit">Create</button>
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
      newLabel = document.createElement('label');
      newLabel.innerHTML = "Role: ";
      newFormElement.appendChild(newLabel);
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
      newLabel2 = document.createElement('label');
      newLabel2.innerHTML = "Staff Member: ";
      newFormElement2.appendChild(newLabel2);
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
      } else if (this.value > endDateSelector.value && endDateSelector.value != "") {
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

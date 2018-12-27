<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | New Class</title>
</head>

<body>

  <header>
    <h1>New Class</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <form autocomplete="off" id="class-form" action="create-new-class.php" method="post" class="main-form full-page-form">

    <p>Class Type:</p>
    <input type="text" name="class-type" list="class-type-list" onclick="select()" required>
      <datalist id="class-type-list">
        <?php
          $query = "SELECT unnest(enum_range(NULL::CLASS_TYPE))::text EXCEPT SELECT name FROM archived_enums;";
          $result = pg_query($db_connection, $query);
          $classTypeNames = pg_fetch_all_columns($result);
          foreach ($classTypeNames as $key => $value) {
            echo "<option value='$value'>";
          }
        ?>
      </datalist>

    <p>Dates: </p>
    <p style="font-size: 12pt; margin-top: 0; margin-bottom: 12px;">Every other week: <input type="checkbox" name="every-other-week" value="TRUE"></p>
    <div style="max-width: 500px;">
      <label for="start-date">Start date:</label>
      <input type="date" id="start-date" name="start-date" value="" placeholder="from" required>
      <label for="end-date">End date:</label>
      <input type="date" id="end-date" name="end-date" value="" placeholder="to" required>
    </div>

    <div style="max-width: 440px;">
      <!-- MONDAY-->
      <label for="monday-checkbox">Monday: </label>
      <input type="checkbox" id="monday-checkbox" name="monday-checkbox" value="Monday">
      <label for="monday-start-time">from:</label>
      <input type="time" id="monday-start-time" name="monday-start-time">
      <label for="monday-end-time">to:</label>
      <input type="time" id="monday-end-time" name="monday-end-time">
      <!-- TUESDAY-->
      <label for="tuesday-checkbox">Tuesday: </label>
      <input type="checkbox" id="tuesday-checkbox" name="tuesday-checkbox" value="Tuesday">
      <label for="tuesday-start-time">from:</label>
      <input type="time" id="tuesday-start-time" name="tuesday-start-time">
      <label for="tuesday-end-time">to:</label>
      <input type="time" id="tuesday-end-time" name="tuesday-end-time">
      <!-- WEDNESDAY-->
      <label for="wednesday-checkbox">Wednesday: </label>
      <input type="checkbox" id="wednesday-checkbox" name="wednesday-checkbox" value="Wednesday">
      <label for="wednesday-start-time">from:</label>
      <input type="time" id="wednesday-start-time" name="wednesday-start-time">
      <label for="wednesday-end-time">to:</label>
      <input type="time" id="wednesday-end-time" name="wednesday-end-time">
      <!-- THURSDAY-->
      <label for="thursday-checkbox">Thursday: </label>
      <input type="checkbox" id="thursday-checkbox" name="thursday-checkbox" value="Thursday">
      <label for="thursday-start-time">from:</label>
      <input type="time" id="thursday-start-time" name="thursday-start-time">
      <label for="thursday-end-time">to:</label>
      <input type="time" id="thursday-end-time" name="thursday-end-time">
      <!-- FRIDAY-->
      <label for="friday-checkbox">Friday: </label>
      <input type="checkbox" id="friday-checkbox" name="friday-checkbox" value="Friday">
      <label for="friday-start-time">from:</label>
      <input type="time" id="friday-start-time" name="friday-start-time">
      <label for="friday-end-time">to:</label>
      <input type="time" id="friday-end-time" name="friday-end-time">
      <!-- SATURDAY-->
      <label for="saturday-checkbox">Saturday: </label>
      <input type="checkbox" id="saturday-checkbox" name="saturday-checkbox" value="Saturday">
      <label for="saturday-start-time">from:</label>
      <input type="time" id="saturday-start-time" name="saturday-start-time">
      <label for="saturday-end-time">to:</label>
      <input type="time" id="saturday-end-time" name="saturday-end-time">
      <!-- SUNDAY-->
      <label for="sunday-checkbox">Sunday: </label>
      <input type="checkbox" id="sunday-checkbox" name="sunday-checkbox" value="Sunday">
      <label for="sunday-start-time">from:</label>
      <input type="time" id="sunday-start-time" name="sunday-start-time">
      <label for="sunday-end-time">to:</label>
      <input type="time" id="sunday-end-time" name="sunday-end-time">
    </div>


    <p>Arena:</p>
    <input type="text" name="arena" list="arena-list" value="" onclick="select();">
      <datalist id="arena-list">
        <?php
          $query = "SELECT unnest(enum_range(NULL::ARENA))::text EXCEPT SELECT name FROM archived_enums;";
          $result = pg_query($db_connection, $query);
          $arenaNames = pg_fetch_all_columns($result);
          foreach ($arenaNames as $key => $value) {
            echo "<option value='$value'>";
          }
        ?>
      </datalist>




    <p>Special Tack:</p>
    <input type="text" name="special-tack">

    <p>Stirrup Leather Length:</p>
    <input type="text" name="stirrup-leather-length">




    <div>
      <div id="staff-section">
        <p>Staff:</p>

        <label>Role: </label>
        <input form="class-form" type="text" name="staff-roles[]" list="staff-role-list" value="" onclick="select();">
          <datalist id="staff-role-list">
            <?php
              $query = "SELECT unnest(enum_range(NULL::STAFF_CLASS_ROLE))::text EXCEPT SELECT name FROM archived_enums;";
              $result = pg_query($db_connection, $query);
              $classTypeNames = pg_fetch_all_columns($result);
              foreach ($classTypeNames as $key => $value) {
                echo "<option value='$value'>";
              }
            ?>
          </datalist>

        <br>
        <label>Staff Member: </label>
        <input form="class-form" type="text" name="staff[]" list="staff-list" value="" onclick="select();">
          <datalist id="staff-list">
            <?php
              $query = "SELECT name FROM workers WHERE staff = TRUE AND (archived IS NULL OR archived = '');";
              $result = pg_query($db_connection, $query);
              $staffNames = pg_fetch_all_columns($result);
              foreach ($staffNames as $key => $value) {
                echo "<option value='$value'>";
              }
            ?>
          </datalist>
      </div>
      <br>
      <button type="button" id="add-staff-button" onclick="newStaffFunction();">Add Additional Staff Member</button>
    </div>




    <br><br>
    <input type="submit" value="Create">

  </form>



  <div style="display:flex; justify-content:space-around;">

    <div>
      <div id="horse-section">
        <p>Horse(s):</p>
        <input form="class-form" type="text" name="horses[]" list="horse-list" value="" onclick="select();">
          <datalist id="horse-list">
            <?php
              $query = "SELECT name FROM horses WHERE (archived IS NULL OR archived = '');";
              $result = pg_query($db_connection, $query);
              $horseNames = pg_fetch_all_columns($result);
              foreach ($horseNames as $key => $value) {
                echo "<option value='$value'>";
              }
            ?>
          </datalist>
      </div>
      <br>
      <button type="button" id="add-horse-button" onclick="newHorseFunction();">Add Additional Horse</button>
    </div>

    <div>
      <div id="tack-section">
        <p>Tack(s):</p>
        <input form="class-form" type="text" name="tacks[]" list="tack-list" value="" onclick="select();">
          <datalist id="tack-list">
            <?php
              $query = "SELECT unnest(enum_range(NULL::TACK))::text EXCEPT SELECT name FROM archived_enums;";
              $result = pg_query($db_connection, $query);
              $tackNames = pg_fetch_all_columns($result);
              foreach ($tackNames as $key => $value) {
                echo "<option value='$value'>";
              }
            ?>
          </datalist>
      </div>
      <br>
      <button type="button" id="add-tack-button" onclick="newTackFunction();">Add Additional Tack</button>
    </div>

    <div>
      <div id="pad-section">
        <p>Pad(s):</p>
        <input form="class-form" type="text" name="pads[]" list="pad-list" value="" onclick="select();">
          <datalist id="pad-list">
            <?php
              $query = "SELECT unnest(enum_range(NULL::PAD))::text EXCEPT SELECT name FROM archived_enums;";
              $result = pg_query($db_connection, $query);
              $padNames = pg_fetch_all_columns($result);
              foreach ($padNames as $key => $value) {
                echo "<option value='$value'>";
              }
            ?>
          </datalist>
      </div>
      <br>
      <button type="button" id="add-pad-button" onclick="newPadFunction();">Add Additional Pad</button>
    </div>



    <div>
      <div id="client-section">
        <p>Client(s):</p>
        <input form="class-form" type="text" name="clients[]" list="client-list" value="" onclick="select();">
          <datalist id="client-list">
            <?php
              $query = "SELECT name FROM clients WHERE (archived IS NULL OR archived = '');";
              $result = pg_query($db_connection, $query);
              $clientNames = pg_fetch_all_columns($result);
              foreach ($clientNames as $key => $value) {
                echo "<option value='$value'>";
              }
            ?>
          </datalist>
      </div>
      <br>
      <button type="button" id="add-client-button" onclick="newClientFunction();">Add Additional Client</button>
    </div>

    <div>
      <div id="leader-section">
        <p>Leader(s):</p>
        <input form="class-form" type="text" name="leaders[]" list="leader-list" value="" onclick="select();">
          <datalist id="leader-list">
            <?php
              $query = "SELECT name FROM workers WHERE (archived IS NULL OR archived = '');";
              $result = pg_query($db_connection, $query);
              $workerNames = pg_fetch_all_columns($result);
              foreach ($workerNames as $key => $value) {
                echo "<option value='$value'>";
              }
            ?>
          </datalist>
        </div>
        <br>
        <button type="button" id="add-leader-button" onclick="newLeaderFunction();">Add Additional Leader</button>
      </div>


    <div>
      <div id="sidewalker-section">
        <p>Sidewalker(s):</p>
        <input form="class-form" type="text" name="sidewalkers[]" list="sidewalker-list" value="" onclick="select();">
          <datalist id="sidewalker-list">
            <?php
              $query = "SELECT name FROM workers WHERE (archived IS NULL OR archived = '');";
              $result = pg_query($db_connection, $query);
              $workerNames = pg_fetch_all_columns($result);
              foreach ($workerNames as $key => $value) {
                echo "<option value='$value'>";
              }
            ?>
          </datalist>
        </div>
        <br>
        <button type="button" id="add-sidewalker-button" onclick="newSidewalkerFunction();">Add Additional Sidewalker</button>
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

      function newLeaderFunction() {
          newInput = document.createElement('input');
          newInput.setAttribute('type', 'text');
          newInput.setAttribute('name', 'leaders[]');
          newInput.setAttribute('list', 'leader-list');
          newInput.setAttribute('value', '');
          newInput.setAttribute('onclick', 'select()');
          newInput.setAttribute('form', 'class-form');
          var leaderSection = document.getElementById('leader-section');
          leaderSection.appendChild(newInput);
        };

    function newSidewalkerFunction() {
      newInput = document.createElement('input');
      newInput.setAttribute('type', 'text');
      newInput.setAttribute('name', 'sidewalkers[]');
      newInput.setAttribute('list', 'sidewalker-list');
      newInput.setAttribute('value', '');
      newInput.setAttribute('onclick', 'select()');
      newInput.setAttribute('form', 'class-form');
      var sidewalkerSection = document.getElementById('sidewalker-section');
      sidewalkerSection.appendChild(newInput);
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

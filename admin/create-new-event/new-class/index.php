<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/connectdb.php";?>
  <title>Admin | New Class</title>
</head>

<body>

  <header>
    <h1>New Class</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <form action="create-new-class.php" method="post" class="main-form full-page-form">

    <p>Class Type:</p>
    <input type="text" name="class-type" list="class-type-list" onclick="select()" required>
      <datalist id="class-type-list">
        <?php
          $query = "SELECT unnest(enum_range(NULL::CLASS_TYPE))";
          $result = pg_query($db_connection, $query);
          $classTypeNames = pg_fetch_all_columns($result);
          foreach ($classTypeNames as $key => $value) {
            echo "<option value='$value'>";
          }
        ?>
      </datalist>

    <p>Dates:</p>
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
          $query = "SELECT unnest(enum_range(NULL::ARENA))";
          $result = pg_query($db_connection, $query);
          $arenaNames = pg_fetch_all_columns($result);
          foreach ($arenaNames as $key => $value) {
            echo "<option value='$value'>";
          }
        ?>
      </datalist>

    <p>Horse:</p>
    <input type="text" name="horse" list="horse-list" value="" onclick="select();">
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

    <p>Tack:</p>
    <input type="text" name="tack" list="tack-list" value="" onclick="select();">
      <datalist id="tack-list">
        <?php
          $query = "SELECT unnest(enum_range(NULL::TACK))";
          $result = pg_query($db_connection, $query);
          $tackNames = pg_fetch_all_columns($result);
          foreach ($tackNames as $key => $value) {
            echo "<option value='$value'>";
          }
        ?>
      </datalist>

    <p>Special Tack:</p>
    <input type="text" name="special-tack">

    <p>Stirrup Leather Length:</p>
    <input type="text" name="stirrup-leather-length">

    <p>Pad:</p>
    <input type="text" name="pad" list="pad-list" value="" onclick="select();">
      <datalist id="pad-list">
        <?php
          $query = "SELECT unnest(enum_range(NULL::PAD))";
          $result = pg_query($db_connection, $query);
          $padNames = pg_fetch_all_columns($result);
          foreach ($padNames as $key => $value) {
            echo "<option value='$value'>";
          }
        ?>
      </datalist>
    <div id="client-section">
      <p>Client(s):</p>
      <input type="text" name="clients[]" list="client-list" value="" onclick="select();">
        <datalist id="client-list">
          <?php
            $query = "SELECT name FROM clients;";
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

    <p>Instructor:</p>
    <input type="text" name="instructor" list="instructor-list" value="" onclick="select();">
      <datalist id="instructor-list">
        <?php
          $query = "SELECT name FROM workers;";
          $result = pg_query($db_connection, $query);
          $workerNames = pg_fetch_all_columns($result);
          foreach ($workerNames as $key => $value) {
            echo "<option value='$value'>";
          }
        ?>
      </datalist>

    <p>Therapist:</p>
    <input type="text" name="therapist" list="therapist-list" value="" onclick="select();">
      <datalist id="therapist-list">
        <?php
          $query = "SELECT name FROM workers;";
          $result = pg_query($db_connection, $query);
          $workerNames = pg_fetch_all_columns($result);
          foreach ($workerNames as $key => $value) {
            echo "<option value='$value'>";
          }
        ?>
      </datalist>

    <p>ES:</p>
    <input type="text" name="equine-specialist" list="es-list" value="" onclick="select();">
      <datalist id="es-list">
        <?php
          $query = "SELECT name FROM workers;";
          $result = pg_query($db_connection, $query);
          $workerNames = pg_fetch_all_columns($result);
          foreach ($workerNames as $key => $value) {
            echo "<option value='$value'>";
          }
        ?>
      </datalist>

    <p>Leader:</p>
    <input type="text" name="leader" list="leader-list" value="" onclick="select();">
      <datalist id="leader-list">
        <?php
          $query = "SELECT name FROM workers;";
          $result = pg_query($db_connection, $query);
          $workerNames = pg_fetch_all_columns($result);
          foreach ($workerNames as $key => $value) {
            echo "<option value='$value'>";
          }
        ?>
      </datalist>

      <div id="sidewalker-section">
        <p>Sidewalker(s):</p>
        <input type="text" name="sidewalkers[]" list="sidewalker-list" value="" onclick="select();">
          <datalist id="sidewalker-list">
            <?php
              $query = "SELECT name FROM workers;";
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




    <br><br>
    <input type="submit" value="Create">

  </form>


  <footer>
    <script type="text/javascript">
    function newClientFunction() {
        newInput = document.createElement('input');
        newInput.setAttribute('type', 'text');
        newInput.setAttribute('name', 'clients[]');
        newInput.setAttribute('list', 'client-list');
        newInput.setAttribute('value', '');
        newInput.setAttribute('onclick', 'select()');
        var clientSection = document.getElementById('client-section');
        clientSection.appendChild(newInput);
      };

    function newSidewalkerFunction() {
      newInput = document.createElement('input');
      newInput.setAttribute('type', 'text');
      newInput.setAttribute('name', 'sidewalkers[]');
      newInput.setAttribute('list', 'sidewalker-list');
      newInput.setAttribute('value', '');
      newInput.setAttribute('onclick', 'select()');
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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/connectdb.php";?>
  <title>Admin | Edit Office Shift</title>
</head>

<body>

  <header>
    <h1>Edit Office Shift</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>



  <?php
    if ($_POST['selected-shift']) {
      echo "<h3 class='main-content-header'>{$_POST['selected-shift']}</h3>";
      $selectedShiftType = explode(', ', $_POST['selected-shift'])[0];
      $selectedLeaderName = explode(', ', $_POST['selected-shift'])[1];

      $getShiftIDsQuery = "SELECT DISTINCT office_shifts.id FROM office_shifts, workers WHERE office_shift_type = '$selectedShiftType' AND leader = (SELECT id FROM workers WHERE name LIKE '$selectedLeaderName');";
      $shiftIDSQLObject = pg_fetch_all(pg_query($db_connection, $getShiftIDsQuery));
      foreach ($shiftIDSQLObject as $row => $data) {
        $shiftIDList[] = $data['id'];
      }

      $shiftDataQuery = "SELECT * FROM office_shifts WHERE office_shifts.id = {$shiftIDList[0]};";

      $shiftData = pg_fetch_array(pg_query($db_connection, $shiftDataQuery), 0, PGSQL_ASSOC);

      $startDate = pg_fetch_array(pg_query($db_connection, "SELECT MIN (date_of_shift) AS start_date FROM office_shifts;"), 0, 1)['start_date'];
      $endDate = pg_fetch_array(pg_query($db_connection, "SELECT MAX (date_of_shift) AS end_date FROM office_shifts;"), 0, 1)['end_date'];


      $weekdaysBlocks = explode(";", $shiftData['all_weekdays_times']);
      $allWeekdaysTimesList = array();
      foreach ($weekdaysBlocks as $weekdayString) {
        if ($weekdayString == "") {continue;}
        $weekdayTriple = explode(",", $weekdayString);
        $allWeekdaysTimesList[$weekdayTriple[0]] = array($weekdayTriple[1], $weekdayTriple[2]);
      }

      $checkboxList = array("Monday" => "", "Tuesday" => "", "Wednesday" => "", "Thursday" => "", "Friday" => "", "Saturday" => "", "Sunday" => "", );
      foreach ($allWeekdaysTimesList as $day => $times) {
        $checkboxList[$day] = "checked";
      }

      $leaderName = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE workers.id = {$shiftData['leader']};"), 0, 1)['name'];

      echo <<<EOT

      <form action="edit-office-shift.php" method="post" class="main-form full-page-form">

        <div>
          <label for="delete-checkbox">Delete Shift? </label>
          <input type="checkbox" id="delete-checkbox" name="DELETE" value="TRUE">
        </div>

        <p>Shift Type:</p>
        <input type="text" name="old-shift-type" value="{$shiftData['office_shift_type']}" style="visibility: hidden;">
        <input type="text" name="shift-type" list="shift-type-list" value="{$shiftData['office_shift_type']}" onclick="select()" required>
          <datalist id="shift-type-list">
EOT;

              $query = "SELECT unnest(enum_range(NULL::OFFICE_SHIFT_TYPE))";
              $result = pg_query($db_connection, $query);
              $shiftTypeNames = pg_fetch_all_columns($result);
              foreach ($shiftTypeNames as $key => $value) {
                echo "<option value='$value'>";
              }

      echo <<<EOT
          </datalist>

        <p>Dates:</p>
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

        <p>Leader:</p>
        <input type="text" name="old-leader" value="{$leaderName}" style="visibility: hidden;">
        <input type="text" name="leader" list="leader-list" value="{$leaderName}" onclick="select();">
          <datalist id="leader-list">
EOT;

              $query = "SELECT name FROM workers;";
              $result = pg_query($db_connection, $query);
              $workerNames = pg_fetch_all_columns($result);
              foreach ($workerNames as $key => $value) {
                echo "<option value='$value'>";
              }
        echo <<<EOT
          </datalist>

          <div id="volunteer-section">
            <p>Volunteers:</p>

EOT;
          $volunteerIDList = explode(',', ltrim(rtrim($shiftData['volunteers'], "}"), '{'));
          foreach ($volunteerIDList as $id) {
            $volunteerName = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE workers.id = {$id}") , 0, 1)['name'];
            echo <<<EOT
            <input type="text" name="volunteers[]" list="volunteer-list" value="{$volunteerName}" onclick="select();">
EOT;
          }

          echo <<<EOT
              <datalist id="volunteer-list">
EOT;

                  $query = "SELECT name FROM workers;";
                  $result = pg_query($db_connection, $query);
                  $workerNames = pg_fetch_all_columns($result);
                  foreach ($workerNames as $key => $value) {
                    echo "<option value='$value'>";
                  }

          echo <<<EOT
              </datalist>
            </div>
            <br>
            <button type="button" id="add-volunteer-button" onclick="newVolunteerFunction();">Add Volunteer</button>

        <br><br>
        <input type="submit" value="Submit Changes">

      </form>

      <footer>
        <script type="text/javascript">
        function newVolunteerFunction() {
          newInput = document.createElement('input');
          newInput.setAttribute('type', 'text');
          newInput.setAttribute('name', 'volunteers[]');
          newInput.setAttribute('list', 'volunteer-list');
          newInput.setAttribute('value', '');
          newInput.setAttribute('onclick', 'select()');
          var volunteerSection = document.getElementById('volunteer-section');
          volunteerSection.appendChild(newInput);
        };
        </script>
      </footer>
EOT;

    } else {

    echo <<<EOT
      <form action="" method="post" class="main-form">
        <p>Select a shift to edit:</p>
        <input type="text" name="selected-shift" list="shift-list">
          <datalist id="shift-list">
EOT;
          $query = "SELECT DISTINCT office_shift_type, name FROM office_shifts, workers WHERE workers.id = office_shifts.leader;";
          $result = pg_query($db_connection, $query);
          while ($row = pg_fetch_row($result)) {
            echo "<option value='$row[0], $row[1]'>";
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

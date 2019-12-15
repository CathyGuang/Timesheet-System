<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | New Horse Care Shift</title>
</head>

<body>

  <header>
    <h1>New Horse Care Shift</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <?php if ($_POST['old-post']) {$oldPostData = unserialize(base64_decode($_POST['old-post']));} ?>

  <form autocomplete="off" action="create-new-horse-care-shift.php" method="post" class="standard-form standard-form">

    <p>Shift Type:</p>
    <input type="text" name="shift-type" value="<?php echo $oldPostData['shift-type']; ?>" list="shift-type-list" onclick="select()" required>
      <datalist id="shift-type-list">
        <?php
          $query = "SELECT unnest(enum_range(NULL::CARE_TYPE))::text EXCEPT SELECT name FROM archived_enums;";
          $result = pg_query($db_connection, $query);
          $careTypeNames = pg_fetch_all_columns($result);
          foreach ($careTypeNames as $key => $value) {
            $value = htmlspecialchars($value, ENT_QUOTES);
            echo "<option value='$value'>";
          }
        ?>
      </datalist>

    <p>Dates:</p>
    <div style="max-width: 500px;">
      <label for="start-date">Start date:</label>
      <input type="date" id="start-date" name="start-date" value="<?php echo $oldPostData['start-date']; ?>" placeholder="from" required>
      <label for="end-date">End date:</label>
      <input type="date" id="end-date" name="end-date" value="<?php echo $oldPostData['end-date']; ?>" placeholder="to" required>
    </div>

    <div style="max-width: 440px;">
      <!-- MONDAY-->
      <label for="monday-checkbox">Monday: </label>
      <input type="checkbox" id="monday-checkbox" name="monday-checkbox" value="Monday" <?php if ($oldPostData['monday-checkbox']) {echo "checked";} ?>>
      <label for="monday-start-time">from:</label>
      <input type="time" id="monday-start-time" name="monday-start-time" value="<?php echo $oldPostData['monday-start-time']; ?>">
      <label for="monday-end-time">to:</label>
      <input type="time" id="monday-end-time" name="monday-end-time" value="<?php echo $oldPostData['monday-end-time']; ?>">
      <!-- TUESDAY-->
      <label for="tuesday-checkbox">Tuesday: </label>
      <input type="checkbox" id="tuesday-checkbox" name="tuesday-checkbox" value="Tuesday" <?php if ($oldPostData['tuesday-checkbox']) {echo "checked";} ?>>
      <label for="tuesday-start-time">from:</label>
      <input type="time" id="tuesday-start-time" name="tuesday-start-time" value="<?php echo $oldPostData['tuesday-start-time']; ?>">
      <label for="tuesday-end-time">to:</label>
      <input type="time" id="tuesday-end-time" name="tuesday-end-time" value="<?php echo $oldPostData['tuesday-end-time']; ?>">
      <!-- WEDNESDAY-->
      <label for="wednesday-checkbox">Wednesday: </label>
      <input type="checkbox" id="wednesday-checkbox" name="wednesday-checkbox" value="Wednesday" <?php if ($oldPostData['wednesday-checkbox']) {echo "checked";} ?>>
      <label for="wednesday-start-time">from:</label>
      <input type="time" id="wednesday-start-time" name="wednesday-start-time" value="<?php echo $oldPostData['wednesday-start-time']; ?>">
      <label for="wednesday-end-time">to:</label>
      <input type="time" id="wednesday-end-time" name="wednesday-end-time" value="<?php echo $oldPostData['wednesday-end-time']; ?>">
      <!-- THURSDAY-->
      <label for="thursday-checkbox">Thursday: </label>
      <input type="checkbox" id="thursday-checkbox" name="thursday-checkbox" value="Thursday" <?php if ($oldPostData['thursday-checkbox']) {echo "checked";} ?>>
      <label for="thursday-start-time">from:</label>
      <input type="time" id="thursday-start-time" name="thursday-start-time" value="<?php echo $oldPostData['thursday-start-time']; ?>">
      <label for="thursday-end-time">to:</label>
      <input type="time" id="thursday-end-time" name="thursday-end-time" value="<?php echo $oldPostData['thursday-end-time']; ?>">
      <!-- FRIDAY-->
      <label for="friday-checkbox">Friday: </label>
      <input type="checkbox" id="friday-checkbox" name="friday-checkbox" value="Friday" <?php if ($oldPostData['friday-checkbox']) {echo "checked";} ?>>
      <label for="friday-start-time">from:</label>
      <input type="time" id="friday-start-time" name="friday-start-time" value="<?php echo $oldPostData['friday-start-time']; ?>">
      <label for="friday-end-time">to:</label>
      <input type="time" id="friday-end-time" name="friday-end-time" value="<?php echo $oldPostData['friday-end-time']; ?>">
      <!-- SATURDAY-->
      <label for="saturday-checkbox">Saturday: </label>
      <input type="checkbox" id="saturday-checkbox" name="saturday-checkbox" value="Saturday" <?php if ($oldPostData['saturday-checkbox']) {echo "checked";} ?>>
      <label for="saturday-start-time">from:</label>
      <input type="time" id="saturday-start-time" name="saturday-start-time" value="<?php echo $oldPostData['saturday-start-time']; ?>">
      <label for="saturday-end-time">to:</label>
      <input type="time" id="saturday-end-time" name="saturday-end-time" value="<?php echo $oldPostData['saturday-end-time']; ?>">
      <!-- SUNDAY-->
      <label for="sunday-checkbox">Sunday: </label>
      <input type="checkbox" id="sunday-checkbox" name="sunday-checkbox" value="Sunday" <?php if ($oldPostData['sunday-checkbox']) {echo "checked";} ?>>
      <label for="sunday-start-time">from:</label>
      <input type="time" id="sunday-start-time" name="sunday-start-time" value="<?php echo $oldPostData['sunday-start-time']; ?>">
      <label for="sunday-end-time">to:</label>
      <input type="time" id="sunday-end-time" name="sunday-end-time" value="<?php echo $oldPostData['sunday-end-time']; ?>">
    </div>



    <p>Shift Leader:</p>
    <input type="text" name="leader" list="leader-list" value="<?php echo $oldPostData['leader']; ?>" onclick="select();" required>
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

      <div id="volunteer-section">
        <p>Volunteer(s):</p>
        <?php
          if ($oldPostData['volunteers']) {
            foreach ($oldPostData['volunteers'] as $volunteer) {
              echo "<input type='text' name='volunteers[]' list='volunteer-list' value='{$volunteer}' onclick='select();'>";
            }
          }
        ?>
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
      </div>
      <br>
      <button type="button" id="add-volunteer-button" onclick="newVolunteerFunction();">Add Additional Volunteer</button>

      <br><br>

      <p>Horse:</p>
      <input type="text" name="horse" list="horse-list" value="<?php echo $oldPostData['horse']; ?>" onclick="select();">
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



    <br><br>
    <input type="submit" value="Create">

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

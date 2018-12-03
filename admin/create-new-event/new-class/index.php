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
    <input type="text" name="class-type" list="class-type-list" required>
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
      <input type="date" id="start-date" name="date-start" value="" placeholder="from" required>
      <label for="end-date">End date:</label>
      <input type="date" id="end-date" name="date-end" value="" placeholder="to" required>
    </div>

    <div style="max-width: 420px;">
      <!-- MONDAY-->
      <label for="monday-checkbox">Monday: </label>
      <input type="checkbox" id="monday-checkbox" name="monday-checkbox">
      <label for="monday-start-time">from:</label>
      <input type="time" id="monday-start-time" name="monday-start-time" required>
      <label for="monday-end-time">to:</label>
      <input type="time" id="monday-end-time" name="monday-end-time" required>
      <!-- TUESDAY-->
      <label for="tuesday-checkbox">Tuesday: </label>
      <input type="checkbox" id="tuesday-checkbox" name="tuesday-checkbox">
      <label for="tuesday-start-time">from:</label>
      <input type="time" id="tuesday-start-time" name="tuesday-start-time" required>
      <label for="tuesday-end-time">to:</label>
      <input type="time" id="tuesday-end-time" name="tuesday-end-time" required>
      <!-- WEDNESDAY-->
      <label for="wednesday-checkbox">Wednesday: </label>
      <input type="checkbox" id="wednesday-checkbox" name="wednesday-checkbox">
      <label for="wednesday-start-time">from:</label>
      <input type="time" id="wednesday-start-time" name="wednesday-start-time" required>
      <label for="wednesday-end-time">to:</label>
      <input type="time" id="wednesday-end-time" name="wednesday-end-time" required>
      <!-- THURSDAY-->
      <label for="thursday-checkbox">Thursday: </label>
      <input type="checkbox" id="thursday-checkbox" name="thursday-checkbox">
      <label for="thursday-start-time">from:</label>
      <input type="time" id="thursday-start-time" name="thursday-start-time" required>
      <label for="thursday-end-time">to:</label>
      <input type="time" id="thursday-end-time" name="thursday-end-time" required>
      <!-- FRIDAY-->
      <label for="friday-checkbox">Friday: </label>
      <input type="checkbox" id="friday-checkbox" name="friday-checkbox">
      <label for="friday-start-time">from:</label>
      <input type="time" id="friday-start-time" name="friday-start-time" required>
      <label for="friday-end-time">to:</label>
      <input type="time" id="friday-end-time" name="friday-end-time" required>
      <!-- SATURDAY-->
      <label for="saturday-checkbox">Saturday: </label>
      <input type="checkbox" id="saturday-checkbox" name="saturday-checkbox">
      <label for="saturday-start-time">from:</label>
      <input type="time" id="saturday-start-time" name="saturday-start-time" required>
      <label for="saturday-end-time">to:</label>
      <input type="time" id="saturday-end-time" name="saturday-end-time" required>
      <!-- SUNDAY-->
      <label for="sunday-checkbox">Sunday: </label>
      <input type="checkbox" id="sunday-checkbox" name="sunday-checkbox">
      <label for="sunday-start-time">from:</label>
      <input type="time" id="sunday-start-time" name="sunday-start-time" required>
      <label for="sunday-end-time">to:</label>
      <input type="time" id="sunday-end-time" name="sunday-end-time" required>
    </div>

    <p>Arena:</p>
    <input type="text" list="arena-list">
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

    <br><br>
    <input type="submit" value="Create">

  </form>




</body>

</html>

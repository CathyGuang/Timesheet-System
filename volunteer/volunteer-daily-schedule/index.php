<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <title>Volunteer Daily Schedule</title>
</head>

<body>

  <header>
    <h1>Volunteer Daily Schedule</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    include "../../static/scripts/connectdb.php";
  ?>

  <form action="">
    <input name="query-name" list="volunteers">
    <datalist id="volunteers">
      <?php
        $result = pg_query($db_connection, "SELECT name FROM volunteer;");
        while ($row = pg_fetch_row($result)) {
          echo "<option value='$row[0]'>";
        }
      ?>
    </datalist>

  </form


</body>

</html>

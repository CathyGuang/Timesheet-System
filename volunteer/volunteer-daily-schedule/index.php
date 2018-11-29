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
        echo "<option value='Hello this is PHP!'>";
        //GET LIST OF ALL VOLUNTEERS FROM DATABASE, ECHO <option value="NAME"> FOR EACH NAME
      ?>
    </datalist>

  </form


</body>

</html>

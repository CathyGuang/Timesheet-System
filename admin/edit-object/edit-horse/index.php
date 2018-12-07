<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/connectdb.php";?>
  <title>Admin | Edit Horse</title>
</head>

<body>

  <header>
    <h1>Edit Horse</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <form action="" method="post" class="main-form">
    <p>Select a horse to edit:</p>
    <input type="text" name="selected-horse" list="horse-list">
      <datalist id="horse-list">
        <?php
          $query = "SELECT name FROM horses;";
          $result = pg_query($db_connection, $query);
          while ($row = pg_fetch_row($result)) {
            echo "<option value='$row[0]'>";
          }
        ?>
      </datalist>

      <br><br>
      <input type="submit" value="submit">
  </form>

  <?php
    if ($_POST['selected-horse']) {
      $horseInfoQuery = "SELECT * FROM horses WHERE name LIKE '{$_POST['selected-horse']}';";
      $horseInfoSQL = pg_query($db_connection, $horseInfoQuery);
      $horseInfo = pg_fetch_array($horseInfoSQL, 0, PGSQL_ASSOC);

      echo <<<EOT
      <form action="edit-horse.php" method="post" class="main-form" style="margin-top: 2vh;">

        <p>Database ID:</p>
        <input type="number" name="id" value="{$horseInfo['id']}" readonly>

        <p>Name:</p>
        <input type="text" name="name" value="{$horseInfo['name']}" required>

        <p>FS Uses per Day:</p>
        <input type="number" name="fs_uses_per_day" value="{$horseInfo['fs_uses_per_day']}">

        <p>Owner Uses per Day:</p>
        <input type="number" name="owner_uses_per_day" value="{$horseInfo['owner_uses_per_day']}">

        <p>Notes:</p>
        <input type="text" name="notes" value="{$horseInfo['notes']}">

        <br><br>
        <input type="submit" value="Update">

      </form>
EOT;
    }
  ?>




</body>

</html>

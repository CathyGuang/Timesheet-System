<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | Edit Horse</title>
</head>

<body>

  <header>
    <h1>Edit Horse</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    if (!$_POST['selected-horse']) {
      echo <<<EOT
      <form autocomplete="off" action="" method="post" class="main-form">
        <p>Select a horse to edit:</p>
        <input type="text" name="selected-horse" list="horse-list" onclick='select();'>
          <datalist id="horse-list">
EOT;
              $query = "SELECT name FROM horses WHERE name != 'HORSE NEEDED' AND (archived IS NULL OR archived = '');";
              $result = pg_query($db_connection, $query);
              while ($row = pg_fetch_row($result)) {
                echo "<option value='$row[0]'>";
              }
      echo <<<EOT
          </datalist>

          <br><br>
          <input type="submit" value="Submit">
      </form>
EOT;
    } else {
      $horseInfoQuery = "SELECT * FROM horses WHERE name LIKE '{$_POST['selected-horse']}' AND (archived IS NULL OR archived = '');";
      $horseInfoSQL = pg_query($db_connection, $horseInfoQuery);
      $horseInfo = pg_fetch_array($horseInfoSQL, 0, PGSQL_ASSOC);

      echo <<<EOT
      <form autocomplete="off" action="edit-horse.php" method="post" class="main-form" style="margin-top: 2vh;">


        <p>Name:</p>
        <input type="text" name="name" value="{$horseInfo['name']}" required>

        <p>Owner:</p>
        <label>(Leave blank if owner is this organization)</label>
        <input type="text" name="owner" value="{$horseInfo['owner']}">

        <p>Owner email address:</p>
        <input type="email" name="owner-email" value="{$horseInfo['owner_email']}">

        <p>Veterinarian name:</p>
        <input type="text" name="vet-name" value="{$horseInfo['vet_name']}">

        <p>Veterinarian email address:</p>
        <input type="email" name="vet-email" value="{$horseInfo['vet_email']}">

        <p>Organization Uses per Day:</p>
        <input type="number" name="org_uses_per_day" value="{$horseInfo['org_uses_per_day']}">

        <p>Owner Uses per Day:</p>
        <input type="number" name="owner_uses_per_day" value="{$horseInfo['owner_uses_per_day']}">

        <p>Horse Uses per Week:</p>
        <input type="number" name="horse_uses_per_week" value="{$horseInfo['horse_uses_per_week']}" required>

        <div>
          <p>Notes:</p>
          <input type="text" name="notes" value="{$horseInfo['notes']}">
        </div>

        <p style='color: var(--dark-red)'>Archive: <input type="checkbox" name="archive" value="TRUE"></p>
        <p style='color: var(--dark-red);'>Delete: <input type="checkbox" name="delete" value="TRUE"></p>
        <p style='font-size: 10pt; color: var(--dark-red); margin-top: 0;'>(Cannot be undone)</p>

        <br><br>
        <input type="submit" value="Update">

        <input type="number" name="id" value="{$horseInfo['id']}" style='visibility: hidden;'>

      </form>
EOT;
    }
  ?>




</body>

</html>

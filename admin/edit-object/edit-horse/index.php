<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
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
      <div class="form-container">
        <form autocomplete="off" action="" method="post" class="standard-form">
          <div class="form-section">
            <h3>Select a horse to edit:</h3>
          </div>

          <div class="form-section">
            <div class="form-element">
              <input type="text" name="selected-horse" list="horse-list" onclick='select();'>
            </div>
          </div>

            <datalist id="horse-list">
EOT;
                $query = "SELECT name FROM horses WHERE name != 'HORSE NEEDED' AND (archived IS NULL OR archived = '');";
                $result = pg_query($db_connection, $query);
                while ($row = pg_fetch_row($result)) {
                  echo "<option value='$row[0]'>";
                }
        echo <<<EOT
            </datalist>

            <div class="form-section">
              <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
              <button type="submit">Go</button>
            </div>
        </form>
      </div>
EOT;
    } else {
      $horseInfoQuery = "SELECT * FROM horses WHERE name LIKE '{$_POST['selected-horse']}' AND (archived IS NULL OR archived = '');";
      $horseInfoSQL = pg_query($db_connection, $horseInfoQuery);
      $horseInfo = pg_fetch_array($horseInfoSQL, 0, PGSQL_ASSOC);

      echo <<<EOT
      <div class="form-container">
        <form autocomplete="off" action="edit-horse.php" method="post" class="standard-form" style="margin-top: 2vh;">

          <div class="form-section">
            <div class="form-element">
              <label for="name">Name:</label>
              <input type="text" name="name" id="name" value="{$horseInfo['name']}" required>
            </div>
          </div>

          <div class="form-section">
            <h3>Owner:</h3>
          </div>

          <div class="form-section">
            <div class="form-element">
              <label for="owner">Owner: (Leave blank for organization)</label>
              <input type="text" name="owner" id="owner" value="{$horseInfo['owner']}">
            </div>

            <div class="form-element">
              <label for="owner-email">Owner email address:</label>
              <input type="email" name="owner-email" id="owner-email" value="{$horseInfo['owner_email']}">
            </div>

            <div class="form-element">
              <label for="owner-phone">Owner phone number:</label>
              <input type="phone" name="owner-phone" id="owner-phone" value="{$horseInfo['owner_phone']}">
            </div>
          </div>

          <div class="form-section">
            <h3>Veterinarian:</h3>
          </div>

          <div class="form-section">
            <div class="form-element">
              <label for="vet-name">Veterinarian name:</label>
              <input type="text" name="vet-name" id="vet-name" value="{$horseInfo['vet_name']}">
            </div>

            <div class="form-element">
              <label for="vet-email">Veterinarian email address:</label>
              <input type="email" name="vet-email" id="vet-email" value="{$horseInfo['vet_email']}">
            </div>

            <div class="form-element">
              <label for="vet-phone">Veterinarian phone number:</label>
              <input type="phone" name="vet-phone" id="vet-phone" value="{$horseInfo['vet_phone']}">
            </div>
          </div>

          <div class="form-section">
            <h3>Use:</h3>
          </div>

          <div class="form-section">
            <div class="form-element">
              <label for="org_uses_per_day">Organization Uses per Day:</label>
              <input type="number" name="org_uses_per_day" id="org_uses_per_day" value="{$horseInfo['org_uses_per_day']}">
            </div>

            <div class="form-element">
              <label for="owner_uses_per_day">Owner Uses per Day:</label>
              <input type="number" name="owner_uses_per_day" id="owner_uses_per_day" value="{$horseInfo['owner_uses_per_day']}">
            </div>

            <div class="form-element">
              <label for="horse_uses_per_week">Horse Uses per Week:</label>
              <input type="number" name="horse_uses_per_week" id="horse_uses_per_week" value="{$horseInfo['horse_uses_per_week']}" required>
            </div>
          </div>

          <div class="form-section">
            <h3>Notes:</h3>
          </div>

          <div class="form-section">
            <div class="form-element">
              <div>
                <textarea name="notes" rows=5>{$horseInfo['notes']}</textarea>
              </div>
            </div>
          </div>

         <div class="form-section">
            <h3>Remove Horse:</h3>
          </div>
          <div class="form-section remove-section">
            <div class="form-element">
              <h4>Archive:
                <input type="checkbox" name="archive" value="TRUE">
              </h4>
              <p>Saves horse in database but removes from all menus</p>
            </div>
            <div class="form-element">
              <h4>
                Delete:
                <input type="checkbox" id="delete-checkbox" name="DELETE" value="TRUE">
              </h4>
              <p>WARNING: only delete horses that are not currently in any classes</p>
            </div>
          </div>

          <div class="form-section">
            <button type="button" class="cancel-form" onclick="window.history.back(2)">Cancel</button>
            <button type="submit">Update</button>
          </div>

          <input type="number" name="id" value="{$horseInfo['id']}" hidden>

        </form>
      </div>
EOT;
    }
  ?>




</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | Edit Client</title>
</head>

<body>

  <header>
    <h1>Edit Client</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
  if (!$_POST['selected-client']) {
    echo <<<EOT
    <div class="form-container">
      <form autocomplete="off" action="" method="post" class="standard-form">
        <div class="form-section">
          <h3>Select a client to edit:</h3>
        </div>
        <div class="form-section">
          <div class="form-element">
            <input type="text" name="selected-client" list="client-list" onclick='select();'>
          </div>
        </div>
        <datalist id="client-list">
EOT;
          $query = "SELECT name FROM clients WHERE (archived IS NULL OR archived = '');";
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
      $clientInfoQuery = "SELECT * FROM clients WHERE name LIKE '{$_POST['selected-client']}' AND (archived IS NULL OR archived = '');";
      $clientInfoSQL = pg_query($db_connection, $clientInfoQuery);
      $clientInfo = pg_fetch_array($clientInfoSQL, 0, PGSQL_ASSOC);

      echo <<<EOT
      <div class="form-container">
        <form autocomplete="off" action="edit-client.php" method="post" class="standard-form" style="margin-top: 2vh;">

          <div class=form=section>
            <div class="form-element">
              <label for="name">Name/Initials:</label>
              <input type="text" name="name" id="name value="{$clientInfo['name']}" required>
            </div>
          </div>

          <div class=form=section>
            <div class="form-element">
              <label for="email">Email:</label>
              <input type="email" name="email" id="email" value="{$clientInfo['email']}">
            </div>
          </div>

          <div class=form=section>
            <div class="form-element">
              <label for="phone">Phone Number:</label>
              <input type="number" name="phone" id="phone" maxlength="10" value="{$clientInfo['phone']}">
            </div>
          </div>

          <div class="form-section">
            <h3>Remove Client:</h3>
          </div>
          <div class="form-section remove-section">
            <div class="form-element">
              <h4>Archive:
                <input type="checkbox" name="archive" value="TRUE">
              </h4>
              <p>Saves client in database but removes from all menus</p>
            </div>
            <div class="form-element">
              <h4>
                Delete:
                <input type="checkbox" id="delete-checkbox" name="DELETE" value="TRUE">
              </h4>
              <p>WARNING: only delete clients that are not currently in any classes</p>
            </div>
          </div>


          
          <div class="form-section">
            <button type="button" class="cancel-form" onclick="window.history.back(2)">Cancel</button>
            <button type="submit">Update</button>
          </div>

          <input type="number" name="id" value="{$clientInfo['id']}" readonly hidden>

        </form>
      </div>
EOT;
    }
  ?>




</body>

</html>

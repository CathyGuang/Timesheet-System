<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | Edit Worker</title>
</head>

<body>

  <header>
    <h1>Edit Worker</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    if (!$_POST['selected-worker']) {
      echo <<<EOT
      <div class="form-container">
        <form autocomplete="off" action="" method="post" class="standard-form">
          <div class="form-section">
            <div class="form-element">
              <label for="selected-worker">Select a worker to edit:</label>
              <input type="text" name="selected-worker" id="selected-worker" list="worker-list" onclick='select();'>
                <datalist id="worker-list">
EOT;
                    $query = "SELECT name FROM workers WHERE name != 'NEEDED' AND (archived IS NULL OR archived = '');";
                    $result = pg_fetch_all(pg_query($db_connection, $query));
                    foreach ($result as $worker) {
                      $name = htmlspecialchars($worker['name'], ENT_QUOTES);
                      echo "<option value='{$name}'>";
                    }
            echo <<<EOT
                </datalist>
            </div>
          </div>

          <div class="form-section">
            <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
            <button type="submit">Go</button>
          </div>
        </form>
      </div>
EOT;

    } else {
      $workerInfoQuery = "SELECT * FROM workers WHERE name LIKE '{$_POST['selected-worker']}' AND (archived IS NULL OR archived = '');";
      $workerInfoSQL = pg_query($db_connection, $workerInfoQuery);
      $workerInfo = pg_fetch_array($workerInfoSQL, 0, PGSQL_ASSOC);
      echo <<<EOT
      <div class="form-container">
        <form autocomplete="off" action="edit-worker.php" method="post" class="standard-form" style="margin-top: 2vh;">

          <div class="form-section">
            <div class="form-element">
              <label for="name">Name:</label>
              <input type="text" name="name" id="name" value="{$workerInfo['name']}" required>
            </div>
          </div>

          <div class="form-section">
            <div class="form-element">
              <label for="title">Title:</label>
              <input type="text" name="title" id="title" value="{$workerInfo['title']}">
            </div>
          </div>

          <div class="form-section">
            <div class="form-element">
              <label for="email">Email:</label>
              <input type="email" name="email" id="email" value="{$workerInfo['email']}">
            </div>
          </div>

          <div class="form-section">
            <div class="form-element">
              <label for="phone">Phone Number:</label>
              <input type="number" name="phone" id="phone" maxlength="10" value="{$workerInfo['phone']}">
            </div>
          </div>
EOT;
        if ($workerInfo['staff'] == 't') {
          $checked = "checked";
        } else {
          $checked = "";
        }
        echo <<<EOT
        <div class="form-section">
          <div class="form-element">
            <p>Staff: <input type="checkbox" name="staff" value="TRUE" {$checked}></p>
          </div>
        </div>
EOT;
        if ($workerInfo['volunteer'] == 't') {
          $checked = "checked";
        } else {
          $checked = "";
        }
          echo <<<EOT
          <div class="form-section">
            <div class="form-element">
              <p>Volunteer: <input type="checkbox" name="volunteer" value="TRUE" {$checked}></p>
            </div>
          </div>

          <div class="form-section">
            <h3>Remove Worker:</h3>
          </div>
          <div class="form-section remove-section">
            <div class="form-element">
              <h4>Archive:
                <input type="checkbox" name="archive" value="TRUE">
              </h4>
              <p>Saves worker in database but removes from all menus</p>
            </div>
            <div class="form-element">
              <h4>
                Delete:
                <input type="checkbox" id="delete-checkbox" name="DELETE" value="TRUE">
              </h4>
              <p>WARNING: only delete workers that are not currently in any classes</p>
            </div>
          </div>

          <div class="form-section">
            <button type="button" class="cancel-form" onclick="window.history.back(2)">Cancel</button>
            <button type="submit">Update</button>
          </div>

          <input type="number" name="id" value="{$workerInfo['id']}" hidden>

        </form>
      </div>
EOT;
    }
  ?>




</body>

</html>

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
      <form autocomplete="off" action="" method="post" class="standard-form">
        <p>Select a worker to edit:</p>
        <input type="text" name="selected-worker" list="worker-list" onclick='select();'>
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

          <br><br>
          <button type="submit">Submit</button>
      </form>
EOT;

    } else {
      $workerInfoQuery = "SELECT * FROM workers WHERE name LIKE '{$_POST['selected-worker']}' AND (archived IS NULL OR archived = '');";
      $workerInfoSQL = pg_query($db_connection, $workerInfoQuery);
      $workerInfo = pg_fetch_array($workerInfoSQL, 0, PGSQL_ASSOC);
      echo <<<EOT
      <form autocomplete="off" action="edit-worker.php" method="post" class="standard-form" style="margin-top: 2vh;">


        <p>Name:</p>
        <input type="text" name="name" value="{$workerInfo['name']}" required>

        <p>Title:</p>
        <input type="text" name="title" value="{$workerInfo['title']}">

        <p>Email:</p>
        <input type="email" name="email" value="{$workerInfo['email']}">

        <p>Phone Number:</p>
        <input type="number" name="phone" maxlength="10" value="{$workerInfo['phone']}">
EOT;
      if ($workerInfo['staff'] == 't') {
        echo <<<EOT
        <div>
          <p>Staff: <input type="checkbox" name="staff" value="TRUE" checked></p>
        </div>
EOT;
      } else {
          echo <<<EOT
          <div>
            <p>Staff: <input type="checkbox" name="staff" value="TRUE"></p>
          </div>
EOT;
      }
      if ($workerInfo['volunteer'] == 't') {
        echo <<<EOT
        <div>
          <p>Volunteer: <input type="checkbox" name="volunteer" value="TRUE" checked></p>
        </div>
EOT;
      } else {
        echo <<<EOT
        <div>
          <p>Volunteer: <input type="checkbox" name="volunteer" value="TRUE"></p>
        </div>
EOT;
      }
      echo <<<EOT

        <p style='color: var(--dark-red)'>Archive: <input type="checkbox" name="archive" value="TRUE"></p>
        <p style='color: var(--dark-red);'>Delete: <input type="checkbox" name="delete" value="TRUE"></p>
        <p style='font-size: 10pt; color: var(--dark-red); margin-top: 0;'>(Cannot be undone)</p>

        <br><br>
        <button type="submit">Update</button>

        <input type="number" name="id" value="{$workerInfo['id']}" hidden>

      </form>
EOT;
    }
  ?>




</body>

</html>

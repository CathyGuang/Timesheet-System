<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/connectdb.php";?>
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
      <form action="" method="post" class="main-form">
        <p>Select a worker to edit:</p>
        <input type="text" name="selected-worker" list="worker-list">
          <datalist id="worker-list">
EOT;
              $query = "SELECT name FROM workers WHERE archived IS NULL OR archived = '';";
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
      $workerInfoQuery = "SELECT * FROM workers WHERE name LIKE '{$_POST['selected-worker']}' AND archived IS NULL;";
      $workerInfoSQL = pg_query($db_connection, $workerInfoQuery);
      $workerInfo = pg_fetch_array($workerInfoSQL, 0, PGSQL_ASSOC);
      echo <<<EOT
      <form action="edit-worker.php" method="post" class="main-form" style="margin-top: 2vh;">


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

        <br><br>
        <input type="submit" value="Update">

        <input type="number" name="id" value="{$workerInfo['id']}" style="visibility: hidden;">

      </form>
EOT;
    }
  ?>




</body>

</html>

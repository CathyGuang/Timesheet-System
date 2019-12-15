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
    <form autocomplete="off" action="" method="post" class="standard-form">
      <p>Select a client to edit:</p>
      <input type="text" name="selected-client" list="client-list" onclick='select();'>
        <datalist id="client-list">
EOT;
          $query = "SELECT name FROM clients WHERE (archived IS NULL OR archived = '');";
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
      $clientInfoQuery = "SELECT * FROM clients WHERE name LIKE '{$_POST['selected-client']}' AND (archived IS NULL OR archived = '');";
      $clientInfoSQL = pg_query($db_connection, $clientInfoQuery);
      $clientInfo = pg_fetch_array($clientInfoSQL, 0, PGSQL_ASSOC);

      echo <<<EOT
      <form autocomplete="off" action="edit-client.php" method="post" class="standard-form" style="margin-top: 2vh;">

        <p>Name/Initials:</p>
        <input type="text" name="name" value="{$clientInfo['name']}" required>

        <p>Email:</p>
        <input type="email" name="email" value="{$clientInfo['email']}">

        <p>Phone Number:</p>
        <input type="number" name="phone" maxlength="10" value="{$clientInfo['phone']}">

        <p style='color: var(--dark-red);'>Archive: <input type="checkbox" name="archive" value="TRUE"></p>
        <p style='color: var(--dark-red);'>Delete: <input type="checkbox" name="delete" value="TRUE"></p>
        <p style='font-size: 10pt; color: var(--dark-red); margin-top: 0;'>(Cannot be undone)</p>


        <br><br>
        <input type="submit" value="Update">

        <input type="number" name="id" value="{$clientInfo['id']}" readonly style='visibility: hidden;'>

      </form>
EOT;
    }
  ?>




</body>

</html>

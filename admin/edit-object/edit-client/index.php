<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/connectdb.php";?>
  <title>Admin | Edit Client</title>
</head>

<body>

  <header>
    <h1>Edit Client</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <form action="" method="post" class="main-form">
    <p>Select a client to edit:</p>
    <input type="text" name="selected-client" list="client-list">
      <datalist id="client-list">
        <?php
          $query = "SELECT name FROM clients;";
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
    if ($_POST['selected-client']) {
      $clientInfoQuery = "SELECT * FROM clients WHERE name LIKE '{$_POST['selected-client']}';";
      $clientInfoSQL = pg_query($db_connection, $clientInfoQuery);
      $clientInfo = pg_fetch_array($clientInfoSQL, 0, PGSQL_ASSOC);

      echo <<<EOT
      <form action="edit-client.php" method="post" class="main-form" style="margin-top: 2vh;">

        <p>Database ID:</p>
        <input type="number" name="id" value="{$clientInfo['id']}" readonly>

        <p>Name:</p>
        <input type="text" name="name" value="{$clientInfo['name']}" required>

        <p>Email:</p>
        <input type="email" name="email" value="{$clientInfo['email']}">

        <p>Phone Number:</p>
        <input type="number" name="phone" maxlength="10" value="{$clientInfo['phone']}">

        <br><br>
        <input type="submit" value="Update">

      </form>
EOT;
    }
  ?>




</body>

</html>

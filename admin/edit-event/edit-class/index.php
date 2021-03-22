<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | Edit Class</title>
</head>

<body>

  <header>
    <h1>Edit Class</h1>
    <nav> <a href="../../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>





    <div class="form-container">
      <form autocomplete="off" action="class-editor.php" method="post" class="standard-form">

        <div class="form-section">
          <div class="form-element">
            <label for="selected-class">Select a class to edit:</label>
            <input type="text" name="selected-class" id="selected-class" list="class-list" onclick='select();'>
          </div>
        </div>
          
        <div class="form-section">
          <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
          <button type="submit">Go</button>
        </div>
         
      </form>
    </div>


    <!-- DATA LISTS -->
    <datalist id="class-list">
          <?php
            $query = "SELECT DISTINCT class_type, clients, display_title, staff, class_code FROM classes WHERE (archived IS NULL OR archived = '');";
            $result = pg_query($db_connection, $query);
            while ($row = pg_fetch_row($result)) {
              //Get client names
              $getClientsQuery = <<<EOT
                SELECT clients.name FROM clients WHERE
                clients.id = ANY('{$row[1]}')
                ;
EOT;
              $clients = pg_fetch_all_columns(pg_query($db_connection, $getClientsQuery));
              $clientString = "";
              foreach ($clients as $name) {
                $clientString .= $name . ", ";
              }
              $clientString = rtrim($clientString, ", ");

              //Get staff names
              $staffJSON = json_decode($row[3], true);
              $staffIDList = [];
              foreach ($staffJSON as $key => $id) {
                $staffIDList[] = $id;
              }
              $staffIDList = to_pg_array($staffIDList);
              $getStaffQuery = <<<EOT
                SELECT workers.name FROM workers WHERE
                workers.id = ANY('{$staffIDList}')
                ;
EOT;
              $staffData = pg_fetch_all_columns(pg_query($db_connection, $getStaffQuery));
              $staffString = "";
              foreach ($staffData as $name) {
                $staffString .= $name . ", ";
              }
              $staffString = rtrim($staffString, ", ");
              echo "<option value='$staffString; $row[2]; $row[0]; $clientString; class code: $row[4]'>";
            }
          ?>
          </datalist>


</body>

</html>

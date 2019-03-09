<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Admin | System Emails</title>
</head>

<body>

  <header>
    <h1>Configure System Emails</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">

    <?php
      $volunteerCoordinatorEmail = pg_fetch_array(pg_query($db_connection, "SELECT value FROM misc_data WHERE key LIKE 'volunteer-coordinator-email';"), 0, PGSQL_ASSOC)['value'];
      $staffCoordinatorEmail = pg_fetch_array(pg_query($db_connection, "SELECT value FROM misc_data WHERE key LIKE 'staff-coordinator-email';"), 0, PGSQL_ASSOC)['value'];
    ?>
    <form autocomplete="off" class="main-form small-form" action="emails2.php" method="post">
      <p>Volunteer Coordinator: <input type="email" name="volunteer-coordinator-email" value="<?php echo $volunteerCoordinatorEmail; ?>"></p>
      <p>Staff Coordinator: <input type="email" name="staff-coordinator-email" value="<?php echo $staffCoordinatorEmail; ?>"></p>

      <div><input type="submit" value="Update"><a href="../"><button>Cancel</button></a></div>


    </form>

  </div>


</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Staff Directory | <?php echo $organizationName; ?> Web Portal</title>
</head>

<body>

  <header>
    <h1>Staff Directory</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">
    <form autocomplete="off" class="main-content-form" style="width: 500px;">
      <?php
        $query = "SELECT * FROM workers WHERE id = {$_POST['buttonInfo']};";
        $personInfo = pg_fetch_all(pg_query($db_connection, $query))[0];

        echo <<<EOT
          <p>Name: {$personInfo['name']}</p>
EOT;
        if ($personInfo['title'] != "") {
          echo "<p>Title: {$personInfo['title']}</p>";
        }
        echo <<<EOT
          <p>Email: {$personInfo['email']}</p>
          <p>Phone: {$personInfo['phone']}</p>
EOT;

      ?>
    </form>
  </div>

</body>

</html>

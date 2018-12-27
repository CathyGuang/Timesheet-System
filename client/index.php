<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Client | <?php echo $organizationName; ?> Web Portal</title>
</head>

<body>

  <header>
    <h1>Client</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">
    <a href="client-daily-schedule"><button class="green-button">Daily Schedule</button></a>
    <a href="manage-classes"><button class="blue-button">Manage Classes</button></a>
  </div>

</body>

</html>

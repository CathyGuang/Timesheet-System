<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Volunteer | <?php echo $organizationName; ?> Web Portal</title>
</head>

<body>

  <header>
    <h1>Volunteer</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">
    <a href="volunteer-daily-schedule"><button class="green-button">Daily Schedule</button></a>
    <a href="record-hours"><button class="blue-button">Record Hours</button></a>
    <a href="view-hours"><button class="green-button">View Hours</button></a>
  </div>

</body>

</html>

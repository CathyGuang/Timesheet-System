<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Full Time Staff | <?php echo $organizationName; ?> Web Portal</title>
</head>

<body>

  <header>
    <h1>Full Time Staff</h1>
    <nav> <a href="./"><button id="back-button">Back</button></a>
      <a href="./"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">
    <a href="view-hours"><button class="green-button">View Hours</button></a>
    <a href="enter-hours"><button class="blue-button">Enter Hours</button></a>
  </div>

</body>

</html>
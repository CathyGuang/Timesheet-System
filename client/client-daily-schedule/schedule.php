<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/connectdb.php"; ?>
  <?php error_reporting(E_ALL & ~E_NOTICE); ?>
  <title>Client Daily Schedule</title>
</head>

<body>

  <header>
    <h1><?php echo $_POST['selected-name'] ?>'s Daily Schedule</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <h2 class="main-content-header"><?php if ($_POST['selected-date'] == date('Y-m-d')) {echo "TODAY";} else {echo "For {$_POST['selected-date']}";} ?></h2>

  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/clientScheduleGenerator.php"; ?>


</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Editable Daily Schedule</title>
  <script>
    $(window).bind("pageshow", function(event) {
      if (event.originalEvent.persisted) {
        window.location.reload();
      }
    });
  </script>
</head>

<body>
  <div class="schedule-header">
    <header>
      <h1>Editable Daily Schedule</h1>
      <nav> <a href="../"><button id="back-button">Back</button></a>
        <a href="/"><button id="home-button">Home</button></a>
      </nav>
    </header>

<h2 class="main-content-header"><?php if ($_POST['selected-date'] == date('Y-m-d')) {echo "TODAY: " . date('l, Y-m-d');} else {echo "For " . date('l, ', strtotime($_POST['selected-date'])) . "{$_POST['selected-date']}";} ?></h2>

    <div style="display: flex; justify-content: space-between;">
      <button class="green-button" type="submit" form="new-schedule2" name="selected-date" value="<?php echo date("Y-m-d", strtotime($_POST['selected-date'] . " -1 day")); ?>" style="height: 40pt; max-width: 300px;">PREVIOUS DAY</button>
      <div>
        <input type="date" form="new-schedule" name="selected-date" value="<?php echo $_POST['selected-date']; ?>" style="height: 40pt; max-width: 300px;">
        <button class="green-button" type="submit" form="new-schedule" style="height: 40pt; max-width: 50px;">GO</button>
      </div>
      <button class="green-button" type="submit" form="new-schedule" name="selected-date" value="<?php echo date("Y-m-d", strtotime($_POST['selected-date'] . " +1 day")); ?>" style="height: 40pt; max-width: 300px;">NEXT DAY</button>
    </div>
  </div>

  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/staffScheduleGenerator.php"; ?>

  <form autocomplete="off" id="new-schedule" method="post" action="" style="visibility: hidden;">
    <input type="text" name="selected-name" value="<?php echo $_POST['selected-name']; ?>" style="visibility: hidden; height: 1px;">
  </form>
  <form autocomplete="off" id="new-schedule2" method="post" action="" style="visibility: hidden;">
    <input type="text" name="selected-name" value="<?php echo $_POST['selected-name']; ?>" style="visibility: hidden; height: 1px;">
  </form>

</body>

</html>

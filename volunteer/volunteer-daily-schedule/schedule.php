<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/connectdb.php"; ?>
  <?php error_reporting(E_ALL & ~E_NOTICE); ?>
  <title>Volunteer Daily Schedule</title>
</head>

<body>

  <header>
    <h1><?php echo $_POST['selected-name'] ?>'s Daily Schedule</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <h2 class="main-content-header"><?php if ($_POST['selected-date'] == date('Y-m-d')) {echo "TODAY";} else {echo "For {$_POST['selected-date']}";} ?></h2>


  <?php
    $selectedName = $_POST['selected-name'];
    $selectedDate = $_POST['selected-date'];

    $QUERY_NAME = $_POST['selected-name'];
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/getWorkerInvolvedClasses.php";
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/getWorkerInvolvedShifts.php";
    //these scripts generate the variables $allClasses, $allOfficeShifts, $allHorseCareShifts


    //filter classes by date
    $todaysClasses = array();
    $todaysHorseCareShifts = array();
    $todaysOfficeShifts = array();

    //foreach class/shift check if date_of_class/date_of_shift matches $selectedDate, if so, append to $todaysClasses / $todaysShifts
    if ($allClasses) {
      foreach ($allClasses as $key => $class) {
        if ($class['date_of_class'] == $selectedDate){
          $todaysClasses[] = $class;
        }
      }
    }
    if ($allHorseCareShifts) {
      foreach ($allHorseCareShifts as $key => $horseCareShift) {
        if ($horseCareShift['date_of_shift'] == $selectedDate){
          $todaysHorseCareShifts[] = $horseCareShift;
        }
      }
    }
    if ($allOfficeShifts) {
      foreach ($allOfficeShifts as $key => $officeShift) {
        if ($officeShift['date_of_shift'] == $selectedDate){
          $todaysOfficeShifts[] = $officeShift;
        }
      }
    }

    echo "<br><b>todaysClasses</b><br>";
    var_dump($todaysClasses);
    echo "<br><b>todaysHorseCareShifts</b><br>";
    var_dump($todaysHorseCareShifts);
    echo "<br><b>todaysOfficeShifts</b><br>";
    var_dump($todaysOfficeShifts);

    //If no classes/shifts are found for a volunteer
    if (!$todaysClasses and !$todaysHorseCareShifts and !$todaysOfficeShifts) {
      echo "<br><h3 class='main-content-header'>No scheduled events today!</h3>";
      //possibly display an empty schedule?
      return;
    }

    //CREATE AND DISPLAY SCHEDULE FOR GIVEN WORKER AND DATE

    //an array containing all class and shift data indexed by start time.
    $masterList = array();

    foreach ($todaysClasses as $value) {
      $masterList[$value['start_time']] = $value;
    }
    foreach ($todaysHorseCareShifts as $value) {
      $masterList[$value['start_time']] = $value;
    }
    foreach ($todaysOfficeShifts as $value) {
      $masterList[$value['start_time']] = $value;
    }
    //sort masterlist by time.
    ksort($masterList);

    echo "<br><b>masterList</b><br>";
    var_dump($masterList);



    //Display the schedule
    echo <<<EOT
    <div class="schedule-display">
    <p class="schedule-time" style="height: 5vh;">Time:</p>
    <p class="schedule-event-type" style="height: 5vh;">Class/Shift:</p>
    <p class="schedule-instructor-leader" style="height: 5vh;">Instructor/Leader:</p>
EOT;

    foreach ($masterList as $time => $event) {
      $newTimeString = date("g:i a", strtotime($time)) . "<br> &#8212 <br>" . date("g:i a", strtotime($event['end_time']));
      echo "<p class='schedule-time'>{$newTimeString}</p>";
      echo "<p class='schedule-event-type'>{$event['class_type']}{$event['care_type']}{$event['shift_type']}</p>";
      if ($event['instructor']){
        $lead = $event['instructor'];
      } else if ($event['leader']) {
        $lead = $event['leader'];
      } else {
        $lead = "";
      }

    }




    echo "</div>";



  ?>


</body>

</html>

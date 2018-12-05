<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/connectdb.php"; ?>
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

    print_r($_POST);
    echo "<br><br>";

    $QUERY_NAME = $_POST['selected-name'];
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/getWorkerInvolvedClasses.php";
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/getWorkerInvolvedShifts.php";

    echo "<br><b>allClasses:</b><br>";
    var_dump($allClasses);
    echo "<br><b>allHorseCareShifts:</b><br>";
    var_dump($allHorseCareShifts);
    echo "<br><b>allOfficeShifts</b><br>";
    var_dump($allOfficeShifts);

    //filter classes by date
    $todaysClasses = array();
    $todaysHorseCareShifts = array();
    $todaysOfficeShifts = array();

    //foreach class check if date_of_class matches $selectedDate, if so, append to $todaysClasses / $todaysShifts
    foreach ($allClasses as $key => $class) {
      if ($class['date_of_class'] == $selectedDate){
        $todaysClasses[] = $class;
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

  ?>







</body>

</html>

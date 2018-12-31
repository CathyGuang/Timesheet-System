
  <?php
    //MAKE SURE _POST INCLUDES THESE TWO PARAMETERS!!
    $selectedName = $_POST['selected-name'];
    $selectedDate = $_POST['selected-date'];

    $QUERY_NAME = $selectedName;
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

    //If no classes/shifts are found for a worker
    if (!$todaysClasses and !$todaysHorseCareShifts and !$todaysOfficeShifts) {
      echo "<br><h3 class='main-content-header' style='margin-top: 40vh; margin-left: 30vw;'>No scheduled events today!</h3>";
      return;
    }

    //CREATE AND DISPLAY SCHEDULE FOR GIVEN WORKER AND DATE

    //an array containing all class and shift data indexed by start time.
    $masterList = array();

    foreach ($todaysClasses as $value) {
      $masterList[] = $value;
    }
    foreach ($todaysHorseCareShifts as $value) {
      $masterList[] = $value;
    }
    foreach ($todaysOfficeShifts as $value) {
      $masterList[] = $value;
    }
    //sort masterlist by time.
    //ksort($masterList);
    function compare($a, $b) {
      if ($a['start_time'] < $b['start_time']) {
        return -1;
      } else if ($a['start_time'] > $b['start_time']) {
        return 1;
      } else if ($a['end_time'] < $b['end_time']) {
        return -1;
      } else {
        return 1;
      }
    }
    usort($masterList, "compare");


    //Display the schedule
    echo <<<EOT
    <div class="schedule-display">
    <p class="schedule-time" style="height: 5vh;">Time:</p>
    <p class="schedule-event-type" style="height: 5vh;">Class/Shift:</p>
    <p class="schedule-staff" style="height: 5vh;">Staff:</p>
    <p class="schedule-leaders" style="height: 5vh;">Volunteers:</p>
    <p class="schedule-volunteers" style="height: 5vh;">Volunteers:</p>
    <p class="schedule-horse-info" style="height: 5vh;">Horse:</p>
    <p class="schedule-clients" style="height: 5vh;">Clients:</p>
EOT;

    foreach ($masterList as $event) {

      //Time
      $time = $event['start_time'];
      $newTimeString = date("g:i a", strtotime($time)) . "<br> &#8212 <br>" . date("g:i a", strtotime($event['end_time']));
      if ($event['cancelled'] == 't') {
        $style = "style='background-color: var(--dark-red);'";
        $cancelled = "<br>CANCELLED";
      } else {
        $style = "";
        $cancelled = "";
      }
      echo "<p class='schedule-time' {$style}>{$newTimeString}{$cancelled}</p>";

      //Event Type
      echo "<p class='schedule-event-type'>{$event['class_type']}{$event['care_type']}{$event['office_shift_type']}</p>";

      //Staff
      $staffString = "";
      foreach ($event['staff'] as $role => $name) {
        if ($name == "") {continue;}
        $staffString .= "<i>{$role}:</i> {$name}<br>";
      }
      if ($staffString == "") {
        $staffString = "&#8212";
      }
      if (strpos($staffString, $selectedName) !== false) {
        $style = "style='background-color: var(--accent-purple);'";
      } else {
        $style = "";
      }
      echo "<p class='schedule-staff' {$style}>{$staffString}</p>";

      //Leaders
      $leaderString = "";
      //Classes with potentially multiple leaders
      var_dump($event['leaders']);
      if ($event['leaders'] && $event['leaders'][0] != "") {
        foreach ($event['leaders'] as $leaderName) {
          if ($leaderName == "NEEDED"){
            $leaderString .= "<i style='float:left;'>Leader:&nbsp</i><div style='color:yellow;'>{$leaderName}</div>";
          } else {
            $leaderString .= "<i>Leader: </i>" . $leaderName . "<br>";
          }
        }
      }
      //Shifts with only one leader
      if ($event['leader']) {
        $leaderString .= "<i>Shift Leader/Key Volunteer: </i>" . $event['leader'];
      }
      if ($leaderString == "") {
        $leaderString = "&#8212";
      }
      if (strpos($leaderString, $selectedName) !== false) {
        $style = "style='background-color: var(--accent-purple);'";
      } else {
        $style = "";
      }
      echo "<div class='schedule-leaders' {$style}>{$leaderString}</div>";


      //Volunteers
      $volunteerString = "";
      if ($event['volunteers'] && $event['volunteers'][0] != "") {
        foreach ($event['volunteers'] as $volunteerName) {
          if ($volunteerName == "NEEDED") {
            $volunteerString .= "<div style='color: yellow;'>{$volunteerName}</div>, ";
          } else {
            $volunteerString .= $volunteerName . ", ";
          }
        }
      }
      if ($event['sidewalkers'] && $event['sidewalkers'][0] != "") {
          foreach ($event['sidewalkers'] as $volunteerName) {
            if ($volunteerName == "NEEDED") {
              $volunteerString .= "<i style='float:left;'>Sidewalker:&nbsp;</i><div style='color: yellow;'>{$volunteerName}</div>";
            } else {
              $volunteerString .= "<i>Sidewalker: </i>{$volunteerName}" . "<br>";
            }
          }
      }
      if ($volunteerString == "") {
        $volunteerString = "&#8212";
      }
      if (strpos($volunteerString, $selectedName) !== false) {
        $style = "style='background-color: var(--accent-purple);'";
      } else {
        $style = "";
      }
      echo "<div class='schedule-volunteers' {$style}>{$volunteerString}</div>";

      //Horse
      $horseString = "";
      if ($event['horses']) {
        foreach ($event['horses'] as $key => $horseName) {
          if ($horseName == "HORSE NEEDED") {
            $horseString .= "<i style='float:left;'>Horse:&nbsp</i><div style='color: red; float: left;'>{$horseName}</div>, ";
          } else {
            $horseString .= "<i>Horse: </i>" . $horseName . ", ";
          }
          if ($event['tacks'][$key] and $event['tacks'][$key] != "") {
            $tackName = rtrim(ltrim($event['tacks'][$key], "\""), "\"");
            $horseString .= "<i>Tack: </i>" . $tackName . ", ";
          }
          if ($event['pads'][$key] and $event['pads'][$key] != "") {
            $padName = rtrim(ltrim($event['pads'][$key], "\""), "\"");
            $horseString .= "<i>Pad: </i>" . $padName;
          }
          $horseString .= "<br>";
        }
        if ($event['special_tack'] and $event['special_tack'] != "") {
          $horseString .= "<i><br>Special Tack: </i>" . $event['special_tack'] . ", ";
        }
        if ($event['stirrup_leather_length'] and $event['stirrup_leather_length'] != "") {
          $horseString .= "<i><br>Stirrup Leather Length: </i>" . $event['stirrup_leather_length'] . ", ";
        }
      }
      if (strpos($horseString, $selectedName) !== false) {
        $style = "style='background-color: var(--accent-purple);'";
      } else {
        $style = "";
      }
      if ($horseString == "") {
        $horseString = "&#8212";
      }
      echo "<div class='schedule-horse-info' {$style}>{$horseString}</div>";

      //Clients
      $clientString = "";
      if ($event['clients'][0] != "") {
        foreach ($event['clients'] as $clientName) {
          $clientString .= "<i>Clients: </i>";
          if (in_array($clientName, $event['attendance'])) {
            $clientString .= $clientName . "<br>";
          } else {
            $clientString .= "<s style='color: red;'>" . $clientName . "</s><br>";
          }
        }
      }
      if ($clientString == "") {
        $clientString = "&#8212";
      }
      if (strpos($clientString, $selectedName) !== false) {
        $style = "style='background-color: var(--accent-purple);'";
      } else {
        $style = "";
      }
      echo "<p class='schedule-clients' {$style}>{$clientString}</p>";


    }

    echo "</div>";

  ?>

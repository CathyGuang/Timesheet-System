
  <?php

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
    <p class="schedule-display-title" style="height: 5vh;">Title:</p>
    <p class="schedule-event-type" style="height: 5vh;">Class/Shift:</p>
    <p class="schedule-staff" style="height: 5vh;">Staff:</p>
    <p class="schedule-clients" style="height: 5vh;">Clients:</p>
    <p class="schedule-horse-info" style="height: 5vh;">Horse:</p>
    <p class="schedule-equipment-info" style="height: 5vh;">Equipment:</p>
    <p class="schedule-volunteers" style="height: 5vh;">Volunteers:</p>
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

      //Display title:
      echo "<p class='schedule-display-title'>{$event['display_title']}</p>";

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


      //Horse
      $horseString = "";
      if ($event['horses'] && $event['horses'][0] != "") {
        foreach ($event['horses'] as $key => $horseName) {
          if ($horseName == "HORSE NEEDED") {
            $horseString .= "<i style='float:left;'>Horse:&nbsp</i><div style='color: red; float: left;'>{$horseName}</div>, ";
          } else {
            $horseString .= "<i>Horse: </i>" . $horseName . ", ";
          }
          $horseString .= "<br>";
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


      //Equipment
      var_dump($event['tacks']);
      var_dump($event['pads']);
      var_dump($event['tack_notes']);
      var_dump($event['client_equipment_notes']);
      $equipmentString = "";
      if ($event['horses']) {
        foreach (range(0,25,1) as $key) {
          $newStuff = false;
          if ($event['tacks'][$key] and $event['tacks'][$key] != "\"\"") {
            $tackName = rtrim(ltrim($event['tacks'][$key], "\""), "\"");
            $equipmentString .= "<i>Tack: </i>" . $tackName . ", ";
            $newStuff = true;
          }
          if ($event['pads'][$key] and $event['pads'][$key] != "\"\"") {
            $padName = rtrim(ltrim($event['pads'][$key], "\""), "\"");
            $equipmentString .= "<i>Pad: </i>" . $padName . ", ";
            $newStuff = true;
          }
          if ($event['tack_notes'][$key] and $event['tack_notes'][$key] != "" and $event['tack_notes'][$key] != "\"\"") {
            $tackNotes = rtrim(ltrim($event['tack_notes'][$key], "\""), "\"");
            $equipmentString .= "<i>Notes: </i>" . $tackNotes . ", ";
            $newStuff = true;
          }
          if ($event['client_equipment_notes'][$key] and $event['client_equipment_notes'][$key] != "" and $event['client_equipment_notes'][$key] != "\"\"") {
            $clientEquipmentNotes = rtrim(ltrim($event['client_equipment_notes'][$key], "\""), "\"");
            $equipmentString .= "<i>Client: </i>" . $clientEquipmentNotes . ', ';
            $newStuff = true;
          }
          if ($newStuff) {$equipmentString .= "<br>";}
        }
      }
      if (strpos($equipmentString, $selectedName) !== false) {
        $style = "style='background-color: var(--accent-purple);'";
      } else {
        $style = "";
      }
      if ($equipmentString == "") {
        $equipmentString = "&#8212";
      }
      echo "<div class='schedule-equipment-info' {$style}>{$equipmentString}</div>";


      //Volunteers
      $volunteerString = "";
      if ($event['volunteers']) {
        foreach ($event['volunteers'] as $role => $volunteerName) {
          if ($role == "") {continue;}
          if ($volunteerName == "NEEDED") {
            $volunteerString .= "<div style='float:left;'>{$role}:&nbsp</div><div style='color: yellow;'>{$volunteerName}</div><br>";
          } else {
            $volunteerString .= $role . ": " . $volunteerName . "<br>";
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


    }

    echo "</div>";

  ?>

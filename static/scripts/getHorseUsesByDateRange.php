<?php
function getHorseUsesByDateRange($id, $date1, $date2) {
  //connect to database
  include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php";

  //initialize $QUERY_ID for getHorseInvolvedClasses script
  $QUERY_ID = $id;
  include $_SERVER['DOCUMENT_ROOT']."/static/scripts/getHorseInvolvedClasses.php";


  $interval = new DateInterval('P1D');
  $date1 = new DateTime($date1);
  $date2 = new DateTime($date2);
  $period = new DatePeriod($date1, $interval, $date2);

  //Initialize use counter variable:
  $totalHorseUses = 0;

  //var_dump($allClasses);

  foreach ($period as $dayData) {
    $day = Date('Y-m-d', strtotime($dayData->format('Y-m-d')));
    foreach ($allClasses as $classData) {
      if ($classData['date_of_class'] == $day) {
        $totalHorseUses++;
      }
    }
  }
  return $totalHorseUses;
};

?>

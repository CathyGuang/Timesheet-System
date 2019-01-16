<?php
function getHorseUsesByDateRange($id, $date1, $date2) {
  //connect to database
  include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php";

  //initialize $QUERY_ID for getHorseInvolvedClasses script
  $QUERY_ID = $id;
  include $_SERVER['DOCUMENT_ROOT']."/static/scripts/getHorseInvolvedClasses.php";


  $interval = DateInterval::createFromDateString('1 day');
  $period = new DatePeriod($date1, $interval, $date2);

  foreach ($period as $day) {
    var_dump($day);
  }


  return $totalHorseUses;
};

?>

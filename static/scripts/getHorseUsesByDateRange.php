<?php
function getHorseUsesByDateRange($id, $date1, $date2) {
  //connect to database
  include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php";

  //initialize $QUERY_ID for getHorseInvolvedClasses script
  $QUERY_ID = $id;
  include $_SERVER['DOCUMENT_ROOT']."/static/scripts/getHorseInvolvedClasses.php";

  var_dump($allClasses);


  return $totalHorseUses;
};

?>

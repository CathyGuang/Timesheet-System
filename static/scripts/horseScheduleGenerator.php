
  <?php
    //MAKE SURE _POST INCLUDES THESE TWO PARAMETERS!!
    $selectedName = $_POST['selected-name'];
    $selectedDate = $_POST['selected-date'];

    $QUERY_NAME = $selectedName;
    //these scripts generate the variables $allClasses,
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/getHorseInvolvedClasses.php";

    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/pureScheduleGenerator.php";
  ?>

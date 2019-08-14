
  <?php
    //MAKE SURE _POST INCLUDES THESE TWO PARAMETERS!!
    $selectedName = $_POST['selected-name'];
    $selectedDate = $_POST['selected-date'];

    $FETCH_OLD_CLASSES = false;

    $QUERY_NAME = $selectedName;
    //these scripts generate the variables $allClasses, $allOfficeShifts, $allHorseCareShifts
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/getWorkerInvolvedClasses.php";
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/getWorkerInvolvedShifts.php";

    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/pureScheduleGenerator.php";
  ?>

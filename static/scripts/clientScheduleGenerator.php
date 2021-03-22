
  <?php
    //MAKE SURE POST INCLUDES THESE TWO PARAMETERS!!
    $selectedName = $_POST['selected-name'];
    $selectedDate = $_POST['selected-date'];

    $QUERY_NAME = $_POST['selected-name'];
    //this script generates the variable $allClasses
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/getClientInvolvedClasses.php";

    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/pureScheduleGenerator.php";
  ?>

<?php
  if ($QUERY_NAME == "ALL") {
    $query = <<<EOT
    SELECT * FROM classes WHERE (archived IS NULL OR archived = '');
EOT;
  } else {
    $queryID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE workers.name = '{$QUERY_NAME}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];

    $query = <<<EOT
    SELECT *
    FROM classes, jsonb_each_text(classes.staff) WHERE
    (
    '{$queryID}' = value
    )
EOT;
    if (!$FETCH_OLD_CLASSES) {// only ignore archived classes if $FETCH_OLD_CLASSES is not set to true
      echo "OK1";
      $query .= <<<EOT
      AND (
      (archived IS NULL OR archived = '')
      )
EOT;
    }
    $query .= <<<EOT
    UNION ALL

    SELECT *
    FROM classes, jsonb_each_text(classes.volunteers) WHERE
    (
    '{$queryID}' = value
    )
EOT;
    if (!$FETCH_OLD_CLASSES) {// only ignore archived classes if $FETCH_OLD_CLASSES is not set to true
      echo 'OK2';
      $query .= <<<EOT
      AND (
      (archived IS NULL OR archived = '')
      )
EOT;
    }
    $query .= <<<EOT
    ;
EOT;
  }

  $result = pg_query($db_connection, $query);

  $allClasses = pg_fetch_all($result);

  if (!$allClasses) {return;}

  include $_SERVER['DOCUMENT_ROOT']."/static/scripts/pureGetInvolvedClasses.php";

?>

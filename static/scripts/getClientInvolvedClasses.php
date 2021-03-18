<?php
  $queryID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM clients WHERE name = '{$QUERY_NAME}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];

  $query = <<<EOT
  SELECT * FROM classes WHERE
  {$queryID} = ANY(clients) AND
  (archived IS NULL OR archived = '')
  ;
EOT;

  $result = pg_query($db_connection, $query);

  $allClasses = pg_fetch_all($result);

  if (!$allClasses) {return;}

  include $_SERVER['DOCUMENT_ROOT']."/static/scripts/pureGetInvolvedClasses.php";

?>

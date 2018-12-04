<?php
  $queryID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE workers.name = '{$QUERY_NAME}';"), 0, 1)['id'];

  $query = <<<EOT
  SELECT class_type, date_of_class, classes.id, name FROM classes, clients WHERE
  (instructor = {$queryID} OR
  therapist = {$queryID} OR
  equine_specialist = {$queryID} OR
  leader = {$queryID} OR
  {$queryID} = ANY(sidewalkers)) AND
  clients.id = ANY(classes.clients)
  ;
EOT;

  $result = pg_query($db_connection, $query);

  $allClasses = pg_fetch_all($result);


?>

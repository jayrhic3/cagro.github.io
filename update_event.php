<?php

//update.php

include('connection.php');


if(isset($_POST["id"]))
{
 $query = "
 UPDATE project_program 
 SET title=:title, start_event=:start_event, end_event=:end_event,descrip=:des,barangay=:barang 
 WHERE id=:id
 ";
 $statement = $connection->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end'],
   ':des'   => $_POST['des'],
   ':barang'   => $_POST['barang'],
   ':id'   => $_POST['id']
  )
 );
}

?>

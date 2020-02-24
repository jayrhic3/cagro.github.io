<?php

//delete.php
include('connection.php');

if(isset($_POST["id"]))
{

 $query = "
 DELETE from project_program WHERE id=:id
 ";
 $statement = $connection->prepare($query);
 $statement->execute(
  array(
   ':id' => $_POST['id']
  )
 );
}

?>
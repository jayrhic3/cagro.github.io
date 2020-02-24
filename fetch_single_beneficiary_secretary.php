<?php 

include('connection.php');
$id=$_POST['user_id'];
$name='';
$query="SELECT * from beneficiaries where id='$id'";
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{
   $name.=$row["firstname"].' '.$row["lastname"];
}


echo json_encode($name);

?>
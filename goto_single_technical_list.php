<?php 
session_start();
include('connection.php');

$_SESSION['beneficiary_id']=$_POST['user_id'];
$id=$_SESSION['beneficiary_id'];
$query="SELECT t1.lastname as lastname,t1.firstname as firstname from recent_request as t2 inner join beneficiaries as t1 on t1.id=t2.beneficiary_id where t2.beneficiary_id='$id'";
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
    {
       $_SESSION["name"]=$row["lastname"].', '.$row["firstname"];
    }



?>
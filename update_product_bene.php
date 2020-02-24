<?php 

include('connection.php');


$id=$_POST["id"];
$value=$_POST["value"];

$statement = $connection->prepare("UPDATE beneficiary_record_product SET ".$column_name."='".$value."' WHERE unique_id = '".$id."'");
$result = $statement->execute();
    if(!empty($result))
    {
        echo 'Data Updated';
    }
    else{
        echo $result;
    }




?>
<?php 

include('connection.php');

$num=$_POST["num"];
$qty=$_POST["qty"];
$unit=$_POST["unit"];
$item=$_POST["item"];
$bene_id=$_POST["bene_id"];
$req_id=$_POST["req_id"];

$date=date('Y-m-d H:i:s');
$cdate=date('F j, Y',strtotime($date));

$statement = $connection->prepare("CALL add_products('$num','$qty','$unit','$item','$bene_id','$req_id','$cdate','$date',@unique_id)");
$result = $statement->execute();
    if(!empty($result))
    {
        echo 'Data Inserted';
    }
    else{
        echo $result;
    }




?>
<?php
include('connection.php');
$query = ''; 
$output = array();
$id=$_POST["user_id"];

$query = "SELECT t2.quantity as qty,t1.units as unit,t1.product_name as item_description,t2.unique_id as unique_id,t1.id as id from 
inventory_all_products as t1 inner join beneficiary_record_product as t2 on
 t2.product_id =t1.id and t2.request_id='$id' where t2.status='On Going' OR t2.status='Done'";

    $sub_array = array();
    $services='';
    $quantity='';
    $id='';
    $unique='';
    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
     $services.=$row["item_description"].',';
     $quantity.=$row["qty"].',';
     $id.=$row["id"].',';
     $unique.=$row["unique_id"].',';
    }

    $sub_array["product"]=$services;
    $sub_array["qty"]=$quantity;
    $sub_array["id"]=$id;
    $sub_array["unique"]=$unique;

echo json_encode($sub_array);
?>
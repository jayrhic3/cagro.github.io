<?php
include('connection.php');
    $id=array();
    $id=$_POST['user_id'];
    $arr=array();
    $arr=explode(",",trim($id[0]));
    $product_name="";
    $quantity="";
    $data_id="";
    $output=array();

    $query="SELECT * from inventory_all_products";
    $statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		foreach($arr as $arr2){
            if($arr2 == $row["id"]){
                $product_name.=$row["product_name"].",";
                $quantity.=$row["quantity"].",";
                $data_id.=$row["id"].",";
            }
        }
    }
    

    $output["product_name"]=$product_name;
    $output["quantity"]=$quantity;
    $output["id"]=$data_id;
	echo json_encode($output);

?>
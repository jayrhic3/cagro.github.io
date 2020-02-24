<?php
include('connection.php');
    $output1 = 'All,';
	$output=array();
    $type=$_POST['type'];
        $query="SELECT * FROM inventory_all_products WHERE type_product='$type' group by product_name";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["product_name"].",";
	    }
    
    
	$output["municipality"]=$output1;
	echo json_encode($output);

?>
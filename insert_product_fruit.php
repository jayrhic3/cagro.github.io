<?php

//insert.php

include('connection.php');

if(isset($_POST["product_name"]))
{
    $product_name=$_POST['product_name'];
    $units=$_POST['units'];
    $quantity=$_POST['quantity'];
    $count=0;
    $count2=0;
    $date=date('Y-m-d H:i:s');
	$cdate=date('F j, Y',strtotime($date));

    $query_check="SELECT * from unit_q";
    $statement2 = $connection->prepare($query_check);
    $result2 = $statement2->execute();
    $result2 = $statement2->fetchAll();
	foreach($result2 as $row)
	{
        if(strtoupper($row["unit_prod"])==strtoupper($units)){
            $count+=1;
        }else{
            $count=0;
        }
    }

    $query_check2="SELECT des from product_name";
    $statement3 = $connection->prepare($query_check2);
    $result3 = $statement3->execute();
    $result3 = $statement3->fetchAll();
	foreach($result3 as $row)
	{
        if(strtoupper($row["des"])==strtoupper($product_name)){
            $count2+=1;
        }else{
            $count2=0;
        }
    }
    
    if($count==0){
        $query4="INSERT INTO unit_q(unit_prod) values('$units')";
        $statement4 = $connection->prepare($query4);
        $statement4->execute();
    }
    if($count2==0){
        $query5="INSERT INTO product_name(des) values('$product_name')";
        $statement5 = $connection->prepare($query5);
        $statement5->execute();
    }

    $query = "INSERT INTO inventory_all_products 
    (product_name, units , quantity,despensed,type_product,status_updated,word_created) 
    VALUES ('$product_name','$units','$quantity','0','Fruit_Trees_Seedlings','Latest','$cdate')";
    $statement = $connection->prepare($query);
    $result = $statement->execute();
    if(!empty($result))
    {
        echo 'Succesfully Added';
    }else{
        echo "wrong";
    }
}


?>

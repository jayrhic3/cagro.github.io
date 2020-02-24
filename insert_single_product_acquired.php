<?php

//insert.php

include('connection.php');
$id=array();
$quantity=array();
$arr1=array();
$arr2=array();
$dif=0;
$des=0;

$id=$_POST["id"];
$quantity=$_POST["quantity"];
$arr1=explode(",",trim($id[0]));
$arr2=explode(",",trim($quantity[0]));

$date=date('Y-m-d H:i:s');
$cdate=date('F j, Y',strtotime($date));

$bene_id=$_POST["bene_id"];
$request_id=$_POST["request_id"];



foreach($arr2 as $index=>$value){
    $statement = $connection->prepare("CALL add_products('$bene_id','$request_id','$cdate','$date',@unique_id,'$value','$arr1[$index]')");
    $statement->execute();
}
    /*
    $query2="SELECT * from inventory_all_products where status_updated='Latest'";
    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
	foreach($result2 as $row2)
	{
		foreach($arr1 as $index=>$value){
            if($row2['id']==$value){
                $dif=($row2['quantity']-$arr2[$index]);
                $des=($row2['despensed']+$arr2[$index]);
                $query3="UPDATE inventory_all_products SET quantity='$dif',despensed='$des' WHERE id='$value'";
                $statement3 = $connection->prepare($query3);
                $statement3->execute();
            }
        }
    }
*/
echo json_encode("Product Succesfully Added!");

?>

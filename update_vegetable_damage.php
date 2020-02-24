<?php
include('connection.php');

        $id=$_POST['cid'];
        $quantity=$_POST['quantity'];
        $dif=0;
        $sum=0;

        $query3="SELECT quantity,damage from inventory_all_products where id='$id'";
        $statement3 = $connection->prepare($query3);
        $statement3->execute();
        $result3 = $statement3->fetchAll();
        foreach($result3 as $row){
            if($quantity>$row["quantity"]){
                echo 'Quantity is higher than the stock, please check the field!';
            }else{
                $sum=($row['damage']+$quantity);
                $query2="UPDATE inventory_all_products set damage='$sum' where id='$id'";
                $statement2 = $connection->prepare($query2);
                $result2 = $statement2->execute();
            
                $dif=($row['quantity']-$quantity);
                $query4="UPDATE inventory_all_products set quantity='$dif' where id = '$id'";
                $statement4=$connection->prepare($query4);
                $statement4->execute();
                echo 'Succesfully Updated';
            }
            
        }

?>
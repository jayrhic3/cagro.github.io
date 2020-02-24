<?php 
session_start();
$_SESSION['product'];
include('connection.php');
$arr1=array();
$arr2=array();

$year=$_POST['year'];
$type=$_POST['type'];
$yeart=$_POST['yeart'];
$yearf=$_POST['yearf'];
$datef=$_POST['datef'];
$datet=$_POST['datet'];

if($type==='Monthly'){
   
$query="SELECT max(t1.quantity) as high,t1.name as name from (select sum(t2.quantity) as quantity,
t1.type_product as name from inventory_all_products as t1 inner join beneficiary_record_product as t2
 on t1.id=t2.product_id and year(t2.created_at)='$year' group by t1.type_product order by quantity desc) as t1";
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

foreach($result as $row)
{
  if($row["name"]=='Chemicals'){
    $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Chemicals' and year(t2.created_at)='$year' group by t2.product_id order by quan desc limit 5";
     $statement2 = $connection->prepare($query2);
     $statement2->execute();
     $result2 = $statement2->fetchAll();
     foreach($result2 as $row2){
        $arr1[]=$row2["quan"];
        $arr2[]=$row2["name"];
     }
  }
  else if($row["name"]=='Vegetables_Seedlings/Seeds'){
    $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
     inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
     t1.type_product='Vegetables_Seedlings/Seeds' and year(t2.created_at)='$year' group by t2.product_id order by quan desc limit 5";

     $statement2 = $connection->prepare($query2);
     $statement2->execute();
     $result2 = $statement2->fetchAll();
     foreach($result2 as $row2){
        $arr1[]=$row2["quan"];
        $arr2[]=$row2["name"];
     }
  }
  else if($row["name"]=='Fertilizers'){
   $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Fertilizers' and year(t2.created_at)='$year' group by t2.product_id order by quan desc limit 5";

    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach($result2 as $row2){
       $arr1[]=$row2["quan"];
       $arr2[]=$row2["name"];
    }
 }
 else if($row["name"]=='Fruit_Trees_Seedlings'){
   $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Fruit_Trees_Seedlings' and year(t2.created_at)='$year' group by t2.product_id order by quan desc limit 5";

    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach($result2 as $row2){
       $arr1[]=$row2["quan"];
       $arr2[]=$row2["name"];
    }
 }
 else if($row["name"]=='Organic/Vermicast'){
   $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Organic/Vermicast' and year(t2.created_at)='$year' group by t2.product_id order by quan desc limit 5";

    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach($result2 as $row2){
       $arr1[]=$row2["quan"];
       $arr2[]=$row2["name"];
    }
 }
 else if($row["name"]=='Corn_Seeds'){
   $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Corn_Seeds' and year(t2.created_at)='$year' group by t2.product_id order by quan desc limit 5";

    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach($result2 as $row2){
       $arr1[]=$row2["quan"];
       $arr2[]=$row2["name"];
    }
 }
 else if($row["name"]=='Rice_Seeds'){
   $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Rice_Seeds' and year(t2.created_at)='$year' group by t2.product_id order by quan desc limit 5";

    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach($result2 as $row2){
       $arr1[]=$row2["quan"];
       $arr2[]=$row2["name"];
    }
 }
 $_SESSION['product']=$row['name'];
}

$dataPoints = array();
$data = array();

   foreach($arr1 as $key=>$value){
      $data['y']=intval($value);
      $data['label']=$arr2[$key];
      $data['name']=$arr2[$key]."(".$value.")";
      $dataPoints[]=$data;
   }
echo json_encode($dataPoints);

}else if($type==='Yearly'){
     
$query="SELECT max(t1.quantity) as high,t1.name as name from (select sum(t2.quantity) as quantity,
t1.type_product as name from inventory_all_products as t1 inner join beneficiary_record_product as t2
 on t1.id=t2.product_id where year(t2.created_at) between '$yearf' and '$yeart' group by t1.type_product order by quantity desc) as t1";
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

foreach($result as $row)
{
  if($row["name"]=='Chemicals'){
    $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Chemicals' where year(t2.created_at) between '$yearf' and '$yeart' group by t2.product_id order by quan desc limit 5";
     $statement2 = $connection->prepare($query2);
     $statement2->execute();
     $result2 = $statement2->fetchAll();
     foreach($result2 as $row2){
        $arr1[]=$row2["quan"];
        $arr2[]=$row2["name"];
     }
  }
  else if($row["name"]=='Vegetables_Seedlings/Seeds'){
    $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
     inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
     t1.type_product='Vegetables_Seedlings/Seeds' where year(t2.created_at) between '$yearf' and '$yeart' group by t2.product_id order by quan desc limit 5";

     $statement2 = $connection->prepare($query2);
     $statement2->execute();
     $result2 = $statement2->fetchAll();
     foreach($result2 as $row2){
        $arr1[]=$row2["quan"];
        $arr2[]=$row2["name"];
     }
  }
  else if($row["name"]=='Fertilizers'){
   $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Fertilizers' where year(t2.created_at) between '$yearf' and '$yeart' group by t2.product_id order by quan desc limit 5";

    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach($result2 as $row2){
       $arr1[]=$row2["quan"];
       $arr2[]=$row2["name"];
    }
 }
 else if($row["name"]=='Fruit_Trees_Seedlings'){
   $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Fruit_Trees_Seedlings' where year(t2.created_at) between '$yearf' and '$yeart' group by t2.product_id order by quan desc limit 5";

    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach($result2 as $row2){
       $arr1[]=$row2["quan"];
       $arr2[]=$row2["name"];
    }
 }
 else if($row["name"]=='Organic/Vermicast'){
   $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Organic/Vermicast' where year(t2.created_at) between '$yearf' and '$yeart' group by t2.product_id order by quan desc limit 5";

    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach($result2 as $row2){
       $arr1[]=$row2["quan"];
       $arr2[]=$row2["name"];
    }
 }
 else if($row["name"]=='Corn_Seeds'){
   $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Corn_Seeds' where year(t2.created_at) between '$yearf' and '$yeart' group by t2.product_id order by quan desc limit 5";

    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach($result2 as $row2){
       $arr1[]=$row2["quan"];
       $arr2[]=$row2["name"];
    }
 }
 else if($row["name"]=='Rice_Seeds'){
   $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Rice_Seeds' where year(t2.created_at) between '$yearf' and '$yeart' group by t2.product_id order by quan desc limit 5";

    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach($result2 as $row2){
       $arr1[]=$row2["quan"];
       $arr2[]=$row2["name"];
    }
 }
 $_SESSION['product']=$row['name'];
}

$dataPoints = array();
$data = array();

   foreach($arr1 as $key=>$value){
      $data['y']=intval($value);
      $data['label']=$arr2[$key];
      $data['name']=$arr2[$key]."(".$value.")";
      $dataPoints[]=$data;
   }
echo json_encode($dataPoints);
}else if($type==='Customize'){
   $query="SELECT max(t1.quantity) as high,t1.name as name from (select sum(t2.quantity) as quantity,
t1.type_product as name from inventory_all_products as t1 inner join beneficiary_record_product as t2
 on t1.id=t2.product_id where DATE_FORMAT(t2.created_at,'%Y-%m-%d') between '$datef' and '$datet' group by t1.type_product order by quantity desc) as t1";
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

foreach($result as $row)
{
  if($row["name"]=='Chemicals'){
    $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Chemicals' where DATE_FORMAT(t2.created_at,'%Y-%m-%d') between '$datef' and '$datet' group by t2.product_id order by quan desc limit 5";
     $statement2 = $connection->prepare($query2);
     $statement2->execute();
     $result2 = $statement2->fetchAll();
     foreach($result2 as $row2){
        $arr1[]=$row2["quan"];
        $arr2[]=$row2["name"];
     }
  }
  else if($row["name"]=='Vegetables_Seedlings/Seeds'){
    $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
     inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
     t1.type_product='Vegetables_Seedlings/Seeds' where DATE_FORMAT(t2.created_at,'%Y-%m-%d') between '$datef' and '$datet' group by t2.product_id order by quan desc limit 5";

     $statement2 = $connection->prepare($query2);
     $statement2->execute();
     $result2 = $statement2->fetchAll();
     foreach($result2 as $row2){
        $arr1[]=$row2["quan"];
        $arr2[]=$row2["name"];
     }
  }
  else if($row["name"]=='Fertilizers'){
   $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Fertilizers' where DATE_FORMAT(t2.created_at,'%Y-%m-%d') between '$datef' and '$datet' group by t2.product_id order by quan desc limit 5";

    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach($result2 as $row2){
       $arr1[]=$row2["quan"];
       $arr2[]=$row2["name"];
    }
 }
 else if($row["name"]=='Fruit_Trees_Seedlings'){
   $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Fruit_Trees_Seedlings' where DATE_FORMAT(t2.created_at,'%Y-%m-%d') between '$datef' and '$datet' group by t2.product_id order by quan desc limit 5";

    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach($result2 as $row2){
       $arr1[]=$row2["quan"];
       $arr2[]=$row2["name"];
    }
 }
 else if($row["name"]=='Organic/Vermicast'){
   $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Organic/Vermicast' where DATE_FORMAT(t2.created_at,'%Y-%m-%d') between '$datef' and '$datet' group by t2.product_id order by quan desc limit 5";

    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach($result2 as $row2){
       $arr1[]=$row2["quan"];
       $arr2[]=$row2["name"];
    }
 }
 else if($row["name"]=='Corn_Seeds'){
   $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Corn_Seeds' where DATE_FORMAT(t2.created_at,'%Y-%m-%d') between '$datef' and '$datet' group by t2.product_id order by quan desc limit 5";

    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach($result2 as $row2){
       $arr1[]=$row2["quan"];
       $arr2[]=$row2["name"];
    }
 }
 else if($row["name"]=='Rice_Seeds'){
   $query2="SELECT sum(t2.quantity) as quan,t1.product_name as name from inventory_all_products as t1
    inner join beneficiary_record_product as t2 on t1.id = t2.product_id and 
    t1.type_product='Rice_Seeds' where DATE_FORMAT(t2.created_at,'%Y-%m-%d') between '$datef' and '$datet' group by t2.product_id order by quan desc limit 5";

    $statement2 = $connection->prepare($query2);
    $statement2->execute();
    $result2 = $statement2->fetchAll();
    foreach($result2 as $row2){
       $arr1[]=$row2["quan"];
       $arr2[]=$row2["name"];
    }
 }
 $_SESSION['product']=$row['name'];
}

$dataPoints = array();
$data = array();

   foreach($arr1 as $key=>$value){
      $data['y']=intval($value);
      $data['label']=$arr2[$key];
      $data['name']=$arr2[$key]."(".$value.")";
      $dataPoints[]=$data;
   }
echo json_encode($dataPoints);
}

?>
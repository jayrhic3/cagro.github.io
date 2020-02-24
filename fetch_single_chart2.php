<?php 

session_start();
include('connection.php');

$year=$_POST['year'];
$type=$_POST['type'];
$yeart=$_POST['yeart'];
$yearf=$_POST['yearf'];
$datef=$_POST['datef'];
$datet=$_POST['datet'];


if($type==='Monthly'){
$vegetable=0;
$fruit=0;
$organic=0;
$rice=0;
$chemicals=0;
$corn=0;
$fertilizer=0;

$statement = $connection->prepare("SELECT sum(t2.quantity) as num,t1.product_name as name,t1.type_product as type,month(t2.created_at) as month from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at)='$year' and month(t2.created_at)=1 group by month(t2.created_at), type_product");
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{

if($row['type']=="Vegetables_Seedlings/Seeds"){
     $vegetable=$row['num'];
}
else if($row['type']=="Fruit_Trees_Seedlings"){
     $fruit=$row['num'];
}
else if($row['type']=="Organic/Vermicast"){
     $organic=$row['num'];
}
else if($row['type']=="Fertilizers"){
     $fertilizer=$row['num'];
}
else if($row['type']=="Rice_Seeds"){
     $rice=$row['num'];
}
else if($row['type']=="Chemicals"){
     $chemicals=$row['num'];
}
else if($row['type']=="Corn_Seeds"){
     $corn=$row['num'];
}
}
$array =array();
$dataPoints = array( 
     array("y" => intval($vegetable), "label" => "Vegetables","name"=>"Vegetable Seeds"."(".intval($vegetable).")"),
     array("y" => intval($fruit), "label" => "Fruit","name"=>"Fruit Trees"."(".intval($fruit).")" ),
     array("y" => intval($organic), "label" => "Organic","name"=>"Organic"."(".intval($organic).")" ),
     array("y" => intval($fertilizer), "label" => "Fertilizers","name"=>"Fertilizers"."(".intval($fertilizer).")" ),
     array("y" => intval($chemicals), "label" => "Chemicals","name"=>"Chemicals"."(".intval($chemicals).")" ),
     array("y" => intval($rice), "label" => "Rice","name"=>"Rice Seeds"."(".intval($rice).")" ),
array("y" => intval($corn), "label" => "Corn","name"=>"Corn Seeds"."(".intval($corn).")" ),
);
$array[]=$dataPoints;

$vegetable=0;
$fruit=0;
$organic=0;
$rice=0;
$chemicals=0;
$corn=0;
$fertilizer=0;
$statement = $connection->prepare("SELECT sum(t2.quantity) as num,t1.product_name as name,t1.type_product as type,month(t2.created_at) as month from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at)='$year' and month(t2.created_at)=2 group by month(t2.created_at), type_product");
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{

if($row['type']=="Vegetables_Seedlings/Seeds"){
     $vegetable=$row['num'];
}
else if($row['type']=="Fruit_Trees_Seedlings"){
     $fruit=$row['num'];
}
else if($row['type']=="Organic/Vermicast"){
     $organic=$row['num'];
}
else if($row['type']=="Fertilizers"){
     $fertilizer=$row['num'];
}
else if($row['type']=="Rice_Seeds"){
     $rice=$row['num'];
}
else if($row['type']=="Chemicals"){
     $chemicals=$row['num'];
}
else if($row['type']=="Corn_Seeds"){
     $corn=$row['num'];
}
}
$dataPoints = array( 
     array("y" => intval($vegetable), "label" => "Vegetables","name"=>"Vegetable Seeds"."(".intval($vegetable).")"),
     array("y" => intval($fruit), "label" => "Fruit","name"=>"Fruit Trees"."(".intval($fruit).")" ),
     array("y" => intval($organic), "label" => "Organic","name"=>"Organic"."(".intval($organic).")" ),
     array("y" => intval($fertilizer), "label" => "Fertilizers","name"=>"Fertilizers"."(".intval($fertilizer).")" ),
     array("y" => intval($chemicals), "label" => "Chemicals","name"=>"Chemicals"."(".intval($chemicals).")" ),
     array("y" => intval($rice), "label" => "Rice","name"=>"Rice Seeds"."(".intval($rice).")" ),
array("y" => intval($corn), "label" => "Corn","name"=>"Corn Seeds"."(".intval($corn).")" ),
);
$array[]=$dataPoints;

$vegetable=0;
$fruit=0;
$organic=0;
$rice=0;
$chemicals=0;
$corn=0;
$fertilizer=0;
$statement = $connection->prepare("SELECT sum(t2.quantity) as num,t1.product_name as name,t1.type_product as type,month(t2.created_at) as month from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at)='$year' and month(t2.created_at)=3 group by month(t2.created_at), type_product");
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{

if($row['type']=="Vegetables_Seedlings/Seeds"){
     $vegetable=$row['num'];
}
else if($row['type']=="Fruit_Trees_Seedlings"){
     $fruit=$row['num'];
}
else if($row['type']=="Organic/Vermicast"){
     $organic=$row['num'];
}
else if($row['type']=="Fertilizers"){
     $fertilizer=$row['num'];
}
else if($row['type']=="Rice_Seeds"){
     $rice=$row['num'];
}
else if($row['type']=="Chemicals"){
     $chemicals=$row['num'];
}
else if($row['type']=="Corn_Seeds"){
     $corn=$row['num'];
}
}
$dataPoints = array( 
     array("y" => intval($vegetable), "label" => "Vegetables","name"=>"Vegetable Seeds"."(".intval($vegetable).")"),
     array("y" => intval($fruit), "label" => "Fruit","name"=>"Fruit Trees"."(".intval($fruit).")" ),
     array("y" => intval($organic), "label" => "Organic","name"=>"Organic"."(".intval($organic).")" ),
     array("y" => intval($fertilizer), "label" => "Fertilizers","name"=>"Fertilizers"."(".intval($fertilizer).")" ),
     array("y" => intval($chemicals), "label" => "Chemicals","name"=>"Chemicals"."(".intval($chemicals).")" ),
     array("y" => intval($rice), "label" => "Rice","name"=>"Rice Seeds"."(".intval($rice).")" ),
array("y" => intval($corn), "label" => "Corn","name"=>"Corn Seeds"."(".intval($corn).")" ),
);

$array[]=$dataPoints;

$vegetable=0;
$fruit=0;
$organic=0;
$rice=0;
$chemicals=0;
$corn=0;
$fertilizer=0;
$statement = $connection->prepare("SELECT sum(t2.quantity) as num,t1.product_name as name,t1.type_product as type,month(t2.created_at) as month from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at)='$year' and month(t2.created_at)=4 group by month(t2.created_at), type_product");
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{

if($row['type']=="Vegetables_Seedlings/Seeds"){
     $vegetable=$row['num'];
}
else if($row['type']=="Fruit_Trees_Seedlings"){
     $fruit=$row['num'];
}
else if($row['type']=="Organic/Vermicast"){
     $organic=$row['num'];
}
else if($row['type']=="Fertilizers"){
     $fertilizer=$row['num'];
}
else if($row['type']=="Rice_Seeds"){
     $rice=$row['num'];
}
else if($row['type']=="Chemicals"){
     $chemicals=$row['num'];
}
else if($row['type']=="Corn_Seeds"){
     $corn=$row['num'];
}
}
$dataPoints = array( 
     array("y" => intval($vegetable), "label" => "Vegetables","name"=>"Vegetable Seeds"."(".intval($vegetable).")"),
     array("y" => intval($fruit), "label" => "Fruit","name"=>"Fruit Trees"."(".intval($fruit).")" ),
     array("y" => intval($organic), "label" => "Organic","name"=>"Organic"."(".intval($organic).")" ),
     array("y" => intval($fertilizer), "label" => "Fertilizers","name"=>"Fertilizers"."(".intval($fertilizer).")" ),
     array("y" => intval($chemicals), "label" => "Chemicals","name"=>"Chemicals"."(".intval($chemicals).")" ),
     array("y" => intval($rice), "label" => "Rice","name"=>"Rice Seeds"."(".intval($rice).")" ),
array("y" => intval($corn), "label" => "Corn","name"=>"Corn Seeds"."(".intval($corn).")" ),
);

$array[]=$dataPoints;

$vegetable=0;
$fruit=0;
$organic=0;
$rice=0;
$chemicals=0;
$corn=0;
$fertilizer=0;
$statement = $connection->prepare("SELECT sum(t2.quantity) as num,t1.product_name as name,t1.type_product as type,month(t2.created_at) as month from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at)='$year' and month(t2.created_at)=5 group by month(t2.created_at), type_product");
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{

if($row['type']=="Vegetables_Seedlings/Seeds"){
     $vegetable=$row['num'];
}
else if($row['type']=="Fruit_Trees_Seedlings"){
     $fruit=$row['num'];
}
else if($row['type']=="Organic/Vermicast"){
     $organic=$row['num'];
}
else if($row['type']=="Fertilizers"){
     $fertilizer=$row['num'];
}
else if($row['type']=="Rice_Seeds"){
     $rice=$row['num'];
}
else if($row['type']=="Chemicals"){
     $chemicals=$row['num'];
}
else if($row['type']=="Corn_Seeds"){
     $corn=$row['num'];
}
}
$dataPoints = array( 
     array("y" => intval($vegetable), "label" => "Vegetables","name"=>"Vegetable Seeds"."(".intval($vegetable).")"),
     array("y" => intval($fruit), "label" => "Fruit","name"=>"Fruit Trees"."(".intval($fruit).")" ),
     array("y" => intval($organic), "label" => "Organic","name"=>"Organic"."(".intval($organic).")" ),
     array("y" => intval($fertilizer), "label" => "Fertilizers","name"=>"Fertilizers"."(".intval($fertilizer).")" ),
     array("y" => intval($chemicals), "label" => "Chemicals","name"=>"Chemicals"."(".intval($chemicals).")" ),
     array("y" => intval($rice), "label" => "Rice","name"=>"Rice Seeds"."(".intval($rice).")" ),
array("y" => intval($corn), "label" => "Corn","name"=>"Corn Seeds"."(".intval($corn).")" ),
);

$array[]=$dataPoints;

$vegetable=0;
$fruit=0;
$organic=0;
$rice=0;
$chemicals=0;
$corn=0;
$fertilizer=0;
$statement = $connection->prepare("SELECT sum(t2.quantity) as num,t1.product_name as name,t1.type_product as type,month(t2.created_at) as month from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at)='$year' and month(t2.created_at)=6 group by month(t2.created_at), type_product");
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{

if($row['type']=="Vegetables_Seedlings/Seeds"){
     $vegetable=$row['num'];
}
else if($row['type']=="Fruit_Trees_Seedlings"){
     $fruit=$row['num'];
}
else if($row['type']=="Organic/Vermicast"){
     $organic=$row['num'];
}
else if($row['type']=="Fertilizers"){
     $fertilizer=$row['num'];
}
else if($row['type']=="Rice_Seeds"){
     $rice=$row['num'];
}
else if($row['type']=="Chemicals"){
     $chemicals=$row['num'];
}
else if($row['type']=="Corn_Seeds"){
     $corn=$row['num'];
}
}
$dataPoints = array( 
     array("y" => intval($vegetable), "label" => "Vegetables","name"=>"Vegetable Seeds"."(".intval($vegetable).")"),
     array("y" => intval($fruit), "label" => "Fruit","name"=>"Fruit Trees"."(".intval($fruit).")" ),
     array("y" => intval($organic), "label" => "Organic","name"=>"Organic"."(".intval($organic).")" ),
     array("y" => intval($fertilizer), "label" => "Fertilizers","name"=>"Fertilizers"."(".intval($fertilizer).")" ),
     array("y" => intval($chemicals), "label" => "Chemicals","name"=>"Chemicals"."(".intval($chemicals).")" ),
     array("y" => intval($rice), "label" => "Rice","name"=>"Rice Seeds"."(".intval($rice).")" ),
array("y" => intval($corn), "label" => "Corn","name"=>"Corn Seeds"."(".intval($corn).")" ),
);

$array[]=$dataPoints;


$vegetable=0;
$fruit=0;
$organic=0;
$rice=0;
$chemicals=0;
$corn=0;
$fertilizer=0;

$statement = $connection->prepare("SELECT sum(t2.quantity) as num,t1.product_name as name,t1.type_product as type,month(t2.created_at) as month from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at)='$year' and month(t2.created_at)=7 group by month(t2.created_at), type_product");
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{

if($row['type']=="Vegetables_Seedlings/Seeds"){
     $vegetable=$row['num'];
}
else if($row['type']=="Fruit_Trees_Seedlings"){
     $fruit=$row['num'];
}
else if($row['type']=="Organic/Vermicast"){
     $organic=$row['num'];
}
else if($row['type']=="Fertilizers"){
     $fertilizer=$row['num'];
}
else if($row['type']=="Rice_Seeds"){
     $rice=$row['num'];
}
else if($row['type']=="Chemicals"){
     $chemicals=$row['num'];
}
else if($row['type']=="Corn_Seeds"){
     $corn=$row['num'];
}
}

$dataPoints = array( 
     array("y" => intval($vegetable), "label" => "Vegetables","name"=>"Vegetable Seeds"."(".intval($vegetable).")"),
     array("y" => intval($fruit), "label" => "Fruit","name"=>"Fruit Trees"."(".intval($fruit).")" ),
     array("y" => intval($organic), "label" => "Organic","name"=>"Organic"."(".intval($organic).")" ),
     array("y" => intval($fertilizer), "label" => "Fertilizers","name"=>"Fertilizers"."(".intval($fertilizer).")" ),
     array("y" => intval($chemicals), "label" => "Chemicals","name"=>"Chemicals"."(".intval($chemicals).")" ),
     array("y" => intval($rice), "label" => "Rice","name"=>"Rice Seeds"."(".intval($rice).")" ),
array("y" => intval($corn), "label" => "Corn","name"=>"Corn Seeds"."(".intval($corn).")" ),
);
$array[]=$dataPoints;



$vegetable=0;
$fruit=0;
$organic=0;
$rice=0;
$chemicals=0;
$corn=0;
$fertilizer=0;
$statement = $connection->prepare("SELECT sum(t2.quantity) as num,t1.product_name as name,t1.type_product as type,month(t2.created_at) as month from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at)='$year' and month(t2.created_at)=8 group by month(t2.created_at), type_product");
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{

if($row['type']=="Vegetables_Seedlings/Seeds"){
     $vegetable=$row['num'];
}
else if($row['type']=="Fruit_Trees_Seedlings"){
     $fruit=$row['num'];
}
else if($row['type']=="Organic/Vermicast"){
     $organic=$row['num'];
}
else if($row['type']=="Fertilizers"){
     $fertilizer=$row['num'];
}
else if($row['type']=="Rice_Seeds"){
     $rice=$row['num'];
}
else if($row['type']=="Chemicals"){
     $chemicals=$row['num'];
}
else if($row['type']=="Corn_Seeds"){
     $corn=$row['num'];
}
}
$dataPoints = array( 
     array("y" => intval($vegetable), "label" => "Vegetables","name"=>"Vegetable Seeds"."(".intval($vegetable).")"),
     array("y" => intval($fruit), "label" => "Fruit","name"=>"Fruit Trees"."(".intval($fruit).")" ),
     array("y" => intval($organic), "label" => "Organic","name"=>"Organic"."(".intval($organic).")" ),
     array("y" => intval($fertilizer), "label" => "Fertilizers","name"=>"Fertilizers"."(".intval($fertilizer).")" ),
     array("y" => intval($chemicals), "label" => "Chemicals","name"=>"Chemicals"."(".intval($chemicals).")" ),
     array("y" => intval($rice), "label" => "Rice","name"=>"Rice Seeds"."(".intval($rice).")" ),
array("y" => intval($corn), "label" => "Corn","name"=>"Corn Seeds"."(".intval($corn).")" ),
);
$array[]=$dataPoints;

$vegetable=0;
$fruit=0;
$organic=0;
$rice=0;
$chemicals=0;
$corn=0;
$fertilizer=0;
$statement = $connection->prepare("SELECT sum(t2.quantity) as num,t1.product_name as name,t1.type_product as type,month(t2.created_at) as month from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at)='$year' and month(t2.created_at)=9 group by month(t2.created_at), type_product");
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{

if($row['type']=="Vegetables_Seedlings/Seeds"){
     $vegetable=$row['num'];
}
else if($row['type']=="Fruit_Trees_Seedlings"){
     $fruit=$row['num'];
}
else if($row['type']=="Organic/Vermicast"){
     $organic=$row['num'];
}
else if($row['type']=="Fertilizers"){
     $fertilizer=$row['num'];
}
else if($row['type']=="Rice_Seeds"){
     $rice=$row['num'];
}
else if($row['type']=="Chemicals"){
     $chemicals=$row['num'];
}
else if($row['type']=="Corn_Seeds"){
     $corn=$row['num'];
}
}
$dataPoints = array( 
     array("y" => intval($vegetable), "label" => "Vegetables","name"=>"Vegetable Seeds"."(".intval($vegetable).")"),
     array("y" => intval($fruit), "label" => "Fruit","name"=>"Fruit Trees"."(".intval($fruit).")" ),
     array("y" => intval($organic), "label" => "Organic","name"=>"Organic"."(".intval($organic).")" ),
     array("y" => intval($fertilizer), "label" => "Fertilizers","name"=>"Fertilizers"."(".intval($fertilizer).")" ),
     array("y" => intval($chemicals), "label" => "Chemicals","name"=>"Chemicals"."(".intval($chemicals).")" ),
     array("y" => intval($rice), "label" => "Rice","name"=>"Rice Seeds"."(".intval($rice).")" ),
array("y" => intval($corn), "label" => "Corn","name"=>"Corn Seeds"."(".intval($corn).")" ),
);

$array[]=$dataPoints;

$vegetable=0;
$fruit=0;
$organic=0;
$rice=0;
$chemicals=0;
$corn=0;
$fertilizer=0;
$statement = $connection->prepare("SELECT sum(t2.quantity) as num,t1.product_name as name,t1.type_product as type,month(t2.created_at) as month from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at)='$year' and month(t2.created_at)=10 group by month(t2.created_at), type_product");
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{

if($row['type']=="Vegetables_Seedlings/Seeds"){
     $vegetable=$row['num'];
}
else if($row['type']=="Fruit_Trees_Seedlings"){
     $fruit=$row['num'];
}
else if($row['type']=="Organic/Vermicast"){
     $organic=$row['num'];
}
else if($row['type']=="Fertilizers"){
     $fertilizer=$row['num'];
}
else if($row['type']=="Rice_Seeds"){
     $rice=$row['num'];
}
else if($row['type']=="Chemicals"){
     $chemicals=$row['num'];
}
else if($row['type']=="Corn_Seeds"){
     $corn=$row['num'];
}
}
$dataPoints = array( 
     array("y" => intval($vegetable), "label" => "Vegetables","name"=>"Vegetable Seeds"."(".intval($vegetable).")"),
     array("y" => intval($fruit), "label" => "Fruit","name"=>"Fruit Trees"."(".intval($fruit).")" ),
     array("y" => intval($organic), "label" => "Organic","name"=>"Organic"."(".intval($organic).")" ),
     array("y" => intval($fertilizer), "label" => "Fertilizers","name"=>"Fertilizers"."(".intval($fertilizer).")" ),
     array("y" => intval($chemicals), "label" => "Chemicals","name"=>"Chemicals"."(".intval($chemicals).")" ),
     array("y" => intval($rice), "label" => "Rice","name"=>"Rice Seeds"."(".intval($rice).")" ),
array("y" => intval($corn), "label" => "Corn","name"=>"Corn Seeds"."(".intval($corn).")" ),
);

$array[]=$dataPoints;

$vegetable=0;
$fruit=0;
$organic=0;
$rice=0;
$chemicals=0;
$corn=0;
$fertilizer=0;
$statement = $connection->prepare("SELECT sum(t2.quantity) as num,t1.product_name as name,t1.type_product as type,month(t2.created_at) as month from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at)='$year' and month(t2.created_at)=11 group by month(t2.created_at), type_product");
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{

if($row['type']=="Vegetables_Seedlings/Seeds"){
     $vegetable=$row['num'];
}
else if($row['type']=="Fruit_Trees_Seedlings"){
     $fruit=$row['num'];
}
else if($row['type']=="Organic/Vermicast"){
     $organic=$row['num'];
}
else if($row['type']=="Fertilizers"){
     $fertilizer=$row['num'];
}
else if($row['type']=="Rice_Seeds"){
     $rice=$row['num'];
}
else if($row['type']=="Chemicals"){
     $chemicals=$row['num'];
}
else if($row['type']=="Corn_Seeds"){
     $corn=$row['num'];
}
}
$dataPoints = array( 
     array("y" => intval($vegetable), "label" => "Vegetables","name"=>"Vegetable Seeds"."(".intval($vegetable).")"),
     array("y" => intval($fruit), "label" => "Fruit","name"=>"Fruit Trees"."(".intval($fruit).")" ),
     array("y" => intval($organic), "label" => "Organic","name"=>"Organic"."(".intval($organic).")" ),
     array("y" => intval($fertilizer), "label" => "Fertilizers","name"=>"Fertilizers"."(".intval($fertilizer).")" ),
     array("y" => intval($chemicals), "label" => "Chemicals","name"=>"Chemicals"."(".intval($chemicals).")" ),
     array("y" => intval($rice), "label" => "Rice","name"=>"Rice Seeds"."(".intval($rice).")" ),
array("y" => intval($corn), "label" => "Corn","name"=>"Corn Seeds"."(".intval($corn).")" ),
);

$array[]=$dataPoints;

$vegetable=0;
$fruit=0;
$organic=0;
$rice=0;
$chemicals=0;
$corn=0;
$fertilizer=0;
$statement = $connection->prepare("SELECT sum(t2.quantity) as num,t1.product_name as name,t1.type_product as type,month(t2.created_at) as month from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at)='$year' and month(t2.created_at)=12 group by month(t2.created_at), type_product");
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{

if($row['type']=="Vegetables_Seedlings/Seeds"){
     $vegetable=$row['num'];
}
else if($row['type']=="Fruit_Trees_Seedlings"){
     $fruit=$row['num'];
}
else if($row['type']=="Organic/Vermicast"){
     $organic=$row['num'];
}
else if($row['type']=="Fertilizers"){
     $fertilizer=$row['num'];
}
else if($row['type']=="Rice_Seeds"){
     $rice=$row['num'];
}
else if($row['type']=="Chemicals"){
     $chemicals=$row['num'];
}
else if($row['type']=="Corn_Seeds"){
     $corn=$row['num'];
}
}
$dataPoints = array( 
     array("y" => intval($vegetable), "label" => "Vegetables","name"=>"Vegetable Seeds"."(".intval($vegetable).")"),
     array("y" => intval($fruit), "label" => "Fruit","name"=>"Fruit Trees"."(".intval($fruit).")" ),
     array("y" => intval($organic), "label" => "Organic","name"=>"Organic"."(".intval($organic).")" ),
     array("y" => intval($fertilizer), "label" => "Fertilizers","name"=>"Fertilizers"."(".intval($fertilizer).")" ),
     array("y" => intval($chemicals), "label" => "Chemicals","name"=>"Chemicals"."(".intval($chemicals).")" ),
     array("y" => intval($rice), "label" => "Rice","name"=>"Rice Seeds"."(".intval($rice).")" ),
array("y" => intval($corn), "label" => "Corn","name"=>"Corn Seeds"."(".intval($corn).")" ),
);

$array[]=$dataPoints;



echo json_encode($array);
}else if($type==='Yearly'){

     $data = array();

     for($r=intval($yearf);$r<=intval($yeart);$r++){
          $statement = $connection->prepare("SELECT sum(t2.quantity) as num,t1.product_name as name,t1.type_product as type,year(t2.created_at) as year from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at) between '$yearf' and '$yeart' group by t1.type_product,year(t2.created_at)");
          $statement->execute();
          $result = $statement->fetchAll();

          $vegetable=0;
          $fruit=0;
          $organic=0;
          $rice=0;
          $chemicals=0;
          $corn=0;
          $fertilizer=0;

          foreach($result as $row)
               {

                    if($row['year']==$r){
                         if($row['type']=="Vegetables_Seedlings/Seeds"){
                              $vegetable=$row['num'];
                         }
                         else if($row['type']=="Fruit_Trees_Seedlings"){
                              $fruit=$row['num'];
                         }
                         else if($row['type']=="Organic/Vermicast"){
                              $organic=$row['num'];
                         }
                         else if($row['type']=="Fertilizers"){
                              $fertilizer=$row['num'];
                         }
                         else if($row['type']=="Rice_Seeds"){
                              $rice=$row['num'];
                         }
                         else if($row['type']=="Chemicals"){
                              $chemicals=$row['num'];
                         }
                         else if($row['type']=="Corn_Seeds"){
                              $corn=$row['num'];
                         }
                    }
               }

               $dataPoints = array( 
                    array("y" => intval($vegetable), "label" => "Vegetables","name"=>"Vegetable Seeds"."(".intval($vegetable).")"),
                    array("y" => intval($fruit), "label" => "Fruit","name"=>"Fruit Trees"."(".intval($fruit).")" ),
                    array("y" => intval($organic), "label" => "Organic","name"=>"Organic"."(".intval($organic).")" ),
                    array("y" => intval($fertilizer), "label" => "Fertilizers","name"=>"Fertilizers"."(".intval($fertilizer).")" ),
                    array("y" => intval($chemicals), "label" => "Chemicals","name"=>"Chemicals"."(".intval($chemicals).")" ),
                    array("y" => intval($rice), "label" => "Rice","name"=>"Rice Seeds"."(".intval($rice).")" ),
               array("y" => intval($corn), "label" => "Corn","name"=>"Corn Seeds"."(".intval($corn).")" ),
               );

               $data[]= $dataPoints;

          }
 
     
     echo json_encode($data);

}else if($type==='Customize'){
     $dataPoints = array();
    $data = array();

     $statement = $connection->prepare("SELECT t2.quantity as num,t1.product_name as name,t2.created_at as dateni,t1.type_product as type from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where DATE_FORMAT(t2.created_at,'%Y-%m-%d') between '$datef' and '$datet'");
     $statement->execute();
     $result = $statement->fetchAll();
     foreach($result as $row)
     {
          $data['y']=intval($row['num']);
          $data['label']=date('F j, Y',strtotime($row['dateni']));
          $dataPoints[]=$data;
     }

     echo json_encode($dataPoints);
}

?>
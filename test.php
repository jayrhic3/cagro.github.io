<?php
include('connection.php');
$dataPoints = array();
$data = array();

 $statement = $connection->prepare("SELECT t2.quantity as num,t1.product_name as name,t2.created_at as dateni,t1.type_product as type from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where DATE_FORMAT(t2.created_at,'%Y-%m-%d') between '2018-02-02' and '2020-03-02'");
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
      $data['y']=intval($row['num']);
      $data['label']=date('F j, Y',strtotime($row['dateni'])) . ", " . $row['name'];
      $dataPoints[]=$data;
 }

 echo json_encode($dataPoints);

?>

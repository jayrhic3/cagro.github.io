<?php 

session_start();
include('connection.php');
$type=$_POST['type'];
$year=$_POST['year'];

if($type=='Gender'){
    $male=0;
    $female=0;

    $statement = $connection->prepare("SELECT (select count(distinct t2.beneficiary_id) from
     beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id=t2.beneficiary_id
      where t1.gender='Male' and year(t2.created_at)='$year') as male,
      (select count(distinct t2.beneficiary_id) from beneficiaries as t1 inner join 
      record_services_beneficiary as t2 on t1.id=t2.beneficiary_id where t1.gender='Female' 
      and year(t2.created_at)='$year') as female");

    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
    $male=$row["male"];
    $female=$row["female"];
    }

    $dataPoints = array( 
        array("y" => intval($male), "label" => "Male" ),
        array("y" => intval($female), "label" => "Female" ),
    );
    
    echo json_encode($dataPoints);
}else if($type=='Beneficiary'){

    $jan=0;
    $feb=0;
    $mar=0;
    $apr=0;
    $may=0;
    $jun=0;
    $jul=0;
    $aug=0;
    $sep=0;
    $oct=0;
    $nov=0;
    $dec=0;


    $statement = $connection->prepare("SELECT count(distinct beneficiary_id) as num,
    month(created_at) as mon from record_services_beneficiary where year(created_at)='$year' 
    group by month(created_at)");

    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        if($row['mon']==1){
            $jan=$row['num'];
           }
           if($row['mon']==2){
            $feb=$row['num'];
           }
           if($row['mon']==3){
            $mar=$row['num'];
           }
           if($row['mon']==4){
            $apr=$row['num'];
           }
           if($row['mon']==5){
            $may=$row['num'];
           }
           if($row['mon']==6){
            $jun=$row['num'];
           }
           if($row['mon']==7){
            $jul=$row['num'];
           }
           if($row['mon']==8){
            $aug=$row['num'];
           }
           if($row['mon']==9){
            $sep=$row['num'];
           }
           if($row['mon']==10){
            $oct=$row['num'];
           }
           if($row['mon']==11){
            $nov=$row['num'];
           }
           if($row['mon']==12){
            $dec=$row['num'];
           }
    }

    $dataPoints = array( 
        array("y" => intval($jan), "label" => "January"."(".intval($jan).")" ),
        array("y" => intval($feb), "label" => "February"."(".intval($feb).")" ),
        array("y" => intval($mar), "label" => "March"."(".intval($mar).")" ),
        array("y" => intval($apr), "label" => "Aptil"."(".intval($apr).")" ),
        array("y" => intval($may), "label" => "May"."(".intval($may).")" ),
        array("y" => intval($jun), "label" => "June"."(".intval($jun).")" ),
        array("y" => intval($jul), "label" => "July"."(".intval($jul).")" ),
        array("y" => intval($aug), "label" => "August"."(".intval($aug).")" ),
        array("y" => intval($sep), "label" => "September"."(".intval($sep).")" ),
        array("y" => intval($oct), "label" => "October"."(".intval($oct).")" ),
        array("y" => intval($nov), "label" => "November"."(".intval($nov).")" ),
        array("y" => intval($dec), "label" => "December"."(".intval($dec).")" ),
    );
    
    echo json_encode($dataPoints);
}

?>
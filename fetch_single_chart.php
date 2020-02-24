<?php 

session_start();
include('connection.php');
$year=$_POST['year'];
$type=$_POST['type'];
$yeart=$_POST['yeart'];
$yearf=$_POST['yearf'];
$datef=$_POST['datef'];
$datet=$_POST['datet'];


if($type=="Monthly"){
        
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
    month(created_at) as mon from record_assistance_beneficiary where year(created_at)='$year'
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
        array("y" => intval($jan), "label" => "January" ),
        array("y" => intval($feb), "label" => "February" ),
        array("y" => intval($mar), "label" => "March" ),
        array("y" => intval($apr), "label" => "Aptil" ),
        array("y" => intval($may), "label" => "May" ),
        array("y" => intval($jun), "label" => "June" ),
        array("y" => intval($jul), "label" => "July" ),
        array("y" => intval($aug), "label" => "August" ),
        array("y" => intval($sep), "label" => "September" ),
        array("y" => intval($oct), "label" => "October" ),
        array("y" => intval($nov), "label" => "November" ),
        array("y" => intval($dec), "label" => "December" ),
    );
    
    echo json_encode($dataPoints);
}else if($type=="Yearly"){
    $arr_year=array();
   
    $dataPoints = array();
    
    for($r=intval($yearf);$r<=intval($yeart);$r++){
        $arr_year[]=$r;
    }

    

    foreach($arr_year as $key){
    $data = array();
    $statement = $connection->prepare("SELECT sum(t2.num) as num, t2.year as year from (select count(distinct beneficiary_id) as num,year(created_at) as year from record_assistance_beneficiary group by month(created_at),year(created_at)) as t2 where t2.year between '$yearf' and '$yeart' group by t2.year");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
            if($row['year']==$key){
                $data['y']=intval($row['num']);
                $data['label']=$key;
            }
            
        
    }
        if(empty($data)){
            $data['y']=0;
            $data['label']=$key;
        }
        $dataPoints[]=$data; 
    }
    echo json_encode($dataPoints);
    
}else if($type=="Customize"){
    $dataPoints = array();
    $data = array();

    $statement = $connection->prepare("SELECT count(distinct beneficiary_id) as num,
    DATE_FORMAT(created_at,'%Y-%m-%d') as dateni from 
    record_assistance_beneficiary where DATE_FORMAT(created_at,'%Y-%m-%d') 
    between '$datef' and '$datet' group by DATE_FORMAT(created_at,'%Y-%m-%d')");
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
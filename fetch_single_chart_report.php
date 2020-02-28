<?php 

session_start();
include('connection.php');
$stype=$_POST['type'];
$year=$_POST['year'];
$type = $_POST['types'];
$yeart=$_POST['yeart'];
$yearf=$_POST['yearf'];
$datef=$_POST['datef'];
$datet=$_POST['datet'];

if($stype=='Gender'){

    if($type=='Monthly'){
        $data = array();

    $statement = $connection->prepare("select count(case when t2.gender='Male' then 1 end) as male, count(case when t2.gender='Female' then 1 end) as female, month(t2.created) as month from ( select t1.gender as gender, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) = '$year' and month(t2.created_at)=1 group by month(t2.created_at),t2.beneficiary_id) as t2 group by month(t2.created)");

    $statement->execute();
    $result = $statement->fetchAll();
    if(empty($result)){
        $dataPoints = array( 
            array("y" => 0, "label" => "Male"),
            array("y" => 0, "label" => "Female" ),
        );
        $data[]=$dataPoints;
    }else{
        foreach($result as $row)
        {
            $dataPoints = array( 
                array("y" => intval($row['male']), "label" => "Male"),
                array("y" => intval($row['female']), "label" => "Female" ),
            );
            $data[]=$dataPoints;
        }
    }
    $statement = $connection->prepare("select count(case when t2.gender='Male' then 1 end) as male, count(case when t2.gender='Female' then 1 end) as female, month(t2.created) as month from ( select t1.gender as gender, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) = '$year' and month(t2.created_at)=2 group by month(t2.created_at),t2.beneficiary_id) as t2 group by month(t2.created)");

    $statement->execute();
    $result = $statement->fetchAll();
    if(empty($result)){
        $dataPoints = array( 
            array("y" => 0, "label" => "Male"),
            array("y" => 0, "label" => "Female" ),
        );
        $data[]=$dataPoints;
    }else{
        foreach($result as $row)
        {
            $dataPoints = array( 
                array("y" => intval($row['male']), "label" => "Male"),
                array("y" => intval($row['female']), "label" => "Female" ),
            );
            $data[]=$dataPoints;
        }
    }

    $statement = $connection->prepare("select count(case when t2.gender='Male' then 1 end) as male, count(case when t2.gender='Female' then 1 end) as female, month(t2.created) as month from ( select t1.gender as gender, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) = '$year' and month(t2.created_at)=3 group by month(t2.created_at),t2.beneficiary_id) as t2 group by month(t2.created)");

    $statement->execute();
    $result = $statement->fetchAll();

    if(empty($result)){
        $dataPoints = array( 
            array("y" => 0, "label" => "Male"),
            array("y" => 0, "label" => "Female" ),
        );
        $data[]=$dataPoints;
    }else{
        foreach($result as $row)
        {
            $dataPoints = array( 
                array("y" => intval($row['male']), "label" => "Male"),
                array("y" => intval($row['female']), "label" => "Female" ),
            );
            $data[]=$dataPoints;
        }
    }

    $statement = $connection->prepare("select count(case when t2.gender='Male' then 1 end) as male, count(case when t2.gender='Female' then 1 end) as female, month(t2.created) as month from ( select t1.gender as gender, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) = '$year' and month(t2.created_at)=4 group by month(t2.created_at),t2.beneficiary_id) as t2 group by month(t2.created)");

    $statement->execute();
    $result = $statement->fetchAll();

    if(empty($result)){
        $dataPoints = array( 
            array("y" => 0, "label" => "Male"),
            array("y" => 0, "label" => "Female" ),
        );
        $data[]=$dataPoints;
    }else{
        foreach($result as $row)
        {
            $dataPoints = array( 
                array("y" => intval($row['male']), "label" => "Male"),
                array("y" => intval($row['female']), "label" => "Female" ),
            );
            $data[]=$dataPoints;
        }
    }

    $statement = $connection->prepare("select count(case when t2.gender='Male' then 1 end) as male, count(case when t2.gender='Female' then 1 end) as female, month(t2.created) as month from ( select t1.gender as gender, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) = '$year' and month(t2.created_at)=5 group by month(t2.created_at),t2.beneficiary_id) as t2 group by month(t2.created)");

    $statement->execute();
    $result = $statement->fetchAll();

    if(empty($result)){
        $dataPoints = array( 
            array("y" => 0, "label" => "Male"),
            array("y" => 0, "label" => "Female" ),
        );
        $data[]=$dataPoints;
    }else{
        foreach($result as $row)
        {
            $dataPoints = array( 
                array("y" => intval($row['male']), "label" => "Male"),
                array("y" => intval($row['female']), "label" => "Female" ),
            );
            $data[]=$dataPoints;
        }
    }

    $statement = $connection->prepare("select count(case when t2.gender='Male' then 1 end) as male, count(case when t2.gender='Female' then 1 end) as female, month(t2.created) as month from ( select t1.gender as gender, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) = '$year' and month(t2.created_at)=6 group by month(t2.created_at),t2.beneficiary_id) as t2 group by month(t2.created)");

    $statement->execute();
    $result = $statement->fetchAll();

    if(empty($result)){
        $dataPoints = array( 
            array("y" => 0, "label" => "Male"),
            array("y" => 0, "label" => "Female" ),
        );
        $data[]=$dataPoints;
    }else{
        foreach($result as $row)
        {
            $dataPoints = array( 
                array("y" => intval($row['male']), "label" => "Male"),
                array("y" => intval($row['female']), "label" => "Female" ),
            );
            $data[]=$dataPoints;
        }
    }

    $statement = $connection->prepare("select count(case when t2.gender='Male' then 1 end) as male, count(case when t2.gender='Female' then 1 end) as female, month(t2.created) as month from ( select t1.gender as gender, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) = '$year' and month(t2.created_at)=7 group by month(t2.created_at),t2.beneficiary_id) as t2 group by month(t2.created)");

    $statement->execute();
    $result = $statement->fetchAll();

    if(empty($result)){
        $dataPoints = array( 
            array("y" => 0, "label" => "Male"),
            array("y" => 0, "label" => "Female" ),
        );
        $data[]=$dataPoints;
    }else{
        foreach($result as $row)
        {
            $dataPoints = array( 
                array("y" => intval($row['male']), "label" => "Male"),
                array("y" => intval($row['female']), "label" => "Female" ),
            );
            $data[]=$dataPoints;
        }
    }

    $statement = $connection->prepare("select count(case when t2.gender='Male' then 1 end) as male, count(case when t2.gender='Female' then 1 end) as female, month(t2.created) as month from ( select t1.gender as gender, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) = '$year' and month(t2.created_at)=8 group by month(t2.created_at),t2.beneficiary_id) as t2 group by month(t2.created)");

    $statement->execute();
    $result = $statement->fetchAll();

    if(empty($result)){
        $dataPoints = array( 
            array("y" => 0, "label" => "Male"),
            array("y" => 0, "label" => "Female" ),
        );
        $data[]=$dataPoints;
    }else{
        foreach($result as $row)
        {
            $dataPoints = array( 
                array("y" => intval($row['male']), "label" => "Male"),
                array("y" => intval($row['female']), "label" => "Female" ),
            );
            $data[]=$dataPoints;
        }
    }

    $statement = $connection->prepare("select count(case when t2.gender='Male' then 1 end) as male, count(case when t2.gender='Female' then 1 end) as female, month(t2.created) as month from ( select t1.gender as gender, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) = '$year' and month(t2.created_at)=9 group by month(t2.created_at),t2.beneficiary_id) as t2 group by month(t2.created)");

    $statement->execute();
    $result = $statement->fetchAll();

    if(empty($result)){
        $dataPoints = array( 
            array("y" => 0, "label" => "Male"),
            array("y" => 0, "label" => "Female" ),
        );
        $data[]=$dataPoints;
    }else{
        foreach($result as $row)
        {
            $dataPoints = array( 
                array("y" => intval($row['male']), "label" => "Male"),
                array("y" => intval($row['female']), "label" => "Female" ),
            );
            $data[]=$dataPoints;
        }
    }

    $statement = $connection->prepare("select count(case when t2.gender='Male' then 1 end) as male, count(case when t2.gender='Female' then 1 end) as female, month(t2.created) as month from ( select t1.gender as gender, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) = '$year' and month(t2.created_at)=10 group by month(t2.created_at),t2.beneficiary_id) as t2 group by month(t2.created)");

    $statement->execute();
    $result = $statement->fetchAll();

    if(empty($result)){
        $dataPoints = array( 
            array("y" => 0, "label" => "Male"),
            array("y" => 0, "label" => "Female" ),
        );
        $data[]=$dataPoints;
    }else{
        foreach($result as $row)
        {
            $dataPoints = array( 
                array("y" => intval($row['male']), "label" => "Male"),
                array("y" => intval($row['female']), "label" => "Female" ),
            );
            $data[]=$dataPoints;
        }
    }

    $statement = $connection->prepare("select count(case when t2.gender='Male' then 1 end) as male, count(case when t2.gender='Female' then 1 end) as female, month(t2.created) as month from ( select t1.gender as gender, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) = '$year' and month(t2.created_at)=11 group by month(t2.created_at),t2.beneficiary_id) as t2 group by month(t2.created)");

    $statement->execute();
    $result = $statement->fetchAll();

    if(empty($result)){
        $dataPoints = array( 
            array("y" => 0, "label" => "Male"),
            array("y" => 0, "label" => "Female" ),
        );
        $data[]=$dataPoints;
    }else{
        foreach($result as $row)
        {
            $dataPoints = array( 
                array("y" => intval($row['male']), "label" => "Male"),
                array("y" => intval($row['female']), "label" => "Female" ),
            );
            $data[]=$dataPoints;
        }
    }

    $statement = $connection->prepare("select count(case when t2.gender='Male' then 1 end) as male, count(case when t2.gender='Female' then 1 end) as female, month(t2.created) as month from ( select t1.gender as gender, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) = '$year' and month(t2.created_at)=12 group by month(t2.created_at),t2.beneficiary_id) as t2 group by month(t2.created)");

    $statement->execute();
    $result = $statement->fetchAll();

    if(empty($result)){
        $dataPoints = array( 
            array("y" => 0, "label" => "Male"),
            array("y" => 0, "label" => "Female" ),
        );
        $data[]=$dataPoints;
    }else{
        foreach($result as $row)
        {
            $dataPoints = array( 
                array("y" => intval($row['male']), "label" => "Male"),
                array("y" => intval($row['female']), "label" => "Female" ),
            );
            $data[]=$dataPoints;
        }
    }
    

    echo json_encode($data);
    }else if($type=='Yearly'){
        $data = array();

        for($r=intval($yearf);$r<=intval($yeart);$r++){
            $statement = $connection->prepare(" select count(case when t2.gender='Male' then 1 end) as male, count(case when t2.gender='Female' then 1 end) as female, year(t2.created) as year from ( select t1.gender as gender, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) between '$yearf' and '$yeart' group by month(t2.created_at),year(t2.created_at),t2.beneficiary_id) as t2 group by year(t2.created)");
            $statement->execute();
            $result = $statement->fetchAll();

            $male=0;
            $female=0;

            foreach($result as $row)
               {

                if($row['year']==$r){
                    $male = $row['male'];
                    $female = $row['female'];
                }

               }

               $dataPoints = array( 
                array("y" => intval($male), "label" => "Male"),
                array("y" => intval($female), "label" => "Female" ),
                );

           $data[]= $dataPoints;
        }

        echo json_encode($data);

    }else if($type=='Customize'){
        $dataPoints = array();
        $data = array();
    
        $statement = $connection->prepare(" select t2.id as id,count(case when t2.gender='Male' then 1 end) as male, count(case when t2.gender='Female' then 1 end) as female, t2.dateni as dateni from ( select t1.gender as gender,t2.beneficiary_id as id, DATE_FORMAT(t2.created_at,'%Y-%m-%d') as dateni from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where DATE_FORMAT(t2.created_at,'%Y-%m-%d') between '$datef' and '$datet' group by DATE_FORMAT(t2.created_at,'%Y-%m-%d')) as t2 group by t2.dateni");
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
            $data['y']=intval($row['male']+$row['female']);
            $data['label']=date('F j, Y',strtotime($row['dateni']));
            $dataPoints[]=$data;
        }
        echo json_encode($dataPoints);
    }
    
}else if($stype=='Beneficiary'){

    if($type=='Monthly'){
        
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

    $data=array();

    $statement = $connection->prepare("SELECT count(distinct beneficiary_id) as num, month(created_at) as mon from record_services_beneficiary where year(created_at)='$year' group by month(created_at)");

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

    }else if($type=='Yearly'){
        $arr_year=array();
   
        $dataPoints = array();
        
        for($r=intval($yearf);$r<=intval($yeart);$r++){
            $arr_year[]=$r;
        }
    
        
    
        foreach($arr_year as $key){
        $data = array();
        $statement = $connection->prepare("select sum(t2.num) as num,t2.year as year from (select count(distinct beneficiary_id) as num,year(created_at) as year from record_services_beneficiary where year(created_at) between '$yearf' and '$yeart' group by month(created_at),year(created_at)) as t2 group by t2.year");
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
        

    }else if($type=='Customize'){

        $dataPoints = array();
        $data = array();

        $statement = $connection->prepare("SELECT count(distinct beneficiary_id) as num, DATE_FORMAT(created_at,'%Y-%m-%d') as dateni from record_services_beneficiary where DATE_FORMAT(created_at,'%Y-%m-%d') between '$datef' and '$datet' group by DATE_FORMAT(created_at,'%Y-%m-%d')");
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

}

?>
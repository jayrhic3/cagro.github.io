<?php
include('connection.php');
$query = ''; 
$output = array();
$id=$_POST["use_id"];
$query .= 'SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.id as ins,t2.request_id as id,
t2.word_created as dates from beneficiaries as t1 inner join record_services_beneficiary as t2 
on t1.id=t2.beneficiary_id WHERE t2.request_id="'.$id.'" group by t2.request_id';

$sub_array = array();
    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        
        
        $sub_array["lastname"] = $row["lastname"];
        $sub_array["firstname"] = $row["firstname"];
        $sub_array["middlename"] = $row["middlename"];
        $sub_array["id"] = $row["id"];
        $sub_array["bene_id"] = $row["ins"];
    }


echo json_encode($sub_array);
?>
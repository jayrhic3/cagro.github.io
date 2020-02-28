<?php
include('connection.php');
include('function_chart_table.php');

$query = ''; 
$output = array();

$query .= 'select t2.created_at as created,count(case when t2.gender="Male" then 1 end) as male, count(case when t2.gender="Female" then 1 end) as female, month(t2.created) as month from ( select t1.gender as gender,t2.created_at as created_at, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) = "2020" group by month(t2.created_at),t2.beneficiary_id) as t2 group by month(t2.created) ';

    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $data = array();
    $filtered_rows = $statement->rowCount();
    foreach($result as $row)
    {
        
        $sub_array = array();
        $sub_array[] = '';
        $sub_array[] = '';
        $sub_array[] = date("F", mktime(0, 0, 0, $row['month'], 10));
        $sub_array[] = $row["male"];
        $sub_array[] = $row["female"];
        $sub_array[] = (intval($row["male"])+intval($row["female"]));
        $data[] = $sub_array;
    }

$output = array(
    "draw"				=>	intval($_POST["draw"]),
    "recordsTotal"		=> 	$filtered_rows,
    "recordsFiltered"	=>	get_total_all_records(),
    "data"				=>	$data
);

echo json_encode($data);

?>

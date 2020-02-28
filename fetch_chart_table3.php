<?php
session_start();
include('connection.php');

$year=$_POST['year'];
$type=$_POST['type'];
$yearf=$_POST['yearf'];
$yeart=$_POST['yeart'];
$datef=$_POST['datef'];
$datet=$_POST['datet'];

if($type=='Monthly'){

        include('function_chart_table.php');

        $query = ''; 
        $output = array();

        $query .= 'select t2.created_at as created,count(case when t2.gender="Male" then 1 end) as male, count(case when t2.gender="Female" then 1 end) as female, month(t2.created) as month from ( select t1.gender as gender,t2.created_at as created_at, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) = "'.$year.'" group by month(t2.created_at),t2.beneficiary_id) as t2 group by month(t2.created) ';

        if(isset($_POST["order"]))
        {
            $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
        }
        else
        {
            $query .= 'ORDER BY t2.created_at DESC ';
        }
        if($_POST["length"] != -1)
        {
            $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }
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

        echo json_encode($output);

}else if($type=='Yearly')
{
    include('function_chart_table.php');
    $query = ''; 
    $output = array();

    $query .= 'select count(case when t2.gender="Male" then 1 end) as male, count(case when t2.gender="Female" then 1 end) as female, year(t2.created) as year,t2.created as created from ( select t1.gender as gender, t2.created_at as created from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where year(t2.created_at) between "'.$yearf.'" and "'.$yeart.'" group by month(t2.created_at),year(t2.created_at),t2.beneficiary_id) as t2 group by year(t2.created) ';
    
    if(isset($_POST["order"]))
    {
        $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
        $query .= 'ORDER BY t2.created DESC ';
    }
    if($_POST["length"] != -1)
    {
        $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $data = array();
        $filtered_rows = $statement->rowCount();
        foreach($result as $row)
        {
            
            $sub_array = array();
            $sub_array[] = '';
            $sub_array[] = $row["year"];
            $sub_array[] = '';
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
    echo json_encode($output);
}else if($type=='Customize')
{
    include('function_chart_table.php');
    $query = ''; 
    $output = array();
    $query .= 'select t2.id as id,count(case when t2.gender="Male" then 1 end) as male, count(case when t2.gender="Female" then 1 end) as female, t2.dateni as dateni from ( select t1.gender as gender,t2.beneficiary_id as id, DATE_FORMAT(t2.created_at,"%Y-%m-%d") as dateni from beneficiaries as t1 inner join record_services_beneficiary as t2 on t1.id = t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d") between "'.$datef.'" and "'.$datet.'" group by DATE_FORMAT(t2.created_at,"%Y-%m-%d")) as t2 group by t2.dateni ';

    
    if(isset($_POST["order"]))
    {
        $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
        $query .= 'ORDER BY t2.dateni DESC ';
    }
    if($_POST["length"] != -1)
    {
        $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $data = array();
        $filtered_rows = $statement->rowCount();
        foreach($result as $row)
        {
            
            $sub_array = array();
            $sub_array[] = date('F j, Y',strtotime($row['dateni']));
            $sub_array[] = '';
            $sub_array[] = '';
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
    echo json_encode($output);
}


?>
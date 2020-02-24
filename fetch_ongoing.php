<?php
session_start();
include('connection.php');
	$status=$_POST['status'];
	$id=$_POST['id'];
	$datefrom=$_POST['datefrom'];
	$dateto=$_POST['dateto'];
	$assistance=$_POST['assistance'];

if($status=='All' && $datefrom=='' && $dateto=='' && $assistance=='All'){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t2.word_created as date_in,t2.status as stat,
	t2.service_id as id,t2.assistanced_received as received from beneficiaries as t1 
	inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id ";

	if(isset($_POST["search"]["value"]))
	{
		$query .= 'WHERE t1.lastname LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR t1.firstname LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR t2.assistanced_received LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR t2.status LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR t2.word_created LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t2.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["middlename"];
	$sub_array[] = $row["received"];
	$sub_array[] = $row["date_in"];
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
if($status!='All' && $id!='' && $datefrom=='' && $dateto=='' && $assistance=='All'){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename, t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where t2.beneficiary_id='$id') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["middlename"];
	$sub_array[] = $row["received"];
	$sub_array[] = $row["date_in"];
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
if($status!='All' && $id!='' && $datefrom=='' && $dateto=='' && $assistance!='All'){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where t2.beneficiary_id='$id' and t2.assistanced_received ='$assistance') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["middlename"];
	$sub_array[] = $row["received"];
	$sub_array[] = $row["date_in"];
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
if($status=='All'&& $datefrom=='' && $dateto=='' && $assistance!='All'){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where t2.assistanced_received ='$assistance') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["middlename"];
	$sub_array[] = $row["received"];
	$sub_array[] = $row["date_in"];
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
if($status=='All'&& $datefrom!='' && $dateto!='' && $assistance=='All'){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where DATE_FORMAT(t2.created_at,'%Y-%m-%d') BETWEEN '$datefrom' AND '$dateto') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["middlename"];
	$sub_array[] = $row["received"];
	$sub_array[] = $row["date_in"];
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
if($status!='All' && $id!='' && $datefrom!='' && $dateto!='' && $assistance=='All'){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where DATE_FORMAT(t2.created_at,'%Y-%m-%d') BETWEEN '$datefrom' AND '$dateto' and t2.beneficiary_id='$id') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["middlename"];
	$sub_array[] = $row["received"];
	$sub_array[] = $row["date_in"];
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
if($status!='All' && $id!='' && $datefrom!='' && $dateto!='' && $assistance!='All'){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where DATE_FORMAT(t2.created_at,'%Y-%m-%d') BETWEEN '$datefrom' AND '$dateto' and t2.beneficiary_id='$id' and t2.assistanced_received='$assistance') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["middlename"];
	$sub_array[] = $row["received"];
	$sub_array[] = $row["date_in"];
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
if($status=='All' && $datefrom!='' && $dateto!='' && $assistance!='All'){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where DATE_FORMAT(t2.created_at,'%Y-%m-%d') BETWEEN '$datefrom' AND '$dateto' and t2.assistanced_received='$assistance') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["middlename"];
	$sub_array[] = $row["received"];
	$sub_array[] = $row["date_in"];
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


//error handling
if($assistance!='All' && $status=='All' && $datefrom=='' && $dateto!=''){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where t2.assistanced_received='') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
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
if($assistance!='All' && $status=='All' && $datefrom!='' && $dateto==''){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where t2.assistanced_received='') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
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
if($assistance!='All' && $status!='All' && $datefrom!='' && $dateto==''){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where t2.assistanced_received='') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
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
if($assistance!='All' && $status!='All' && $datefrom=='' && $dateto!=''){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where t2.assistanced_received='') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
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
if($assistance=='All' && $status=='All' && $datefrom=='' && $dateto!=''){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where t2.assistanced_received='') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
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
if($assistance!='All' && $status=='All' && $datefrom=='' && $dateto!=''){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where t2.assistanced_received='') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
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
if($assistance=='All' && $status!='All' && $datefrom=='' && $dateto!=''){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where t2.assistanced_received='') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
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
if($assistance!='All' && $status!='All' && $datefrom!='' && $dateto==''){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where t2.assistanced_received='') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
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
if($assistance=='All' && $status!='All' && $datefrom=='' && $dateto!=''){

	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where t2.assistanced_received='') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
	$data[] = $sub_array;
	}
	$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records(),
	"data"				=>	$data
	);
	echo json_encode($output);
	
}/*
else if($status=='All'&&$datefrom!=''&&$dateto!=''){
	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t2.word_created as date_in,t2.status as stat,
	t2.service_id as id,t2.assistanced_received as received from beneficiaries as t1 
	inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id WHERE DATE_FORMAT(t2.created_at,'%Y-%m-%d') BETWEEN '$datefrom' AND '$dateto' ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t2.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
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
else if($datefrom==''&&$dateto==''&&$id!=''&& $assistance!='All'){
	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where t2.beneficiary_id='$id') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
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
else if($datefrom!=''&&$dateto!=''&&$id!=''&&$status!='All'){
	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received
	 from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id 
	 where t2.beneficiary_id='$id' and DATE_FORMAT(t2.created_at,'%Y-%m-%d') BETWEEN '$datefrom' AND '$dateto') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
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
else if($status!='All' && $datefrom!=''||$dateto!=''){
	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received
	 from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id 
	 where t2.beneficiary_id='') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
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
else if($id!='All' && $datefrom!=''||$dateto!=''){
	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received
	 from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id 
	 where t2.beneficiary_id='') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
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
else if($datefrom==''&&$dateto==''&&$status=='All'&& $assistance!='All'){
	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where t2.assistanced_received='$assistance') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
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
else if($datefrom==''&&$dateto==''&& $assistance!='All'&&$id!=''){
	include('function_ongoing.php');
	$query = "";
	$output = array();

	$query .= "SELECT t1.lastname as lastname,t1.firstname as firstname,t1.word_created as date_in,
	t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
	(select t1.lastname as lastname,t1.firstname as firstname,t2.word_created as word_created,
	t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
	from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
	 where t2.assistanced_received='$assistance' and t2.beneficiary_id='$id') as t1 ";
	
	if(isset($_POST["order"]))
	{
	$query .= "ORDER BY ".$_POST['order']['0']['column']." ".$_POST['order']['0']['dir']." ";
	}
	else
	{
	$query .= "ORDER BY t1.created_at DESC ";
	}
	if($_POST["length"] != -1)
	{
	$query .= "LIMIT " . $_POST['start'] . ", " . $_POST['length'];
	}
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{

	$sub_array = array();
	$sub_array[] = $row["lastname"];
	$sub_array[] = $row["firstname"];
	$sub_array[] = $row["received"];
		if($row['stat']=='On Going'){
			$sub_array[] = '<b><p style="background:yellow"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Pending'){
			$sub_array[] = '<b><p style="background:pink"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Done'){
			$sub_array[] = '<b><p style="background:lightgreen"> '.$row["stat"].'</p></b>';
		}elseif($row['stat']=='Cancel'){
			$sub_array[] = '<b><p style="background:gray"> '.$row["stat"].'</p></b>';
		}
	$sub_array[] = $row["date_in"];
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
*/
?>
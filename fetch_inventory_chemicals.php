<?php
include('connection.php');
include('function_inventory_fertilizers.php');

$status=$_POST["status"];
$datefrom=$_POST["datefrom"];
$dateto=$_POST["dateto"];

if($status=='Latest' && $datefrom=='' && $dateto==''){
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.damage as damage,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
    quantity as quan,despensed as despense,status as stat,damage as damage,id as d,created_at as created,word_created as word_created from 
    inventory_all_products where type_product="Chemicals" and status_updated="Latest") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
    }

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
            $sub_array[] = $row["product_name"];
            $sub_array[] = $row["units"];
            $sub_array[] = $row["quantity"];
            $sub_array[] = $row["despensed"];
            $sub_array[] = $row["damage"];
            if($row["quantity"]>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if($row["quantity"]<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if($row["quantity"]>0 && $row["quantity"]<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["dates"];
            $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-pencil check" data-toggle="modal" data-target="#userModal"></button><button type="button" name="check" id="'.$row["id"].'" class="btn btn-success btn-sm ti-plus renew" data-toggle="modal" data-target="#userModal3">Renew</button><button type="button" name="check" id="'.$row["id"].'" class="btn btn-danger btn-sm ti-trash damage" data-toggle="modal" data-target="#userModal4"></button>';
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
else if($status=='Old' && $datefrom=='' && $dateto==''){
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.damage as damage,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
    quantity as quan,despensed as despense,damage as damage,status as stat,id as d,created_at as created,word_created as word_created from 
    inventory_all_products where type_product="Chemicals" and status_updated="Old") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
    }

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
            $sub_array[] = $row["product_name"];
            $sub_array[] = $row["units"];
            $sub_array[] = $row["quantity"];
            $sub_array[] = $row["despensed"];
            $sub_array[] = $row["damage"];
            if($row["quantity"]>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if($row["quantity"]<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if($row["quantity"]>0 && $row["quantity"]<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["dates"];
            $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-pencil check" data-toggle="modal" data-target="#userModal"></button>';
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
else if($status=='Summary' && $datefrom=='' && $dateto==''){
    $date=date('Y-m-d H:i:s');
	$cdate=date('F j, Y',strtotime($date));
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.damage as damage,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
    sum(quantity) as quan,sum(despensed) as despense,sum(damage) as damage,status as stat,id as d,created_at as created from 
    inventory_all_products where type_product="Chemicals" group by product_name,units) as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
    }

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
            $sub_array[] = $row["product_name"];
            $sub_array[] = $row["units"];
            $sub_array[] = $row["quantity"];
            $sub_array[] = $row["despensed"];
            $sub_array[] = $row["damage"];
            if($row["quantity"]>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if($row["quantity"]<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if($row["quantity"]>0 && $row["quantity"]<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $cdate;
            $sub_array[] = '';
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
else if($status=='Latest' && $datefrom!='' && $dateto!=''){
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.damage as damage,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
    quantity as quan,despensed as despense,status as stat,damage as damage,id as d,created_at as created,word_created as word_created from 
    inventory_all_products where type_product="Chemicals" and status_updated="Latest" and DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
    }

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
            $sub_array[] = $row["product_name"];
            $sub_array[] = $row["units"];
            $sub_array[] = $row["quantity"];
            $sub_array[] = $row["despensed"];
            $sub_array[] = $row["damage"];
            if($row["quantity"]>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if($row["quantity"]<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if($row["quantity"]>0 && $row["quantity"]<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["dates"];
            $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-pencil check" data-toggle="modal" data-target="#userModal"></button><button type="button" name="check" id="'.$row["id"].'" class="btn btn-success btn-sm ti-plus renew" data-toggle="modal" data-target="#userModal3">Renew</button><button type="button" name="check" id="'.$row["id"].'" class="btn btn-danger btn-sm ti-trash damage" data-toggle="modal" data-target="#userModal4"></button>';
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
else if($status=='Old' && $datefrom!='' && $dateto!=''){
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.damage as damage,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
    quantity as quan,despensed as despense,damage as damage,status as stat,id as d,created_at as created,word_created as word_created from 
    inventory_all_products where type_product="Chemicals" and status_updated="Old" and DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
    }

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
            $sub_array[] = $row["product_name"];
            $sub_array[] = $row["units"];
            $sub_array[] = $row["quantity"];
            $sub_array[] = $row["despensed"];
            $sub_array[] = $row["damage"];
            if($row["quantity"]>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if($row["quantity"]<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if($row["quantity"]>0 && $row["quantity"]<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["dates"];
            $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-pencil check" data-toggle="modal" data-target="#userModal"></button><button type="button" name="check" id="'.$row["id"].'" class="btn btn-success btn-sm ti-plus renew" data-toggle="modal" data-target="#userModal3">Renew</button>';
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
else if($status=='Summary' && $datefrom!='' && $dateto!=''){
    $date=date('Y-m-d H:i:s');
	$cdate=date('F j, Y',strtotime($date));
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.damage as damage,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
    sum(quantity) as quan,sum(despensed) as despense,sum(damage) as damage,status as stat,id as d,created_at as created from 
    inventory_all_products where type_product="Chemicals" and DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'" group by product_name,units) as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
    }

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
            $sub_array[] = $row["product_name"];
            $sub_array[] = $row["units"];
            $sub_array[] = $row["quantity"];
            $sub_array[] = $row["despensed"];
            $sub_array[] = $row["damage"];
            if($row["quantity"]>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if($row["quantity"]<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if($row["quantity"]>0 && $row["quantity"]<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $cdate;
            $sub_array[] = '';
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
else if($status=='Latest' && $datefrom!='' && $dateto==''){
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
    quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
    inventory_all_products where type_product="") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
    }

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
            $sub_array[] = $row["product_name"];
            $sub_array[] = $row["units"];
            $sub_array[] = $row["quantity"];
            $sub_array[] = $row["despensed"];
            if($row["quantity"]>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if($row["quantity"]<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if($row["quantity"]>0 && $row["quantity"]<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["dates"];
            $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-pencil check" data-toggle="modal" data-target="#userModal"></button><button type="button" name="check" id="'.$row["id"].'" class="btn btn-success btn-sm ti-plus renew" data-toggle="modal" data-target="#userModal3">Renew</button>';
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
else if($status=='Latest' && $datefrom=='' && $dateto!=''){
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
    quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
    inventory_all_products where type_product="") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
    }

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
            $sub_array[] = $row["product_name"];
            $sub_array[] = $row["units"];
            $sub_array[] = $row["quantity"];
            $sub_array[] = $row["despensed"];
            if($row["quantity"]>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if($row["quantity"]<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if($row["quantity"]>0 && $row["quantity"]<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["dates"];
            $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-pencil check" data-toggle="modal" data-target="#userModal"></button><button type="button" name="check" id="'.$row["id"].'" class="btn btn-success btn-sm ti-plus renew" data-toggle="modal" data-target="#userModal3">Renew</button>';
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
else if($status=='Old' && $datefrom=='' && $dateto!=''){
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
    quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
    inventory_all_products where type_product="") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
    }

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
            $sub_array[] = $row["product_name"];
            $sub_array[] = $row["units"];
            $sub_array[] = $row["quantity"];
            $sub_array[] = $row["despensed"];
            if($row["quantity"]>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if($row["quantity"]<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if($row["quantity"]>0 && $row["quantity"]<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["dates"];
            $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-pencil check" data-toggle="modal" data-target="#userModal"></button><button type="button" name="check" id="'.$row["id"].'" class="btn btn-success btn-sm ti-plus renew" data-toggle="modal" data-target="#userModal3">Renew</button>';
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
else if($status=='Old' && $datefrom!='' && $dateto==''){
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
    quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
    inventory_all_products where type_product="") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
    }

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
            $sub_array[] = $row["product_name"];
            $sub_array[] = $row["units"];
            $sub_array[] = $row["quantity"];
            $sub_array[] = $row["despensed"];
            if($row["quantity"]>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if($row["quantity"]<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if($row["quantity"]>0 && $row["quantity"]<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["dates"];
            $sub_array[] = '<button type="button" name="check" id="'.$row["id"].'" class="btn btn-warning btn-sm ti-pencil check" data-toggle="modal" data-target="#userModal"></button><button type="button" name="check" id="'.$row["id"].'" class="btn btn-success btn-sm ti-plus renew" data-toggle="modal" data-target="#userModal3">Renew</button>';
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
else if($status=='Summary' && $datefrom=='' && $dateto!=''){
    $date=date('Y-m-d H:i:s');
	$cdate=date('F j, Y',strtotime($date));
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
    sum(quantity) as quan,sum(despensed) as despense,status as stat,id as d,created_at as created from 
    inventory_all_products where type_product="") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
    }

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
            $sub_array[] = $row["product_name"];
            $sub_array[] = $row["units"];
            $sub_array[] = $row["quantity"];
            $sub_array[] = $row["despensed"];
            if($row["quantity"]>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if($row["quantity"]<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if($row["quantity"]>0 && $row["quantity"]<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $cdate;
            $sub_array[] = '';
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
else if($status=='Summary' && $datefrom!='' && $dateto==''){
    $date=date('Y-m-d H:i:s');
	$cdate=date('F j, Y',strtotime($date));
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
    sum(quantity) as quan,sum(despensed) as despense,status as stat,id as d,created_at as created from 
    inventory_all_products where type_product="") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
    }

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
            $sub_array[] = $row["product_name"];
            $sub_array[] = $row["units"];
            $sub_array[] = $row["quantity"];
            $sub_array[] = $row["despensed"];
            if($row["quantity"]>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if($row["quantity"]<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if($row["quantity"]>0 && $row["quantity"]<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $cdate;
            $sub_array[] = '';
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
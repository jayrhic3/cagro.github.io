<?php
include('connection.php');
$type=$_POST['type'];
    include('function_inventory_vegetable.php');
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
    quantity as quan,despensed as despense,status as stat,id as d,created_at as created from 
    inventory_all_products where type_product="'.$type.'" and status_updated="Latest" and quantity >= 20) as t2 ';

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
            $sub_array[] = '<p id="name" name="name[]" value="'.$row["product_name"].'">'.$row["product_name"].'</p>';
            $sub_array[] = $row["units"];
            $sub_array[] = $row["quantity"];
            if(intval($row["quantity"])>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if(intval($row["quantity"])<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if(intval($row["quantity"])>0 && intval($row["quantity"])<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["id"];
            $data[] = $sub_array;
        }

    $output = array(
        "draw"				=>	intval($_POST["draw"]),
        "recordsTotal"		=> 	$filtered_rows,
        "recordsFiltered"	=>	get_total_all_records(),
        "data"				=>	$data
    );
    echo json_encode($output);

/*
else if($type=="Fruit_Trees_Seedlings"){
    include('function_inventory_fruit.php');
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
    quantity as quan,despensed as despense,status as stat,id as d,created_at as created from 
    inventory_all_products where type_product="Vegetables_Seedlings/Seeds" and status_updated="Latest") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit_description LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["unit_desc"];
            $sub_array[] = $row["quantity"];
            if(intval($row["quantity"])>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if(intval($row["quantity"])<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if(intval($row["quantity"])>0 && intval($row["quantity"])<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["id"];
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
else if($type=="Organic/Vermicast"){
    include('function_inventory_organic.php');
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.unit_description as unit_desc,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,unit_description as unit_description,units as unit,
    quantity as quan,despensed as despense,status as stat,id as d,created_at as created from 
    inventory_all_products where type_product="Organic/Vermicast") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit_description LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["unit_desc"];
            $sub_array[] = $row["quantity"];
            if(intval($row["quantity"])>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if(intval($row["quantity"])<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if(intval($row["quantity"])>0 && intval($row["quantity"])<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["id"];
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
else if($type=="Rice_Seeds"){
    include('function_inventory_rice.php');
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.unit_description as unit_desc,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,unit_description as unit_description,units as unit,
    quantity as quan,despensed as despense,status as stat,id as d,created_at as created from 
    inventory_all_products where type_product="Rice_Seeds") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit_description LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["unit_desc"];
            $sub_array[] = $row["quantity"];
            if(intval($row["quantity"])>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if(intval($row["quantity"])<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if(intval($row["quantity"])>0 && intval($row["quantity"])<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["id"];
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
else if($type=="Fertilizers"){
    include('function_inventory_fertilizers.php');
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.unit_description as unit_desc,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,unit_description as unit_description,units as unit,
    quantity as quan,despensed as despense,status as stat,id as d,created_at as created from 
    inventory_all_products where type_product="Fertilizers") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit_description LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["unit_desc"];
            $sub_array[] = $row["quantity"];
            if(intval($row["quantity"])>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if(intval($row["quantity"])<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if(intval($row["quantity"])>0 && intval($row["quantity"])<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["id"];
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
else if($type=="Chemicals"){
    include('function_inventory_chemicals.php');
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.unit_description as unit_desc,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,unit_description as unit_description,units as unit,
    quantity as quan,despensed as despense,status as stat,id as d,created_at as created from 
    inventory_all_products where type_product="Chemicals") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit_description LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["unit_desc"];
            $sub_array[] = $row["quantity"];
            if(intval($row["quantity"])>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if(intval($row["quantity"])<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if(intval($row["quantity"])>0 && intval($row["quantity"])<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["id"];
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
else if($type=="Corn_Seeds"){
    include('function_inventory_corn.php');
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.unit_description as unit_desc,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,unit_description as unit_description,units as unit,
    quantity as quan,despensed as despense,status as stat,id as d,created_at as created from 
    inventory_all_products where type_product="Corn_Seeds") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit_description LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["unit_desc"];
            $sub_array[] = $row["quantity"];
            if(intval($row["quantity"])>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if(intval($row["quantity"])<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if(intval($row["quantity"])>0 && intval($row["quantity"])<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["id"];
            $data[] = $sub_array;
        }

    $output = array(
        "draw"				=>	intval($_POST["draw"]),
        "recordsTotal"		=> 	$filtered_rows,
        "recordsFiltered"	=>	get_total_all_records(),
        "data"				=>	$data
    );
    echo json_encode($output);
}else if($type==''){
    include('function_inventory_corn.php');
    $query = ''; 
    $output = array();
    $query .= 'SELECT t2.prod as product_name,t2.unit_description as unit_desc,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
    t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,unit_description as unit_description,units as unit,
    quantity as quan,despensed as despense,status as stat,id as d,created_at as created from 
    inventory_all_products where type_product="") as t2 ';

    if(isset($_POST["search"]["value"]))
    {
        $query .= 'WHERE t2.prod LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.quan LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.despense LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.stat LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR t2.unit_description LIKE "%'.$_POST["search"]["value"].'%" ';
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
            $sub_array[] = $row["unit_desc"];
            $sub_array[] = $row["quantity"];
            if(intval($row["quantity"])>20){
                $sub_array[] = '<p style="background-color:lightgreen">'.'Available'.'</p>';
            }else if(intval($row["quantity"])<=0){
                $sub_array[] = '<p style="background-color:pink">'.'Not Available'.'</p>';
            }else if(intval($row["quantity"])>0 && intval($row["quantity"])<=20){
                $sub_array[] = '<p style="background-color:yellow">'.'Low Stock'.'</p>';
            }
            $sub_array[] = $row["id"];
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
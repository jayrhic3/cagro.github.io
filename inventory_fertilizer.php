<?php
session_start();
include('connection.php');
if(!isset($_SESSION['username'])){
    header('location:index.php');
}

$sub_array2 = array();
$sub_array3 = array();

$query="SELECT * from inventory_all_products";
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{
    if($row['quantity']>20){
        $quer="UPDATE inventory_all_products SET status='Available' WHERE id=".$row['id']." ";
        $statement7 = $connection->prepare($quer);
        $statement7->execute();
    }else if($row["quantity"]<=0){
        $quer="UPDATE inventory_all_products SET status='Not Available' WHERE id=".$row['id']." ";
        $statement7 = $connection->prepare($quer);
        $statement7->execute();
    }else if($row["quantity"]<=20){
        $quer="UPDATE inventory_all_products SET status='Low Stock' WHERE id=".$row['id']." ";
        $statement7 = $connection->prepare($quer);
        $statement7->execute();
    }
}

$query3="SELECT unit_prod FROM unit_q";
$statement3 = $connection->prepare($query3);
$statement3->execute();
$result3 = $statement3->fetchAll();
foreach($result3 as $row3)
{
    $sub_array3[] = $row3["unit_prod"];
}

$query3="SELECT des FROM product_name";
$statement3 = $connection->prepare($query3);
$statement3->execute();
$result3 = $statement3->fetchAll();
foreach($result3 as $row3)
{
    $sub_array2[] = $row3["des"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cagro Information System</title>

    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link type="image/x-icon" href="assets/images/cagro5.png" rel="shortcut icon">
    
    

   <!-- Common -->
   <link href="assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/lib/helper.css" rel="stylesheet">
    <link href="assets/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Datatable -->
    <link href="assets/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="assets/css/jquery-ui.css" rel="stylesheet" />

    <script src="js/jquery.min.js"></script>

    <style>
        .back{
            background:skyblue;
        }
        .table{
            width:100%;
        }
        .form-control{
            border-color:black;
        }
        #add{
            margin-top:30px;
        }
        #filter{
            margin-top:30px;
        }
    </style>
    
</head>

<body>

<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
            <div class="nano">
                <div class="nano-content">
                <ul>
                        <div class="logo"><a href="index.html"><img src="assets/images/cagro1.png" alt="" /><span>CAGRO</span></a></div>
                        <li class="label">Home</li>
                        <li><a href="dashboard2.php"><i class="ti-home"></i>Dashboard</a></li>
                        <li><a href="planning_agri_supplies.php"><i class="ti-shopping-cart-full"></i>Agri Supplies</a></li>
                        <li><a href="request_services.php"><i class="ti-shopping-cart-full"></i>Request</a></li>
                        <li><a href="beneficiary_product_record.php"><i class="ti-folder"></i>Product Request</a></li>
                        <li><a href="beneficiary_product_transactions.php"><i class="ti-folder"></i>Transactions</a></li>
                        <li><a class="sidebar-sub-toggle"><i class="ti-panel"></i> Inventory <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="inventory_vegetable_seeds.php"><i class="ti-folder"></i>Vegetable Seeds</a></li>
                                <li><a href="inventory_fruit_seeds.php"><i class="ti-folder"></i>Fruit trees Seeds</a></li>
                                <li><a href="inventory_organic.php"><i class="ti-folder"></i>Organic/Vermicast</a></li>
                                <li><a href="inventory_fertilizer.php"><i class="ti-folder"></i>Fertilizers</a></li>
                                <li><a href="inventory_corn_seeds.php"><i class="ti-folder"></i>Corn Seeds</a></li>
                                <li><a href="inventory_rice_seeds.php"><i class="ti-folder"></i>Rice Seeds</a></li>
                                <li><a href="inventory_chemicals.php"><i class="ti-folder"></i>Chemicals</a></li>
                            </ul>
                        </li>
                        <li><a class="sidebar-sub-toggle"><i class="ti-panel"></i> Reports <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="inventory_reports.php"><i class="ti-folder"></i>Inventory Reports</a></li>
                                <li><a href="planning_barangay_report.php"><i class="ti-folder"></i>Barangay Reports</a></li>
                                <li><a href="planning_beneficiary_report.php"><i class="ti-folder"></i>Beneficiary Reports</a></li>
                                <li><a href="planning_statistical_report.php"><i class="ti-folder"></i>Statistical Reports</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <!-- /# sidebar -->


    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-left">
                    <h4 id="datetime"></h4>
                            <h5 id="time"></h5>
                    </div>
                    <div class="float-right">
                        <div class="dropdown dib">
                            <div class="header-icon" data-toggle="dropdown">
                                <?php 
                                    $count;
                                    if($statement3 = $connection->prepare('SELECT count(product_name) as num from inventory_all_products where status!="Available"')){
                                        $statement3->execute();
                                        $result3 = $statement3->fetchAll();
                                        foreach($result3 as $row3)
                                        {
                                            $count=$row3['num'];
                                        }
                                    }
                                
                                ?>
                                <i class="ti-bell"></i><span style="color:red;font-size:12px;"><b><?php 
                                if($count==0){
                                    echo "";
                                }else{
                                echo $count; 
                                }
                                
                                ?></b></span>
                                <div class="drop-down dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-content-heading">
                                        <span class="text-left">Recent Notifications</span>
                                    </div>
                                    <div class="dropdown-content-body">
                                        <ul>

                                        <?php 
                                        
                                            if($statement4 = $connection->prepare('SELECT * from inventory_all_products where status!="Available" order by created_at desc limit 3')){
                                                $statement4->execute();
                                                $result4 = $statement4->fetchAll();
                                                
                                                if(!empty($result4)){

                                                

                                                foreach($result4 as $row4)
                                                {
                                                 
                                        
                                        ?>

                                            <li>
                                                <a >
                                                    <img class="pull-left m-r-10 avatar-img" src="assets/images/avatar/notif.png" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right"><?php echo $row4['status'] ?></small>
                                                        <div class="notification-heading"><?php echo $row4['product_name'] ?></div>
                                                    </div>
                                                </a>
                                            </li>

                                        <?php 
                                        
                                            }

                                            echo '<li class="text-center">
                                            <a href="#" id="view_notif" class="more-link">See All</a>
                                        </li>';
                                        }else{
                                            echo '<li class="text-center">
                                            <a href="#" >No Nofication</a>
                                                </li>';
                                        }
                                    }
                                        
                                        
                                        ?>
                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                        
                        <div class="dropdown dib">
                            <div class="header-icon" data-toggle="dropdown">
                                <span class="user-avatar"><?php echo $_SESSION["username"]; ?>
                                    <i class="ti-angle-down f-s-10"></i>
                                </span>
                                <div class="drop-down dropdown-profile dropdown-menu dropdown-menu-right">
                              
                                    <div class="dropdown-content-body">
                                        <ul>
                                        <li>
                                                <a id="profile">
                                                    <i class="ti-user"></i>
                                                    <span>Profile</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a id="setting">
                                                    <i class="ti-settings"></i>
                                                    <span>Setting</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a id="logout">
                                                    <i class="ti-power-off"></i>
                                                    <span>Logout</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                
                <!-- /# row -->

                <div class="row">
                            <!-- /# column -->
                            <div class="col-md-12">
                                <div class="card">
                                   <div class="card-body">
                                   <h3>Inventory Fertilizers</h3>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Status:</label>
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="Latest">Latest</option>
                                                        <option value="Old">Old</option>
                                                        <option value="Summary">Summary</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label>From:</label>
                                                <input type="date" class="form-control" id="datefrom" name="datefrom">
                                            </div>
                                            <div class="col-md-2">
                                                <label>To:</label>
                                                <input type="date" class="form-control" id="dateto" name="dateto">
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-primary ti-search" id="filter"></button>
                                            </div>
                                            <div class="col-md-3">
                                                <div align="right">
                                                    <button type="button" id="add" class="btn btn-primary ti-plus" data-toggle="modal" data-target="#userModal2"> Product</button>
                                                </div>
                                            </div>

                                        </div>
                                   
                                   <div class="row">
                                        <div class="col-lg-12"  id="ongoing_table">
                                            <div class="table-responsive">
                                                <table id="user_data" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Product Name</th>
                                                            <th >Units</th>
                                                            <th >Quantity</th>
                                                            <th >Despensed</th>
                                                            <th >Damage</th>
                                                            <th width="12%">Status</th>
                                                             <th>Date Created</th>
                                                            <th width="15%">Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                      
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="footer">
                                    <p>2019 © DAVAO DEL NORTE STATE COLLEGE - INSTITUTE OF INFORMATION TECHNOLOGY. - <a href="www.dnsc.edu.ph">www.dnsc.edu.ph</a></p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>



    <!-- Common -->

    <!-- modal -->
    <div id="userModal" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="assistance_form" action="" target="">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Product</h4>
                            <b><button type="button" class="close" data-dismiss="modal" id="ex_close"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                                <div class="form-group">
                                    <label>Product Name:</label>
                                    <input type="text" name="cproduct_name" id="cproduct_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Units:</label>
                                    <input type="text" name="cunit" id="cunit" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Quantity:</label>
                                    <input type="number" name="cquantity" id="cquantity" class="form-control" disabled>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="cid" id="cid" />
                            
                            <input type="button" id="cupdate" class="btn btn-primary" value="Update" />
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="cclose_form">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="userModal4" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="assistance_form4" action="" target="">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Damage</h4>
                            <b><button type="button" class="close" data-dismiss="modal" id="ex_close"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                                <div class="form-group">
                                    <label>Product Name:</label>
                                    <input type="text" name="damage_product" id="damage_product" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Units:</label>
                                    <input type="text" name="damage_unit" id="damage_unit" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>No. of Damage:</label>
                                    <input type="number" name="damage_quantity" id="damage_quantity" class="form-control" >
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="damage_id" id="damage_id" />
                            <input type="hidden" name="damage_qty" id="damage_qty" />
                            <input type="button" id="update_damage" class="btn btn-primary" value="Update" />
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="cclose_form">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="userModal3" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="assistance_form" action="" target="">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Renew Product</h4>
                            <b><button type="button" class="close" data-dismiss="modal" id="ex_close"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                                <div class="form-group">
                                    <label>Product Name:</label>
                                    <input type="text" name="rcproduct_name" id="rcproduct_name" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Units:</label>
                                    <input type="text" name="rcunit" id="rcunit" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Quantity:</label>
                                    <input type="number" name="rcquantity" id="rcquantity" class="form-control">
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="rcid" id="rcid" />
                            
                            <input type="button" id="rcupdate" class="btn btn-success" value="Renew" />
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="cclose_form">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="userModal2" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="form_add" action="" target="">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Product</h4>
                            <b><button type="button" class="close" data-dismiss="modal" id="ex_close"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                                <div class="form-group">
                                    <label>Product Name:</label>
                                    <input type="text" name="product_name" id="product_name" class="form-control">
                                    <span id="error_product_name"></span>
                                </div>
                                <div class="form-group">
                                    <label>Units:</label>
                                    <input type="text" name="unit" id="unit" class="form-control">
                                    <span id="error_unit"></span>
                                </div>
                                <div class="form-group">
                                    <label>Quantity:</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control">
                                    <span id="error_quantity"></span>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="user_id" id="user_id" />
                            
                            <input type="button" id="addpro" class="btn btn-primary" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="close_form">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    
</body>

    
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
    <script src="assets/js/lib/menubar/sidebar.js"></script>
    <script src="assets/js/lib/preloader/pace.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="assets/js/lib/bootstrap.min.js"></script>
    
    

</html>

<script>
$(document).ready(function(){ 
    var interval=setInterval(function(){
        var momentNow=new moment();
        $('#datetime').html(momentNow.format('MMMM DD, YYYY')+' '+momentNow.format('dddd').substring(0,3).toUpperCase());
        $('#time').html(momentNow.format('A hh:mm:ss'));
   },100);
   $(function() {
        $('#product_name').autocomplete({
            source: <?php echo json_encode($sub_array2); ?>,
            minLength: 0
        }).focus(function () {
            if ($(this).autocomplete("widget").is(":visible")) {
                return;
            }
            $(this).data("uiAutocomplete").search($(this).val());
        });
    });

   $(function() {
        $('#unit').autocomplete({
            source: <?php echo json_encode($sub_array3); ?>,
            minLength: 0
        }).focus(function () {
            if ($(this).autocomplete("widget").is(":visible")) {
                return;
            }
            $(this).data("uiAutocomplete").search($(this).val());
        });
    });
    fetchData();
    var dataTable;

   function fetchData(){
        var status=$('#status').val();
        var datefrom=$('#datefrom').val();
        var dateto=$('#dateto').val();

        dataTable = $('#user_data').DataTable({
            "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"fetch_inventory_fertilizer.php",
                type:"POST",
                data:{'datefrom':datefrom,'dateto':dateto,'status':status}
            },
            "columnDefs":[
                {
                    "targets":[0, 3, 3],
                    "orderable":false,
                },
            ],

            });
   }

   $(document).on('change','#status',function(){
        dataTable.clear().destroy();
        fetchData();
   });

   $(document).on('click', '#filter', function(){
        var datefrom=$('#datefrom').val();
        var dateto=$('#dateto').val();
        if(datefrom!='' && dateto!=''){
            dataTable.clear().destroy();
            fetchData();
            $('#datefrom').css({"border-color":"#000000"});
            $('#dateto').css({"border-color":"#000000"});
        }else{
            $('#print').show();
            $('#datefrom').css({"border-color":"#FF0000"});
            $('#dateto').css({"border-color":"#FF0000"});
        }
	});
   

    $(document).on('click','#addpro',function(){
       var product_name=$('#product_name').val();
       var units=$('#unit').val();
       var quantity=$('#quantity').val()

        if(product_name==''){
            $('#error_product_name').text('*Product Name is Required');
			$('#error_product_name').css({"color":"#FF0000"});
			$('#product_name').css({"border-color":"#FF0000"});
        }else{
            $('#error_product_name').text('')
			$('#product_name').css({"border-color":"#000"});
        }
        if(units==''){
            $('#error_unit').text('*Unit is Required');
			$('#error_unit').css({"color":"#FF0000"});
			$('#unit').css({"border-color":"#FF0000"});
        }else{
            $('#error_unit').text('')
			$('#unit').css({"border-color":"#000"});
        }
        if(quantity==''){
            $('#error_quantity').text('*Quantity is Required');
			$('#error_quantity').css({"color":"#FF0000"});
			$('#quantity').css({"border-color":"#FF0000"});
        }else{
            $('#error_quantity').text('')
			$('#quantity').css({"border-color":"#000"});
        }

        if(product_name!='' && units!='' && quantity!=''){
            var filter=/^[0-9-+]+$/;
            if(filter.test(quantity)){
                $.ajax({
                        url:"insert_product_fertilizers.php",
                        method:'POST',
                        data:{'product_name':product_name,'units':units,'quantity':quantity},
                        success:function(data)
                        {
                            $('#form_add')[0].reset();
                            alert(data);
                            $('#userModal2').modal('hide');
                            dataTable.ajax.reload();
                        }
                    });
            }else{
                $('#error_quantity').text('*Invalid Input, Number is Expected!');
			    $('#error_quantity').css({"color":"#FF0000"});
			    $('#quantity').css({"border-color":"#FF0000"});
            }
        }

    });

    $(document).on('click', '.check', function(){
		var user_id = $(this).attr("id");
            $.ajax({
                    url:"fetch_single_fertilizers.php",
                    method:"POST",
                    data:{user_id:user_id},
                    dataType:"json",
                    success:function(data)
                    {
                       $('#cproduct_name').val(data.product_name);
                       $('#cunit').val(data.units);
                       $('#cquantity').val(data.quantity);
                       $('#cid').val(data.id);
                    }
                });
	});
    $(document).on('click', '.damage', function(){
        var user_id = $(this).attr("id");
            $.ajax({
                    url:"fetch_single_vegetable.php",
                    method:"POST",
                    data:{user_id:user_id},
                    dataType:"json",
                    success:function(data)
                    {
                    $('#damage_product').val(data.product_name);
                    $('#damage_unit').val(data.units);
                    $('#damage_qty').val(data.quantity);
                    $('#damage_id').val(data.id);
                    }
                });
        });
    $(document).on('click', '.renew', function(){
		var user_id = $(this).attr("id");
            $.ajax({
                    url:"fetch_single_fertilizers.php",
                    method:"POST",
                    data:{user_id:user_id},
                    dataType:"json",
                    success:function(data)
                    {
                       $('#rcproduct_name').val(data.product_name);
                       $('#rcunit').val(data.units);
                       $('#rcquantity').val(data.quantity);
                       $('#rcid').val(data.id);
                    }
                });
	});

    $(document).on('click','#cupdate',function(){
        var product_name=$('#cproduct_name').val();
        var unit= $('#cunit').val();
        var quantity= $('#cquantity').val();
        var cid=$('#cid').val();
        $.ajax({
				url:"update_fertilizers.php",
				method:'POST',
				data:{'product_name':product_name,'unit':unit,'quantity':quantity,'cid':cid},
				success:function(data)
				{
                    alert(data);
                    $('#userModal').modal('hide');
                    dataTable.ajax.reload();
				}
			});  
    });
    $(document).on('click','#update_damage',function(){
        var quantity= $('#damage_quantity').val();
            if(quantity!=''){
                if(confirm("Are you sure you want to Update this Data?"))
                    {
                        var cid=$('#damage_id').val();
                        $.ajax({
                                url:"update_vegetable_damage.php",
                                method:'POST',
                                data:{'quantity':quantity,'cid':cid},
                                success:function(data)
                                {
                                    alert(data);
                                    if(data=="Quantity is higher than the stock, please check the field!"){
                                        $('#damage_quantity').css({"border-color":"#FF0000"});
                                    }else{
                                        $('#damage_quantity').css({"border-color":"#000"});
                                        $('#userModal4').modal('hide');
                                        dataTable.ajax.reload();
                                    }
                                }
                            });  
                        
                    }
            }else{
                alert("Some field is required!!");
                $('#damage_quantity').css({"border-color":"#FF0000"});
            }
            
    });
    $(document).on('click','#rcupdate',function(){
        var product_name=$('#rcproduct_name').val();
        var unit= $('#rcunit').val();
        var quantity= $('#rcquantity').val();
        var cid=$('#rcid').val();
        $.ajax({
				url:"update_renew_fertilizer.php",
				method:'POST',
				data:{'product_name':product_name,'unit':unit,'quantity':quantity,'cid':cid},
				success:function(data)
				{
                    alert(data);
                    $('#userModal3').modal('hide');
                    dataTable.ajax.reload();
				}
			});  
    });

    $('#logout').click(function(){
        document.location.href="logout.php";
    });
    $('#profile').click(function(){
        document.location.href="profile_planning.php";
    });
    $('#setting').click(function(){
        document.location.href="planning_setting.php";
    });
    $('#view_notif').click(function(){
        document.location.href="notification_table_inventory.php";
    });

});
</script>
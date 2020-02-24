<?php
session_start();
include('connection.php');

if(!isset($_SESSION['username'])){
    header('location:login.php');
}

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
        .but{
            margin-left:92%;
        }
        .add{
            margin-left:92%;
            margin-top:-80px;
        }
        #print{
            margin-left:83%;
            margin-top:-40px;
        }
        .form-control{
            border-color:black;
            
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
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h3>Product Aquired</h3>
                                            </div>
                                            <div class="col-md-4">
                                                <div align="right">
                                                    <button type="button" id="close_button" class="btn btn-secondary ti-back-left btn-sm"></button>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label >Last Name:</label>
                                                        <input type="text" name="lastname" id="lastname" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label >First Name:</label>
                                                        <input type="text" name="firstname" id="firstname" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label >Middle Name:</label>
                                                        <input type="text" name="middlename" id="middlename" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   <div class="row">
                                        <div class="col-lg-12"  id="ongoing_table">
                                            <div class="table-responsive">
                                                <form action="print_gate_pass.php" method="post" target="_blank">
                                                    <div class="txt"><h5>Type of Product:</h5>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <select name="type_product" id="type_product" class="form-control">
                                                                <option value="All">All</option>
                                                                <?php 
                                                                    $id=$_SESSION['single_id'];
                                                                    $query5="SELECT services_received as re from record_services_beneficiary where request_id='$id'";
                                                                    $statement = $connection->prepare($query5);
                                                                    $statement->execute();
                                                                    $result = $statement->fetchAll();
                                                                    foreach($result as $row)
                                                                    {
                                                                        echo '<option value='.$row["re"].'>'.$row["re"].'</option>';

                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <button type="button" class="btn btn-warning ti-eye btn-sm" id="print" data-toggle="modal" data-target="#userModal"> Acquired</button>
                                                        <?php 
                                                            $service_id=$_SESSION['service_id'];
                                                            $query_check="SELECT * from recent_request where service_id='$service_id'";
                                                            $statement2 = $connection->prepare($query_check);
                                                            $statement2->execute();
                                                            $result2 = $statement2->fetchAll();
                                                            foreach($result2 as $row)
                                                            {
                                                                if($row['status']=='Done'){
                                                                    echo '<button type="button" class="btn btn-primary ti-plus btn-sm add" id="user_id" disabled> Product</button>';
                                                                }else{
                                                                    echo '<button type="button" class="btn btn-primary ti-plus btn-sm add" id="user_id"> Product</button>';
                                                                }
                                                            }
                                                        
                                                        ?>
                                                     
                                                     </div>
                                                    <input type="hidden" value="<?php echo $_SESSION['single_id']; ?>" name ="use_id" id="use_id">
                                                    <input type="hidden" id="bene_id" name="bene_id">
                                                    <h5>Product Acquired</h5>
                                                <div id="alert_message"></div>
                                                <table id="user_data" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th >Prodcut Name</th>
                                                            <th >Unit</th>
                                                            <th >Quantity</th>
                                                            <th >Status</th>
                                                            <th >Date Received</th>
                                                            <th width="5%">Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                </form>
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
                <form method="post" id="assistance_form" action="print_gate_pass2.php" target="_blank">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Beneficiary Product Request</h4>
                            <b><button type="button" class="close" data-dismiss="modal" id="ex_close"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                            <table id="table_ni" class="table table-stripped table-bordered">
                                <thead>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                </thead>
                                <tbody id="body_table">
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="user_id_print" id="user_id_print" />
                            <?php 
                                $service_id=$_SESSION['service_id'];
                                $query_check2="SELECT * from recent_request where service_id='$service_id'";
                                $statement3 = $connection->prepare($query_check2);
                                $statement3->execute();
                                $result3 = $statement3->fetchAll();
                                foreach($result3 as $row)
                                {
                                    if($row['status']=='Done'){
                                        echo '<button type="submit" id="print_ac" class="btn btn-warning ti-printer"> Print</button>';
                                    }else{
                                        echo '<button type="button" id="addassis" class="btn btn-warning ti-thumb-up"> Approved</button>';
                                    }
                                }
                            
                            ?>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="userModal2" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="assistance_form1" action="print_gate_pass.php" target="_blank">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Are you sure you want to finished Adding products to <?php echo $_SESSION['name']; ?>?</h4>
                            <b><button type="button" class="close" data-dismiss="modal" id="ex_close_con"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                           
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="user_id_print_approved" id="user_id_print_approved" />
                            <button type="button" id="yes" class="btn btn-success"> Yes</button>
                            <button type="button" id="cancel" class="btn btn-default"> Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="userModal3" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="assistance_form23">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Product</h4>
                            <b><button type="button" class="close" data-dismiss="modal" id="ex_close_con"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                           <div class="form-group">
                                <label>Quantity:</label>
                                <input type="number" class="form-control" id="quantity" name="quantity">
                           </div>
                           <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="On Going">On Going</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Done">Done</option>
                                    <option value="Cancel">Cancel</option>
                                </select>
                           </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id_product" id="id_product" />
                            <button type="submit" id="update_product" class="btn btn-success"> Update</button>
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

    fetch_single_bene();
    fetchdata();
    function fetch_single_bene()
    {
        var use_id=$("#use_id").val();
        $.ajax({
                url:"fetch_single_bene_services.php",
                method:"POST",
                dataType:"json",
                data:{use_id:use_id},
                success:function(data)
                {
                    $("#lastname").val(data.lastname);
                    $("#firstname").val(data.firstname);
                    $("#middlename").val(data.middlename);
                    $("#user_id").val(data.id);
                    $("#bene_id").val(data.bene_id);
                }
            });
            
    };
    function update_data(id, column_name, value)
    {
        if(value==''){
            alert("Filed is Empty, Data not Save!");
            dataTable.ajax.reload();
        }else{
            $.ajax({
            url:"update_product_bene.php",
            method:"POST",
            data:{id:id, column_name:column_name, value:value},
            success:function(data)
            {
                dataTable.ajax.reload();
            }
        });
            
        }
        
    };

    var dataTable;

    $(document).on('change','#type_product',function(){
       dataTable.clear().destroy();
       fetchdata();
    });

    function fetchdata(){
        var type=$('#type_product').val();
        dataTable = $('#user_data').DataTable({
        "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"fetch_single_product_bene.php",
            type:"POST",
            data:{'type':type}
        },
        "columnDefs":[
            {
                "targets":[0, 3, 3],
                "orderable":false,
            },
        ],

        });
    };

    

    $('#user_id').click(function(){
        var request_id = $('#user_id').val();
        var bene_id=$('#bene_id').val();
        var type=$('#type_product').val();
        
        $.ajax({
				url:"goto_product_list.php",
				method:'POST',
				data:{'request_id':request_id,'bene_id':bene_id,'type':type},
				success:function(data)
				{
                    document.location.href="product_list_single.php";
				}
			});
        
    });

    $(document).on('click','#print',function(){
        var user_id=$('#use_id').val();
        $('#user_id_print').val(user_id);

        $.ajax({
                    url:"fetch_single_product_acquired_record.php",
                    method:"POST",
                    data:{user_id:user_id},
                    dataType:"json",
                    success:function(data)
                    {
                        var arr1=[];
                        arr1=data.product.trim().split(',');
                        var arr2=[];
                        arr2=data.qty.trim().split(',');
                        var arr3=[];
                        arr3=data.id.trim().split(',');
                        var arr4=[];
                        arr4=data.unique.trim().split(',');
                        if(arr1.length==1){
                            $('#addassis').hide();
                            $('#table_ni tbody').append("<tr><td>No product Acquired!, Please Add Product!!</td></tr>");
                        }else{
                            $('#addassis').show();
                        }
                        for($i=0;$i<arr1.length;$i++){
                           var html='<tr><td>'+arr1[$i]+'</td><td><input type="hidden" name="uni[]" class="uni" id="uni" value="'+arr4[$i]+'">'+arr2[$i]+'<input type="hidden" name="qty[]" class="qty" id="qty" value="'+arr2[$i]+'"></td><input type="hidden" name="idni[]" class="idni" id="idni" value="'+arr3[$i]+'"></tr>';
                           $('#table_ni tbody').append(html);
                        }
                        
                    }
                });
    });

    $(document).on('click','.view',function(){
        var user_id = $(this).attr("id");
        $.ajax({
			url:"fetch_single_product.php",
			method:"POST",
			data:{user_id:user_id},
			dataType:"json",
			success:function(data)
			{
                $('#quantity').val(data.quantity);
                $('#status').val(data.status);
                $('#id_product').val(data.unique_id);
			}
		});
    }); 

    $(document).on('submit','#assistance_form23',function(){
        $.ajax({
            url:"update_product_user.php",
            method:'POST',
            data:new FormData(this),
            contentType:false,
            processData:false,
            success:function(data)
            {
                $('#assistance_form23')[0].reset();
                alert(data);
                $('#userModal3').modal('hide');
                dataTable.ajax.reload();
            }
        });
    });

    $(document).on('click', '#can', function(){
        dataTable.ajax.reload();
    });

    $(document).on('blur', '.update', function(){
        var id = $(this).data("id");
        var column_name = $(this).data("column");
        var value = $(this).text();
        update_data(id, column_name, value);
    });

    $(document).on('click', '#insert', function(){
        var num = $('#data1').text();
        var qty = $('#data2').text();
        var unit = $('#data3').text();
        var item = $('#data4').text();
        var bene_id=$("#bene_id").val();
        var req_id=$("#user_id").val();
        if(num != '' && qty != '' && unit !='' && item !='')
        {
            $.ajax({
            url:"insert_product_bene.php",
            method:"POST",
            data:{num:num,qty:qty,unit:unit,item:item,bene_id:bene_id,req_id:req_id},
            success:function(data)
            {
            dataTable.ajax.reload();
            $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
            
            }
            });
            setInterval(function(){
            $('#alert_message').html('');
            }, 5000);
        }
        else
        {
            alert("Both Fields is required");
        }
    });

    $(document).on('click','#addassis',function(){
        var user_id=$('#user_id_print').val();
        $('#user_id_print_approved').val(user_id);
        $('#userModal').modal('hide');
        $('#userModal2').modal('show');
    });

    $('#ex_close_con').click(function(){
        $('#userModal').modal('show');
        $('#userModal2').modal('hide');
    });
    $('#cancel').click(function(){
        $('#userModal').modal('show');
        $('#userModal2').modal('hide');
    });

    $('#ex_close').click(function(){
        $('#body_table tr').remove();
    });
    $('#close_button').click(function(){
        document.location.href="product_record_list_single.php";
    });

    $(document).on('click','#yes',function(){
        var user_id=$('#user_id_print_approved').val();
        var id=[];
        var quan=[];
        var uni=[];

        $('input.idni').each(function(){
            id.push($(this).val());
        });
        $('input.qty').each(function(){
            quan.push($(this).val());
        });
        $('input.uni').each(function(){
            uni.push($(this).val());
        });


        $.ajax({
				url:"goto_product_approved.php",
				method:'POST',
				data:{'uni[]':uni.join(),'quantity[]':quan.join(),'id[]':id.join(),'user_id':user_id},
				success:function(data)
				{
                    window.open('print_gate_pass.php');
                    
				}
			});
            location.reload();
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
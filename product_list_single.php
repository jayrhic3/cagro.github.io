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
    <link href="js/dataTables.checkboxes.css" rel="stylesheet" />

    <script src="js/jquery.min.js"></script>

    <style>
        .back{
            background:skyblue;
        }
        .table{
            width:100%;
        }
        .table.checkboxes{
            height:20px;
            width:20px;
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
                                   <h3>Add Products</h3>
                                   <div class="row">
                                        <div class="col-md-12"  id="ongoing_table">
                                        <div align="right">
                                            <button type="button" id="close_button" class="btn btn-secondary ti-back-left btn-sm"></button>
                                        </div>

                                        <h4>Type of Product:</h4>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <select name="type_product" id="type_product" class="form-control">
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
                                        <input type="hidden" id="type" value="<?php echo $_SESSION['type']; ?>">
                                        <input type="hidden" id="request_id" value="<?php echo $_SESSION['request_id']; ?>">
                                        <input type="hidden" id="bene_id" value="<?php echo $_SESSION['beneficiary_id']; ?>">
                                        <div align="right">
                                            <button type="button" class="btn btn-warning ti-eye" id="next" data-toggle="modal" data-target="#userModal"> Choosen Product</button>
                                        </div><br>
                                                <table id="user_data" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Product Name</th>
                                                            <th >Unit Description</th>
                                                            <th >Quantity in Stock</th>
                                                            <th>Status</th>
                                                            <th width="5%"></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            <div>
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
    <div id="userModal" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="assistance_form" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Product List </h4>
                            <b><button type="button" class="close" data-dismiss="modal" id="ex_close"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                            <table id="product_data" class="table table-striped table-bordered">
                                <thead>
                                    <th>Product Name</th>
                                    <th>Stock</th>
                                    <th>Quantity</th>
                                </thead>
                                <tbody id="table_nako">
                                                
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="user_id" id="user_id" />
                           
                            <input type="button" id="add_product" class="btn btn-primary" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="close_form">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="userModal2" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="assistance_form" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Are you sure you want to add this product to <?php echo $_SESSION['name']; ?>? </h4>
                            <b><button type="button" class="close" data-dismiss="modal" id="ex_close_con"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                            <table id="product_data_con" class="table table-striped table-bordered">
                                <thead>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                </thead>
                                <tbody id="table_nako_con">
                                                
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="user_id" id="user_id" />
                           
                            <input type="button" id="add_product_con" class="btn btn-primary" value="Yes" />
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="close_form_con">Cancel</button>
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
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <script src="js/dataTables.checkboxes.min.js"></script>
    <script src="js/moment.min.js"></script>
    

</html>

<script>
$(document).ready(function(){ 
    var interval=setInterval(function(){
        var momentNow=new moment();
        $('#datetime').html(momentNow.format('MMMM DD, YYYY')+' '+momentNow.format('dddd').substring(0,3).toUpperCase());
        $('#time').html(momentNow.format('A hh:mm:ss'));
   },100);
        $('#type_product').val($('#type').val());
        fetchdata();

       var dataTable;

       $(document).on('change','#type_product',function(){
            dataTable.clear().destroy();
            fetchdata();
        });

        function fetchdata(){
        var type=$('#type_product').val();
        dataTable = $('#user_data').DataTable({
        "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"fetch_single_inventory_vegetableSeeds.php",
            type:"POST",
            data:{'type':type}
        },
        "columnDefs":[
            {
                "targets":4,
                "checkboxes":{
                    "selectRow":true,
                }
            },
        ],
        "select":{
            "style":"multi"
        }

        });
    };
    

    $(document).on('click','#next',function(){
        var rows_selected=[];
        rows_selected=dataTable.column(4).checkboxes.selected();

        $.ajax({
                    url:"fetch_single_product_acquired.php",
                    method:"POST",
                    data:{'user_id[]':rows_selected.join()},
                    dataType:"json",
                    success:function(data)
                    {
                        var arr1=[];
                        arr1=data.product_name.trim().split(',');
                        var arr2=[];
                        arr2=data.quantity.trim().split(',');
                        var arr3=[];
                        arr3=data.id.trim().split(',');

                        if(arr2.length==1){
                            $('#add_product').hide();
                            $('#product_data tbody').append("<tr><td style='color:red'>No product Selected!, Please select Product!!</td></tr>");
                        }else{
                            $('#add_product').show();
                        }

                        for(var i=0;i<arr1.length-1;i++){
                            var html="<tr>";
                            html+="<td name='product[]' class='desc' value='"+arr1[i]+"' id='product'>"+arr1[i]+"</td>";
                            html+="<td name='stock[]' class='stock' value='"+arr2[i]+"' id='stock'>"+arr2[i]+"</td>";
                            html+="<td><input type='number' class='form-control quan' name='quantity[]' id='quantity' value='0'></input></td>";
                            html+="<input type='hidden' class='id_data' name='data_id[]' value='"+arr3[i]+"' id='data_id'>"+arr3[i]+"</input>";
                            html+="</tr>";
                            
                            $('#product_data tbody').append(html);
                        }
                    }
                });
        
        
    });

    $(document).on('click','#close_form',function(){
        $('#table_nako tr').remove();
    });
    $(document).on('click','#close_form_con',function(){
        $('#table_nako_con tr').remove();
        $('#userModal').modal('show');
        $('#userModal2').modal('hide');
    });
    $(document).on('click','#ex_close',function(){
        $('#table_nako tr').remove();
    });
    $(document).on('click','#ex_close_con',function(){
        $('#table_nako_con tr').remove();
        $('#userModal').modal('show');
        $('#userModal2').modal('hide');
    });

    $(document).on('click','#add_product',function(){
        var desc=[];
        var quan=[];
        var stock=[];
        var count=0;
        var count2=0;

        $('td.desc').each(function(){
            desc.push($(this).text());
        });
        $('td.stock').each(function(){
            stock.push($(this).text());
        });
        $('input.quan').each(function(){
        quan.push($(this).val());
        });

        for(var i=0;i<quan.length;i++){
          if(quan[i]=='0'||quan[i]==''){
            count+=1;
          }
          if(quan[i]>stock[i]){
            count2+=1;
          }
        }

        if(count==0){
            if(count2==0){
                for(var i=0;i<desc.length;i++){
                var html='<tr><td>'+desc[i]+'</td><td>'+quan[i]+'</td></tr>';
                $('#product_data_con tbody').append(html);
                }
                $('#add_product_con').show();
            }else{
                var html='<tr><td style="color:red">Invalid Input!! the quamtity is higher than the stock.</td></tr>';
                $('#product_data_con tbody').append(html);
                $('#add_product_con').hide();
            }
            
        }else{
            var html='<tr><td style="color:red">Some field are empty or equal to 0.</td></tr>';
            $('#product_data_con tbody').append(html);
            $('#add_product_con').hide();
        }

       

        $('#userModal').modal('hide');
        $('#userModal2').modal('show');

    });

    $(document).on('click','#add_product_con',function(){
        var quan=[];
        var id=[];
       $('input.quan').each(function(){
        quan.push($(this).val());
       });
       $('input.id_data').each(function(){
        id.push($(this).val());
       });
       var request_id=$('#request_id').val();
       var bene_id=$('#bene_id').val();
       
       $.ajax({
                    url:"insert_single_product_acquired.php",
                    method:"POST",
                    data:{'quantity[]':quan.join(),'id[]':id.join(),'request_id':request_id,'bene_id':bene_id},
                    dataType:"json",
                    success:function(data)
                    {
                       alert(data);
                       $('#userModal').modal('hide');
                       $('#userModal2').modal('hide');
                       document.location.href="single_record_products.php";
                    }
                });

    });

    $('#close_button').click(function(){
        document.location.href="single_record_products.php";
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
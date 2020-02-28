<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <style>
      
        @page {  margin: 0mm; }
      
        .right_image{
            margin-left:40px;
        }
        h6{
            text-align:center;
            color:black;
            font-size:20px;
        }
        h3{
            color:black;
        }
        .card{
            width:90%;
            margin-left:50px;
        }
        #chartContainer{
            margin-left:20px;
        }
        #chartContainer3{
            margin-left:20px;
        }
        .table-stripped{
            width:90%;
            margin-left:50px;
        }
    </style>
</head>
<body>
    <?php 
        include('connection.php');
        $year=$_POST['year'];
        $type=$_POST['type'];
        
        if($type==='Monthly'){

    ?>
<br><br><br>
    <div class="row">
        <div class="col-md-3">
            <div class="right_image">
                <img src="assets/images/tagum.png" width="200px" height="180px">
            </div>
        </div>
        <div class="col-md-6">
        <h6>Republic of the Philippines</h6>
        <h6>Province of Davao del Norte</h6>
        <h6>City of Tagum</h6><br>
        <h3 align="center">Number of product issue per month in year <?php echo $year; ?></h3>
        </div>
        <div class="col-md-3">
            <div class="left_image">
                <img src="assets/images/cagro1.png" width="200px" height="180px">
            </div>
        </div>
    </div><br>
            <div class="container" align="center" id="chartContainer" style="height: 400px; width: 70%;"></div>
       
            <input type="hidden" value="<?php echo $_POST['year']; ?>" id="year">
            <input type="hidden" value="<?php echo $_POST['type']; ?>" id="type">
            <input type="hidden" value="<?php echo $_POST['yearfrom']; ?>" id="yearfrom">
            <input type="hidden" value="<?php echo $_POST['yearto']; ?>" id="yearto">
            <input type="hidden" value="<?php echo $_POST['datefrom']; ?>" id="datefrom">
            <input type="hidden" value="<?php echo $_POST['dateto']; ?>" id="dateto">
            <br>
        <table class="table table-stripped table-bordered">
            <thead>
                <th>No.</th>
                <th>Month</th>
                <th>Type of Product</th>
                <th>No. of product issue</th>
            </thead>
            <tbody>
            <?php 
            $count=1;
            $query = 'select t2.num as num,t2.created_at as created,t2.product_name as name,t2.type_product as type,t2.month as mon from (select sum(t2.quantity) as num,t2.created_at as created_at, t1.product_name as product_name,t1.type_product as type_product,month(t2.created_at) as month from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at) = "'.$year.'" group by month(t2.created_at),t1.type_product) as t2 ';

            $statement = $connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
                echo '<tr>';
                echo '<td>'.$count.'</td><td>'.date("F", mktime(0, 0, 0, $row['mon'], 10)).'</td><td>'.$row['type'].'</td><td>'.$row['num'].'</td>';
                echo '</tr>';
                $count++;

            }
            ?>
            </tbody>
        </table>
   
    <?php 
    
        }
        else if($type==='Yearly')
        {
            $yearf=$_POST['yearfrom'];
            $yeart=$_POST['yearto'];
    

    ?>
    
<br><br><br>
    <div class="row">
        <div class="col-md-3">
            <div class="right_image">
                <img src="assets/images/tagum.png" width="200px" height="180px">
            </div>
        </div>
        <div class="col-md-6">
        <h6>Republic of the Philippines</h6>
        <h6>Province of Davao del Norte</h6>
        <h6>City of Tagum</h6><br>
        <h3 align="center">Number of product issue per year from <?php echo $yearf; ?> to <?php echo $yeart; ?></h3>
        </div>
        <div class="col-md-3">
            <div class="left_image">
                <img src="assets/images/cagro1.png" width="200px" height="180px">
            </div>
        </div>
    </div><br>
            <div class="container" align="center" id="chartContainer" style="height: 400px; width: 70%;"></div>
       
            <input type="hidden" value="<?php echo $_POST['year']; ?>" id="year">
            <input type="hidden" value="<?php echo $_POST['type']; ?>" id="type">
            <input type="hidden" value="<?php echo $_POST['yearfrom']; ?>" id="yearfrom">
            <input type="hidden" value="<?php echo $_POST['yearto']; ?>" id="yearto">
            <input type="hidden" value="<?php echo $_POST['datefrom']; ?>" id="datefrom">
            <input type="hidden" value="<?php echo $_POST['dateto']; ?>" id="dateto">
            <br>
            <table class="table table-stripped table-bordered">
            <thead>
                <th>No.</th>
                <th>Year</th>
                <th>Type of Product</th>
                <th>No. of product issue</th>
            </thead>
            <tbody>
            <?php 
            $count=1;
            $query = 'SELECT sum(t2.quantity) as num,t2.created_at as cre,t1.product_name as name,t1.type_product as type,year(t2.created_at) as year from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where year(t2.created_at) between "'.$yearf.'" and "'.$yeart.'" group by t1.type_product,year(t2.created_at) ';

            $statement = $connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
                echo '<tr>';
                echo '<td>'.$count.'</td><td>'.$row['year'].'</td><td>'.$row['type'].'</td><td>'.$row['num'].'</td>';
                echo '</tr>';
                $count++;

            }
            ?>
            </tbody>
        </table>
    <?php 
    
        }
        else if($type==='Customize')
        {
            $datef=$_POST['datefrom'];
            $datet=$_POST['dateto'];
        
    
    ?>
    
<br><br><br>
    <div class="row">
        <div class="col-md-3">
            <div class="right_image">
                <img src="assets/images/tagum.png" width="200px" height="180px">
            </div>
        </div>
        <div class="col-md-6">
        <h6>Republic of the Philippines</h6>
        <h6>Province of Davao del Norte</h6>
        <h6>City of Tagum</h6><br>
        <h3 align="center">Number of product issue from <?php echo date('F j, Y',strtotime($datef)); ?> to <?php echo date('F j, Y',strtotime($datet)); ?></h3>
        </div>
        <div class="col-md-3">
            <div class="left_image">
                <img src="assets/images/cagro1.png" width="200px" height="180px">
            </div>
        </div>
    </div><br>
            <div class="container" align="center" id="chartContainer3" style="height: 400px; width: 70%;"></div>
       
            <input type="hidden" value="<?php echo $_POST['year']; ?>" id="year">
            <input type="hidden" value="<?php echo $_POST['type']; ?>" id="type">
            <input type="hidden" value="<?php echo $_POST['yearfrom']; ?>" id="yearfrom">
            <input type="hidden" value="<?php echo $_POST['yearto']; ?>" id="yearto">
            <input type="hidden" value="<?php echo $_POST['datefrom']; ?>" id="datefrom">
            <input type="hidden" value="<?php echo $_POST['dateto']; ?>" id="dateto">
            <br>
            <table class="table table-stripped table-bordered">
            <thead>
                <th>No.</th>
                <th>Date</th>
                <th>Type of Product</th>
                <th>Product Name</th>
                <th>No. of product issue</th>
            </thead>
            <tbody>
            <?php 
            $count=1;
            $query = 'SELECT t2.quantity as num,t1.type_product as type,t1.product_name as name,t2.created_at as dateni,t1.type_product as type from inventory_all_products as t1 inner join beneficiary_record_product as t2 on t2.product_id=t1.id where DATE_FORMAT(t2.created_at,"%Y-%m-%d") between "'.$datef.'" and "'.$datet.'" ';

            $statement = $connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
                echo '<tr>';
                echo '<td>'.$count.'</td><td>'.date('F j, Y',strtotime($row['dateni'])).'</td><td>'.$row['type'].'</td><td>'.$row['name'].'</td><td>'.$row['num'].'</td>';
                echo '</tr>';
                $count++;

            }
            ?>
            </tbody>
        </table>
    <?php
    
        }
    
    
    
    ?>

</body>
<script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/morris.min.js"></script>
    <script src="js/raphael-min.js"></script>
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
    <script src="assets/js/lib/menubar/sidebar.js"></script>
    <script src="assets/js/lib/preloader/pace.min.js"></script>
    <script src="js/canvasjs.min.js"></script>
    <script src="js/moment.min.js"></script>
</html>

<script>
    $(document).ready(function(){
        fetchChart();
        function fetchChart(){
        var year=$('#year').val();
        var type=$('#type').val();
        var yearf=$('#yearfrom').val();
        var yeart=$('#yearto').val();
        var datef=$('#datefrom').val();
        var datet=$('#dateto').val();
        $.ajax({
                url:"fetch_single_chart2.php",
                method:"POST",
                data:{year:year,type:type,yearf:yearf,yeart:yeart,datef:datef,datet:datet},
                dataType:"json",
                success:function(data)
                {
                    if(type=="Monthly"){
                    $('#chartContainer3').show();
                    $('#chartContainer').show();
                var chart = new CanvasJS.Chart("chartContainer");

                chart.options.zoomEnabled = true;
                chart.options.animationEnabled = true;
                chart.options.theme = "light2";

                    var series1 = { //dataSeries - first quarter
                        type: "column",
                        name: "January",
                        yValueFormatString: "#,##0",
                        showInLegend: true
                    };

                    var series2 = { //dataSeries - second quarter
                        type: "column",
                        name: "February",
                        yValueFormatString: "#,##0",
                        showInLegend: true
                    };
                    var series3 = { //dataSeries - second quarter
                        type: "column",
                        name: "March",
                        yValueFormatString: "#,##0",
                        showInLegend: true
                    };
                    var series4 = { //dataSeries - second quarter
                        type: "column",
                        name: "April",
                        yValueFormatString: "#,##0",
                        showInLegend: true
                    };
                     var series5 = { //dataSeries - second quarter
                        type: "column",
                        name: "May",
                        yValueFormatString: "#,##0",
                        showInLegend: true
                    };
                    var series6 = { //dataSeries - second quarter
                        type: "column",
                        name: "June",
                        yValueFormatString: "#,##0",
                        showInLegend: true
                    };
                    var series7 = { //dataSeries - first quarter
                        type: "column",
                        name: "July",
                        yValueFormatString: "#,##0",
                        showInLegend: true
                    };

                    var series8 = { //dataSeries - second quarter
                        type: "column",
                        name: "August",
                        yValueFormatString: "#,##0",
                        showInLegend: true
                    };
                    var series9 = { //dataSeries - second quarter
                        type: "column",
                        name: "September",
                        yValueFormatString: "#,##0",
                        showInLegend: true
                    };
                    var series10 = { //dataSeries - second quarter
                        type: "column",
                        name: "October",
                        yValueFormatString: "#,##0",
                        showInLegend: true
                    };
                     var series11 = { //dataSeries - second quarter
                        type: "column",
                        name: "November",
                        yValueFormatString: "#,##0",
                        showInLegend: true
                    };
                    var series12 = { //dataSeries - second quarter
                        type: "column",
                        name: "December",
                        yValueFormatString: "#,##0",
                        showInLegend: true
                    };


                    chart.options.data = [];

                    series1.dataPoints = data[0];
                    series2.dataPoints = data[1];
                    series3.dataPoints = data[2];
                    series4.dataPoints = data[3];
                    series5.dataPoints = data[4];
                    series6.dataPoints = data[5];
                    series7.dataPoints = data[6];
                    series8.dataPoints = data[7];
                    series9.dataPoints = data[8];
                    series10.dataPoints = data[9];
                    series11.dataPoints = data[10];
                    series12.dataPoints = data[11];

                    chart.options.data.push(series1);
                    chart.options.data.push(series2);
                    chart.options.data.push(series3);
                    chart.options.data.push(series4);
                    chart.options.data.push(series5);
                    chart.options.data.push(series6);
                    chart.options.data.push(series7);
                    chart.options.data.push(series8);
                    chart.options.data.push(series9);
                    chart.options.data.push(series10);
                    chart.options.data.push(series11);
                    chart.options.data.push(series12);

                    chart.render();
                }else if(type=="Yearly"){

                    $('#chartContainer3').show();
                    $('#chartContainer').show();

                    var chart = new CanvasJS.Chart("chartContainer");

                    chart.options.zoomEnabled = true;
                    chart.options.animationEnabled = true;
                    chart.options.theme = "light2";

                    

                    chart.options.data = [];
                    var start = 0;
                    var end = 0;
                    start = yearf;
                    end = yeart;
                    var val = 0;

                    for(i=start;i<=end;i++){
                        var series1 = { //dataSeries - first quarter
                        type: "column",
                        name: ""+i+"",
                        yValueFormatString: "#,##0",
                        showInLegend: true
                    };
                        series1.dataPoints = data[val];
                        chart.options.data.push(series1);
                        val++;
                    }
                       
                    chart.render();
                
            }else if(type=="Customize"){
                $('#chartContainer3').show();
                $('#chartContainer').show();
                fetchChart4();
            }   
               
			
		
                }
            });
        };

        function fetchChart4(){
        var year=$('#year').val();
        var type=$('#type').val();
        var yearf=$('#yearfrom').val();
        var yeart=$('#yearto').val();
        var datef=$('#datefrom').val();
        var datet=$('#dateto').val();
        $.ajax({
                url:"fetch_single_chart2.php",
                method:"POST",
                data:{year:year,type:type,yearf:yearf,yeart:yeart,datef:datef,datet:datet},
                dataType:"json",
                success:function(data)
                {
                var chart = new CanvasJS.Chart("chartContainer3", {
                        animationEnabled: true,
                        theme: "light2",
                        zoomEnabled: true,
                        data: [{
                            type: "column",
                            indexLabelPlacement: "outside",
                            yValueFormatString: "#,##0",
                            dataPoints: data
                        }]
                    });
                    chart.render();
                }
            });
    }

     });
</script>
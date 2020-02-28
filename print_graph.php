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
        <h3 align="center">Number of beneficiary serve per month in year <?php echo $year; ?></h3>
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
                <th>No. of Beneficiary Serve</th>
            </thead>
            <tbody>
            <?php 
            $count=1;
            $query = 'SELECT t1.num as num,t1.mon as mon,t1.created_at as created_at 
            from (select count(distinct beneficiary_id) as num,month(created_at) as mon,
            created_at as created_at from record_assistance_beneficiary where year(created_at)="'.$year.'"
            group by month(created_at)) as t1 ';

            $statement = $connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
                echo '<tr>';
                echo '<td>'.$count.'</td><td>'.date("F", mktime(0, 0, 0, $row['mon'], 10)).'</td><td>'.$row['num'].'</td>';
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
        <h3 align="center">Number of beneficiary serve per year from <?php echo $yearf; ?> to <?php echo $yeart; ?></h3>
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
                <th>No. of Beneficiary Serve</th>
            </thead>
            <tbody>
            <?php 
            $count=1;
            $query = 'SELECT sum(t2.num) as num, t2.year as year from (select count(distinct beneficiary_id) as num,year(created_at) as year from record_assistance_beneficiary group by month(created_at),year(created_at)) as t2 where t2.year between "'.$yearf.'" and "'.$yeart.'" group by t2.year ';

            $statement = $connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
                echo '<tr>';
                echo '<td>'.$count.'</td><td>'.$row['year'].'</td><td>'.$row['num'].'</td>';
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
        <h3 align="center">Number of beneficiary serve from <?php echo date('F j, Y',strtotime($datef)); ?> to <?php echo date('F j, Y',strtotime($datet)); ?></h3>
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
                <th>Date</th>
                <th>No. of Beneficiary Serve</th>
            </thead>
            <tbody>
            <?php 
            $count=1;
            $query = 'SELECT t1.dateni as dateni,t1.num as num from (select count(distinct beneficiary_id) as num
            ,DATE_FORMAT(created_at,"%Y-%m-%d") as dateni from record_assistance_beneficiary where 
            DATE_FORMAT(created_at,"%Y-%m-%d") between "'.$datef.'" and "'.$datet.'" 
            group by DATE_FORMAT(created_at,"%Y-%m-%d")) as t1 ';

            $statement = $connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
                echo '<tr>';
                echo '<td>'.$count.'</td><td>'.date('F j, Y',strtotime($row['dateni'])).'</td><td>'.$row['num'].'</td>';
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
                url:"fetch_single_chart.php",
                method:"POST",
                data:{year:year,type:type,yearf:yearf,yeart:yeart,datef:datef,datet:datet},
                dataType:"json",
                success:function(data)
                {
                var chart = new CanvasJS.Chart("chartContainer", {
                        animationEnabled: true,
                        theme: "light2",
                        data: [{
                            type: "column",
                            yValueFormatString: "#,##0",
                            dataPoints: data
                        }]
                    });
                    chart.render();
                }
            });
        };

     });
</script>
<?php 

require "fpdf/fpdf.php";
include('connection.php');
$count=0;

$status=$_POST["status"];
$status_r=$_POST["status_r"];
$datefrom=$_POST["datefrom"];
$dateto=$_POST["dateto"];

if($status=='All'&&$status_r=='Latest'&&$datefrom==''&&$dateto==''){
  
class myPDF extends FPDF{
    function header(){
        $status=$_POST["status"];
        $status_r=$_POST["status_r"];

        $date=date('h:i:s a m/d/Y',time());
        $cdate=date('F j, Y',strtotime($date));
        $time=date('g:i a',strtotime("$date"));

       $this->Ln();
        $this->Image('assets/images/tagum.png',170,6,35);
        $this->Image('assets/images/cagro1.png',10,6,30);
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','',14);
        $this->Cell(200,5,'Republic of the Philippines',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'Province of Davao del Norte',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'City of Tagum',0,0,'C'); 
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,'CITY AGRICULTURE OFFICE',0,0,'C'); 
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,$status_r.' Inventory Report of '.$status.' Products as of '.$cdate,0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    function header1($status){
        
    }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(75,10,'Product Name',1,0,'C');
        $this->Cell(20,10,'Units',1,0,'C');
        $this->Cell(20,10,'Quantity',1,0,'C');
        $this->Cell(20,10,'Disposed',1,0,'C');
        $this->Cell(20,10,'Total ',1,0,'C');
        $this->Cell(30,10,'Date ',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection){
        $count=0;
       $query='SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
       t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
       quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
       inventory_all_products where status_updated="Latest") as t2 order by t2.created desc';
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(75,10,$row['product_name'],1,0,'L');
        $this->Cell(20,10,$row['units'],1,0,'L');
        $this->Cell(20,10,$row['quantity'],1,0,'L');
        $this->Cell(20,10,$row['despensed'],1,0,'L');
        $this->Cell(20,10,$row['quantity']+$row['despensed'],1,0,'L');
        $this->Cell(30,10,$row['dates'],1,0,'L');
        $this->Ln();
       }
    }
    function viewtotal($connection){
        $query='SELECT sum(quantity) as quantity,sum(despensed) as despensed,
        sum(quantity+despensed) as total from inventory_all_products where status_updated="Latest"';
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
         $this->SetFont('Times','B',10);
         $this->Cell(85,10,'TOTAL:',1,0,'L');
         $this->Cell(20,10,'',1,0,'L');
         $this->Cell(20,10,$row['quantity'],1,0,'L');
         $this->Cell(20,10,$row['despensed'],1,0,'L');
         $this->Cell(20,10,$row['total'],1,0,'L');
         $this->Cell(30,10,'',1,0,'L');
         $this->Ln();
        }
    }
}

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Legal',0);
$pdf->header1($status);
$pdf->headerTable();
$pdf->viewTable($connection);
$pdf->viewtotal($connection);
$pdf->Output();
}
else if($status=='All'&&$status_r=='Old'&&$datefrom==''&&$dateto==''){
     
class myPDF extends FPDF{
    function header(){
        $status=$_POST["status"];
        $status_r=$_POST["status_r"];

        $date=date('h:i:s a m/d/Y',time());
        $cdate=date('F j, Y',strtotime($date));
        $time=date('g:i a',strtotime("$date"));

       $this->Ln();
        $this->Image('assets/images/tagum.png',170,6,35);
        $this->Image('assets/images/cagro1.png',10,6,30);
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','',14);
        $this->Cell(200,5,'Republic of the Philippines',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'Province of Davao del Norte',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'City of Tagum',0,0,'C'); 
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,'CITY AGRICULTURE OFFICE',0,0,'C'); 
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,$status_r.' Inventory Report of '.$status.' Products as of '.$cdate,0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    function header1($status){
        
    }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(75,10,'Product Name',1,0,'C');
        $this->Cell(20,10,'Units',1,0,'C');
        $this->Cell(20,10,'Quantity',1,0,'C');
        $this->Cell(20,10,'Disposed',1,0,'C');
        $this->Cell(20,10,'Total ',1,0,'C');
        $this->Cell(30,10,'Date ',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection){
        $count=0;
       $query='SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
       t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
       quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
       inventory_all_products where status_updated="Old") as t2 order by t2.created desc';
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(75,10,$row['product_name'],1,0,'L');
        $this->Cell(20,10,$row['units'],1,0,'L');
        $this->Cell(20,10,$row['quantity'],1,0,'L');
        $this->Cell(20,10,$row['despensed'],1,0,'L');
        $this->Cell(20,10,$row['quantity']+$row['despensed'],1,0,'L');
        $this->Cell(30,10,$row['dates'],1,0,'L');
        $this->Ln();
       }
    }
    function viewtotal($connection){
        $query='SELECT sum(quantity) as quantity,sum(despensed) as despensed,
        sum(quantity+despensed) as total from inventory_all_products where status_updated="Old"';
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
         $this->SetFont('Times','B',10);
         $this->Cell(85,10,'TOTAL:',1,0,'L');
         $this->Cell(20,10,'',1,0,'L');
         $this->Cell(20,10,$row['quantity'],1,0,'L');
         $this->Cell(20,10,$row['despensed'],1,0,'L');
         $this->Cell(20,10,$row['total'],1,0,'L');
         $this->Cell(30,10,'',1,0,'L');
         $this->Ln();
        }
    }
}

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Legal',0);
$pdf->header1($status);
$pdf->headerTable();
$pdf->viewTable($connection);
$pdf->viewtotal($connection);
$pdf->Output();
}
else if($status=='All'&&$status_r=='Summary'&&$datefrom==''&&$dateto==''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST["status"];
            $status_r=$_POST["status_r"];
    
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
    
           $this->Ln();
            $this->Image('assets/images/tagum.png',170,6,35);
            $this->Image('assets/images/cagro1.png',10,6,30);
            $this->Ln();
            $this->Ln();
            $this->SetFont('Arial','',14);
            $this->Cell(200,5,'Republic of the Philippines',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'Province of Davao del Norte',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'City of Tagum',0,0,'C'); 
            $this->Ln();
            $this->Ln();
            $this->SetFont('Arial','B',12);
            $this->Cell(200,5,'CITY AGRICULTURE OFFICE',0,0,'C'); 
            $this->Ln();
            $this->SetFont('Arial','B',12);
            $this->Cell(200,5,$status_r.' Report of Inventory of '.$status.' Products as of '.$cdate,0,0,'C'); 
            $this->Ln();
            $this->Ln();
           }
        function header1($status){
            
        }
        
        function footer(){
            $this->SetY(-20);
            $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
        }
        function headerTable(){
            $this->SetFont('Times','B',10);
            $this->Cell(10,10,'No.',1,0,'C');
            $this->Cell(75,10,'Product Name',1,0,'C');
            $this->Cell(20,10,'Units',1,0,'C');
            $this->Cell(20,10,'Quantity',1,0,'C');
            $this->Cell(20,10,'Disposed',1,0,'C');
            $this->Cell(20,10,'Total ',1,0,'C');
            $this->Cell(30,10,'Date ',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection){
            $count=0;
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
           $query='SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
           t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
           sum(quantity) as quan,sum(despensed) as despense,status as stat,id as d,created_at as created from 
           inventory_all_products group by product_name,units) as t2 order by t2.created desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(10,10,($count+=1).'.',1,0,'L');
            $this->Cell(75,10,$row['product_name'],1,0,'L');
            $this->Cell(20,10,$row['units'],1,0,'L');
            $this->Cell(20,10,$row['quantity'],1,0,'L');
            $this->Cell(20,10,$row['despensed'],1,0,'L');
            $this->Cell(20,10,$row['quantity']+$row['despensed'],1,0,'L');
            $this->Cell(30,10,$cdate,1,0,'L');
            $this->Ln();
           }
        }
        function viewtotal($connection){
            $query='SELECT sum(t1.quantity) as quantity,sum(t1.despensed) as despensed,
            sum(t1.quantity+t1.despensed) as total,t1.status_updated as updated from 
            (select sum(quantity) as quantity,sum(despensed) as despensed,status_updated as status_updated
             from inventory_all_products) as t1';
            $statement = $connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
             $this->SetFont('Times','B',10);
             $this->Cell(85,10,'TOTAL:',1,0,'L');
             $this->Cell(20,10,'',1,0,'L');
             $this->Cell(20,10,$row['quantity'],1,0,'L');
             $this->Cell(20,10,$row['despensed'],1,0,'L');
             $this->Cell(20,10,$row['total'],1,0,'L');
             $this->Cell(30,10,'',1,0,'L');
             $this->Ln();
            }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($connection);
    $pdf->viewtotal($connection);
    $pdf->Output();
}
else if($status!='All'&&$status_r=='Latest'&&$datefrom==''&&$dateto==''){
    class myPDF extends FPDF{
    function header(){
        $status=$_POST["status"];
        $status_r=$_POST["status_r"];

        $date=date('h:i:s a m/d/Y',time());
        $cdate=date('F j, Y',strtotime($date));
        $time=date('g:i a',strtotime("$date"));

       $this->Ln();
        $this->Image('assets/images/tagum.png',170,6,35);
        $this->Image('assets/images/cagro1.png',10,6,30);
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','',14);
        $this->Cell(200,5,'Republic of the Philippines',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'Province of Davao del Norte',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'City of Tagum',0,0,'C'); 
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,'CITY AGRICULTURE OFFICE',0,0,'C'); 
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,$status_r.' Inventory Report of '.$status.' as of '.$cdate,0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    function header1($status){
        
    }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(75,10,'Product Name',1,0,'C');
        $this->Cell(20,10,'Units',1,0,'C');
        $this->Cell(20,10,'Quantity',1,0,'C');
        $this->Cell(20,10,'Disposed',1,0,'C');
        $this->Cell(20,10,'Total ',1,0,'C');
        $this->Cell(30,10,'Date ',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$status){
        $count=0;
       $query='SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
       t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
       quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
       inventory_all_products where status_updated="Latest" and type_product="'.$status.'") as t2 order by t2.created desc';
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(75,10,$row['product_name'],1,0,'L');
        $this->Cell(20,10,$row['units'],1,0,'L');
        $this->Cell(20,10,$row['quantity'],1,0,'L');
        $this->Cell(20,10,$row['despensed'],1,0,'L');
        $this->Cell(20,10,$row['quantity']+$row['despensed'],1,0,'L');
        $this->Cell(30,10,$row['dates'],1,0,'L');
        $this->Ln();
       }
    }
    function viewtotal($connection,$status){
        $query='SELECT sum(quantity) as quantity,sum(despensed) as despensed,
        sum(quantity+despensed) as total from inventory_all_products where status_updated="Latest" and type_product="'.$status.'"';
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
         $this->SetFont('Times','B',10);
         $this->Cell(85,10,'TOTAL:',1,0,'L');
         $this->Cell(20,10,'',1,0,'L');
         $this->Cell(20,10,$row['quantity'],1,0,'L');
         $this->Cell(20,10,$row['despensed'],1,0,'L');
         $this->Cell(20,10,$row['total'],1,0,'L');
         $this->Cell(30,10,'',1,0,'L');
         $this->Ln();
        }
    }
}

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Legal',0);
$pdf->header1($status);
$pdf->headerTable();
$pdf->viewTable($connection,$status);
$pdf->viewtotal($connection,$status);
$pdf->Output();
}
else if($status!='All'&&$status_r=='Old'&&$datefrom==''&&$dateto==''){
        
class myPDF extends FPDF{
    function header(){
        $status=$_POST["status"];
        $status_r=$_POST["status_r"];

        $date=date('h:i:s a m/d/Y',time());
        $cdate=date('F j, Y',strtotime($date));
        $time=date('g:i a',strtotime("$date"));

       $this->Ln();
        $this->Image('assets/images/tagum.png',170,6,35);
        $this->Image('assets/images/cagro1.png',10,6,30);
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','',14);
        $this->Cell(200,5,'Republic of the Philippines',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'Province of Davao del Norte',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'City of Tagum',0,0,'C'); 
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,'CITY AGRICULTURE OFFICE',0,0,'C'); 
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,$status_r.' Inventory Report of '.$status.' Products as of '.$cdate,0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    function header1($status){
        
    }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(75,10,'Product Name',1,0,'C');
        $this->Cell(20,10,'Units',1,0,'C');
        $this->Cell(20,10,'Quantity',1,0,'C');
        $this->Cell(20,10,'Disposed',1,0,'C');
        $this->Cell(20,10,'Total ',1,0,'C');
        $this->Cell(30,10,'Date ',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$status){
        $count=0;
       $query='SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
       t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
       quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
       inventory_all_products where status_updated="Old" and type_product="'.$status.'") as t2 order by t2.created desc';
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(75,10,$row['product_name'],1,0,'L');
        $this->Cell(20,10,$row['units'],1,0,'L');
        $this->Cell(20,10,$row['quantity'],1,0,'L');
        $this->Cell(20,10,$row['despensed'],1,0,'L');
        $this->Cell(20,10,$row['quantity']+$row['despensed'],1,0,'L');
        $this->Cell(30,10,$row['dates'],1,0,'L');
        $this->Ln();
       }
    }
    function viewtotal($connection,$status){
        $query='SELECT sum(quantity) as quantity,sum(despensed) as despensed,
        sum(quantity+despensed) as total from inventory_all_products where status_updated="Old"
         and type_product="'.$status.'"';
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
         $this->SetFont('Times','B',10);
         $this->Cell(85,10,'TOTAL:',1,0,'L');
         $this->Cell(20,10,'',1,0,'L');
         $this->Cell(20,10,$row['quantity'],1,0,'L');
         $this->Cell(20,10,$row['despensed'],1,0,'L');
         $this->Cell(20,10,$row['total'],1,0,'L');
         $this->Cell(30,10,'',1,0,'L');
         $this->Ln();
        }
    }
}

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Legal',0);
$pdf->header1($status);
$pdf->headerTable();
$pdf->viewTable($connection,$status);
$pdf->viewtotal($connection,$status);
$pdf->Output();
}

else if($status!='All'&&$status_r=='Summary'&&$datefrom==''&&$dateto==''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST["status"];
            $status_r=$_POST["status_r"];
    
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
    
           $this->Ln();
            $this->Image('assets/images/tagum.png',170,6,35);
            $this->Image('assets/images/cagro1.png',10,6,30);
            $this->Ln();
            $this->Ln();
            $this->SetFont('Arial','',14);
            $this->Cell(200,5,'Republic of the Philippines',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'Province of Davao del Norte',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'City of Tagum',0,0,'C'); 
            $this->Ln();
            $this->Ln();
            $this->SetFont('Arial','B',12);
            $this->Cell(200,5,'CITY AGRICULTURE OFFICE',0,0,'C'); 
            $this->Ln();
            $this->SetFont('Arial','B',12);
            $this->Cell(200,5,$status_r.' Report of Inventory of '.$status.' as of '.$cdate,0,0,'C'); 
            $this->Ln();
            $this->Ln();
           }
        function header1($status){
            
        }
        
        function footer(){
            $this->SetY(-20);
            $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
        }
        function headerTable(){
            $this->SetFont('Times','B',10);
            $this->Cell(10,10,'No.',1,0,'C');
            $this->Cell(75,10,'Product Name',1,0,'C');
            $this->Cell(20,10,'Units',1,0,'C');
            $this->Cell(20,10,'Quantity',1,0,'C');
            $this->Cell(20,10,'Disposed',1,0,'C');
            $this->Cell(20,10,'Total ',1,0,'C');
            $this->Cell(30,10,'Date ',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$status){
            $count=0;
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
           $query='SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
           t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
           sum(quantity) as quan,sum(despensed) as despense,status as stat,id as d,created_at as created from 
           inventory_all_products where type_product="'.$status.'" group by product_name,units) as t2 order by t2.created desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(10,10,($count+=1).'.',1,0,'L');
            $this->Cell(75,10,$row['product_name'],1,0,'L');
            $this->Cell(20,10,$row['units'],1,0,'L');
            $this->Cell(20,10,$row['quantity'],1,0,'L');
            $this->Cell(20,10,$row['despensed'],1,0,'L');
            $this->Cell(20,10,$row['quantity']+$row['despensed'],1,0,'L');
            $this->Cell(30,10,$cdate,1,0,'L');
            $this->Ln();
           }
        }
        function viewtotal($connection,$status){
            $query='SELECT sum(t1.quantity) as quantity,sum(t1.despensed) as despensed,
            sum(t1.quantity+t1.despensed) as total,t1.status_updated as updated from 
            (select sum(quantity) as quantity,sum(despensed) as despensed,status_updated as status_updated,type_product as type_product
             from inventory_all_products where type_product="'.$status.'") as t1';
            $statement = $connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
             $this->SetFont('Times','B',10);
             $this->Cell(85,10,'TOTAL:',1,0,'L');
             $this->Cell(20,10,'',1,0,'L');
             $this->Cell(20,10,$row['quantity'],1,0,'L');
             $this->Cell(20,10,$row['despensed'],1,0,'L');
             $this->Cell(20,10,$row['total'],1,0,'L');
             $this->Cell(30,10,'',1,0,'L');
             $this->Ln();
            }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($connection,$status);
    $pdf->viewtotal($connection,$status);
    $pdf->Output();
}
else if($status=='All'&&$status_r=='Latest'&&$datefrom!=''&&$dateto!=''){
     
class myPDF extends FPDF{
    function header(){
        $status=$_POST["status"];
        $status_r=$_POST["status_r"];
        $datefrom=$_POST["datefrom"];
        $dateto=$_POST["dateto"];
        $date=date('h:i:s a m/d/Y',time());
        $cdate=date('F j, Y',strtotime($date));
        $time=date('g:i a',strtotime("$date"));

       $this->Ln();
        $this->Image('assets/images/tagum.png',170,6,35);
        $this->Image('assets/images/cagro1.png',10,6,30);
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','',14);
        $this->Cell(200,5,'Republic of the Philippines',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'Province of Davao del Norte',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'City of Tagum',0,0,'C'); 
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,'CITY AGRICULTURE OFFICE',0,0,'C'); 
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,$status_r.' Inventory Report of '.$status.' Products ',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,' from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    function header1($status){
        
    }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(75,10,'Product Name',1,0,'C');
        $this->Cell(20,10,'Units',1,0,'C');
        $this->Cell(20,10,'Quantity',1,0,'C');
        $this->Cell(20,10,'Disposed',1,0,'C');
        $this->Cell(20,10,'Total ',1,0,'C');
        $this->Cell(30,10,'Date ',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$datefrom,$dateto){
        $count=0;
       $query='SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
       t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
       quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
       inventory_all_products where status_updated="Latest" and DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'") as t2 order by t2.created desc';
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(75,10,$row['product_name'],1,0,'L');
        $this->Cell(20,10,$row['units'],1,0,'L');
        $this->Cell(20,10,$row['quantity'],1,0,'L');
        $this->Cell(20,10,$row['despensed'],1,0,'L');
        $this->Cell(20,10,$row['quantity']+$row['despensed'],1,0,'L');
        $this->Cell(30,10,$row['dates'],1,0,'L');
        $this->Ln();
       }
    }
    function viewtotal($connection,$datefrom,$dateto){
        $query='SELECT sum(quantity) as quantity,sum(despensed) as despensed,
        sum(quantity+despensed) as total from inventory_all_products where status_updated="Latest" and 
        DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'"';
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
         $this->SetFont('Times','B',10);
         $this->Cell(85,10,'TOTAL:',1,0,'L');
         $this->Cell(20,10,'',1,0,'L');
         $this->Cell(20,10,$row['quantity'],1,0,'L');
         $this->Cell(20,10,$row['despensed'],1,0,'L');
         $this->Cell(20,10,$row['total'],1,0,'L');
         $this->Cell(30,10,'',1,0,'L');
         $this->Ln();
        }
    }
}

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Legal',0);
$pdf->header1($status);
$pdf->headerTable();
$pdf->viewTable($connection,$datefrom,$dateto);
$pdf->viewtotal($connection,$datefrom,$dateto);
$pdf->Output();
}
if($status=='All'&&$status_r=='Old'&&$datefrom!=''&&$dateto!=''){
        
class myPDF extends FPDF{
    function header(){
        $status=$_POST["status"];
        $status_r=$_POST["status_r"];
        $datefrom=$_POST["datefrom"];
        $dateto=$_POST["dateto"];
        $date=date('h:i:s a m/d/Y',time());
        $cdate=date('F j, Y',strtotime($date));
        $time=date('g:i a',strtotime("$date"));

       $this->Ln();
        $this->Image('assets/images/tagum.png',170,6,35);
        $this->Image('assets/images/cagro1.png',10,6,30);
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','',14);
        $this->Cell(200,5,'Republic of the Philippines',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'Province of Davao del Norte',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'City of Tagum',0,0,'C'); 
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,'CITY AGRICULTURE OFFICE',0,0,'C'); 
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,$status_r.' Inventory Report of '.$status.' Products ',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,' from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    function header1($status){
        
    }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(75,10,'Product Name',1,0,'C');
        $this->Cell(20,10,'Units',1,0,'C');
        $this->Cell(20,10,'Quantity',1,0,'C');
        $this->Cell(20,10,'Disposed',1,0,'C');
        $this->Cell(20,10,'Total ',1,0,'C');
        $this->Cell(30,10,'Date ',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$datefrom,$dateto){
        $count=0;
       $query='SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
       t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
       quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
       inventory_all_products where status_updated="Old" and DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'") as t2 order by t2.created desc';
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(75,10,$row['product_name'],1,0,'L');
        $this->Cell(20,10,$row['units'],1,0,'L');
        $this->Cell(20,10,$row['quantity'],1,0,'L');
        $this->Cell(20,10,$row['despensed'],1,0,'L');
        $this->Cell(20,10,$row['quantity']+$row['despensed'],1,0,'L');
        $this->Cell(30,10,$row['dates'],1,0,'L');
        $this->Ln();
       }
    }
    function viewtotal($connection,$datefrom,$dateto){
        $query='SELECT sum(quantity) as quantity,sum(despensed) as despensed,
        sum(quantity+despensed) as total from inventory_all_products where status_updated="Old" and 
        DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'"';
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
         $this->SetFont('Times','B',10);
         $this->Cell(85,10,'TOTAL:',1,0,'L');
         $this->Cell(20,10,'',1,0,'L');
         $this->Cell(20,10,$row['quantity'],1,0,'L');
         $this->Cell(20,10,$row['despensed'],1,0,'L');
         $this->Cell(20,10,$row['total'],1,0,'L');
         $this->Cell(30,10,'',1,0,'L');
         $this->Ln();
        }
    }
}

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Legal',0);
$pdf->header1($status);
$pdf->headerTable();
$pdf->viewTable($connection,$datefrom,$dateto);
$pdf->viewtotal($connection,$datefrom,$dateto);
$pdf->Output();
}
if($status=='All'&&$status_r=='Summary'&&$datefrom!=''&&$dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST["status"];
            $status_r=$_POST["status_r"];
            $datefrom=$_POST["datefrom"];
            $dateto=$_POST["dateto"];
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
    
           $this->Ln();
            $this->Image('assets/images/tagum.png',170,6,35);
            $this->Image('assets/images/cagro1.png',10,6,30);
            $this->Ln();
            $this->Ln();
            $this->SetFont('Arial','',14);
            $this->Cell(200,5,'Republic of the Philippines',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'Province of Davao del Norte',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'City of Tagum',0,0,'C'); 
            $this->Ln();
            $this->Ln();
            $this->SetFont('Arial','B',12);
            $this->Cell(200,5,'CITY AGRICULTURE OFFICE',0,0,'C'); 
            $this->Ln();
            $this->SetFont('Arial','B',12);
            $this->Cell(200,5,$status_r.' Report of Inventory of '.$status.' Products ',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,' from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
            $this->Ln();
            $this->Ln();
           }
        function header1($status){
            
        }
        
        function footer(){
            $this->SetY(-20);
            $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
        }
        function headerTable(){
            $this->SetFont('Times','B',10);
            $this->Cell(10,10,'No.',1,0,'C');
            $this->Cell(75,10,'Product Name',1,0,'C');
            $this->Cell(20,10,'Units',1,0,'C');
            $this->Cell(20,10,'Quantity',1,0,'C');
            $this->Cell(20,10,'Disposed',1,0,'C');
            $this->Cell(20,10,'Total ',1,0,'C');
            $this->Cell(30,10,'Date ',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$datefrom,$dateto){
            $count=0;
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
           $query='SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
           t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
           sum(quantity) as quan,sum(despensed) as despense,status as stat,id as d,created_at as created from 
           inventory_all_products where DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'" group by product_name,units) as t2 order by t2.created desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(10,10,($count+=1).'.',1,0,'L');
            $this->Cell(75,10,$row['product_name'],1,0,'L');
            $this->Cell(20,10,$row['units'],1,0,'L');
            $this->Cell(20,10,$row['quantity'],1,0,'L');
            $this->Cell(20,10,$row['despensed'],1,0,'L');
            $this->Cell(20,10,$row['quantity']+$row['despensed'],1,0,'L');
            $this->Cell(30,10,$cdate,1,0,'L');
            $this->Ln();
           }
        }
        function viewtotal($connection,$datefrom,$dateto){
            $query='SELECT sum(t1.quantity) as quantity,sum(t1.despensed) as despensed,
            sum(t1.quantity+t1.despensed) as total,t1.status_updated as updated from 
            (select sum(quantity) as quantity,sum(despensed) as despensed,status_updated as status_updated
             from inventory_all_products where DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'" group by product_name,units) as t1';
            $statement = $connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
             $this->SetFont('Times','B',10);
             $this->Cell(85,10,'TOTAL:',1,0,'L');
             $this->Cell(20,10,'',1,0,'L');
             $this->Cell(20,10,$row['quantity'],1,0,'L');
             $this->Cell(20,10,$row['despensed'],1,0,'L');
             $this->Cell(20,10,$row['total'],1,0,'L');
             $this->Cell(30,10,'',1,0,'L');
             $this->Ln();
            }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto);
    $pdf->viewtotal($connection,$datefrom,$dateto);
    $pdf->Output();
}
else if($status!='All'&&$status_r=='Latest'&&$datefrom!=''&&$dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST["status"];
            $status_r=$_POST["status_r"];
            $datefrom=$_POST["datefrom"];
            $dateto=$_POST["dateto"];
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
    
           $this->Ln();
            $this->Image('assets/images/tagum.png',170,6,35);
            $this->Image('assets/images/cagro1.png',10,6,30);
            $this->Ln();
            $this->Ln();
            $this->SetFont('Arial','',14);
            $this->Cell(200,5,'Republic of the Philippines',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'Province of Davao del Norte',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'City of Tagum',0,0,'C'); 
            $this->Ln();
            $this->Ln();
            $this->SetFont('Arial','B',12);
            $this->Cell(200,5,'CITY AGRICULTURE OFFICE',0,0,'C'); 
            $this->Ln();
            $this->SetFont('Arial','B',12);
            $this->Cell(200,5,$status_r.' Inventory Report of '.$status,0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,' from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
            $this->Ln();
            $this->Ln();
           }
        function header1($status){
            
        }
        
        function footer(){
            $this->SetY(-20);
            $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
        }
        function headerTable(){
            $this->SetFont('Times','B',10);
            $this->Cell(10,10,'No.',1,0,'C');
            $this->Cell(75,10,'Product Name',1,0,'C');
            $this->Cell(20,10,'Units',1,0,'C');
            $this->Cell(20,10,'Quantity',1,0,'C');
            $this->Cell(20,10,'Disposed',1,0,'C');
            $this->Cell(20,10,'Total ',1,0,'C');
            $this->Cell(30,10,'Date ',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$status,$datefrom,$dateto){
            $count=0;
           $query='SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
           t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
           quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
           inventory_all_products where type_product="'.$status.'" and status_updated="Latest" and DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'") as t2 order by t2.created desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(10,10,($count+=1).'.',1,0,'L');
            $this->Cell(75,10,$row['product_name'],1,0,'L');
            $this->Cell(20,10,$row['units'],1,0,'L');
            $this->Cell(20,10,$row['quantity'],1,0,'L');
            $this->Cell(20,10,$row['despensed'],1,0,'L');
            $this->Cell(20,10,$row['quantity']+$row['despensed'],1,0,'L');
            $this->Cell(30,10,$row['dates'],1,0,'L');
            $this->Ln();
           }
        }
        function viewtotal($connection,$status,$datefrom,$dateto){
            $query='SELECT sum(quantity) as quantity,sum(despensed) as despensed,
            sum(quantity+despensed) as total from inventory_all_products where status_updated="Latest" and type_product="'.$status.'" and 
            DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'"';
            $statement = $connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
             $this->SetFont('Times','B',10);
             $this->Cell(85,10,'TOTAL:',1,0,'L');
             $this->Cell(20,10,'',1,0,'L');
             $this->Cell(20,10,$row['quantity'],1,0,'L');
             $this->Cell(20,10,$row['despensed'],1,0,'L');
             $this->Cell(20,10,$row['total'],1,0,'L');
             $this->Cell(30,10,'',1,0,'L');
             $this->Ln();
            }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($connection,$status,$datefrom,$dateto);
    $pdf->viewtotal($connection,$status,$datefrom,$dateto);
    $pdf->Output();
}
else if($status!='All'&&$status_r=='Old'&&$datefrom!=''&&$dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST["status"];
            $status_r=$_POST["status_r"];
            $datefrom=$_POST["datefrom"];
            $dateto=$_POST["dateto"];
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
    
           $this->Ln();
            $this->Image('assets/images/tagum.png',170,6,35);
            $this->Image('assets/images/cagro1.png',10,6,30);
            $this->Ln();
            $this->Ln();
            $this->SetFont('Arial','',14);
            $this->Cell(200,5,'Republic of the Philippines',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'Province of Davao del Norte',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'City of Tagum',0,0,'C'); 
            $this->Ln();
            $this->Ln();
            $this->SetFont('Arial','B',12);
            $this->Cell(200,5,'CITY AGRICULTURE OFFICE',0,0,'C'); 
            $this->Ln();
            $this->SetFont('Arial','B',12);
            $this->Cell(200,5,$status_r.' Inventory Report of '.$status,0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,' from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
            $this->Ln();
            $this->Ln();
           }
        function header1($status){
            
        }
        
        function footer(){
            $this->SetY(-20);
            $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
        }
        function headerTable(){
            $this->SetFont('Times','B',10);
            $this->Cell(10,10,'No.',1,0,'C');
            $this->Cell(75,10,'Product Name',1,0,'C');
            $this->Cell(20,10,'Units',1,0,'C');
            $this->Cell(20,10,'Quantity',1,0,'C');
            $this->Cell(20,10,'Disposed',1,0,'C');
            $this->Cell(20,10,'Total ',1,0,'C');
            $this->Cell(30,10,'Date ',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$status,$datefrom,$dateto){
            $count=0;
           $query='SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
           t2.stat as status,t2.d as id,t2.created as created_at,t2.word_created as dates from (select product_name as prod,units as unit,
           quantity as quan,despensed as despense,status as stat,id as d,created_at as created,word_created as word_created from 
           inventory_all_products where type_product="'.$status.'" and status_updated="Old" and DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'") as t2 order by t2.created desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(10,10,($count+=1).'.',1,0,'L');
            $this->Cell(75,10,$row['product_name'],1,0,'L');
            $this->Cell(20,10,$row['units'],1,0,'L');
            $this->Cell(20,10,$row['quantity'],1,0,'L');
            $this->Cell(20,10,$row['despensed'],1,0,'L');
            $this->Cell(20,10,$row['quantity']+$row['despensed'],1,0,'L');
            $this->Cell(30,10,$row['dates'],1,0,'L');
            $this->Ln();
           }
        }
        function viewtotal($connection,$status,$datefrom,$dateto){
            $query='SELECT sum(quantity) as quantity,sum(despensed) as despensed,
            sum(quantity+despensed) as total from inventory_all_products where status_updated="Old" and type_product="'.$status.'" and 
            DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'"';
            $statement = $connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
             $this->SetFont('Times','B',10);
             $this->Cell(85,10,'TOTAL:',1,0,'L');
             $this->Cell(20,10,'',1,0,'L');
             $this->Cell(20,10,$row['quantity'],1,0,'L');
             $this->Cell(20,10,$row['despensed'],1,0,'L');
             $this->Cell(20,10,$row['total'],1,0,'L');
             $this->Cell(30,10,'',1,0,'L');
             $this->Ln();
            }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($connection,$status,$datefrom,$dateto);
    $pdf->viewtotal($connection,$status,$datefrom,$dateto);
    $pdf->Output();
}
if($status!='All'&&$status_r=='Summary'&&$datefrom!=''&&$dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST["status"];
            $status_r=$_POST["status_r"];
            $datefrom=$_POST["datefrom"];
            $dateto=$_POST["dateto"];
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
    
           $this->Ln();
            $this->Image('assets/images/tagum.png',170,6,35);
            $this->Image('assets/images/cagro1.png',10,6,30);
            $this->Ln();
            $this->Ln();
            $this->SetFont('Arial','',14);
            $this->Cell(200,5,'Republic of the Philippines',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'Province of Davao del Norte',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'City of Tagum',0,0,'C'); 
            $this->Ln();
            $this->Ln();
            $this->SetFont('Arial','B',12);
            $this->Cell(200,5,'CITY AGRICULTURE OFFICE',0,0,'C'); 
            $this->Ln();
            $this->SetFont('Arial','B',12);
            $this->Cell(200,5,$status_r.' Report of Inventory of '.$status.' ',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,' from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
            $this->Ln();
            $this->Ln();
           }
        function header1($status){
            
        }
        
        function footer(){
            $this->SetY(-20);
            $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
        }
        function headerTable(){
            $this->SetFont('Times','B',10);
            $this->Cell(10,10,'No.',1,0,'C');
            $this->Cell(75,10,'Product Name',1,0,'C');
            $this->Cell(20,10,'Units',1,0,'C');
            $this->Cell(20,10,'Quantity',1,0,'C');
            $this->Cell(20,10,'Disposed',1,0,'C');
            $this->Cell(20,10,'Total ',1,0,'C');
            $this->Cell(30,10,'Date ',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$datefrom,$dateto,$status){
            $count=0;
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
           $query='SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
           t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
           sum(quantity) as quan,sum(despensed) as despense,status as stat,id as d,created_at as created from 
           inventory_all_products where type_product="'.$status.'" and DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'" group by product_name,units) as t2 order by t2.created desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(10,10,($count+=1).'.',1,0,'L');
            $this->Cell(75,10,$row['product_name'],1,0,'L');
            $this->Cell(20,10,$row['units'],1,0,'L');
            $this->Cell(20,10,$row['quantity'],1,0,'L');
            $this->Cell(20,10,$row['despensed'],1,0,'L');
            $this->Cell(20,10,$row['quantity']+$row['despensed'],1,0,'L');
            $this->Cell(30,10,$cdate,1,0,'L');
            $this->Ln();
           }
        }
        function viewtotal($connection,$datefrom,$dateto,$status){
            $query='SELECT sum(t1.quantity) as quantity,sum(t1.despensed) as despensed,
            sum(t1.quantity+t1.despensed) as total,t1.status_updated as updated from 
            (select sum(quantity) as quantity,sum(despensed) as despensed,status_updated as status_updated
             from inventory_all_products where type_product="'.$status.'" and DATE_FORMAT(created_at,"%Y-%m-%d") BETWEEN "'.$datefrom.'" AND "'.$dateto.'" group by product_name,units) as t1';
            $statement = $connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row)
            {
             $this->SetFont('Times','B',10);
             $this->Cell(85,10,'TOTAL:',1,0,'L');
             $this->Cell(20,10,'',1,0,'L');
             $this->Cell(20,10,$row['quantity'],1,0,'L');
             $this->Cell(20,10,$row['despensed'],1,0,'L');
             $this->Cell(20,10,$row['total'],1,0,'L');
             $this->Cell(30,10,'',1,0,'L');
             $this->Ln();
            }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$status);
    $pdf->viewtotal($connection,$datefrom,$dateto,$status);
    $pdf->Output();
}
/*

else{
    $date=date('m/d/Y',time());
class myPDF extends FPDF{
    function header(){
        $status=$_POST["status"];
        $this->SetFont('Arial','',10);
        $this->Cell(200,5,'F-CAG-01',0,0,'L'); 
        $this->Ln();
        $this->SetFont('Arial','',10);
        $this->Cell(200,5,'Revision',0,0,'L'); 
        $this->Ln();
        $this->SetFont('Arial','',10);
        $this->Cell(200,5,'Effectivity Date: '.date('m/d/Y',time()),0,0,'L'); 
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','',14);
        $this->Cell(200,5,'Republic of the Philippines',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'Province of Davao del Norte',0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'City of Tagum',0,0,'C'); 
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,'CITY AGRICULTURE OFFICE',0,0,'C'); 
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,'Transactional Report of '.$status.' Request',0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    function header1($status){
        
    }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(30,10,'Product Name',1,0,'C');
        $this->Cell(30,10,'Units',1,0,'C');
        $this->Cell(65,10,'Quantity',1,0,'C');
        $this->Cell(30,10,'Despensed',1,0,'C');
        $this->Cell(40,10,'Total Quantity',1,0,'C');
        $this->Ln();
    }
    function viewTable($status,$connection){
       $query='SELECT t2.prod as product_name,t2.unit as units,t2.quan as quantity,t2.despense as despensed,
       t2.stat as status,t2.d as id,t2.created as created_at from (select product_name as prod,units as unit,
       quantity as quan,despensed as despense,status as stat,id as d,created_at as created from 
       inventory_all_products where type_product="'.$status.'") as t2';
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(30,10,$row['product_name'],1,0,'L');
        $this->Cell(30,10,$row['units'],1,0,'L');
        $this->Cell(65,10,$row['quantity'],1,0,'L');
        $this->Cell(30,10,$row['despensed'],1,0,'L');
        $this->Cell(40,10,$row['quantity']+$row['despensed'],1,0,'L');
        $this->Ln();
       }
    }
    function viewtotal($status,$connection){
        $query='SELECT sum(quantity) as quantity,sum(despensed) as despensed,
        sum(quantity+despensed) as total from inventory_all_products where type_product="'.$status.'"';
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
         $this->SetFont('Times','B',10);
         $this->Cell(30,10,'TOTAL:',1,0,'L');
         $this->Cell(30,10,'',1,0,'L');
         $this->Cell(65,10,$row['quantity'],1,0,'L');
         $this->Cell(30,10,$row['despensed'],1,0,'L');
         $this->Cell(40,10,$row['total'],1,0,'L');
         $this->Ln();
        }
    }
}

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Legal',0);
$pdf->header1($status);
$pdf->headerTable();
$pdf->viewTable($status,$connection);
$pdf->viewtotal($status,$connection);
$pdf->Output();
}
*/

?>
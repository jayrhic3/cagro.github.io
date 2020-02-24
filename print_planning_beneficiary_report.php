<?php 

require "fpdf/fpdf.php";
include('connection.php');

$id=$_POST['user_id'];
$dateto=$_POST["dateto"];
$datefrom=$_POST["datefrom"];
$status=$_POST['status'];
$type=$_POST['type'];
$prod=$_POST['prod'];

if($status=='All' && $type=='All' && $prod=='All' && $datefrom=='' && $dateto==''){
class myPDF extends FPDF{
    function header(){
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
        $this->Cell(200,5,'Beneficiary Report as of '.$cdate,0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(25,10,'Last Name',1,0,'C');
        $this->Cell(25,10,'First Name',1,0,'C');
        $this->Cell(40,10,'Type of Product',1,0,'C');
        $this->Cell(50,10,'Product Name',1,0,'C');
        $this->Cell(15,10,'Quantity',1,0,'C');
        $this->Cell(30,10,'Date Received',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection){
        $count=0;
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,
       t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
       t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
       inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id order by t3.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',8);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(25,10,$row['lastname'],1,0,'L');
        $this->Cell(25,10,$row['firstname'],1,0,'L');
        $this->Cell(40,10,$row['type'],1,0,'L');
        $this->Cell(50,10,$row['product'],1,0,'L');
        $this->Cell(15,10,$row['quantity'],1,0,'L');
        $this->Cell(30,10,$row['cre'],1,0,'L');
        $this->Ln();
       }
    }
}

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Legal',0);
$pdf->headerTable();
$pdf->viewTable($connection);
$pdf->Output();
}
else if($status!='All' && $type=='All' && $prod=='All' && $datefrom=='' && $dateto==''){
    class myPDF extends FPDF{
    function header(){
        $id=$_POST['user_id'];
        $dateto=$_POST["dateto"];
        $datefrom=$_POST["datefrom"];
        $status=$_POST['status'];
        $type=$_POST['type'];
        $prod=$_POST['prod'];
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
    $this->Cell(200,5,'Beneficiary Report of '.$status.' as of '.$cdate,0,0,'C'); 
    $this->Ln();
    $this->Ln();
   }

function footer(){
    $this->SetY(-20);
    $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
}
function headerTable(){
    $this->SetFont('Times','B',10);
    $this->Cell(10,10,'No.',1,0,'C');
    $this->Cell(25,10,'Last Name',1,0,'C');
    $this->Cell(25,10,'First Name',1,0,'C');
    $this->Cell(40,10,'Type of Product',1,0,'C');
    $this->Cell(50,10,'Product Name',1,0,'C');
    $this->Cell(15,10,'Quantity',1,0,'C');
    $this->Cell(30,10,'Date Received',1,0,'C');
    $this->Ln();
}
function viewTable($connection,$id){
    $count=0;
   $query="SELECT t1.lastname as lastname,t1.firstname as firstname,
   t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
   t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
   inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id and
    t3.beneficiary_id='$id' order by t3.created_at desc";
   $statement = $connection->prepare($query);
   $statement->execute();
   $result = $statement->fetchAll();
   foreach($result as $row)
   {
    $this->SetFont('Times','',8);
    $this->Cell(10,10,($count+=1).'.',1,0,'L');
    $this->Cell(25,10,$row['lastname'],1,0,'L');
    $this->Cell(25,10,$row['firstname'],1,0,'L');
    $this->Cell(40,10,$row['type'],1,0,'L');
    $this->Cell(50,10,$row['product'],1,0,'L');
    $this->Cell(15,10,$row['quantity'],1,0,'L');
    $this->Cell(30,10,$row['cre'],1,0,'L');
    $this->Ln();
   }
}
}

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Legal',0);
$pdf->headerTable();
$pdf->viewTable($connection,$id);
$pdf->Output();
}
else if($status!='All' && $type!='All' && $prod=='All' && $datefrom=='' && $dateto==''){
    class myPDF extends FPDF{
        function header(){
            $id=$_POST['user_id'];
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
            $status=$_POST['status'];
            $type=$_POST['type'];
            $prod=$_POST['prod'];
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
        $this->Cell(200,5,'Beneficiary Report of '.$type.' acquired by '.$status,0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'as of '.$cdate,0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(25,10,'Last Name',1,0,'C');
        $this->Cell(25,10,'First Name',1,0,'C');
        $this->Cell(40,10,'Type of Product',1,0,'C');
        $this->Cell(50,10,'Product Name',1,0,'C');
        $this->Cell(15,10,'Quantity',1,0,'C');
        $this->Cell(30,10,'Date Received',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$id,$type){
        $count=0;
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,
       t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
       t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
       inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id 
       and t3.beneficiary_id='$id' and t2.type_product='$type' order by t3.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',8);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(25,10,$row['lastname'],1,0,'L');
        $this->Cell(25,10,$row['firstname'],1,0,'L');
        $this->Cell(40,10,$row['type'],1,0,'L');
        $this->Cell(50,10,$row['product'],1,0,'L');
        $this->Cell(15,10,$row['quantity'],1,0,'L');
        $this->Cell(30,10,$row['cre'],1,0,'L');
        $this->Ln();
       }
    }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$id,$type);
    $pdf->Output();
}
else if($status=='All' && $type!='All' && $prod=='All' && $datefrom=='' && $dateto==''){
    class myPDF extends FPDF{
        function header(){
            $id=$_POST['user_id'];
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
            $status=$_POST['status'];
            $type=$_POST['type'];
            $prod=$_POST['prod'];
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
        $this->Cell(200,5,'Beneficiary Report of '.$type,0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'as of '.$cdate,0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(25,10,'Last Name',1,0,'C');
        $this->Cell(25,10,'First Name',1,0,'C');
        $this->Cell(40,10,'Type of Product',1,0,'C');
        $this->Cell(50,10,'Product Name',1,0,'C');
        $this->Cell(15,10,'Quantity',1,0,'C');
        $this->Cell(30,10,'Date Received',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$type){
        $count=0;
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,
       t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
       t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
       inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
       and t2.type_product='$type' order by t3.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',8);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(25,10,$row['lastname'],1,0,'L');
        $this->Cell(25,10,$row['firstname'],1,0,'L');
        $this->Cell(40,10,$row['type'],1,0,'L');
        $this->Cell(50,10,$row['product'],1,0,'L');
        $this->Cell(15,10,$row['quantity'],1,0,'L');
        $this->Cell(30,10,$row['cre'],1,0,'L');
        $this->Ln();
       }
    }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$type);
    $pdf->Output();
}
else if($status=='All' && $type!='All' && $prod!='All' && $datefrom=='' && $dateto==''){
    class myPDF extends FPDF{
        function header(){
            $id=$_POST['user_id'];
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
            $status=$_POST['status'];
            $type=$_POST['type'];
            $prod=$_POST['prod'];
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
        $this->Cell(200,5,'Beneficiary Report of '.$prod,0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'as of '.$cdate,0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(25,10,'Last Name',1,0,'C');
        $this->Cell(25,10,'First Name',1,0,'C');
        $this->Cell(40,10,'Type of Product',1,0,'C');
        $this->Cell(50,10,'Product Name',1,0,'C');
        $this->Cell(15,10,'Quantity',1,0,'C');
        $this->Cell(30,10,'Date Received',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$prod){
        $count=0;
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,
       t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
       t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
       inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
       and t2.product_name='$prod' order by t3.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',8);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(25,10,$row['lastname'],1,0,'L');
        $this->Cell(25,10,$row['firstname'],1,0,'L');
        $this->Cell(40,10,$row['type'],1,0,'L');
        $this->Cell(50,10,$row['product'],1,0,'L');
        $this->Cell(15,10,$row['quantity'],1,0,'L');
        $this->Cell(30,10,$row['cre'],1,0,'L');
        $this->Ln();
       }
    }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$prod);
    $pdf->Output();
}
else if($status!='All' && $type!='All' && $prod!='All' && $datefrom=='' && $dateto==''){
    class myPDF extends FPDF{
        function header(){
            $id=$_POST['user_id'];
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
            $status=$_POST['status'];
            $type=$_POST['type'];
            $prod=$_POST['prod'];
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
        $this->Cell(200,5,'Beneficiary Report of '.$prod.' acquired by '.$status,0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'as of '.$cdate,0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(25,10,'Last Name',1,0,'C');
        $this->Cell(25,10,'First Name',1,0,'C');
        $this->Cell(40,10,'Type of Product',1,0,'C');
        $this->Cell(50,10,'Product Name',1,0,'C');
        $this->Cell(15,10,'Quantity',1,0,'C');
        $this->Cell(30,10,'Date Received',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$prod,$id){
        $count=0;
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,
       t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
       t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
       inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
       and t2.product_name='$prod' and t3.beneficiary_id='$id' order by t3.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',8);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(25,10,$row['lastname'],1,0,'L');
        $this->Cell(25,10,$row['firstname'],1,0,'L');
        $this->Cell(40,10,$row['type'],1,0,'L');
        $this->Cell(50,10,$row['product'],1,0,'L');
        $this->Cell(15,10,$row['quantity'],1,0,'L');
        $this->Cell(30,10,$row['cre'],1,0,'L');
        $this->Ln();
       }
    }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$prod,$id);
    $pdf->Output();
}
else if($status=='All' && $type=='All' && $prod=='All' && $datefrom!='' && $dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $id=$_POST['user_id'];
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
            $status=$_POST['status'];
            $type=$_POST['type'];
            $prod=$_POST['prod'];
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
        $this->Cell(200,5,'Beneficiary Report of from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(25,10,'Last Name',1,0,'C');
        $this->Cell(25,10,'First Name',1,0,'C');
        $this->Cell(40,10,'Type of Product',1,0,'C');
        $this->Cell(50,10,'Product Name',1,0,'C');
        $this->Cell(15,10,'Quantity',1,0,'C');
        $this->Cell(30,10,'Date Received',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$datefrom,$dateto){
        $count=0;
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,
       t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
       t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
       inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id and 
       date_format(t3.created_at,'%Y-%m-%d') between '$datefrom' and '$dateto' order by t3.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',8);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(25,10,$row['lastname'],1,0,'L');
        $this->Cell(25,10,$row['firstname'],1,0,'L');
        $this->Cell(40,10,$row['type'],1,0,'L');
        $this->Cell(50,10,$row['product'],1,0,'L');
        $this->Cell(15,10,$row['quantity'],1,0,'L');
        $this->Cell(30,10,$row['cre'],1,0,'L');
        $this->Ln();
       }
    }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto);
    $pdf->Output();
}
else if($status!='All' && $type=='All' && $prod=='All' && $datefrom!='' && $dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $id=$_POST['user_id'];
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
            $status=$_POST['status'];
            $type=$_POST['type'];
            $prod=$_POST['prod'];
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
        $this->Cell(200,5,'Beneficiary Report of '.$status,0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(25,10,'Last Name',1,0,'C');
        $this->Cell(25,10,'First Name',1,0,'C');
        $this->Cell(40,10,'Type of Product',1,0,'C');
        $this->Cell(50,10,'Product Name',1,0,'C');
        $this->Cell(15,10,'Quantity',1,0,'C');
        $this->Cell(30,10,'Date Received',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$datefrom,$dateto,$id){
        $count=0;
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,
       t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
       t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
       inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id and 
       t3.beneficiary_id='$id' and date_format(t3.created_at,'%Y-%m-%d') 
       between '$datefrom' and '$dateto' order by t3.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',8);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(25,10,$row['lastname'],1,0,'L');
        $this->Cell(25,10,$row['firstname'],1,0,'L');
        $this->Cell(40,10,$row['type'],1,0,'L');
        $this->Cell(50,10,$row['product'],1,0,'L');
        $this->Cell(15,10,$row['quantity'],1,0,'L');
        $this->Cell(30,10,$row['cre'],1,0,'L');
        $this->Ln();
       }
    }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$id);
    $pdf->Output();
}
else if($status!='All' && $type!='All' && $prod=='All' && $datefrom!='' && $dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $id=$_POST['user_id'];
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
            $status=$_POST['status'];
            $type=$_POST['type'];
            $prod=$_POST['prod'];
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
        $this->Cell(200,5,'Beneficiary Report of '.$type.' acquired by '.$status,0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(25,10,'Last Name',1,0,'C');
        $this->Cell(25,10,'First Name',1,0,'C');
        $this->Cell(40,10,'Type of Product',1,0,'C');
        $this->Cell(50,10,'Product Name',1,0,'C');
        $this->Cell(15,10,'Quantity',1,0,'C');
        $this->Cell(30,10,'Date Received',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$datefrom,$dateto,$id,$type){
        $count=0;
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,
       t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
       t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
       inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id 
       and t3.beneficiary_id='$id' and t2.type_product='$type' and
       date_format(t3.created_at,'%Y-%m-%d') between '$datefrom' and '$dateto' order by t3.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',8);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(25,10,$row['lastname'],1,0,'L');
        $this->Cell(25,10,$row['firstname'],1,0,'L');
        $this->Cell(40,10,$row['type'],1,0,'L');
        $this->Cell(50,10,$row['product'],1,0,'L');
        $this->Cell(15,10,$row['quantity'],1,0,'L');
        $this->Cell(30,10,$row['cre'],1,0,'L');
        $this->Ln();
       }
    }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$id,$type);
    $pdf->Output();
}
else if($status=='All' && $type!='All' && $prod=='All' && $datefrom!='' && $dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $id=$_POST['user_id'];
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
            $status=$_POST['status'];
            $type=$_POST['type'];
            $prod=$_POST['prod'];
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
        $this->Cell(200,5,'Beneficiary Report of '.$type,0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(25,10,'Last Name',1,0,'C');
        $this->Cell(25,10,'First Name',1,0,'C');
        $this->Cell(40,10,'Type of Product',1,0,'C');
        $this->Cell(50,10,'Product Name',1,0,'C');
        $this->Cell(15,10,'Quantity',1,0,'C');
        $this->Cell(30,10,'Date Received',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$datefrom,$dateto,$id,$type){
        $count=0;
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,
       t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
       t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
       inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
       and t2.type_product='$type' and date_format(t3.created_at,'%Y-%m-%d') between '$datefrom' and '$dateto' order by t3.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',8);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(25,10,$row['lastname'],1,0,'L');
        $this->Cell(25,10,$row['firstname'],1,0,'L');
        $this->Cell(40,10,$row['type'],1,0,'L');
        $this->Cell(50,10,$row['product'],1,0,'L');
        $this->Cell(15,10,$row['quantity'],1,0,'L');
        $this->Cell(30,10,$row['cre'],1,0,'L');
        $this->Ln();
       }
    }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$id,$type);
    $pdf->Output();
}
else if($status=='All' && $type!='All' && $prod!='All' && $datefrom!='' && $dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $id=$_POST['user_id'];
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
            $status=$_POST['status'];
            $type=$_POST['type'];
            $prod=$_POST['prod'];
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
        $this->Cell(200,5,'Beneficiary Report of '.$prod,0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(25,10,'Last Name',1,0,'C');
        $this->Cell(25,10,'First Name',1,0,'C');
        $this->Cell(40,10,'Type of Product',1,0,'C');
        $this->Cell(50,10,'Product Name',1,0,'C');
        $this->Cell(15,10,'Quantity',1,0,'C');
        $this->Cell(30,10,'Date Received',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$datefrom,$dateto,$prod){
        $count=0;
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,
       t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
       t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
       inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
       and t2.product_name='$prod' and date_format(t3.created_at,'%Y-%m-%d') between '$datefrom' and '$dateto' order by t3.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',8);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(25,10,$row['lastname'],1,0,'L');
        $this->Cell(25,10,$row['firstname'],1,0,'L');
        $this->Cell(40,10,$row['type'],1,0,'L');
        $this->Cell(50,10,$row['product'],1,0,'L');
        $this->Cell(15,10,$row['quantity'],1,0,'L');
        $this->Cell(30,10,$row['cre'],1,0,'L');
        $this->Ln();
       }
    }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$prod);
    $pdf->Output();
}
else if($status!='All' && $type!='All' && $prod!='All' && $datefrom!='' && $dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $id=$_POST['user_id'];
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
            $status=$_POST['status'];
            $type=$_POST['type'];
            $prod=$_POST['prod'];
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
        $this->Cell(200,5,'Beneficiary Report of '.$prod.' acquired by '.$status,0,0,'C'); 
        $this->Ln();
        $this->Cell(200,5,'from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(10,10,'No.',1,0,'C');
        $this->Cell(25,10,'Last Name',1,0,'C');
        $this->Cell(25,10,'First Name',1,0,'C');
        $this->Cell(40,10,'Type of Product',1,0,'C');
        $this->Cell(50,10,'Product Name',1,0,'C');
        $this->Cell(15,10,'Quantity',1,0,'C');
        $this->Cell(30,10,'Date Received',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$datefrom,$dateto,$prod,$id){
        $count=0;
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,
       t2.type_product as type,t2.product_name as product,t3.quantity as quantity,
       t3.created_at as created,t3.word_created as cre from beneficiaries as t1 inner join inventory_all_products as t2 
       inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id
       and t2.product_name='$prod' and t3.beneficiary_id='$id' and date_format(t3.created_at,'%Y-%m-%d') between
        '$datefrom' and '$dateto' order by t3.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',8);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(25,10,$row['lastname'],1,0,'L');
        $this->Cell(25,10,$row['firstname'],1,0,'L');
        $this->Cell(40,10,$row['type'],1,0,'L');
        $this->Cell(50,10,$row['product'],1,0,'L');
        $this->Cell(15,10,$row['quantity'],1,0,'L');
        $this->Cell(30,10,$row['cre'],1,0,'L');
        $this->Ln();
       }
    }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$prod,$id);
    $pdf->Output();
}
/*
else if($status=='All'&&$datefrom!=''&&$dateto!=''){
    $date=date('m/d/Y',time());
class myPDF extends FPDF{
    function header(){
        $dateto=$_POST["dateto"];
        $datefrom=$_POST["datefrom"];
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
        $this->Cell(200,5,'Beneficiary Report from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)).'',0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(30,10,'Last Name',1,0,'C');
        $this->Cell(30,10,'First Name',1,0,'C');
        $this->Cell(50,10,'Type of Product',1,0,'C');
        $this->Cell(30,10,'Product Name',1,0,'C');
        $this->Cell(20,10,'Quantity',1,0,'C');
        $this->Cell(35,10,'Date Received',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$datefrom,$dateto){
       $query="SELECT t1.firstname as firstname,t1.lastname as lastname,t1.type_product as type,
       t1.product_name as product,t1.quantity as quantity,t1.created_at as created,t1.word_created as cre 
       from (select t1.firstname as firstname,t1.lastname as lastname,t2.type_product as type_product,
       t2.product_name as product_name,t3.quantity as quantity,t3.created_at as created_at,
       t3.word_created as word_created from beneficiaries as t1 inner join inventory_all_products as t2 
       inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id 
       where date_format(t3.created_at,'%Y-%m-%d') between '$datefrom' and '$dateto') as t1";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(30,10,$row['lastname'],1,0,'L');
        $this->Cell(30,10,$row['firstname'],1,0,'L');
        $this->Cell(50,10,$row['type'],1,0,'L');
        $this->Cell(30,10,$row['product'],1,0,'L');
        $this->Cell(20,10,$row['quantity'],1,0,'L');
        $this->Cell(35,10,$row['cre'],1,0,'L');
        $this->Ln();
       }
    }
}

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Legal',0);
$pdf->headerTable();
$pdf->viewTable($connection,$datefrom,$dateto);
$pdf->Output();
}
else if($datefrom==''&&$dateto==''&&$id!=''){
    $date=date('m/d/Y',time());
    class myPDF extends FPDF{
        function header(){
            
            $status=$_POST['status'];
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
            $this->Cell(200,5,'Beneficiary Report of '.$status,0,0,'C'); 
            $this->Ln();
            $this->Ln();
           }
        
        function footer(){
            $this->SetY(-20);
            $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
        }
        function headerTable(){
            $this->SetFont('Times','B',10);
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(50,10,'Type of Product',1,0,'C');
            $this->Cell(30,10,'Product Name',1,0,'C');
            $this->Cell(20,10,'Quantity',1,0,'C');
            $this->Cell(35,10,'Date Received',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$id){
           $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.type_product as type,
           t1.product_name as product,t1.quantity as quantity,t1.created_at as created,t1.word_created as cre 
           from (select t1.lastname as lastname,t1.firstname as firstname,t2.type_product as type_product,
           t2.product_name as product_name,t3.quantity as quantity,t3.created_at as created_at,
           t3.word_created as word_created from beneficiaries as t1 inner join inventory_all_products as t2 
           inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id 
           where t3.beneficiary_id='$id') as t1";
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(50,10,$row['type'],1,0,'L');
            $this->Cell(30,10,$row['product'],1,0,'L');
            $this->Cell(20,10,$row['quantity'],1,0,'L');
            $this->Cell(35,10,$row['cre'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$id);
    $pdf->Output();
}
else if($datefrom!=''&&$dateto!=''&&$id!=''&&$status!='All'){
    $date=date('m/d/Y',time());
    class myPDF extends FPDF{
        function header(){
            
            $status=$_POST['status'];
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
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
            $this->Cell(200,5,'Beneficiary Report of '.$status.' from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
            $this->Ln();
            $this->Ln();
           }
        
        function footer(){
            $this->SetY(-20);
            $this->Cell(0,10,'Approved by:____________                                                                                    Attested by:_______________ ',5,0,'L');
        }
        function headerTable(){
            $this->SetFont('Times','B',10);
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(50,10,'Type of Product',1,0,'C');
            $this->Cell(30,10,'Product Name',1,0,'C');
            $this->Cell(20,10,'Quantity',1,0,'C');
            $this->Cell(35,10,'Date Received',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$id,$datefrom,$dateto){
           $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.type_product as type,
           t1.product_name as product,t1.quantity as quantity,t1.created_at as created,t1.word_created as cre 
           from (select t1.lastname as lastname,t1.firstname as firstname,t2.type_product as type_product,
           t2.product_name as product_name,t3.quantity as quantity,t3.created_at as created_at,
           t3.word_created as word_created from beneficiaries as t1 inner join inventory_all_products as t2 
           inner join beneficiary_record_product as t3 on t1.id=t3.beneficiary_id and t3.product_id=t2.id 
           where t3.beneficiary_id='$id' and date_format(t3.created_at,'%Y-%m-%d') between '$datefrom' and '$dateto') as t1";
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(50,10,$row['type'],1,0,'L');
            $this->Cell(30,10,$row['product'],1,0,'L');
            $this->Cell(20,10,$row['quantity'],1,0,'L');
            $this->Cell(35,10,$row['cre'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$id,$datefrom,$dateto);
    $pdf->Output();
}
*/
?>
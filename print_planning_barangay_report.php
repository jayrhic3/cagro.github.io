<?php 

require "fpdf/fpdf.php";
include('connection.php');

$muni=$_POST['muni'];
$barangay=$_POST['barangay'];
$datefrom=$_POST['datefrom'];
$dateto=$_POST['dateto'];

if($muni=='All' && $barangay=='All' && $datefrom=='' && $dateto==''){
class myPDF extends FPDF{
    function header(){
        date_default_timezone_set("Asia/Manila");
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
        $this->Cell(200,5,'Barangay Report as of all barangays '.$cdate.'',0,0,'C'); 
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
        $this->Cell(30,10,'Last Name',1,0,'C');
        $this->Cell(30,10,'First Name',1,0,'C');
        $this->Cell(95,10,'Product Name',1,0,'C');
        $this->Cell(30,10,'Date Received',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection){
        $count=0;
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.product_name as product_name,
       t1.word_created as dates,t1.created_at as dateni from (select t1.lastname as lastname,
       t1.firstname as firstname,t2.product_name as product_name,t3.word_created as word_created,
       t3.created_at as created_at from beneficiaries as t1 inner join beneficiary_record_product as t3 
       inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id and t2.id=t3.product_id) as t1";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',9);
        $this->Cell(10,10,($count+=1).'.',1,0,'L');
        $this->Cell(30,10,$row['lastname'],1,0,'L');
        $this->Cell(30,10,$row['firstname'],1,0,'L');
        $this->Cell(95,10,$row['product_name'],1,0,'L');
        $this->Cell(30,10,$row['dates'],1,0,'L');
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
else if($muni!='All' && $barangay=='All' && $datefrom=='' && $dateto==''){
    class myPDF extends FPDF{
        function header(){
            date_default_timezone_set("Asia/Manila");
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));

            $muni=$_POST['muni'];
            $barangay=$_POST['barangay'];
            $datefrom=$_POST['datefrom'];
            $dateto=$_POST['dateto'];
                
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
            $this->Cell(200,5,'Municipal Report of '.$muni.' as of '.$cdate,0,0,'C'); 
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
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(95,10,'Product Name',1,0,'C');
            $this->Cell(30,10,'Date Received',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$muni){
            $count=0;
           $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.product_name as product_name,
           t1.word_created as dates,t1.created_at as dateni from (select t1.lastname as lastname,
           t1.firstname as firstname,t2.product_name as product_name,t3.word_created as word_created,
           t3.created_at as created_at from beneficiaries as t1 inner join beneficiary_record_product as t3 
           inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id and t2.id=t3.product_id and 
           t1.mucipality='$muni') as t1";
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',9);
            $this->Cell(10,10,($count+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(95,10,$row['product_name'],1,0,'L');
            $this->Cell(30,10,$row['dates'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$muni);
    $pdf->Output();
}
else if($muni!='All' && $barangay!='All' && $datefrom=='' && $dateto==''){
    class myPDF extends FPDF{
        function header(){
            date_default_timezone_set("Asia/Manila");
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));

            $muni=$_POST['muni'];
            $barangay=$_POST['barangay'];
            $datefrom=$_POST['datefrom'];
            $dateto=$_POST['dateto'];
                
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
            $this->Cell(200,5,'Barangay Report of '.$barangay.' as of '.$cdate,0,0,'C'); 
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
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(95,10,'Product Name',1,0,'C');
            $this->Cell(30,10,'Date Received',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$barangay){
            $count=0;
           $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.product_name as product_name,
           t1.word_created as dates,t1.created_at as dateni from (select t1.lastname as lastname,
           t1.firstname as firstname,t2.product_name as product_name,t3.word_created as word_created,
           t3.created_at as created_at from beneficiaries as t1 inner join beneficiary_record_product as t3 
           inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id and t2.id=t3.product_id and 
           t1.barangay='$barangay') as t1";
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',9);
            $this->Cell(10,10,($count+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(95,10,$row['product_name'],1,0,'L');
            $this->Cell(30,10,$row['dates'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$barangay);
    $pdf->Output();
}
else if($muni=='All' && $barangay=='All' && $datefrom!='' && $dateto!=''){
    class myPDF extends FPDF{
        function header(){
            date_default_timezone_set("Asia/Manila");
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));

            $muni=$_POST['muni'];
            $barangay=$_POST['barangay'];
            $datefrom=$_POST['datefrom'];
            $dateto=$_POST['dateto'];
                
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
            $this->Cell(200,5,'Barangay Report of all barangays ',0,0,'C'); 
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
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(95,10,'Product Name',1,0,'C');
            $this->Cell(30,10,'Date Received',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$datefrom,$dateto){
            $count=0;
           $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.product_name as product_name,
           t1.word_created as dates,t1.created_at as dateni from (select t1.lastname as lastname,
           t1.firstname as firstname,t2.product_name as product_name,t3.word_created as word_created,
           t3.created_at as created_at from beneficiaries as t1 inner join beneficiary_record_product as t3 
           inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id and t2.id=t3.product_id and 
           date_format(t3.created_at,'%Y-%m-%d') between '$datefrom' and '$dateto') as t1";
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',9);
            $this->Cell(10,10,($count+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(95,10,$row['product_name'],1,0,'L');
            $this->Cell(30,10,$row['dates'],1,0,'L');
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
else if($muni!='All' && $barangay=='All' && $datefrom!='' && $dateto!=''){
    class myPDF extends FPDF{
        function header(){
            date_default_timezone_set("Asia/Manila");
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));

            $muni=$_POST['muni'];
            $barangay=$_POST['barangay'];
            $datefrom=$_POST['datefrom'];
            $dateto=$_POST['dateto'];
                
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
            $this->Cell(200,5,'Municipal Report of all Municipalities of Davao del Norte ',0,0,'C'); 
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
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(95,10,'Product Name',1,0,'C');
            $this->Cell(30,10,'Date Received',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$datefrom,$dateto,$muni){
            $count=0;
           $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.product_name as product_name,
           t1.word_created as dates,t1.created_at as dateni from (select t1.lastname as lastname,
           t1.firstname as firstname,t2.product_name as product_name,t3.word_created as word_created,
           t3.created_at as created_at from beneficiaries as t1 inner join beneficiary_record_product as t3 
           inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id and t2.id=t3.product_id and 
           date_format(t3.created_at,'%Y-%m-%d') between '$datefrom' and '$dateto' and t1.mucipality='$muni') as t1";
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',9);
            $this->Cell(10,10,($count+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(95,10,$row['product_name'],1,0,'L');
            $this->Cell(30,10,$row['dates'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$muni);
    $pdf->Output();
}
else if($muni!='All' && $barangay!='All' && $datefrom!='' && $dateto!=''){
    class myPDF extends FPDF{
        function header(){
            date_default_timezone_set("Asia/Manila");
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));

            $muni=$_POST['muni'];
            $barangay=$_POST['barangay'];
            $datefrom=$_POST['datefrom'];
            $dateto=$_POST['dateto'];
                
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
            $this->Cell(200,5,'Barangay Report of '.$barangay,0,0,'C'); 
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
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(95,10,'Product Name',1,0,'C');
            $this->Cell(30,10,'Date Received',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$datefrom,$dateto,$barangay){
            $count=0;
           $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.product_name as product_name,
           t1.word_created as dates,t1.created_at as dateni from (select t1.lastname as lastname,
           t1.firstname as firstname,t2.product_name as product_name,t3.word_created as word_created,
           t3.created_at as created_at from beneficiaries as t1 inner join beneficiary_record_product as t3 
           inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id and t2.id=t3.product_id and 
           date_format(t3.created_at,'%Y-%m-%d') between '$datefrom' and '$dateto' and t1.barangay='$barangay') as t1";
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',9);
            $this->Cell(10,10,($count+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(95,10,$row['product_name'],1,0,'L');
            $this->Cell(30,10,$row['dates'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$barangay);
    $pdf->Output();
}
/*
else{
    class myPDF extends FPDF{
        function header(){
            $barangay=$_POST['barangay'];
            date_default_timezone_set("Asia/Manila");
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
    
            $this->SetFont('Arial','',10);
            $this->Cell(200,5,'F-CAG-01',0,0,'L'); 
            $this->Ln();
            $this->SetFont('Arial','',10);
            $this->Cell(200,5,'Revision',0,0,'L'); 
            $this->Ln();
            $this->SetFont('Arial','',10);
            $this->Cell(200,5,'Effectivity Date: '.$cdate,0,0,'L'); 
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
            $this->Cell(200,5,'Barangay Report of '.$barangay.' as of '.$cdate,0,0,'C'); 
            $this->Ln();
            $this->Ln();
           }
        
        function footer(){
            $this->SetY(-20);
            $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
        }
        function headerTable(){
            $this->SetFont('Times','B',10);
            $this->Cell(50,10,'Last Name',1,0,'C');
            $this->Cell(50,10,'First Name',1,0,'C');
            $this->Cell(50,10,'Product Name',1,0,'C');
            $this->Cell(50,10,'Date Received',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$barangay){
           $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.product_name as product_name,
           t1.word_created as dates,t1.created_at as dateni from (select t1.lastname as lastname,
           t1.firstname as firstname,t2.product_name as product_name,t3.word_created as word_created,
           t3.created_at as created_at from beneficiaries as t1 inner join beneficiary_record_product as t3
            inner join inventory_all_products as t2 on t1.id=t3.beneficiary_id and t2.id=t3.product_id where 
            t1.barangay='$barangay') as t1";
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(50,10,$row['lastname'],1,0,'L');
            $this->Cell(50,10,$row['firstname'],1,0,'L');
            $this->Cell(50,10,$row['product_name'],1,0,'L');
            $this->Cell(50,10,$row['dates'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$barangay);
    $pdf->Output();
}/*
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
}*/
?>
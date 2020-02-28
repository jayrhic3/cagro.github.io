<?php 

require "fpdf/fpdf.php";
include('connection.php');

$count=0;
$id=$_POST['user_id'];
$dateto=$_POST["dateto"];
$datefrom=$_POST["datefrom"];
$status=$_POST['status'];
$assistance=$_POST['assistance'];
$no=0;

if($status=='All' && $datefrom=='' && $dateto=='' && $assistance=='All'){
    
class myPDF extends FPDF{
    function header(){
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
        $this->Cell(15,10,'No.',1,0,'C');
        $this->Cell(30,10,'Last Name',1,0,'C');
        $this->Cell(30,10,'First Name',1,0,'C');
        $this->Cell(30,10,'Middle Name',1,0,'C');
        $this->Cell(50,10,'Assistant Request',1,0,'C');
        $this->Cell(40,10,'Date Requested',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$no){
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t2.word_created as date_in,t2.status as stat,
       t2.service_id as id,t2.assistanced_received as received from beneficiaries as t1 
       inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id order by t2.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(15,10,($no+=1).'.',1,0,'L');
        $this->Cell(30,10,ucfirst(strtolower($row['lastname'])),1,0,'L');
        $this->Cell(30,10,ucfirst(strtolower($row['firstname'])),1,0,'L');
        $this->Cell(30,10,ucfirst(strtolower($row['middlename'])),1,0,'L');
        $this->Cell(50,10,ucfirst(strtolower($row['received'])),1,0,'L');
        $this->Cell(40,10,ucfirst(strtolower($row['date_in'])),1,0,'L');
        $this->Ln();
       }
    }
}

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Legal',0);
$pdf->headerTable();
$pdf->viewTable($connection,$no);
$pdf->Output();
}else if($status!='All' && $id!='' && $datefrom=='' && $dateto=='' && $assistance=='All'){
    class myPDF extends FPDF{
        function header(){
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
            $status=$_POST["status"];

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
            $this->Cell(15,10,'No.',1,0,'C');
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(30,10,'Middle Name',1,0,'C');
            $this->Cell(50,10,'Assistant Request',1,0,'C');
            $this->Cell(40,10,'Date Requested',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$id,$no){
           $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t2.word_created as date_in,t2.status as stat,
           t2.service_id as id,t2.assistanced_received as received from beneficiaries as t1 
           inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id 
           WHERE t2.beneficiary_id='$id' order by t2.created_at desc";
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($no+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(30,10,$row['middlename'],1,0,'L');
            $this->Cell(50,10,$row['received'],1,0,'L');
            $this->Cell(40,10,$row['date_in'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$id,$no);
    $pdf->Output();
}else if($status!='All' && $id!='' && $datefrom=='' && $dateto=='' && $assistance!='All'){
    class myPDF extends FPDF{
        function header(){
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
            $status=$_POST["status"];
            $assistance=$_POST['assistance'];

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
            $this->Cell(200,5,'Beneficiary Report of '.$assistance.' Assistance acquired by '.$status,0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,' as of '.$cdate,0,0,'C'); 
            $this->Ln();
            $this->Ln();
           }
        
        function footer(){
            $this->SetY(-20);
            $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
        }
        function headerTable(){
            $this->SetFont('Times','B',10);
            $this->Cell(15,10,'No.',1,0,'C');
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(30,10,'Middle Name',1,0,'C');
            $this->Cell(50,10,'Assistant Request',1,0,'C');
            $this->Cell(40,10,'Date Requested',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$id,$assistance,$no){
           $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.word_created as date_in,
           t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
           (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t2.word_created as word_created,
           t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
           from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
            where t2.beneficiary_id='$id' and t2.assistanced_received ='$assistance') as t1 order by t1.created_at desc";
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($no+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(30,10,$row['middlename'],1,0,'L');
            $this->Cell(50,10,$row['received'],1,0,'L');
            $this->Cell(40,10,$row['date_in'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$id,$assistance,$no);
    $pdf->Output();
}
else if($status=='All'&& $datefrom=='' && $dateto=='' && $assistance!='All'){
    class myPDF extends FPDF{
        function header(){
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
            $status=$_POST["status"];
            $assistance=$_POST['assistance'];

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
            $this->Cell(200,5,'Beneficiary Report of all '.$assistance.' as of '.$cdate,0,0,'C'); 
            $this->Ln();
            $this->Ln();
           }
        
        function footer(){
            $this->SetY(-20);
            $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
        }
        function headerTable(){
            $this->SetFont('Times','B',10);
            $this->Cell(15,10,'No.',1,0,'C');
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            
            $this->Cell(30,10,'Middle Name',1,0,'C');
            $this->Cell(50,10,'Assistant Request',1,0,'C');
            $this->Cell(40,10,'Date Requested',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$assistance,$no){
           $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.word_created as date_in,
           t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
           (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t2.word_created as word_created,
           t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
           from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
            where t2.assistanced_received ='$assistance') as t1 order by t1.created_at desc";
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($no+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            
            $this->Cell(30,10,$row['middlename'],1,0,'L');
            $this->Cell(50,10,$row['received'],1,0,'L');
            $this->Cell(40,10,$row['date_in'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$assistance,$no);
    $pdf->Output();
}
else if($status=='All'&& $datefrom!='' && $dateto!='' && $assistance=='All'){
    class myPDF extends FPDF{
        function header(){
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));

            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];


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
            $this->Cell(200,5,'Beneficiary Report from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
            $this->Ln();
            $this->Ln();
           }
        
        function footer(){
            $this->SetY(-20);
            $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
        }
        function headerTable(){
            $this->SetFont('Times','B',10);
            $this->Cell(15,10,'No.',1,0,'C');
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(30,10,'Middle Name',1,0,'C');
            $this->Cell(50,10,'Assistant Request',1,0,'C');
            $this->Cell(40,10,'Date Requested',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$datefrom,$dateto,$no){
           $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.word_created as date_in,
           t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
           (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t2.word_created as word_created,
           t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
           from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
            where DATE_FORMAT(t2.created_at,'%Y-%m-%d') BETWEEN '$datefrom' AND '$dateto') as t1 order by t1.created_at desc";
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($no+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(30,10,$row['middlename'],1,0,'L');
            $this->Cell(50,10,$row['received'],1,0,'L');
            $this->Cell(40,10,$row['date_in'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$no);
    $pdf->Output();
}
else if($status!='All' && $id!='' && $datefrom!='' && $dateto!='' && $assistance=='All'){
    class myPDF extends FPDF{
        function header(){
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
            
            $status=$_POST['status'];
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];

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
            $this->Cell(200,5,'Beneficiary Report of '.$status.' from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
            $this->Ln();
            $this->Ln();
           }
        
        function footer(){
            $this->SetY(-20);
            $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
        }
        function headerTable(){
            $this->SetFont('Times','B',10);
            $this->Cell(15,10,'No.',1,0,'C');
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(30,10,'Middle Name',1,0,'C');
            $this->Cell(50,10,'Assistant Request',1,0,'C');
            $this->Cell(40,10,'Date Requested',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$datefrom,$dateto,$id,$no){
           $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.word_created as date_in,
           t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
           (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t2.word_created as word_created,
           t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
           from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
            where DATE_FORMAT(t2.created_at,'%Y-%m-%d') BETWEEN '$datefrom' AND '$dateto' and t2.beneficiary_id='$id') as t1 order by t1.created_at desc";
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($no+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(30,10,$row['middlename'],1,0,'L');
            $this->Cell(50,10,$row['received'],1,0,'L');
            $this->Cell(40,10,$row['date_in'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$id,$no);
    $pdf->Output();
}
else if($status!='All' && $id!='' && $datefrom!='' && $dateto!='' && $assistance!='All'){
    class myPDF extends FPDF{
        function header(){
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
            
            $status=$_POST['status'];
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
            $assistance=$_POST['assistance'];

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
            $this->Cell(200,5,'Beneficiary Report of '.$assistance.' acquired by '.$status,0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,' from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C');
            $this->Ln();
            $this->Ln();
           }
        
        function footer(){
            $this->SetY(-20);
            $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
        }
        function headerTable(){
            $this->SetFont('Times','B',10);
            $this->Cell(15,10,'No.',1,0,'C');
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(30,10,'Middle Name',1,0,'C');
            $this->Cell(50,10,'Assistant Request',1,0,'C');
            $this->Cell(40,10,'Date Requested',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$datefrom,$dateto,$id,$assistance,$no){
           $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.word_created as date_in,
           t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
           (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t2.word_created as word_created,
           t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
           from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
            where DATE_FORMAT(t2.created_at,'%Y-%m-%d') BETWEEN '$datefrom' AND '$dateto' and t2.beneficiary_id='$id' and t2.assistanced_received='$assistance') as t1 order by t1.created_at desc";
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($no+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(30,10,$row['middlename'],1,0,'L');
            $this->Cell(50,10,$row['received'],1,0,'L');
            $this->Cell(40,10,$row['date_in'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$id,$assistance,$no);
    $pdf->Output();
}
else if($status=='All' && $datefrom!='' && $dateto!='' && $assistance!='All'){
    class myPDF extends FPDF{
        function header(){
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
            
            $status=$_POST['status'];
            $dateto=$_POST["dateto"];
            $datefrom=$_POST["datefrom"];
            $assistance=$_POST['assistance'];

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
            $this->Cell(200,5,'Beneficiary Report of '.$assistance,0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,' from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C');
            $this->Ln();
            $this->Ln();
           }
        
        function footer(){
            $this->SetY(-20);
            $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
        }
        function headerTable(){
            $this->SetFont('Times','B',10);
            $this->Cell(15,10,'No.',1,0,'C');
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(30,10,'Middle Name',1,0,'C');
            $this->Cell(50,10,'Assistant Request',1,0,'C');
            $this->Cell(40,10,'Date Requested',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$datefrom,$dateto,$assistance,$no){
           $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.word_created as date_in,
           t1.status as stat,t1.created_at as created,t1.assistanced_received as received from 
           (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t2.word_created as word_created,
           t2.status as status,t2.created_at as created_at,t2.assistanced_received as assistanced_received 
           from beneficiaries as t1 inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id
            where DATE_FORMAT(t2.created_at,'%Y-%m-%d') BETWEEN '$datefrom' AND '$dateto' and t2.assistanced_received='$assistance') as t1 order by t1.created_at desc";
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($no+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(30,10,$row['middlename'],1,0,'L');
            $this->Cell(50,10,$row['received'],1,0,'L');
            $this->Cell(40,10,$row['date_in'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$assistance,$no);
    $pdf->Output();
}
else if($assistance!='All' && $status=='All' && $datefrom=='' && $dateto!=''){

	echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($assistance!='All' && $status=='All' && $datefrom!='' && $dateto==''){

	echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
	
}
else if($assistance!='All' && $status!='All' && $datefrom!='' && $dateto==''){

    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($assistance!='All' && $status!='All' && $datefrom=='' && $dateto!=''){

    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($assistance=='All' && $status=='All' && $datefrom=='' && $dateto!=''){

	echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($assistance!='All' && $status=='All' && $datefrom=='' && $dateto!=''){

    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($assistance=='All' && $status!='All' && $datefrom=='' && $dateto!=''){

	echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($assistance!='All' && $status!='All' && $datefrom!='' && $dateto==''){

	echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
	
}
else if($assistance=='All' && $status!='All' && $datefrom=='' && $dateto!=''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
	
}
/*
if($status=='All' && $datefrom=='' && $dateto==''){
    $date=date('m/d/Y',time());
class myPDF extends FPDF{
    function header(){
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
        $this->Cell(200,5,'Beneficiary Report',0,0,'C'); 
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
        $this->Cell(65,10,'Assistant Request',1,0,'C');
        $this->Cell(30,10,'Status',1,0,'C');
        $this->Cell(40,10,'Date Requested',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection){
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t2.word_created as date_in,t2.status as stat,
       t2.service_id as id,t2.assistanced_received as received from beneficiaries as t1 
       inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id order by t2.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(30,10,$row['lastname'],1,0,'L');
        $this->Cell(30,10,$row['firstname'],1,0,'L');
        $this->Cell(65,10,$row['received'],1,0,'L');
        $this->Cell(30,10,$row['stat'],1,0,'L');
        $this->Cell(40,10,$row['date_in'],1,0,'L');
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
    function header1($dateto,$datefrom){
       
    }
    
    function footer(){
        $this->SetY(-20);
        $this->Cell(0,10,'Approved by:____________                                                                          Attested by: ',5,0,'L');
    }
    function headerTable(){
        $this->SetFont('Times','B',10);
        $this->Cell(30,10,'Last Name',1,0,'C');
        $this->Cell(30,10,'First Name',1,0,'C');
        $this->Cell(65,10,'Assistant Request',1,0,'C');
        $this->Cell(30,10,'Status',1,0,'C');
        $this->Cell(40,10,'Date Requested',1,0,'C');
        $this->Ln();
    }
    function viewTable($dateto,$datefrom,$connection){
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t2.word_created as date_in,t2.status as stat,
       t2.service_id as id,t2.assistanced_received as received from beneficiaries as t1 
       inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id 
       WHERE DATE_FORMAT(t2.created_at,'%Y-%m-%d') BETWEEN '$datefrom' AND '$dateto' order by t2.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(30,10,$row['lastname'],1,0,'L');
        $this->Cell(30,10,$row['firstname'],1,0,'L');
        $this->Cell(65,10,$row['received'],1,0,'L');
        $this->Cell(30,10,$row['stat'],1,0,'L');
        $this->Cell(40,10,$row['date_in'],1,0,'L');
        $this->Ln();
       }
    }
}

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Legal',0);
$pdf->header1($dateto,$datefrom);
$pdf->headerTable();
$pdf->viewTable($dateto,$datefrom,$connection);
$pdf->Output();
}
else if($datefrom==''&&$dateto==''&&$id!=''){
    $date=date('m/d/Y',time());
class myPDF extends FPDF{
    function header(){
        $dateto=$_POST["dateto"];
        $datefrom=$_POST["datefrom"];
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
        $this->Cell(65,10,'Assistant Request',1,0,'C');
        $this->Cell(30,10,'Status',1,0,'C');
        $this->Cell(40,10,'Date Requested',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$id){
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t2.word_created as date_in,t2.status as stat,
       t2.service_id as id,t2.assistanced_received as received from beneficiaries as t1 
       inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id 
       WHERE t2.beneficiary_id='$id' order by t2.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(30,10,$row['lastname'],1,0,'L');
        $this->Cell(30,10,$row['firstname'],1,0,'L');
        $this->Cell(65,10,$row['received'],1,0,'L');
        $this->Cell(30,10,$row['stat'],1,0,'L');
        $this->Cell(40,10,$row['date_in'],1,0,'L');
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
        $dateto=$_POST["dateto"];
        $datefrom=$_POST["datefrom"];
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
        $this->Cell(200,5,'Beneficiary Report of '.$status.' from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
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
        $this->Cell(65,10,'Assistant Request',1,0,'C');
        $this->Cell(30,10,'Status',1,0,'C');
        $this->Cell(40,10,'Date Requested',1,0,'C');
        $this->Ln();
    }
    function viewTable($connection,$id,$dateto,$datefrom){
       $query="SELECT t1.lastname as lastname,t1.firstname as firstname,t2.word_created as date_in,t2.status as stat,
       t2.service_id as id,t2.assistanced_received as received from beneficiaries as t1 
       inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id 
       WHERE t2.beneficiary_id='$id' and DATE_FORMAT(t2.created_at,'%Y-%m-%d') BETWEEN '$datefrom' AND '$dateto' order by t2.created_at desc";
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(30,10,$row['lastname'],1,0,'L');
        $this->Cell(30,10,$row['firstname'],1,0,'L');
        $this->Cell(65,10,$row['received'],1,0,'L');
        $this->Cell(30,10,$row['stat'],1,0,'L');
        $this->Cell(40,10,$row['date_in'],1,0,'L');
        $this->Ln();
       }
    }
}

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Legal',0);
$pdf->headerTable();
$pdf->viewTable($connection,$id,$dateto,$datefrom);
$pdf->Output();
}
*/
?>
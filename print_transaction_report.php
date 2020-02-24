<?php 

require "fpdf/fpdf.php";
include('connection.php');
$count=0;
$name=$_POST['name'];
$id=$_POST['user_id'];
$status=$_POST['status'];
$datefrom=$_POST['datefrom'];
$dateto=$_POST['dateto'];

if($name=='All' && $status=='All' && $datefrom=='' && $dateto==''){
   
class myPDF extends FPDF{
    function header(){
        $status=$_POST["status"];
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
        $this->Cell(200,5,'Transactional Report of '.$status.' Request as of '.$cdate,0,0,'C'); 
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
        $this->Cell(15,10,'No.',1,0,'C');
        $this->Cell(30,10,'Last Name',1,0,'C');
        $this->Cell(30,10,'First Name',1,0,'C');
        $this->Cell(50,10,'Assistant Request',1,0,'C');
        $this->Cell(30,10,'Status',1,0,'C');
        $this->Cell(40,10,'Date Requested',1,0,'C');
        $this->Ln();
    }
    function viewTable($status,$connection,$count){
       $query='SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
       t2.word_created as dates,t2.service_id as id,t2.created_at as dateni,t2.status as stat,t2.assistance_recieved as ass from 
       beneficiaries as t1 inner join recent_request as t2 on t1.id = t2.beneficiary_id order by t2.created_at desc';
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(15,10,($count+=1).'.',1,0,'L');
        $this->Cell(30,10,$row['lastname'],1,0,'L');
        $this->Cell(30,10,$row['firstname'],1,0,'L');
        $this->Cell(50,10,$row['ass'],1,0,'L');
        $this->Cell(30,10,$row['stat'],1,0,'L');
        $this->Cell(40,10,$row['dates'],1,0,'L');
        $this->Ln();
       }
    }
}

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Legal',0);
$pdf->header1($status);
$pdf->headerTable();
$pdf->viewTable($status,$connection,$count);
$pdf->Output();
}
else if($name!='All' && $status=='All' && $datefrom=='' && $dateto==''){
   
    class myPDF extends FPDF{
        function header(){
            $status=$_POST["status"];
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
            $name=$_POST['name'];

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
            $this->Cell(200,5,'Transactional Report of '.$name.' as of '.$cdate,0,0,'C'); 
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
            $this->Cell(15,10,'No.',1,0,'C');
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(50,10,'Assistant Request',1,0,'C');
            $this->Cell(30,10,'Status',1,0,'C');
            $this->Cell(40,10,'Date Requested',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$id,$count){
           $query='SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
           t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
            from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
            t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
            t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
            recent_request as t2 on t1.id=t2.beneficiary_id where t2.beneficiary_id="'.$id.'") as t1 order by t1.created_at desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($count+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(50,10,$row['ass'],1,0,'L');
            $this->Cell(30,10,$row['stat'],1,0,'L');
            $this->Cell(40,10,$row['dates'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($connection,$id,$count);
    $pdf->Output();
    }
else if($name=='All' && $status!='All' && $datefrom=='' && $dateto==''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST["status"];
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
            $status=$_POST['status'];

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
            $this->Cell(200,5,'Transactional Report of '.$status.' request as of '.$cdate,0,0,'C'); 
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
            $this->Cell(15,10,'No.',1,0,'C');
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(50,10,'Assistant Request',1,0,'C');
            $this->Cell(30,10,'Status',1,0,'C');
            $this->Cell(40,10,'Date Requested',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$status,$count){
           $query='SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
           t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
            from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
            t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
            t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
            recent_request as t2 on t1.id=t2.beneficiary_id where t2.status="'.$status.'") as t1 order by t1.created_at desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($count+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(50,10,$row['ass'],1,0,'L');
            $this->Cell(30,10,$row['stat'],1,0,'L');
            $this->Cell(40,10,$row['dates'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($connection,$status,$count);
    $pdf->Output();
}
else if($name!='All' && $status!='All' && $datefrom=='' && $dateto==''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST["status"];
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
            $status=$_POST['status'];
            $name=$_POST['name'];

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
            $this->Cell(200,5,'Transactional Report of '.$status.' request of '.$name,0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'as of '.$cdate,0,0,'C'); 
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
            $this->Cell(15,10,'No.',1,0,'C');
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(50,10,'Assistant Request',1,0,'C');
            $this->Cell(30,10,'Status',1,0,'C');
            $this->Cell(40,10,'Date Requested',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$status,$id,$count){
           $query='SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
           t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
            from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
            t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
            t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
            recent_request as t2 on t1.id=t2.beneficiary_id where t2.status="'.$status.'" and t2.beneficiary_id="'.$id.'") as t1 order by t1.created_at desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($count+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(50,10,$row['ass'],1,0,'L');
            $this->Cell(30,10,$row['stat'],1,0,'L');
            $this->Cell(40,10,$row['dates'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($connection,$status,$id,$count);
    $pdf->Output();
}
else if($name=='All' && $status=='All' && $datefrom!='' && $dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST["status"];
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
            $status=$_POST['status'];
            $name=$_POST['name'];
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
            $this->Cell(200,5,'Transactional Report from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
       
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
            $this->Cell(15,10,'No.',1,0,'C');
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(50,10,'Assistant Request',1,0,'C');
            $this->Cell(30,10,'Status',1,0,'C');
            $this->Cell(40,10,'Date Requested',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$datefrom,$dateto,$count){
           $query='SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
           t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
            from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
            t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
            t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
            recent_request as t2 on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
             BETWEEN "'.$datefrom.'" AND "'.$dateto.'") as t1 order by t1.created_at desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($count+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(50,10,$row['ass'],1,0,'L');
            $this->Cell(30,10,$row['stat'],1,0,'L');
            $this->Cell(40,10,$row['dates'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$count);
    $pdf->Output();
}
else if($name!='All' && $status=='All' && $datefrom!='' && $dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST["status"];
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
            $status=$_POST['status'];
            $name=$_POST['name'];
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
            $this->Cell(200,5,'Transactional Report of '.$name,0,0,'C'); 
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
            $this->Cell(15,10,'No.',1,0,'C');
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(50,10,'Assistant Request',1,0,'C');
            $this->Cell(30,10,'Status',1,0,'C');
            $this->Cell(40,10,'Date Requested',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$datefrom,$dateto,$count,$id){
           $query='SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
           t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
            from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
            t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
            t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
            recent_request as t2 on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
             BETWEEN "'.$datefrom.'" AND "'.$dateto.'" and t2.beneficiary_id="'.$id.'") as t1 order by t1.created_at desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($count+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(50,10,$row['ass'],1,0,'L');
            $this->Cell(30,10,$row['stat'],1,0,'L');
            $this->Cell(40,10,$row['dates'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$count,$id);
    $pdf->Output();
}
else if($name=='All' && $status!='All' && $datefrom!='' && $dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST["status"];
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
            $status=$_POST['status'];
            $name=$_POST['name'];
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
            $this->Cell(200,5,'Transactional Report of all '.$status.' request',0,0,'C'); 
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
            $this->Cell(15,10,'No.',1,0,'C');
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(50,10,'Assistant Request',1,0,'C');
            $this->Cell(30,10,'Status',1,0,'C');
            $this->Cell(40,10,'Date Requested',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$datefrom,$dateto,$count,$status){
           $query='SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
           t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
            from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
            t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
            t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
            recent_request as t2 on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
             BETWEEN "'.$datefrom.'" AND "'.$dateto.'" and t2.status="'.$status.'") as t1 order by t1.created_at desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($count+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(50,10,$row['ass'],1,0,'L');
            $this->Cell(30,10,$row['stat'],1,0,'L');
            $this->Cell(40,10,$row['dates'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$count,$status);
    $pdf->Output();
}
else if($name!='All' && $status!='All' && $datefrom!='' && $dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST["status"];
            $date=date('h:i:s a m/d/Y',time());
            $cdate=date('F j, Y',strtotime($date));
            $time=date('g:i a',strtotime("$date"));
            $status=$_POST['status'];
            $name=$_POST['name'];
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
            $this->Cell(200,5,'Transactional Report of all '.$status.' request acquired by '.$name,0,0,'C'); 
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
            $this->Cell(15,10,'No.',1,0,'C');
            $this->Cell(30,10,'Last Name',1,0,'C');
            $this->Cell(30,10,'First Name',1,0,'C');
            $this->Cell(50,10,'Assistant Request',1,0,'C');
            $this->Cell(30,10,'Status',1,0,'C');
            $this->Cell(40,10,'Date Requested',1,0,'C');
            $this->Ln();
        }
        function viewTable($connection,$datefrom,$dateto,$count,$status,$id){
           $query='SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,t1.status as stat,
           t1.word_created as dates,t1.service_id as id,t1.created_at as dateni,t1.assistance_recieved as ass
            from (select t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
            t2.word_created as word_created,t2.service_id as service_id,t2.created_at as created_at,t2.status as status,
            t2.assistance_recieved as assistance_recieved from beneficiaries as t1 inner join 
            recent_request as t2 on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
             BETWEEN "'.$datefrom.'" AND "'.$dateto.'" and t2.status="'.$status.'" and t2.beneficiary_id="'.$id.'") as t1 order by t1.created_at desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($count+=1).'.',1,0,'L');
            $this->Cell(30,10,$row['lastname'],1,0,'L');
            $this->Cell(30,10,$row['firstname'],1,0,'L');
            $this->Cell(50,10,$row['ass'],1,0,'L');
            $this->Cell(30,10,$row['stat'],1,0,'L');
            $this->Cell(40,10,$row['dates'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($connection,$datefrom,$dateto,$count,$status,$id);
    $pdf->Output();
}
else if($name=='All' && $status=='All' && $datefrom!='' && $dateto==''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($name=='All' && $status=='All' && $datefrom=='' && $dateto!=''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($name=='All' && $status!='All' && $datefrom=='' && $dateto!=''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}           
else if($name=='All' && $status!='All' && $datefrom!='' && $dateto==''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}       
else if($name!='All' && $status=='All' && $datefrom=='' && $dateto!=''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($name!='All' && $status=='All' && $datefrom!='' && $dateto==''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}      
else if($name!='All' && $status!='All' && $datefrom=='' && $dateto!=''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}     
else if($name!='All' && $status!='All' && $datefrom!='' && $dateto==''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
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
        $this->Cell(30,10,'Last Name',1,0,'C');
        $this->Cell(30,10,'First Name',1,0,'C');
        $this->Cell(65,10,'Assistant Request',1,0,'C');
        $this->Cell(30,10,'Status',1,0,'C');
        $this->Cell(40,10,'Date Requested',1,0,'C');
        $this->Ln();
    }
    function viewTable($status,$connection){
       $query='SELECT t1.lastname as lastname,t1.firstname as firstname,t1.middlename as middlename,
       t2.word_created as dates,t2.service_id as id,t2.created_at as dateni,t2.status as stat,t2.assistance_recieved as ass from 
       beneficiaries as t1 inner join recent_request as t2 on t1.id = t2.beneficiary_id and t2.status="'.$status.'" order by t2.created_at desc';
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(30,10,$row['lastname'],1,0,'L');
        $this->Cell(30,10,$row['firstname'],1,0,'L');
        $this->Cell(65,10,$row['ass'],1,0,'L');
        $this->Cell(30,10,$row['stat'],1,0,'L');
        $this->Cell(40,10,$row['dates'],1,0,'L');
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
$pdf->Output();
}

*/
?>
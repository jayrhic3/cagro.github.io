<?php 

require "fpdf/fpdf.php";
include('connection.php');
$count=0;
$status=$_POST['status'];
$datefrom=$_POST['datefrom'];
$dateto=$_POST['dateto'];
$assistance=$_POST['assistance'];

if($status=='All'&&$assistance=='All'&&$datefrom==''&&$dateto==''){
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
        $this->Cell(200,5,'Feedback Report as of '.$cdate,0,0,'C'); 
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
        $this->Cell(32,10,'Type of Services',1,0,'C');
        $this->Cell(25,10,'Rating',1,0,'C');
        $this->Cell(90,10,'Comment/Recommendaton',1,0,'C');
        $this->Cell(33,10,'Date Rated',1,0,'C');
        $this->Ln();
    }
    function viewTable($status,$connection,$count){
       $query='SELECT t2.beneficiary_id as bene_id,t2.assistance_received as ass,t2.rating as rate,
       t2.comment as comment,t2.word_created as created from comment_recommendation as t2 inner join 
       beneficiaries as t1 on t2.beneficiary_id=t1.id order by t2.created_at desc';
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(15,10,($count+=1).'.',1,0,'L');
        $this->Cell(32,10,$row['ass'],1,0,'L');
        $this->Cell(25,10,$row['rate'],1,0,'L');
        $this->Cell(90,10,$row['comment'],1,0,'L');
        $this->Cell(33,10,$row['created'],1,0,'L');
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
else if($status=='All'&&$assistance!='All'&&$datefrom==''&&$dateto==''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST['status'];
            $datefrom=$_POST['datefrom'];
            $dateto=$_POST['dateto'];
            $assistance=$_POST['assistance'];

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
            $this->Cell(200,5,'Feedback Report of '.$assistance.' as of '.$cdate,0,0,'C'); 
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
            $this->Cell(32,10,'Type of Services',1,0,'C');
            $this->Cell(25,10,'Rating',1,0,'C');
            $this->Cell(90,10,'Comment/Recommendaton',1,0,'C');
            $this->Cell(33,10,'Date Rated',1,0,'C');
            $this->Ln();
        }
        function viewTable($assistance,$connection,$count){
           $query='SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
           t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
           assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
           t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
           on t1.id=t2.beneficiary_id where t2.assistance_received="'.$assistance.'") as t1 order by t1.created_at desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($count+=1).'.',1,0,'L');
            $this->Cell(32,10,$row['ass'],1,0,'L');
            $this->Cell(25,10,$row['rate'],1,0,'L');
            $this->Cell(90,10,$row['comment'],1,0,'L');
            $this->Cell(33,10,$row['created'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($assistance,$connection,$count);
    $pdf->Output();
}
else if($status!='All'&&$assistance=='All'&&$datefrom==''&&$dateto==''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST['status'];
            $datefrom=$_POST['datefrom'];
            $dateto=$_POST['dateto'];
            $assistance=$_POST['assistance'];

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
            $this->Cell(200,5,'Feedback Report of '.$status.' beneficiaries',0,0,'C'); 
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
            $this->Cell(32,10,'Type of Services',1,0,'C');
            $this->Cell(25,10,'Rating',1,0,'C');
            $this->Cell(90,10,'Comment/Recommendaton',1,0,'C');
            $this->Cell(33,10,'Date Rated',1,0,'C');
            $this->Ln();
        }
        function viewTable($status,$connection,$count){
           $query='SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
           t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
           assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
           t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
           on t1.id=t2.beneficiary_id where t2.rating="'.$status.'") as t1 order by t1.created_at desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($count+=1).'.',1,0,'L');
            $this->Cell(32,10,$row['ass'],1,0,'L');
            $this->Cell(25,10,$row['rate'],1,0,'L');
            $this->Cell(90,10,$row['comment'],1,0,'L');
            $this->Cell(33,10,$row['created'],1,0,'L');
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
else if($status!='All'&&$assistance!='All'&&$datefrom==''&&$dateto==''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST['status'];
            $datefrom=$_POST['datefrom'];
            $dateto=$_POST['dateto'];
            $assistance=$_POST['assistance'];

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
            $this->Cell(200,5,'Feedback Report of '.$assistance.' by '.$status.' beneficiaries',0,0,'C'); 
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
            $this->Cell(32,10,'Type of Services',1,0,'C');
            $this->Cell(25,10,'Rating',1,0,'C');
            $this->Cell(90,10,'Comment/Recommendaton',1,0,'C');
            $this->Cell(33,10,'Date Rated',1,0,'C');
            $this->Ln();
        }
        function viewTable($status,$connection,$count,$assistance){
           $query='SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
           t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
           assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
           t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
           on t1.id=t2.beneficiary_id where t2.rating="'.$status.'" and t2.assistance_received="'.$assistance.'") as t1 order by t1.created_at desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($count+=1).'.',1,0,'L');
            $this->Cell(32,10,$row['ass'],1,0,'L');
            $this->Cell(25,10,$row['rate'],1,0,'L');
            $this->Cell(90,10,$row['comment'],1,0,'L');
            $this->Cell(33,10,$row['created'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($status,$connection,$count,$assistance);
    $pdf->Output();
}
else if($status=='All'&&$assistance=='All'&&$datefrom!=''&&$dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST['status'];
            $datefrom=$_POST['datefrom'];
            $dateto=$_POST['dateto'];
            $assistance=$_POST['assistance'];

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
            $this->Cell(200,5,'Feedback Report from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
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
            $this->Cell(32,10,'Type of Services',1,0,'C');
            $this->Cell(25,10,'Rating',1,0,'C');
            $this->Cell(90,10,'Comment/Recommendaton',1,0,'C');
            $this->Cell(33,10,'Date Rated',1,0,'C');
            $this->Ln();
        }
        function viewTable($datefrom,$connection,$count,$dateto){
           $query='SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
           t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
           assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
           t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
           on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
             BETWEEN "'.$datefrom.'" AND "'.$dateto.'") as t1 order by t1.created_at desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($count+=1).'.',1,0,'L');
            $this->Cell(32,10,$row['ass'],1,0,'L');
            $this->Cell(25,10,$row['rate'],1,0,'L');
            $this->Cell(90,10,$row['comment'],1,0,'L');
            $this->Cell(33,10,$row['created'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($datefrom,$connection,$count,$dateto);
    $pdf->Output();
}
else if($status!='All'&&$assistance=='All'&&$datefrom!=''&&$dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST['status'];
            $datefrom=$_POST['datefrom'];
            $dateto=$_POST['dateto'];
            $assistance=$_POST['assistance'];

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
            $this->Cell(200,5,'Feedback Report of '.$status.' beneficiaries',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
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
            $this->Cell(32,10,'Type of Services',1,0,'C');
            $this->Cell(25,10,'Rating',1,0,'C');
            $this->Cell(90,10,'Comment/Recommendaton',1,0,'C');
            $this->Cell(33,10,'Date Rated',1,0,'C');
            $this->Ln();
        }
        function viewTable($datefrom,$connection,$count,$dateto,$status){
           $query='SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
           t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
           assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
           t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
           on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
             BETWEEN "'.$datefrom.'" AND "'.$dateto.'" and t2.rating="'.$status.'") as t1 order by t1.created_at desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($count+=1).'.',1,0,'L');
            $this->Cell(32,10,$row['ass'],1,0,'L');
            $this->Cell(25,10,$row['rate'],1,0,'L');
            $this->Cell(90,10,$row['comment'],1,0,'L');
            $this->Cell(33,10,$row['created'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($datefrom,$connection,$count,$dateto,$status);
    $pdf->Output();
}
else if($status=='All'&&$assistance!='All'&&$datefrom!=''&&$dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST['status'];
            $datefrom=$_POST['datefrom'];
            $dateto=$_POST['dateto'];
            $assistance=$_POST['assistance'];

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
            $this->Cell(200,5,'Feedback Report of '.$assistance.'',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
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
            $this->Cell(32,10,'Type of Services',1,0,'C');
            $this->Cell(25,10,'Rating',1,0,'C');
            $this->Cell(90,10,'Comment/Recommendaton',1,0,'C');
            $this->Cell(33,10,'Date Rated',1,0,'C');
            $this->Ln();
        }
        function viewTable($datefrom,$connection,$count,$dateto,$assistance){
           $query='SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
           t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
           assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
           t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
           on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
             BETWEEN "'.$datefrom.'" AND "'.$dateto.'" and t2.assistance_received="'.$assistance.'") as t1 order by t1.created_at desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($count+=1).'.',1,0,'L');
            $this->Cell(32,10,$row['ass'],1,0,'L');
            $this->Cell(25,10,$row['rate'],1,0,'L');
            $this->Cell(90,10,$row['comment'],1,0,'L');
            $this->Cell(33,10,$row['created'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($datefrom,$connection,$count,$dateto,$assistance);
    $pdf->Output();
}
else if($status!='All'&&$assistance!='All'&&$datefrom!=''&&$dateto!=''){
    class myPDF extends FPDF{
        function header(){
            $status=$_POST['status'];
            $datefrom=$_POST['datefrom'];
            $dateto=$_POST['dateto'];
            $assistance=$_POST['assistance'];

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
            $this->Cell(200,5,'Feedback Report of '.$assistance.' by '.$status.' beneficiaries',0,0,'C'); 
            $this->Ln();
            $this->Cell(200,5,'from '.date('F j, Y',strtotime($datefrom)).' to '.date('F j, Y',strtotime($dateto)),0,0,'C'); 
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
            $this->Cell(32,10,'Type of Services',1,0,'C');
            $this->Cell(25,10,'Rating',1,0,'C');
            $this->Cell(90,10,'Comment/Recommendaton',1,0,'C');
            $this->Cell(33,10,'Date Rated',1,0,'C');
            $this->Ln();
        }
        function viewTable($datefrom,$connection,$count,$dateto,$assistance,$status){
           $query='SELECT t1.assistance_received as ass,t1.rating as rate,t1.comment as comment,
           t1.word_created as created,t1.created_at as dateni from (select t2.assistance_received as 
           assistance_received,t2.rating as rating,t2.comment as comment,t2.word_created as word_created,
           t2.created_at as created_at from comment_recommendation as t2 inner join beneficiaries as t1 
           on t1.id=t2.beneficiary_id where DATE_FORMAT(t2.created_at,"%Y-%m-%d")
             BETWEEN "'.$datefrom.'" AND "'.$dateto.'" and t2.assistance_received="'.$assistance.'" and t2.rating="'.$status.'") as t1 order by t1.created_at desc';
           $statement = $connection->prepare($query);
           $statement->execute();
           $result = $statement->fetchAll();
           foreach($result as $row)
           {
            $this->SetFont('Times','',10);
            $this->Cell(15,10,($count+=1).'.',1,0,'L');
            $this->Cell(32,10,$row['ass'],1,0,'L');
            $this->Cell(25,10,$row['rate'],1,0,'L');
            $this->Cell(90,10,$row['comment'],1,0,'L');
            $this->Cell(33,10,$row['created'],1,0,'L');
            $this->Ln();
           }
        }
    }
    
    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P','Legal',0);
    $pdf->header1($status);
    $pdf->headerTable();
    $pdf->viewTable($datefrom,$connection,$count,$dateto,$assistance,$status);
    $pdf->Output();
}
//error handling
else if($status=='All'&&$assistance=='All'&&$datefrom!=''&&$dateto==''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($status=='All'&&$assistance=='All'&&$datefrom==''&&$dateto!=''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($status!='All'&&$assistance=='All'&&$datefrom!=''&&$dateto==''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($status!='All'&&$assistance=='All'&&$datefrom==''&&$dateto!=''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($status=='All'&&$assistance!='All'&&$datefrom==''&&$dateto!=''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($status=='All'&&$assistance!='All'&&$datefrom!=''&&$dateto==''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($status!='All'&&$assistance!='All'&&$datefrom!=''&&$dateto==''){
    echo '<h4 style="color:red">An empty field found, Please check the field!!!</h4>';
}
else if($status!='All'&&$assistance!='All'&&$datefrom==''&&$dateto!=''){
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
        $this->Cell(200,5,'Feedback Report of '.$status.' Request',0,0,'C'); 
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
        $this->Cell(45,10,'Beneficiary ID',1,0,'C');
        $this->Cell(32,10,'Type of Services',1,0,'C');
        $this->Cell(25,10,'Rating',1,0,'C');
        $this->Cell(65,10,'Comment/Recommendaton',1,0,'C');
        $this->Cell(28,10,'Date Rated',1,0,'C');
        $this->Ln();
    }
    function viewTable($status,$connection){
       $query='SELECT t2.beneficiary_id as bene_id,t2.assistance_received as ass,t2.rating as rate,
       t2.comment as comment,t2.word_created as created from comment_recommendation as t2 inner join 
       beneficiaries as t1 on t2.beneficiary_id=t1.id and t2.rating="'.$status.'" order by t2.created_at desc';
       $statement = $connection->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach($result as $row)
       {
        $this->SetFont('Times','',10);
        $this->Cell(45,10,$row['bene_id'],1,0,'L');
        $this->Cell(32,10,$row['ass'],1,0,'L');
        $this->Cell(25,10,$row['rate'],1,0,'L');
        $this->Cell(65,10,$row['comment'],1,0,'L');
        $this->Cell(28,10,$row['created'],1,0,'L');
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
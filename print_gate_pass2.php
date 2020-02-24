<?php 
session_start();
require "fpdf/fpdf.php";
include('connection.php');

$single_id=$_POST['user_id_print'];
$service_id=$_SESSION["service_id"];

$query="UPDATE record_services_beneficiary set status='Done' where ser_id='$service_id'";
$statement2 = $connection->prepare($query);
$statement2->execute();

$query2="UPDATE request_services set status='Done' where ser_id='$service_id'";
$statement3 = $connection->prepare($query2);
$statement3->execute();

$query3="UPDATE recent_request set status='Done' where service_id='$service_id'";
$statement4 = $connection->prepare($query3);
$statement4->execute();

$query4="UPDATE record_assistance_beneficiary set status='Done' where service_id='$service_id'";
$statement5 = $connection->prepare($query4);
$statement5->execute();


class myPDF extends FPDF{
    function header(){
        $this->Rect(5,5,140,200,'D');
        $date=date('h:i:s a m/d/Y',time());
        $cdate=date('F j, Y',strtotime($date));
       
        $time=date('g:i a',strtotime("$date UTC+08:00"));

        $this->SetFont('Arial','',8);
        $this->Cell(130,5,'F-CAG-01',0,0,'R'); 
        $this->Ln();

        $this->SetFont('Arial','',8);
        $this->Cell(130,5,'Revision 0',0,0,'R'); 
        $this->Ln();

        $this->SetFont('Arial','',8);
        $this->Cell(130,5,'Effectivity Date: '.$cdate,0,0,'R'); 
        $this->Ln();
        $this->SetFont('Arial','',10);
        $this->Cell(130,5,'Republic of the Philippines',0,0,'C'); 
        $this->Ln();
        $this->Cell(130,5,'Province of Davao del Norte',0,0,'C'); 
        $this->Ln();
        $this->SetFont('Arial','B',10);
        $this->Cell(130,5,'City of Tagum',0,0,'C'); 
        $this->Ln();
        $this->SetFont('Arial','B',8);
        $this->Cell(130,5,'Date  : '.$cdate,0,0,'R'); 
        $this->Ln();

        $this->SetFont('Arial','B',10);
        $this->Cell(130,5,'CITY AGRICULTURE OFFICE',0,0,'C'); 
        $this->Ln();
        $this->Cell(130,5,'Gate Pass',0,0,'C'); 
        $this->Ln();
        $this->Ln();

       
       }
   
   
    function viewTable($connection,$single_id){
        
        $this->SetFont('Times','B',8);
        $this->Cell(22,6,'Qty',1,0,'C');
        $this->Cell(17,6,'Unit',1,0,'C');
        $this->Cell(70,6,'Item Description',1,0,'C');
        $this->Cell(20,6,'Remarks',1,0,'C');
        $this->Ln();

        $statement = $connection->prepare(
            "SELECT t2.quantity as qty,t1.units as unit,t1.product_name as item_description from 
            inventory_all_products as t1 inner join beneficiary_record_product as t2 on
             t2.product_id =t1.id and t2.request_id='$single_id'"
        );
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
            $this->SetFont('Times','B',8);
            $this->Cell(22,6,$row["qty"],1,0,'C');
            $this->Cell(17,6,$row["unit"],1,0,'C');
            $this->Cell(70,6,$row["item_description"],1,0,'L');
            $this->Cell(20,6,'ok',1,0,'C');
            $this->Ln();
        }

        $this->SetFont('Times','B',8);
        $this->Cell(22,6,'',1,0,'C');
        $this->Cell(17,6,'',1,0,'C');
        $this->Cell(70,6,'',1,0,'C');
        $this->Cell(20,6,'',1,0,'C');
        $this->Ln();
        $this->Ln();
       
        $this->SetFont('Arial','B',8);
        $this->Cell(30,5,'Approved by : ',0,0,'R'); 
        $this->Ln();
        $this->SetFont('Arial','U',10);
        $this->Cell(145,5,'ENGR. HAROLD S. DAWA ',0,0,'C'); 
        $this->Ln();
        $this->SetFont('Arial','B',8);
        $this->Cell(145,5,'City Agriculturist ',0,0,'C'); 
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','',8);
        $this->Cell(130,5,'F-CAG-01',0,0,'R'); 
        $this->Ln();
        }
    }



$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P',array(148,210));
$pdf->viewTable($connection,$single_id);
$pdf->Output();

?>
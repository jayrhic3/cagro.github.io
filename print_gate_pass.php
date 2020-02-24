<?php 
session_start();
require "fpdf/fpdf.php";
include('connection.php');

$single_id=$_SESSION['user_idni'];
$service_id=$_SESSION["service_id"];

$arr1=array();
$arr2=array();
$arr3=array();

$id=$_SESSION["idni"];
$quantity=$_SESSION["qtyni"];
$uni=$_SESSION["uni"];
$arr1=explode(",",trim($id[0]));
$arr2=explode(",",trim($quantity[0]));
$arr3=explode(",",trim($uni[0]));

    $query6="SELECT * from inventory_all_products where status_updated='Latest'";
    $statement6 = $connection->prepare($query6);
    $statement6->execute();
    $result6 = $statement6->fetchAll();
	foreach($result6 as $row2)
	{
		foreach($arr1 as $index=>$value){
            if($row2['id']==$value){
                $dif=($row2['quantity']-$arr2[$index]);
                $des=($row2['despensed']+$arr2[$index]);
                $query7="UPDATE inventory_all_products SET quantity='$dif',despensed='$des' WHERE id='$value'";
                $statement7 = $connection->prepare($query7);
                $statement7->execute();
            }
        }
    }

    foreach($arr3 as $value){
        $query8="UPDATE beneficiary_record_product set status='Done' where unique_id='$value'";
        $statement8 = $connection->prepare($query8);
        $statement8->execute();
    }

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
        $this->Rect(5,5,140,140,'D');
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
$pdf->AddPage('P',array(150,150));
$pdf->viewTable($connection,$single_id);
$pdf->Output();

?>
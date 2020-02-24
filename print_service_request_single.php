<?php 
session_start();
require "fpdf/fpdf.php";
include('connection.php');

$id=$_POST["user_id"];

class myPDF extends FPDF{
    function header(){
        $this->Rect(5,5,110,180,'D');
        $date=date('h:i:s a m/d/Y',time());
        $cdate=date('F j, Y',strtotime($date));

        $this->SetFont('Arial','',8);
        $this->Cell(100,5,'F-CAG-01',0,0,'R'); 
        $this->Ln();

        $this->SetFont('Arial','',8);
        $this->Cell(100,5,'Revision 0',0,0,'R'); 
        $this->Ln();

        $this->SetFont('Arial','',8);
        $this->Cell(100,5,'Effectivity Date: '.$cdate,0,0,'R'); 
        $this->Ln();

        $this->SetFont('Arial','B',10);
        $this->Cell(100,5,'City Agriculture Office',0,0,'C'); 
        $this->Ln();
        $this->SetFont('Arial','B',10);
        $this->Cell(100,5,'AGRI SUPPLIES & FARM INPUTS',0,0,'C'); 
        $this->Ln();
        $this->Cell(100,5,'REQUEST FORM',0,0,'C'); 
        $this->Ln();
        $this->Ln();

        $this->SetFont('Arial','b',8);
        $this->Cell(200,5,'Date  :         '.$cdate,0,0,'L'); 
        $this->Ln();

       
       }
   
    function viewTable($connection,$id){
        $received = array();
        $barang="";
        $purok="";
        $muni="";
        $lastname="";
        $firstname="";
        $middlename="";

        $statement = $connection->prepare(
            "SELECT t1.firstname as firstname,t1.lastname as lastname,t1.middlename as middlename,
            t2.service_recieved as rec,t2.beneficiary_id as id,t1.mobnum as num,t1.purok as purok,
            t1.barangay as barang,t1.mucipality as muni from beneficiaries as t1 
            inner join request_services as t2 on t2.beneficiary_id=t1.id WHERE t2.request_id='$id'"
        );
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
            $barang=$row['barang'];
            $purok=$row['purok'];
            $muni=$row['muni'];
            $lastname=$row['lastname'];
            $firstname=$row['firstname'];
            $middlename=$row['middlename'];
            $received[]=$row['rec'];
            
        }

        $this->SetFont('Arial','B',8);
        $this->Cell(200,5,'Name  :       '.$firstname.' '.$middlename.' '.$lastname,0,0,'L'); 
        $this->Ln();

        $this->SetFont('Arial','B',8);
        $this->Cell(200,5,'Address  :  '.$purok.', '.$barang.', '.$muni,0,0,'L'); 
        $this->Ln();
        $this->Ln();

        $this->SetFont('Arial','B',8);
        $this->Cell(200,5,'Request for  : ',0,0,'L'); 
        $this->Ln();

        for($i=0;$i<sizeof($received);$i++){
            $this->SetFont('Arial','B',8);
            $this->Cell(200,5,'* '.$received[$i],0,0,'L'); 
            $this->Ln();
        }
        
        $this->Ln();
        $this->SetFont('Arial','B',8);
        $this->Cell(200,5,'Specific:',0,0,'L'); 
        $this->Ln();
        $this->SetFont('Times','B',8);
        $this->Cell(12,5,'No.',1,0,'C');
        $this->Cell(12,5,'Qty',1,0,'C');
        $this->Cell(17,5,'Unit',1,0,'C');
        $this->Cell(60,5,'Item Description',1,0,'C');
        $this->Ln();
        $this->SetFont('Times','B',8);
        $this->Cell(12,5,'',1,0,'C');
        $this->Cell(12,5,'',1,0,'C');
        $this->Cell(17,5,'',1,0,'C');
        $this->Cell(60,5,'',1,0,'C');
        $this->Ln();
        $this->SetFont('Times','B',8);
        $this->Cell(12,5,'',1,0,'C');
        $this->Cell(12,5,'',1,0,'C');
        $this->Cell(17,5,'',1,0,'C');
        $this->Cell(60,5,'',1,0,'C');
        $this->Ln();
        $this->SetFont('Times','B',8);
        $this->Cell(12,5,'',1,0,'C');
        $this->Cell(12,5,'',1,0,'C');
        $this->Cell(17,5,'',1,0,'C');
        $this->Cell(60,5,'',1,0,'C');
        $this->Ln();
        $this->SetFont('Times','B',8);
        $this->Cell(12,5,'',1,0,'C');
        $this->Cell(12,5,'',1,0,'C');
        $this->Cell(17,5,'',1,0,'C');
        $this->Cell(60,5,'',1,0,'C');
        $this->Ln();
        $this->SetFont('Times','B',8);
        $this->Cell(101,5,'Remarks:',1,0,'L');
        $this->Ln();
       
        $this->SetFont('Arial','B',8);
        $this->Cell(200,5,'Released by :',0,0,'L'); 
        $this->Ln();
        $this->Cell(200,5,'_____________________',0,0,'L'); 
        $this->Ln();
        $this->Cell(40,5,'In-Charge',0,0,'C'); 
        $this->Ln();
        $this->Cell(100,5,'Note: Please return this request form for record purpose',0,0,'C'); 
        $this->Ln();
        $this->Cell(100,5,'and claim the gate pass to be issued by the information desk.',0,0,'C'); 
        $this->Ln();
        $this->SetFont('Arial','',8);
        $this->Cell(100,5,'F-CAG-01',0,0,'R'); 
        $this->Ln();
        }
    }



$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P',array(120,200));
$pdf->viewTable($connection,$id);
$pdf->Output();

?>
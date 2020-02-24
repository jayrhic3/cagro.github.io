<?php 
session_start();
require "fpdf/fpdf.php";
include('connection.php');

$id=$_SESSION["request_id"];

class myPDF extends FPDF{
    function header(){
        $this->Rect(5,5,100,140,'D');
        date_default_timezone_set("Asia/Manila");
        $date=date('h:i:s a m/d/Y',time());
        $cdate=date('F j, Y',strtotime($date));
        $time=date('g:i a',strtotime("$date"));

        $this->SetFont('Arial','',8);
        $this->Cell(90,5,'F-CAG-01',0,0,'R'); 
        $this->Ln();

        $this->SetFont('Arial','',8);
        $this->Cell(90,5,'Revision 0',0,0,'R'); 
        $this->Ln();

        $this->SetFont('Arial','',8);
        $this->Cell(90,5,'Effectivity Date: '.$cdate,0,0,'R'); 
        $this->Ln();

        $this->SetFont('Arial','B',10);
        $this->Cell(90,5,'Beneficiary Information and Request Form',0,0,'C'); 
        $this->Ln();

        $this->SetFont('Arial','',8);
        $this->Cell(200,5,'Date  : '.$cdate,0,0,'L'); 
        $this->Ln();

        $this->SetFont('Arial','',8);
        $this->Cell(200,5,'Time  : '.$time,0,0,'L'); 
        $this->Ln();
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
        $mobnum="";

        $statement = $connection->prepare(
            "SELECT t1.firstname as firstname,t1.lastname as lastname,t1.middlename as middlename,t2.assistance_recieved as rec,t2.beneficiary_id as id,t1.mobnum as num,t1.purok as purok,t1.barangay as barang,t1.mucipality as muni from beneficiaries as t1 inner join recent_request as t2 on t2.beneficiary_id=t1.id WHERE t2.request_id='$id'"
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
            $mobnum=$row['num'];
            $received[]=$row['rec'];
            
        }

        $this->SetFont('Arial','B',8);
        $this->Cell(200,5,'Name  :       '.$firstname.' '.$middlename.' '.$lastname,0,0,'L'); 
        $this->Ln();

        $this->SetFont('Arial','B',8);
        $this->Cell(200,5,'Contact#  : '.$mobnum,0,0,'L'); 
        $this->Ln();

        $this->SetFont('Arial','B',8);
        $this->Cell(200,5,'Address  :  '.$purok.', '.$barang.', '.$muni,0,0,'L'); 
        $this->Ln();
        $this->Ln();

        $this->SetFont('Arial','B',10);
        $this->Cell(200,5,'Request/Inquiry/Concerns  : ',0,0,'L'); 
        $this->Ln();

        for($i=0;$i<sizeof($received);$i++){
            $this->SetFont('Arial','B',8);
            $this->Cell(200,5,'* '.$received[$i],0,0,'L'); 
            $this->Ln();
        }
        
        $this->Ln();
        $this->SetFont('Arial','B',8);
        $this->Cell(200,5,'_________________________________________________________',0,0,'L'); 
        $this->Ln();
        $this->Ln();

        $this->SetFont('Arial','B',8);
        $this->Cell(200,5,'Approved by : ',0,0,'L'); 
        $this->Ln();
        $this->SetFont('Arial','U',8);
        $this->Cell(60,5,'ENGR. HAROLD S. DAWA ',0,0,'R'); 
        $this->Ln();
        $this->SetFont('Arial','',8);
        $this->Cell(50,5,'City Agriculturist ',0,0,'R'); 
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','B',8);
        $this->Cell(200,5,'Forwarded to : _____________________',0,0,'L'); 
        $this->Ln();
        $this->SetFont('Arial','',8);
        $this->Cell(90,5,'F-CAG-01',0,0,'R'); 
        $this->Ln();
        }
    }



$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P',array(110,150));
$pdf->viewTable($connection,$id);
$pdf->Output();

?>
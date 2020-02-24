<?php 



require "fpdf/fpdf.php";
include('connection.php');
session_start();

$id=$_SESSION['id_farm'];

class myPDF extends FPDF{
    function header(){
        $this->Rect(5,5,205,345,'D');
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
        $this->Cell(200,5,'Farm Equipment and Machineries Services',0,0,'C'); 
        $this->Ln();
        $this->Ln();
        $this->Cell(200,5,'BENEFICIARY/CLIENT FORM',0,0,'C'); 
        $this->Ln();
        $this->Ln();
       }
    
    function footer(){
       
    }
    function headerTable(){
        $this->SetFont('Arial','B',12);
        $this->Cell(180,5,'Control No.____________',0,0,'R'); 
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,'Beneficiary Profile:',0,0,'L'); 
        $this->Ln();
    }
    function viewTable($connection,$id){
        $statement = $connection->prepare(
            "SELECT t1.firstname as firstname, t1.lastname as lastname,t1.middlename as middlename,t1.mobnum as mob,
            t2.farm_site as farm,t2.tentative as dates,t2.coordinate as coor,t1.mucipality as muni,
            t1.barangay as barang,t1.province as prov,t1.purok as purok from beneficiaries as t1
             inner join record_assistance_beneficiary as t2 on t1.id=t2.beneficiary_id and
             t2.service_id='$id'"
        );
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
       
        $this->Ln();
        $this->Rect(10,69,195,50,'D');
        $this->SetFont('Arial','B',10);
        $this->Cell(200,8,'Name:'.'                '.$row["lastname"].', '.$row["firstname"].' '.$row["middlename"],0,0,'L'); 
        $this->Ln();
        $this->Cell(200,8,'Address:'.'           '.$row["prov"].', '.$row["muni"].', '.$row["barang"].', '.$row["purok"],0,0,'L'); 
        $this->Ln();
        $this->Cell(200,8,'Contact No:'.'      '.$row["mob"],0,0,'L'); 
        $this->Ln();
        $this->Cell(200,8,'Farm Site:'.'         '.$row["farm"],0,0,'L'); 
        $this->Ln();
        $this->Cell(200,8,'Coordinates:'.'    '.$row["coor"],0,0,'L'); 
        $this->Ln();
        $this->Cell(200,8,'Signature:'.'__________________',0,0,'L'); 
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,5,'Farm Mechanization Services Availed',0,0,'L'); 
        $this->Ln();
        $this->Rect(10,134,195,70,'D');
        $this->Ln();
        $this->SetFont('Arial','B',10);
        $this->Cell(200,8,'Tentative Schedule:'.'    '.date('F j, Y',strtotime($row["dates"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(200,8,'Operation:'.'       ',0,0,'L'); 
        $this->Ln();
        $this->Rect(40,154,5,5,'D');
        $this->Rect(100,154,5,5,'D');
        $this->Rect(40,163,5,5,'D');
        $this->SetFont('Arial','B',10);
        $this->Cell(130,9,'Corn Shelling'.'                                        Land Prep-Tractor',0,0,'R');
        $this->Ln();
        $this->Cell(138,8,'Other,'.' Specify:_____________________________________',0,0,'R'); 
        $this->Ln(); 
        $this->Cell(200,8,'Date Started:'.'__________________________________________________________',0,0,'L'); 
        $this->Ln();
        $this->Cell(200,8,'Date Ended:'.'___________________________________________________________',0,0,'L'); 
        $this->Ln();
        $this->Cell(200,8,'Area to be Served:'.'_____________________________________________________',0,0,'L'); 
        $this->Ln();
        $this->Cell(200,8,'Name of Operator:'.'_____________________________________________________',0,0,'L'); 
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(200,8,'Remarks:'.'       ',0,0,'L'); 
        $this->Ln();
        $this->Rect(40,219,5,5,'D');
        $this->Rect(40,229,5,5,'D');
        $this->SetFont('Arial','B',10);
        $this->Cell(77,9,'Transaction Completed',0,0,'R');
        $this->Ln();
        $this->Cell(140,9,'Reschedule on:_______________________________________',0,0,'R');
        $this->Ln();
        $this->Cell(190,9,'Reasons:_____________________________________________________________________',0,0,'R');
        $this->Ln();
        $this->Cell(190,9,'_____________________________________________________________________________',0,0,'R');
        $this->Ln();
        $this->Cell(190,9,'_____________________________________________________________________________',0,0,'R');
        $this->Ln();
        $this->Ln();
        $this->Cell(190,9,'_____________________________________________________________________________',0,0,'C');
        $this->Ln();
        $this->Cell(190,9,'Dispatcher/Farm Mechanization Program in-charge',0,0,'C');
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







?>
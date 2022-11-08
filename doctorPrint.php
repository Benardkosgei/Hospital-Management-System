<?php
include("dbconnection.php");                           
?>
<?php 
require "assets/fpdf/fpdf.php";
class myPDF extends FPDF{
    function hd($con){
        $date=date("Y-m-d h:i:sa");
        $i ="images/hmslogo.png";
        $this->Image($i,10,5,45);
        $this->SetFont('Arial','B',12);
        $this->Cell(180,7,ucwords("Kapkatet"),0,0,'C');
        $this->Ln(5);
        $this->SetFont('Arial','',10);
        $this->Cell(180,7,ucwords("Kericho"),0,0,'C');
        $this->Ln(5);
        $this->SetFont('Arial','BU',14);
        $this->Cell(180,7,'Doctors',0,1,'C');
        $this->Ln(5);
        $this->Ln(5);
    }
    
    
    function viewTable($con){
        $this->SetFont('Arial','B',11);
        $this->Cell(10,6,'No.', 1,0,'L');
        $this->Cell(40,6,"Doctor's Name", 1,0,'L');
        $this->Cell(30,6,'Department.', 1,0,'L');
        $this->Cell(30,6,'Contact', 1,0,'L');
        $this->Cell(25,6,'Education', 1,0,'L');
        $this->Cell(25,6,'Experience', 1,0,'L');
        $this->Cell(20,6,'Status', 1,1,'L');
        
      
        // $this->Cell(63,6,'Company', 1,1,'L');
        $date=date("Y-m-d");
        $c=1;

        $sql ="SELECT * FROM doctor";
        $query_sql = mysqli_query($con,$sql);
        while($rs = mysqli_fetch_array($query_sql))
                {

                    $sqldept = "SELECT * FROM department WHERE departmentid='$rs[departmentid]'";
                    $qsqldept = mysqli_query($con,$sqldept);
                    $rsdept = mysqli_fetch_array($qsqldept);         

        $this->SetFont('Arial','',9);
        $this->Cell(10,6,$c, 1,0,'L');
        $this->Cell(40,6,$rs['doctorname'], 1,0,'L');
        $this->Cell(30,6,$rsdept['departmentname'], 1,0,'L');
        $this->Cell(30,6,$rs['mobileno'], 1,0,'L');
        $this->Cell(25,6,$rs['education'], 1,0,'L');
        $this->Cell(25,6,$rs['experience'].'Year[s]', 1,0,'L');
        $this->Cell(20,6,$rs['status'], 1,1,'L');
        $c++;
                                                   
        }
    }
    

    
function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','',7);
        $this->Cell(0,5,'',0,0,'L');
        $this->SetFont('Arial','',8);
        $this->Cell(0,5,'Page'.$this->PageNo().'/{nb}',0,0,'R');
    }

    }
    

$pdf=new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4',0);
$pdf->hd($con);
$pdf->viewTable($con);
$pdf->Output();

?>
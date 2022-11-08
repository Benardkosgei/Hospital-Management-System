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
        $this->Cell(280,7,ucwords("Kapkatet"),0,0,'C');
        $this->Ln(5);
        $this->SetFont('Arial','',10);
        $this->Cell(280,7,ucwords("Kericho"),0,0,'C');
        $this->Ln(5);
        $this->SetFont('Arial','BU',14);
        $this->Cell(280,7,'Approved Appointment Report',0,1,'C');
        $this->Ln(5);
        $this->Ln(5);
    }
    
    
    function viewTable($con){
        $this->SetFont('Arial','B',11);
        $this->Cell(10,6,'No.', 1,0,'L');
        $this->Cell(40,6,"Patient's Name", 1,0,'L');
        $this->Cell(37,6,'Date and Time', 1,0,'L');
        $this->Cell(25,6,'Department', 1,0,'L');
        $this->Cell(25,6,'Gender', 1,0,'L');
        $this->Cell(30,6,'Doctor ', 1,0,'L');
        $this->Cell(90,6,'Appointment Reason', 1,0,'L');
        $this->Cell(20,6,'Status', 1,1,'L');
        
      
        // $this->Cell(63,6,'Company', 1,1,'L');
        $date=date("Y-m-d");
        $c=1;

        $sql ="SELECT * FROM appointment WHERE (status='Approved' OR status='Active')";
                if(isset($_SESSION['patientid']))
                {
                    $sql  = $sql . " AND patientid='".$_SESSION['patientid']."'";
                }
                if(isset($_SESSION['doctorid']))
                {
                    $sql  = $sql . " AND doctorid='".$_SESSION['doctorid']."'";           
                }
                $qsql = mysqli_query($con,$sql);
                while($rs = mysqli_fetch_array($qsql))
                {
                    $sqlpat = "SELECT * FROM patient WHERE patientid='".$rs['patientid']."'";
                    $qsqlpat = mysqli_query($con,$sqlpat);
                    $rspat = mysqli_fetch_array($qsqlpat);


                    $sqldept = "SELECT * FROM department WHERE departmentid='".$rs['departmentid']."'";
                    $qsqldept = mysqli_query($con,$sqldept);
                    $rsdept = mysqli_fetch_array($qsqldept);

                    $sqldoc= "SELECT * FROM doctor WHERE doctorid='".$rs['doctorid']."'";
                    $qsqldoc = mysqli_query($con,$sqldoc);
                    $rsdoc = mysqli_fetch_array($qsqldoc);
         

        $this->SetFont('Arial','',9);
        $this->Cell(10,6,$c, 1,0,'L');
        $this->Cell(40,6,$rspat['patientname'], 1,0,'L');
        $this->Cell(37,6,$rs['appointmentdate'].' at '.$rs['appointmenttime'], 1,0,'L');
        $this->Cell(25,6,$rsdept['departmentname'], 1,0,'L');
        $this->Cell(25,6,$rspat['gender'], 1,0,'L');
        $this->Cell(30,6,$rsdoc['doctorname'], 1,0,'L');
        $this->Cell(90,6,$rs['app_reason'], 1,0,'L');
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
$pdf->AddPage('L','A4',0);
$pdf->hd($con);
$pdf->viewTable($con);
$pdf->Output();

?>
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
        $this->Cell(180,7,ucwords("Kericho"),0,1,'C');
        $this->SetFont('Arial','B',10);
         $this->Cell(130,7,'Time :',0,0,'R');
         $this->SetFont('Arial','',10);
        $this->Cell(60,7,date("d-M-Y").' , '.date("h:i:sa"),0,1,'C');
        $this->Ln(5);
        $this->Ln(1);
    }
    
    
    function viewTable($con){
         $sqlpatient = "SELECT * FROM patient where patientid='$_GET[patientid]'";
         $qsqlpatient = mysqli_query($con,$sqlpatient);
        $rspatient=mysqli_fetch_array($qsqlpatient);  
        $this->SetFont('Arial','B',11);
        $this->Cell(135,7,"Patient's Name", 1,0,'L');
        $this->SetFont('Arial','',9);
        $this->Cell(55,7, $rspatient['patientname'], 1,1,'L');
        //Gender
        $this->SetFont('Arial','B',11);
        $this->Cell(50,7,"Gender", 1,0,'L');
        $this->SetFont('Arial','',9);
        $this->Cell(40,7, $rspatient['gender'], 1,0,'L');
        //dob
        $this->SetFont('Arial','B',11);
        $this->Cell(70,7,"Date of Birth", 1,0,'L');
        $this->SetFont('Arial','',9);
        $this->Cell(30,7, $rspatient['dob'], 1,1,'L');
        //Blood Group
        $this->SetFont('Arial','B',11);
        $this->Cell(125,7,"Blood Group", 1,0,'L');
        $this->SetFont('Arial','',9);
        $this->Cell(65,7, $rspatient['bloodgroup'], 1,1,'L');
        //Contact
        $this->SetFont('Arial','B',11);
        $this->Cell(60,7,"Phone Number", 1,0,'L');
        $this->SetFont('Arial','',9);
        $this->Cell(30,7, $rspatient['mobileno'], 1,0,'L');
         $this->SetFont('Arial','B',11);
        $this->Cell(30,7,"Address", 1,0,'L');
        $this->SetFont('Arial','',9);
        $this->Cell(70,7, $rspatient['address'], 1,1,'L');
        $this->Ln(10);
    //_______________________________________________________
     
        $this->Ln(8);
        //prescription
        $this->SetFont('Arial','BU',14);
        $this->Cell(100,7,'Bill Details',0,1);
        $this->Ln(3);

       
          $sqlbilling_records ="SELECT * FROM billing WHERE appointmentid='$_GET[appointmentid]'";
         $qsqlbilling_records = mysqli_query($con,$sqlbilling_records);
         $rsbilling_records = mysqli_fetch_array($qsqlbilling_records);
       $this->SetFont('Arial','B',11);
        $this->Cell(50,7,"Bill Number", 1,0,'L');
        $this->Cell(140,7,'#HMS_'.$rsbilling_records['billingid'], 1,1,'L');
        $this->Cell(50,7, 'Appointment Number', 1,0,'L');
        $this->Cell(140,7, $rsbilling_records['appointmentid'], 1,1,'L');
        ///
        $this->Cell(50,7, 'Billing Date', 1,0,'L');
        $this->Cell(50,7,  $rsbilling_records['billingdate'], 1,0,'L');
         $this->Cell(50,7, 'Billing time', 1,0,'L');
        $this->Cell(40,7,  $rsbilling_records['billingtime'], 1,1,'L');
        // $total = $total + $rs['medicinecost'];
         $this->Cell(50,7,"Date", 1,0,'L');
        $this->Cell(100,7, 'Appointment Number', 1,0,'L');
        $this->Cell(40,7, 'Bill Amount', 1,1,'L'); 
        ///  
        $sql ="SELECT * FROM billing_records where billingid='$rsbilling_records[billingid]'";
        $qsql = mysqli_query($con,$sql);
        $billamt= 0;
        while($rs = mysqli_fetch_array($qsql))
        {
        $this->SetFont('Arial','I',9);
        $this->Cell(50,7,$rs['bill_date'], 1,0,'L');
        $this->Cell(100,7,$rs['bill_type'], 1,0,'L');
        $this->Cell(40,7,'Ksh. '.$rs['bill_amount'], 1,1,'L');
        $billamt = $billamt +  $rs['bill_amount'];
        }
        $this->SetFont('Arial','B',11);
        $this->Cell(150,9,"Total Cost", 1,0,'L');
        $this->Cell(40,9, 'Ksh. '.$billamt, 1,1,'L');
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
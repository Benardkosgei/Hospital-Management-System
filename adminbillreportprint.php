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
         //appointment Report
    $sqlappointment1 = "SELECT max(appointmentid) FROM appointment where patientid='$_GET[patientid]' AND (status='Active' OR status='Approved')";
    $qsqlappointment1 = mysqli_query($con,$sqlappointment1);
    $rsappointment1=mysqli_fetch_array($qsqlappointment1);
    
    $sqlappointment = "SELECT * FROM appointment where appointmentid='$rsappointment1[0]'";
    $qsqlappointment = mysqli_query($con,$sqlappointment);
    $rsappointment=mysqli_fetch_array($qsqlappointment);
    
 
    $sqlappointment = "SELECT * FROM appointment where appointmentid='$rsappointment1[0]'";
    $qsqlappointment = mysqli_query($con,$sqlappointment);
     $rsappointment=mysqli_fetch_array($qsqlappointment);
    
    $sqlroom = "SELECT * FROM room where roomid='$rsappointment[roomid]' ";
    $qsqlroom = mysqli_query($con,$sqlroom);
    $rsroom =mysqli_fetch_array($qsqlroom);
    
    $sqldepartment = "SELECT * FROM department where departmentid='$rsappointment[departmentid]'";
    $qsqldepartment = mysqli_query($con,$sqldepartment);
    $rsdepartment =mysqli_fetch_array($qsqldepartment);
    
    $sqldoctor = "SELECT * FROM doctor where doctorid='$rsappointment[doctorid]'";
    $qsqldoctor = mysqli_query($con,$sqldoctor);
    $rsdoctor =mysqli_fetch_array($qsqldoctor);
    //
    //Contact
        $this->SetFont('Arial','B',11);
        $this->Cell(40,7,"Department", 1,0,'L');
        $this->SetFont('Arial','I',9);
        $this->Cell(60,7, $rsdepartment['departmentname'], 1,0,'L');
         $this->SetFont('Arial','B',11);
        $this->Cell(30,7,"Doctor", 1,0,'L');
        $this->SetFont('Arial','I',9);
        $this->Cell(60,7,$rsdoctor['doctorname'], 1,1,'L');
        //
           //Contact
        $this->SetFont('Arial','B',11);
        $this->Cell(100,7,"Appointment Date and Time", 1,0,'L');
        $this->SetFont('Arial','I',9);
        $this->Cell(90,7, date("d-M-Y",strtotime($rsappointment['appointmentdate'])). ' at ' .date("h:i A",strtotime($rsappointment['appointmenttime'])), 1,1,'L');
        $this->Ln(8);
        //
        $this->SetFont('Arial','BU',14);
        $this->Cell(100,7,'Treatment Record',0,1);

        $sql ="SELECT * FROM treatment_records LEFT JOIN treatment ON treatment_records.treatmentid=treatment.treatmentid WHERE treatment_records.patientid='$_GET[patientid]' AND treatment_records.appointmentid='$_GET[appointmentid]'";
        $qsql = mysqli_query($con,$sql);
        while($rs = mysqli_fetch_array($qsql))
        {
            $sqlpat = "SELECT * FROM patient WHERE patientid='$rs[patientid]'";
            $qsqlpat = mysqli_query($con,$sqlpat);
            $rspat = mysqli_fetch_array($qsqlpat);
            
            $sqldoc= "SELECT * FROM doctor WHERE doctorid='$rs[doctorid]'";
            $qsqldoc = mysqli_query($con,$sqldoc);
            $rsdoc = mysqli_fetch_array($qsqldoc);
            
            $sqltreatment= "SELECT * FROM treatment WHERE treatmentid='$rs[treatmentid]'";
            $qsqltreatment = mysqli_query($con,$sqltreatment);
            $rstreatment = mysqli_fetch_array($qsqltreatment);
        $this->SetFont('Arial','i',11);
        $this->Cell(190,17,$rstreatment['treatmenttype'].' done on '.date("d-m-Y",strtotime($rs['treatment_date'])). "  at ". date("h:i A",strtotime($rs['treatment_time'])).' by Doctor '.$rsdoc['doctorname'].'.', 0,1,'L');
        
        }
        //
        $this->Ln(8);
        //prescription
        $this->SetFont('Arial','BU',14);
        $this->Cell(100,7,'Prescription Details',0,1);
        $this->Ln(3);

        $this->SetFont('Arial','B',11);
        $this->Cell(40,7,"Medicine", 1,0,'L');
        $this->Cell(60,7, "Unit", 1,0,'L');
        $this->Cell(60,7, 'Medicine Cost', 1,0,'L');
        $this->Cell(30,7, "Total", 1,1,'L');
        $sql = "SELECT prescription_records.prescription_id,prescription_records.medicine_name,medicine.medicinename,medicine.medicinecost,prescription_records.unit
          FROM patient
         JOIN prescription
          ON  patient.patientid = prescription.patientid 
         JOIN prescription_records
         ON prescription.prescriptionid = prescription_records.prescription_id
         JOIN medicine
         ON prescription_records.medicine_name = medicine.medicineid";
        $total  =0;
        $qsql = mysqli_query($con,$sql);
        while($rs = mysqli_fetch_array($qsql))
        {
        $total = $total + $rs['medicinecost']; 
        $this->SetFont('Arial','I',9);
        $this->Cell(40,7,$rs['medicinename'], 1,0,'L');
        $this->Cell(60,7, $rs['unit'], 1,0,'L');
        $this->Cell(60,7, $rs['medicinecost'], 1,0,'L');
        $this->Cell(30,7, $total, 1,1,'L');
        }
        $this->SetFont('Arial','B',11);
        $this->Cell(160,9,"Total Cost", 1,0,'L');
        $this->Cell(30,9, 'Ksh. '.$total, 1,1,'L');
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
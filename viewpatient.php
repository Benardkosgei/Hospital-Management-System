<?php
include("adformheader.php");
include("dbconnection.php");
if(isset($_GET[delid]))
{
	$sql ="DELETE FROM patient WHERE patientid='$_GET[delid]'";
	$qsql=mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('patient record deleted successfully..');</script>";
	}
}
?>
<div class="container-fluid">
  <div class="block-header" style="display:flex;justify-content: space-between;">
    <h2 class="text-center">View Patient Records</h2>
    <a href="patientPrint.php" class="btn btn-info text-white btn-sm" title="Print List of Patients">Print &nbsp;&nbsp;
         <i class="zmdi zmdi-print"></i>
          </a>
  </div>
  <!-- start tabs -->
  <ul class="nav nav-tabs">
  <li class="active" style="padding:10px 0px;"><a data-toggle="tab" href="#home">Inpatient Care</a></li>
  <li style="padding:10px 0px 10px 20px;"><a data-toggle="tab" href="#menu1">OutPatient Care</a></li>
</ul>
<div class="tab-content">
  <div id="home" class="tab-pane fade in active">

<div class="card" style="background:slategrey;">

  <section class="container">
    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">

      <thead>
        <tr>
          <th width="15%" height="36"><div align="center">Name</div></th>
          <th width="20%"><div align="center">Admission</div></th>
          <th width="28%"><div align="center">Address, Contact</div></th>    
          <th width="20%"><div align="center">Patient Profile</div></th>
          <th width="17%"><div align="center">Action</div></th>
        </tr>
      </thead>
      <tbody>
       <?php
       $sql ="SELECT * FROM patient WHERE typeofcare='inpatient' ORDER BY patientid DESC";
       $qsql = mysqli_query($con,$sql);
       while($rs = mysqli_fetch_array($qsql))
       {
        echo "<tr>
        <td>$rs[patientname]<br>
        <strong>Login ID :</strong> $rs[loginid] </td>
        <td>
        <strong>Date</strong>: &nbsp;$rs[admissiondate]<br>
        <strong>Time</strong>: &nbsp;$rs[admissiontime]</td>
        <td>$rs[address]<br>$rs[city] -  &nbsp;$rs[pincode]<br>
        Mob No. - $rs[mobileno]</td>
        <td><strong>Blood group</strong> - $rs[bloodgroup]<br>
        <strong>Gender</strong> - &nbsp;$rs[gender]<br>
        <strong>DOB</strong> - &nbsp;$rs[dob]</td>
        <td align='center'>Status - $rs[status] <br>";
        if(isset($_SESSION[adminid]))
        {
          echo "<a href='patient.php?editid=$rs[patientid]' class='btn btn-sm btn-raised bg-green'>Edit</a><a href='viewpatient.php?delid=$rs[patientid]' class='btn btn-sm btn-raised bg-blush'>Delete</a> <hr>
          <a href='patientreport.php?patientid=$rs[patientid]' class='btn btn-sm btn-raised bg-cyan'>View Report</a>";
        }
        echo "</td></tr>";
      }
      ?>
    </tbody>
  </table>
</section>

</div>
  </div>
<!-- End in patitent -->
  <div id="menu1" class="tab-pane fade">
    <div class="card">

  <section class="container">
    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">

      <thead>
        <tr>
          <th width="15%" height="36"><div align="center">Name</div></th>
          <th width="20%"><div align="center">Admission</div></th>
          <th width="28%"><div align="center">Address, Contact</div></th>    
          <th width="20%"><div align="center">Patient Profile</div></th>
          <th width="17%"><div align="center">Action</div></th>
        </tr>
      </thead>
      <tbody>
       <?php
       $sql ="SELECT * FROM patient WHERE typeofcare ='outpatient' ORDER BY patientid DESC";
       $qsql = mysqli_query($con,$sql);
       while($rs = mysqli_fetch_array($qsql))
       {
        echo "<tr>
        <td>$rs[patientname]<br>
        <strong>Login ID :</strong> $rs[loginid] </td>
        <td>
        <strong>Date</strong>: &nbsp;$rs[admissiondate]<br>
        <strong>Time</strong>: &nbsp;$rs[admissiontime]</td>
        <td>$rs[address]<br>$rs[city] -  &nbsp;$rs[pincode]<br>
        Mob No. - $rs[mobileno]</td>
        <td><strong>Blood group</strong> - $rs[bloodgroup]<br>
        <strong>Gender</strong> - &nbsp;$rs[gender]<br>
        <strong>DOB</strong> - &nbsp;$rs[dob]</td>
        <td align='center'>Status - $rs[status] <br>";
        if(isset($_SESSION[adminid]))
        {
          echo "<a href='patient.php?editid=$rs[patientid]' class='btn btn-sm btn-raised bg-green'>Edit</a><a href='viewpatient.php?delid=$rs[patientid]' class='btn btn-sm btn-raised bg-blush'>Delete</a> <hr>
          <a href='patientreport.php?patientid=$rs[patientid]' class='btn btn-sm btn-raised bg-cyan'>View Report</a>";
        }
        echo "</td></tr>";
      }
      ?>
    </tbody>
  </table>
</section>

</div>
  </div>
  
</div>
<!-- End tab 2 -->
</div>
<?php
include("adformfooter.php");
?>
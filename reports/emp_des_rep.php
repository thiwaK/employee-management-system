<?php
ob_start();
include("../inc/header.php");

include('../phpclasses/pagination.php');
?>
<html>
<head>
	<title>Scholar details by units</title>
<script type="text/javascript">
function prnt(){
	document.getElementById("divpanel").style.display='none';
	window.print();
}

</script>
<style>
.td,.th{
    font-size:15px;
    }
</style>
</head>

<body>
<font size="1" face="Courier New" >
<table width="100%" border="0">

<tr>
    <td colspan="2" align="left"></td>
</tr>    
<?php
    require_once("../dashboard/conn.php");

    $dbobj = new dbConnection();
    $con = $dbobj->getCon();

    $search_des=@$_POST["cmbdes_search"];
    $sql1="SELECT * 
          FROM  post
          WHERE  position like '%$search_des%'";
    $result1=mysqli_query($con,$sql1);
    $row = mysqli_fetch_array($result1);
    $position= $row['position'];

    $sql="SELECT * 
          FROM employee
          WHERE designation IN ('Agriculture Instructor','Technical Assistant (Extention)','Director','Additional Director','Deputy Director','Programme Assistant( Agriculture)','Development Officer','Research Assistant','Bee Demonstrator','Agriculture Monitoring Officer','Officer in charge(Women Extension)','Officer in charge(optional food crops)')  AND scholarship ='NO' AND status = 'Current Employee' AND  designation like '%$search_des%'";
    $result=mysqli_query($con,$sql);
    echo"<th colspan='2' align='center'>Scholar Details post of  ".$position."</th>";


    echo "<table border='2' width='100%' id='result_table' contenteditable='false'>
        
        
		<th><label>Name with Initials</label></th>
        <th><label>Designation</label></th>
		<th><label>Date of Birth<label/></td>
		<th><label>Mobile No</label></th>
        <th><label>Permanent Address</label></th>
        <th><label>NIC No</label></th>
        <th><label>Email Address</label></th>
        <th><label>Appointment Date</label></th>
        <th><label>Service at DOA</label></th>
        <th><label>Highest Educational Qualification</label></th>
        <th><label>Service Category</label></th>
		<th><label>Permanent or Not</label></th>
        <th><label>subjected to desciplinary actions or not</label></th>
        <th><label>Prefered area if wish to go for a scholarship</label></th>
        <th><label>passport No</label></th>
        
       
        
</tr>";

    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
       
        echo "<td>" . $row['name_with_initials'] . "</td>";
        echo "<td>" . $row['designation'] . "</td>";
        echo "<td>" . $row['date_of_birth'] . "</td>";
        echo "<td>" . $row['phone_mobile'] . "</td>";
        echo "<td>" . $row['permanent_address'] . "</td>";
        echo "<td>" . $row['id_number'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['joined_public_date'] . "</td>";
        echo "<td>" . $row['service_at_doa'] . "</td>";        
        echo "<td>" . $row['highest_educational_qualification'] . "</td>";
        echo "<td>" . $row['service_category'] . "</td>";
         echo "<td>" .$row['appointment'] . "</td>";  
        echo "<td>" . $row['subject_to_desciplinary'] . "</td>";   
        echo "<td>" . $row['area_prefer'] . "</td>";
         echo "<td>" . $row['passport_no'] . "</td>";
        
        
        echo "</tr>";
    }    

    echo "</table>";
    ?>
<tr><td colspan="3" align="center"><hr /></td></tr>   
<tr><td colspan="4" align="center">
    <div id="divpanel" align="center">
<input type="button" value="Print" onclick="prnt();" style="width: 80px; height: 30px" />&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Close" onclick="window.close();" style="width: 80px; height: 30px" />
</div></td></tr>
<tr>
<td colspan="2" align="center">
<hr />
<i></i>
</td>
</tr>
</table></font>
</body>
</html>
<?php
	session_start();
	include "connect.php";
	
	if($_SESSION['user'] == "")
	{ 
		header("location:login.php");
	}
	
	$inactive = 600; // Set timeout period in seconds

if (isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
        session_destroy();
        header("Location:login.php");
    }
}
$_SESSION['timeout'] = time();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Historical Record</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.content {
	padding: 10px 0;
	width: 780px;
	float: left;
}
.add {	color: #333;
}
.add {	font-weight: bold;
}
.change {	font-weight: bold;
	color: #333;
}
.delete {	font-weight: bold;
	color: #333;
}
a:link {
	color: #333;
	text-decoration: none; /* unless you style your links to look extremely unique, it's best to provide underlines for quick visual identification */
}
a:visited {
	color: #333;
	text-decoration: none;
}
a:hover, a:active, a:focus { /* this group of selectors will give a keyboard navigator the same hover experience as the person using a mouse. */
	text-decoration: underline;
	color: #333;
}
</style>
</head>

<body>
<div id="log-header"><img src="Template/images/template_01.gif" width="139" height="121" alt="Logo" /><img src="Template/images/text_header.gif" alt="text" width="281" height="121" /><span class="text">PT. National Utility Helicopters</span></div>
<div id="log-header-menu">&nbsp; <a href="home.php">Home</a> || <span class="tes">Inventory :</span> <a href="partnumber.php">Part Number</a>  | <a href="nomenclature.php">Nomenclature</a> || <span class="tes">Historical Record:</span> <a href="historicalrecord.php">Part Number</a> | <a href="serialnumber.php">Serial Number</a> |<a href="doLogout.php"> Logout</a></div>
<div id="log-utama">
  <form method="get" action="serialnumber2.php">
		  <p><strong>&nbsp;(Historical Record ) </strong>Search by Serial Number<strong> :</strong> 
		    <input type="text" name="search" id="search"/>
		    <input type="submit" value="Go"/>
		  </p>
		  <p>&nbsp;</p>
  </form>

<?php
			
				if($_GET['search']=="")
			{
				$result2= mysql_query("Select count(*) From snhr");
			}
			else
			{
				$result2 = mysql_query("Select count(*) From snhr where S_N like '%".$_GET['search']."%'");
			}
			
			//paging
			$hitung=mysql_fetch_array($result2);
			$jumlahData=$hitung[0];
			$dataPerPage=2000;
			$jumlahPage=ceil($jumlahData/$dataPerPage);
			
			if($_GET['page']=="")
				$page=1;
			else
				$page=$_GET['page'];
				
			$start=($page-1)*$dataPerPage;

			//Menampilkan Data
			if($_GET['search']=="")
			{
				$result= mysql_query("Select * From snhr limit $start,$dataPerPage");
			}
			else
			{
				$result = mysql_query("Select * From snhr where S_N like '%".$_GET['search']."%'limit $start,$dataPerPage");
			}
			
			
			if(mysql_num_rows($result))
			{
				echo "<table border='1'>
				<tr>
					<td>DATE</td>
					<td>PART_NUMBER</td>
					<td>S_N</td>
					<td>NOMENCLATURE</td>
					<td>DESCRIPTION</td>
					<td>IN</td>
					<td>OUT</td>
				</tr>";
				
				while($row = mysql_fetch_array($result))
				{
					echo 
					"<tr>
						<td>".$row['DATE']."</td>
						<td>".$row['PART_NUMBE']."</td>
						<td>".$row['S_N']."</td>
						<td>".$row['NOMENCLATU']."</td>
						<td>".$row['DESCRIP']."</td>
						<td>".$row['IN']."</td>
						<td>".$row['OUT']."</td>
					</tr>";
				}
				echo "</table>";
			}
			else
			{
				echo "You Don't Have any Data";
			}
			
			//lanjutan paging
			for($i=1;$i<=$jumlahPage;$i++)
				echo "<a href='serialnumber2.php?search=".$_GET['search']."&page=$i'>$i</a> &emsp;";
		?>
</div>
</body>
</html>
<?php
session_start();
if($_SESSION['sess_adminID'] == "")
{
header("location:login.php");
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
</head>
<body>
<form name="pdfinvoice" method="post" action="pdf.php">
<table border="1" align="center">
    <tr>
        <td><?php include("top.php");?></td>
    </tr>
	<tr>
    	<td>s</td>
    </tr>
    <tr>
        <td><?php include("bottom.php");?></td>
    </tr>
	</table>
	</form>
	</body>
	</html>

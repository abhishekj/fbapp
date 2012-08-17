<?php
session_start();
if($_SESSION['sess_adminID'] == "")
{
header("location:login.php");
}
?>
<html>
<head>
<title>Email Refferal</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="stylesheet.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td align="center" valign="top">
      <table width="779" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="#325DB4" height="18">
            </td>
        </tr>
        <tr> 
          <td bgcolor="#FFFFFF"><img src="../images/spacer.gif" width="200" height="1"></td>
        </tr>
        <tr> 
          <td bgcolor="#082560" height="30" align="center"><a href="http://www.webbeeglobal.com" target="_blank"><font color="#FFFFFF">Powered 
            by WebbeeGlobal.com</font></a></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>

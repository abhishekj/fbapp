<?php
session_start();
if($_SESSION['sess_adminID'] == "")
{
header("location:login.php");
}
?>
<html>
<head>
<title>HCMAQApp</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="stylesheet.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td align="center" valign="top">
      <table width="779" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="#082560" height="20" align="right" valign="top"> 
            <table width="174" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td height="20" colspan="2">&nbsp;</td>
              </tr>
              <?php
	   if($_SESSION['sess_adminID'] != "")
	   {
	   ?>
              <tr> 
                <td width="122"><b><a href="logout.php" class="link">LOGOUT</a></b></td>
                <td width="207"><b><a href="change_password.php" class="link">Change Password</a></b></td>
              </tr>
              <?php
	   }
	   ?>
            </table>
          </td>
        </tr>
        <tr> 
          <td><img src="../images/spacer.gif" width="1" height="1"></td>
        </tr>
        <?php
	   if($_SESSION['sess_adminID'] != "")
	   {
	   ?>
        <tr> 
          <td bgcolor="#325DB4" height="35" align="left"> <a href="view_questions.php" class="link"><font color="#FFFFFF">Add Answers
<!--            </font></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="search_a_invoice.php" class="link"><font color="#FFFFFF">Search Answers-->
            </font></a>&nbsp;&nbsp;</td>
        </tr>
        <?php
	   }
	   ?>
      </table>
    </td>
  </tr>
</table>
</body>
</html>

<?php
session_start();
include("../db.inc.php");
include("../functions.inc.php");

if($_SESSION['sess_adminID'] == "")
{
header("location:login.php");
}

$save=$_GET['save'];
if($save=="y")
	{
	 $new_password=$_POST['new_password'];
	 $old_password=$_POST['old_password'];
	 $confirm_password=$_POST['confirm_password'];
	 $db_wb = new DB();
	 $db_wb->open();
	 $sql="select adminID from admin where adminID='$_SESSION[sess_adminID]' and password=PASSWORD('$old_password')";
	 $db_wb->query($sql);
	 echo $db_wb->error();
	if($old_password==""){
	$msg="Old password is required.";
	}
	else if($new_password==""){
		$msg=" New Password is required.";
	}
	else if($confirm_password==""){
		$msg="Confirm Password is required.";
	}
	else if($confirm_password!=$new_password){
		$msg="New password and Confirm Password should be equal.";
		}
	else{
		if($db_wb->numrows()!=0){
				$sql="update admin set password=PASSWORD('$new_password') where adminID='$_SESSION[sess_adminID]'";
				 $db_wb->query($sql);
				 echo $db_wb->error();
		
				header("location:admin_area.php");
				}
			else
			{
			$msg="Password is incorrect. Try agin.";
			 
			}
		}
	}

?>

<html>
<head>
<title>Guestbook</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="stylesheet.css">
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr align="center" valign="top"> 
    <td>
      <table width="779" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td> 
            <table width="779" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td><b>
                  <?php include("top.php")?>
                  </b> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr valign="top" align="center"> 
          <td height="330"> 
            <table width="650" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="bottom"> 
                <td class="txt" height="30" align="left">&nbsp;</td>
              </tr>
              <tr align="left" valign="middle"> 
                <td height="18" class="txt" align="left">&nbsp;</td>
              </tr>
              <tr align="right"> 
                <td height="30" class="txt" bgcolor="#ECEEF2" align="right"> 
                  <div align="center"><b><font color="#082560"> <font color="#666666">Change 
                    Your Password</font></font></b></div>
                </td>
              </tr>
              <tr> 
                <td><img src="images/spacer.gif" width="20" height="1"></td>
              </tr>
              <tr> 
                <td bgcolor="#ECEEF2">&nbsp;</td>
              </tr>
              <tr> 
                <td bgcolor="#082560"><img src="images/spacer.gif" width="30" height="1"></td>
              </tr>
              <tr> 
                <td height="40" align="center"><b><font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
                  <?php
				echo $msg;
				$msg="";
				?>
                  </font></b></td>
              </tr>
              <tr align="center" valign="top"> 
                <td align="center"> 
                  <table width="411" border="0" cellspacing="0" cellpadding="0">
                    <form name="change_password" method="post" action="change_password.php?save=y">
                    <tr> 
                        <td width="161" class="text1" align="right" valign="middle" height="9"><font color="#325DB4"><b>Old 
                          Password&nbsp;&nbsp;</b></font></td>
                        <td width="250" align="left" valign="top" height="9"> 
                          <input type="password" name="old_password">
                      </td>
                    </tr>
                    
                      <tr> 
                        <td width="161" class="text1">&nbsp;</td>
                        <td width="250">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td width="161" class="text1" align="right" valign="middle" height="9"><font color="#325DB4"><b>New 
                          Password&nbsp;&nbsp;</b></font></td>
                        <td width="250" align="left" valign="top" height="9"> 
                          <input type="password" name="new_password">
                        </td>
                      </tr>
                      <tr> 
                        <td width="161" class="text1" align="right" valign="middle">&nbsp;</td>
                        <td width="250" align="left" valign="top">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td width="161" class="text1" align="right" valign="middle" height="34"><font color="#325DB4"><b>Confirm 
                          Password&nbsp;&nbsp;</b></font></td>
                        <td width="250" align="left" valign="top" height="34"> 
                          <input type="password" name="confirm_password">
                        </td>
                      </tr>
                      <tr> 
                        <td width="161" class="text1" align="right" valign="middle">&nbsp;</td>
                        <td width="250" align="left" valign="top">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td width="161" class="text1" align="right" valign="middle">&nbsp;</td>
                        <td width="250" align="left" valign="top"> 
                          <input type="submit" name="Login" value="Login!!!">
                        </td>
                      </tr>
                    </form>
                  </table>
                </td>
              </tr>
              <tr> 
                <td height="40">&nbsp;</td>
              </tr>
              <tr> 
                <td bgcolor="#082560"><img src="images/spacer.gif" width="20" height="1"></td>
              </tr>
              <tr> 
                <td bgcolor="#ECEEF2">&nbsp;</td>
              </tr>
              <tr> 
                <td bgcolor="#FFFFFF"><img src="images/spacer.gif" width="20" height="1"></td>
              </tr>
              <tr> 
                <td bgcolor="#ECEEF2" height="30">&nbsp;</td>
              </tr>
              <tr> 
                <td height="30">&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr> 
          <td>
            <table width="779" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td>&nbsp; </td>
              </tr>
              <tr>
                <td>
                  <?php include("bottom.php");?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>

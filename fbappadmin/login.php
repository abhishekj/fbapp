<?php
session_start();
include("db.inc.php");
include("functions.inc.php");

$login=$_GET['login'];
if($login=="y")
	{
	  $adminID=$_POST['adminID'];
	  $password=$_POST['password'];
	 $db_wb = new DB();
	 $db_wb->open();
	 $sql="select adminID from admin where adminID='$adminID' and password=PASSWORD('$password')";
	 $db_wb->query($sql);
	 echo $db_wb->error();
	if($adminID==""){
	$msg="Admin ID is required.";
	}
	else if($password==""){
		$msg="Password is required.";
	}
	else{
		if($db_wb->numrows()!=0){
				$_SESSION['sess_adminID']=$adminID;
		
				header("location:admin_area.php");
				}
			else
			{
			$msg="Login Name or Password is incorrect. Try agin.";
			 
			}
		}
	}

?>

<html>
<head>
<title>HCMFBApp</title>
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
                <td>&nbsp; </td>
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
                <td height="18" class="txt" align="left"><b class="txt"><font color="#325DB4">Administration 
                  Suite</font> </b></td>
              </tr>
              <tr align="right"> 
                <td height="30" class="txt" bgcolor="#ECEEF2" align="right"> 
                  <div align="center"><b><font color="#082560"> <font color="#666666">ADMINISTRATOR 
                    LOGIN </font></font></b></div>
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
                  <table width="300" border="0" cellspacing="0" cellpadding="0">
                    <form name="Login" method="post" action="login.php?login=y">
                      <tr> 
                        <td width="79" class="text1" align="right" valign="middle"><font color="#325DB4"><b>Login 
                          ID&nbsp;&nbsp;</b></font></td>
                        <td width="221" align="left" valign="top"> 
                          <input type="text" name="adminID">
                        </td>
                      </tr>
                      <tr> 
                        <td width="79" class="text1">&nbsp;</td>
                        <td width="221">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td width="79" class="text1" align="right" valign="middle" height="9"><font color="#325DB4"><b>Password&nbsp;&nbsp;</b></font></td>
                        <td width="221" align="left" valign="top" height="9"> 
                          <input type="password" name="password">
                        </td>
                      </tr>
                      <tr> 
                        <td width="79" class="text1" align="right" valign="middle">&nbsp;</td>
                        <td width="221" align="left" valign="top">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td width="79" class="text1" align="right" valign="middle">&nbsp;</td>
                        <td width="221" align="left" valign="top"> 
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
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>

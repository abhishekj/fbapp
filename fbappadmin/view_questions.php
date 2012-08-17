<?php
session_start();
require_once("db.inc.php");
require_once("functions.inc.php");


if($_SESSION['sess_adminID'] == "")
{
header("location:login.php");
}
$q_id=$_GET['q_id'];

$db_wb2 = new DB();
$db_wb2->open();

	if($q_id)
	{
	$sql2="SELECT count(*) as cnt FROM `questions` LEFT OUTER JOIN `answers` ON `q_id`=`a_qid` where q_to='$q_id'";
	}
	else
	{
	$sql2="SELECT count(*) as cnt FROM `questions` LEFT OUTER JOIN `answers` ON `q_id`=`a_qid` ";
	}
	$db_wb2->query($sql2);
	echo $db_wb2->error();

/**************************************************
********************PAGING CODE*******************
**************************************************/
$page_size =15;
//$sql2="select * from billing_history where login_name='$login_name'";
//$db_wb2->query($sql2);
$total_rows = $db_wb2->fetchObject()->cnt;
$total_pages = intval($total_rows / $page_size);
$remain = $total_rows % $page_size;
if($remain != 0)
{
++$total_pages;
}
$current_page  = $_GET['current_page'];
if($current_page == "")
{
$current_page  = 1;
}


$start  = $_GET['start'];
if($start == "")
{
$start  = 0;
}
$end  = $start + $page_size;
$jump_page=$_GET[jump_page];
/********JUMP PAGE ***********/
$jump_page=$_POST['jump_page'];
if($jump_page)
{
$jump_page--;
$current_page=$jump_page+1;
$jump = $jump_page*($page_size);
$start = $jump;
}
/**********END JUMP PAGE*************/
$sql2 = "SELECT * FROM `questions` LEFT OUTER JOIN `answers` ON `q_id`=`a_qid` order by q_dateposted desc limit $start, $page_size";
$db_wb2->query($sql2);

//$db_ug->close();
$url = $_SERVER['PHP_SELF'];
$prev_url .= "?start=".($start-$page_size)."&current_page=".($tmp=$current_page-1);
if($tmp <= 0)
{
$show_prev = false;
}
else
{
$show_prev = true;
}

$next_url .= "?start=".($start+$page_size)."&current_page=".($tmp=$current_page+1);
//$jump_url
if($tmp > $total_pages)
{
$show_next = false;
}
else
{
$show_next = true;
}
/**************************************************
*************** END PAGEING CODE*******************
**************************************************/

	
?>
<html>

<head>
<title>View Answers</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000" topmargin="0" leftmargin="0">
<table width="779" border="0" cellspacing="0" cellpadding="0" align="center">
  <form name="view_email2mobile" method="post" action="view_questions.php">
    <tr> 
      <td colspan="6"> 
        <div align="left"> 
          <?php include("top.php")?>
        </div>
      </td>
    </tr>
    <tr> 
      <?php
		if($group!="")
		{
		?>
      <td colspan="6"> 
        <div align="center"></div>
      </td>
      <?php
		  }
		  ?>
    </tr>
    <tr> 
	 <td colspan="6">
	
        <table width="779" border="1" cellspacing="1" cellpadding="1">
          <tr>
          <td width="16%" height="20"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Id</b></font></div></td> 
            <td width="16%" height="20"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Customer Email</b></font></div>
            </td>
            <td width="16%" height="20"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Question</b></font></td>
            <td width="18%" height="20"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> Answer</font></b></td>
            <td width="18%" height="20"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Date Question Posted</b></font></td>
            <td width="14%" height="20"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Facebook ID</b></font></td>            
          </tr>
          <?php
				for($i=1;$newObj2=$db_wb2->fetchObject();$i++)
				{
				?>
          <tr> 
            <td width="16%"> 
              <div align="left"> </div>
              <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
              <?php
				  echo $i;
				  ?>
              </font></td>
            <td width="16%"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
              <?php
				  echo $newObj2->q_email;
				  ?>
              </font></td>
            <td width="18%"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
              <?php
				  echo substr($newObj2->q_question,0,20);
				  ?>
              </font></td>
            <td width="18%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
            <a href="edit_answer.php?q=<?php echo $newObj2->q_id?>"> 
              <?php
				  echo $newObj2->a_answer?substr($newObj2->a_answer,0,15):'Add Answer';
				  ?>
			</a>
              </font></td>
            <td width="14%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
              <?php
				  echo $newObj2->q_dateposted;
				  ?>
              </font></td>
              <td width="14%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
		<img src="https://graph.facebook.com/<?php
				  echo $newObj2->q_to;
				  ?>/picture">
              </font></td>            
          </tr>
          <?php
				}
				?>
        </table>
      </td>
    </tr>
    <tr> 
      <td width="30%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="6%">&nbsp;</td>
      <td colspan="2"> 
        <div align="right"> 
          <?php
									if($total_pages > 1)
									{
									?>
          <table width="269" border="0" cellspacing="0" cellpadding="0" align="right" height="32">
            <tr> 
              <td align="left" width="82"> 
                <?php if($show_prev){?>
                <a href="<?php echo $prev_url ?>">&lt;&lt;Prev</a> 
                <?php
													  }?>
              </td>
              <td width="104" align="center" valign="middle">Page <b> 
                <?php echo $current_page?>
                </b>of 
                <?php echo $total_pages?>
              </td>
              <td width="83"> 
                <?php if($show_next){?>
                <a href="<?php echo $next_url;?>">Next&gt;&gt;</a> 
                <?php
													  }?>
              </td>
            </tr>
          </table>
          <?php
									}
									?>
        </div>
      </td>
    </tr>
    <tr> 
      <td colspan="6"> 
        <input type="hidden" name="jump_page" >
        <script language="JavaScript">
function jump_page (form) {
var TestVar = prompt("Enter page no to jump to",'2');
view_email2mobile.jump_page.value=TestVar;
document.view_email2mobile.submit();
}
</script>
      </td>
    </tr>
    <tr> 
      <td colspan="6"> 
        <div align="right"><a href="javascript:jump_page(this.form);"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Jump 
          Page</font></a>

</div>
      </td>
    </tr>
    <tr> 
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="6"> 
        <?php include("bottom.php");?>
      </td>
    </tr>
    <?Php
		  if($group!="")
		  {
		  ?>
    <?php
  }
  ?>
  </form>
</table>
</body>

</html>

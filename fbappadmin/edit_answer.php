<?php
session_start();
include("db.inc.php");
include_once("functions.inc.php");
if($_SESSION['sess_adminID'] == "")
{
header("location:login.php");
}
$db_wb_time = new DB();
$db_wb_time->open();
$qid = $_GET['q'];

if($_GET['save']=='y'){
//	$sql="UPDATE `answers`,questions SET a_answer='".q($_POST['answer'])."' where q_id=$qid AND `q_id`=`a_qid` ";
	$sql="SELECT * FROM answers WHERE a_qid=$qid";	
	$db_wb_time->query($sql);

	if($db_wb_time->numRows()==0){
		$sql = "INSERT INTO `answers` (`a_fbid`,`a_answer`,`a_qid`) values ('".q($_GET['fbid'])."',substr('".q($_POST['answer'])."',1,400),$qid)";
	} else{
	//echo $_POST['answer'];
		 $sql="UPDATE `answers` SET a_answer=substr('".q($_POST['answer'])."',1,400) where a_qid=$qid ";
	}
	$db_wb_time->query($sql);	
	
	// send email
	$sql = "SELECT * FROM questions where q_id=$qid";
	$db_wb_time->query($sql);
	$newObj_time=$db_wb_time->fetchObject();
	$name = $newObj_time->name;
	$email = $newObj_time->q_email;
	
	$text = readmyfile("email/answer.html");
	$text = preg_replace("/__NAME__/",$name?$name:'User',$text);
	if(0){
require_once "Mail.php";		
$headers["From"]    = "customercare@healthcaremagic.com";
$headers["To"]      = $email;
$headers["Subject"] = "[HealthCareMagic] A Doctor Answered your Question.";
$headers["X-SMTPAPI"] = "{'category': 'FBreply'}";

$params["host"] = "smtp.sendgrid.net";
$params["port"] = "25";
$params["auth"] = true;
$params["username"] = "rxhealthcaremagic";
$params["password"] = "tomcat33";

// Create the mail object using the Mail::factory method
$mail_object =&Mail::factory("smtp", $params);

$mail_object->send($email, $headers, $text); 
	}else{	
	send_mail($email,"[HealthCareMagic] A Doctor Answered your Question.",$text,"donotreply@healthcaremagic.com","HealthCareMagic",true);
	}
	header('location: view_questions.php?msg=Updated the Question.');
}

$sql_time="SELECT * FROM `questions` LEFT OUTER JOIN `answers` ON `q_id`=`a_qid` WHERE q_id=$qid";
$db_wb_time->query($sql_time);
$newObj_time=$db_wb_time->fetchObject();

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Edit Answer</title>
<script type="text/javascript" src="calendarDateInput.js"></script>
</head>
<body>
<form name="pdfinvoice" method="post" action="edit_answer.php?save=y&fbid=<?php echo $newObj_time->q_to; ?>&q=<?php echo $newObj_time->q_id; ?>">
<table border="1" align="center">
<tr>
	<td><?php include("top.php");?></td>
</tr>
	<tr>
		<td>
			<table align="" width="779">
			<tr>
				<td align="left"></td>
				<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><u>Add / Update Answer</u></strong></td>
			</tr>
				<tr>
					<td  align="left">Date Question Posted</td>
				 <td width="886" height="80" align="left" ><div id="main" align="left">&nbsp;&nbsp;<?php echo $newObj_time->q_dateposted; ?>
				</tr>
				<tr>
					<td>Question</td>
					<td><?php echo $newObj_time->q_question; ?></td>
				</tr>
				<tr>
					<td>Answer</td>
				<td><textarea maxlength="500" onkeyup="document.getElementById('charsleft').innerHTML=(400 - this.form.answer.value.length)+' Characters left';"  name="answer"><?php echo $newObj_time->a_answer; ?></textarea><br />
			<div id="charsleft">400 Characters left</div>	
				</td>
				</tr>
			</table>
		</td>
	</tr>	
	<tr>
		<td align="center"><input type="submit" name="print" value="Update Answer" /></td>
	</tr>
    <tr>
        <td><?php include("bottom.php");?></td>
    </tr>
	</table>
	</form>
	</body>
	</html>
<?php 

function q($content){
	//$content = (! get_magic_quotes_gpc ()) ? addslashes ($content) : $content;
	//        $content = mysql_real_escape_string($content);
	$content = mysql_real_escape_string(preg_replace("/&lt;|&rt;/","",preg_replace("/[^\x20-\x7E\x0A]/","",$content)));
	return $content;
}
?>

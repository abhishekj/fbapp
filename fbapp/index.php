<?php
session_start();
require 'src/facebook.php';
require_once 'config.inc.php';
require_once 'db.inc.php';
$db = new DB();
$db->open();
global $appId;
global $secret;
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $secret,
));

$user = $facebook->getUser();
$opr='home';
$opr=$_GET['opr']?$_GET['opr']:'home';

/*
if($_GET['opr']=='login'){
	$opr = 'login';
} elseif ($_GET['opr']=='logout'){
	$opr = 'logout';
	
}elseif ($_GET['opr']=='gift' && $user){
	$opr = 'gift';
}

*/

//
//if ($user) {
//  try {
//    // Proceed knowing you have a logged in user who's authenticated.
//    $user_profile = $facebook->api('/me');
//  } catch (FacebookApiException $e) {
//    error_log($e);
//    $user = null;
//  }
//}
if (isset($_GET['code'])){
    header("Location: http://apps.facebook.com/326745340698069/" );
    exit;
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
  $logoutUrl.='&opr=logout';
	$me = $facebook->api($user);
	
//  $friends = $facebook->api('/'.$facebook->getUser().'/friends');
} else {
//	$scope=array("scope","friends_about_me,");
 $loginUrl = $facebook->getLoginUrl(
  array("scope" => "publish_stream,email",
// 	"redirect_uri" => "http://apps.facebook.com/326745340698069/"
)
);
	$loginUrl.='&opr=login&purl='.$_REQUEST['purl'];
$_SESSION['plink'] = $_GET['purl'];
}
?>
<?php if($opr=='home' && $user){
	$arr = array('message'=>$me["name"] . ' has started using the "Ask a Doctor" application');
	$arr["link"] = "http://www.xyz.com";
	$arr["picture"] = "http://apps.ejain.com/fbapp/img/logo2.png";
	$arr["description"] = "XYZ.com is a place where you can ask health queries to doctors at a fraction of your co-pay cost and get detailed, personalized answers. You can ask follow-ups too. Give it a try!";
	$arr["name"] = "HCM Q&A App";	
//		if($_SESSION['plink']){
//			$arr["link"] = $_REQUEST['purl']?$_REQUEST['purl']:"http://www.webbeeglobal.com/index.php";
//		}
	 $query = "SELECT 1 AS 'selected' FROM `posts` WHERE `p_dated` > DATE_SUB(NOW(),INTERVAL 5 DAY) AND `p_fbid` = '" . q($facebook->getUser()). "' AND p_type='loggedin'";

	$db->query($query);
	
	if($db->numRows()==0){
		//echo $_SESSION['plink'];
		
		$post_id = $facebook->api("/".$facebook->getUser()."/feed",post,$arr);
		$query = "INSERT INTO posts (p_type,p_fbid,p_postfbid) VALUES('loggedin','".q($facebook->getUser())."','".$post_id['id']."')";
		$db->query($query);
		
	} else{

	}
	show_header();
	show_questionform();
	showanswers();
	show_footer();
	
		exit;
		
	}elseif ($user && $opr=='questionsubmitrefresh'){
		$arr = array('message'=>$me["name"] . ' has asked a question to a doctor. You can also ask a question to a doctor for FREE through the "Ask a Doctor" application. Brought to you by www.XYZ.com. ');
		$arr["link"] = "http://www.XYZ.com";
        $arr["picture"] = "http://apps.ejain.com/fbapp/img/logo2.png";
        $arr["description"] = "XYZ.com is a place where you can ask health queries to doctors at a fraction of your co-pay cost and get detailed, personalized answers. You can ask follow-ups too. Give it a try!";
        $arr["name"] = "HCM Q&A App";

		 $query = "SELECT 1 AS 'selected' FROM `posts` WHERE `p_dated` > DATE_SUB(NOW(),INTERVAL 1 HOUR ) AND `p_fbid` = '" . q($facebook->getUser()). "' AND p_type='question'";

	$db->query($query);
	$post_id = '';
	if($db->numRows()==0){
		//echo $_SESSION['plink'];
		
		$post_id = $facebook->api("/".$facebook->getUser()."/feed",post,$arr);
		$query = "INSERT INTO posts (p_type,p_fbid,p_postfbid) VALUES('question','".q($facebook->getUser())."','".$post_id['id']."')";
		$db->query($query);
	}
		if($_POST['question']!='' && $_POST['question'] != 'Type your question here' ){
		$query = "INSERT INTO questions (`q_to`,`q_question`,q_postfbid,q_email,q_name) VALUES('".q($facebook->getUser())."',substr('".q($_POST['question'])."',1,150),'".$post_id['id']."','".q($me["email"])."','".q($me["name"])."')";
		$db->query($query);
		}
		show_header();
	show_questionform();
	showanswers();
	show_footer();
		
		exit;
    	
//}else{
//	show_answersrefresh();
  //              exit;

//}
}elseif($user && $opr=='viewanswer'){
	$arr = array('message'=>"" . $me["name"] . ' received an answer from a doctor. You can also get answers from doctors for FREE through the .Ask a Doctor. application. Brought to you by www.XYZ.com');
	$arr["link"] = "http://www.XYZ.com";
        $arr["picture"] = "http://apps.ejain.com/fbapp/img/logo2.png";
        $arr["description"] = "XYZ.com is a place where you can ask health queries to doctors at a fraction of your co-pay cost and get detailed, personalized answers. You can ask follow-ups too. Give it a try!";
        $arr["name"] = "HCM Q&A App";

	 $query = "SELECT 1 AS 'selected' FROM `posts` WHERE `p_dated` > DATE_SUB(NOW(),INTERVAL 1 DAY) AND `p_fbid` = '" . q($facebook->getUser()). "' AND p_type='viewanswer'";
	$db->query($query);
        $post_id = '';
        if($db->numRows()==0){
	 $post_id = $facebook->api("/".$facebook->getUser()."/feed",post,$arr);
                $query = "INSERT INTO posts (p_type,p_fbid,p_postfbid) VALUES('viewanswer','".q($facebook->getUser())."','".$post_id['id']."')";
                $db->query($query);
	}
	viewanswer(); exit;
}

?>
<html><head>
<script>
top.location="<?php echo $loginUrl ; ?>";
</script>
    </head>
    <body>hi</body>
    </html>
    <?php 
    
    function q($content){
	//$content = (! get_magic_quotes_gpc ()) ? addslashes ($content) : $content;
	//        $content = mysql_real_escape_string($content);
	$content = mysql_real_escape_string(preg_replace("/&lt;|&rt;/","",preg_replace("/[^\x20-\x7E]/","",$content)));
	return $content;
}
function show_gifted($str){
	global $db;
	$query = "SELECT * FROM `gift` GROUP BY  `g_to` ORDER BY g_dated DESC LIMIT 50";
	$db->query($query);
	?>
	
	<div style="width:650px; height:300px;">
    <div style="background-color:#6c85b8; color:#ffffff; border:1px solid #395a9d; padding-left:10px;"><?php echo $str; ?> - Recent Gifts to:</div>

    <div style="border:1px solid #545454; border-top:none;">
    
   
    

	
	
	<?php 
	while ($newObj = $db->fetchObject()){
		?>
		
		 <!-- Friends List open -->
    	<div style=" width:150px; height:60px; float:left; margin:10px 5px;">
        	<div style="float:left;"><a target="_top" href="http://www.facebook.com/<?php echo $newObj->g_to; ?>/"><img src="https://graph.facebook.com/<?php echo $newObj->g_to; ?>/picture"/></a></div>		
            <div style="float:left;">
            	<span>           </span>
            	<form>
<!--                	<input type="checkbox" name="" />-->
                </form>
               
            </div>	
           <div style="clear:both;"></div>
        </div>

    <!-- Close Friends list -->
		<?php 
	}
	?>
	
	
<div style="clear:both;"></div>
 <div style="background-color:#f2f2f2; height:50px; border-top:1px solid #cccccc;">
 Return to <a href="http://www.facebook.com" target="_top">FaceBook</a>
 </div>
    </div>
    
</div>
	<?php 
}
    ?>
    
    
    <?php 
function show_questionform(){
		?>
		
<div class="content">
    	<form method="post" action="http://apps.ejain.com/fbapp/index.php?opr=questionsubmitrefresh" id="form1">
	<div style="font-size: 9px;font-color: Grey; padding: 8px;text-align: left;" >
<br />
Please type your health query. Please do NOT include any personally identifiable information like name, date of birth, identification number, etc.<br />
<b>Note:</b> Once the doctor reples to your query, you will receive an e-mail informing you of the same and you.ll be able to see your answer here.
</div>
    <div class="textareabg">
	
    <textarea onclick="if(this.value=='Type your question here'){this.value='';}" onblur="if(this.value==''){this.value='Type your question here';}" onkeyup="document.getElementById('charsleft').innerHTML=(150 - this.form.question.value.length)+' Characters left';" name="question" rows="" class="textareaq">Type your question here</textarea>
    </div>
    <div class="action">
    <span class="left"><div id="charsleft">150 Characters left</div>
 By clicking on "Ask a Doctor", I agree to the <a href="http://www.XYZ.com/tc" target="_blank">Terms and Conditions</a> </span>
    <span class="right">
    <label>
      <input type="image" name="imageField" id="imageField" src="http://apps.ejain.com/fbapp/img/askadoctor.png" />
    </label>
    </span>
    </div>
    </form>
  </div>			
		
			 <div class="clear"></div>
		<?php 
}
    ?>
    
    
    
    
    <?php 
    function show_answersrefresh(){
	showanswers(); exit;
    	?>
    	<html><head>
    
<script>
top.location="<?php echo $fbUrl ; ?>";
</script>
    </head>
    <body>hi</body>
    </html>
    <?php 
    }
    ?>


 <?php 
function showanswers($aid=""){
	
	global $db;
	global $facebook;
	
	if($aid && 0){
		$query = "SELECT * FROM `questions`,`answers` WHERE `q_id`=`a_qid` AND `a_fbid`='" . q($facebook->getUser()). "' AND `a_active`='checked' AND a_id=$aid ORDER BY q_id DESC";
        $db->query($query);
	}else{
	
	$query = "SELECT * FROM `questions` LEFT OUTER JOIN `answers` ON `q_id`=`a_qid` WHERE `q_to`='" . q($facebook->getUser()). "' ";
	$db->query($query);
	
	}
	?>
	
<div style="font-size: 9px;font-color: Grey; padding: 8px;" >The information in this answer is provided for general informational purposes only and SHOULD NOT be relied upon as a substitute for sound professional medical advice, evaluation or care from your physician or other qualified healthcare provider as a complete assessment of an individual has not taken place. Nothing in this answer should be used for treating or diagnosing a medical or health condition. This is not a replacement for Doctor - patient relationship and physical examination by a qualified healthcare provider.</div>
<div class="questionpanel">    
<h1>My Answers</h1>
	
	
	<?php 
	while ($newObj = $db->fetchObject()){
		?>
		
		 <h1>Q.  <?php echo $newObj->q_question;?></h1>
<h2>
			
	<?php if ($aid) { 
			echo "" . $newObj->a_answer;
        	} elseif($newObj->a_id){
        	
      ?>
      
		<?php echo $newObj->a_answer; ?>
<?php /*<h2><a class="visitwebsite" target="_top" href="http://apps.facebook.com/326745340698069/index.php?opr=viewanswer&aid=<?php echo $newObj->a_id; ?>&tm=<?php echo time() " >Thank You !</a>  </h2> */?>
			<?php   	
        	} else{
			
		}
        	
     ?>
        	</h2>
		<?php 
	}
	?>
	 </div>
	 <div class="clear"></div>
	<?php 
}
    ?>
    
 <?php
function viewanswer(){
        global $db;
        global $facebook;
	$aid = $_GET['aid'];
	show_header();
	show_questionform();
	showanswers($aid);
	show_footer();
	
	exit;
//        $query = "SELECT * FROM `questions`,`answers` WHERE `q_id`=`a_qid` AND `a_fbid`='" . q($facebook->getUser()). "' AND `a_active`='checked' AND a_id=$aid";
//        $db->query($query);
        ?>





        <?php
}
    ?>

                     
<?php 
function show_header(){
	?>
	
<style type="text/css">
body{
	margin:0;
	padding:0;
}
.clear {
	clear: both;
}
.wrapper {
	width:600px;
	margin:auto;
	border: 1px solid #CCC;
	background-color: #FFF;
	background-image: url(http://apps.ejain.com/fbapp/img/bg.png);
	background-repeat: repeat-x;
	background-position: bottom;
}
.questionpanel .visitwebsite {
	display: block;
	height: 24px;
	width: 136px;
	background-image: url(http://apps.ejain.com/fbapp/img/visitwebsite.png);
	background-position: left top;
	text-align: left;
	text-decoration: none;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFF;
	padding-top: 9px;
	padding-right: 9px;
	padding-bottom: 9px;
	padding-left: 15px;
}
.wrapper .header {
	height: 56px;
	background-color: #FFFFFF;
}
.content .textareaq {
	width: 520px;
	overflow: auto;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	resize: none;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 20px;
	color: #000000;
	padding: 7px;
	height: 120px;
}
.content .textareabg {
	background-image: url(http://apps.ejain.com/fbapp/img/textarea.png);
	background-repeat: no-repeat;
	background-position: center top;
	height: 140px;
	width: 557px;
	padding-top: 15px;
	padding-right: 15px;
	padding-bottom: 0px;
	padding-left: 15px;
}
.content .action {
	width: 552px;
	padding-right: 15px;
	padding-left: 15px;
}
.content .action .left {
	float: left;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #999;
	padding-top: 5px;
	padding-left: 3px;
	text-align: left;
	line-height: 18px;
}
.wrapper .questionpanel {
	border-top-width: 1px;
	border-top-style: solid;
	border-top-color: #CCC;
	margin-top: 20px;
	padding-right: 15px;
	padding-bottom: 15px;
	padding-left: 15px;
}
.questionpanel h2 {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: normal;
	color: #666;
	margin-bottom: 10px;
	border-bottom-width: 1px;
	border-bottom-style: dotted;
	border-bottom-color: #CCC;
	padding-bottom: 10px;
}
.questionpanel h2 a {
	color: #666;
	text-decoration:none;
}
.questionpanel h2 a:hover {
	color: #06C;
	text-decoration:none;
}
.questionpanel h2 span a {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	color: #06C;
	text-decoration: none;
}

.questionpanel h1 {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 23px;
	color: #069;
}
.left a {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	color: #069;
	text-decoration: none;
}
.content  .action .right {
	float: right;
}
.wrapper .content {
	text-align: center;
	padding: 5px;
}
.left a:hover {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	color: #069;
	text-decoration: underline;
}
.questionpanel h2 span {
	clear:both;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #666;
	padding: 0px;
	margin: 0px;
}
.questionpanel .visitwebsite:hover {
	display: block;
	height: 24px;
	width: 136px;
	background-image: url(http://apps.ejain.com/fbapp/img/visitwebsite.png);
	background-position: left bottom;
	text-align: left;
	text-decoration: none;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FFF;
	padding-top: 9px;
	padding-right: 9px;
	padding-bottom: 9px;
	padding-left: 15px;
}
.questionpanel h2 span a:hover {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	color: #333;
	text-decoration: none;
}
</style>
</head>
<body>
<div class="wrapper">
	 <div class="header"><img src="http://apps.ejain.com/fbapp/img/logo2.png"  alt="Logo" /></div>
	<div style="position: absolute;top: 30px; right: -100px;">
	<iframe src="//www.facebook.com/plugins/like.php?href=http://apps.facebook.com/askadoc/&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe><br/>
	Ask. Don't search. It's your health!
	</div>
	<?php 
}

function show_footer(){
	?>
	</div>
<div style="font-size: 9px;font-color: Grey; padding: 8px;text-align: right;" ><p>Powered by: <a target="_blank" href="http://www.webbeeglobal.com/">Webbee</a></p></div>
	<?php 
}
?>

<?php
//error_reporting(E_ALL);

//function for formatiing price
function formatPrice($price, $thousand_delim = ",", $decimal_delim = ".", $precision = "2")
{
	//if (strstr($price,".")) {
	//	$price .= "00";
	//	$price = ereg_replace("(\...).*$", "\\1", $price);
	//} else
	//	$price .= ".00";
	
	$price = sprintf("%.$precision"."f", $price);
	$price = str_replace(".", $decimal_delim, $price);
	$pos = strpos($price, $decimal_delim);
	if (!$pos) $pos = strlen($price);
	for ($i = $pos -3; $i > 0; $i -= 3) {
		$price = substr($price, 0, $i).$thousand_delim.substr($price, $i);
	}
	return $price;
}


//function to upload
function upload($uploaddir,$name,$banner_id,$useidonly=false)
{
$filename = $_FILES[$name]['name'];
$pos = strpos($filename,".");
$len = strlen($filename);
$file_type = substr($filename,$pos+1,$len);
if($useidonly)
{
$file_name = $banner_id;
}
else
{
$file_name = $name."_".$banner_id;
}
$file_name .= ".".$file_type;
if(move_uploaded_file($_FILES[$name]['tmp_name'], $uploaddir.$file_name))
{
$uploaded = true;
return $file_name;
}
else
{
return false;
}
}


function cp_debug($text)
{
echo "CP DEBUG: \t$text<br>";
}
function cpRedirect($pagename)
{
header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".$pagename);
}


function cpCreateCombo($db, $name, $table, $display, $value, $selected, $size=0, $options="")
{

echo "<select $options size='$size' name='$name'>";
$sql = "select * from $table";
$db->query($sql);

while ($row = $db->fetchArray())
{
echo "<option value = $row[$value]";
if(is_array($selected)){
foreach ($selected as $value1) {

if ($row[$value] == $value1)
{
echo " selected";
}
}
}
else
{
if ($row[$value] == $selected)
{

echo " selected";
}
}
?>
<?php 
if(is_array($display)){
foreach ($display as $dis) 
echo $row[$dis]." ";
}
else
{
echo $row[$display]." ";
}
?>
<?php
}
?>
</select>
<?php
}


function readmyfile($path)
{
	$text='';
	$fp = @fopen($path,"r");
	while (!@feof($fp))
	{
	$buffer = @fgets($fp, 4096);
	$text.= $buffer;
	}
	@fclose($fp);
	return $text;
}
function send_mail($email_to,$subject,$message,$from_email,$from_name='',$html)
{
if($from_name == '') $from_name=$from_email;
if($html)
 $headers = "Content-type: text/html; charset=iso-8859-1\n";
 else 
 $headers = "Content-type: text/plain; charset=iso-8859-1\n";
 
 $headers .= "From: $from_name <$from_email> \n";

 @mail($email_to, $subject, $message, $headers);
}



		function executeQuery($sql)
		{
			$result = mysql_query($sql) or die(mysql_error(). " : ".$sql);
			return $result;
		}
		function getSingleResult($sql)
		{
			$response="";	
			$result = mysql_query($sql) or die(mysql_error(). " : ".$sql);
			if($line=mysql_fetch_array($result))
				{
					$response=$line[0];
				}				
			return $response;
		}

		function executeUpdate($sql)
		{
			mysql_query($sql) or die(mysql_error(). " : ".$sql);
		}
		function decimal ($p )
		 {
		 	$i=strpos($p,".");
			if($i)
			{	
				strlen(substr($p,$i+1));
				if(strlen(substr($p,$i+1))==1)
				{
				$p.="0";
				}
				
			}
			else
			{
				$p.=".00";
			}
			return  $p;
		}
		function getOrderID($last_id)
			{
				$a= substr($last_id,3,strlen($last_id));
				$a= intval($a)+1;
				
				if($a<10)
				{
					$a="00".$a;
				}
				else if($a<=99)
				{
					$a="0".$a;
				}
				$new_order_id ="ORA".$a;
				return $new_order_id;
			}

			function templateID($last_template)
			{
				$t= substr($last_template,3,strlen($last_template));
				$t= intval($t)+1;
				
				if($t<10)
				{
					$t="00".$t;
				}
				else if($t<=99)
				{
					$t="0".$t;
				}
				$new_template_id ="TMP".$t;
				return $new_template_id;
			}




function GenCombo($sql,$lstfield,$key,$keyvalue)
{
 global $dblink;
 $result = @mysql_query($sql) or die('Sql Error In genCombo');
 if (@mysql_num_rows($result)==0)
 {
  return;
 }
 while ($row = @mysql_fetch_array($result))
 {
  if ($keyvalue == $row["$key"]) $sel=" selected";
  else $sel="";
  echo "<option value=\"".$row["$key"]."\" $sel>".$row["$lstfield"]."</option>";
 }
}

//function for generating the check boxes from for database
function GenCheckbox($sql,$lstfield,$key,$keyvalues)
{
 global $dblink;

 $noofiteminrow=3;
 $itemno=1;
 $trtext="<tr>";
 $result = @mysql_query($sql) or die('Sql Error In genCombo');
 if (@mysql_num_rows($result)==0)
 {
  return;
 }
 echo "<input type=\"hidden\" name=\"noof_".$key."\" value=".@mysql_num_rows($result).">";
 echo "<table>";
 $ctr=0;
 $keyarr=explode(",", $keyvalues);
 //print_r($keyarr);
 while ($row = @mysql_fetch_array($result))
 {
  $ctr++;
  if ($itemno ==1) echo $trtext;
  if (in_array($row["$key"],$keyarr)) $sel=" checked";
  else $sel="";
  echo "<td>";
  echo "<input type=\"hidden\" name=\"valueof_".$key."[$ctr]\" value=".$row["$key"].">";
  echo "<input type=\"checkbox\" name=\"varof_".$key."[$ctr]\" value=\"1\" $sel>".$row["$lstfield"]."</td>";
  $itemno++;
  if ($itemno > $noofiteminrow)
  {
   echo "</tr>";
   $itemno=1;
  }
 }//end while
 $ctr++;
 echo "<tr><td colspan=$noofiteminrow>";
 echo "<input type=\"hidden\" name=\"valueof_".$key."[$ctr]\" value=0>";
 echo "<input type=\"checkbox\" name=\"varof_".$key."[$ctr]\" value=\"1\" $sel>Any</td>";
 echo "</td></tr>";
 echo "</table>";
}

//function to process multiple checkbox
function ProcessCheckbox($noofcheckbox,$valarr,$vararr)
{
 for ($i=1;$i<=$noofcheckbox;$i++)
 {
  if ($vararr[$i] == '1')
  {
   $arr[]=$valarr[$i];
  }
 }
 return $arr;
}

function GenDate($date)
{
 $arr = explode("-",$date);
 //print_r($arr);
 //echo "<br>";
 $unixts=mktime(0,0,0,$arr[1],$arr[2],$arr[0]);
 //Echo "unix timestamp : $unixts <br>";
 //echo "new date : ".date("d-m-Y",$unixts);
 return date("d-m-Y",$unixts);
}

//Combo Box( generate from OPT file

function makeCombo($optname,$optfile,$optsel,$optex){ //returns string containing select tag

$combo="<select name='$optname' $optex>";
include $optfile;

foreach($manutmp as $key => $value){

	$tosel="";
	if($optsel==$key)
	{
	$tosel="selected";
	}
	
		
		$combo.="<option value='$key' $tosel>$value\n";
	
	}
$combo.="</select>";
return $combo;
}


function getComboValue($optfile,$optkey){
include $optfile;
return $manutmp[$optkey];
}
/******generate random number*****/
/*********************************/	
$security_code='';
$allow = "0123456789";
srand((double)microtime()*1000000);
for($i=0; $i<8; $i++) {
$security_code .= $allow[rand()%strlen($allow)];
}
/******closing generate random number*****/
/*********************************/	
//include_once('webbee.inc.php');
?>

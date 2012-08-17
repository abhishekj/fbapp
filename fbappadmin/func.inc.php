<?php
function getPrice($db, $flagID)
{
$sql = "select price from flag where flagID = $flagID";
$db->query($sql);
$tObj = $db->fetchArray();
return $tObj[0];
}
function getSetting($db, $which=0)
{
if($which)
{
$sql = "select setting$which from setting";
}
else
{
$sql = "select dollarValue from setting";
}
$db->query($sql);
$tObj = $db->fetchArray();
return $tObj[0];
}

function getDated($db, $template_code)
{
$sql = "select dated from template where template_code = '$template_code'";
$db->query($sql);
$tObj = $db->fetchArray();
return $tObj[0];
}

function getDiscount($db, $template_code,$price)
{
$discount2 = getSetting($db, 2);
$discount4 = getSetting($db, 3);

$sql = "select current_date";
$db->query($sql);
$tObj = $db->fetchArray();
$cdate = $tObj[0];

$sql = "select DATE_ADD(dated, INTERVAL 2 MONTH) <= current_date from template where template_code = '$template_code'";
$db->query($sql);
$tObj = $db->fetchArray();
$date2 = $tObj[0];

$sql = "select DATE_ADD(dated, INTERVAL 4 MONTH) <= current_date from template where template_code = '$template_code'";
$db->query($sql);
$tObj = $db->fetchArray();
$date4 = $tObj[0];

if($date4)
{
return ($price * $discount4 / 100);
}
elseif($date2)
{
return ($price * $discount2 / 100);
}
else
{
return 0;
}


}
function getOrderCode()
{
return md5(uniqid(rand(0,9999999999))).time();
}

function getFullURL($url)
{
return "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/$url";
}

function last_id($db,$table,$id)
{
$sql = "select max($id) from $table";
$db->query($sql);
$lid = $db->fetchArray();
return $lid[0];
}
?>
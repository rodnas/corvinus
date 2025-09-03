<?php
/*
if (version_compare(phpversion(), '5.3.10', '>'))
	{
//	echo 'Current PHP version: '.phpversion().'<br>';
	error_reporting(0);
	}
*/
ini_set('display_errors',0);

$sessionID = session_id();
if(empty($sessionID)) {
	session_id('corvinus');
	session_start();
}

ob_start();
if (!DEFINED('runOK')) define('runOK',true);
$config=Array();
$config["startPageTime"]=microtime(true);
$config["bannerROOT"]="../docroot/core_advert/";
$config["bannerDrROOT"]="../docroot/nocore_doctor_advert/";
$config["systemROOT"]="/";

include "share/inc/config.inc.php";
include "share/lib/config.lib.php";    	

$config["dbConnect"] = new PDO($config["configShare"]["databaseType"].':host='.$config["configShare"]["databaseServer"].';dbname='.$config["configShare"]["databaseSelect"], $config["configShare"]["databaseUser"], $config["configShare"]["databasePassword"]);
$setNames=$config["dbConnect"]->prepare($config["configShare"]["setNames"]);
$setNames->execute();

$config = configFieldSearchAll($config,"backend");
$config["dayID"] = dayIdentifier(time());

if (isset($_GET["cssconvert"]) && !empty($_GET["cssconvert"]))
	{
	$result = cssConvert($config,$_GET["systemType"],$_GET["cssconvert"],$_GET["resolution"]);
	echo $result;
	}
else if (isset($_GET["jsconvert"]) && !empty($_GET["jsconvert"]))
	{
	$result = jsConvert($config,"backend/js/",$_GET["jsconvert"]);
	echo $result;
	}
else
	{
	header("Location: backend/index.php");
	}
$config["dbConnect"] = NULL;	
?>
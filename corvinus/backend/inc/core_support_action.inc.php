<?php
if (!DEFINED('runOK')) exit;
$viewItem[$config["modulSelect"].'_x_description']=0;
if ($config["modulAction"] == "list")
	{
	$viewItem[$config["modulSelect"].'_x_description']=1;
	}
$viewItem = viewConfig($config,$viewItem);
$viewItem[$config["modulSelect"]."_x_core_supportID"]=1;
if (isset($_POST["s_core_supportID"]))
	{
	if (!empty($_POST["s_core_supportID"])) {$viewItem[$config["modulSelect"]."_x_core_supportID"]=0;}
	else {$viewItem[$config["modulSelect"]."_x_core_supportID"]=1;}
	}
else if (isset($_SESSION[$config["modulSelect"]."_s_core_supportID"]) && !empty($_SESSION[$config["modulSelect"]."_s_core_supportID"]))
	{
	$viewItem[$config["modulSelect"]."_x_core_supportID"]=0;
	}
?>
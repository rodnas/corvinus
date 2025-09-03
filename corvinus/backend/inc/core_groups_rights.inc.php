<?php
if (!DEFINED('runOK')) exit;
$viewItem[$config["modulSelect"]."_x_description"]=0;
$viewItem = viewConfig($config,$viewItem);
$viewItem[$config["modulSelect"]."_x_core_configsID"]=1;
if (isset($_POST["s_core_configsID"]))
	{
	if (!empty($_POST["s_core_configsID"])) {$viewItem[$config["modulSelect"]."_x_core_configsID"]=0;}
	else {$viewItem[$config["modulSelect"]."_x_core_configsID"]=1;}
	}
else if (isset($_SESSION[$config["modulSelect"]."_s_core_configsID"]) && !empty($_SESSION[$config["modulSelect"]."_s_core_configsID"]))
	{
	$viewItem[$config["modulSelect"]."_x_core_configsID"]=0;
	}
$viewItem[$config["modulSelect"]."_x_core_usersID"]=1;
if (isset($_POST["s_core_groupsID"]))
	{
	if (!empty($_POST["s_core_groupsID"])) {$viewItem[$config["modulSelect"]."_x_core_groupsID"]=0;}
	else {$viewItem[$config["modulSelect"]."_x_core_groupsID"]=1;}
	}
else if (isset($_SESSION[$config["modulSelect"]."_s_core_groupsID"]) && !empty($_SESSION[$config["modulSelect"]."_s_core_groupsID"]))
	{
	$viewItem[$config["modulSelect"]."_x_core_groupsID"]=0;
	}
?>
<?php
if (!DEFINED('runOK')) exit;
$viewItem[$config["modulSelect"]."_x_core_configsID"]=0;
$viewItem[$config["modulSelect"]."_x_core_support_typeID"]=0;
$viewItem[$config["modulSelect"]."_s_core_configsID"]=0;
$viewItem[$config["modulSelect"]."_s_core_support_typeID"]=0;
$viewItem[$config["modulSelect"]."_x_description"]=0;
$viewItem[$config["modulSelect"]."_x_planTime"]=0;
$viewItem[$config["modulSelect"]."_x_realTime"]=0;
if ($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"]==2)
	{
	$viewItem[$config["modulSelect"]."_x_core_configsID"]=1;
	$viewItem[$config["modulSelect"]."_x_core_support_typeID"]=1;
	$viewItem[$config["modulSelect"]."_s_core_configsID"]=1;
	$viewItem[$config["modulSelect"]."_s_core_support_typeID"]=1;
	if (isset($_POST["s_core_support_typeID"]))
		{
		if (!empty($_POST["s_core_support_typeID"])) {$viewItem[$config["modulSelect"]."_x_core_support_typeID"]=0;}
		else {$viewItem[$config["modulSelect"]."_x_core_support_typeID"]=1;}
		}
	else if (isset($_SESSION[$config["modulSelect"]."_s_core_support_typeID"]) && !empty($_SESSION[$config["modulSelect"]."_s_core_support_typeID"]))
		{
		$viewItem[$config["modulSelect"]."_x_core_support_typeID"]=0;
		}
	if (isset($_POST["s_core_configsID"]))
		{
		if (!empty($_POST["s_core_configsID"])) {$viewItem[$config["modulSelect"]."_x_core_configsID"]=0;}
		else {$viewItem[$config["modulSelect"]."_x_core_configsID"]=1;}
		}
	else if (isset($_SESSION[$config["modulSelect"]."_s_core_configsID"]) && !empty($_SESSION[$config["modulSelect"]."_s_core_configsID"]))
		{
		$viewItem[$config["modulSelect"]."_x_core_configsID"]=0;
		}
	$viewItem[$config["modulSelect"]."_x_planTime"]=1;
	$viewItem[$config["modulSelect"]."_x_realTime"]=1;
	}
if ($config["modulAction"] == "list")
	{
	$viewItem[$config["modulSelect"]."_x_description"]=1;
	}
$viewItem = viewConfig($config,$viewItem);
$viewItem[$config["modulSelect"]."_x_core_support_topicID"]=1;
if (isset($_POST["s_core_support_topicID"]))
	{
	if (!empty($_POST["s_core_support_topicID"])) {$viewItem[$config["modulSelect"]."_x_core_support_topicID"]=0;}
	else {$viewItem[$config["modulSelect"]."_x_core_support_topicID"]=1;}
	}
else if (isset($_SESSION[$config["modulSelect"]."_s_core_support_topicID"]) && !empty($_SESSION[$config["modulSelect"]."_s_core_support_topicID"]))
	{
	$viewItem[$config["modulSelect"]."_x_core_support_topicID"]=0;
	}
$viewItem[$config["modulSelect"]."_x_core_support_statusID"]=1;
if (isset($_POST["s_core_support_statusID"]))
	{
	if (!empty($_POST["s_core_support_statusID"])) {$viewItem[$config["modulSelect"]."_x_core_support_statusID"]=0;}
	else {$viewItem[$config["modulSelect"]."_x_core_support_statusID"]=1;}
	}
else if (isset($_SESSION[$config["modulSelect"]."_s_core_support_statusID"]) && !empty($_SESSION[$config["modulSelect"]."_s_core_support_statusID"]))
	{
	$viewItem[$config["modulSelect"]."_x_core_support_statusID"]=0;
	}
?>
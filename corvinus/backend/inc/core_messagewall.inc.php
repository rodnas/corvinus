<?php
if (!DEFINED('runOK')) exit;
$viewItem[$config["modulSelect"].'_x_predescription']=0;
if (!empty($config["x_predescription"]))
	{
	if ($config["modulAction"] == "add") 
		{
		$viewItem[$config["modulSelect"].'_x_predescription']=1;
		}
	else
		{
		$viewItem[$config["modulSelect"].'_x_predescription']=0;
		}
	$config[$config["modulSelect"]."_x_predescription"] = "<span class='phpmaker'><i>".setConfigValue($config,$config["modulSelect"],"answerTitle").":</i><b><br>".$config["x_predescription"];
	$config[$config["modulSelect"]."_x_targetUserID_disabled"]=' disabled="disabled"';
	$config[$config["modulSelect"]."_x_targetGroupID_disabled"]=' disabled="disabled"';
	$config[$config["modulSelect"]."_x_siteID_disabled"]=' disabled="disabled"';
	$config[$config["modulSelect"]."_x_subject_disabled"]=' disabled="disabled"';
	}
$viewItem = viewConfig($config,$viewItem);
$viewItem[$config["modulSelect"]."_x_targetUserID"]=1;
if (isset($_POST["s_targetUserID"]))
	{
	if (!empty($_POST["s_targetUserID"])) {$viewItem[$config["modulSelect"]."_x_targetUserID"]=0;}
	else {$viewItem[$config["modulSelect"]."_x_targetUserID"]=1;}
	}
else if (isset($_SESSION[$config["modulSelect"]."_s_targetUserID"]) && !empty($_SESSION[$config["modulSelect"]."_s_targetUserID"]))
	{
	$viewItem[$config["modulSelect"]."_x_targetUserID"]=0;
	}
$viewItem[$config["modulSelect"]."_x_targetGroupID"]=1;
if (isset($_POST["s_targetGroupID"]))
	{
	if (!empty($_POST["s_targetGroupID"])) {$viewItem[$config["modulSelect"]."_x_targetGroupID"]=0;}
	else {$viewItem[$config["modulSelect"]."_x_targetGroupID"]=1;}
	}
else if (isset($_SESSION[$config["modulSelect"]."_s_targetGroupID"]) && !empty($_SESSION[$config["modulSelect"]."_s_targetGroupID"]))
	{
	$viewItem[$config["modulSelect"]."_x_targetGroupID"]=0;
	}
?>
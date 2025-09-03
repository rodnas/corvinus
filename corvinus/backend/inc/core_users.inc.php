<?php
if (!DEFINED('runOK')) exit;
$viewItem[$config["modulSelect"].'_x_description']=0;
$viewItem[$config["modulSelect"].'_x_newsletter']=0;
$viewItem[$config["modulSelect"].'_insertUserID']=0;
$viewItem[$config["modulSelect"].'_x_insertWhen']=0;
$viewItem[$config["modulSelect"].'_x_password']=0;
$viewItem[$config["modulSelect"].'_x_password2']=0;
//$viewItem['core_users_x_core_groups']=0;
if ($config["modulAction"]=="add")
	{
	$viewItem[$config["modulSelect"].'_x_password']=1;
	$viewItem[$config["modulSelect"].'_x_password2']=1;
	$viewItem[$config["modulSelect"].'_x_core_groups']=1;
	}
else if ($config["modulAction"]=="passchange")
	{
	$viewItem[$config["modulSelect"].'_x_password']=1;
	$viewItem[$config["modulSelect"].'_x_password2']=1;
	}
else if ($config["modulAction"]=="edit")
	{
	if ($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"]==2)
		{
		$viewItem[$config["modulSelect"].'_x_password']=0;
		$viewItem[$config["modulSelect"].'_x_password2']=0;
		$viewItem[$config["modulSelect"].'_x_core_groups']=1;
		}
	}
//$viewItem = viewConfig($config,$viewItem);
$viewItem[$config["modulSelect"]."_x_core_userstitleID"]=1;
if (isset($_POST["s_core_userstitleID"]))
	{
	if (!empty($_POST["s_core_userstitleID"])) {$viewItem[$config["modulSelect"]."_x_core_userstitleID"]=0;}
	else {$viewItem[$config["modulSelect"]."_x_core_userstitleID"]=1;}
	}
else if (isset($_SESSION[$config["modulSelect"]."_s_core_userstitleID"]) && !empty($_SESSION[$config["modulSelect"]."_s_core_userstitleID"]))
	{
	$viewItem[$config["modulSelect"]."_x_core_userstitleID"]=0;
	}

if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 2 ||
	$_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 3) {
	$viewItem[$config["modulSelect"]."_x_core_groupsID"]=1;
	if (isset($_POST["s_core_groupsID"]))
		{
		if (!empty($_POST["s_core_groupsID"])) {$viewItem[$config["modulSelect"]."_x_core_groupsID"]=0;}
		else {$viewItem[$config["modulSelect"]."_x_core_groupsID"]=1;}
		}
	else if (isset($_SESSION[$config["modulSelect"]."_s_core_groupsID"]) && !empty($_SESSION[$config["modulSelect"]."_s_core_groupsID"]))
		{
		$viewItem[$config["modulSelect"]."_x_core_groupsID"]=0;
		}
} else {
	$viewItem[$config["modulSelect"]."_x_core_groupsID"]=0;
}
?>
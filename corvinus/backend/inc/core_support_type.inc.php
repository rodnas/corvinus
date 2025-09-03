<?php
if (!DEFINED('runOK')) exit;
$viewItem[$config["modulSelect"]."_x_description"]=0;
$viewItem[$config["modulSelect"].'_x_insertWhen']=0;
if ($config["modulAction"] == "list") 
	{
	$viewItem[$config["modulSelect"].'_x_insertWhen']=1;
	}
$viewItem = viewConfig($config,$viewItem);
?>
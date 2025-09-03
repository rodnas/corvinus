<?php
function modulFrameDelete($config, $viewItem)
	{
	$_SESSION["nocore_reservationAction"]="";
	unset($_SESSION["nocore_reservationAction"]);
	if (isset($_REQUEST["back"]))
		{
		jumpToPage($config[$config["modulSelect"]]["whichBack"]);
		}
	$config["deleteReally"]='<div id="deleteReallyBox">'.$config["configShare"]["deleteReallyTitle"].'</div>';
	switch ($config["getAction"])
		{
		case "I": // display
			$itemValues = modulGetRecord($config, $config[$config["modulSelect"]]["mainTable"]);
			break;
		case "U": // display
			$itemValues = modulGetRecord($config, $config[$config["modulSelect"]]["mainTable"]);
			break;
		case "D": // delete
			$itemValues = modulGetRecord($config, $config[$config["modulSelect"]]["mainTable"]);
			if (isset($_REQUEST["delete"]))
				{
				$deleteCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##deleteCFG##","##/deleteCFG##");
				$deleteFieldCFG = explode('<#>',$deleteCFG);
				for ($deleteFieldCFGCount=0;$deleteFieldCFGCount<count($deleteFieldCFG);$deleteFieldCFGCount++)
					{
					$deleteItemCFG = explode('<=>',$deleteFieldCFG[$deleteFieldCFGCount]);
					switch (trim($deleteItemCFG[0]))
						{
						case "simple":
							$deleteSQL = "DELETE FROM ".$deleteItemCFG[1].$config[$config["modulSelect"]]["key"];
							$config["dbConnect"]->exec($deleteSQL);
							break;
						case "file":
							$actualImgPath = actualImgPath($config,$itemValues);
							$deleteFile = $actualImgPath.$itemValues[$deleteItemCFG[1]];
							if (is_file($deleteFile))
								{
								unlink($deleteFile);
								}
							break;
						case "pictureResize":
							if ($config[$config["modulSelect"]]["hide"] != "1")
								{
								$actualImgPath = $config["configShare"]["docrootPath"].$config[$config["modulSelect"]]["imgPath"];
								}
							else
								{
								$actualImgPath = $config["configShare"]["docrootPathHide"].$config[$config["modulSelect"]]["imgPath"];
								}
							$deletePicture = $actualImgPath.$itemValues[$deleteItemCFG[1]];
							if (is_file($deletePicture))
								{
								unlink($deletePicture);
								}
							$deleteSmallPicture = $actualImgPath.str_replace(".",setConfigValue($config,$config["modulSelect"],"pictSmallNamePlus").".",$itemValues[$deleteItemCFG[1]]);
							if (is_file($deleteSmallPicture))
								{
								unlink($deleteSmallPicture);
								}
							$deleteNormalPicture = $actualImgPath.str_replace(".",setConfigValue($config,$config["modulSelect"],"pictNormalNamePlus").".",$itemValues[$deleteItemCFG[1]]);
							if (is_file($deleteNormalPicture))
								{
								unlink($deleteNormalPicture);
								}
							break;
						}
					}
				jumpToPage($config[$config["modulSelect"]]["whichBack"]);
				}
		}
	$config["getAction"]="D";
	require_once ($config["systemROOT"].$config["configShare"]["modulFramePath"]."view.inc.php");
	$config["contentViewHTML"] = modulFrameViewRecord($config,$itemValues,$config["getAction"], $viewItem);
	$config["navigationHTML"] = footerNavigation($config);
	$config["actionForm"]=$_SERVER["SCRIPT_NAME"]."?modulSelect=".$config["modulSelect"]."&modulAction=delete";
	$viewHTML = iniCFGParser($config["sharedTPL"]["iniCFG"],"##viewForm##","##/viewForm##");
	$config["contentHTML"]=parseContent($viewHTML,$config,$itemValues);
	return $config;
	}

function modulFrameDeleteGroup($config, $viewItem)
	{
	if (isset($_REQUEST["back"]))
		{
		jumpToPage($config[$config["modulSelect"]]["whichBack"]);
		}
	switch ($config["getAction"])
		{
		case "I": // display
			break;
		case "D": // delete
			if (isset($_REQUEST["delete"]))
				{
				$deleteCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##deleteCFG##","##/deleteCFG##");
				$deleteFieldCFG = explode('<#>',$deleteCFG);
				for ($deleteFieldCFGCount=0;$deleteFieldCFGCount<count($deleteFieldCFG);$deleteFieldCFGCount++)
					{
					$deleteItemCFG = explode('<=>',$deleteFieldCFG[$deleteFieldCFGCount]);
					switch (trim($deleteItemCFG[0]))
						{
						case "groupDr":
							$deleteSQL = "DELETE FROM ".$deleteItemCFG[1].$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_nocore_doctorID"];
							$config["dbConnect"]->exec($deleteSQL);
							break;
						}
					}
				jumpToPage($config[$config["modulSelect"]]["whichBack"]);
				}
//	die();
		}
	$config["getAction"]="D";
	$viewItem[$config["modulSelect"]."_deleteGroup"]=0;
	$config["contentViewHTML"] = modulFrameViewRecord($config,$itemValues,$config["getAction"], $viewItem);
	$config["navigationHTML"] = footerNavigation($config);
	$config["actionForm"]=$_SERVER["SCRIPT_NAME"]."?modulSelect=".$config["modulSelect"]."&modulAction=deleteGroup";
	$viewHTML = iniCFGParser($config["sharedTPL"]["iniCFG"],"##viewForm##","##/viewForm##");
	$config["contentHTML"]=parseContent($viewHTML,$config,$itemValues);
	return $config;
	}
?>
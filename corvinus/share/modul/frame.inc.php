<?php                      	
/**
* modulFrame functions
*/
//$config = modulFrame($config, $modulSelect, $modulAction);
// modulframe head start
function modulFrame($config, $p_modulSelect, $p_modulAction, $viewItem)
	{
	$layoutNoContent = explode(",",$config['configShare']['layoutNoContent']);
	if (in_array($config['modulSelect'],$layoutNoContent)) {
		$config["layoutMainHTML"]="layoutnocontent";
	}
	$fileName=$p_modulSelect;
	
	// CFG Start 
	$fileType="cfg";
	$filePath="cfg/";
	$loadError="cfgNotFound";
	$config = cfgLoader($config,$fileName,$fileType,$filePath,$loadError);
	$config[$modulSelect]["iniCFG"] = str_replace("##modul##",$p_modulSelect,$config[$modulSelect]["iniCFG"]);

	// LNG Start
	$fileType="lng";
	$filePath="lng/";
	$loadError="lngNotFound";
	$config = lngLoader($config,$fileName,$fileType,$filePath,$loadError);
	$config[$modulSelect]["iniCFG"] = str_replace("##modul##",$p_modulSelect,$config[$modulSelect]["iniCFG"]);

	// TPL Start 
	$fileType="html";
	$filePath="tpl/";
	$loadError="templateNotFound";
	$config = tplLoader($config,$fileName,$fileType,$filePath,$loadError);
	$config[$fileName]["iniCFG"].=$config[$fileName]["tplCFG"];


	$config["getAction"] = @$_POST["a"];
//	if (empty($config["getAction"])) {
	if (empty($config["modulAction"])) {
		$config["modulAction"]="list";
	
	}
	$config["modulSelect"] = $p_modulSelect;
//	$viewItem = viewField($config,$viewItem);
	if (file_exists($config["configShare"]["incPath"].$config["modulSelect"].".inc.php"))
		{
		include $config["configShare"]["incPath"].$config["modulSelect"].".inc.php";
		}
	$config[$config["modulSelect"]]["allRecs"] = modulPermission($config,$p_modulSelect);
	$actModulPath = setConfigValue($config,$p_modulSelect,"whichModulPath");
	if ($config["modulAction"]<>"list")
		{
		if ($config[$config["modulSelect"]]["layoutMainHTMLNo"]!=1)
			{
			$config[$config["modulSelect"]]["whichBack"] = "index.php?modulSelect=".$config["modulSelect"]."&modulAction=list".$config[$config["modulSelect"]]["plusParam"];
			}
		if (isset($_SESSION["addBack"]))
			{
			$config[$config["modulSelect"]]["whichBack"] .= "&modulSelect=".$_SESSION["addBack"];
			}
		if (isset($config["modulRecordID"]))
			{
			$config[$config["modulSelect"]]["key"] = $config["modulRecordID"];
			}
		else if (isset($config["modulSimpleRecordID"]))
			{
			$config[$config["modulSelect"]]["key"] = $config["modulSimpleRecordID"];
			}
		else if (isset($_POST["key"]))
			{
			$config[$config["modulSelect"]]["key"] = @$_POST["key"];
			}
		if (!empty($config[$config["modulSelect"]]["key"]))
			{
			$config[$config["modulSelect"]]["sqlKey"] = "id=" . "" . $config[$config["modulSelect"]]["key"] . "";
			$_SESSION[$config["modulSelect"]["whichSystemAndMode"].$config["modulSelect"]."sqlKey"] = $config[$config["modulSelect"]]["sqlKey"];
			}
		else
			{
			$config[$config["modulSelect"]]["sqlKey"] = "";
			}
		}
	if (isset($_GET["modulSimpleAction"]) || isset($config["modulSimpleAction"]) || (isset($config[$config["modulSelect"]]["layoutMainHTMLNo"]) && $config[$config["modulSelect"]]["layoutMainHTMLNo"]==1))
		{
		if (isset($_SESSION[$config["configShare"]["whichSystemAndMode"]."layoutFullBack"]))
			{
			$config["layoutFullBack"]=$_SESSION[$config["configShare"]["whichSystemAndMode"]."layoutFullBack"];
			}
		else if (!isset($config["layoutFullBack"]) || empty($config["layoutFullBack"]))
			{
			$config["layoutFullBack"]=$config["configShare"]["baseModul"];
			}
		if (!isset($config["modulSimpleAction"]))
			{
			$config["modulSimpleAction"]=$_GET["modulSimpleAction"];
			}
		$modulSelectPre=$config["modulSelect"];
		$modulActionPre=$config["modulAction"];
		unset($_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."firstPage"]);
		unset($_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."lastPage"]);
		unset($_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."modulPage"]);
		unset($_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."errorPage"]);
		if (isset($_SESSION["whichModul"]))
			{
			$config[$config["modulSelect"]]["whichBack"] .= "&modulSelect=".$_SESSION["whichModul"]."&cmd=resetall";
			}
		if (isset($config["layoutFullBack"]))
			{
			$config[$config["modulSelect"]]["whichBack"] = $config["layoutFullBack"];
			}
				
		if (!isset($config[$config["modulSelect"]]["displayRecs"]) || empty($config[$config["modulSelect"]]["displayRecs"]))
			{
			$config[$config["modulSelect"]]["displayRecs"]=$config["configShare"]["displayRecs"];
			}
		if (!isset($config[$config["modulSelect"]]["recRange"]) || empty($config[$config["modulSelect"]]["recRange"]))
			{
			$config[$config["modulSelect"]]["recRange"]=$config["configShare"]["recRange"];
			}
		$config[$config["modulSelect"]]["startRec"]=1;
		$config[$config["modulSelect"]]["advancedSearch"]="";
		$config[$config["modulSelect"]]["basicSearch"]="";
		$config[$config["modulSelect"]]["pSearchOriginal"]="";
		$config[$config["modulSelect"]]["searchWhere"]="";
		$config[$config["modulSelect"]]["dbwhere"]="";
		$config[$config["modulSelect"]]["whereClause"]="";
		$config[$config["modulSelect"]]["masterDetailWhere"] = "";
		$config[$config["modulSelect"]]["OrderBy"] = "";
		$config[$config["modulSelect"]]["GroupBy"] = "";
		require_once ($config["configShare"]["modulFrameIncludePath"]."list.inc.php");
		$config = modulSimpleList($config,$viewItem);
		$config["modulSelect"]=$modulSelectPre;
		$config["modulAction"]=$modulActionPre;
		switch ($config["modulSimpleAction"])
			{
			case "layoutsetup":
				{
				$_SESSION[$config["configShare"]["whichSystemAndMode"]."layout"]=$config["modulSimpleAction"];
				coreUsersConfigSet($config,"layout",$config["modulSimpleAction"]);
				jumpToPage($config["layoutFullBack"]);
				break;
				}
			case "left":
				{
				$_SESSION[$config["configShare"]["whichSystemAndMode"]."layout"]=$config["modulSimpleAction"];
				coreUsersConfigSet($config,"layout",$config["modulSimpleAction"]);
				jumpToPage($config["layoutFullBack"]);
				break;
				}
			case "right":
				{
				$_SESSION[$config["configShare"]["whichSystemAndMode"]."layout"]=$config["modulSimpleAction"];
				coreUsersConfigSet($config,"layout",$config["modulSimpleAction"]);
				jumpToPage($config["layoutFullBack"]);
				break;
				}
			case "logout":
				{
				$lastLogoutSQL = "UPDATE core_users SET `lastLogoutWhen`='".db_actual_datetime()."'";
				$lastLogoutSQL .= " WHERE id='".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]."'";
				$config["dbConnect"]->exec($lastLogoutSQL);
				session_destroy();
				session_start();
				$core_usersSQL = "SELECT *,(SELECT core_themesID FROM core_groups WHERE core_users.core_groupsID=core_groups.id) AS core_groups_themesID,";
				$core_usersSQL .= "(SELECT fieldValue FROM core_users_config WHERE core_users_config.core_usersID=core_users.id AND fieldName='themes') AS core_users_themesID FROM `core_users` WHERE `nickname` = '" . $config["configShare"]["guestUser"] . "'";
				$core_usersRec=$config["dbConnect"]->prepare($core_usersSQL);
				$core_usersRec->execute();
				$core_usersCount = $core_usersRec->rowCount();
				if ($core_usersCount != 0)
					{
					$rowUser=$core_usersRec->fetch(PDO::FETCH_ASSOC);
					$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_User"] = $rowUser["nickname"];
				 	$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"] = $rowUser["id"];
				 	$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"] = $rowUser["core_groupsID"];
					if (!empty($rowUser["core_users_themesID"]))
						{
						$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"] = $rowUser["core_users_themesID"];
						}
					else if (!empty($rowUser["core_groups_themesID"]))
						{
						$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"] = $rowUser["core_groups_themesID"];
						}
					else
						{
						$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"] = 1;
						}
					}
				else
					{
					$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"] = 1;
					}
				$_SESSION["status_core_themesFilterID"] = $_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"];
				jumpToPage("index.php");
				}
			}
		}
	else
		{
		if ($config[$config["modulSelect"]]["layoutMainHTMLNo"]!=1 && isset($config["modulSelect"]) && !empty($config["modulSelect"]))
			{
			coreUsersConfigSet($config,"modulSelect",$config["modulSelect"]);
			}
		switch ($config["modulAction"])
			{
			case "list":
				{
				unset($_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."firstPage"]);
				unset($_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."lastPage"]);
				unset($_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."modulPage"]);
				unset($_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."errorPage"]);
				if (isset($_SESSION["whichModul"]))
					{
					$config[$config["modulSelect"]]["whichBack"] .= "&modulSelect=".$_SESSION["whichModul"]."&cmd=resetall";
					}
				if (isset($config["layoutFullBack"]))
					{
					$config[$config["modulSelect"]]["whichBack"] = $config["layoutFullBack"];
					}
				
				if (!isset($config[$config["modulSelect"]]["displayRecs"]) || empty($config[$config["modulSelect"]]["displayRecs"]))
					{
					$config[$config["modulSelect"]]["displayRecs"]=$config["configShare"]["displayRecs"];
					}
				if (!isset($config[$config["modulSelect"]]["recRange"]) || empty($config[$config["modulSelect"]]["recRange"]))
					{
					$config[$config["modulSelect"]]["recRange"]=$config["configShare"]["recRange"];
					}
				$config[$config["modulSelect"]]["startRec"]=1;
				$config[$config["modulSelect"]]["advancedSearch"]="";
				$config[$config["modulSelect"]]["basicSearch"]="";
				$config[$config["modulSelect"]]["pSearchOriginal"]="";
				$config[$config["modulSelect"]]["searchWhere"]="";
				$config[$config["modulSelect"]]["dbwhere"]="";
				$config[$config["modulSelect"]]["whereClause"]="";
				$config[$config["modulSelect"]]["masterDetailWhere"] = "";
				$config[$config["modulSelect"]]["OrderBy"] = "";
				$config[$config["modulSelect"]]["GroupBy"] = "";
				require_once ($config["configShare"]["modulFrameIncludePath"]."list.inc.php");
				$config = modulSimpleList($config,$viewItem);
				break;
				}
			case "view":
				{
				if (!isModulView($config,$config["modulSelect"])) jumpToPage($config[$config["modulSelect"]]["whichBack"]);
				$config = header1($config);
				if (empty($config["getAction"]))
					{
					$config["getAction"] = "I";	// display
					$config["key"] = $config["modulRecordID"];
					}
				else
					{
					$config["key"] = @$_POST["key"];
					}
				$config["x_errorText"]="";
				$config["x_fieldFocus"]="";
				$config[$config["modulSelect"]]["whichCFG"]="inputCFG";
				$config[$config["modulSelect"]]["whichForm"]="inputForm";
				$config[$config["modulSelect"]]["whichCheck"]="checkCFG";
				$config[$config["modulSelect"]]["whichPosition"]="positionCFG";
				$config[$config['modulSelect']]['readonly']='readonly="readonly"';
				$config[$config['modulSelect']]['disabled']='disabled="disabled"';
				require_once ($config["configShare"]["modulFrameIncludePath"]."view.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."input.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."check.inc.php");
				$config = modulFrameView($config, $viewItem);
				break;
				}
			case "add":
				{
				if (!isModulAdd($config,$config["modulSelect"])) jumpToPage($config[$config["modulSelect"]]["whichBack"]);
				$config = header1($config);
				if (empty($config["getAction"]))
					{
					$config["key"] = $config["modulRecordID"];
					$config[$config["modulSelect"]]["key"] = $config["key"];
					if ($config[$config["modulSelect"]]["key"] <> "")
						{
						$config["getAction"] = "C"; // copy record
						}
					else
						{
						$config["getAction"] = "I"; // display blank record
						}
					}
				else
					{
					$config["key"] = @$_POST["key"];
					}
				$config["x_errorText"]="";
				$config["x_fieldFocus"]="";
				$config[$config["modulSelect"]]["whichCFG"]="inputCFG";
				$config[$config["modulSelect"]]["whichForm"]="inputForm";
				$config[$config["modulSelect"]]["whichCheck"]="checkCFG";
				$config[$config["modulSelect"]]["whichPosition"]="positionCFG";
				$config[$config['modulSelect']]['readonly']='';
				$config[$config['modulSelect']]['disabled']='';
				require_once ($config["configShare"]["modulFrameIncludePath"]."add.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."input.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."check.inc.php");
				$config = modulFrameAdd($config, $viewItem);
				break;
				}
			case "edit":
				{
				if (!isModulEdit($config,$config["modulSelect"])) jumpToPage($config[$config["modulSelect"]]["whichBack"]);
				$config = header1($config);
				if (empty($config["getAction"]))
					{
					$config["getAction"] = "I";	//display with input box
					$config["key"] = $config["modulRecordID"];
					}
				else
					{
					$config["key"] = @$_POST["key"];
					}
				$config["x_errorText"]="";
				$config["x_fieldFocus"]="";
				$config[$config["modulSelect"]]["whichCFG"]="inputCFG";
				$config[$config["modulSelect"]]["whichForm"]="inputForm";
				$config[$config["modulSelect"]]["whichCheck"]="checkCFG";
				$config[$config["modulSelect"]]["whichPosition"]="positionCFG";
				$config[$config['modulSelect']]['readonly']='';
				$config[$config['modulSelect']]['disabled']='';
				require_once ($config["configShare"]["modulFrameIncludePath"]."edit.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."input.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."check.inc.php");
				$config = modulFrameEdit($config, $viewItem);
				break;
				}
			case "mydata":
				{
				if (!isModulEdit($config,$config["modulSelect"])) jumpToPage($config[$config["modulSelect"]]["whichBack"]);
				$config = header1($config);
				if (empty($config["getAction"]))
					{
					$config["getAction"] = "I";	//display with input box
					$config["key"] = $config["modulRecordID"];
					}
				else
					{
					$config["key"] = @$_POST["key"];
					}
				$config["x_errorText"]="";
				$config["x_fieldFocus"]="";
				$config[$config["modulSelect"]]["whichCFG"]="inputCFG";
				$config[$config["modulSelect"]]["whichForm"]="inputForm";
				$config[$config["modulSelect"]]["whichCheck"]="checkCFG";
				$config[$config["modulSelect"]]["whichPosition"]="positionCFG";
				require_once ($config["configShare"]["modulFrameIncludePath"]."edit.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."input.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."check.inc.php");
				$config = modulFrameEdit($config, $viewItem);
				break;
				}
			case "passchange":
				{
				if (!isModulEdit($config,$config["modulSelect"])) jumpToPage($config[$config["modulSelect"]]["whichBack"]);
				$config = header1($config);
				if (empty($config["getAction"]))
					{
					$config["getAction"] = "I";	//display with input box
					$config["key"] = $config["modulRecordID"];
					}
				else
					{
					$config["key"] = @$_POST["key"];
					}
				$config["x_errorText"]="";
				$config["x_fieldFocus"]="";
				$config[$config["modulSelect"]]["whichCFG"]="passchangeCFG";
				$config[$config["modulSelect"]]["whichForm"]="passchangeForm";
				$config[$config["modulSelect"]]["whichCheck"]="checkPasschangeCFG";
				$config[$config["modulSelect"]]["whichPosition"]="positionPasschangeCFG";
				require_once ($config["configShare"]["modulFrameIncludePath"]."edit.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."input.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."check.inc.php");
				$config = modulFrameEdit($config, $viewItem);
				break;
				}
			case "import":
				{
				if (!isModulAdd($config,$config["modulSelect"])) jumpToPage($config[$config["modulSelect"]]["whichBack"]);
				$config = header1($config);
				if (empty($config["getAction"]))
					{
					$config["getAction"] = "I"; // display blank record
					}
				$config["x_errorText"]="";
				$config["x_fieldFocus"]="";
				$config[$config["modulSelect"]]["whichCFG"]="importCFG";
				$config[$config["modulSelect"]]["whichForm"]="importForm";
				$config[$config["modulSelect"]]["whichCheck"]="checkImportCFG";
				$config[$config["modulSelect"]]["whichPosition"]="positionImportCFG";
//				$config[$config["modulSelect"]]["importTable"]="core_import";
				require_once ($config["configShare"]["modulFrameIncludePath"]."add.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."input.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."check.inc.php");
				$config = modulFrameAdd($config, $viewItem);
				break;
				}
			case "pdf":
				{
				if (!isModulAdd($config,$config["modulSelect"])) jumpToPage($config[$config["modulSelect"]]["whichBack"]);
				$config = header1($config);
				if (empty($config["getAction"]))
					{
					$config["getAction"] = "I"; // display blank record
					}
				$config["x_errorText"]="";
				$config["x_fieldFocus"]="";
				$config[$config["modulSelect"]]["whichCFG"]="pdfCFG";
				$config[$config["modulSelect"]]["whichForm"]="pdfForm";
				$config[$config["modulSelect"]]["whichCheck"]="";
				$config[$config["modulSelect"]]["whichPosition"]="";
				require_once ($config["configShare"]["modulFrameIncludePath"]."pdf.inc.php");
				$config = modulFramePDF($config, $viewItem);
				break;
				}
			case "delete":
				{
				if (!isModulDelete($config,$config["modulSelect"])) jumpToPage($config[$config["modulSelect"]]["whichBack"]);
				$config = header1($config);
				if (empty($config["getAction"]))
					{
					$config["getAction"] = "I";	// display
					$config["key"] = $config["modulRecordID"];
					}
				else
					{
					$config["key"] = @$_POST["key"];
					}
				$config[$config['modulSelect']]['readonly']='readonly="readonly"';
				$config[$config['modulSelect']]['disabled']='disabled="disabled"';
				require_once ($config["configShare"]["modulFrameIncludePath"]."view.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."delete.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."input.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."check.inc.php");
				$config = modulFrameDelete($config, $viewItem);
				break;
				}
			case "deleteGroup":
				{
				if (!isModulDelete($config,$config["modulSelect"])) jumpToPage($config[$config["modulSelect"]]["whichBack"]);
				$config = header1($config);
				if (empty($config["getAction"]))
					{
					$config["getAction"] = "I";	// display
					$config["key"] = $config["modulRecordID"];
					}
				else
					{
					$config["key"] = @$_POST["key"];
					}
				require_once ($config["configShare"]["modulFrameIncludePath"]."view.inc.php");
				require_once ($config["configShare"]["modulFrameIncludePath"]."delete.inc.php");
				$config = modulFrameDeleteGroup($config, $viewItem);
				break;
				}
			}
		}
	$config["contentHTML"] = clearForm($config, $config["contentHTML"], $viewItem);
	return $config;
	}
// modulframe head stop
?>
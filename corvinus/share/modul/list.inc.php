<?php
// Modulframe list Begin
function modulSimpleList($config, $viewItem)
	{
	if (!empty($config[$config["modulSelect"]."changeYesNo"]))
		{
		$rightsDIM = array("allowview","allowadd","allowedit","allowdelete","allowadmin");
		if(in_array($config[$config["modulSelect"]."changeYesNo"],$rightsDIM))
			{
			$w_actual_datetime = db_actual_datetime();
			$x_key_record = $config[$config["modulSelect"]."changeRecord"];
			$selectRightsSQL = "SELECT * FROM " . $config[$config["modulSelect"]."modulTable"] . " WHERE id=" . $x_key_record;
			$selectRights=$config["dbConnect"]->prepare($selectRightsSQL);
			$selectRights->execute();
			if (($row = $selectRights->fetch()))
				{
				// get the field contents
				$p_rights_id = @$row["rights_id"]; 
				$p_allrecs = @$row["allrecs"];
				switch ($config[$config["modulSelect"]."changeYesNo"])
					{
					case "allowview":
						if ((@$row["allrecs"] & ewAllowView) == ewAllowView && $config[$config["modulSelect"]."actPermission"] == '1') {$p_allrecs -= 8;} 
						else if (!(@$row["allrecs"] & ewAllowView) == ewAllowView && $config[$config["modulSelect"]."actPermission"] == '0') {$p_allrecs += 8;};
						break;
					case "allowadd": 	
						if ((@$row["allrecs"] & ewAllowAdd) == ewAllowAdd && $config[$config["modulSelect"]."actPermission"] == '1') {$p_allrecs -= 1;} 
						else if (!(@$row["allrecs"] & ewAllowAdd) == ewAllowAdd && $config[$config["modulSelect"]."actPermission"] == '0') {$p_allrecs += 1;};
						break;
					case "allowedit": 
						if ((@$row["allrecs"] & ewAllowEdit) == ewAllowEdit && $config[$config["modulSelect"]."actPermission"] == '1') {$p_allrecs -= 4;} 
						else if (!(@$row["allrecs"] & ewAllowEdit) == ewAllowEdit && $config[$config["modulSelect"]."actPermission"] == '0') {$p_allrecs += 4;};
						break;
					case "allowdelete": 
						if ((@$row["allrecs"] & ewAllowDelete) == ewAllowDelete && $config[$config["modulSelect"]."actPermission"] == '1') {$p_allrecs -= 2;} 
						else if (!(@$row["allrecs"] & ewAllowDelete) == ewAllowDelete && $config[$config["modulSelect"]."actPermission"] == '0') {$p_allrecs += 2;};
						break;	
					case "allowadmin": 
						if ((@$row["allrecs"] & ewAllowAdmin) == ewAllowAdmin && $config[$config["modulSelect"]."actPermission"] == '1') {$p_allrecs -= 16;} 
						else if (!(@$row["allrecs"] & ewAllowAdmin) == ewAllowAdmin && $config[$config["modulSelect"]."actPermission"] == '0') 	{$p_allrecs += 16;};
						break;
					}
				$updateRightsSQL = "UPDATE " . $config[$config["modulSelect"]."modulTable"] . " SET ";
				$updateRightsSQL .= "allrecs = ".$p_allrecs;			
				$updateRightsSQL .= " WHERE id= '".$x_key_record."'";
				$config["dbConnect"]->exec($updateRightsSQL);
				}
			}
		else
			{
			$w_actual_datetime = "'".db_actual_datetime()."'";
			$x_key_record = $config[$config["modulSelect"]."changeRecord"];
			$x_actPermission = intval($config[$config["modulSelect"]."actPermission"]);
			if ($x_actPermission != 1)
				{
				$x_newPermission = 1;
				}
			else
				{
				$x_newPermission = 0;
				}
			$updateSQL = "UPDATE " . $config[$config["modulSelect"]."modulTable"] . " SET ";
			$updateSQL .= "modifyUserID = ".@$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]. ",";			
			$updateSQL .= "modifyWhen = ".$w_actual_datetime.",";			
			$updateSQL .= $config[$config["modulSelect"]."changeYesNo"]."=".$x_newPermission;			
			$updateSQL .= " WHERE id= '".$x_key_record."'";
			$config["dbConnect"]->exec($updateSQL);
			}
		}

	if (isset($_GET["prev_key"]))
		{
		$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."_prev_key"] = $_GET["prev_key"];
		}
	$searchFilterSQL = "";

	$searchFilterCFG = iniCFGParser($config["configShare"]["iniCFG"],"##listFilterCFG##","##/listFilterCFG##");
	$searchFilterCFG .= iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##listFilterCFG##","##/listFilterCFG##");
	$searchFilterItemCFG = explode('<#>',$searchFilterCFG);
	for ($searchFilterItemCFGCount=0;$searchFilterItemCFGCount<count($searchFilterItemCFG);$searchFilterItemCFGCount++)
		{
		$searchFilterItemFieldCFG = explode('<=>',trim($searchFilterItemCFG[$searchFilterItemCFGCount]));
		switch ($searchFilterItemFieldCFG[0])
			{
			case "simple":
				if (isset($_REQUEST[$searchFilterItemFieldCFG[2]]))
					{
					$s_itemValues[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]]=$_REQUEST[$searchFilterItemFieldCFG[2]];
					$_SESSION[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]]=$s_itemValues[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]];
					$s_itemValues[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]."_filter"]=$_REQUEST[$searchFilterItemFieldCFG[2]."_filter"];
					$_SESSION[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]."_filter"]=$s_itemValues[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]."_filter"];
					}
				else if (isset($_SESSION[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]]))
					{
					$s_itemValues[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]]=$_SESSION[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]];
					$s_itemValues[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]."_filter"]=$_SESSION[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]."_filter"];
					}
				$config[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]."_filter"]=
					selectFilterMake($config,$config['configShare'][$searchFilterItemFieldCFG[3]],$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]."_filter");
				$config[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]]=$s_itemValues[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]];
				$searchFilterSQL .= selectFilterCreate($config,$searchFilterSQL,str_replace("s_","",$searchFilterItemFieldCFG[2]),$s_itemValues[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]."_filter"],$s_itemValues[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]]);
				break;
			case "checkbox":
				if (isset($_POST[$searchFilterItemFieldCFG[1]])) {
					if ($_POST[$searchFilterItemFieldCFG[1]]==1) {
						$s_itemValues[$searchFilterItemFieldCFG[1]]=" checked";
						$itemValues[$searchFilterItemFieldCFG[1]]=" checked";
					} else {
						$s_itemValues[$searchFilterItemFieldCFG[1]]="";
						$itemValues[$searchFilterItemFieldCFG[1]]="";
					}
//					$_SESSION[$config["modulSelect"]."_".$searchFilterItemFieldCFG[1]]=$s_itemValues[$searchFilterItemFieldCFG[1]];
				} else if (isset($_SESSION[$config["modulSelect"]."_".$searchFilterItemFieldCFG[1]])) {
//					$s_itemValues[$searchFilterItemFieldCFG[1]]=$_SESSION[$config["modulSelect"]."_".$searchFilterItemFieldCFG[1]];
				}
				break;
			case "fixSelect":
				if (isset($_REQUEST[$searchFilterItemFieldCFG[2]]))
					{
					$s_itemValues[$searchFilterItemFieldCFG[2]]=$_REQUEST[$searchFilterItemFieldCFG[2]];
					$_SESSION[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]]=$s_itemValues[$searchFilterItemFieldCFG[2]];
					}
				else if (isset($_SESSION[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]]))
					{
					$s_itemValues[$searchFilterItemFieldCFG[2]]=$_SESSION[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]];
					}
				$fixSelect = "<option value=\"\">".setConfigValue($config,$config["modulSelect"],"itemSelectTitle")."</option>";
				$sql = 'SHOW COLUMNS FROM '.$searchFilterItemFieldCFG[1].' WHERE field="'.str_replace("s_","",$searchFilterItemFieldCFG[2]).'"';
				$sqlw=$config["dbConnect"]->prepare($sql);
				$sqlw->execute();
				$row=$sqlw->fetch(PDO::FETCH_ASSOC);
				foreach(explode("','",substr($row['Type'],6,-2)) as $option)
					{
					$fixSelect.="<option value='".$option."'";
					if ($option == $s_itemValues[$searchFilterItemFieldCFG[2]] )
						{
						$fixSelect .= " selected";
						}
					$fixSelect .= ">".$option."</option>";
					}				
				$config[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]]=$fixSelect;
				if (!empty($s_itemValues[$searchFilterItemFieldCFG[2]]))
					{
					if (!empty($searchFilterSQL))
						{
						$searchFilterSQL .= " AND ";
						}
					$searchFilterItemFieldCFG[2] = str_replace("left_s_","",$searchFilterItemFieldCFG[2]);
					$searchFilterSQL .= str_replace("s_","",$searchFilterItemFieldCFG[2])."='".$s_itemValues[$searchFilterItemFieldCFG[2]]."'";
					}
				break;
			case "optionSelect":
				if (isset($_REQUEST[$searchFilterItemFieldCFG[2]]))
					{
					$s_itemValues[$searchFilterItemFieldCFG[2]]=$_REQUEST[$searchFilterItemFieldCFG[2]];
					$_SESSION[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]]=$s_itemValues[$searchFilterItemFieldCFG[2]];
					}
				else if (isset($_SESSION[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]]))
					{
					$s_itemValues[$searchFilterItemFieldCFG[2]]=$_SESSION[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]];
					}
				if (isset($searchFilterItemFieldCFG[6]) && !empty($searchFilterItemFieldCFG[6])) {$styleWidth = ' style="width:'.$searchFilterItemFieldCFG[6].'px;"';} else {$styleWidth = '';}
				if (isset($searchFilterItemFieldCFG[8]) && !empty($searchFilterItemFieldCFG[8])) {$topicFilter=$searchFilterItemFieldCFG[8];} else {$topicFilter="";}
				$config[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]]=optionSelect($config,$searchFilterItemFieldCFG[1],$searchFilterItemFieldCFG[2],$searchFilterItemFieldCFG[3],$searchFilterItemFieldCFG[4],$s_itemValues,$config["modulSelect"]."_".$searchFilterItemFieldCFG[3],$topicFilter);
				if (!empty($s_itemValues[$searchFilterItemFieldCFG[2]]))
					{
					if (!empty($searchFilterSQL))
						{
						$searchFilterSQL .= " AND ";
						}
					$searchFilterItemFieldCFG[2] = str_replace("left_s_","",$searchFilterItemFieldCFG[2]);
					$searchFilterSQL .= substr($searchFilterItemFieldCFG[2],2)."='".$s_itemValues[$searchFilterItemFieldCFG[2]]."'";
					}
				break;
			case "optionSelectShare":
/*
				$selectFilter = explode(',',trim($config['configShare'][$searchFilterItemFieldCFG[7]]));
				$filterSelect = "<option value=\"\">".$config["configShare"]["itemSelectTitle"]."</option>";
				$filterActual = "";
				foreach($selectFilter as $option)
					{
					$filterSelect.="<option value='".$option."'";
					if ($option == $_POST[$searchFilterItemFieldCFG[2]."_filter"] )
						{
						$filterSelect .= " selected";
						$filterActual = $option;
						}
					$filterSelect .= ">".$option."</option>";
					}				
				$config[$config["modulSelect"]."_".$searchFilterItemFieldCFG[2]."_filter"]=$filterSelect;
				if (isset($_REQUEST[$searchFilterItemFieldCFG[2]]))
					{
					$s_itemValues[$searchFilterItemFieldCFG[2]]=$_REQUEST[$searchFilterItemFieldCFG[2]];
					$_SESSION[$searchFilterItemFieldCFG[2]]=$s_itemValues[$searchFilterItemFieldCFG[2]];
					}
				else if (isset($_SESSION[$searchFilterItemFieldCFG[2]]))
					{
					$s_itemValues[$searchFilterItemFieldCFG[2]]=$_SESSION[$searchFilterItemFieldCFG[2]];
					}
				if (isset($searchFilterItemFieldCFG[6]) && !empty($searchFilterItemFieldCFG[6])) {$styleWidth = ' style="width:'.$searchFilterItemFieldCFG[6].'px;"';} else {$styleWidth = '';}
				if (isset($searchFilterItemFieldCFG[8]) && !empty($searchFilterItemFieldCFG[8])) {$topicFilter=$searchFilterItemFieldCFG[8];} else {$topicFilter="";}
				$config["configShare"]["configShare_".$searchFilterItemFieldCFG[2]]=optionSelect($config,$searchFilterItemFieldCFG[1],$searchFilterItemFieldCFG[2],$searchFilterItemFieldCFG[3],$searchFilterItemFieldCFG[4],$s_itemValues,$config["modulSelect"]."_".$searchFilterItemFieldCFG[1], $topicFilter);
				if (!empty($s_itemValues[$searchFilterItemFieldCFG[2]]))
					{
					if (!empty($searchFilterSQL))
						{
						$searchFilterSQL .= " AND ";
						}
					$searchFilterItemFieldCFG[2] = str_replace("left_s_","",$searchFilterItemFieldCFG[2]);
					$searchFilterSQL .= str_replace("s_","",$searchFilterItemFieldCFG[2])." ".$filterActual." '".$s_itemValues[$searchFilterItemFieldCFG[2]]."'";
					}
*/
				break;
			}
		}
	if (isset($searchFilterSQL))
		{
		$_SESSION[$config["modulSelect"]."searchFilterSQL"]=$searchFilterSQL;
		}
	// get search criteria for advanced search
	$config = basicSearch($config);
	$config = buildSearch($config);
	$config = saveSearch($config);
	$config = clearSearch($config);	
	$config = buildWhere($config);
	if (isset($config[$config["modulSelect"]]["pSearch"]) && !empty($config[$config["modulSelect"]]["pSearch"]))
		{
		$config["calendarType"]="journal";
		$config["calendarListType"]="journal";

		unset($_SESSION["calendarSelectedDay"]);
		unset($_SESSION["calendarSelectedDate"]);
		unset($_SESSION["calendarWeek"]);
		unset($_SESSION["calendarYear"]);
		unset($_SESSION["calendarMonth"]);

		}
	if (isset($config[$config["modulSelect"]]["dbwhere"]))
		{
		$_SESSION[$config["modulSelect"]."dbwhere"]=$config[$config["modulSelect"]]["dbwhere"];
		}

	if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] != 1 && $config["modulSelect"] == "products") {

		$config["configShare"]["configShare_s_own"]="";
		$s_itemValues["products_s_own"]="";
		$s_itemValues["s_own"]="";
		if ($_POST["s_own"] && $_POST["s_own"]=="1") {
			$s_itemValues["products_s_own"]=" checked";
			$s_itemValues["s_own"]=" checked";
			$config["configShare"]["configShare_s_own"]=" checked";
		}
	}
	$searchFilterForm = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##listFilterForm##","##/listFilterForm##");
	$config["listFilterHTML"] = parseContent($searchFilterForm,$config,$itemValues);
	$config["listFilterHTML"] = clearForm($config, $config["listFilterHTML"], $viewItem);

	$config["configShare"]["searchFileterOff"] = "";
	if ((!empty($config[$config["modulSelect"]]["sqlfilter"]) && $config["sqlfilter"] <> "ALL") || !empty($config[$config["modulSelect"]]["searchWhere"]))
		{
		$config["configShare"]["searchFileterOff"] .= '<div id="searchButton2">';
  		$config["configShare"]["searchFileterOff"] .= "<button class='buttonBox' id='subMenuHeight24' title='".$config["configShare"]["searchOffTitle"]."' name='modulOperation' type='submit' value='list::".$config["modulSelect"]."::RESETFILTER'><span class='glyphicon glyphicon-remove' style='color:red;' aria-hidden='true'></span></button>";
		$config["configShare"]["searchFileterOff"] .= "</div>";
		}
	$topSearchBasicForm = iniCFGParser($config["sharedTPL"]["iniCFG"],"##topSearchBasicForm##","##/topSearchBasicForm##");
	$config["topSearchBasicHTML"] = parseContent($topSearchBasicForm,$config,"");
	$searchFilterFullForm = iniCFGParser($config["sharedTPL"]["iniCFG"],"##listFilterForm##","##/listFilterForm##");
	$searchFilterFullForm = parseContent($searchFilterFullForm,$config,"");
	if ($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_User"] == setConfigValue($config,"configShare","guestUser"))
		{
		$viewItem["configShare_x_insertUserID"]=0;
		$viewItem["configShare_x_searchFilter"]=1;
		}
	else
		{
		$viewItem["configShare_x_insertUserID"]=0;
		$viewItem["configShare_x_searchFilter"]=1;
		}
	$searchFilterFullForm = parseContent($searchFilterFullForm,$config,"");
	$searchFilterFullForm = clearForm($config, $searchFilterFullForm, $viewItem);
	$config["listFilterFullHTML"]=$searchFilterFullForm;

	// default order
	$config[$config["modulSelect"]]["defaultOrder"] = setConfigValue($config,$config["modulSelect"],"defaultOrder");
	if ($config["modulSelect"] != "userslog")
		{
		if (empty($config[$config["modulSelect"]]["defaultOrder"])) $config[$config["modulSelect"]]["defaultOrder"] = "insertWhen";
		}
	else
		{
		if (empty($config[$config["modulSelect"]]["defaultOrder"])) $config[$config["modulSelect"]]["defaultOrder"] = "actionWhen";
		}
	$config[$config["modulSelect"]]["defaultOrderType"] = setConfigValue($config,$config["modulSelect"],"defaultOrderType");
	if (empty($config[$config["modulSelect"]]["defaultOrderType"])) $config[$config["modulSelect"]]["defaultOrderType"] = "DESC";

	// default filter
	if (!empty($searchFilterSQL))
		{
		$config[$config["modulSelect"]]["defaultFilter"]=$searchFilterSQL;
		}
	else
		{
		$config[$config["modulSelect"]]["defaultFilter"]="";
		}
	$defaultFilterCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##defaultFilterCFG##","##/defaultFilterCFG##");
	$defaultFilterNowCFG = explode('<#>',$defaultFilterCFG);
	for ($defaultFilterCFGCount=0;$defaultFilterCFGCount<count($defaultFilterNowCFG);$defaultFilterCFGCount++)
		{
		if (!empty($defaultFilterNowCFG[$defaultFilterCFGCount]))
			{
			if (!empty($config[$config["modulSelect"]]["defaultFilter"]))
				{
				$config[$config["modulSelect"]]["defaultFilter"].=" AND ";
				}
			$config[$config["modulSelect"]]["defaultFilter"].=$defaultFilterNowCFG[$defaultFilterCFGCount];
			}
		$relatedTableItemCFG = explode('<=>',trim($relatedTableCFG[$relatedTableCFGCount]));
		}
	if (isset($_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."_prev_key"]))
		{
		$config[$config["modulSelect"]]["prevTable"]=str_replace("core_","",$config[$config["modulSelect"]]["prevTable"]);
		$config[$config["modulSelect"]]["defaultFilter"] = " (".$config[$config["modulSelect"]]["prevTable"] ."ID=".$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."_prev_key"].")";
		}
	$modulFilterParamDIM = explode('<#>',setConfigValue($config,$config["modulSelect"],"modulFilterParam"));
	for ($filterFieldCount=0;$filterFieldCount<count($modulFilterParamDIM);$filterFieldCount++)
		{
		$modulFilterFieldDIM = explode('#',$modulFilterParamDIM[$filterFieldCount]);
		switch ($modulFilterFieldDIM[0])
			{
			case "modulSelect":
				$config[$config["modulSelect"]]["defaultFilter"].=" ".$modulFilterFieldDIM[1]."='".$config["modulSelect"]."'";
				break;
			case "menu_id":
				if (isset($_SESSION[$config["configShare"]["whichSystemAndMode"]."whichTopSubMenu"]))
					{
					$config[$config["modulSelect"]]["defaultFilter"].=" ".$modulFilterFieldDIM[1]."='".$_SESSION[$config["configShare"]["whichSystemAndMode"]."whichTopSubMenu"]."'";
					}
				$config[$config["modulSelect"]]["defaultFilter"].=" ".$modulFilterFieldDIM[1]."='".$_SESSION[$config["configShare"]["whichSystemAndMode"]."whichTopSubMenu"]."'";
				break;
			default:
				break;
			}
		}
	if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 2 ||
		$_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 3)
		{
		$config[$config["modulSelect"]]["defaultFilter"] .= "";
		}
	else
		{	
		if (!empty($config[$config["modulSelect"]]["defaultFilter"]))
			{
			$config[$config["modulSelect"]]["defaultFilter"].=" AND active=1";
			}
		else
			{
			$config[$config["modulSelect"]]["defaultFilter"].="active=1";
			}
		}
	if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] != 1 && $config["modulSelect"] == "products") {
		$s_itemValues["products_s_own"]="";
/*
		if ($_POST["s_own"] && $_POST["s_own"]=="1") {
			$s_itemValues["products_s_own"]=" checked";
			if (!empty($config[$config["modulSelect"]]["defaultFilter"])) {
				$config[$config["modulSelect"]]["defaultFilter"] .= " AND active=1 AND insertUserID=".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"];
			} else {
				$config[$config["modulSelect"]]["defaultFilter"] .= " active=1 AND insertUserID=".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"];
			}
		}
*/
	}
	
	// default filter
	if ($config["modulSelect"] == "core_messagewall")
		{
		if (!empty($config[$config["modulSelect"]]["defaultFilter"])) {$config[$config["modulSelect"]]["defaultFilter"].=" AND ";} else {$config[$config["modulSelect"]]["defaultFilter"].="";}
		if ($_SESSION[setConfigValue($config,"configShare","whichSystem")."status_UserLevel"] == 2)
			{
			$config[$config["modulSelect"]]["defaultFilter"] .= " (insertUserID=".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"];
			$config[$config["modulSelect"]]["defaultFilter"] .= " OR targetUserID=".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"].")";
			}
		else
			{
			$config[$config["modulSelect"]]["defaultFilter"] .= "active=1 ";
			$config[$config["modulSelect"]]["defaultFilter"] .= " AND (insertUserID=".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"];
			$config[$config["modulSelect"]]["defaultFilter"] .= " OR targetUserID=".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"].")";
			}
		}
	if ($config["modulSelect"] == "core_users")
		{
		// default filter
		if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 2)
			{
//			$config[$config["modulSelect"]]["defaultFilter"] = "";
			}
		else if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 3)
			{
			if (!empty($config[$config["modulSelect"]]["defaultFilter"]))
				{
				$config[$config["modulSelect"]]["defaultFilter"] .= " AND ";
				}
			$config[$config["modulSelect"]]["defaultFilter"] = "core_groupsID=1 OR core_groupsID > 2";
			}
		else  if (@$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"]==1)
			{
			if (!empty($config[$config["modulSelect"]]["defaultFilter"]))
				{
				$config[$config["modulSelect"]]["defaultFilter"] .= " AND ";
				}
			$config[$config["modulSelect"]]["defaultFilter"] = "active=1 AND core_groupsID=1";
			}
		else
			{
			if (!empty($config[$config["modulSelect"]]["defaultFilter"]))
				{
				$config[$config["modulSelect"]]["defaultFilter"] .= " AND ";
				}
			$config[$config["modulSelect"]]["defaultFilter"] = "active=1 AND (core_groupsID=1 OR core_groupsID > 3)";
			}
		}
	if ($config["modulSelect"] == "core_configs")
		{
		if (@$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"] != 2) 
			jumpToPage(setConfigValue($config,"configShare","baseModul"));
		if (isset($_SESSION["whichModul"]))
			{
			if (!empty($config[$_SESSION["whichModul"]]["listBack"]))
				{
				$config[$config["modulSelect"]]["whichBack"] = $config[$_SESSION["whichModul"]]["listBack"];
				}
			else
				{
				$config[$config["modulSelect"]]["whichBack"] = $_SESSION["whichModul"];
				}
			}
		// default filter
		if ($_GET["calltype"]=="all")
			{
			session_unregister("whichModul");
			}
		if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 2)
			{
//			$config[$config["modulSelect"]]["defaultFilter"] = "";
//			if ($_REQUEST["whichModul"]) {$_SESSION["whichModul"]=$_REQUEST["whichModul"];}
//			if ( ISSET($_SESSION["whichModul"]) ) $config[$config["modulSelect"]]["defaultFilter"] = "modul='".$_SESSION["whichModul"]."'";
			}
		else
			{
//			$config[$config["modulSelect"]]["defaultFilter"] = "active=1";
//			if ($_REQUEST["whichModul"]) {$_SESSION["whichModul"]=$_REQUEST["whichModul"];}
//			if ( ISSET($_SESSION["whichModul"]) ) $config[$config["modulSelect"]]["defaultFilter"] = " AND modul='".$_SESSION["whichModul"]."'";
			}
		}
	if (!empty($config[$config["modulSelect"]]["defaultFilter"]))
		{
		if (!empty($plusFilter))
			{
			$config[$config["modulSelect"]]["defaultFilter"] .= " AND ".$plusFilter;
			}
		}
	else
		{
		if (!empty($config[$config["modulSelect"]]["defaultFilter"]) && !empty($plusFilter))
			{
			$config[$config["modulSelect"]]["defaultFilter"] .= " AND ".$plusFilter;
			}
		else
			{
			$config[$config["modulSelect"]]["defaultFilter"] .= $plusFilter;
			}
		}
	$config = checkOrder($config);
	// build SQL
	$relatedTablesCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##relatedTablesCFG##","##/relatedTablesCFG##");
	if (!empty($relatedTablesCFG))
		{
		$config[$config["modulSelect"]]["strSQL"] = "SELECT * FROM (SELECT ".$config[$config["modulSelect"]]["mainTable"].".*,";
//		$config[$config["modulSelect"]]["strSQL"] = "SELECT * FROM (SELECT ".$selectSQLFields.",";
		$relatedTableCFG = explode('<#>',$relatedTablesCFG);
		for ($relatedTableCFGCount=0;$relatedTableCFGCount<count($relatedTableCFG);$relatedTableCFGCount++)
			{
			$relatedTableItemCFG = explode('<=>',trim($relatedTableCFG[$relatedTableCFGCount]));
			$config[$config["modulSelect"]]["strSQL"] .= "(SELECT ".$relatedTableItemCFG[0]." FROM ".$relatedTableItemCFG[1]." WHERE ".$relatedTableItemCFG[2].") AS ".$relatedTableItemCFG[3].$relatedTableItemCFG[4];
			}
		$config[$config["modulSelect"]]["strSQL"] .= " FROM " . $config[$config["modulSelect"]]["mainTable"] .") AS work ";
		}
	else
		{
		$config[$config["modulSelect"]]["strSQL"] = "SELECT * FROM ".$config[$config["modulSelect"]]["mainTable"];
		}
	$config=buildSQL($config);
//echo $config[$config["modulSelect"]]["strSQL"]."<br>";
	$config[$config["modulSelect"]]["resultSQL"] = $config["dbConnect"]->prepare($config[$config["modulSelect"]]["strSQL"]);
	$config[$config["modulSelect"]]["resultSQL"]->execute();
	$config[$config["modulSelect"]]["totalRecs"] = $config[$config["modulSelect"]]["resultSQL"]->rowCount();
	$config=checkStart($config);
	$config = header1($config);
//	if ($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_User"] != setConfigValue($config,"configShare","guestUser"))
//		{
		$config = modulFrameList($config, $viewItem);
//		}
	return $config;
	}

function modulFrameList($config, $viewItem)
	{
	$listPrevHTML = modulListPrev($config, $viewItem);
	$contentListtHTML = $listPrevHTML;
	$listHeadHTML = modulListHead($config, $viewItem);
	if ($config[$config["modulSelect"]]["totalRecs"]==0)
		{
		$viewItem["listBottomNavigation"]=0;
		}
	$contentListtHTML .= $listHeadHTML;
	$config = startList($config);
	if ($config[$config["modulSelect"]]["totalRecs"]>0)
		{
		$config[$config["modulSelect"]]["limitStart"]=$config[$config["modulSelect"]]["startRec"]-1;
		}
	else
		{
		$config[$config["modulSelect"]]["limitStart"]=0;
		}
	$config[$config["modulSelect"]]["strSQLNoLimit"]=$config[$config["modulSelect"]]["strSQL"];
	$_SESSION[$config["modulSelect"]]["strSQLNoLimit"]=$config[$config["modulSelect"]]["strSQL"];
	if (isset($config[$config["modulSelect"]]["listScroll"]) && $config[$config["modulSelect"]]["listScroll"]==1)
		{
		$config[$config["modulSelect"]]["stopRec"]=$config[$config["modulSelect"]]["totalRecs"];
		$config[$config["modulSelect"]]["recCount"]=$config[$config["modulSelect"]]["recCount"];
		$listBoxHeight=$config[$config["modulSelect"]]["listBoxHeight"];
		$contentListtHTML .= '<div style="overflow:auto;max-height:'.$listBoxHeight.';">';
		}
	else
		{
		$config[$config["modulSelect"]]["strSQL"].= " LIMIT ".$config[$config["modulSelect"]]["limitStart"].",".$config[$config["modulSelect"]]["displayRecs"];
		}
	$config[$config["modulSelect"]]["resultSQL"] = $config["dbConnect"]->prepare($config[$config["modulSelect"]]["strSQL"]);
	$config[$config["modulSelect"]]["resultSQL"]->execute();
//echo $config[$config["modulSelect"]]["strSQL"]."<br>";
//die();
if ($config["modulSelect"]!="nocore_reservation" || empty($_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."Type"]) ||
	$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."Type"]=="journal" || $config["calendarType"]=="journalToday")
	{
	while (($config[$config["modulSelect"]]["resultRow"] = $config[$config["modulSelect"]]["resultSQL"]->fetch()) && ($config[$config["modulSelect"]]["recCount"] < $config[$config["modulSelect"]]["stopRec"]))
		{
		if ($config['modulSelect']=='products') {
			$viewItem = productFieldsList($viewItem,$config,$itemValues);
		}
		$config[$config["modulSelect"]]["recCount"]++;	
		if ($config[$config["modulSelect"]]["recCount"] >= $config[$config["modulSelect"]]["startRec"])
			{
			$config[$config["modulSelect"]]["recActual"]++;	

			// load key for record
			$config[$config["modulSelect"]]["key"] = @$config[$config["modulSelect"]]["resultRow"]["id"];
			$itemValues = itemValuesFromDB($config, $config[$config["modulSelect"]]["mainTable"]);
			$itemValues["x_insert_name"] = $config[$config["modulSelect"]]["resultRow"]["insertName"];
			$itemValues["x_insertName"] = $config[$config["modulSelect"]]["resultRow"]["insertName"];
			$itemValues["x_modify_name"] = $config[$config["modulSelect"]]["resultRow"]["modifyName"];
//			$itemValues["x_langName"] = $config[$config["modulSelect"]]["resultRow"]["langName"];
			$itemValuesCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##itemValuesPlus##","##/itemValuesPlus##");
			$itemValuesItemCFG = explode('<#>',$itemValuesCFG);
			for ($itemValuesItemCFGCount=0;$itemValuesItemCFGCount<count($itemValuesItemCFG);$itemValuesItemCFGCount++)
				{
				$itemValues["x_".trim($itemValuesItemCFG[$itemValuesItemCFGCount])] = $config[$config["modulSelect"]]["resultRow"][trim($itemValuesItemCFG[$itemValuesItemCFGCount])];
				}
			if ($config["modulSelect"] == "core_messagewall")
				{
				if ($itemValues["x_insertUserID"] != $_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"])
					{
					$config[$config["modulSelect"]]["noCopy"] = false;
					$config[$config["modulSelect"]]["noEdit"] = true;
					}
				else
					{
					$config[$config["modulSelect"]]["noCopy"] = true;
					$config[$config["modulSelect"]]["noEdit"] = false;
					}
				}
			if (!empty($itemValues["x_bgcolor"]))
				{
				$config[$config["modulSelect"]."_x_fgcolor"]=trim(str_replace("&nbsp;","",$itemValues["x_fgcolor"]));
				$config[$config["modulSelect"]."_x_bgcolor"]=trim($itemValues["x_bgcolor"]);
				$config[$config["modulSelect"]."_x_bgcolor"]="#ff0000;";
				}
			else
				{
				}
			$contentListWideHTML = "";
			$actualImgPath = actualImgPath($config,$itemValues);
			$listCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##listCFG##","##/listCFG##");
			$listItemCFG = explode('<#>',$listCFG);


			if ($config["modulSelect"]!="products") {
				$config[$config["modulSelect"]]["bgcolor"] = 'listLineColor1'; // row color
				$config[$config["modulSelect"]."_"."bgcolor"] = 'listLineColor1'; // row color
				if (($config[$config["modulSelect"]]["recCount"] % 2) <> 0)
					{ // display alternate color for rows
					$config[$config["modulSelect"]]["bgcolor"] = 'listLineColor2'; // row color
					$config[$config["modulSelect"]."_"."bgcolor"] = 'listLineColor2'; // row color
					}
			} else {
				if ($itemValues["x_insertUserID"]==$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]) {
					$config[$config["modulSelect"]]["bgcolor"] = 'listLineColor1'; // row color
					$config[$config["modulSelect"]."_"."bgcolor"] = 'listLineColor1'; // row color
					if (($config[$config["modulSelect"]]["recCount"] % 2) <> 0) { // display alternate color for rows
						$config[$config["modulSelect"]]["bgcolor"] = 'listLineColor2'; // row color
						$config[$config["modulSelect"]."_"."bgcolor"] = 'listLineColor2'; // row color
					}
				} else {
					$config[$config["modulSelect"]]["bgcolor"] = 'notOwn1'; // row color
					$config[$config["modulSelect"]."_"."bgcolor"] = 'notOwn1'; // row color
					if (($config[$config["modulSelect"]]["recCount"] % 2) <> 0) { // display alternate color for rows
						$config[$config["modulSelect"]]["bgcolor"] = 'notOwn2'; // row color
						$config[$config["modulSelect"]."_"."bgcolor"] = 'notOwn2'; // row color
					}
				}

			}
			if (isset($itemValues['x_linebgcolor']) && !empty($itemValues['x_linebgcolor'])) {
				$config[$config["modulSelect"]]["bgcolor"] .= ' '.TRIM($itemValues['x_linebgcolor']);
				$config[$config["modulSelect"]."_"."bgcolor"] .= ' '.TRIM($itemValues['x_linebgcolor']);
			}
			for ($listItemCFGCount=0;$listItemCFGCount<count($listItemCFG);$listItemCFGCount++)
				{
				$listItemFieldCFG = explode('<=>',trim($listItemCFG[$listItemCFGCount]));
				switch ($listItemFieldCFG[0])
					{
					case "simple":
						if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 4 && $listItemFieldCFG[2]=="storageWhere" ) {
							if ($itemValues['x_insertUserID'] == $_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserID"]) {
								$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=$itemValues[$listItemFieldCFG[3]]."&nbsp;";
							} else {
								$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=" - ";
							}
						} else if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 5 && $listItemFieldCFG[2]=="storageWhere" ) {
							if ($itemValues['x_insertUserID'] == $_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserID"]) {
								$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=$itemValues[$listItemFieldCFG[3]]."&nbsp;";
							} else {
								$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=" - ";
							}
						} else if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 5 && $listItemFieldCFG[2]=="price" ) {
							if ($itemValues['x_insertUserID'] == $_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserID"]) {
								$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=$itemValues[$listItemFieldCFG[3]]."&nbsp;";
							} else {
								$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=" - ";
							}
						} else {
							$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=$itemValues[$listItemFieldCFG[3]]."&nbsp;";
						}
						break;
					case "patient":
						if (!empty($itemValues["x_medMaxID"]) || !empty($itemValues["x_nocore_reservationID"]))
							{
							$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]="E";
							}
						$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]].=$itemValues[$listItemFieldCFG[3]]."&nbsp;";
						break;
					case "calendarDateTime":
						$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=substr(FormatDateTime($itemValues[$listItemFieldCFG[3]],8),0,16)."&nbsp;";
						break;
					case "calendarTime":
						$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=substr($itemValues[$listItemFieldCFG[3]],11,5)."&nbsp;";
						break;
					case "thumbView":
						if (!empty($itemValues[$listItemFieldCFG[3]]))
							{
							$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=$actualImgPath.$itemValues[$listItemFieldCFG[3]];
							}
						else
							{
							$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=$config["configShare"]["imageButton"]."nopict.png";
							}
						break;
					case "sealNumber":
						$sealNumberSQL = "SELECT id,name FROM `nocore_doctor` WHERE active=1 AND sealNumber='".$itemValues[$listItemFieldCFG[3]]."'";
						$sealNumberRec=$config["dbConnect"]->prepare($sealNumberSQL);
						$sealNumberRec->execute();
						$sealNumberCount = $sealNumberRec->rowCount();
						if ($sealNumberCount == 0)
							{
							$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=$itemValues[$listItemFieldCFG[3]]."&nbsp;";
							}
						else
							{
							$sealNumberRS=$sealNumberRec->fetch(PDO::FETCH_ASSOC);
							$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=$sealNumberRS["name"]."&nbsp;";
							}

						break;
					case "whereWait":
						$sealNumberSQL = "SELECT id,name FROM `nocore_where` WHERE active=1 AND id='".$itemValues["x_whereWait"]."'";
						$sealNumberRec=$config["dbConnect"]->prepare($sealNumberSQL);
						$sealNumberRec->execute();
						$sealNumberCount = $sealNumberRec->rowCount();
						if ($sealNumberCount == 0)
							{
							$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=$itemValues[$listItemFieldCFG[3]]."&nbsp;";
							}
						else
							{
							$sealNumberRS=$sealNumberRec->fetch(PDO::FETCH_ASSOC);
							$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=$sealNumberRS["name"]."&nbsp;";
							}

						break;

					case "insertTime":
						$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]."Time"]="<b><i>" . substr(FormatDateTime($itemValues["x_insertWhen"],4),0,5) . "</i></b>";
						break;
					case "noWhiteSpace":
						$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=$itemValues[$listItemFieldCFG[3]];
						break;
					case "fullLine":
						if (!empty($itemValues[$listItemFieldCFG[3]]))
							{
							$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=longtextWrapper($config,$itemValues[$listItemFieldCFG[3]]);
							}
						else
							{
							$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]="";
							}
						break;
					case "fullLineFull":
						if (!empty($itemValues[$listItemFieldCFG[3]]))
							{
							$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=longtextView($config,$itemValues[$listItemFieldCFG[3]]);
							}
						else
							{
							$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]="";
							}
						break;
					case "optionView":
						if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 5 && $listItemFieldCFG[5]=="firmName" ) {
							if ($itemValues['insertUserID'] == $_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserID"]) {
								$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=optionView($config,$listItemFieldCFG[2],$listItemFieldCFG[3],$listItemFieldCFG[4],$listItemFieldCFG[5],$itemValues);
							} else {
								$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=" - ";
							}
						} else {
							$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=optionView($config,$listItemFieldCFG[2],$listItemFieldCFG[3],$listItemFieldCFG[4],$listItemFieldCFG[5],$itemValues);
						}
						break;
					case "downloadView":
						$actualImgPath = $config["configShare"]["docrootPath"].$config["configShare"]["imageDirectory"].$config[$config["modulSelect"]]["imgPath"];
						if (!empty($itemValues[$listItemFieldCFG[3]]))
							{
							$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]="<a title='' href='index.php?modulSelect=".$config["modulSelect"]."&amp;id=".$itemValues["x_id"]."&amp;fieldname=".$listItemFieldCFG[3]."&amp;code=".md5($itemValues[$listItemFieldCFG[3]])."' target='_blank'>".pictureView($config, $config["configShare"]["imageButton"]."download.png","","","")."</a>";
							}
						else
							{
							$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]= "&nbsp;";
							}
						$contentListHTML .= "</span></td>";
						break;
					case "active":
						$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=changeYesNo($config, $itemValues,"active",$itemValues["x_active"],setConfigValue($config,"configShare","yesTitle"),setConfigValue($config,"configShare","noTitle"));
						break;
					case "insertwhowhen":
						$itemValues["x_insert_name"] = $config[$config["modulSelect"]]["resultRow"]["insertName"];
						$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]="<b>".$itemValues["x_insert_name"]."<br><i>" . FormatDateTime($itemValues["x_insertWhen"],8) . "</i></b>";
						break;
					case "insertWhen":
						$itemValues["x_insert_name"] = $config[$config["modulSelect"]]["resultRow"]["insertName"];
						$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]="<b><i>" . FormatDateTime($itemValues["x_insertWhen"],8) . "</i></b>";
						break;
					case "allow":
						switch ($listItemFieldCFG[3])
							{
							case "allowview":
								$allowActual = ewAllowView;
								break;
							case "allowadd":
								$allowActual = ewAllowAdd;
								break;
							case "allowedit":
								$allowActual = ewAllowEdit;
								break;
							case "allowdelete":
								$allowActual = ewAllowDelete;
								break;
							case "allowadmin":
								$allowActual = ewAllowAdmin;
								break;
							}	
						$config[$config["modulSelect"]."_x_".$listItemFieldCFG[2]]=changeYesNo($config, $itemValues,$listItemFieldCFG[3],(($itemValues["x_allrecs"] & $allowActual) == $allowActual),$config["configShare"]["yesTitle"],$config["configShare"]["noTitle"]);
						break;
					}
				}
			if (!empty($config[$config["modulSelect"]]["nextModul"]) && isModulView($config,$config[$config["modulSelect"]]["nextModul"]))
				{
				if (($config[$config["modulSelect"]]["key"] != NULL))
					{
					$subOther = "<a title='' href='index.php?modulSelect=".$config[$config["modulSelect"]]["nextModul"]."&amp;modulAction=list&amp;prev_key=" . urlencode($itemValues["x_id"]) . "&amp;".$config[$config["modulSelect"]]["nextModul"]."cmd=reset&amp;table=".$config["modulSelect"]."'>";
					}
				else
					{
					$subOther = "<a title='' href=\"" . "javascript:alert('Invalid Record! Key is null');" . "\">";
					}
				if (isset($config[$config["modulSelect"]]["nextModulIcon"]))
					{
					$subOther .= "<img alt='' src='" . setConfigValue($config,"configShare","imageButton") . $config[$config["modulSelect"]]["nextModulIcon"]."' border='0' name='view' title='".setConfigValue($config,$config["modulSelect"],"nextModulTitle")."' class='buttonBox'></a>";
					}
				else
					{
					$subOther .= "<img alt='' src='" . setConfigValue($config,"configShare","imageButton") . "dictionary.png' border='0' name='view' title='".setConfigValue($config,$config["modulSelect"],"nextModulTitle")."' class='buttonBox'></a>";
					}
				}
			$config[$config["modulSelect"]."_x_submenu"] = $subOther.subMenu($config, $itemValues,$config["modulSelect"]);
			$listItemForm = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##listItemForm##","##/listItemForm##");
			$listItemForm = parseContent($listItemForm,$config,"");
			$config[$config["modulSelect"]."_x_description_enable"]=1;
			if ($viewItem[$config["modulSelect"]."_x_description"] == 1)
				{
				if (empty($itemValues["x_description"]))
					{
					$viewItem[$config["modulSelect"]."_x_description"]=0;
					}
				else
					{
					$viewItem[$config["modulSelect"]."_x_description"]=1;
					}
				}
			$contentItemHTML = clearForm($config, $listItemForm, $viewItem);
			$viewItem[$config["modulSelect"]."_x_description"]=$config[$config["modulSelect"]."_x_description_enable"];
			$contentItemHTML = str_replace('<div id="itemView"></div>','',$contentItemHTML);
			}
		$contentListtHTML .= $contentItemHTML;
		}
	}
else
	{
	require_once ($config["configShare"]["modulFrameIncludePath"]."calendarlist.inc.php");
	}
	if (isset($config[$config["modulSelect"]]["listScroll"]) && $config[$config["modulSelect"]]["listScroll"]==1)
		{
		$contentListtHTML .= "</div>";
		if ($config["modulSelect"]=="nocore_reservation")
			{
			$contentListtHTML .= "</div>";
			}
		}
	$config = navigationNew($config,$config[$config["modulSelect"]]["mainTable"]);
	$config["contentListHTML"] = $contentListtHTML;
	$listHTML = iniCFGParser($config["sharedTPL"]["iniCFG"],"##listForm##","##/listForm##");
	$config["contentHTML"]=parseContent($listHTML,$config,"");
	$config["contentHTML"] = clearForm($config, $config["contentHTML"], $viewItem);
	return $config;
	}
	
function modulListHead($config, $viewItem)
	{
	$listCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##listCFG##","##/listCFG##");
	$listHeaderCFG = explode('<#>',$listCFG);
	for ($listHeaderCFGCount=0;$listHeaderCFGCount<count($listHeaderCFG);$listHeaderCFGCount++)
		{
		$listHeaderFieldCFG = explode('<=>',trim($listHeaderCFG[$listHeaderCFGCount]));
		switch ($listHeaderFieldCFG[1])
			{
			case "simple":
				$config[$config["modulSelect"]."_".$listHeaderFieldCFG[2]."Title"]=$config[$config["modulSelect"]][$listHeaderFieldCFG[2]."Title"];
				break;
			case "order":
				if ($listHeaderFieldCFG[2] != "insertWhen")
					{
					$config[$config["modulSelect"]."_".$listHeaderFieldCFG[2]."Title"]=orderChange($config,$listHeaderFieldCFG[2],$config[$config["modulSelect"]][$listHeaderFieldCFG[2]."Title"]);
					}
				else
					{
					if (empty($config[$config["modulSelect"]][$listHeaderFieldCFG[2]."Title"]))
						{
						$config[$config["modulSelect"]."_".$listHeaderFieldCFG[2]."Title"]=orderChange($config,$listHeaderFieldCFG[2],$config["configShare"]["insertWhenTitle"]);
						}
					else
						{
						$config[$config["modulSelect"]."_".$listHeaderFieldCFG[2]."Title"]=orderChange($config,$listHeaderFieldCFG[2],$config[$config["modulSelect"]][$listHeaderFieldCFG[2]."Title"]);
						}
					}
				break;
			case "selectName":
				$config[$config["modulSelect"]."_".$listHeaderFieldCFG[2]."IDTitle"]=orderChange($config,$listHeaderFieldCFG[2]."Name",$config[$config["modulSelect"]][$listHeaderFieldCFG[2]."IDTitle"]);
				break;
			case "icon":
				if (($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 2 ||
					$_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 3) && setConfigValue($config,"configShare","onlyView") != 1)
					{
					$config[$config["modulSelect"]."_".$listHeaderFieldCFG[2]."Title"]="<div class='buttonBox'><img alt='' src='".$config["configShare"]["imageButton"].setConfigValue($config,$modulSelect,$listHeaderFieldCFG[2]."Button")."' border='0' title='".setConfigValue($config,$config["modulSelect"],$listHeaderFieldCFG[2]."Title")."' class='buttonBox'></div>";
					}
				break;
			}
		}
	$listHeadForm = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##listHeadForm##","##/listHeadForm##");
	$listHeadForm = parseContent($listHeadForm,$config,"");
	$resultHeadHTML = clearForm($config, $listHeadForm, $viewItem);
	return $resultHeadHTML;
	}
// Modulframe list End

function modulListPrev($config, $viewItem)
	{
	if (isset($_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."_prev_key"]))
		{
		$prevSQL = "SELECT *";
		$prevSQL .= " FROM ".$config[$config["modulSelect"]]["prevTable"];
		$prevSQL .= " WHERE (".$config[$config["modulSelect"]]["prevTable"].".id = " . $_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."_prev_key"]  . ")";	
		$prevRec=$config["dbConnect"]->prepare($prevSQL);
		$prevRec->execute();
		$prevCount = $prevRec->rowCount();
		if ($prevCount > 0)
			{
			$prevROW=$prevRec->fetch(PDO::FETCH_ASSOC);
			$listPrevCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##listPrevCFG##","##/listPrevCFG##");
			$listPrevItemCFG = explode('<#>',$listPrevCFG);
			for ($listPrevItemCFGCount=0;$listPrevItemCFGCount<count($listPrevItemCFG);$listPrevItemCFGCount++)
				{
				$listPrevItemFieldCFG = explode('<=>',trim($listPrevItemCFG[$listPrevItemCFGCount]));
				switch ($listPrevItemFieldCFG[0])
					{
					case "simple":
						$config[$config[$config["modulSelect"]]["whichBack"]."_prev_".$listPrevItemFieldCFG[1]."Title"]=$config[$config[$config["modulSelect"]]["whichBack"]][$listPrevItemFieldCFG[1]."Title"];
						$config[$config[$config["modulSelect"]]["whichBack"]."_prev_".$listPrevItemFieldCFG[1]]=$prevROW[$listPrevItemFieldCFG[1]];
						break;
					case "simpleText":
						$config[$config[$config["modulSelect"]]["whichBack"]."_prev_".$listPrevItemFieldCFG[1]."Title"]=$config[$config[$config["modulSelect"]]["whichBack"]][$listPrevItemFieldCFG[1]."Title"];
						$config[$config[$config["modulSelect"]]["whichBack"]."_prev_".$listPrevItemFieldCFG[1]]=$prevROW[$listPrevItemFieldCFG[1]];
						break;
					}
				}
			$key = @$prevROW["id"];
			$config[setConfigValue($config,$config["modulSelect"],"prevTable")]["resultRow"] = $row;
			$prevKey = $_SESSION[$config["modulSelect"]["whichSystemAndMode"].$config["modulSelect"]."sqlKey"];
			$_SESSION[$config["modulSelect"]["whichSystemAndMode"].$config["modulSelect"]."sqlKey"] = $prevKey;
			}
		}
	$listPrevForm = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##listPrevForm##","##/listPrevForm##");
	$resultPrevHTML=parseContent($listPrevForm,$config,"");
	return $resultPrevHTML;
	}

function selectFilterMake($config,$filters,$postFilter)
	{
	$selectFilter = explode(',',trim($filters));
	$filterSelect = "<option value=\"\">".$config["configShare"]["itemSelectTitle"]."</option>";
	foreach($selectFilter as $option)
		{
		$filterSelect.="<option value='".$option."'";
		if ($option == $_SESSION[$postFilter] )
			{
			$filterSelect .= " selected";
			}
		$filterSelect .= ">".$option."</option>";
		}				
	return $filterSelect;
	}				

function selectFilterCreate($config,$searchFilterSQL,$filterField,$filterActual,$filterValue) {
	$searcFilterBack = "";
	switch ($filterActual) {
		case "=":
			if (!empty($filterValue)) {
				if (!empty($searchFilterSQL)) {
					$searchFilterBack .= " AND ";
				}
				$searchFilterBack .= $filterField."='".$filterValue."'";
			}
			break;
		case "<>":
			if (!empty($filterValue)) {
				if (!empty($searchFilterSQL)) {
					$searchFilterBack .= " AND ";
				}
				$searchFilterBack .= $filterField."<>'".$filterValue."'";
			}
			break;
		case "<":
			if (!empty($filterValue)) {
				if (!empty($searchFilterSQL)) {
					$searchFilterBack .= " AND ";
				}
				$searchFilterBack .= $filterField."<'".$filterValue."'";
			}
			break;
		case "<=":
			if (!empty($filterValue)) {
				if (!empty($searchFilterSQL)) {
					$searchFilterBack .= " AND ";
				}
				$searchFilterBack .= $filterField."<='".$filterValue."'";
			}
			break;
		case ">":
			if (!empty($filterValue)) {
				if (!empty($searchFilterSQL)) {
					$searchFilterBack .= " AND ";
				}
				$searchFilterBack .= $filterField.">'".$filterValue."'";
			}
			break;
		case ">=":
			if (!empty($filterValue)) {
				if (!empty($searchFilterSQL)) {
					$searchFilterBack .= " AND ";
				}
				$searchFilterBack .= $filterField.">='".$filterValue."'";
			}
			break;
		case "is null":
			if (!empty($searchFilterSQL)) {
				$searchFilterBack .= " AND ";
			}
			$searchFilterBack .= $filterField." IS NULL";
			break;
		case "is not null":
			if (!empty($searchFilterSQL)) {
				$searchFilterBack .= " AND ";
			}
			$searchFilterBack .= $filterField." IS NOT NULL";
			break;
	}
	return $searchFilterBack;
}
?>
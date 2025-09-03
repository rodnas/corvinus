<?php
function modulFrameView($config, $viewItem)
	{
	$config["deleteReally"]='';
	if (isset($_REQUEST["back"])) {jumpToPage($config[$config["modulSelect"]]["whichBack"]);}
	switch ($config["getAction"])
		{
		case "I": // display
			$itemValues = modulGetRecord($config, $config[$config["modulSelect"]]["mainTable"]);
			$config["x_id"]=$itemValues["x_id"];
			if (($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 2 ||
				$_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 3) && 
				($itemValues["x_isReadWhen"] == 0 || is_null($itemValues["x_isReadWhen"])))
				{
				if ($config["modulSelect"] != "core_messagewall")
					{
					$updateSQL = "UPDATE " . $config["modulSelect"] . " SET ";
					$updateSQL .= "isReadWhen = '".db_actual_datetime()."',";
					$updateSQL .= "isReadUserID = '".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]."'";
					$updateSQL .= " WHERE id=" .$config[$config["modulSelect"]]["key"];
					}
				else
					{
					$updateSQL = "UPDATE " . $config["modulSelect"] . " SET ";
					$updateSQL .= "isReadWhen = '".db_actual_datetime()."'";
					$updateSQL .= " WHERE id=" .$config[$config["modulSelect"]]["key"];
					}
				$config["dbConnect"]->exec($updateSQL);
				}
			break;
		}
	$config["getAction"]="";
	$config["contentViewHTML"] = modulFrameViewRecord($config,$itemValues,"", $viewItem);
	$config["navigationHTML"] = footerNavigation($config);
	if ($config['modulSelect']=='products') {
		$viewItem = productFieldsView($viewItem,$config,$itemValues);
	}
	$viewHTML = iniCFGParser($config["sharedTPL"]["iniCFG"],"##viewForm##","##/viewForm##");
	$config["contentHTML"]=parseContent($viewHTML,$config,$itemValues);
	return $config;
	}

function modulFrameViewRecord($config, $p_itemValues, $p_getAction, $viewItem)
	{
	$viewCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##inputCFG##","##/inputCFG##");
	$config = inputMake($viewCFG,$config,$p_itemValues, $viewItem);
	$viewCFG = iniCFGParser($config["configShare"]["iniCFG"],"##inputCFG##","##/inputCFG##");
	$config = inputMake($viewCFG,$config,$p_itemValues, $viewItem);
//	$viewForm = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##viewForm##","##/viewForm##");
	$viewForm = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##inputForm##","##/inputForm##");
	$viewForm=parseContent($viewForm,$config,"");
	if ($viewItem[$config["modulSelect"]."_x_description"] == 1 && empty($p_itemValues["x_description"]))
		{
		$viewItem[$config["modulSelect"]."_x_description"]=0;
		}
	$resultHTML = clearForm($config, $viewForm, $viewItem);
	$config = modulViewPrev($config, $viewItem);
	return $resultHTML;
	}

function viewMake($viewCFG,$config,$p_itemValues, $viewItem)
	{
	$viewFieldCFG = explode('<#>',$viewCFG);
	$actualImgPath = actualImgPath($config,$p_itemValues);
	for ($viewFieldCFGCount=0;$viewFieldCFGCount<count($viewFieldCFG);$viewFieldCFGCount++)
		{
		$viewItemCFG = explode('<=>',trim($viewFieldCFG[$viewFieldCFGCount]));
		switch ($viewItemCFG[0])
			{
			case "simple":
				if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 4 && $viewItemCFG[1]=="x_storageWhere" ) {
					if ($p_itemValues['x_insertUserID'] == $_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserID"]) {
						$config[$config["modulSelect"]."_".$viewItemCFG[1]]=htmlspecialchars($p_itemValues[$viewItemCFG[1]]);
					} else {
						$config[$config["modulSelect"]."_".$viewItemCFG[1]]=" - ";
					}
				} else if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 5 && $viewItemCFG[1]=="x_storageWhere" ) {
					if ($p_itemValues['x_insertUserID'] == $_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserID"]) {
						$config[$config["modulSelect"]."_".$viewItemCFG[1]]=htmlspecialchars($p_itemValues[$viewItemCFG[1]]);
					} else {
						$config[$config["modulSelect"]."_".$viewItemCFG[1]]=" - ";
					}
				} else if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 5 && $viewItemCFG[1]=="x_price" ) {
					if ($p_itemValues['x_insertUserID'] == $_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserID"]) {
						$config[$config["modulSelect"]."_".$viewItemCFG[1]]=htmlspecialchars($p_itemValues[$viewItemCFG[1]]);
					} else {
						$config[$config["modulSelect"]."_".$viewItemCFG[1]]=" - ";
					}
				} else {
					$config[$config["modulSelect"]."_".$viewItemCFG[1]]=htmlspecialchars($p_itemValues[$viewItemCFG[1]]);
				}
				break;
			case "simpleDateTime":
				$config[$config["modulSelect"]."_".$viewItemCFG[1]]=substr($p_itemValues[$viewItemCFG[1]],0,16)."&nbsp;";
				break;
			case "simpleView":
				$config[$config["modulSelect"]."_".$viewItemCFG[1]]=$p_itemValues[$viewItemCFG[1]];
				break;
			case "insertTime":
				$config[$config["modulSelect"]."_".$viewItemCFG[1]."Time"]="<b><i>" . substr(FormatDateTime($p_itemValues[$viewItemCFG[1]],4),0,5) . "</i></b>";
				break;
			case "optionSelect":
				if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 5 && $viewItemCFG[4]=="firmName" ) {
					if ($p_itemValues['x_insertUserID'] == $_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserID"]) {
						$config[$config["modulSelect"]."_".$viewItemCFG[2]]=optionView($config,$viewItemCFG[1],$viewItemCFG[2],$viewItemCFG[3],$viewItemCFG[4],$p_itemValues);
					} else {
						$config[$config["modulSelect"]."_".$viewItemCFG[2]]=" - ";
					}
				} else {
					$config[$config["modulSelect"]."_".$viewItemCFG[2]]=optionView($config,$viewItemCFG[1],$viewItemCFG[2],$viewItemCFG[3],$viewItemCFG[4],$p_itemValues);
				}
				break;
			case "prevView":
				$config[$config["modulSelect"]."_".$viewItemCFG[1]]=optionView($config,$viewItemCFG[1],$viewItemCFG[2],$viewItemCFG[3],$viewItemCFG[4],$p_itemValues);
				break;
			case "editorText":
				$config[$config["modulSelect"]."_".$viewItemCFG[1]]=$p_itemValues[$viewItemCFG[1]];
				if (empty($viewItemCFG[2]) || intval($viewItemCFG[2]) > 115) $viewItemCFG[2] = 115;
				if (empty($viewItemCFG[3]) || intval($viewItemCFG[3]) > 10) $viewItemCFG[3] = 10;
				break;
			case "checkbox":
				$config[$config["modulSelect"]."_".$viewItemCFG[1]]=activeItem($config,$p_itemValues,$viewItemCFG[1],$config["configShare"]["yesTitle"],$config["configShare"]["noTitle"]);
				break;
			case "simpleText":
				if (empty($viewItemCFG[2])) $viewItemCFG[2] = 60;
				if (empty($viewItemCFG[2])) $viewItemCFG[3] = 10;
				$rows=$viewItemCFG[2];
				$cols=$viewItemCFG[3];
				$config[$config["modulSelect"]."_".$viewItemCFG[1]]=htmlspecialchars($p_itemValues[$viewItemCFG[1]]);
				break;
			case "datePanel":
				$config[$config["modulSelect"]."_".$viewItemCFG[1]]=htmlspecialchars($p_itemValues[$viewItemCFG[1]]);
				break;
			case "pictureView":
				$config[$config["modulSelect"]."_".$viewItemCFG[1]]= pictureView($config, $actualImgPath.$p_itemValues[$viewItemCFG[1]],"",$p_itemValues["x_sizeWidth"],$p_itemValues["x_sizeHeight"]);
				break;
			}
		}
	return $config;
	}

function modulViewPrev($config, $viewItem)
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
?>

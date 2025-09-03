<?php
function modulFrameCheck($config,$p_itemValues, $viewItem)
	{
	$config["x_fieldFocus"]="";
	$checkCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##".$config[$config["modulSelect"]]["whichCheck"]."##","##/".$config[$config["modulSelect"]]["whichCheck"]."##");
	$checkItemsCFG = explode('<#>',$checkCFG);
	for ($checkItemCFGCount=0;$checkItemCFGCount<count($checkItemsCFG);$checkItemCFGCount++)
		{
		$checkItemCFG = explode('<=>',trim($checkItemsCFG[$checkItemCFGCount]));
		if (!ISSET($viewItem[$config["modulSelect"]."_".$checkItemCFG[1]]) || (ISSET($viewItem) && $viewItem[$config["modulSelect"]."_".$checkItemCFG[1]] != 0))
			{
			switch ($checkItemCFG[0])
				{
				case "empty":
					if (isset($p_itemValues[$checkItemCFG[1]]))
						{
						$realString = str_replace("<br>","",$p_itemValues[$checkItemCFG[1]]);
						if (EMPTY($realString))
							{
							$config["x_errorText"] = $config[$config["modulSelect"]][$checkItemCFG[2]."EmptyTitle"];
							$config[$config["modulSelect"]][$checkItemCFG[2]."Title"] = "<span id='errorMessageText'>".$config[$config["modulSelect"]][$checkItemCFG[2]."Title"]."</span>";
							$config[$config["modulSelect"]."_".$checkItemCFG[2]."Label"] = $config["x_errorText"];
							}
						}
					break;
				case "emptyPict":
					if (isset($p_itemValues[$checkItemCFG[1]]))
						{
						$realString = str_replace("<br>","",$p_itemValues[$checkItemCFG[1]]);
						if (EMPTY($realString) && @$_FILES[$checkItemCFG[3]]['name']=="")
							{
							$config["x_errorText"] = $config[$config["modulSelect"]][$checkItemCFG[2]."EmptyTitle"];
							$config[$config["modulSelect"]][$checkItemCFG[2]."Title"] = "<span id='errorMessageText'>".$config[$config["modulSelect"]][$checkItemCFG[2]."Title"]."</span>";
							$config[$config["modulSelect"]."_".$checkItemCFG[2]."Label"] = $config["x_errorText"];
							}
						}
					break;
				case "emptyServer":
					if (isset($p_itemValues[$checkItemCFG[1]]))
						{
						$realString = str_replace("<br>","",$p_itemValues[$checkItemCFG[1]]);
						if (EMPTY($realString) && $p_itemValues["x_core_groupsID"] > 3)
							{
							$config["x_errorText"] = $config[$config["modulSelect"]][$checkItemCFG[2]."EmptyTitle"];
							$config[$config["modulSelect"]][$checkItemCFG[2]."Title"] = "<span id='errorMessageText'>".$config[$config["modulSelect"]][$checkItemCFG[2]."Title"]."</span>";
							$config[$config["modulSelect"]."_".$checkItemCFG[2]."Label"] = $config["x_errorText"];
							}
						}
					break;
				case "email":
					if (!empty($p_itemValues[$checkItemCFG[1]]))
						{ 
						if (!emailValidator($p_itemValues[$checkItemCFG[1]]))
							{
							$config["x_errorText"] = $config[$config["modulSelect"]][$checkItemCFG[2]."EmptyTitle"];
							$config[$config["modulSelect"]][$checkItemCFG[2]."Title"] = "<span id='errorMessageText'>".$config[$config["modulSelect"]][$checkItemCFG[2]."Title"]."</span>";
							$config[$config["modulSelect"]."_".$checkItemCFG[2]."Label"] = $config["x_errorText"];
							}
						}
					break;
				case "duplicate":
					if (!empty($p_itemValues[$checkItemCFG[1]]))
						{ 
						if ($config["modulAction"] == "add")
							{
							$modulCheckFieldParamDIM = explode(',',$checkItemCFG[3]);
							$strSQL = "SELECT * FROM " . $config[$config["modulSelect"]]["mainTable"] . " WHERE";
							$firstField = 1;
							for ($checkFieldParamCount=0;$checkFieldParamCount<count($modulCheckFieldParamDIM);$checkFieldParamCount++)
								{
								if ($firstField == 0)
									{
									$strSQL .= " AND ";
									}
								else
									{
									$firstField = 0;
									}
								$modulCheckValueParamDIM = explode(';',$modulCheckFieldParamDIM[$checkFieldParamCount]);
								$strSQL .= " ".$modulCheckValueParamDIM[0] . "'".$p_itemValues[$modulCheckValueParamDIM[1]]."'";
								}						
							}
						else if ($config["modulAction"] == "edit")
							{
							$modulCheckFieldParamDIM = explode(',',$checkItemCFG[4]);
							$strSQL = "SELECT * FROM " . $config[$config["modulSelect"]]["mainTable"] . " WHERE";
							$firstField = 1;
							for ($checkFieldParamCount=0;$checkFieldParamCount<count($modulCheckFieldParamDIM);$checkFieldParamCount++)
								{
								if ($firstField == 0)
									{
									$strSQL .= " AND ";
									}
								else
									{
									$firstField = 0;
									}
								$modulCheckValueParamDIM = explode(';',$modulCheckFieldParamDIM[$checkFieldParamCount]);
								$strSQL .= " ".$modulCheckValueParamDIM[0] . "'".$p_itemValues[$modulCheckValueParamDIM[1]]."'";
								}						
							}
						$duplicate=$config["dbConnect"]->prepare($strSQL);
						$duplicate->execute();
						$duplicateCount = $duplicate->rowCount();
						if ($duplicateCount != 0)
							{	
							$config["x_errorText"] = $config[$config["modulSelect"]][$checkItemCFG[2]."DuplicateTitle"];
							$config[$config["modulSelect"]][$checkItemCFG[1]."Title"] = "<span id='errorMessageText'>".$config[$config["modulSelect"]][$checkItemCFG[2]."Title"]."</span>";
							$config[$config["modulSelect"]."_".$checkItemCFG[2]."Label"] = $config["x_errorText"];
							}
						}
					break;
				case "oldpassword":
					if (isset($p_itemValues[$checkItemCFG[1]]))
						{
						$realString = str_replace("<br>","",$p_itemValues[$checkItemCFG[1]]);
						if (EMPTY($realString))
							{
							$config["x_errorText"] = $config[$config["modulSelect"]][$checkItemCFG[2]."EmptyTitle"];
							$config[$config["modulSelect"]][$checkItemCFG[2]."Title"] = "<span id='errorMessageText'>".$config[$config["modulSelect"]][$checkItemCFG[2]."Title"]."</span>";
							$config[$config["modulSelect"]."_".$checkItemCFG[2]."Label"] = $config["x_errorText"];
							}
						else
							{
							$strSQL = "SELECT * FROM " . $config["modulSelect"] . " WHERE id=".$config["key"]." AND password='" . $p_itemValues["x_oldpassword"] . "'";
							$core_usersRec=$config["dbConnect"]->prepare($strSQL);
							$core_usersRec->execute();
							$core_usersCount = $core_usersRec->rowCount();
							if ($core_usersCount == 0) 
								{
								$config["x_errorText"] = $config[$config["modulSelect"]][$checkItemCFG[2]."BadTitle"];
								$config[$config["modulSelect"]][$checkItemCFG[2]."Title"] = "<span id='errorMessageText'>".$config[$config["modulSelect"]][$checkItemCFG[2]."Title"]."</span>";
								$config[$config["modulSelect"]."_".$checkItemCFG[2]."Label"] = $config["x_errorText"];
								}
							}
						}
					break;
				case "password":
					if (!EMPTY($p_itemValues[$checkItemCFG[1]]) && $p_itemValues[$checkItemCFG[1]] != $p_itemValues[$checkItemCFG[2]])
						{
						$config["x_errorText"] = $config[$config["modulSelect"]][$checkItemCFG[2]."PasswordTitle"];
						$config[$config["modulSelect"]][$checkItemCFG[2]."Title"] = "<span id='errorMessageText'>".$config[$config["modulSelect"]][$checkItemCFG[2]."Title"]."</span>";
						$config[$config["modulSelect"]."_".$checkItemCFG[2]."Label"] = $config["x_errorText"];
						}
					break;
				default:
					break;
				}
			}
		if (!EMPTY($config["x_errorText"]) && EMPTY($config["x_fieldFocus"]))
			{
			$config["x_fieldFocus"] = $checkItemCFG[1];
			}
		}
	return $config;
	}
?>
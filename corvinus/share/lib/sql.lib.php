<?php
function buildSQL($config)
	{
	// build SQL
	if ($config[$config["modulSelect"]]["defaultFilter"] <> "")
		{
		$config[$config["modulSelect"]]["whereClause"] .= "(" . $config[$config["modulSelect"]]["defaultFilter"] . ") AND ";
		}
	if ($config[$config["modulSelect"]]["dbwhere"] <> "" )
		{
		$config[$config["modulSelect"]]["whereClause"] .= "(" . $config[$config["modulSelect"]]["dbwhere"] . ") AND ";
		}
	if (!isModulList($config,$config["modulSelect"]))
		{
//		$config[$config["modulSelect"]]["whereClause"] .= "(0=1) AND ";
		}
	if (substr($config[$config["modulSelect"]]["whereClause"], -5) == " AND ")
		{
		$config[$config["modulSelect"]]["whereClause"] = substr($config[$config["modulSelect"]]["whereClause"], 0, strlen($config[$config["modulSelect"]]["whereClause"])-5);
		}
	if ($config[$config["modulSelect"]]["whereClause"] <> "")
		{
		$config[$config["modulSelect"]]["strSQL"] .= " WHERE " . $config[$config["modulSelect"]]["whereClause"];
		}
	if ($config[$config["modulSelect"]]["GroupBy"] <> "")
		{
		$config[$config["modulSelect"]]["strSQL"] .= " GROUP BY " . $config[$config["modulSelect"]]["GroupBy"] . " ";
		}
	if ($config[$config["modulSelect"]]["OrderBy"] <> "")
		{
		$config[$config["modulSelect"]]["strSQL"] .= " ORDER BY " . $config[$config["modulSelect"]]["OrderBy"] . " " . @$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_OT"];
		}
	if (@$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"] == 2)
		{
		debugPrintValue($config, '$config[$config["modulSelect"]]["strSQL"]', $config[$config["modulSelect"]]["strSQL"], 0);
		}
	return $config;
	}

function buildSQLUnion($config)
	{
	// build SQL
	if ($config[$config["modulSelect"]]["defaultFilter"] <> "")
		{
		$config[$config["modulSelect"]]["whereClause"] .= "(" . $config[$config["modulSelect"]]["defaultFilter"] . ") AND ";
		}
	if ($config[$config["modulSelect"]]["dbwhere"] <> "" )
		{
		$config[$config["modulSelect"]]["whereClause"] .= "(" . $config[$config["modulSelect"]]["dbwhere"] . ") AND ";
		}
	if (($config[$config["modulSelect"]]["allRecs"] & ewAllowList) <> ewAllowList)
		{
		$config[$config["modulSelect"]]["whereClause"] .= "(0=1) AND ";
		}
	if (substr($config[$config["modulSelect"]]["whereClause"], -5) == " AND ")
		{
		$config[$config["modulSelect"]]["whereClause"] = substr($config[$config["modulSelect"]]["whereClause"], 0, strlen($config[$config["modulSelect"]]["whereClause"])-5);
		}
	if ($config[$config["modulSelect"]]["whereClause"] <> "")
		{
		$config[$config["modulSelect"]]["strSQL"] .= " WHERE " . $config[$config["modulSelect"]]["whereClause"];
		}
	if (@$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"] == 2)
		{
		debugPrintValue($config, '$config[$config["modulSelect"]]["strSQL"]', $config[$config["modulSelect"]]["strSQL"], 0);
		}
	return $config;
	}

function checkOrder($config)
	{
	// check for an Order parameter
	$config[$config["modulSelect"]]["OrderBy"] = "";
	if ($config[$config["modulSelect"]."order"] <> "")
		{
		$config[$config["modulSelect"]]["OrderBy"] = $config[$config["modulSelect"]."order"];
		// check if an ASC/DESC/NOSORT toggle is required
		if (@$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_OB"] == $config[$config["modulSelect"]]["OrderBy"])
			{
			if (@$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_OT"] == "ASC")
				{
				$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_OT"] = "DESC";
				}
			else if (@$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_OT"] == "DESC")
				{
				$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_OT"] = "NOSORT";
				$config[$config["modulSelect"]]["OrderBy"] = "";
				}
			else
				{
				$_SESSION_[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_OT"] = "ASC";
				}
			}
		else
			{
			$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_OT"] = "ASC";
			}
		$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_OB"] = $config[$config["modulSelect"]]["OrderBy"];
		$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_REC"] = 1;
		}
	else
		{
		$config[$config["modulSelect"]]["OrderBy"] = @$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_OB"];
		if ($config[$config["modulSelect"]]["OrderBy"] == "")
			{
			$config[$config["modulSelect"]]["OrderBy"] = $config[$config["modulSelect"]]["defaultOrder"];
			$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_OB"] = $config[$config["modulSelect"]]["OrderBy"];
			$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_OT"] = $config[$config["modulSelect"]]["defaultOrderType"];
			}
		}
	return $config;
	}

function checkStart($config)
	{
	// check for a START parameter
	if ((!isset($_POST[$config["modulSelect"]."pageno"]) || empty($_POST[$config["modulSelect"]."pageno"])) && 
		isset($config[$config["modulSelect"]."start"]) && !empty($config[$config["modulSelect"]."start"]))
		{
		$config[$config["modulSelect"]]["startRec"] = $config[$config["modulSelect"]."start"];
		$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_REC"] = $config[$config["modulSelect"]]["startRec"];
		}
	else if (@$_POST[$config["modulSelect"]."pageno"] <> "")
		{
		$config[$config["modulSelect"]]["pageno"] = $_POST[$config["modulSelect"]."pageno"];
		if (is_numeric($config[$config["modulSelect"]]["pageno"]))
			{
			$config[$config["modulSelect"]]["startRec"] = ($config[$config["modulSelect"]]["pageno"] - 1)*$config[$config["modulSelect"]]["displayRecs"] + 1;
			if ($config[$config["modulSelect"]]["startRec"] <= 0)
				{
				$config[$config["modulSelect"]]["startRec"] = 1;
				}
			elseIf ($config[$config["modulSelect"]]["startRec"] >= (($config[$config["modulSelect"]]["totalRecs"]-1)/$config[$config["modulSelect"]]["displayRecs"])*$config[$config["modulSelect"]]["displayRecs"]+1)
				{
				$config[$config["modulSelect"]]["startRec"] = (($config[$config["modulSelect"]]["totalRecs"]-1)/$config[$config["modulSelect"]]["displayRecs"])*$config[$config["modulSelect"]]["displayRecs"] + 1;
				}
			$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_REC"] = $config[$config["modulSelect"]]["startRec"];
			}
		else
			{
			$config[$config["modulSelect"]]["startRec"] = @$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_REC"];
			if (!is_numeric($config[$config["modulSelect"]]["startRec"]))
				{			
				$config[$config["modulSelect"]]["startRec"] = 1; // reset start record counter
				$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_REC"] = $config[$config["modulSelect"]]["startRec"];
				}
			}
		}
	else
		{
		$config[$config["modulSelect"]]["startRec"] = @$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_REC"];
		if (!is_numeric($config[$config["modulSelect"]]["startRec"]))
			{		
			$config[$config["modulSelect"]]["startRec"] = 1; // reset start record counter
			$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_REC"] = $config[$config["modulSelect"]]["startRec"];
			}
		}	
	if ($config["configShare"]["startReset"] == 1)
		{
		$config[$config["modulSelect"]]["startRec"] = 1; // reset start record counter
		$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_REC"] = $config[$config["modulSelect"]]["startRec"];
		$config["configShare"]["startReset"] = 0;
		}
//	$_SESSION[$config["configShare"]["whichSystemAndMode"] .$config["modulSelect"]. "startRec"]=$config[$config["modulSelect"]]["startRec"];
	return $config;
	}

function buildWhere($config)
	{
	// build dbwhere
	if ($config[$config["modulSelect"]]["masterDetailWhere"] <> "" )
		{
		$config[$config["modulSelect"]]["dbwhere"] .= "(" . $config[$config["modulSelect"]]["masterDetailWhere"] . ") AND ";
		}
	if ($config[$config["modulSelect"]]["searchWhere"] <> "" )
		{
		$config[$config["modulSelect"]]["dbwhere"] .= "(" . $config[$config["modulSelect"]]["searchWhere"] . ") AND ";
		}
	if (strlen($config[$config["modulSelect"]]["dbwhere"]) > 5)
		{
		$config[$config["modulSelect"]]["dbwhere"] = substr($config[$config["modulSelect"]]["dbwhere"], 0, strlen($config[$config["modulSelect"]]["dbwhere"])-5); // trim rightmost AND
		}
	return $config;
	}

function buildSearch($config)
	{
	// build search criteria
	if ($config[$config["modulSelect"]]["advancedSearch"] <> "")
		{
		$config[$config["modulSelect"]]["searchWhere"] = $config[$config["modulSelect"]]["advancedSearch"]; //advanced search
		}
	elseIf ($config[$config["modulSelect"]]["basicSearch"] <> "")
		{
		$config[$config["modulSelect"]]["searchWhere"] = $config[$config["modulSelect"]]["basicSearch"]; //basic search
		}
	return $config;
	}

function saveSearch($config)
	{
	// save search criteria
	if ($config[$config["modulSelect"]]["searchWhere"] <> "")
		{
		$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."_searchWhere"] = $config[$config["modulSelect"]]["searchWhere"];	
		$config[$config["modulSelect"]]["startRec"] = 1; //reset start record counter (new search)
		$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."_REC"] = $config[$config["modulSelect"]]["startRec"];
		}
	else
		{
		$config[$config["modulSelect"]]["searchWhere"] = @$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."_searchWhere"];
		}
	return $config;
	}

function clearSearch($config)
	{
	// get clear search cmd
	if (!isset($config[$config["modulSelect"]."cmd"])) {$config[$config["modulSelect"]."cmd"]=$_GET[$config["modulSelect"]."cmd"];}
	if ($config[$config["modulSelect"]."cmd"] <> "")
		{
//		$config[$config["modulSelect"]."cmd"] = $_GET[$config["modulSelect"]."cmd"];
		if (strtoupper($config[$config["modulSelect"]."cmd"]) == "RESET")
			{
			$_SESSION[$config["configShare"]["whichSystemAndMode"] .$config["modulSelect"]. "startRec"]=1;
			$config[$config["modulSelect"]]["searchWhere"] = ""; //reset search criteria
			$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "pSearchOriginal"] = "";
			$config[$config["modulSelect"]]["pSearchOriginal"]="";
			$_SESSION[$config["configShare"]["pSearchOriginal"]] = "";
			$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_searchWhere"] = $config[$config["modulSelect"]]["searchWhere"];
			$config["configShare"]["pSearchOriginal"] = "";
			}
		elseif (strtoupper($config[$config["modulSelect"]."cmd"]) == "RESETALL")
			{
/*
			$_SESSION[$config["configShare"]["whichSystemAndMode"] .$config["modulSelect"]. "startRec"]=1;
			$config[$config["modulSelect"]]["searchWhere"] = ""; //reset search criteria
			$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "pSearchOriginal"] = "";
			$config[$config["modulSelect"]]["pSearchOriginal"]="";
			$_SESSION[$config["configShare"]["pSearchOriginal"]] = "";
			$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_searchWhere"] = $config[$config["modulSelect"]]["searchWhere"];
			$config[$config["modulSelect"]]["key_m"] = "";
			$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_masterkey"] = $config[$config["modulSelect"]]["key_m"]; // clear master key
			$config[$config["modulSelect"]]["masterDetailWhere"] = "";
			$config["configShare"]["pSearchOriginal"] = "";
*/
			}	
		elseif (strtoupper($config[$config["modulSelect"]."cmd"]) == "RESETFILTER")
			{
			$_SESSION[$config["configShare"]["whichSystemAndMode"] .$config["modulSelect"]. "startRec"]=1;
			$config[$config["modulSelect"]]["searchWhere"] = ""; //reset search criteria
			$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "pSearchOriginal"] = "";
			$config[$config["modulSelect"]]["pSearchOriginal"]="";
			$_SESSION[$config["configShare"]["pSearchOriginal"]] = "";
			$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_searchWhere"] = $config[$config["modulSelect"]]["searchWhere"];
			$config[$config["modulSelect"]]["key_m"] = "";
			$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_masterkey"] = $config[$config["modulSelect"]]["key_m"]; // clear master key
			$config[$config["modulSelect"]]["masterDetailWhere"] = "";
			$config["configShare"]["pSearchOriginal"] = "";
			$_GET[$config["modulSelect"]."cmd"]="RESETALL";
			jumpToPage("?modulSelect=".$config["modulSelect"]."&modulAction=".$config["modulAction"]."&".$config["modulSelect"]."cmd=RESETALL");
			}	
		$config[$config["modulSelect"]]["startRec"] = 1; //reset start record counter (reset command)
		$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_REC"] = $config[$config["modulSelect"]]["startRec"];

		}
	$config[$config["modulSelect"]]["pSearchOriginal"] = $_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "pSearchOriginal"];
	return $config;
	}

function tableExist($config,$p_tableName)
	{
	$is_table = true;
	$tableExistSQL = "SELECT * FROM ".$p_tableName . " LIMIT 1";
	$tableExist=$config["dbConnect"]->prepare($tableExistSQL);
	$tableExist->execute();
	$tableExistCount = $tableExist->rowCount();
	if ($tableExistCount == 0)
		{
		$is_table = false;
		}
	return $is_table;		
	}

function fieldListInsertSQL($config, $p_fieldList)
	{
	// insert into database
	$insertItemSQL = "INSERT INTO " . $config[$config["modulSelect"]]["mainTable"] . " (";
	$insertItemSQL .= implode(",", array_keys($p_fieldList));
	$insertItemSQL .= ") VALUES (";
	$insertItemSQL .= implode(",", array_values($p_fieldList));
	$insertItemSQL .= ")";
	$config["dbConnect"]->exec($insertItemSQL);
	}

function fieldListUpdateSQL($config, $p_fieldList)
	{
	// update
	$updateItemSQL = "UPDATE " . $config[$config["modulSelect"]]["mainTable"] . " SET ";
	foreach ($p_fieldList as $key=>$temp)
		{
		$updateItemSQL .= "$key = $temp, ";			
		}
	if (substr($updateItemSQL, -2) == ", ")
		{
		$updateItemSQL = substr($updateItemSQL, 0, strlen($updateItemSQL)-2);
		}
	$updateItemSQL .= " WHERE ".$config[$config["modulSelect"]]["sqlKey"];
	$config["dbConnect"]->exec($updateItemSQL);
	}

function treeCounter($config,$p_treeActualSQL)
	{
	$treeActual=$config["dbConnect"]->prepare($p_treeActualSQL);
	$treeActual->execute();
	$treeActualRow=$treeActual->fetch();
	$treeCounter = $treeActualRow["treecounter"];
	return $treeCounter;
	}

function itemValuesFromDB($config, $p_tableName)
	{
	// get data from db
	$showColumnsSQL = "SHOW COLUMNS FROM ".$p_tableName;
	$showColumns=$config["dbConnect"]->prepare($showColumnsSQL);
	$showColumns->execute();
	$showColumnsCount = $showColumns->rowCount();
	if ($showColumnsCount > 0)
		{
		while ($resultRow = $showColumns->fetch())
			{
			$fieldNames[]=$resultRow["Field"];
			}
		} 
	$counter=0;
	while ( isset($fieldNames[$counter]) )
		{
//		$itemValues["x_".$fieldNames[$counter]] = $config[$p_tableName]["resultRow"][$fieldNames[$counter]];
		$itemValues["x_".$fieldNames[$counter]] = trim($config[$config["modulSelect"]]["resultRow"][$fieldNames[$counter]]);
		$counter++;
		}
	return $itemValues;
	}

function basicSearch($config)
	{
	// get search criteria for basic search
	$config[$config["modulSelect"]]["pSearch"]=@$_POST[$config["modulSelect"]."psearch"];
	$config[$config["modulSelect"]]["pSearchOriginal"]=$config[$config["modulSelect"]]["pSearch"];
	$config[$config["modulSelect"]]["pSearchType"] = @$_POST[$config["modulSelect"]."psearchtype"];
	if (empty($config[$config["modulSelect"]]["pSearch"]) && !empty($_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "pSearchOriginal"]))
		{
		$config[$config["modulSelect"]]["pSearch"]=$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "pSearchOriginal"];
		$config[$config["modulSelect"]]["pSearchOriginal"]=$config[$config["modulSelect"]]["pSearch"];
		}
	if ($config[$config["modulSelect"]]["pSearch"] <> "")
		{
		$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "pSearchOriginal"] = $config[$config["modulSelect"]]["pSearchOriginal"];
		$_SESSION[$config["configShare"]["whichSystemAndMode"] .$config["modulSelect"]. "startRec"]=1;
		if ($config[$config["modulSelect"]]["pSearchType"] <> "")
			{
			while (strpos($config[$config["modulSelect"]]["pSearch"], "  ") > 0)
				{
				$config[$config["modulSelect"]]["pSearch"] = str_Replace("  ", " ",$config[$config["modulSelect"]]["pSearch"]);
				}
			$arpSearch = explode(" ", trim($config[$config["modulSelect"]]["pSearch"]));
			foreach ($arpSearch as $kw)
				{
				$config[$config["modulSelect"]]["basicSearch"] .= "(";
				if (ISSET($config[$config["modulSelect"]]["iniCFG"]))
					{
					$basicSearchCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##basicSearchFieldsCFGCFG##","##/basicSearchFieldsCFG##");
					$basicSearchDIM = explode('<#>',$basicSearchCFG);
					for ($i=0;$i<count($basicSearchDIM);$i++)
						{
						if (!empty($basicSearchDIM[$i]))
							{
							$config[$config["modulSelect"]]["basicSearch"] .= $basicSearchDIM[$i]." LIKE '%" . trim($kw) . "%' OR ";
							}
						}
					}
				else
					{
					$basicSearchDIM = explode('#',$config[$config["modulSelect"]]["basicSearchFields"]);
					for ($i=0;$i<count($basicSearchDIM);$i++)
						{
						if (!empty($basicSearchDIM[$i]))
							{
							$config[$config["modulSelect"]]["basicSearch"] .= $basicSearchDIM[$i]." LIKE '%" . trim($kw) . "%' OR ";
							}
						}
					}
				if (substr($config[$config["modulSelect"]]["basicSearch"], -4) == " OR ")
					{
					$config[$config["modulSelect"]]["basicSearch"] = substr($config[$config["modulSelect"]]["basicSearch"], 0, strlen($config[$config["modulSelect"]]["basicSearch"])-4);
					}
				$config[$config["modulSelect"]]["basicSearch"] .= ") " . $config[$config["modulSelect"]]["pSearchType"] . " ";
				}
			}
		else
			{
			if (ISSET($config[$config["modulSelect"]]["iniCFG"]))
				{
				$basicSearchCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##basicSearchFieldsCFG##","##/basicSearchFieldsCFG##");
				$basicSearchDIM = explode('<#>',$basicSearchCFG);
				for ($i=0;$i<count($basicSearchDIM);$i++)
					{
					if (!empty($basicSearchDIM[$i]))
						{
						$config[$config["modulSelect"]]["basicSearch"].= $basicSearchDIM[$i]." LIKE '%" . $config[$config["modulSelect"]]["pSearch"] . "%' OR ";
						}
					}
				}
			else
				{
				$basicSearchDIM = explode('#',$config[$config["modulSelect"]]["basicSearchFields"]);
				for ($i=0;$i<count($basicSearchDIM);$i++)
					{
					if (!empty($basicSearchDIM[$i]))
						{
						$config[$config["modulSelect"]]["basicSearch"].= $basicSearchDIM[$i]." LIKE '%" . $config[$config["modulSelect"]]["pSearch"] . "%' OR ";
						}
					}
				}
			}
		}
	$config["configShare"]["pSearchOriginal"] = stripcslashes($config[$config["modulSelect"]]["pSearchOriginal"]);
	if (substr($config[$config["modulSelect"]]["basicSearch"], -4) == " OR ")
		{
		$config[$config["modulSelect"]]["basicSearch"] = substr($config[$config["modulSelect"]]["basicSearch"], 0, strlen($config[$config["modulSelect"]]["basicSearch"])-4);
		}
	if (substr($config[$config["modulSelect"]]["basicSearch"], -5) == " AND ")
		{
		$config[$config["modulSelect"]]["basicSearch"] = substr($config[$config["modulSelect"]]["basicSearch"], 0, strlen($config[$config["modulSelect"]]["basicSearch"])-5);
		}
	return $config;
	}

function modulGetRecord($config, $p_itemValues)
	{
	if ($config["modulSelect"]!="advertlog" && $config["modulSelect"]!="core_users")
		{
		$getRecordSQL = "SELECT ".$config[$config["modulSelect"]]["mainTable"].".*,";
		$getRecordSQL .= "(SELECT core_users.nickname FROM core_users WHERE core_users.id = ".$config[$config["modulSelect"]]["mainTable"].".insertUserID ) AS insertUserID,";
		$getRecordSQL .= "(SELECT core_users.nickname FROM core_users WHERE core_users.id = ".$config[$config["modulSelect"]]["mainTable"].".modifyUserID ) AS modifyUserID";
		$getRecordSQL .= " FROM " . $config[$config["modulSelect"]]["mainTable"];
		$getRecordSQL .= " WHERE " . $_SESSION[$config["modulSelect"]["whichSystemAndMode"].$config["modulSelect"]."sqlKey"];
		}
	else
		{
		$getRecordSQL = "SELECT ".$config[$config["modulSelect"]]["mainTable"].".*";
		$getRecordSQL .= " FROM " . $config[$config["modulSelect"]]["mainTable"];
		$getRecordSQL .= " WHERE " . $_SESSION[$config["modulSelect"]["whichSystemAndMode"].$config["modulSelect"]."sqlKey"];
		}
	if (!empty($config[$config["modulSelect"]]["sqlKey"]) || !empty($_SESSION[$config["modulSelect"]["whichSystemAndMode"].$config["modulSelect"]."sqlKey"]))
		{
		$getRecord=$config["dbConnect"]->prepare($getRecordSQL);
		$getRecord->execute();
		$getRecordCount = $getRecord->rowCount();
		if ($getRecordCount == 0)
			{
			jumpToPage($config[$config["modulSelect"]]["whichBack"]);
			}
	   	$config[$config["modulSelect"]]["resultRow"] = $getRecord->fetch();
		$p_itemValues = itemValuesFromDB($config, $config[$config["modulSelect"]]["mainTable"]);
		$p_itemValues["x_insertUserID"] = $config[$config["modulSelect"]]["resultRow"]["insertUserID"];
		$p_itemValues["x_modifyUserID"] = $config[$config["modulSelect"]]["resultRow"]["modifyUserID"];
		}
	else
		{
//		jumpToPage($config[$config["modulSelect"]]["whichBack"]);
		}
	return $p_itemValues;
	}


function cleanSQLInput($dirty)
	{
	if (get_magic_quotes_gpc())
		{
		$clean = mysql_real_escape_string(addslashes($dirty));
		}
	else
		{
		$clean = mysql_real_escape_string($dirty);
		}
	return $clean;
	}

function db_actual_datetime()
	{
	return ConvertDateToMysqlFormat(date('Y-m-d H:i:s',time()));
	}

function coreUsersConfigClear($config,$configField,$configValue)
	{
	$deleteSQL = "DELETE FROM core_users_config WHERE fieldName='".$configField."' AND core_localserverID='".$config["core_localserverID"]."' AND core_usersID='".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]."'";
	$config["dbConnect"]->exec($deleteSQL);
	}

function coreUsersConfigSet($config,$configField,$configValue)
	{
	$searchSQL=$config["dbConnect"]->prepare("SELECT id FROM `core_users_config` WHERE active=1 AND fieldName='".$configField."' AND core_localserverID='".$config["core_localserverID"]."'  AND core_usersID='".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]."'");
	$searchSQL->execute();
	$searchCount = $searchSQL->rowCount();
	$searchSQL->closeCursor();
	if ($searchCount > 0)
		{
		$updateSQL = "UPDATE core_users_config SET fieldName='".$configField."',fieldValue='".$configValue."',modifyWhen='".db_actual_datetime()."' WHERE active=1 AND fieldName='".$configField."' AND core_localserverID='".$config["core_localserverID"]."'  AND core_usersID='".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]."'";
		$config["dbConnect"]->exec($updateSQL);
		}
	else
		{
		$insertSQL="INSERT INTO core_users_config (fieldName,fieldValue,active,core_localserverID,core_usersID,insertWhen) VALUES ";
		$insertSQL .= "('".$configField."', '".$configValue."', '1', '".$config["core_localserverID"]."', '".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]."', '".db_actual_datetime()."')";
		$config["dbConnect"]->exec($insertSQL);
		}
	}

function coreUsersConfigRead($config,$configField,$configValue)
	{
	$searchSQL=$config["dbConnect"]->prepare("SELECT id FROM `core_users_config` WHERE active=1 AND fieldName='".$configField."' AND core_localserverID='".$config["core_localserverID"]."'  AND core_usersID='".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]."'");
	$searchSQL->execute();
	$searchCount = $searchSQL->rowCount();
	$searchSQL->closeCursor();
	if ($searchCount > 0)
		{
		$searchRS=$searchSQL->fetch(PDO::FETCH_ASSOC);
		}
	}

/* backup the db OR just a table */
function backup_db($host,$user,$pass,$name,$tables = '*')
	{
/*
	// if mysqldump is on the system path you do not need to specify the full path
	// simply use "mysqldump --add-drop-table ..." in this case
	$dumpfname = $name . "_" . date("YmdHis").".sql";
	$command = "D:\\prog\\xampp183\\mysql\\bin\\mysqldump --add-drop-table --host=$host --user=$user ";
	if ($pass)
		{
		$command.= "--password=". $pass ." ";
		}
	$command.= $name;
	$command.= " > " . $dumpfname;
	system($command);
 
	// zip the dump file
	$zipfname = '../../sql/'.$name . "_" . date("YmdHis").".zip";
	$zip = new ZipArchive();
	if($zip->open($zipfname,ZIPARCHIVE::CREATE))
		{
		$zip->addFile($dumpfname,$dumpfname);
		$zip->close();
		}
	unlink($dumpfname);
*/
	}
?>
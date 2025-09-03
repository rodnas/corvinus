<?php
function modulPermission($config,$p_rightsModul)
	{
	$rightsResult = 0;
	if (!is_null(@$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"])) 
		{
		$legals["usersSQL"] = "SELECT active";
		$legals["usersSQL"] .= " FROM core_users";
		$legals["usersSQL"] .= " WHERE (id=".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"].")";
		$legals["usersRs"]=$config["dbConnect"]->prepare($legals["usersSQL"]);
		$legals["usersRs"]->execute();
		if ($legals["usersRs"] && $legals["usersRow"] = $legals["usersRs"]->fetch(PDO::FETCH_ASSOC)) 
			{
			if ($legals["usersRow"]["active"]==1)
				{
				$legals["rightsSQL"] = "SELECT name, active";
				$legals["rightsSQL"] .= " FROM core_configs";
				$legals["rightsSQL"] .= " WHERE (name='".$p_rightsModul."')";
				$legals["rightsRs"]=$config["dbConnect"]->prepare($legals["rightsSQL"]);
				$legals["rightsRs"]->execute();
				if ($legals["rightsRs"] && $legals["rightsRow"] = $legals["rightsRs"]->fetch(PDO::FETCH_ASSOC)) 
					{
					if ($legals["rightsRow"]["active"]==1)
						{
						$legals["groupsSQL"] = "SELECT active";
						$legals["groupsSQL"] .= " FROM core_groups";
						$legals["groupsSQL"] .= " WHERE (id=". $_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"].")";
						$legals["groupsRs"]=$config["dbConnect"]->prepare($legals["groupsSQL"]);
						$legals["groupsRs"]->execute();
						if ($legals["groupsRs"] && $legals["groupsRow"] = $legals["groupsRs"]->fetch(PDO::FETCH_ASSOC)) 
							{
							if ($legals["groupsRow"]["active"]==1)
								{
								$legals["groups_rightsSQL"] = "SELECT core_configs.name,";
								$legals["groups_rightsSQL"] .= " core_groups_rights.active,";
								$legals["groups_rightsSQL"] .= " core_groups_rights.allrecs,";
								$legals["groups_rightsSQL"] .= " core_groups_rights.ownrecs";
								$legals["groups_rightsSQL"] .= " FROM core_configs";
								$legals["groups_rightsSQL"] .= " LEFT JOIN core_groups_rights ON core_groups_rights.core_configsID=core_configs.id";
								$legals["groups_rightsSQL"] .= " WHERE (core_configs.name='".$p_rightsModul."'";
								$legals["groups_rightsSQL"] .= " AND core_groups_rights.core_groupsID=". $_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"].")";
								$legals["groups_rightsRs"]=$config["dbConnect"]->prepare($legals["groups_rightsSQL"]);
								$legals["groups_rightsRs"]->execute();
								if ($legals["groups_rightsRs"] && $legals["groups_rightsRow"] = $legals["groups_rightsRs"]->fetch(PDO::FETCH_ASSOC)) 
									{
									if ($legals["groups_rightsRow"]["active"]==1)
										{
										$rightsResult = $legals["groups_rightsRow"]["allrecs"];
										}
									}
								}
							}
						$legals["users_rightsSQL"] = "SELECT core_configs.name,";
						$legals["users_rightsSQL"] .= " core_users_rights.active,";
						$legals["users_rightsSQL"] .= " core_users_rights.allrecs,";
						$legals["users_rightsSQL"] .= " core_users_rights.ownrecs";
						$legals["users_rightsSQL"] .= " FROM core_configs";
						$legals["users_rightsSQL"] .= " LEFT JOIN core_users_rights ON core_users_rights.core_configsID=core_configs.id";
						$legals["users_rightsSQL"] .= " WHERE (core_configs.name='".$p_rightsModul."'";
						$legals["users_rightsSQL"] .= " AND core_users_rights.core_usersID=". $_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"].")";
						$legals["users_rightsRs"]=$config["dbConnect"]->prepare($legals["users_rightsSQL"]);
						$legals["users_rightsRs"]->execute();
						if ($legals["users_rightsRs"] && $legals["users_rightsRow"] = $legals["users_rightsRs"]->fetch(PDO::FETCH_ASSOC)) 
							{
							if ($legals["users_rightsRow"]["active"]==1)
								{
								$rightsResult = $legals["users_rightsRow"]["allrecs"];
								}
							}
						}
					}
				}
			}
		}
	return $rightsResult;
	}

function isModulView($config,$p_isModul)
	{
	$result = false;
	if ((modulPermission($config,$p_isModul) & ewAllowview) == ewAllowview)
		{
		$result =  true;
		}
	return $result;
	}

function isModulList($config,$p_isModul)
	{
	$result = false;
	if ((modulPermission($config,$p_isModul) & ewAllowlist) == ewAllowlist)
		{
		$result =  true;
		}
	return $result;
	}

function isModulAdd($config,$p_isModul)
	{
	$result = false;
	if ((modulPermission($config,$p_isModul) & ewAllowadd) == ewAllowadd)
		{
		$result =  true;
		}
	return $result;
	}

function isModulEdit($config,$p_isModul)
	{
	$result = false;
	if ((modulPermission($config,$p_isModul) & ewAllowedit) == ewAllowedit)
		{
		$result =  true;
		}
	return $result;
	}

function isModulDelete($config,$p_isModul)
	{
	$result = false;
	if ((modulPermission($config,$p_isModul) & ewAllowdelete) == ewAllowdelete)
		{
		$result =  true;
		}
	return $result;
	}

function isModulAdmin($config,$p_isModul)
	{
	$result = false;
	if ((modulPermission($config,$p_isModul) & ewAllowadmin) == ewAllowadmin)
		{
		$result =  true;
		}
	return $result;
	}

function jumpToPage($p_whichPage)
	{
	ob_end_clean();
	header("Location: ".$p_whichPage);
	}

function longtextWrapper($config,$p_wrapText)
	{
	$wrappedText = "";
	if (isset($config["configShare"]["textWrapLen"]))
		{
		$wrapingLen = setConfigValue($config,"configShare","textWrapLen");
		}
	else
		{
		$wrapingLen = 180;
		}
	$textDim = explode(" ",$p_wrapText);

	for ($i=0;$i<count($textDim);$i++)
		{
		$wrappedText .= " ". trim(wordwrap($textDim[$i],$wrapingLen,"<br />\n"));
		}
//	$wrappedText .= " ". trim(wordwrap($p_wrapText,$wrapingLen,"<br/>\n"));
	return trim($wrappedText);
	}

function longtextView($config,$p_wrapText)
	{
	return trim(str_replace("\n","<br>",$p_wrapText));
	}


function configSeparatorWrapper($config,$p_wrapText)
	{
	$wrappedText = str_replace("<#>","<br />",$p_wrapText);
	return trim($wrappedText);
	}

function makeFieldList($config, $p_itemValues, $p_tableName)
	{
	$structureSQL = "SHOW COLUMNS FROM ".$p_tableName;
	$structure=$config["dbConnect"]->prepare($structureSQL);
	$structure->execute();
	$structureCount = $structure->rowCount();
	if ($structureCount > 0)
		{
		while ($resultRow = $structure->fetch())
			{
			$fieldNames[]=$resultRow["Field"];
			$fieldTypes[]=$resultRow["Type"];
			}
		} 

	$counter=0;
	while ( isset($fieldNames[$counter]) )
		{
		if ( isset($p_itemValues["x_".$fieldNames[$counter]]))
			{
			if (strpos($fieldTypes[$counter],"int(")!==false)
				{
				if ($fieldNames[$counter]<>"id")
					{
					$theValue = (!get_magic_quotes_gpc()) ? addslashes($p_itemValues["x_".$fieldNames[$counter]]) : $p_itemValues["x_".$fieldNames[$counter]];
					$theValue = ($theValue != "") ? intval($theValue) : "NULL";
					$p_fieldList[$fieldNames[$counter]] = $theValue;
					}
				}			
			else if (strpos($fieldTypes[$counter],"char(")!==false ||
				strpos($fieldTypes[$counter],"text")!==false ||
				strpos($fieldTypes[$counter],"longtext")!==false)
				{
				if (strtolower($p_itemValues["x_".$fieldNames[$counter]])=="<br>")
					{
					$p_itemValues["x_".$fieldNames[$counter]]="";
					}
				$theValue = (!get_magic_quotes_gpc()) ? addslashes($p_itemValues["x_".$fieldNames[$counter]]) : $p_itemValues["x_".$fieldNames[$counter]];
				$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
				$p_fieldList[$fieldNames[$counter]] = $theValue;
				}
			else
				{
				$theValue = (!get_magic_quotes_gpc()) ? addslashes($p_itemValues["x_".$fieldNames[$counter]]) : $p_itemValues["x_".$fieldNames[$counter]];
				$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
				$p_fieldList[$fieldNames[$counter]] = $theValue;
				}			
			}
		$counter++;
		}
	return $p_fieldList;
	}

function itemValuesFromPOST($config, $p_tableName)
	{
	// get the form values
	$structureSQL = "SHOW COLUMNS FROM ".$p_tableName;
	$structure=$config["dbConnect"]->prepare($structureSQL);
	$structure->execute();
	$structureCount = $structure->rowCount();
	if ($structureCount > 0)
		{
		while ($resultRow = $structure->fetch())
			{
			$fieldNames[]=$resultRow["Field"];
			}
		} 
	$counter=0;
	while ( isset($fieldNames[$counter]) )
		{
		$itemValues["x_".$fieldNames[$counter]] = @$_POST["x_".$fieldNames[$counter]];
		$counter++;
		}
	return $itemValues;
	}

function startList($config)
	{
	// avoid starting record > total records

	if ($config[$config["modulSelect"]]["startRec"] > $config[$config["modulSelect"]]["totalRecs"])
		{
		$config[$config["modulSelect"]]["startRec"] = $config[$config["modulSelect"]]["totalRecs"];
		}
	else
		{
//		$config[$config["modulSelect"]]["startRec"] = 1;
//		$config[$config["modulSelect"]]["startRec"] = $_SESSION[$config["configShare"]["whichSystemAndMode"] .$config["modulSelect"]. "startRec"];
		}

	// set the last record to display
	$config[$config["modulSelect"]]["stopRec"] = $config[$config["modulSelect"]]["startRec"] + $config[$config["modulSelect"]]["displayRecs"] - 1;
	$config[$config["modulSelect"]]["recCount"] = $config[$config["modulSelect"]]["startRec"] - 1;

	// move to the first record
//	db_data_seek($config[$config["modulSelect"]]["resultSQL"], $config[$config["modulSelect"]]["recCount"]);
	$config[$config["modulSelect"]]["recActual"] = 0;
	return $config;
	}

/**
 * Makes directory and returns BOOL(TRUE) if exists OR made.
 *
 * @param  $path Path name
 * @return bool
 */
function rmkdir($path, $mode = 0755)
	{
	$path = rtrim(preg_replace(array("/\\\\/", "/\/{2,}/"), "/", $path), "/");
	$e = explode("/", ltrim($path, "/"));
	if(substr($path, 0, 1) == "/")
		{
		$e[0] = "/".$e[0];
		}
	$c = count($e);
	$cp = $e[0];
	for($i = 1; $i < $c; $i++)
		{
		if(!is_dir($cp) && !@mkdir($cp, $mode))
			{
			return false;
			}
		$cp .= "/".$e[$i];
		}
	return @mkdir($path, $mode);
	}

function pictureresize($inputname,$outputname,$new_w,$new_h)
	{
	$system = explode(".",$inputname);
	$inputtype = $system[count($system)-1];
	$inputtype = strtolower($inputtype);
	if (($inputtype == 'jpg') or ($inputtype == 'jpeg'))
		{
		$src_img = imagecreatefromjpeg($inputname);
		}
	if ($inputtype == 'gif')
		{
		$src_img = imagecreatefromgif($inputname);
		}
	if ($inputtype == 'png')
		{
		$src_img = imagecreatefrompng($inputname);
		}
	$old_x=imageSX($src_img);
	$old_y=imageSY($src_img);
	if ($old_x > $new_w || $old_y > $new_h)
		{
		if ($old_x > $old_y)
			{
			$thumb_w=$new_w;
			$thumb_h=$old_y*($new_h/$old_x);
			}
		if ($old_x < $old_y)
			{
			$thumb_w=$old_x*($new_w/$old_y);
			$thumb_h=$new_h;
			}
		if ($old_x == $old_y)
			{
			$thumb_w=$new_w;
			$thumb_h=$new_h;
			}
		}
	else
		{
		$thumb_w = $old_x;
		$thumb_h = $old_y;
		}
	$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);
	if ((preg_match("/png/",$system[1])) || (preg_match("/gif/",$system[1])))
		{
		imagepng($dst_img,$outputname);
		}
	else
		{
		imagejpeg($dst_img,$outputname);
		}
	imagedestroy($dst_img);
	imagedestroy($src_img);
	$resized=1;
	return $resized;
	}

function emailValidator( $email, $chFail = false )
	{
	$msgs = Array(); $msgs[] = 'Received email address: '.$email;
	//check for email pattern (adapted and improved from http://karmak.org/archive/2003/02/validemail.html)
	//incorrectly allows IP addresses with block numbers > 256, but those will fail to create sockets anyway
	//unicode norwegian chars cannot be used: C caron, D stroke, ENG, N acute, S caron, T stroke, Z caron (PHP unicode limitation)
	if( !preg_match( "/^(([^<>()[\]\\\\.,;:\s@\"]+(\.[^<>()[\]\\\\.,;:\s@\"]+)*)|(\"([^\"\\\\\r]|(\\\\[\w\W]))*\"))@((\[([0-9]{1,3}\.){3}[0-9]{1,3}\])|(([a-z\-0-9†ÖÑáÇäà§¢ïìîÅëoÜ]+\.)+[a-z]{2,}))$/i", $email ) )
		{
	        $msgs[] = 'Email address was not recognised as a valid email pattern';
	        return $chFail ? Array( false, $msgs ) : false;
		}
	$msgs[] = 'Email address was recognised as a valid email pattern';

	//get the mx host name
	if( preg_match( "/@\[[\d.]*\]$/", $email ) )
		{
		$mxHost[0] = preg_replace( "/[\w\W]*@\[([\d.]+)\]$/", "$1", $email );
		$msgs[] = 'Email address contained IP address '.$mxHost[0].' - no need for MX lookup';
		}
	else
		{
		//get all mx servers - if no MX records, assume domain is MX (SMTP RFC)
		}
	$msgs[] = 'Could not establish SMTP session with any MX servers';
	return $chFail ? Array( true, $msgs ) : true;
	}

function setConfigValue($config,$configType,$configField)
	{
if ($configType=="core_messagewall")
	{
	}
	if ($configType != "configShare" && $configType != "registration")
		{
		$shareConfig = $config[$configType]["mainTable"];
		}
	if (isset($config[$shareConfig][$configField]))
		{
		$setConfigValueResult = $config[$shareConfig][$configField];
		}
	else if (isset($config[$configType][$configField]))
		{
		$setConfigValueResult = $config[$configType][$configField];
		}
	else if (isset($config["configShare"][$configField]))
		{
		$setConfigValueResult = $config["configShare"][$configField];
		}	
	else if (isset($config[$configField]))
		{
		$setConfigValueResult = $config[$configField];
		}
	else $setConfigValueResult = "";
	return $setConfigValueResult;
	}

function calendarNext($config,$actualDate,$moveType)
	{
	$weekDay["Sat"] = "Szo";
	$weekDay["Sun"] = "Va";
	$weekDay["Mon"] = "H√©";
	$weekDay["Tue"] = "Ke";
	$weekDay["Wed"] = "Sze";
	$weekDay["Thu"] = "Cs";
	$weekDay["Fri"] = "P√©";
	$months = array('Janu√°r', 'Febru√°r', 'M√°rcius', '√Åprilis', 'M√°jus', 'J√∫nius', 'J√∫lius', 'Augusztus', 'Szeptember', 'Okt√≥ber', 'November', 'December');

	if (empty($actualDate) || $actualDate=="date")
		{
		$actualDate = date("Y-m-d",time());
		}
	if ($moveType == "date")
		{
		$config["calendarNext"]=date("Y-m-d",mktime(0,0,0, substr($actualDate,5,2), substr($actualDate,8,2)+1, substr($actualDate,0,4)));
		$config["calendarPrev"]=date("Y-m-d",mktime(0,0,0, substr($actualDate,5,2), substr($actualDate,8,2)-1, substr($actualDate,0,4)));
		$config["calendarMoveType"]="date";
		$config["calendarDayList"]=date("Y.m.d. ",mktime(0,0,0, substr($actualDate,5,2), substr($actualDate,8,2), substr($actualDate,0,4)));
		$config["calendarDayList"].=$weekDay[date("D",mktime(0,0,0, substr($actualDate,5,2), substr($actualDate,8,2), substr($actualDate,0,4)))];
		$config["calendarToday"]=$actualDate;
		$config["calendarWeekNow"]=date("Y-W",mktime(0,0,0, substr($actualDate,5,2), substr($actualDate,8,2), substr($actualDate,0,4)));
		$config["calendarMonthNow"]=date("Y-m",mktime(0,0,0, substr($actualDate,5,2), substr($actualDate,8,2), substr($actualDate,0,4)));
		$config["calendarJournalNow"]=date("Y-W",mktime(0,0,0, substr($actualDate,5,2), substr($actualDate,8,2), substr($actualDate,0,4)));
		}
	else if ($moveType == "week")
		{
		$weekDay1 = date('Y.m.d', strtotime($_SESSION["calendarYear"]."-W".sprintf("%02s",$_SESSION["calendarWeek"])."-1"));
		$weekDay7 = date('Y.m.d', strtotime($_SESSION["calendarYear"]."-W".sprintf("%02s",$_SESSION["calendarWeek"])."-7"));
		$config["nextWeek"]=date("Y-W",mktime(0,0,0, substr($weekDay7,5,2), substr($weekDay7,8,2)+1 , substr($weekDay7,0,4)));
		$config["prevWeek"]=date("Y-W",mktime(0,0,0, substr($weekDay1,5,2), substr($weekDay1,8,2)-1 , substr($weekDay1,0,4)));;
		$config["calendarNext"]=$config["nextWeek"];
		$config["calendarPrev"]=$config["prevWeek"];
		$config["calendarMoveType"]="week";
		$monday    = date('Y.m.d', strtotime($_SESSION["calendarYear"]."-W".sprintf("%02s",$_SESSION["calendarWeek"])."-1"));
		$sunday    = date('Y.m.d', strtotime($_SESSION["calendarYear"]."-W".sprintf("%02s",$_SESSION["calendarWeek"])."-7"));
//		$config["calendarDayList"]="<div>".$_SESSION["calendarYear"].". ".$_SESSION["calendarWeek"].". ".$config["configShare"]["weekTitle"]." (".$monday." - ".$sunday.")</div>";
		$config["calendarDayList"]="<div>".$_SESSION["calendarYear"].". ".$_SESSION["calendarWeek"].". ".$config["configShare"]["weekTitle"]."</div>";
		$config["calendarWeekDayList"]='';
		$weekDayFirst=intval(date('d', strtotime($_SESSION["calendarYear"]."-W".sprintf("%02s",$_SESSION["calendarWeek"])."-1")));
		if ($config["calendarListType"]=="weekly" || $_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."Type"]=="weekly")
			{
			$config["calendarWeekDayList"].='<div>';
			$config["calendarWeekDayList"].='<div style="float:left;width:50px;" id="calendarListHeadWeek">';
			$config["calendarWeekDayList"].='</div>';
			$config["calendarWeekDayList"].='<div style="margin-left:55px;min-width:220px;" id="calendarReserveWeek">';
			$config["calendarWeekDayList"].='<div style="float:left;min-width:20px;max-width:260px;width:13.6%" id="calendarListHeadWeek">'.date('m.d', strtotime($_SESSION["calendarYear"]."-W".sprintf("%02s",$_SESSION["calendarWeek"])."-1")).'<br>'.$weekDay["Mon"].'</div>';
			$config["calendarWeekDayList"].='<div style="float:left;min-width:20px;max-width:260px;width:13.6%" id="calendarListHeadWeek">'.date('m.d', strtotime($_SESSION["calendarYear"]."-W".sprintf("%02s",$_SESSION["calendarWeek"])."-2")).'<br>'.$weekDay["Tue"].'</div>';
			$config["calendarWeekDayList"].='<div style="float:left;min-width:20px;max-width:260px;width:13.6%" id="calendarListHeadWeek">'.date('m.d', strtotime($_SESSION["calendarYear"]."-W".sprintf("%02s",$_SESSION["calendarWeek"])."-3")).'<br>'.$weekDay["Wed"].'</div>';
			$config["calendarWeekDayList"].='<div style="float:left;min-width:20px;max-width:260px;width:13.4%" id="calendarListHeadWeek">'.date('m.d', strtotime($_SESSION["calendarYear"]."-W".sprintf("%02s",$_SESSION["calendarWeek"])."-4")).'<br>'.$weekDay["Thu"].'</div>';
			$config["calendarWeekDayList"].='<div style="float:left;min-width:20px;max-width:260px;width:13.4%" id="calendarListHeadWeek">'.date('m.d', strtotime($_SESSION["calendarYear"]."-W".sprintf("%02s",$_SESSION["calendarWeek"])."-5")).'<br>'.$weekDay["Fri"].'</div>';
			$config["calendarWeekDayList"].='<div style="float:left;min-width:20px;max-width:260px;width:13.4%" id="calendarListHeadWeek">'.date('m.d', strtotime($_SESSION["calendarYear"]."-W".sprintf("%02s",$_SESSION["calendarWeek"])."-6")).'<br>'.$weekDay["Sat"].'</div>';
			$config["calendarWeekDayList"].='<div style="float:left;min-width:20px;max-width:260px;width:13.4%" id="calendarListHeadWeek">'.date('m.d', strtotime($_SESSION["calendarYear"]."-W".sprintf("%02s",$_SESSION["calendarWeek"])."-7")).'<br>'.$weekDay["Sun"].'</div>';
			$config["calendarWeekDayList"].='<div style="clear:both;"></div>';
			$config["calendarWeekDayList"].='</div>';
			$config["calendarWeekDayList"].='</div>';
			}
		$config["calendarToday"]=date('Y.m.d', strtotime($_SESSION["calendarYear"]."-W".sprintf("%02s",$_SESSION["calendarWeek"])."-1"));
		$config["calendarWeekNow"]=date("Y-W",mktime(0,0,0, substr($config["calendarToday"],5,2), substr($config["calendarToday"],8,2), substr($config["calendarToday"],0,4)));
		$config["calendarMonthNow"]=date("Y-m",mktime(0,0,0, substr($config["calendarToday"],5,2), substr($config["calendarToday"],8,2), substr($config["calendarToday"],0,4)));
		$config["calendarJournalNow"]=date('Y.m.d', strtotime($_SESSION["calendarYear"]."-W".sprintf("%02s",$_SESSION["calendarWeek"])."-1"));
		}
	else if ($moveType == "month")
		{
		$config["nextMonth"]=date("Y-m",mktime(0,0,0, substr($actualDate,5,2)+1, 1, substr($actualDate,0,4)));
		$config["prevMonth"]=date("Y-m",mktime(0,0,0, substr($actualDate,5,2)-1, 1, substr($actualDate,0,4)));
		$config["calendarNext"]=$config["nextMonth"];
		$config["calendarPrev"]=$config["prevMonth"];
		$config["calendarMoveType"]="month";
		$config["calendarDayList"]="<div>".$_SESSION["calendarYear"].". ".$_SESSION["calendarMonth"]." (".$months[intval($_SESSION["calendarMonth"])-1].")</div>";
		if ($config["calendarListType"]=="monthly" || $_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."Type"]=="monthly")
			{
			}
		$config["calendarToday"]=date('Y.m.d',mktime(0,0,0,substr($actualDate,5,2), 1, substr($actualDate,0,4)));
		$config["calendarWeekNow"]=date("Y-W", mktime(0,0,0,substr($actualDate,5,2), 1, substr($actualDate,0,4)));
		$config["calendarMonthNow"]=date("Y-m",mktime(0,0,0, substr($actualDate,5,2), 1, substr($actualDate,0,4)));
		$config["calendarJournalNow"]=date('Y.m.d',mktime(0,0,0,substr($actualDate,5,2), 1, substr($actualDate,0,4)));
		}
	return $config;
	}
?>
<?php
function configFieldSearchAll($config,$systemType)
	{
	if (!isset($config["core_localserverID"]))
		{
		$core_configSQL = "SELECT fieldName,fieldValue FROM `core_config` WHERE active=1 AND autoload=1 AND systemType='".$systemType."' AND core_localserverID IS NULL";
		}
	else
		{
		$core_configSQL = "SELECT fieldName,fieldValue FROM `core_config` WHERE active=1 AND autoload=1 AND systemType='".$systemType."' AND (core_localserverID IS NULL OR core_localserverID='".$config["core_localserverID"]."')";
		}
	foreach ($config["dbConnect"]->query($core_configSQL) as $configROW) 
		{
		$config[$configROW["fieldName"]]=$configROW["fieldValue"];
		$_SESSION[$configROW["fieldName"]]=$config[$configROW["fieldName"]];
		}
	return $config;
	}

function languageFieldSearchAll($config,$systemType)
	{
	if (!isset($config["core_localserverID"]))
		{
		$core_languageSQL = "SELECT fieldName,fieldValue FROM `core_language` WHERE active=1 AND autoload=1 AND systemType='".$systemType."' AND core_localserverID IS NULL";
		}
	else
		{
		$core_languageSQL = "SELECT fieldName,fieldValue FROM `core_language` WHERE active=1 AND autoload=1 AND systemType='".$systemType."' AND (core_localserverID IS NULL OR core_localserverID='".$config["core_localserverID"]."')";
		}
	foreach ($config["dbConnect"]->query($core_languageSQL) as $languageROW) 
		{
		if (substr($languageROW["fieldValue"],0,2)!="//")
			{
			$config[$languageROW["fieldName"]]=$languageROW["fieldValue"];
			$_SESSION[$languageROW["fieldName"]]=$config[$languageROW["fieldName"]];
			}
		}
	return $config;
	}
	
function configFieldSearchModul($config)
	{
	foreach ($config["dbConnect"]->query("SELECT fieldName,fieldValue FROM `core_config` WHERE active=1 AND fieldName LIKE '".$config["modulName"]."%'") as $configROW) 
		{
		$config[$configROW["fieldName"]]=$configROW["fieldValue"];
		$_SESSION[$configROW["fieldName"]]=$config[$configROW["fieldName"]];
		}
	return $config;
	}

function languageFieldSearchModul($config)
	{
	foreach ($config["dbConnect"]->query("SELECT fieldName,fieldValue FROM `core_language` WHERE active=1 AND fieldName LIKE '".$config["modulName"]."%'") as $languageROW) 
		{
		if (substr($languageROW["fieldValue"],0,2)!="//")
			{
			$config[$languageROW["fieldName"]]=$languageROW["fieldValue"];
			$_SESSION[$languageROW["fieldName"]]=$config[$languageROW["fieldName"]];
			}
		}
	return $config;
	}

function configFieldSearch($config,$fieldName)
	{
	if (!ISSET($_SESSION[$fieldName]))
		{
		$config = configFieldSearchAll($config);
		}
	else
		{
		$config[$fieldName] = $_SESSION[$fieldName];
		}
	return $config;
	}

function ParseCFG($cfg,$config)
	{
	$ex=explode ('##START##',$cfg);
	for ($i=0; $i<sizeof($ex); $i++)
		{
		if (substr_count($ex[$i],'##STOP##')>0)
			{
			$xxpdfParseTpl=explode('##STOP##',$ex[$i]);
			$funParam = explode('#',$xxpdfParseTpl[0]);
			switch($funParam[0])
				{
				case "configShare":
					$configSize = sizeof($funParam);
					$to=$config[$funParam[0]][$funParam[1]];
					break;
				case "SERVER_NAME":
					$to=strtolower($_SERVER['SERVER_NAME']);
					break;
				case "SERVER_ADDR":
					$to=strtolower($_SERVER['SERVER_ADDR']);
					break;
				case "REMOTE_NAME":
					$to=strtolower($_SERVER['SERVER_NAME']);
					break;
				case "REMOTE_ADDR":
					$to=strtolower($_SERVER['SERVER_ADDR']);
					break;
				case "REMOTE_HOST":
					$to=strtolower(gethostbyaddr($_SERVER['SERVER_ADDR']));
					break;
				}
			$cfg=str_replace('##START##'.$xxpdfParseTpl[0].'##STOP##', $to, $cfg);
			}
		}
	return $cfg;
	}

function iniCFGParser($mainCFG,$startCFG,$stopCFG)
	{
	$result = trim(substr($mainCFG,0,strpos($mainCFG,$stopCFG)));
	$result = trim(substr($result,strpos($result,$startCFG)+strlen($startCFG)));
	return $result;
	}

function ini2CFGParser($mainCFG,$startCFG,$stopCFG)
	{
	if (strpos($mainCFG,$startCFG) > 0)
		{
		$result = trim(substr($mainCFG,0,strpos($mainCFG,$startCFG)-1));
		$result .= trim(substr($mainCFG,strpos($mainCFG,$stopCFG)+strlen($stopCFG)+1));
		}
	else
		{
		$result = $mainCFG;
		}
	return $result;
	}

function clearForm($config,$origForm, $viewItem)
	{
	$reallyForm = $origForm;
	if (ISSET($viewItem) && !empty($viewItem))
		{
		reset($viewItem);
		while( key($viewItem) !== NULL )
			{
			$viewItemNOW = key($viewItem);
			$viewItemVisible = current($viewItem);
			if ($viewItemVisible==1)
				{
				$reallyForm = str_replace("<".$viewItemNOW.">","",$reallyForm);
				$reallyForm = str_replace("</".$viewItemNOW.">","",$reallyForm);
				}
			else
				{
				$reallyForm = ini2CFGParser($reallyForm,$viewItemNOW,"/".$viewItemNOW);
				}
			next($viewItem);
			}
		}
	return $reallyForm;
	}

function parseContent($tpl,$config,$itemValues)
	{
	$ex=explode ('{##',$tpl);
	for ($i=0; $i<sizeof($ex); $i++)
		{
		if (substr_count($ex[$i],'##}')>0)
			{
			$xxpdfParseTpl=explode('##}',$ex[$i]);
			$funParam = explode('::',$xxpdfParseTpl[0]);
			$configSize = sizeof($funParam);
			switch ($configSize)
				{
				case 1:
					$to=$config[$funParam[0]];
					break;
				case 2:
					if ($funParam[0]=="@modulSelect")
						{
						$to=$config[$config["modulSelect"]."_".$funParam[1]];
						}
					else if ($funParam[0]=="&modulSelect")
						{
						$to=$config[$config["modulSelect"]][$funParam[1]];
						}
					else if ($funParam[0]=="&configShare")
						{
						$to=$config["configShare"][$funParam[1]];
						}
					else if ($funParam[0]=="@itemValues")
						{
						$to=$itemValues[$funParam[1]];
						}
					else
						{
						$to=$config[$funParam[0]][$funParam[1]];
						}
					break;
				case 3:
					$to=$config[$funParam[0]][$funParam[1]][$funParam[2]];
					break;
					
					break;
				case "captcha":
					/*
					##Start##text#field#size#maxlength##Stop##
					example:
					##Start##captcha#x_name#8#8##Stop##
					*/
					$to = '<img src="/normal/111hosting/inc/capimg.php?width=100&height=40&characters=5">';
					break;
				}
			$tpl=str_replace('{##'.$xxpdfParseTpl[0].'##}', $to, $tpl);
			}
		}
	return $tpl;
	}
	
function dayIdentifier($calcDate)
	{
	if (date("W",$calcDate)%2) {$dayID="1";} else {$dayID="2";}
	$dayID .= date("D",$calcDate);
	return $dayID;
	}

function jsConvert($config, $jsPath, $jsName)
	{
	/** JS from file **/
	$jsContent = fileUp($jsName,"js",$config,$jsPath,"jsNotFound");
	$result = parseContent($jsContent["returnValue"],$config,"");
	
	header('Content-type: text/javascript');
	return $result;
	}


function cssConvert($config,$systemType,$cssName,$resolution)
	{
	$themesStartSQL = "SELECT id, name, bgcolor, fgcolor FROM core_themes WHERE active=1 AND id=".$_SESSION[$config["configShare"]["whichSystemAndMode"]."status_core_themesFilterID"];
	$themesStart=$config["dbConnect"]->prepare($themesStartSQL);
	$themesStart->execute();
	$themesStartCount = $themesStart->rowCount();
	if ($themesStartCount > 0)
		{
		$themesStartData = $themesStart->fetch();
		$config["actualBgColor"] = $themesStartData["bgcolor"];
		$config["actualFgColor"] = $themesStartData["fgcolor"];
		if ($config["actualFgColor"]=="#FFFFFF")
			{
			$config["actualMenuBgColor"]="#000000";
			}
		else
			{
			$config["actualMenuBgColor"]="#FFFFFF";
			}
//		$config["imgURL"]=$systemType."/themes/".$themesStartData["path"]."/img/button/";
		}
	if ($resolution==1) {$cssName = $cssName.$_SESSION["screenResolution"];}
	$config["cssFromFile"]=1;
	if ($config["cssFromFile"]==1)
		{
		$cssContent = fileUp($cssName,"css",$config,$systemType."/css/","cssNotFound");
		}
	else
		{
		$cssContent["returnCode"]=-1;
		}
	if ($cssContent["returnCode"]==-1)
		{
		// CSS from table
/*
		$cssContent = "";
		$cssSQL="SELECT * FROM `core_config` WHERE active=1 AND core_localserverID='".$config["core_localserverID"]."' AND fieldName='".$cssName."' LIMIT 1";
		foreach ($config["dbConnect"]->query($cssSQL) as $cssROW) 
			{
			$cssContent["returnCode"]=1;
			$cssContent["returnValue"]=$cssROW["fieldValue"];
			}
*/
		}
	else if ($cssContent["returnCode"]==1)
		{
/*
		if ($config["cssInsertRename"]==1)
			{
			$config["dbConnect"]->exec("UPDATE core_config SET active=0,modifyWhen='".date('Y-m-d H:i:s',time())."' WHERE active=1 AND localServerID='".$config["localServerID"]."' AND fieldName='".$cssName."'");
			$insertSQL='INSERT INTO core_config (fieldName,fieldValue,autoload,active,insertWhen,core_localserverID) VALUES (:fieldName,:fieldValue,:autoload,:active,:insertWhen,:core_localserverID)';
			$insertPrepare = $config["dbConnect"]->prepare($insertSQL);
			$fieldName = $cssName;
			$fieldValue = $cssContent["returnValue"];
			$insertWhen=date('Y-m-d H:i:s',time());
			$autoload=1;
			$active=1;
			$insertPrepare->execute(array(':fieldName'=>$cssName, ':fieldValue'=>$cssContent["returnValue"],':autoload'=>$autoload,':active'=>$active, ':insertWhen'=>$insertWhen, ':core_localserverID'=>$config["localserverID"]));
			rename("css/".$cssName.".css","backend/css/".$cssName.".css_".date("Ymdhms"));
			}
*/
		}
	$result = parseContent($cssContent["returnValue"],$config,"");

	header('Content-type: text/css');
	$days_to_cache = 10;
	header('Expires: '.gmdate('D, d M Y H:i:s',time() + (60 * 60 * 24 * $days_to_cache)).' GMT');
	return $result;
	}


function cssConvertFE($config,$cssName,$resolution)
	{
	if ($resolution==1) {$cssName = $cssName.$_SESSION["screenResolution"];}
	
	if ($config["cssFromFile"]==1)
		{
		$cssContent = fileUp($cssName,"css",$config,"css/","cssNotFound");
		}
	else
		{
		$cssContent["returnCode"]=-1;
		}
	if ($cssContent["returnCode"]==-1)
		{
		// CSS from table
		$cssContent = "";
		$cssSQL="SELECT * FROM `core_config` WHERE active=1 AND core_localserverID='".$config["core_localserverID"]."' AND fieldName='".$cssName."' LIMIT 1";
		foreach ($config["dbConnect"]->query($cssSQL) as $cssROW) 
			{
			$cssContent["returnCode"]=1;
			$cssContent["returnValue"]=$cssROW["fieldValue"];
			}
		}
	else if ($cssContent["returnCode"]==1)
		{
		if ($config["cssInsertRename"]==1)
			{
			$config["dbConnect"]->exec("UPDATE core_config SET active=0,modifyWhen='".date('Y-m-d H:i:s',time())."' WHERE active=1 AND localServerID='".$config["localServerID"]."' AND fieldName='".$cssName."'");
			$insertSQL='INSERT INTO core_config (fieldName,fieldValue,autoload,active,insertWhen,core_localserverID) VALUES (:fieldName,:fieldValue,:autoload,:active,:insertWhen,:core_localserverID)';
			$insertPrepare = $config["dbConnect"]->prepare($insertSQL);
			$fieldName = $cssName;
			$fieldValue = $cssContent["returnValue"];
			$insertWhen=date('Y-m-d H:i:s',time());
			$autoload=1;
			$active=1;
			$insertPrepare->execute(array(':fieldName'=>$cssName, ':fieldValue'=>$cssContent["returnValue"],':autoload'=>$autoload,':active'=>$active, ':insertWhen'=>$insertWhen, ':core_localserverID'=>$config["localserverID"]));
			rename("css/".$cssName.".css","css/".$cssName.".css_".date("Ymdhms"));
			}
		}
	$result = parseContent($cssContent["returnValue"],$config,"");

	header('Content-type: text/css');
	$days_to_cache = 10;
	header('Expires: '.gmdate('D, d M Y H:i:s',time() + (60 * 60 * 24 * $days_to_cache)).' GMT');
	return $result;
	}

function fileUp($name,$ext,$config,$filePATH,$fileNotFound)
	{
	$result=Array();
	$addDir=$filePATH;
	if (file_exists($addDir."{$name}.{$ext}"))
		{ 
		$content='';
		$cont=file($addDir.$name.'.'.$ext);
		while(list($line_num,$line)=each($cont)) $content.=$line;
		$result["returnCode"]=1;
		$result["returnValue"]=$content;
		}
	else 
		{
		$result["returnCode"]=-1;
		$result["returnValue"]=$name." - ".$config[$fileNotFound];
		}
	return $result;
	}

function cfgLoader($config,$fileName,$fileType,$filePath,$loadError)
	{
	$fileContent = fileUp(strtolower($fileName),$fileType,$config,$filePath,$loadError);

	if ($fileContent["returnCode"]!=1)
		{
		$core_configsSQL=$config["dbConnect"]->prepare("SELECT cfgCFG FROM `core_configs` WHERE name='".$fileName."'");
		$core_configsSQL->execute();
		$core_configsROW=$core_configsSQL->fetchColumn();
		if (!empty($core_configsROW))
			{
			$fileContent["returnValue"]=$core_configsROW;
			$fileContent["returnCode"]=1;
			}
		}

	if ($fileContent["returnCode"]==1)
		{
		$config[$fileName]["iniCFG"] = $fileContent["returnValue"];
//		$core_configsUpdateSQL = "UPDATE core_configs SET `cfgCFG`='".$config[$fileName]["iniCFG"]."' WHERE name='".$fileName."'";
//		$config["dbConnect"]->exec($core_configsUpdateSQL);

		$modulCFG = iniCFGParser($config[$fileName]["iniCFG"],"##modulCFG##","##/modulCFG##");
		$modulFieldsCFG = explode('<#>',$modulCFG);
		for ($modulFieldCFGCount=0;$modulFieldCFGCount<count($modulFieldsCFG);$modulFieldCFGCount++)
			{
			$modulFieldCFG = explode('<=>',$modulFieldsCFG[$modulFieldCFGCount]);
			$config[$fileName][trim($modulFieldCFG[0])]=ParseCFG(trim($modulFieldCFG[1]),$config);
//			$config["configShare"][trim($modulFieldCFG[0])]=parseContent($config[$fileName][trim($modulFieldCFG[0])],$config,"");
			}
		}
	return $config;
	}

function lngLoader($config,$fileName,$fileType,$filePath,$loadError)
	{
	$fileContent = fileUp(strtolower($fileName),$fileType,$config,$filePath,$loadError);
	if ($fileContent["returnCode"]!=1)
		{
		$core_configsSQL=$config["dbConnect"]->prepare("SELECT id FROM `core_configs` WHERE name='".$fileName."'");
		$core_configsSQL->execute();
		$core_configsID=$core_configsSQL->fetchColumn();
		if (!empty($core_configsID))
			{
			$searchSQL = "SELECT * FROM core_language WHERE active=1 AND systemType='backend' AND core_configsID=10";
			foreach ($config["dbConnect"]->query($searchSQL) as $configLngROW) 
				{
				if (substr($configLngROW["fieldValue"],0,2)!="//")
					{
					$config[$fileName][trim($configLngROW["fieldName"])."Title"]=trim($configLngROW["fieldValue"]);
					}
				}
			$searchSQL = "SELECT * FROM core_language WHERE active=1 AND systemType='backend' AND core_configsID='".$core_configsID."'";
			foreach ($config["dbConnect"]->query($searchSQL) as $configLngROW) 
				{
				if (substr($configLngROW["fieldValue"],0,2)!="//")
					{
					$config[$fileName][trim($configLngROW["fieldName"])."Title"]=trim($configLngROW["fieldValue"]);
					}
				}
			$fileContent["returnCode"]=1;
			}
		}
	else
		{
		$config[$fileName]["lngCFG"] = $fileContent["returnValue"];
		$titleCFG = iniCFGParser($config[$fileName]["lngCFG"],"##titleCFG##","##/titleCFG##");
		$modulTitlesDIM = explode('<#>',$titleCFG);
		for ($modulTitleCount=0;$modulTitleCount<count($modulTitlesDIM);$modulTitleCount++)
			{
			$modulTitleDIM = explode('::',$modulTitlesDIM[$modulTitleCount]);
			$config[$fileName][trim($modulTitleDIM[0])."Title"]=trim($modulTitleDIM[1]);
			}
		}
	return $config;
	}

function tplLoader($config,$fileName,$fileType,$filePath,$fileError)
	{
	$fileContent = fileUp(strtolower($fileName),$fileType,$config,$filePath,$fileError);

	if ($fileContent["returnCode"]!=1)
		{
		$core_configsSQL=$config["dbConnect"]->prepare("SELECT tplCFG FROM `core_configs` WHERE name='".$fileName."'");
		$core_configsSQL->execute();
		$core_configsROW=$core_configsSQL->fetchColumn();
		if (!empty($core_configsROW))
			{
			$fileContent["returnValue"]=$core_configsROW;
			$fileContent["returnCode"]=1;
			}
		}
	if ($fileContent["returnCode"]==1)
		{
		$config[$fileName]["tplCFG"] = $fileContent["returnValue"];
		$config[$fileName."_resultValue"]=$fileContent["returnValue"];
//		$core_configsUpdateSQL = "UPDATE core_configs SET `tplCFG`='".$config[$fileName]["tplCFG"]."' WHERE name='".$fileName."'";
//		$config["dbConnect"]->exec($core_configsUpdateSQL);
		}
	else
		{
		$config[$fileName]["tplCFG"] = $fileContent["returnValue"];
		}
	return $config;
	}

function modulOperation($config)
	{
	if (isset($_POST["modulOperation"]) && !empty($_POST["modulOperation"]))
		{
		if (isset($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_modulSelect"]) && !empty($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_modulSelect"]))
			{
			unset($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_modulSelect"]);
			}
		if (isset($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_modulAction"]) && !empty($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_modulAction"]))
			{
			unset($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_modulAction"]);
			}
		$config["modulOperation"]=$_POST["modulOperation"];
		$modulOperationCFG = explode('::',$_POST["modulOperation"]);
		switch ($modulOperationCFG[0])
			{
			case "list":
				{
				$config["modulAction"]=$modulOperationCFG[0];
				$config["modulSelect"]=$modulOperationCFG[1];
				$config[$config["modulSelect"]."cmd"]=$modulOperationCFG[2];
				break;
				}
			case "item":
				{
				$config["modulAction"]=$modulOperationCFG[1];
				$config["modulSelect"]=$modulOperationCFG[2];
				$config["modulRecordID"]=$modulOperationCFG[3];
				if (isset($modulOperationCFG[4]) && !empty($modulOperationCFG[4]))
					{
					$_SESSION[$config["modulSelect"]."back"]=$modulOperationCFG[4];
					}
				break;
				}
			case "calendarChange":
				$config["modulAction"]="list";
				$config["modulSelect"]=$modulOperationCFG[2];
			case "calendar":
				{
				$config["modulAction"]=$modulOperationCFG[1];
				$config["modulSelect"]=$modulOperationCFG[2];
				if ($config["modulAction"]=="add")
					{
					if ($modulOperationCFG[3]=="dateTime")
						{
						$config[$config["modulSelect"]]["calendarAddDateTime"]=$modulOperationCFG[4];
						$_SESSION[$config["modulSelect"]."backScreen"]="#".substr($config[$config["modulSelect"]]["calendarAddDateTime"],11);
						}
					if ($modulOperationCFG[3]=="date")
						{
						$config[$config["modulSelect"]]["calendarAddDate"]=$modulOperationCFG[4];
						}
					}
				else if ($config["modulAction"]=="edit")
					{
					$config["modulRecordID"]=$modulOperationCFG[3];
					$config[$config["modulSelect"]]["calendarAddDateTime"]=$modulOperationCFG[4];
					$_SESSION[$config["modulSelect"]."backScreen"]="#".substr($config[$config["modulSelect"]]["calendarAddDateTime"],11);
					}
				else if ($config["modulAction"]=="view")
					{
					$config["modulRecordID"]=$modulOperationCFG[3];
					$config[$config["modulSelect"]]["calendarAddDateTime"]=$modulOperationCFG[4];
					$_SESSION[$config["modulSelect"]."backScreen"]="#".$config[$config["modulSelect"]]["calendarAddDateTime"];
					}
				else if (isset($modulOperationCFG[3]) && !empty($modulOperationCFG[3]) &&
					isset($modulOperationCFG[4]) && !empty($modulOperationCFG[4]))
					{
					$config["calendarType"]=$modulOperationCFG[3];
					if ($modulOperationCFG[3]=="date")
						{
						$config["calendarDate"]=$modulOperationCFG[4];
						if ($_SESSION["nocore_reservationAction"]=="edit")
							{
							$config["modulAction"]=$_SESSION["nocore_reservationAction"];
							$config["modulRecordID"]=$_SESSION["nocore_reservationItem"];
							}
						if ($_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."Type"]!="journal")
							{
							$config["calendarType"]="daily";
							$config["calendarListType"]="daily";
							}
						$config["calendarYear"]=date("Y");
						$config["calendarMonth"]=date("m");
						}
					if ($modulOperationCFG[3]=="daily")
						{
						$config["calendarDate"]=$modulOperationCFG[4];
						$config["calendarType"]="daily";
						$config["calendarListType"]="daily";
						}
					else if ($modulOperationCFG[3]=="year")
						{
						$config["calendarYear"]=$modulOperationCFG[4];
						}
					else if ($modulOperationCFG[3]=="month")
						{
						$config["calendarYear"]=substr($modulOperationCFG[4],0,4);
						$config["calendarMonth"]=substr($modulOperationCFG[4],5,2);
						if ($_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."Type"]!="journal")
							{
							$config["calendarType"]="monthly";
							$config["calendarListType"]="monthly";
							}
						}
					else if ($modulOperationCFG[3]=="monthly")
						{
						$config["calendarYear"]=substr($modulOperationCFG[4],0,4);
						$config["calendarMonth"]=substr($modulOperationCFG[4],5,2);
						$config["calendarType"]="month";
						$config["calendarListType"]="monthly";
						}
					else if ($modulOperationCFG[3]=="week")
						{
						$config["calendarYear"]=substr($modulOperationCFG[4],0,4);
						$config["calendarWeek"]=substr($modulOperationCFG[4],5,2);
						if ($_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."Type"]!="journal")
							{
							$config["calendarType"]="weekly";
							$config["calendarListType"]="weekly";
							}
						}
					else if ($modulOperationCFG[3]=="weekly")
						{
						$config["calendarYear"]=substr($modulOperationCFG[4],0,4);
						$config["calendarWeek"]=substr($modulOperationCFG[4],5,2);
						$config["calendarType"]="weekly";
						$config["calendarListType"]="weekly";
						}
					else if ($modulOperationCFG[3]=="journal")
						{
						$config["calendarType"]="journal";
						$config["calendarListType"]="journal";
						}
					}
				else
					{
//					$config["calendarDate"]="date";

					$config["calendarType"]="daily";
					$config["calendarListType"]="daily";
					$_SESSION["calendarSelectedDay"]=date("d",time());
					$_SESSION["calendarSelectedDate"]=date("Y-m-d",time());
					$config["calendarYear"]=date("Y");
					unset($_SESSION["calendarWeek"]);
					unset($_SESSION["calendarYear"]);
					unset($_SESSION["calendarMonth"]);
					}
				if (isset($config["calendarDate"]) && !empty($config["calendarDate"]))
					{
					$_SESSION["calendarSelectedDay"]=substr($config["calendarDate"],8,2);
					$_SESSION["calendarSelectedDate"]=$config["calendarDate"];
					unset($_SESSION["calendarWeek"]);
					unset($_SESSION["calendarYear"]);
					unset($_SESSION["calendarMonth"]);
					}
				else if (isset($config["calendarMonth"]) && !empty($config["calendarMonth"]))
					{
					$_SESSION["calendarYear"]=$config["calendarYear"];
					$_SESSION["calendarMonth"]=$config["calendarMonth"];
					unset($_SESSION["calendarSelectedDay"]);
					unset($_SESSION["calendarSelectedDate"]);
					unset($_SESSION["calendarWeek"]);
					}
				else if (isset($config["calendarWeek"]) && !empty($config["calendarWeek"]))
					{
					$_SESSION["calendarYear"]=$config["calendarYear"];
					$_SESSION["calendarWeek"]=$config["calendarWeek"];
					$config["calendarMonth"] = date('m', strtotime($config["calendarYear"]."-W".sprintf("%02s",$config["calendarWeek"])."-1"));
					unset($_SESSION["calendarSelectedDay"]);
					unset($_SESSION["calendarSelectedDate"]);
					unset($_SESSION["calendarMonth"]);
					}
				else if (isset($config["calendarYear"]) && !empty($config["calendarYear"]))
					{
					$_SESSION["calendarYear"]=$config["calendarYear"];
					unset($_SESSION["calendarSelectedDay"]);
					unset($_SESSION["calendarSelectedDate"]);
					unset($_SESSION["calendarMonth"]);
					unset($_SESSION["calendarWeek"]);
					}
				else
					{
/*
					$_SESSION["calendarSelectedDay"]=date("d",time());
					$_SESSION["calendarSelectedDate"]=date("Y-m-d",time());
					unset($_SESSION["calendarWeek"]);
					unset($_SESSION["calendarYear"]);
					unset($_SESSION["calendarMonth"]);
*/
					}
				break;
				}
			case "order":
				{
				$config["modulAction"]="list";
				$config["modulSelect"]=$modulOperationCFG[1];
				$config[$modulOperationCFG[1]."order"]=$modulOperationCFG[2];
				break;
				}
			case "start":
				{
				$config["modulAction"]="list";
				$config["modulSelect"]=$modulOperationCFG[1];
				$config[$config["modulSelect"]."start"]=$modulOperationCFG[2];
				break;
				}
			case "yesOrNo":
				{
				$config["modulAction"]="list";
				$config["modulSelect"]=$modulOperationCFG[1];
				$config[$config["modulSelect"]."changeYesNo"]=$modulOperationCFG[2];
				$config[$config["modulSelect"]."modulTable"]=$modulOperationCFG[1];
				$config[$config["modulSelect"]."changeRecord"]=$modulOperationCFG[4];
				$config[$config["modulSelect"]."actPermission"]=$modulOperationCFG[3];
				break;
				}
			case "simple":
				{
				$config["modulSimpleAction"]=$modulOperationCFG[1];
				if (isset($modulOperationCFG[2]) && !empty($modulOperationCFG[2]))
					{
					$config["modulSimpleSelect"]=$modulOperationCFG[2];
					}
				break;
				}
			case "simpleItem":
				{
				$config["modulSimpleAction"]=$modulOperationCFG[1];
				$config["modulSimpleSelect"]=$modulOperationCFG[2];
				$config["modulSimpleRecordID"]=$modulOperationCFG[3];
				break;
				}
			case "description":
				{
				$config["modulAction"]="list";
				$config["modulSelect"]=$modulOperationCFG[2];
				$config[$config["modulSelect"]."cmd"]="resetall";
				if (!isset($_SESSION[$config["modulSelect"]]["desription"])) {
					$_SESSION[$config["modulSelect"]]["desription"]="1";
				} else {
					if ($_SESSION[$config["modulSelect"]]["desription"]==1) {
						$_SESSION[$config["modulSelect"]]["desription"]=0;
					} else {
						$_SESSION[$config["modulSelect"]]["desription"]=1;
					}
				}
				break;
				}
			}
		}
	return $config;
	}

function viewConfig($config,$viewItem)
	{
 	if (isset($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_nocore_sealNumber"]) &&
		!empty($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_nocore_sealNumber"]))
		{
//		$viewItem["configShare_sealNumber"]=0;
		}
	else
		{
//		$viewItem["configShare_sealNumber"]=1;
		}
	if (isset($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_core_localserverID"]) &&
		!empty($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_localserverID"]))
		{
		$viewItem[$config["modulSelect"].'_x_core_localserverID']=0;
		$viewItem[$config["modulSelect"].'_s_core_localserverID']=0;
		$viewItem['configShare_x_core_localserverID']=0;
		$viewItem['configShare_s_core_localserverID']=0;
		}
	else
		{
		$viewItem[$config["modulSelect"].'_x_core_localserverID']=1;
		$viewItem[$config["modulSelect"].'_s_core_localserverID']=1;
		$viewItem['configShare_x_core_localserverID']=1;
		$viewItem['configShare_s_core_localserverID']=1;
		}
	if ($config["localserverOnly"]==1)
		{
		$viewItem[$config["modulSelect"].'_x_core_localserverID']=0;
		$viewItem[$config["modulSelect"].'_s_core_localserverID']=0;
		$viewItem['configShare_x_core_localserverID']=0;
		$viewItem['configShare_s_core_localserverID']=0;
		}
	if ($viewItem[$config["modulSelect"].'_x_core_localserverID']+$viewItem[$config["modulSelect"].'_x_nocore_doctorID']>0)
		{
		$viewItem['configShare_searchFilter']=1;
		}
	else
		{
		$viewItem['configShare_searchFilter']=0;
		}
	if (isset($_REQUEST["s_core_localserverID"]))
		{
		if (!empty($_REQUEST["s_core_localserverID"])) {$viewItem[$config["modulSelect"]."_x_core_localserverID"]=0;}
		else {$viewItem[$config["modulSelect"]."_x_core_localserverID"]=1;}
		}
	else if (isset($_SESSION[$config["modulSelect"]."_s_core_localserverID"]) && !empty($_SESSION[$config["modulSelect"]."_s_core_localserverID"]))
		{
		$viewItem[$config["modulSelect"]."_x_core_localserverID"]=0;
		}
	if ($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"]==2)
		{
		$viewItem[$config["modulSelect"].'_x_insertWhen']=1;
		}
	else
		{
		$viewItem[$config["modulSelect"].'_x_insertWhen']=0;
		}
	$viewItem["contentFrameMiniHead"]=0;
	return $viewItem;
	}

function minuteCalc($minuteValue)
	{
	if (!empty($minuteValue))
		{
		return $minuteValue*60;
		}
	else
		{
		return $minuteValue;
		}
	}


function actualImgPath($config,$itemValues)
	{
	$config["configShare"]["localserverPath"]="";
	if (isset($config["core_localserverID"]) && !empty($config["core_localserverID"]))
		{
		$config["configShare"]["localserverPath"]=substr($config["core_localserverName"],0,3)."/";
		}
	else if (isset($itemValues["x_core_localserverID"]) && !empty($itemValues["x_core_localserverID"]))
		{
		$core_localserverSQL = "SELECT * FROM core_localserver WHERE id=".$itemValues["x_core_localserverID"];
		$core_localserverRec=$config["dbConnect"]->prepare($core_localserverSQL);
		$core_localserverRec->execute();
		$core_localserverCount = $core_localserverRec->rowCount();
		if ($core_localserverCount == 1)
			{
			$rowLocalserver=$core_localserverRec->fetch();
			$config["core_localserverName"]=$rowLocalserver["name"];
			$config["configShare"]["localserverPath"]=substr($config["core_localserverName"],0,3)."/";
			}
		}
	if ($config[$config["modulSelect"]]["hide"] != "1")
		{
		$actualImgPath = $config["configShare"]["docrootPath"].$config["configShare"]["localserverPath"].$config[$config["modulSelect"]]["imgPath"];
		}
	else
		{
		$actualImgPath = $config["configShare"]["docrootPathHide"].$config["configShare"]["localserverPath"].$config[$config["modulSelect"]]["imgPath"];
		}
	return $actualImgPath;
	}
?>

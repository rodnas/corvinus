<?php
function modulFrameEdit($config, $viewItem)
	{
	$config["deleteReally"]='';
	if (isset($_POST["back"]))
		{
		if (isset($_SESSION[$config["modulSelect"]."back"]) && !empty($_SESSION[$config["modulSelect"]."back"]))
			{
			$config[$config["modulSelect"]]["whichBack"]="?modulSelect=".$_SESSION[$config["modulSelect"]."back"]."&amp;modulAction=list&amp;".$_SESSION[$config["modulSelect"]."back"]."cmd=resetall";
			}
		unset($_SESSION[$config["modulSelect"]."back"]);
		if ($config["modulSelect"]=="nocore_reservation")
			{
			$config[$config["modulSelect"]]["whichBack"].=$_SESSION[$config["modulSelect"]."backScreen"];
			unset($_SESSION[$config["modulSelect"]."backScreen"]);
			$_SESSION["nocore_reservationAction"]="";
			unset($_SESSION["nocore_reservationAction"]);
			unset($_SESSION["nocore_reservationItem"]);
			}
		jumpToPage($config[$config["modulSelect"]]["whichBack"]);
		}
	$itemValues = itemValuesFromPOST($config, $config[$config["modulSelect"]]["mainTable"]);
	switch ($config["getAction"])
		{
		case "I": // get a record to display
			$itemValues = modulGetRecord($config, $config[$config["modulSelect"]]["mainTable"]);
			break;
		case "U": // update
			$itemValues = itemValuesFromPOST($config, $config[$config["modulSelect"]]["mainTable"]);
			$shareFieldCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##shareFieldCFG##","##/shareFieldCFG##");
			$shareFieldCFGDIM = explode('<#>',$shareFieldCFG);
			for ($i=0;$i<count($shareFieldCFGDIM);$i++)
				{
				if (!empty($shareFieldCFGDIM[$i]))
					{
					$shareFieldItem = explode('::',$shareFieldCFGDIM[$i]);
					$shareFieldItem[0]=trim($shareFieldItem[0]);
					switch ($shareFieldItem[1])
						{
						case "P":
							$itemValues["x_".$shareFieldItem[0]] = $_POST["x_".$shareFieldItem[0]];
							break;
						case "S":
							if (empty($itemValues["x_".$shareFieldItem[0]]) && isset($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_".$shareFieldItem[0]]))
								{
								$itemValues["x_".$shareFieldItem[0]] = $_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_".$shareFieldItem[0]];
								}
							break;
						case "F":
							$itemValues["x_".$shareFieldItem[0]] = $_FILES["x_".$shareFieldItem[0]]["name"];
							break;
						}
					}
				}
			$config = modulFrameCheck($config, $itemValues, $viewItem);
			if ($config["x_errorText"] == 'NULL' || $config["x_errorText"] == "")		
				{
				$inputCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##modulEditCFG##","##/modulEditCFG##");
				$modulEditParamDIM = explode('<#>',$inputCFG);
				$actualImgPath = actualImgPath($config,$itemValues);
				for ($editFieldCount=0;$editFieldCount<count($modulEditParamDIM);$editFieldCount++)
					{
					$modulEditFieldDIM = explode('<=>',trim($modulEditParamDIM[$editFieldCount]));
					switch ($modulEditFieldDIM[0])
						{
						case "checkbox":
							if (isset($_POST[$modulEditFieldDIM[1]]))
								{
								$itemValues[$modulEditFieldDIM[1]]=1;
								}
							else
								{
								$itemValues[$modulEditFieldDIM[1]]="0";
								}   
							break;
						case "pictureAdd":
							$itemValues[trim($modulEditFieldDIM[1])] = @$_POST[trim($modulEditFieldDIM[1])];
							if (@$_FILES[$modulEditFieldDIM[1]]['name']!="") 
								{
								$imagetype = @$_FILES[$modulEditFieldDIM[1]]['type'];
								if (($imagetype=="image/pjpeg")	|| ($imagetype=="image/jpeg") || ($imagetype=="image/jpg")
									|| ($imagetype=="image/gif") || ($imagetype=="image/png"))
									{
									if (($imagetype=="image/pjpeg") || ($imagetype=="image/jpeg") || ($imagetype=="image/jpg"))
										{
										$extension = ".jpg";
										}
									if (($imagetype=="image/gif"))
										{
										$extension = ".gif";
										}
									if (($imagetype=="image/png"))
										{
										$extension = ".png";
										}
									$pictureNameSAVE = substr(@$_FILES[$modulEditFieldDIM[1]]['name'],0,strpos(@$_FILES[$modulEditFieldDIM[1]]['name'],"."))."_".$itemValues["x_id"]. $extension;
									$dirMake = rmkdir($actualImgPath, 0755);
									$pictureNameOrig = realPath($actualImgPath)."/".$pictureNameSAVE;
									move_uploaded_file(@$_FILES[$modulEditFieldDIM[1]]['tmp_name'],$pictureNameOrig);
									chmod($pictureNameOrig,0755);
									$itemValues[$modulEditFieldDIM[1]] = $pictureNameSAVE;
									}
								}
							break;
						case "pictureResizeAdd":
							$itemValues[$modulEditFieldDIM[1]] = @$_POST[$modulEditFieldDIM[1]];
							if (@$_FILES[$modulEditFieldDIM[1]]['name']!="") 
								{
								$imagetype = @$_FILES[$modulEditFieldDIM[1]]['type'];
								if (($imagetype=="image/pjpeg")	|| ($imagetype=="image/jpeg") || ($imagetype=="image/jpg")
									|| ($imagetype=="image/gif") || ($imagetype=="image/png"))
									{
									if (($imagetype=="image/pjpeg") || ($imagetype=="image/jpeg") || ($imagetype=="image/jpg"))
										{
										$extension = ".jpg";
										}
									if (($imagetype=="image/gif"))
										{
										$extension = ".gif";
										}
									if (($imagetype=="image/png"))
										{
										$extension = ".png";
										}
									$pictureNameSAVE = substr(@$_FILES[$modulEditFieldDIM[1]]['name'],0,strpos(@$_FILES[$modulEditFieldDIM[1]]['name'],"."))."_".$itemValues["x_id"]. $extension;
									$dirMake = rmkdir($actualImgPath, 0755);
									$pictureNameOrig = realPath($actualImgPath)."/".$pictureNameSAVE;
									move_uploaded_file(@$_FILES[$modulEditFieldDIM[1]]['tmp_name'],$pictureNameOrig);
									chmod($pictureNameOrig,0644);
									$pictureNameSmallSAVE = $config["modulSelect"]."_".$itemValues["x_id"].setConfigValue($config,$config["modulSelect"],"pictSmallNamePlus"). $extension;
									$pictureNameSmallOrig = realPath($actualImgPath)."/".$pictureNameSmallSAVE;
									pictureresize($pictureNameOrig,$pictureNameSmallOrig,setConfigValue($config,$config["modulSelect"],"pictSmallWidth"),setConfigValue($config,$config["modulSelect"],"pictSmallHeight"));
									chmod($pictureNameSmallOrig,0644);
									$pictureNameNormalSAVE = $config["modulSelect"]."_".$itemValues["x_id"].setConfigValue($config,$config["modulSelect"],"pictNormalNamePlus"). $extension;
									$pictureNameNormalOrig = realPath($actualImgPath)."/".$pictureNameNormalSAVE;
									pictureresize($pictureNameOrig,$pictureNameNormalOrig,setConfigValue($config,$config["modulSelect"],"pictNormalWidth"),setConfigValue($config,$config["modulSelect"],"pictNormalHeight"));
									chmod($pictureNameNormalOrig,0644);
									$itemValues[$modulEditFieldDIM[1]] = $pictureNameSAVE;
									}
								}
							break;
						case "logoAdd":
							$itemValues[$modulEditFieldDIM[1]] = @$_POST[$modulEditFieldDIM[1]];
							if (@$_FILES[$modulEditFieldDIM[1]]['name']!="") 
								{
								$imagetype = @$_FILES[$modulEditFieldDIM[1]]['type'];
								if (($imagetype=="image/pjpeg")	|| ($imagetype=="image/jpeg") || ($imagetype=="image/jpg")
									|| ($imagetype=="image/gif") || ($imagetype=="image/png"))
									{
									if (($imagetype=="image/pjpeg") || ($imagetype=="image/jpeg") || ($imagetype=="image/jpg"))
										{
										$extension = ".jpg";
										}
									if (($imagetype=="image/gif"))
										{
										$extension = ".gif";
										}
									if (($imagetype=="image/png"))
										{
										$extension = ".png";
										}
									$pictureNameSAVE = substr(@$_FILES[$modulEditFieldDIM[1]]['name'],0,strpos(@$_FILES[$modulEditFieldDIM[1]]['name'],"."))."_".$itemValues["x_id"]. $extension;
									$dirMake = rmkdir($actualImgPath, 0755);
									$pictureNameOrig = realPath($actualImgPath)."/".$pictureNameSAVE;
									move_uploaded_file(@$_FILES[$modulEditFieldDIM[1]]['tmp_name'],$pictureNameOrig);
									chmod($pictureNameOrig,0644);
									$pictureNameSmallSAVE = $config["modulSelect"]."_".$itemValues["x_id"].setConfigValue($config,$config["modulSelect"],"pictSmallNamePlus"). $extension;
									$pictureNameSmallOrig = realPath($actualImgPath)."/".$pictureNameSmallSAVE;
									pictureresize($pictureNameOrig,$pictureNameSmallOrig,setConfigValue($config,$config["modulSelect"],"logoWidth"),setConfigValue($config,$config["modulSelect"],"logoHeight"));
									chmod($pictureNameSmallOrig,0644);
									$itemValues[$modulEditFieldDIM[1]] = $pictureNameSmallSAVE;
									}
								}
							break;
						case "fileAdd":
							$itemValues[$modulEditFieldDIM[1]] = @$_POST[$modulEditFieldDIM[1]];
							$fileNameElement = explode(".",@$_FILES[$modulEditFieldDIM[1]]['name']);
							$extension = ".".$fileNameElement[count($fileNameElement)-1];
							if (@$_FILES[$modulEditFieldDIM[1]]['name']!="")
								{
								$fileType = @$_FILES[$modulEditFieldDIM[1]]['type'];
								$dirMake = rmkdir($actualImgPath, 0755);
								$fileNameSAVE = substr(@$_FILES[$modulEditFieldDIM[1]]['name'],0,strpos(@$_FILES[$modulEditFieldDIM[1]]['name'],"."))."_".$itemValues["x_id"]. $extension;
								$fileNameOrig = realPath($actualImgPath)."/".$fileNameSAVE;
								move_uploaded_file(@$_FILES[$modulEditFieldDIM[1]]['tmp_name'],$fileNameOrig);
								chmod($fileNameOrig,0644);
								$itemValues[$modulEditFieldDIM[1]] = $fileNameSAVE;
								}
							break;
						case "active":
							if ($itemValues[$modulEditFieldDIM[1]]==$modulEditFieldDIM[2] && $itemValues["x_active"] != 1)
								{
								$itemValues["x_active"] = 1;
								}
							break;
						case "x_expirationdate":
							$itemValues[$modulEditFieldDIM[0]]=date('Y.m.d',mktime(0,0,0,substr($itemValues[$modulEditFieldDIM[1]],5,2),substr($itemValues[$modulEditFieldDIM[1]],8,2),substr($itemValues[$modulEditFieldDIM[1]],0,4)+1));
							break;
						case "default":
							break;
						}
					}
				// add the values into an array
				if (isset($_REQUEST["save"]) || isset($_REQUEST["saveNoBack"]))
					{
					$fieldList = makeFieldList($config, $itemValues, $config[$config["modulSelect"]]["mainTable"]);
					fieldListUpdateSQL($config, $fieldList);
					if (isset($_REQUEST["save"]))
						{
						if (isset($_SESSION[$config["modulSelect"]."back"]) && !empty($_SESSION[$config["modulSelect"]."back"]))
							{
							$config[$config["modulSelect"]]["whichBack"]="?modulSelect=".$_SESSION[$config["modulSelect"]."back"]."&amp;modulAction=list&amp;".$_SESSION[$config["modulSelect"]."back"]."cmd=resetall";
							}
						unset($_SESSION[$config["modulSelect"]."back"]);
						if ($config["modulSelect"]=="nocore_reservation")
							{
							$_SESSION["nocore_reservationAction"]="";
							unset($_SESSION["nocore_reservationAction"]);
							unset($_SESSION["nocore_reservationItem"]);
							$config[$config["modulSelect"]]["whichBack"].=$_SESSION[$config["modulSelect"]."backScreen"];
							unset($_SESSION[$config["modulSelect"]."backScreen"]);
							jumpToPage($config[$config["modulSelect"]]["whichBack"]);
							}
						else
							{
							$_SESSION["nocore_reservationAction"]="";
							unset($_SESSION["nocore_reservationAction"]);
							unset($_SESSION["nocore_reservationItem"]);
							jumpToPage($config[$config["modulSelect"]]["whichBack"]);
							}
						}
					}
				}		
		}
	$config["getAction"]="U";
	$config["contentEditHTML"] = modulFrameInputRecord($config,$itemValues,$config["getAction"], $viewItem);
	$config["x_id"]=$itemValues["x_id"];
	$config["navigationHTML"] = footerNavigation($config);
	$config["actionForm"]=$_SERVER["SCRIPT_NAME"]."?modulSelect=".$config["modulSelect"]."&modulAction=".$config["modulAction"];
//	$config[$config['modulSelect']]['input']='';
	$editHTML = iniCFGParser($config["sharedTPL"]["iniCFG"],"##editForm##","##/editForm##");
	$config["contentHTML"]=parseContent($editHTML,$config,$itemValues);
	return $config;
	}
?>
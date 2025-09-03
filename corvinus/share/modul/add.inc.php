<?php
function modulFrameAdd($config, $viewItem)
	{
	$config["deleteReally"]='';
	if (isset($_REQUEST["back"]))
		{
		jumpToPage($config[$config["modulSelect"]]["whichBack"]);
		}
	$makeActive = '1';
	$beforeAddCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##beforeAddIDCFG##","##/beforeAddIDCFG##");
	$beforeAddFieldCFG = explode('<#>',$beforeAddCFG);
	for ($beforeAddFieldCFGCount=0;$beforeAddFieldCFGCount<count($beforeAddFieldCFG);$beforeAddFieldCFGCount++)
		{
		$beforeAddItemCFG = explode('<=>',$beforeAddFieldCFG[$beforeAddFieldCFGCount]);
		switch ($beforeAddItemCFG[0])
			{
			case "prevkey":
				$itemValues[$beforeAddItemCFG[1]]=$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."_prev_key"];
				break;
			}
		}
	$config["modulOperationNow"]="item::add::".$config["modulSelect"]."::";
	switch ($config["getAction"])
		{
		case "C": // get a record to display
			$addSQL = "SELECT * FROM " . $config[$config["modulSelect"]]["mainTable"] . " WHERE " . $config[$config["modulSelect"]]["sqlKey"];
			$addRec=$config["dbConnect"]->prepare($addSQL);
			$addRec->execute();
			$addRecCount = $addRec->rowCount();
			if ($addRecCount == 0)
				{
				jumpToPage($config[$config["modulSelect"]]["whichBack"]);
				}
			else
				{
				$config[$config["modulSelect"]]["resultRow"] = $addRec->fetch();
				$itemValues = itemValuesFromDB($config, $config[$config["modulSelect"]]["mainTable"] );
				if ($config["modulSelect"]=="core_messagewall")
					{
					$itemValues["x_targetUserID"] = $itemValues["x_insertUserID"];
					$itemValues["x_answer_id"] = $itemValues["x_id"];
					$config["x_predescription"] = $itemValues["x_description"];
					$itemValues["x_description"] = "";
					}
				}
			break;
		case "A": // add
			if (!isset($config[$config["modulSelect"]]["importTable"]) && $config["modulAction"]!="import")
				{
				$itemValues = itemValuesFromPOST($config, $config[$config["modulSelect"]]["mainTable"]);
				}
			else
				{
				$itemValues = itemValuesFromPOST($config, $config[$config["modulSelect"]]["importTable"]);
				$itemValues["x_importName"]=$_POST["x_importName"];
				$itemValues["x_description"]=$_POST["x_description"];
				}
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
			if (strtolower($itemValues["x_description"])=="<br>")
				{
				$itemValues["x_description"]="";
				}
			$config = modulFrameCheck($config, $itemValues, $viewItem);
			if ($config["x_errorText"] == 'NULL' || $config["x_errorText"] == "")		
				{
				// add the values into an array
				$makeActive = '1';
				if (isset($config[$config["modulSelect"]]["importTable"]) || $config["modulAction"]=="import")
					{
					require ($config["systemROOT"].$config["configShare"]["modulFramePath"]."import.inc.php");
					jumpToPage($config[$config["modulSelect"]]["whichBack"]);
					break;
					}
				$beforeAddCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##beforeAddCFG##","##/beforeAddCFG##");
				$beforeAddFieldCFG = explode('<#>',$beforeAddCFG);
				for ($beforeAddFieldCFGCount=0;$beforeAddFieldCFGCount<count($beforeAddFieldCFG);$beforeAddFieldCFGCount++)
					{
					$beforeAddItemCFG = explode('<=>',$beforeAddFieldCFG[$beforeAddFieldCFGCount]);
					switch (trim($beforeAddItemCFG[0]))
						{
						case "prevkey":
							$itemValues[$beforeAddItemCFG[1]]=$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"]."_prev_key"];
							break;
						case "configsID":
							$configsIDSQL = "SELECT * FROM core_configs WHERE modul='".$beforeAddItemCFG[1]."'";
							$configsIDRec=$config["dbConnect"]->prepare($configsIDSQL);
							$configsIDRec->execute();
							$configsIDROW=$configsIDRec->fetch();
							$itemValues["x_".$beforeAddItemCFG[0]]=$configsIDROW["id"];
							break;
						case "notActive":
							$makeActive = '0';
							break;
						case "datetime":
							$itemValues[$beforeAddItemCFG[1]]=db_actual_datetime();
							break;
						case "products_status":
							$itemValues["x_".$beforeAddItemCFG[1]]=$beforeAddItemCFG[2];
							break;
						case "member":
							if (empty($itemValues[$beforeAddItemCFG[1]]))
								{
								$itemValues[$beforeAddItemCFG[1]] = $config["configShare"]["registrationUserLevel"];
								}
							break;
						case "genActivationCode":
							$itemValues[$beforeAddItemCFG[1]] = md5($itemValues[$beforeAddItemCFG[2]]);
							break;
						case "genNewsletterAccount":
							if (isset($_POST["x_newsletter"]) && !empty($_POST["x_newsletter"])) 
								{
								$itemValues["x_newsletter"]=1;
								$itemValues["x_activation_code"]=md5($itemValues["x_name"]);
								$insertSQL="INSERT INTO newsletter (name, email, activationCode, regmailWhen) VALUES ";
								$insertSQL .= "('".$itemValues["x_surname"]." ".$itemValues["x_forename"]."', '".$itemValues["x_email"]."', '".$itemValues["x_activationCode"]."', '".db_actual_datetime()."')";
								$config["dbConnect"]->exec($insertSQL);
								$newsletterAccountLast="".$config["dbConnect"]->lastInsertId()."";
								$config = regNewsletterMailSend($itemValues, $config, $newsletterAccountLast);
								}
							break;
						}
					}
				$itemValues["x_active"] = $makeActive;
				$itemValues["x_insertUserID"] = @$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"];
				$itemValues["x_insertWhen"] = db_actual_datetime();
				if (($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 2 ||
					$_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 3) && 
					$config["modulSelect"] != "support" && $config["modulSelect"] != "core_messagewall")
					{
					$itemValues["x_isReadWhen"] = db_actual_datetime();
					$itemValues["x_isReadUserID"] = @$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"];
					}
				if (isset($_REQUEST["save"]) || isset($_REQUEST["saveNoBack"]))
					{
					$fieldList = makeFieldList($config, $itemValues, $config[$config["modulSelect"]]["mainTable"]);
					if ($config["modulSelect"]!="core_messagewall")
						{
						fieldListInsertSQL($config, $fieldList);
						}
					else
						{
						if (empty($itemValues["x_targetGroupID"]))
							{

							fieldListInsertSQL($config, $fieldList);
//							$config = messagewallMail($itemValues["x_targetUserID"], $config);
							}
						else
							{
							$itemValues["x_active"] = 1;
							$itemValues["x_insertUserID"] = @$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"];
							$itemValues["x_insertWhen"] = db_actual_datetime();;
							$config[$config["modulSelect"]]["messageWhoSQL"] = "SELECT * FROM core_users WHERE active=1 AND groupsID = ".$itemValues["x_targetGroupID"];
							$messageRec=$config["dbConnect"]->prepare($config[$config["modulSelect"]]["messageWhoSQL"]);
							$messageRec->execute();
							while ($messageWhoROW = $messageRec->fetch())
								{
								$itemValues["x_targetUserID"]=$messageWhoROW["id"];
								$fieldList = makeFieldList($config, $itemValues, $config[$config["modulSelect"]]["mainTable"]);
								fieldListInsertSQL($config, $fieldList);
//								$config = ($itemValues["x_targetUserID"], $config);
								}
							$itemValues["x_targetUserID"]="";
							}
						}
					$makeActive = '1';
					$afterAddCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##afterAddCFG##","##/afterAddCFG##");
					$afterAddFieldCFG = explode('<#>',$afterAddCFG);
					$actualImgPath = actualImgPath($config,$itemValues);
					for ($afterAddFieldCFGCount=0;$afterAddFieldCFGCount<count($afterAddFieldCFG);$afterAddFieldCFGCount++)
						{
						$afterAddItemCFG = explode('<=>',$afterAddFieldCFG[$afterAddFieldCFGCount]);
						switch ($afterAddItemCFG[0])
							{
							case "pictureAdd":
								$itemValues[$afterAddItemCFG[1]] = @$_POST[$afterAddItemCFG[1]];
								if (@$_FILES[$afterAddItemCFG[1]]['name']!="") 
									{
									$imagetype = @$_FILES[$afterAddItemCFG[1]]['type'];
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
										$pictureNameSAVE = substr(@$_FILES[$afterAddItemCFG[1]]['name'],0,strpos(@$_FILES[$afterAddItemCFG[1]]['name'],"."))."_".$last_id. $extension;
										$dirMake = rmkdir($actualImgPath, 0755);
										$pictureNameOrig = realPath($actualImgPath)."/".$pictureNameSAVE;
										move_uploaded_file(@$_FILES[$afterAddItemCFG[1]]['tmp_name'],$pictureNameOrig);
										chmod($pictureNameOrig,0644);
										chmod($pictureNameSmallOrig,0644);
										$itemValues[$afterAddItemCFG[1]] = $pictureNameSAVE;
										}
									}
								$theValue = (!get_magic_quotes_gpc()) ? addslashes($itemValues[$afterAddItemCFG[1]]) : $itemValues[$afterAddItemCFG[1]];
								$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
								$fieldList["`$afterAddItem[2]`"] = $theValue;
								break;
							case "pictureResizeAdd":
								$itemValues[$afterAddItemCFG[1]] = @$_POST[$afterAddItemCFG[1]];
								if (@$_FILES[$afterAddItemCFG[1]]['name']!="") 
									{
									$imagetype = @$_FILES[$afterAddItemCFG[1]]['type'];
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
										$pictureNameSAVE = substr(@$_FILES[$afterAddItemCFG[1]]['name'],0,strpos(@$_FILES[$afterAddItemCFG[1]]['name'],"."))."_".$last_id. $extension;
										$dirMake = rmkdir($actualImgPath, 0755);
										$pictureNameOrig = realPath($actualImgPath)."/".$pictureNameSAVE;
										move_uploaded_file(@$_FILES[$afterAddItemCFG[1]]['tmp_name'],$pictureNameOrig);
										chmod($pictureNameOrig,0644);
										$pictureNameSmallSAVE = $config["modulSelect"]."_".$last_id.setConfigValue($config,$config["modulSelect"],"pictSmallNamePlus").$extension;
										$pictureNameSmallOrig = realPath($actualImgPath)."/".$pictureNameSmallSAVE;
										pictureresize($pictureNameOrig,$pictureNameSmallOrig,setConfigValue($config,$config["modulSelect"],"pictSmallWidth"),setConfigValue($config,$config["modulSelect"],"pictSmallHeight"));
										chmod($pictureNameSmallOrig,0644);
										$pictureNameNormalSAVE = $config["modulSelect"]."_".$last_id.setConfigValue($config,$config["modulSelect"],"pictNormalNamePlus"). $extension;
										$pictureNameNormalOrig = realPath($actualImgPath)."/".$pictureNameNormalSAVE;
										pictureresize($pictureNameOrig,$pictureNameNormalOrig,setConfigValue($config,$config["modulSelect"],"pictNormalWidth"),setConfigValue($config,$config["modulSelect"],"pictNormalHeight"));
										chmod($pictureNameNormalOrig,0644);
										$itemValues[$afterAddItemCFG[1]] = $pictureNameSAVE;
										}
									}
								$theValue = (!get_magic_quotes_gpc()) ? addslashes($itemValues[$afterAddItemCFG[1]]) : $itemValues[$afterAddItemCFG[1]];
								$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
								$fieldList["`$afterAddItemCFG[2]`"] = $theValue;
								break;
							case "fileAdd":
								$itemValues[$afterAddItemCFG[1]] = @$_POST[$afterAddItemCFG[1]];
								$fileNameElement = explode(".",@$_FILES[$afterAddItemCFG[1]]['name']);
								$extension = ".".$fileNameElement[count($fileNameElement)-1];
								if (@$_FILES[$afterAddItemCFG[1]]['name']!="") 
									{
									$fileType = @$_FILES[$afterAddItemCFG[1]]['type'];
									$dirMake = rmkdir($actualImgPath, 0755);
									$fileNameSAVE = substr(@$_FILES[$afterAddItemCFG[1]]['name'],0,strpos(@$_FILES[$afterAddItemCFG[1]]['name'],"."))."_".$last_id. $extension;
									$fileNameOrig = realPath($actualImgPath)."/".$fileNameSAVE;
									move_uploaded_file(@$_FILES[$afterAddItemCFG[1]]['tmp_name'],$fileNameOrig);
									chmod($fileNameOrig,0644);
									$itemValues[$afterAddItemCFG[1]] = $fileNameSAVE;
									}
								$theValue = (!get_magic_quotes_gpc()) ? addslashes($itemValues[$afterAddItemCFG[1]]) : $itemValues[$afterAddItemCFG[1]];
								$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
								$fieldList["`$afterAddItemCFG[2]`"] = $theValue;
								break;
							case "regUserMailSend":
								if (isset($itemValues[$afterAddItemCFG[3]]))
									{
									$config = regUserMailSend($itemValues, $config, $last_id);
									if (isset($config[$config["modulSelect"]]["noJump"]) && $config[$config["modulSelect"]]["noJump"] == 1)
										{
										$itemValues[$afterAddItemCFG[1]] = db_actual_datetime();
										$theValue = (!get_magic_quotes_gpc()) ? addslashes($itemValues[$afterAddItemCFG[1]]) : $itemValues[$afterAddItemCFG[1]];
										$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
										$fieldList["`$afterAddItemCFG[2]`"] = $theValue;
										}
									}
								break;
							case "regUserNewsletter":
								if (isset($itemValues[$afterAddItemCFG[3]]))
									{
									$config = regNewsletterMailSend($itemValues, $config, $last_id);
									if (isset($config[$config["modulSelect"]]["noJump"]) && $config[$config["modulSelect"]]["noJump"] == 1)
										{
										$itemValues[$afterAddItemCFG[1]] = db_actual_datetime();
										$theValue = (!get_magic_quotes_gpc()) ? addslashes($itemValues[$afterAddItemCFG[1]]) : $itemValues[$afterAddItemCFG[1]];
										$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
										$fieldList["`$afterAddItemCFG[2]`"] = $theValue;
										}
									}
								break;
							case "regNewsletterMailSend":
								if (isset($itemValues[$afterAddItemCFG[3]]))
									{
									$config = regNewsletterMailSend($itemValues, $config, $last_id);
									if (isset($config[$config["modulSelect"]]["noJump"]) && $config[$config["modulSelect"]]["noJump"] == 1)
										{
										$itemValues[$afterAddItemCFG[1]] = db_actual_datetime();
										$theValue = (!get_magic_quotes_gpc()) ? addslashes($itemValues[$afterAddItemCFG[1]]) : $itemValues[$afterAddItemCFG[1]];
										$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
										$fieldList["`$afterAddItemCFG[2]`"] = $theValue;
										}
									}
								break;
							case "active":
								if ($itemValues[$afterAddItemCFG[1]]==$afterAddItemCFG[2] && $itemValues["x_active"] != 1)
									{
									$itemValues["x_active"] = 1;
									}
								break;
							case "x_expirationdate":
								$itemValues[$afterAddItemCFG[0]]=date('Y.m.d',mktime(0,0,0,substr($itemValues[$afterAddItemCFG[1]],5,2),substr($itemValues[$afterAddItemCFG[1]],8,2),substr($itemValues[$afterAddItemCFG[1]],0,4)+1));
								break;
							}
						}
					$fieldList = makeFieldList($config, $itemValues, $config[$config["modulSelect"]]["mainTable"]);
					if (isset($afterAddCFG) && !empty($afterAddCFG))
						{
						$updateSQL = "UPDATE " . $config[$config["modulSelect"]]["mainTable"] . " SET ";
						foreach ($fieldList as $key=>$temp)
							{
							$updateSQL .= "$key = $temp, ";			
							}
						if (substr($updateSQL, -2) == ", ")
							{
							$updateSQL = substr($updateSQL, 0, strlen($updateSQL)-2);
							}
						$updateSQL .= " WHERE id=".$last_id;
						$config["dbConnect"]->exec($updateSQL);
						}
					}
				if (isset($_REQUEST["save"]) || isset($_REQUEST["saveNoBack"]))
					{
					unset($_SESSION[$config["configShare"]["whichSystemMode"]."modulSelect"]);
					unset($_SESSION[$config["configShare"]["whichSystemMode"]."modulAction"]);
					if (isset($_REQUEST["save"]))
						{
						jumpToPage($config[$config["modulSelect"]]["whichBack"]);
						}
					}
				}
		}
	$config["getAction"]="A";
	$config["contentAddHTML"] = modulFrameInputRecord($config,$itemValues,$config["getAction"], $viewItem);
	$config["navigationHTML"] = footerNavigation($config);
//	$config["actionForm"]=$_SERVER["SCRIPT_NAME"]."?modulSelect=".$config["modulSelect"]."&modulAction=".$config["modulAction"];
//	$config["actionForm"]=$_SERVER["SCRIPT_NAME"];
	$addHTML = iniCFGParser($config["sharedTPL"]["iniCFG"],"##addForm##","##/addForm##");
	$config["contentHTML"]=parseContent($addHTML,$config,$itemValues);
	return $config;
	}
?>
<?php
function modulFrameInputRecord($config, $p_itemValues, $p_getAction, $viewItem)
	{
	if (isset($_GET["templatePopup"]))
		{
		$config[$config["modulSelect"]."_x_templatePopupName"]=$config[$config["modulSelect"]]["templatePopupName"];
		}
	$inputCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##".$config[$config["modulSelect"]]["whichCFG"]."##","##/".$config[$config["modulSelect"]]["whichCFG"]."##");
	$config = inputMake($inputCFG,$config,$p_itemValues, $viewItem);
	$inputCFG = iniCFGParser($config["configShare"]["iniCFG"],"##".$config[$config["modulSelect"]]["whichCFG"]."##","##/".$config[$config["modulSelect"]]["whichCFG"]."##");
	$config = inputMake($inputCFG,$config,$p_itemValues, $viewItem);
	$inputForm = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##".$config[$config["modulSelect"]]["whichForm"]."##","##/".$config[$config["modulSelect"]]["whichForm"]."##");
	$inputForm = parseContent($inputForm,$config,"");
	$resultHTML = clearForm($config, $inputForm, $viewItem);
	$resultHTML .= modulPositionExplode($config, $p_itemValues, $viewItem);
	return $resultHTML;
	}

function modulPositionExplode($config, $p_itemValues, $viewItem)	
	{
	$resultHTML = "<SCRIPT type=\"text/javascript\" LANGUAGE=\"JavaScript\">";
	$resultHTML .= "switch (document.".$config["modulAction"]."form.fieldFocus.value)";
	$resultHTML .= "{";
	$positionCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##".$config[$config["modulSelect"]]["whichPosition"]."##","##/".$config[$config["modulSelect"]]["whichPosition"]."##");
	$positionItemsCFG = explode('<#>',$positionCFG);
	for ($positionItemCFGCount=0;$positionItemCFGCount<count($positionItemsCFG);$positionItemCFGCount++)
		{
		$positionItemCFG = explode('<=>',trim($positionItemsCFG[$positionItemCFGCount]));
		if ((!ISSET($viewItem[$config["modulSelect"]."_".$positionItemCFG[0]]) || (ISSET($viewItem) && $viewItem[$config["modulSelect"]."_".$positionItemCFG[0]] != 0)) &&
			$viewItem[$config["modulSelect"]."_x_".$positionItemCFG[0]]!=1)
			{
			switch ($positionItemCFG[1])
				{
				case "case":
					$resultHTML .= "case '".$positionItemCFG[0]."' : document.".$config["modulAction"]."form.".$positionItemCFG[0].".focus();";
					$resultHTML .= "break;";
					break;
				case "default":
					$resultHTML .= "default : document.".$config["modulAction"]."form.".$positionItemCFG[0].".focus();";
					$resultHTML .= "break;";
					break;
				}
			}
		}
	$resultHTML .= "}";
	$resultHTML .= "</script>";
	return $resultHTML;
	}

function inputMake($inputCFG,$config,$p_itemValues, $viewItem)
	{
	$inputItemsCFG = explode('<#>',$inputCFG);
	for ($inputItemCFGCount=0;$inputItemCFGCount<count($inputItemsCFG);$inputItemCFGCount++)
		{
		$inputItemCFG = explode('<=>',trim($inputItemsCFG[$inputItemCFGCount]));
		switch ($inputItemCFG[0])
			{
			case "simple":
				$size=$inputItemCFG[2];
				$maxlength=$inputItemCFG[3];
				if (isset($config[$config["modulSelect"]."_".$inputItemCFG[1]."_disabled"])) 
					{
					$disabled = $config[$config["modulSelect"]."_".$inputItemCFG[1]."_disabled"];
					}
				else
					{
					$disabled='';
					}
				$config[$config["modulSelect"]."_".$inputItemCFG[1]]=htmlspecialchars($p_itemValues[$inputItemCFG[1]]);
				break;
			case "simpleDateTime":
				$config[$config["modulSelect"]."_".$inputItemCFG[1]]=substr($p_itemValues[$inputItemCFG[1]],0,16)."&nbsp;";
				break;
			case "password":
				$size=$inputItemCFG[2];
				$maxlength=$inputItemCFG[3];
				$config[$config["modulSelect"]."_".$inputItemCFG[1]]=htmlspecialchars($p_itemValues[$inputItemCFG[1]]);
				break;
			case "optionSelect":
				if ($config["modulSelect"]=="products" && $config["modulAction"]) {
					$p_itemValues["x_products_statusID"] = 1;
				}

				if (isset($inputItemCFG[6]) && !empty($inputItemCFG[6])) {$styleWidth = ' style="width:'.$inputItemCFG[6].'px;"';} else {$styleWidth = '';}
				if (isset($inputItemCFG[9]) && !empty($inputItemCFG[9])) {$onChange=' onchange="'.$inputItemCFG[7].';"';} else {$onChange='';}
				if (isset($inputItemCFG[8]) && !empty($inputItemCFG[8])) {$topicFilter=$inputItemCFG[8];} else {$topicFilter="";}

				$config[$config["modulSelect"]."_".$inputItemCFG[2]]="";
				$config[$config["modulSelect"]."_".$inputItemCFG[2]].=optionSelect($config,$inputItemCFG[1],$inputItemCFG[2],$inputItemCFG[3],$inputItemCFG[4],$p_itemValues,$config["modulSelect"]."_".$inputItemCFG[1],$topicFilter);
				if (isModulAdd($config,$inputItemCFG[1]))
					{
					if (isset($inputItemCFG[5]) && !empty($inputItemCFG[5]))
						{
						$config[$config["modulSelect"]."_".$inputItemCFG[1]."_a"] .= "<img alt='' src='" . setConfigValue($config,"configShare","imageButton") . "plus20x20.png' border=0 name='".$inputItemCFG[1]."add' title='".setConfigValue($config,$inputItemCFG[1],"title")." ".setConfigValue($config,"configShare","addTitle") ."'  onclick='loadModulAdd(\"".$inputItemCFG[7]."\",\"".$inputItemCFG[1]."\")'>";
						}
					}
				if (isModulAdd($config,$inputItemCFG[1]))
					{
					if (isset($inputItemCFG[5]) && !empty($inputItemCFG[5]))
						{
						$config[$config["modulSelect"]."_".$inputItemCFG[1]."_a"] .= "<img alt='' src='" . setConfigValue($config,"configShare","imageButton") . "plus20x20.png' border=0 name='".$inputItemCFG[1]."add' title='".setConfigValue($config,$inputItemCFG[1],"title")." ".setConfigValue($config,"configShare","addTitle") ."'  onclick='loadModulAdd(\"".$inputItemCFG[7]."\",\"".$inputItemCFG[1]."\")'>";
						}
					}
				break;
			case "prevView":
				$config[$config["modulSelect"]."_".$inputItemCFG[1]]=optionView($config,$inputItemCFG[1],$inputItemCFG[2],$inputItemCFG[3],$inputItemCFG[4],$p_itemValues);
				break;
			case "insertTime":
				$config[$config["modulSelect"]."_".$inputItemCFG[1]."Time"]="<b><i>" . substr(FormatDateTime($p_itemValues[$inputItemCFG[1]],4),0,5) . "</i></b>";
				break;
			case "simpleView":
				$config[$config["modulSelect"]."_".$inputItemCFG[1]]=$p_itemValues[$inputItemCFG[1]];
				break;
			case "uploadView":
				$size=$inputItemCFG[2];
				$maxlength=$inputItemCFG[3];
				$actualImgPath = actualImgPath($config,$p_itemValues);
				$config[$config["modulSelect"]."_".$inputItemCFG[1]."_p"] = $actualImgPath.$p_itemValues[$inputItemCFG[1]];
				$config[$config["modulSelect"]."_".$inputItemCFG[1]]='<input type="file" name="'.$inputItemCFG[1].'" id="'.$inputItemCFG[1].'" size="'.$size.'" maxlength=".$maxlength.." value="'.$config[document_x_downloadURL].'">';
//				$config[$config["modulSelect"]."_".$inputItemCFG[1]]=pictureView($config, $actualImgPath.$p_itemValues[$inputItemCFG[1]],"",$p_itemValues["x_sizeWidth"],$p_itemValues["x_sizeHeight"]);
				break;
			case "editorText":
				$config[$config["modulSelect"]."_".$inputItemCFG[1]]='<textarea id="'.$inputItemCFG[1].'" name="'.$inputItemCFG[1].'">'.htmlspecialchars($p_itemValues[$inputItemCFG[1]]).'</textarea>';
				if (empty($inputItemCFG[2]) || intval($inputItemCFG[2]) < 500) $inputItemCFG[2] = 500;
				if (empty($inputItemCFG[3]) || intval($inputItemCFG[3]) < 150) $inputItemCFG[3] = 150;
				break;
			case "simpleText":
				if (empty($inputItemCFG[2])) $inputItemCFG[2] = 60;
				if (empty($inputItemCFG[2])) $inputItemCFG[3] = 10;
				$rows=$inputItemCFG[2];
				$cols=$inputItemCFG[3];
				$config[$config["modulSelect"]."_".$inputItemCFG[1]]=htmlspecialchars($p_itemValues[$inputItemCFG[1]]);
				break;
			case "checkbox":
				if ($p_itemValues[$inputItemCFG[1]] == 1)
					{
					$config[$config["modulSelect"]."_".$inputItemCFG[1]]=" checked";
					}
				else
					{
					$config[$config["modulSelect"]."_".$inputItemCFG[1]]="";
					}
				break;
			case "datePanel":
				$config[$config["modulSelect"]."_".$inputItemCFG[1]]=htmlspecialchars($p_itemValues[$inputItemCFG[1]]);
				break;
			case "pictureView":
				$actualImgPath = actualImgPath($config,$p_itemValues);
				$config[$config["modulSelect"]."_".$inputItemCFG[1]."_p"] = $actualImgPath.$p_itemValues[$inputItemCFG[1]];
				$config[$config["modulSelect"]."_".$inputItemCFG[1]]=pictureView($config, $actualImgPath.$p_itemValues[$inputItemCFG[1]],"",$p_itemValues["x_sizeWidth"],$p_itemValues["x_sizeHeight"]);
				break;
			}
		}
	return $config;
	}
?>
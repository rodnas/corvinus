<?php
function topMenu($config)
	{
	$topMenuPositionCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##topMenuPositionCFG##","##/topMenuPositionCFG##");
	$topMenuItemPositionCFG = explode('<=>',$topMenuPositionCFG);
	$topSubMenuHTML ="";
	$topMenuCFG = iniCFGParser($config["configShare"]["iniCFG"],"##topMenuCFG##","##/topMenuCFG##");
	$topMenuItemCFG = explode('<#>',$topMenuCFG);
	$noMenuItem = Array();
	if (isset($config["configShare"]["noMenuItem"]))
		{
		$noMenuItem = explode('<#>',$config["configShare"]["noMenuItem"]);	
		}
	$topMenuHTML="<div id='topMainMenu'><div id='menuBox'>";
	$topSubMenuAdd=0;
	for ($topMenuItemCFGCount=0;$topMenuItemCFGCount<count($topMenuItemCFG);$topMenuItemCFGCount++)
		{
		$menuItemsActual = explode('<subMenu>',$topMenuItemCFG[$topMenuItemCFGCount]);
		$menuItemActual = trim($menuItemsActual[0]);
		if ((modulPermission($config,$menuItemActual) & ewAllowview) == ewAllowview && !in_array(trim($menuItemActual),$noMenuItem))
			{
			if ($topMenuItemCFGCount > 0 && !empty($config["topMenuSeparator"])) 
				{
				$topMenuHTML .= $config["topMenuSeparator"];
				}
			$actualAction = setConfigValue($config,$menuItemActual,"action");
			if ($menuItemActual == $config["modulSelect"]) {$menuCSSClass = 'topMenuTextActual';} else {$menuCSSClass = 'topMenuText';}
			if ($menuItemActual == trim($topMenuItemPositionCFG[0]))  {$menuCSSClass = 'topMenuTextActual';}
			$topSubMenuCFG = trim($menuItemsActual[1]);
			$subMenuYes = 1;
			$topSubMenuItemCFG = explode('<=>',$topSubMenuCFG);
			if (in_array($config["modulSelect"], $topSubMenuItemCFG)) {$subMenuYes=1;} else {$subMenuYes=0;}
			if ($subMenuYes==1)
				{
				if (isset($topSubMenuCFG) && !empty($topSubMenuCFG)) 
					{
					$topSubMenuHTML="<div id='topSubMenuBox'><div id='menuBox'>";
					$topSubMenuItemCFG = explode('<=>',$topSubMenuCFG);
					for ($topSubMenuItemCFGCount=0;$topSubMenuItemCFGCount<count($topSubMenuItemCFG);$topSubMenuItemCFGCount++)
						{
						$topSubMenuItemActual = $topSubMenuItemCFG[$topSubMenuItemCFGCount];
						if ((modulPermission($config,$topSubMenuItemActual) & ewAllowview) == ewAllowview && !array_key_exists(trim($menuItemActual),$noMenuItem))
							{
							if ($topSubMenuItemCFGCount > 0 && !empty($config["topMenuSeparator"])) 
								{
								$topSubMenuHTML .= $config["topMenuSeparator"];
								}
							$actualAction = setConfigValue($config,$topSubMenuItemActual,"action");
							if ($topSubMenuItemActual == $config["modulSelect"] || 
								(isset($topMenuItemPositionCFG[1]) && !empty($topMenuItemPositionCFG[1]) && $topMenuItemPositionCFG[1]==$topSubMenuItemActual) ) 
								{
								$topSubMenuCSSClass = 'topMenuTextActual';
								$menuCSSClass = 'topMenuTextActual';
								$topSubMenuAdd=1;
								}
							else
								{
								$topSubMenuCSSClass = 'topMenuText';
								}
							if ($topSubMenuItemCFGCount!=0) {
								if (empty($actualAction))
									{ 
									$topSubMenuHTML .= "<a title='' href='index.php?modulSelect=".$topSubMenuItemActual."&amp;modulAction=list&amp;".$topSubMenuItemActual."cmd=resetall' class='$topSubMenuCSSClass'>";
									}
							else
									{
									$topSubMenuHTML .= "<a title='' href='index.php?modulSelect=".$topSubMenuItemActual."&amp;modulAction=".$actualAction."&amp;".$topSubMenuItemActual."cmd=resetall' class='$topSubMenuCSSClass'>";
									}
								$topSubMenuHTML .= $config[$topSubMenuItemActual]["title"];
								$isNewItemCount = $config[$topSubMenuItemActual]["isNewItemCount"];
								if ($isNewItemCount==1 &&
									($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"] == 2 ||
									$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"] == 3))
									{
									$topMenuFilter = "isReadWhen IS NULL";
									$topMenuSQL = "SELECT COUNT(*) AS topMenuCount FROM ".$topSubMenuItemActual." WHERE " .$topMenuFilter;
									$topMenuRec=$config["dbConnect"]->prepare($topMenuSQL);
									$topMenuRec->execute();
									$topMenuCountDb = $topMenuRec->rowCount();
									$topMenuRec->closeCursor();
									if ($topMenuCountDb > 0)
										{
										$topMenuRow=$topMenuRec->fetch(PDO::FETCH_ASSOC);
										$topMenuCount = @$topMenuRow["topMenuCount"];
										if ($topMenuCount > 0)
											{
											$topSubMenuHTML .= "<span class='newitemcounttext'>&nbsp;(".$topMenuCount."&nbsp;".$config["configShare"]["newItem"].")</span>";
											}
										}
									}
								}
							$topSubMenuHTML .= "</a>";
							}
						}
					$topSubMenuHTML .= "</div><div style='clear:both'></div></div>";
					}
				}
			if (empty($actualAction))
				{ 
				$topMenuHTML .= "<a title='' href='index.php?modulSelect=".$menuItemActual."&amp;modulAction=list&amp;".$menuItemActual."cmd=resetall' class='$menuCSSClass'>";
				}
			else
				{
				$topMenuHTML .= "<a title='' href='index.php?modulSelect=".$menuItemActual."&amp;modulAction=".$actualAction."&amp;".$menuItemActual."cmd=resetall' class='$menuCSSClass'>";
				}
			$topMenuHTML .= $config[$menuItemActual]["title"];
			$isNewItemCount = $config[$menuItemActual]["isNewItemCount"];
			if ($isNewItemCount==1 &&
				($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"] == 2 ||
				$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"] == 3))
				{
				$topMenuFilter = "isReadWhen IS NULL";
				$topMenuSQL = "SELECT COUNT(*) AS topMenuCount FROM ".$menuItemActual." WHERE " .$topMenuFilter;
				$topMenuRec=$config["dbConnect"]->prepare($topMenuSQL);
				$topMenuRec->execute();
				$topMenuCountDb = $topMenuRec->rowCount();
				$topMenuRec->closeCursor();
				if ($topMenuCountDb > 0)
					{
					$topMenuRow=$topMenuRec->fetch(PDO::FETCH_ASSOC);
					$topMenuCount = @$topMenuRow["topMenuCount"];
					if ($topMenuCount > 0)
					if ($topMenuCount > 0)
						{
						$topMenuHTML .= "<span class='newitemcounttext'>&nbsp;(".$topMenuCount."&nbsp;".$config["configShare"]["newItem"].")</span>";
						}
					}
				}
			$topMenuHTML .= "</a>";
			}
		}
	$topMenuHTML .= "</div><div style='clear:both'></div></div>";
	if ($topSubMenuAdd==1)
		{
		$topMenuHTML .= $topSubMenuHTML;
		}
	$topMenuHTML = "<div id='contentText'><div id='topMenuText'>".$topMenuHTML."</div></div>";

	return $topMenuHTML;
	}

function loginService($config)
	{
	$loginServiceHTML = "";
	if ($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"] != 1) {
		if (setConfigValue($config,"configShare","onlyView") != 1 ) {
			$loginServiceHTML .= "<div id='loginBox'>";
			$loginServiceHTML .= "<div id='loginTextBox'>";
			$loginServiceHTML .= "<span class='loginText'>".@$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_User"];
			$loginServiceHTML .= "</span>";
			$loginServiceHTML .= "</div>";
			$loginServiceHTML .= "<div id='topServiceButton'>";
			$loginServiceHTML .= "<button title='".$config["configShare"]["myDataChangeTitle"]."' id='buttonTop' name='modulOperation' type='submit' value='item::mydata::core_users::".@$_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserID"]."::".$config["modulSelect"]."'><span class='glyphicon glyphicon-user ewIcon'></span></button>";
			$loginServiceHTML .= "<button title='".$config["configShare"]["passwordChangeTitle"]."' id='buttonTop' name='modulOperation' type='submit' value='item::passchange::core_users::".@$_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserID"]."::".$config["modulSelect"]."'><i class='fa fa-key' aria-hidden='true'></i></button>";
			if ($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"] != 1)
				{
				$loginServiceHTML .= "<button title='".$config["configShare"]["logoutTitle"]."' id='buttonTop' name='modulOperation' type='submit' value='simple::logout'><span class='glyphicon glyphicon-log-out ewIcon'></span></button>";
				}
			$loginServiceHTML .= "</div>";
			$loginServiceHTML .= "</div>";
		}
	} else {
		$loginServiceHTML .=  
		'<form id="loginForm" method="post" action="">
			<div id="itemTitle" style="">
				<label title="'.$config["configShare"]["loginNicknameLabelTitle"].'">'.$config["configShare"]["loginNicknameLabelTitle"].'</label>
				<input type="text" name="x_nickname" id="x_nickname" value="" />
			</div>
			<div id="itemTitle" style="float:left;margin-right:5px;">
				<label title="'.$config["configShare"]["loginPasswordLabelTitle"].'">'.
				'<span class="glyphicons glyphicons-keys"></span>'.
				$config["configShare"]["loginPasswordLabelTitle"].'</label>
				<input type="password" name="x_password" id="x_password" value="" />
			</div>
			<div style="float:left;"></div>
				<button title="'.$config["configShare"]["loginSubmitButtonTextTitle"].'" id="buttonTop" name="modulOperation" type="submit" value="login"<span class="glyphicon glyphicon-log-in"></span></button>
			</div>
			<div id="errorMess"></div>
			<div style="clear:both;height: 10px;"></div>
		</form>';
	}
	$config["loginServiceHTML"]=$loginServiceHTML;
	$config["topErrorMessageHTML"] = topErrorMessage($config);
	return $config;
}

function topStatus($config)
	{
	$topStatusHTML = "<div id='topStatusBox'><div style='float:left;'>";
	if ($config["modulSelect"] != "notLogged")
		{
		if (setConfigValue($config,"configShare","onlyView") != 1 || $_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"] > 1)
			{
			$topStatusHTML .= "<div id='topStatusButton'>";
			if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 2 
				AND $config["modulAction"] == "list")
				{	
/*
				$topStatusHTML .= "<a title='' href='index.php?modulSelect=configs&amp;modulAction=list&amp;configscmd=resetall&amp;whichModul=".$config["modulSelect"]."'>";
				$topStatusHTML .= "<img alt='' src='" . $config["configShare"]["imageButton"].$config["configShare"]["configsButton"]."' border=0 name='config_".$config["modulSelect"]."' class='buttonBox' title='".$config["core_configs"]["title"]."'>";
				$topStatusHTML .= "</a>";
*/
				}
			$topStatusHTML .= "</div>";
			$topStatusHTML .= "<div id='topStatusText'>";
			$topStatusHTML .= $config[$config["modulSelect"]]["title"];
			if ($config["modulSelect"]=="nocore_reservation")
				{
				if (isset($_SESSION["calendarSelectedDate"]))
					{
					$topStatusHTML .=" (".$_SESSION["calendarSelectedDate"].") ";
					}
				else if (isset($_SESSION["calendarWeek"]))
					{
					$topStatusHTML .=" (".$_SESSION["calendarYear"].". ".$_SESSION["calendarWeek"].". ".$config["configShare"]["weekTitle"].") ";
					}
				else if (isset($_SESSION["calendarMonth"]))
					{
					$months = array('Január', 'Február', 'Március', 'Április', 'Május', 'Június', 'Július', 'Augusztus', 'Szeptember', 'Október', 'November', 'December');
					$topStatusHTML .=" (".$_SESSION["calendarYear"].". ".$months[$_SESSION["calendarMonth"]-1].") ";
					}
				else if (isset($_SESSION["calendarYear"]))
					{
					$topStatusHTML .=" (".$_SESSION["calendarYear"].") ";
					}
				}
			if ($config["modulAction"] != "list")
				{
				$topStatusHTML .= "&nbsp;=>&nbsp;".$config["configShare"][$config["modulAction"]."Title"];
				}
			$topStatusHTML .= "</div>";
			}
		}
		$topStatusHTML .= "</div><div style='clear:both;'></div></div>";
	return $topStatusHTML;	
	}

function topAdmin($config)
	{
	$serviceMenuHTML = "";
	if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] > 1)
		{ 
		$topServiceCFG = iniCFGParser($config["configShare"]["iniCFG"],"##serviceMenuCFG##","##/serviceMenuCFG##");
		$isModulHTML = "";
		$serviceMenuHTMLStart = "<div id='adminBox'><div id='adminButton'>";
		$serviceMenuParamDIM = explode('<#>',$topServiceCFG);
		for ($serviceMenuCount=0;$serviceMenuCount<count($serviceMenuParamDIM);$serviceMenuCount++)
			{
			$serviceMenuFieldDIM = explode('#',rtrim(ltrim($serviceMenuParamDIM[$serviceMenuCount])));
			if (isModulView($config,$serviceMenuFieldDIM[0]))
				{
				if ($serviceMenuFieldDIM[0]=="core_users" && !isModulAdmin($config,$serviceMenuFieldDIM[0]))
					{
					continue;
					}
				if ($serviceMenuFieldDIM[0]!="config")
					{
					$serviceMenuHTML .= "<a title='' href='index.php?modulSelect=".setConfigValue($config,$serviceMenuFieldDIM[0],"name")."&amp;modulAction=list&amp;".setConfigValue($config,$serviceMenuFieldDIM[0],"name")."cmd=resetall'>";
					}
				else
					{
					$serviceMenuHTML .= "<a title='' href='index.php?modulSelect=".setConfigValue($config,$serviceMenuFieldDIM[0],"name")."&amp;modulAction=list&amp;".setConfigValue($config,$serviceMenuFieldDIM[0],"name")."cmd=resetall&amp;calltype=all'>";
					}
				$serviceMenuHTML .= "<img alt='' src='" . setConfigValue($config,"configShare","imageButton").setConfigValue($config,$serviceMenuFieldDIM[0],"icon")."' border=0 name='".$serviceMenuFieldDIM[0]."' class='buttonBox' title='".setConfigValue($config,$serviceMenuFieldDIM[0],"title")."'>";
				$serviceMenuHTML .= "</a>";
				}
			}
		if (!empty($serviceMenuHTML))
			{
			$serviceMenuHTML = $serviceMenuHTMLStart.$serviceMenuHTML;
			$serviceMenuHTML .= "</div></div>";
			}
		}
	return $serviceMenuHTML;	
	}

function topErrorMessage($config)
	{
	$topErrorMessageHTML = "";
	if (isset($config["x_errorText"]) && $config["x_errorText"] != "")
		{
		$topErrorMessageHTML .= '<div id="errorMessageBox">';
		$topErrorMessageHTML .= '<div id="errorMessageText">';
		$topErrorMessageHTML .= $config["x_errorText"];
		$topErrorMessageHTML .= "</div>";
		$topErrorMessageHTML .= "</div>";
		}
	return $topErrorMessageHTML;	
	}

function activeItem($config,$p_itemValues,$whichField,$yes_tooltip,$no_tooltip)
	{
	if ($p_itemValues[$whichField]) 
		{
		$result .= "<img alt='' src='".setConfigValue($config,"configShare","imageButton")."pipa.png' border='0' title='".$yes_tooltip."' class='buttonBox'>";
		}
	else
		{
		$result .= "<img alt='' src='".setConfigValue($config,"configShare","imageButton")."x.png' border='0' title='".$no_tooltip."' class='buttonBox'>";
		}
	return $result;
	}

function changeYesNo($config, $p_itemValues,$which_permission,$x_which_field,$yes_tooltip,$no_tooltip)
	{
	$back_text = "";
	if (($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 2 ||
		$_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 3) && setConfigValue($config,"configShare","onlyView") != 1)
		{
		if ($x_which_field=='') $x_which_field=0;
		if (isModulAdd($config,$config["modulSelect"]) || isModulEdit($config,$config["modulSelect"])) 
			{ 
			$modulTable = $config[$config["modulSelect"]]["mainTable"];
			if (!empty($modulTable)) {$modulTable = $config["modulSelect"];}
			}
		if (!is_null($x_which_field) && $x_which_field <> 0) 
			{
			$toolTip=$yes_tooltip;
			$boxType="buttonBoxY";
			$buttonYesNo = "ok";
			}
		else
			{
			$toolTip=$no_tooltip;
			$boxType="buttonBoxN";
			$buttonYesNo = "remove";
			}
		if (isModulAdd($config,$config["modulSelect"]) || isModulEdit($config,$config["modulSelect"])) 
			{ 
			if ($which_permission!="active")
				{
		  		$back_text .= "<button class='".$boxType."' title='".$toolTip."' name='modulOperation' type='submit' value='yesOrNo::".$config["modulSelect"]."::".$which_permission."::".$x_which_field."::".urlencode($p_itemValues["x_id"])."'>
				<span class='glyphicon glyphicon-".$buttonYesNo." ewIcon'></span>
				</button>";
				}
			else
				{
		  		$back_text .= "<button class='".$boxType."' title='".$toolTip."' name='modulOperation' type='submit' value='yesOrNo::".$config["modulSelect"]."::".$which_permission."::".$x_which_field."::".urlencode($p_itemValues["x_id"])."'>
				<span class='glyphicon glyphicon-".$buttonYesNo." ewIcon'></span>
				</button>";
				}
			}
		}
	else if ($which_permission != "active")
		{
		if (!is_null($x_which_field) && $x_which_field <> 0) 
			{
			$back_text .= "<img alt='' src='".setConfigValue($config,"configShare","imageButton")."pipa.png' border='0' title='".$yes_tooltip."'>";
			}
		else
			{
			$back_text .= "<img alt='' src='".setConfigValue($config,"configShare","imageButton")."x.png' border='0' title='".$no_tooltip."'>";
			}
		}
	return $back_text;
	}

function footerNavigation($config)
	{
	$footerNavigationHTML = "";
	if (!empty($config["modulAction"]))
		{
		$footerNavigationHTML .= "<div style='float:center;clear:both;height: 10px;'></div>
		<div id='footerNavigation'>";
		if ($config["modulAction"]=="pictureEdit")
			{
			$footerNavigationHTML .= "<button class='buttonBox' title='".$config["configShare"]["saveTitle"]."' id='footerMenuSave' name='save' type='submit' value=''>";
			$footerNavigationHTML .= "<span class='glyphicon glyphicon-save ewIcon'></span>";
			$footerNavigationHTML .= "</button>";
			$footerNavigationHTML .= "<button class='buttonBox' title='".$config["configShare"]["saveNoBackTitle"]."' id='footerMenuSaveNoBack' name='saveNoBack' type='submit' value=''>";
			$footerNavigationHTML .= "<span class='glyphicon glyphicon-saved ewIcon'></span>";
			$footerNavigationHTML .= "</button>";
			}
		else if ($config["modulAction"]!="view" && $config["modulAction"]!="delete" && $config["modulAction"]!="deleteGroup" && $config["modulAction"]!="pdf")
			{
			$footerNavigationHTML .= "<button class='buttonBox' title='".$config["configShare"]["saveTitle"]."' id='footerMenuSave' name='save' type='submit' value=''>";
			$footerNavigationHTML .= "<span class='glyphicon glyphicon-save ewIcon'></span>";
			$footerNavigationHTML .= "</button>";
			if (!isset($config[$config["modulSelect"]]["saveNoBackNo"]) || (isset($config[$config["modulSelect"]]["saveNoBackNo"]) && $config[$config["modulSelect"]]["saveNoBackNo"]!="1"))
				{
				$footerNavigationHTML .= "<button class='buttonBox' title='".$config["configShare"]["saveNoBackTitle"]."' id='footerMenuSaveNoBack' name='saveNoBack' type='submit' value=''>";
				$footerNavigationHTML .= "<span class='glyphicon glyphicon-saved ewIcon'></span>";
				$footerNavigationHTML .= "</button>";
				}
			}
		else if ($config["modulAction"]=="delete" || $config["modulAction"]=="deleteGroup")
			{
			$footerNavigationHTML .= "<button class='buttonBox' title='".$config["configShare"]["deleteTitle"]."' id='footerMenuDelete' name='delete' type='submit' value=''>";
			$footerNavigationHTML .= "<span class='glyphicon glyphicon-trash ewIcon'></span>";
			$footerNavigationHTML .= "</button>";
			}
		$footerNavigationHTML .= "<button class='buttonBox' title='".$config["configShare"]["backTitle"]."' id='footerMenuCancel' name='back' type='submit' value=''>";
		$footerNavigationHTML .= "<span class='glyphicon glyphicon-remove ewIcon'></span>";
		$footerNavigationHTML .= "</button>";
		$footerNavigationHTML .= "</div>";
		$footerNavigationHTML .= "<div style='clear:both;height: 1px;'></div>";
		}
	return $footerNavigationHTML;
	}

function footer($config)
	{
	$footerHTML = setConfigValue($config,"system","footer");
	return $footerHTML;
	}

function subMenu($config, $p_itemValues, $p_modulMenu)
	{
	$subMenuHTML = "";
	if (!isset($config["plus_param"])) $config["plus_param"] = "";
	$subMenuCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##subMenuCFG##","##/subMenuCFG##");
	$subMenuItemsCFG = explode('<#>',$subMenuCFG);
	for ($subMenuItemCFGCount=0;$subMenuItemCFGCount<count($subMenuItemsCFG);$subMenuItemCFGCount++)
		{
		$subMenuItemCFG = explode('<=>',trim($subMenuItemsCFG[$subMenuItemCFGCount]));
		if (!empty($subMenuItemCFG[0]))
			{
			if (($p_itemValues["x_id"] != NULL))
				{
		  		$subMenuHTML .= "<button class='button24x24Box' title='".$config[$p_modulMenu][$subMenuItemCFG[1]."Title"]."' name='modulOperation' type='submit' value='simpleItem::".$subMenuItemCFG[1]."::".$p_modulMenu."::".urlencode($p_itemValues["x_id"])."'>".$subMenuItemCFG[0]."</button>";
				}
			}
		}
	if (isModulView($config,$config["modulSelect"])) 
		{ 
		if (!isset($config[$config["modulSelect"]]["noView"]) || !$config[$config["modulSelect"]]["noView"])
			{
			if (($p_itemValues["x_id"] != NULL))
				{
				$subMenuHTML .= "<button class='buttonBox' title='".$config["configShare"]["viewTitle"]."' id='' name='modulOperation' type='submit' value='item::view::".$config["modulSelect"]."::".urlencode($p_itemValues["x_id"])."'>
				<span data-caption='".$config["configShare"]["viewTitle"]."' class='glyphicon glyphicon-info-sign' ewIcon' data-phrase='ViewLink'></span>
				</button>";
				}
			}
		}
	if (isModulAdd($config,$config["modulSelect"]) && setConfigValue($config,"configShare","onlyView") != 1  &&
		($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] > 1))
		{ 
		if (!isset($config[$config["modulSelect"]]["noCopy"]) || !$config[$config["modulSelect"]]["noCopy"])
			{
			if (($p_itemValues["x_id"] != NULL))
				{
				$subMenuHTML .= "<button title='".$config["configShare"]["copyTitle"]."' class='buttonBox' id='' name='modulOperation' type='submit' value='item::add::".$config["modulSelect"]."::".urlencode($p_itemValues["x_id"])."'>
				<span data-caption='".$config["configShare"]["copyTitle"]."' class='glyphicon glyphicon-duplicate' ewIcon' data-phrase='DuplicateLink'></span>
				</button>";
				}
			}
		} 
	if (isModulEdit($config,$config["modulSelect"]) && setConfigValue($config,"configShare","onlyView") != 1) 
		{ 
		if (!isset($config[$config["modulSelect"]]["noEdit"]) || !$config[$config["modulSelect"]]["noEdit"])
			{
			if (($p_itemValues["x_id"] != NULL))
				{
				if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 2 ||
					$_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 3 || 
					($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 4 && $config[$config["modulSelect"]]["resultRow"]["insertUserID"]==$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]) ||
					$config[$config["modulSelect"]]["resultRow"]["insertUserID"] == $_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"])
					{
					$subMenuHTML .= "<button title='".$config["configShare"]["editTitle"]."' class='buttonBox' id='' name='modulOperation' type='submit' value='item::edit::".$config["modulSelect"]."::".urlencode($p_itemValues["x_id"])."'>
					<span data-caption='".$config["configShare"]["editTitle"]."' class='glyphicon glyphicon-edit' ewIcon' data-phrase='EditLink'></span>
					</button>";
					}
				}
			}
		}
	if (isModulDelete($config,$config["modulSelect"]) && setConfigValue($config,"configShare","onlyView") != 1) 
		{ 
		if (!isset($config[$config["modulSelect"]]["noDelete"]) || !$config[$config["modulSelect"]]["noDelete"])
			{
			if (($p_itemValues["x_id"] != NULL))
				{
				if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 2 ||
					$_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 3 || 
					($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 4 && $config[$config["modulSelect"]]["resultRow"]["insertUserID"]==$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"])||
					$config[$config["modulSelect"]]["resultRow"]["insertUserID"] == $_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"])
					{
					$subMenuHTML .= "<button title='".$config["configShare"]["deleteTitle"]."' class='buttonBox' id='' name='modulOperation' type='submit' value='item::delete::".$config["modulSelect"]."::".urlencode($p_itemValues["x_id"])."'>
					<span data-caption='Törlés' class='glyphicon glyphicon-trash ewIcon' data-phrase='DeleteLink'></span>
					</button>";
					}
				}
			}
		} 
	$subMenuCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##subMenuAddCFG##","##/subMenuAddCFG##");
	$subMenuItemsCFG = explode('<#>',$subMenuCFG);
	for ($subMenuItemCFGCount=0;$subMenuItemCFGCount<count($subMenuItemsCFG);$subMenuItemCFGCount++)
		{
		$subMenuItemCFG = explode('<=>',trim($subMenuItemsCFG[$subMenuItemCFGCount]));
		if (!empty($subMenuItemCFG[0]))
			{
			if (($p_itemValues["x_id"] != NULL))
				{
				if ($subMenuItemCFG[0]!="pdf")
					{
					$subMenuHTML .= "<div><button title='".$config[$p_modulMenu][$subMenuItemCFG[1]."Title"]."' id='' name='modulOperation' type='submit' value='item::".$subMenuItemCFG[1]."::".$config["modulSelect"]."::".urlencode($p_itemValues["x_id"])."'>".$config["configShare"][$subMenuItemCFG[1]."Title"]."</button></div>";
					}
				}
			}
		}
	if (isModulAdmin($config,$config["modulSelect"]) && $config["configShare"]["onlyView"] != 1) 
		{ 
		$subMenuHTML.="".changeYesNo($config, $p_itemValues,"active",$p_itemValues["x_active"],$config["configShare"]["yesTitle"],$config["configShare"]["noTitle"])."";
		}
	return $subMenuHTML;
	}

function navigationNew($config,$p_modulMenu)
	{
	$config["sharedNavigation"]="";
	$config["sharedNavigationAdd"]="";
	if ($config[$config["modulSelect"]]["totalRecs"] > 0)
		{
		$config[$config["modulSelect"]]["rsEof"] = ($config[$config["modulSelect"]]["totalRecs"] < ($config[$config["modulSelect"]]["startRec"] + $config[$config["modulSelect"]]["displayRecs"]));
		$config[$config["modulSelect"]]["PrevStart"] = $config[$config["modulSelect"]]["startRec"] - $config[$config["modulSelect"]]["displayRecs"];
		if ($config[$config["modulSelect"]]["PrevStart"] < 1) $config[$config["modulSelect"]]["PrevStart"] = 1;
		$config[$config["modulSelect"]]["NextStart"] = $config[$config["modulSelect"]]["startRec"] + $config[$config["modulSelect"]]["displayRecs"];
		if ($config[$config["modulSelect"]]["NextStart"] > $config[$config["modulSelect"]]["totalRecs"] ) $config[$config["modulSelect"]]["NextStart"] = $config[$config["modulSelect"]]["startRec"];
		$config[$config["modulSelect"]]["LastStart"] = intval(($config[$config["modulSelect"]]["totalRecs"]-1)/$config[$config["modulSelect"]]["displayRecs"])*$config[$config["modulSelect"]]["displayRecs"]+1;
		if ($config[$config["modulSelect"]]["startRec"] > $config[$config["modulSelect"]]["totalRecs"])
			{
			$config[$config["modulSelect"]]["startRec"]=$config[$config["modulSelect"]]["totalRecs"];
			}
		else
			{
			}
		$config[$config["modulSelect"]]["stopRec"] = $config[$config["modulSelect"]]["startRec"] + $config[$config["modulSelect"]]["displayRecs"] - 1;
		$config[$config["modulSelect"]]["recCount"] = $config[$config["modulSelect"]]["totalRecs"] - 1;
		if ($config[$config["modulSelect"]]["rsEof"])
			{
			$config[$config["modulSelect"]]["recCount"]=$config[$config["modulSelect"]]["totalRecs"];
			}
		if ($config[$config["modulSelect"]]["stopRec"] > $config[$config["modulSelect"]]["recCount"])
			{
			$config[$config["modulSelect"]]["stopRec"] = $config[$config["modulSelect"]]["recCount"];
			}
		if (!isset($config[$config["modulSelect"]]["listScroll"])) {$config[$config["modulSelect"]]["listScroll"]=0;}
		if (!isset($config[$config["modulSelect"]]["navigationNoText"])) {$config[$config["modulSelect"]]["navigationNoText"]=1;}
		if ($config[$config["modulSelect"]]["navigationNoText"]==1)
			{
			$config["sharedNavigation"] .= "<div style='float:left;margin-left:5px;'>";
			$config["sharedNavigation"] .= "<span class='navigationText text-nowrap'><div style='float:left;'><input class='form-control' type='text' name='".$config["modulSelect"]."pageno' value='' placeholder='";
			$config["sharedNavigation"] .= intval(($config[$config["modulSelect"]]["startRec"]-1)/$config[$config["modulSelect"]]["displayRecs"])+1;
			$config["sharedNavigation"] .= "' size='4' style='text-align:right'></div><div style='float:right;'>";
			$config["sharedNavigation"] .= "/&nbsp;";
			$config["sharedNavigation"] .= intval(($config[$config["modulSelect"]]["totalRecs"]-1)/$config[$config["modulSelect"]]["displayRecs"])+1;
			$config["sharedNavigation"] .= "&nbsp;".$config["configShare"]["pageTitle"]."</div></span></div>";
			}
		// first page button
		$config["sharedNavigation"] .= "<div style='float:right;'><div style='float:left;'>";
		if ($config[$config["modulSelect"]]["listScroll"]!=1)
			{
			if ($config[$config["modulSelect"]]["startRec"] == 1)
				{
				$config["sharedNavigation"] .= "<span class='buttonBoxE'>&nbsp;</span>";
				}
			else
				{
		  		$config["sharedNavigation"] .= "<button class='buttonBox' id='' title='".$config["configShare"]["firstTitle"]."' name='modulOperation' type='submit' value='start::".$config["modulSelect"]."::1'><span data-caption='LeftLast' class='glyphicon glyphicon-fast-backward ewIcon' data-phrase='LeftLastLink'></span></button>";
				}
			}
		// previous page button
		if ($config[$config["modulSelect"]]["listScroll"]!=1)
			{
			if ($config[$config["modulSelect"]]["PrevStart"] == $config[$config["modulSelect"]]["startRec"])
				{
				$config["sharedNavigation"] .= "<span class='buttonBoxE'>&nbsp;</span>";
				}
			else
				{
		  		$config["sharedNavigation"] .= "<button class='buttonBox' id='' title='".$config["configShare"]["prevTitle"]."' name='modulOperation' type='submit' value='start::".$config["modulSelect"]."::".$config[$config["modulSelect"]]["PrevStart"]."'><span data-caption='LeftPage' class='glyphicon glyphicon-backward ewIcon' data-phrase='LeftPageLink'></span></button>";
				}

			if ($config[$config["modulSelect"]]["startRec"]!=1)
				{
		  		$config["sharedNavigation"] .= "<button class='buttonBox' id='' title='".$config["configShare"]["prevItemTitle"]."' name='modulOperation' type='submit' value='start::".$config["modulSelect"]."::".($config[$config["modulSelect"]]["startRec"]-1)."'><span data-caption='Left' class='glyphicon glyphicon-triangle-left ewIcon' data-phrase='LeftLink'></span></button>";
				}
			else
				{
				$config["sharedNavigation"] .= "<span class='buttonBoxE'>&nbsp;</span>";
				}

			}
		// current page number
		if ($config[$config["modulSelect"]]["navigationNoText"]==1)
			{
			$config["sharedNavigation"] .= "</div><div style='float:left;line-height:24px;min-width:80px;text-align:center;'>";
			$config["sharedNavigation"] .= "<span class='navigationText'>&nbsp;".trim($config[$config["modulSelect"]]["startRec"]) . " - " . $config[$config["modulSelect"]]["stopRec"] . "&nbsp;</span>";
			$config["sharedNavigation"] .= "</div><div style='float:left;'>";
			}
		// next page button
		if ($config[$config["modulSelect"]]["listScroll"]!=1)
			{

			if ($config[$config["modulSelect"]]["startRec"]<$config[$config["modulSelect"]]["totalRecs"]-$config[$config["modulSelect"]]["displayRecs"]+1)
				{
		  		$config["sharedNavigation"] .= "<button class='buttonBox' id='' title='".setConfigValue($config,$config["modulSelect"],"nextItemTitle")."' name='modulOperation' type='submit' value='start::".$config["modulSelect"]."::".($config[$config["modulSelect"]]["startRec"]+1)."'><span data-caption='Right' class='glyphicon glyphicon-triangle-right ewIcon' data-phrase='RightLink'></span></button>";
				}
			else
				{
				$config["sharedNavigation"] .= "<span class='buttonBoxE'>&nbsp;</span>";
				}

			if ($config[$config["modulSelect"]]["NextStart"] == $config[$config["modulSelect"]]["startRec"])
				{
				$config["sharedNavigation"] .= "<span class='buttonBoxE'>&nbsp;</span>";
				}
			else
				{
		  		$config["sharedNavigation"] .= "<button class='buttonBox' id='' title='".setConfigValue($config,$config["modulSelect"],"nextTitle")."' name='modulOperation' type='submit' value='start::".$config["modulSelect"]."::".$config[$config["modulSelect"]]["NextStart"]."'><span data-caption='RightPage' class='glyphicon glyphicon-forward ewIcon' data-phrase='RightPageLink'></button>";
				}
			}
		// last page button 
		if ($config[$config["modulSelect"]]["listScroll"]!=1)
			{
			$config["sharedNavigation"] .= "</div><div style='float:left;'>";
			if ($config[$config["modulSelect"]]["startRec"]<$config[$config["modulSelect"]]["totalRecs"]-$config[$config["modulSelect"]]["displayRecs"]+1)
				{
		  		$config["sharedNavigation"] .= "<button class='buttonBox' id='' title='".setConfigValue($config,$config["modulSelect"],"lastTitle")."' name='modulOperation' type='submit' value='start::".$config["modulSelect"]."::".$config[$config["modulSelect"]]["LastStart"]."'><span data-caption='RightLast' class='glyphicon glyphicon-fast-forward ewIcon' data-phrase='RightLastLink'></button>";
				}
			else
				{
				$config["sharedNavigation"] .= "<span class='buttonBoxE'>&nbsp;</span>";
				}
			$config["sharedNavigation"] .= "</div><div style='float:left;'>";
			}
		if (isset($config[$config["modulSelect"]]["viewDescription"])) {
			if ($config[$config["modulSelect"]]["viewDesription"]==1) {
				$config["sharedNavigationAdd"] .= "<button title='".$config["configShare"]["descriptionTitle"]."' class='buttonBox' name='modulOperation' type='submit' value='description::description::".$config["modulSelect"]."::'><span data-caption='Description' class='glyphicon glyphicon-zoom-out ewIcon' data-phrase='DescriptionLink'></span></button>";
			} else {
				$config["sharedNavigationAdd"] .= "<button title='".$config["configShare"]["descriptionTitle"]."' class='buttonBox' name='modulOperation' type='submit' value='description::description::".$config["modulSelect"]."::'><span data-caption='Description' class='glyphicon glyphicon-zoom-in ewIcon' data-phrase='DescriptionLink'></span></button>";
			}
		}
//		$config["sharedNavigationAdd"] .= "<button title='".$config["configShare"]["descriptionTitle"]."' class='buttonBox' name='modulOperation' type='submit' value='description::description::".$config["modulSelect"]."::'><span data-caption='Description' class='glyphicon glyphicon-ok ewIcon' data-phrase='DescriptionLink'></span></button>";
		if (isModulAdd($config,$config["modulSelect"]))
			{
			if ((!isset($config[$config["modulSelect"]]["noAdd"]) || !$config[$config["modulSelect"]]["noAdd"]) && (!isset($GLOBALS["treeAdmin"]) || !$GLOBALS["treeAdmin"]))
				{
				$config["sharedNavigationAdd"] .= "<button title='".$config["configShare"]["addTitle"]."' class='buttonBox' name='modulOperation' type='submit' value='item::add::".$config["modulSelect"]."::'><span data-caption='Add' class='glyphicon glyphicon-plus ewIcon' data-phrase='AddLink'></span></button>";
				}
			}
		else
			{
			$config["sharedNavigation"] .= "<span class='buttonBoxE'>&nbsp;</span>";
			}
			
		$navigationAddCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##navigationAddCFG##","##/navigationAddCFG##");
		$navigationAddItemsCFG = explode('<#>',$navigationAddCFG);
		for ($navigationAddItemCFGCount=0;$navigationAddItemCFGCount<count($navigationAddItemsCFG);$navigationAddItemCFGCount++) {
			$navigationAddItemCFG = explode('::',trim($navigationAddItemsCFG[$navigationAddItemCFGCount]));
			if (!empty($navigationAddItemCFG[0])) {
				if ($navigationAddItemCFG[0]=="import") {
					if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] != 1) {
						$config["sharedNavigationAdd"] .= "<button title='".$config[$config["modulSelect"]][	$navigationAddItemCFG[1]."Title"]."' class='buttonBox' name='modulOperation' type='submit' value='item::".$navigationAddItemCFG[1]."::".$config["modulSelect"]."'>".$navigationAddItemCFG[1]."</button>";
					}
				} else if ($navigationAddItemCFG[0]=="export") {
					if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] != 1) {
						$config["sharedNavigationAdd"] .= "<button title='".$config[$config["modulSelect"]][$navigationAddItemCFG[1]."Title"]."' class='buttonBox' name='modulOperation' type='submit' value='item::".$navigationAddItemCFG[1]."::".$config["modulSelect"]."'><span data-caption='Active' class='glyphicon glyphicon-arrow-down' data-phrase='ExportLink'></span></button>";
					}
				} else if ($navigationAddItemCFG[0]!="pdf") {
					$config["sharedNavigationAdd"] .= "<button title='".$config[$config["modulSelect"]][$navigationAddItemCFG[1]."Title"]."' class='buttonBox' name='modulOperation' type='submit' value='item::".$navigationAddItemCFG[1]."::".$config["modulSelect"]."'><span data-caption='Active' class='glyphicon glyphicon-plus ewIcon' data-phrase='DeleteLink'></span></button>";
				}
			}
		}
		if ($config[$config["modulSelect"]]["navigationNoText"]==1)
			{
			$config["sharedNavigationAdd"] .= "<span class='navigationText'>".$config[$config["modulSelect"]]["startRec"] . " / " . $config[$config["modulSelect"]]["totalRecs"]."&nbsp;".$config["configShare"]["itemTitle"]."&nbsp;</span>";
			}
		$config["sharedNavigation"] .= "</div></div>";
		}
	else
		{
		if ($config["modulSelect"]!="nocore_reservation")
			{
			$config["sharedNavigationAdd"] .= "<span class='navigationTextError'>";
			if (isModulList($config,$config["modulSelect"]))
				{
				$config["sharedNavigationAdd"] .= $config["configShare"]["noRecordTitle"];
				}
			else
				{
				$config["sharedNavigationAdd"] .= $config["configShare"]["noRightsTitle"];
				}
			$config["sharedNavigationAdd"] .= "</span>";
			}
		if (isModulAdd($config,$config["modulSelect"]))
			{
			if (!isset($config[$config["modulSelect"]]["noAdd"]) || !$config[$config["modulSelect"]]["noAdd"])
				{
				$config["sharedNavigationAdd"] .= "<button title='".$config["configShare"]["addTitle"]."' class='buttonBox' name='modulOperation' type='submit' value='item::add::".$config["modulSelect"]."::'><span data-caption='Add' class='glyphicon glyphicon-plus ewIcon' data-phrase='AddLink'></span></button>";
				}
			}
		$navigationAddCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##navigationAddCFG##","##/navigationAddCFG##");
		$navigationAddItemsCFG = explode('<#>',$navigationAddCFG);
		for ($navigationAddItemCFGCount=0;$navigationAddItemCFGCount<count($navigationAddItemsCFG);$navigationAddItemCFGCount++)
			{
			$navigationAddItemCFG = explode('::',trim($navigationAddItemsCFG[$navigationAddItemCFGCount]));
			if (!empty($navigationAddItemCFG[0]))
				{
				if ($navigationAddItemCFG[0]=="import") {
					if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] != 1) {
						$config["sharedNavigationAdd"] .= "<button title='".$config[$config["modulSelect"]][$navigationAddItemCFG[1]."Title"]."' class='buttonBox' name='modulOperation' type='submit' value='item::".$navigationAddItemCFG[1]."::".$config["modulSelect"]."'>".$config["modulSelect"]."</button>";
					}
				} else if ($navigationAddItemCFG[0]=="export") {
					if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] != 1) {
						$config["sharedNavigationAdd"] .= "<button title='".$config[$config["modulSelect"]][$navigationAddItemCFG[1]."Title"]."' class='buttonBox' name='modulOperation' type='submit' value='item::".$navigationAddItemCFG[1]."::".$config["modulSelect"]."'><span data-caption='Active' class='glyphicon glyphicon-arrow-down' data-phrase='ExportLink'></span></button>";
					}
				} else 	if ($navigationAddItemCFG[0]!="pdf") {
					$config["sharedNavigationAdd"] .= "<button title='".$config[$config["modulSelect"]][$navigationAddItemCFG[1]."Title"]."' class='buttonBox' name='modulOperation' type='submit' value='item::".$navigationAddItemCFG[1]."::".$config["modulSelect"]."'><span data-caption='Active' class='glyphicon glyphicon-plus ewIcon' data-phrase='DeleteLink'></span></button>";
					}
				}
			}
		}
	if (setConfigValue($config,$config["modulSelect"],"noNavigationDefault")==0)
		{
		$config["navigationHTML"]=$config["sharedNavigation"];
		$config["navigationAddHTML"]=$config["sharedNavigationAdd"];
		$config["navigationBackHTML"]=$config["sharedNavigationBack"];
		}
	return $config;
	}


function orderChange($config,$which_field, $orderTitle)
	{
	$actualOrder = setConfigValue($config,$config["modulSelect"],$which_field);
	if (ISSET($actualOrder))
		{
		$order_box .= "<div style='float:left'>".$orderTitle."&nbsp;</div>";
		$really_order = str_replace("Title","",$which_field);
  		$order_box .= "<button class='nosortButton' title='".$config["configShare"]["orderTitle"]."' name='modulOperation' type='submit' value='order::".$config["modulSelect"]."::".urlencode($really_order)."'>";
		if ($config[$config["modulSelect"]]["OrderBy"] == $really_order) 
			{ 
		 	if (@$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_OT"] == "ASC") 
				{
				$order_box .= "<span data-caption='Növekvő' class='glyphicon glyphicon-sort-by-attributes' data-phrase='ASC'></span>";
				}
			else if (@$_SESSION[$config["configShare"]["whichSystemAndMode"].$config["modulSelect"] . "_OT"] == "DESC") 
				{
				$order_box .= "<span data-caption='Növekvő' class='glyphicon glyphicon-sort-by-attributes-alt' data-phrase='DESC'></span>";
				}
			else
				{
				$order_box .= "<span data-caption='Csökkenő' class='glyphicon glyphicon-sort' data-phrase='None'></span>";
				}
			}
		else
			{
			$order_box .= "<span data-caption='Csökkenő' class='glyphicon glyphicon-sort' data-phrase='None'></span>";
			}
		$order_box .= "</button>";
		}
	else
		{
		$order_box = NULL;
		}
	return $order_box;
	}

function tplUp($name,$config,$p_tplPATH)
	{
	$addDir=$p_tplPATH;
	$ext='html';
	if (file_exists($addDir."{$name}.{$ext}"))
		{ 
		$tpl='';
		$cont=file($addDir.$name.'.'.$ext);
		while(list($line_num,$line)=each($cont)) $tpl.=$line;
		return $tpl;
		}
	else die ("TPL NEM TALÁLTAM: $name");
	}

function header1($config)
	{
/**** CSS load ****/
	$cssCFG = iniCFGParser($config["configShare"]["iniCFG"],"##cssCFG##","##/cssCFG##");
	$cssItemCFG = explode('<#>',$cssCFG);
	$cssHTML="";
	for ($cssItemCFGCount=0;$cssItemCFGCount<count($cssItemCFG);$cssItemCFGCount++)
		{
		if (!empty($cssItemCFG[$cssItemCFGCount]))
			{
			$config["pageStartHTML"] .= '<LINK REL="stylesheet" HREF="'.$cssItemCFG[$cssItemCFGCount].'" TYPE="text/css">';
			}
		}
/**** Javascript load ****/
	$javascriptCFG = iniCFGParser($config["configShare"]["iniCFG"],"##javascriptCFG##","##/javascriptCFG##");
	$javascriptCFG .= iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##javascriptCFG##","##/javascriptCFG##");
	$javascriptItemCFG = explode('<#>',$javascriptCFG);
	$javascriptHTML="";
	for ($javascriptItemCFGCount=0;$javascriptItemCFGCount<count($javascriptItemCFG);$javascriptItemCFGCount++)
		{
		if (!empty($javascriptItemCFG[$javascriptItemCFGCount]))
			{
			$config["pageStartHTML"] .= "<script language=\"JavaScript\" type=\"text/javascript\" src=\"" . $config["systemROOT"].$config["configShare"]["sharePath"] . "js/".$javascriptItemCFG[$javascriptItemCFGCount].".js\"></script>";
			}
		}

//	$config["topDevelopHTML"] = topDevelop($config);
	$config["topLogoHTML"] = topLogo($config);
	$config["topMenuHTML"] = topMenu($config);
	$config = loginService($config);
	if (@$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"] == 2 ||
		@$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"] == 3)
		{
		$config["core_themes"]["themesSelect"] = filterSelect($config,"core_themes",$p_itemValues,0);
		$themesSelectFormHTML = iniCFGParser($config["sharedTPL"]["iniCFG"],"##themesSelectForm##","##/themesSelectForm##");
		$config["themesHTML"] = parseContent($themesSelectFormHTML,$config,"");
		}
	if ($config["configShare"]["topMessageTitle"]<>"")
		{
		if (substr($config["configShare"]["topMessageTitle"],0,2)!="//")
			{
			$config["topMessageHTML"] = '<div id="mainMessageBox">'.$config["configShare"]["topMessageTitle"].'</div>';
			}
		}
	if ($_GET["import"]=="ok")
		{
		$config["statusMessageHTML"] = '<div id="greenMessageBox">'.$config[$config["modulSelect"]]["importOKTitle"].'</div>';
		}
	if ($_GET["import"]=="bad")
		{
		$config["statusMessageHTML"] = '<div id="redMessageBox">'.$config[$config["modulSelect"]]["importBADTitle"];
		if (isset($config["importErrorLine"]) && !empty($config["importErrorLine"])) {
			$config["statusMessageHTML"] .='<br>'.$config["importErrorLine"];
		}
		$config["statusMessageHTML"] .='</div>';
		}
	$config["topAdminHTML"] = topAdmin($config);
	$config["topStatusHTML"] = topStatus($config);
	$config["footerHTML"] = footer($config);
	$config["systemTitle"] = $config["configShare"]["systemTitle"];
	return $config;
	}

function topLogo($config)
	{
	$topLogoHTML=$config["configShare"]["topLogoTitle"];
	return $topLogoHTML;	
	}

function topDevelop($config)
	{
	$topDevelopHTML .= "<img src='" . setConfigValue($config,"configShare","imagePath").$config["configShare"]["developLogo"]."' border=0 name='config_".$config["modulSelect"]."' title='".setConfigValue($config,"config","developerTitle")."'>";
	return $topDevelopHTML;	
	}

function display($config)
	{
	if (isset($config[$config["modulSelect"]]["templateName"]) && !empty($config[$config["modulSelect"]]["templateName"]))
		{
		$viewPageHTML = tplUp($config[$config["modulSelect"]]["templateName"],$config,$config["configShare"]["tplPath"]);
		$viewPageHTML = parseContent($viewPageHTML,$config,"");
		if ($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_User"] == $config["configShare"]["guestUser"])
			{
			$viewItem["configShare_x_topMenu"]=0;
			$viewItem["configShare_x_content"]=0;
			}
		else
			{
			$viewItem["configShare_x_topMenu"]=1;
			$viewItem["configShare_x_content"]=1;
			}
		$viewPageHTML = clearForm($config, $viewPageHTML, $viewItem);
		$viewPageHTML = parseContent($viewPageHTML,$config,"");
		echo $viewPageHTML;
		}
	else
		{
		if (!empty($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"]) && $_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 1) $config["configShare"]["onlyView"] = 0;
		else $config["configShare"]["onlyView"] = 0;
		if (!empty($config["layoutMainHTML"]))
			{
			$config["fullHTML"] = tplUp($config["layoutMainHTML"],$config,$config["configShare"]["tplPath"]);
			}
		else if (isset($_SESSION[$config["configShare"]["whichSystemAndMode"]."layout"]) && !empty($_SESSION[$config["configShare"]["whichSystemAndMode"]."layout"]))
			{
			$config["fullHTML"] = tplUp($_SESSION[$config["configShare"]["whichSystemAndMode"]."layout"],$config,$config["configShare"]["tplPath"]);
			}
		else
			{
			$config["fullHTML"] = tplUp('layout',$config,$config["configShare"]["tplPath"]);
			}
		$config["fullHTML"] = parseContent($config["fullHTML"],$config,"");
		echo $config["fullHTML"];	
		}
	}

function optionView($config,$p_itemTable,$p_itemField,$p_itemID,$p_itemName,$p_itemValues)
	{
	if ($p_itemTable == 'core_users' ) {
		$sqlwrk = "SELECT ".$p_itemID.",".$p_itemName." FROM ".$p_itemTable." WHERE ".$p_itemID." = '" . $_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]."'";
		}
	else {
		$sqlwrk = "SELECT ".$p_itemID.",".$p_itemName." FROM ".$p_itemTable." WHERE ".$p_itemID." = '" . $p_itemValues[$p_itemField]."'";
		}
	$optionRec=$config["dbConnect"]->prepare($sqlwrk);
	$optionRec->execute();
	$optionCount = $optionRec->rowCount();
	$x_result_name = "";
	if ($optionCount > 0)
		{
		$optionRS=$optionRec->fetch(PDO::FETCH_ASSOC);
		$x_result_name = $optionRS[$p_itemName];
		}
	else
		{
		$x_result_name = "&nbsp;";
		}
	$optionRec->closeCursor();
	return $x_result_name;
	}

function filterSelect($config,$p_itemTable,$p_itemValues,$p_pleaseSelect)
	{
	if (empty($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_".$p_itemTable."FilterID"]))
		{
//		$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_".$p_itemTable."FilterID"] = 1;
		} // set default value
	
	if (ISSET($config[$p_itemTable]["selectWidth"]) && !EMPTY($config[$p_itemTable]["selectWidth"]))
		{
		$selectWidth="style='width:".$config[$p_itemTable]["selectWidth"].";'";
		}
	else
		{
		$selectWidth="";
		}
	if (ISSET($config[$p_itemTable]["selectFields"]) && !EMPTY($config[$p_itemTable]["selectField"]))
		{
		$selectFields=$config[$p_itemTable]["selectFields"];
		}
	else
		{
//		$selectFields="id, name";
		$selectFields="*";
		}
	$resultHTML = "";
	if ($p_pleaseSelect==1)
		{
		$resultHTML .= "<option value=\"-1\">".$config["configShare"]["itemSelectTitle"]."</option>";
		}
	$sqlwrk = "SELECT ".$selectFields." FROM ".$p_itemTable;
	if ($p_itemTable == "core_users") {
		$sqlwrk .= " WHERE active=1 AND  firmName != '' ORDER BY firmName";
	} else {
		$sqlwrk .= " WHERE active=1 ORDER BY name";
	}
	foreach ($config["dbConnect"]->query($sqlwrk) as $datawrk) 
		{
		$rowcntwrk = 0;
		$resultHTML .= "<option value=\"" . htmlspecialchars($datawrk["id"]) . "\"";
		if ($datawrk["id"] == $_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_".$p_itemTable."FilterID"])
			{
			$resultHTML .= " selected";
			}
		if ($p_itemTable != "core_themes")
			{
			$resultHTML .= ">" . $datawrk["name"] . "</option>";
			}
		else
			{
			$resultHTML .= " style='background-color:".$datawrk["bgcolor"].";color:".$datawrk["fgcolor"].";'>" . $datawrk["name"] . "</option>";
			}
		$rowcntwrk++;
		}
	return $resultHTML;
	}

function optionSelect($config,$p_itemTable,$p_itemField,$p_itemID,$p_itemName,$p_itemValues,$p_selectField, $p_topicFilter)
	{
	if (empty($p_itemValues[$p_itemField]))
		{
		$p_itemValues[$p_itemField] = 0;
		} // set default value
	$config["whose_id"] = str_replace("_rights","",$config["modulSelect"])."ID";
	$resultHTML = "<option value=\"\">".$config["configShare"]["itemSelectTitle"]."</option>";
	$optionFilter="";
	$sqlwrk = "SELECT ".$p_itemID.",".$p_itemName." FROM ".$p_itemTable;
	if ($p_itemTable == "core_users") {
		$sqlwrk .= " WHERE active=1 AND  firmName != ''";
	} else if ($p_itemTable == "core_groups") {
		if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 2) {
			$sqlwrk .= " WHERE active=1 ";
		} else if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 3) {
			$sqlwrk .= " WHERE (active=1 && id>=".$_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"].")";
		} else {
			$sqlwrk .= " WHERE (active=1 && id>=".$_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"].")";
		}	
	} else if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 2 ||
		$_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 3) {
		$sqlwrk .= " WHERE active=1 ";
	} else if ($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 4 && $p_itemTable == "firm") {
		$sqlwrk .= " WHERE (active=1 && insertUserID=".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"];
	} else {
		$sqlwrk .= " WHERE active=1 ";
	}
	$sqlwrk .= "ORDER BY ".$p_itemName;
	if ($p_itemTable == "recipetopic")
		{
		$sqlwrk = "select recipetopic.name,recipetopic.id, count(recipe.recipetopicID) AS counted from recipe
			right join recipetopic on recipe.recipetopicID=recipetopic.id
			group by recipe.recipetopicID
			order by recipetopic.name ASC";
		}
	else if ($p_itemTable == "personaltopic")
		{
		$sqlwrk = "select personaltopic.name,personaltopic.id, count(personal.topicID) AS counted,personaltopic.name AS topicName from personal
			right join personaltopic on personal.topicID=personaltopic.id
			right join core_configs on personaltopic.configsID=core_configs.id
			WHERE personaltopic.configsID=48 AND personaltopic.active=1
			group by personal.topicID
			order by personaltopic.name ASC";
		}
	foreach ($config["dbConnect"]->query($sqlwrk) as $datawrk) 
		{
		$rowcntwrk = 0;
		$resultHTML .= "<option ";
		$resultHTML .= "value=\"" . htmlspecialchars($datawrk[$p_itemID]) . "\"";
		if ($datawrk[$p_itemID] == @$p_itemValues[$p_itemField])
			{
			$resultHTML .= " selected";
			}
		$resultHTML .= ">" . $datawrk[$p_itemName];
		if ($p_itemTable == "recipetopic" || $p_itemTable=="personaltopic")
			{
			$resultHTML .= " (".$datawrk["counted"].")";
			}
		$resultHTML .= "</option>";
		$rowcntwrk++;
		}
	return $resultHTML;
	}

function optionSelect2($config,$selectField,$selectID,$selectValue,$inputValue)
	{
	$resultSelect = '<option value="">'.$config["startSelectTitle"].'</option>';
	foreach ($config["dbConnect"]->query($config[$selectField."SQL"]) as $selectROW) 
		{
		$resultSelect .= "<option value=\"" . htmlspecialchars($selectROW[$selectID]) . "\"";
		if ($selectROW[$selectID] == $inputValue)
			{
			$resultSelect .= " selected";
			}
		$resultSelect .= ">" . $selectROW[$selectValue];
		$resultSelect .= "</option>";
		}
	$config[$selectField]=$resultSelect;
	return $config;	
	}

function debugPrintValue($config, $p_printHead, $p_printValue, $p_printNeed)
	{
	if (($_SESSION[$config["configShare"]["whichSystemAndMode"]."status_UserLevel"] == 2) && ($p_printNeed == 1))
		{
		print ($p_printHead . " => " . $p_printValue."<br>");
		}
	}

function pictureView($config, $whichpicture, $picturetitle, $sWidth, $sHeight)
	{
	if (!empty($whichpicture)) 
		{ 
		if (is_file($whichpicture))
			{
			if (!(strpos($whichpicture,".swf") > 0))
				{
				if (empty($picturetitle))
					{
					$whichpictureview = "<img alt='".$picturetitle."' src='" . $whichpicture . "' border='0' width='500px'>";
					}
				else
					{
					$whichpictureview = "<img  alt='".$picturetitle."' src='" . $whichpicture . "' border='0' width='500px' title='".$picturetitle."'>";
					}
				}
			else
				{
				$whichpictureview = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
					codebase="http://active.macromedia.com/flash4/cabs/swflash.cab#version=4,0,0,0"
					id="name" width="'.$sWidth.'" height="'.$sHeight.'">
					<param name="movie" value="'.$whichpicture.'">
					<param name="quality" value="high">
					<param name="wmode" value="transparent">
					<embed name="name" src="'.$whichpicture.'"
					quality="high" wmode="transparent" width="'.$sWidth.'" height="'.$sHeight.'"
					type="application/x-shockwave-flash"
					pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?
					P1_Prod_Version=ShockwaveFlash">
					</embed>
					</object>';
				}
			}
		else
			{
			$whichpictureview = "<img alt='".$picturetitle."' src='".$config["configShare"]["imageButton"]."nopict.png' border='0'>";
			}
		} 
	else
		{
		$whichpictureview = "<img alt='".$picturetitle."' src='".$config["configShare"]["imageButton"]."nopict.png' border='0'>";
		}
	return $whichpictureview;	
	}

function pictureService($config, $whichPicture, $key, $p_itemValues)
	{
	$whichpictureview = "<a title='' href='index.php?modulAction=pictureEdit&amp;key=" . urlencode($key) ."&amp;table=".$config["modulSelect"]."'>";
	if (!empty($whichPicture)) 
		{ 
		if (is_file($whichPicture))
			{
			$whichpictureview .= "<img alt='' src='" . $whichPicture. "' border='0' name='view' title='".$config["configShare"]["pictureEditTitle"]."'>";
			}
		else
			{
			$whichpictureview .= "<img alt='' src='" . $config["configShare"]["imageButton"] . "nopict.png' border='0' name='view' title='".$config["configShare"]["pictureAddTitle"]."' class='buttonBox'>";
			}
		} 
	else
		{
		$whichpictureview .= "<img alt='' src='" . $config["configShare"]["imageButton"] . "nopict.png' border='0' name='view' title='".$config["configShare"]["pictureAddTitle"]."' class='buttonBox'>";
		}
	$whichpictureview .= "</a>";
	return $whichpictureview;	
	}

function viewField($config, $viewItem)
	{
	if (file_exists($config["configShare"]["incPath"].$config["modulSelect"].".inc.php"))
		{
		include $config["configShare"]["incPath"].$config["modulSelect"].".inc.php";
		}

	return $viewItem;
	}
	
function ParseTplFORM($tpl,$config,$p_itemValues)
	{
	$ex=explode ('##START##',$tpl);
	for ($i=0; $i<sizeof($ex); $i++)
		{
		if (substr_count($ex[$i],'##STOP##')>0)
			{
			$xxpdfParseTpl=explode('##STOP##',$ex[$i]);
			$funParam = explode('#',$xxpdfParseTpl[0]);
			switch($funParam[0])
				{
				case "title":
					/*
					##Start##title#modul#field##Stop##
					example: 
					##Start##title#usertitle#nameTitle##Stop##
					*/
					if (isset($config[$funParam[1]][$funParam[2]]))
						{
						$to=$config[$funParam[1]][$funParam[2]];
						}
					else
						{
						$to=$config["configShare"][$funParam[2]];
						}
					break;
				case "textarea":
					/*
					##Start##textarea#field#cols#rows##Stop##
					example:
					##Start##textarea#x_name#60#10##Stop##
					*/
					$to='<textarea name="'.$funParam[1].'" cols="'.$funParam[2].'" rows="'.$funParam[3].'" style="width:'.$funParam[4].';height:'.$funParam[5].'">'.$p_itemValues[$funParam[1]].'</textarea>';
					$to.=$config["configShare"][str_replace("x_","e_",$funParam[1])."Err"];
					break;
				case "text":
					/*
					##Start##text#field#size#maxlength##Stop##
					example:
					##Start##text#x_name#63#100##Stop##
					*/
					$to='<input type="text" name="'.$funParam[1].'" size="'.$funParam[2].'" maxlength="'.$funParam[3].'" value="'.$p_itemValues[$funParam[1]].'">';
					$to.=$config["configShare"][str_replace("x_","e_",$funParam[1])."Err"];
					break;
				case "editorText":
					/*
					##Start##editorText#field#style#jcol#jrow##Stop##
					example:
					##Start##editorText#x_description#height: 170px; width: 500px;border: 1px solid #999999;#700#200##Stop##
					*/
					$to='<textarea id="x_description" name="x_description" style="height: 170px; width: 500px;border: 1px solid #999999;">'.htmlspecialchars($p_itemValues[$funParam[1]]).'</textarea><script language="javascript1.2" type="text/javascript">generate_wysiwyg(\'x_description\',700,200);</script>';
					break;
				case "selectOption":
					/*
					##Start##selectOption#table#pleaseSelect#admin##Stop##
					example:
					##Start##selectOption#site#1#0##Stop##
					*/
					$to=selectOption($config,$funParam[1],$p_itemValues,$funParam[2],$funParam[3]);
					break;
				case "itemValues":
					$to=$p_itemValues[$funParam[1]];
					break;
				case "config":
					/*
					##Start##selectOption#table#pleaseSelect#admin##Stop##
					example:
					##Start##selectOption#site#1#0##Stop##
					*/
					{
					$configSize = sizeof($funParam);
					switch ($configSize)
						{
						case 2:
							$to=$config[$funParam[1]];
							break;
						case 3:
							$to=$config[$funParam[1]][$funParam[2]];
							break;
						default:
							break;
						}
					}
					break;
				case "configPrice":
					/*
					##Start##selectOption#table#pleaseSelect#admin##Stop##
					example:
					##Start##selectOption#site#1#0##Stop##
					*/
					{
					$configSize = sizeof($funParam);
					switch ($configSize)
						{
						case 2:
							$to=number_format(intval($config[$funParam[1]]),0,',','.');
							break;
						case 3:
							$to=number_format($config[$funParam[1]][$funParam[2]],0,',','.');
							break;
						default:
							break;
						}
					}
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
			$tpl=str_replace('##START##'.$xxpdfParseTpl[0].'##STOP##', $to, $tpl);
			}
		}
	return $tpl;
	}

function ParseTpl($tpl,$config)
	{
	$tpl=ParseTplForm($tpl,$config,"");
	$qs=array();
	$qv=array();
	$ex=explode ('{$',$tpl);
	for ($i=0; $i<sizeof($ex); $i++)
		{
		if (substr_count($ex[$i],'}')>0)
			{
			$xxpdfParseTpl=explode('}',$ex[$i]);
			if (substr_count($xxpdfParseTpl[0],'[')>0)
				{
				$clrpdfParseTpl=explode ('[',$xxpdfParseTpl[0]); 
				$sppdfParseTpl=str_replace('$','',substr($clrpdfParseTpl[1],0,strlen($clrpdfParseTpl[1])-1)); 
				$to=trim($config[$sppdfParseTpl]);
				}
			$tpl=str_replace('{$'.$xxpdfParseTpl[0].'}', trim($to), $tpl);
			}
		}
	return $tpl;
	}
?>

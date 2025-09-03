<?php
if (isset($_POST["x_nickname"])) {$config["x_nickname"]=$_POST["x_nickname"];} else {$config["x_nickname"]="";}
if (isset($_POST["x_password"])) {$config["x_password"]=$_POST["x_password"];} else {$config["x_password"]="";}
$config["modulName"]="login";

$config = configFieldSearchAll($config,"backend");
$config = languageFieldSearchAll($config,"frontend");
$config = configFieldSearchModul($config);
$config = languageFieldSearchModul($config);
$config["dayID"] = dayIdentifier(time());
$config["x_nicknameError"]="";
$config["x_passwordError"]="";

$userID = Array();
$userIDResult = Array();
$inputOK=1;
if (empty($config["x_nickname"])) {
	$config["x_nicknameError"] = '<div id="rowError">'.$config["loginNicknameEmpty"].'</div><div style="clear:both;"></div>';
	$config["loginNicknameLabel"] = "<span id='errorMessageText'>".$config["loginNicknameLabel"]."</span>";
	$config["loginNicknameLabelTitle"] = $config["loginNicknameEmpty"];
	$inputOK=0;
} else 	{
	$config["loginUserSQL"]="SELECT * FROM `core_users` WHERE active=1 AND nickname='".$config["x_nickname"]."'";
	$userID=$config["dbConnect"]->prepare($config["loginUserSQL"]);
	$userID->execute();
	$userIDResult=$userID->fetch(PDO::FETCH_ASSOC);
	$userID->closeCursor();
	if (empty($userIDResult["id"])) {
		$config["x_nicknameError"] = '<div id="rowError">'.$config["loginNicknameNotExist"].'</div><div style="clear:both;"></div>';
		$config["loginNicknameLabel"] = "<span id='errorMessageText'>".$config["loginNicknameLabel"]."</span>";
		$config["loginNicknameLabelTitle"] = $config["loginNicknameNotExist"];
		$inputOK=0;
	} else {
		$inputOK=1;
	}
}
if (empty($config["x_password"])) {
	$config["x_passwordError"] = '<div id="rowError">'.$config["loginPasswordEmpty"].'</div><div style="clear:both;"></div>';
	$config["loginPasswordLabel"] = "<span id='errorMessageText'>".$config["loginPasswordLabel"]."</span>";
	$config["loginPasswordLabelTitle"] = $config["loginPasswordEmpty"];
	$inputOK=0;
} else if ($config["x_password"] != $userIDResult["password"]) {
	$config["x_passwordError"] = '<div id="rowError">'.$config["loginPasswordBad"].'</div><div style="clear:both;"></div>';
	$config["loginPasswordLabel"] = "<span id='errorMessageText'>".$config["loginPasswordLabel"]."</span>";
	$config["loginPasswordLabelTitle"] = $config["loginPasswordBad"];
	$inputOK=0;
}
if ($inputOK == 1)
	{
	session_unset();
//	session_destroy();
	$core_usersSQL = "SELECT *,(SELECT core_themesID FROM core_groups WHERE core_users.core_groupsID=core_groups.id) AS core_groups_themesID,";
	$core_usersSQL .= "(SELECT fieldValue FROM core_users_config WHERE core_users_config.core_usersID=core_users.id AND fieldName='themes') AS core_users_themesID,";
	$core_usersSQL .= "(SELECT fieldValue FROM core_users_config WHERE core_users_config.core_usersID=core_users.id AND fieldName='modulSelect') AS core_users_modulSelect";
	$core_usersSQL .= "  FROM `core_users` WHERE `nickname` = '" . $config["x_nickname"] . "'";
	$core_usersRec=$config["dbConnect"]->prepare($core_usersSQL);
	$core_usersRec->execute();
	$core_usersCount = $core_usersRec->rowCount();
	if ($core_usersCount != 0) {
		$rowUser=$core_usersRec->fetch(PDO::FETCH_ASSOC);
		$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_User"] = $rowUser["nickname"];
	 	$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"] = $rowUser["id"];
	 	$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"] = $rowUser["core_groupsID"];
		if ($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"]==2 &&
			$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]==2) {
			backup_db($config["configShare"]["databaseServer"],$config["configShare"]["databaseUser"],$config["configShare"]["databasePassword"],$config["configShare"]["databaseSelect"]);
		} 
		if (!empty($rowUser["core_users_modulSelect"])) {
			$config["configShare"]["baseModul"]="?modulSelect=".trim($rowUser["core_users_modulSelect"])."&amp;modulAction=list&amp;".trim($rowUser["core_users_modulSelect"])."cmd=resetall";
			$config["configShare"]["baseModul"]="index.php?modulSelect=".trim($rowUser["core_users_modulSelect"])."&amp;modulAction=list&amp;".trim($rowUser["core_users_modulSelect"])."cmd=resetall";
		}
		if (!empty($rowUser["core_users_themesID"])) {
			$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"] = $rowUser["core_users_themesID"];
		} else if (!empty($rowUser["core_groups_themesID"])) {
			$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"] = $rowUser["core_groups_themesID"];
		} else {
			$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"] = 1;
		}
	} else {
		$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"] = 1;
	}
	$_SESSION["status_core_themesFilterID"] = $_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"];

	if (!isset($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"])) {
		$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"]=1;
	}
	$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"]=8;

	$themesSQL = "SELECT id, name, path, bgcolor, fgcolor FROM core_themes WHERE active=1 AND id=".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"];
	$themesRS=$config["dbConnect"]->prepare($themesSQL);
	$themesRS->execute();
	$themesCount = $themesRS->rowCount();
	if ($themesCount > 0) {
		$themesData=$themesRS->fetch(PDO::FETCH_ASSOC);
		$config["configShare"]["themesName"]=$themesData["path"];
		$config["configShare"]["themePath"] = "themes/".$config["configShare"]["themesName"]."/";
		$config["configShare"]["imagePath"] = $config["configShare"]["themePath"]."img/";
		$config["configShare"]["imageDirectory"] = $config["configShare"]["themePath"]."img/";
		$config["configShare"]["imageButton"] = $config["configShare"]["imagePath"] . "button/";
		$config["actualBgColor"] = $themesData["bgcolor"];
		$config["actualFgColor"] = $themesData["fgcolor"];
	}

}
jumpToPage($config["configShare"]["baseModul"]);
?>

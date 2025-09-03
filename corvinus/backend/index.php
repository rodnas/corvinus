<?php
if (version_compare(phpversion(), '5.3.10', '>')) {
//	echo 'Current PHP version: '.phpversion().'<br>';
	error_reporting(0);
}
//@error_reporting(E_ALL | E_STRICT);   // NOT FOR PRODUCTION SERVERS!
//ini_set('display_errors', '1');         // NOT FOR PRODUCTION SERVERS!

$sessionID = session_id();
if(empty($sessionID)) {
	session_id('corvinus');
	session_start();
}

ob_start();
if (!DEFINED('runOK')) define('runOK',true);
$config=Array();
$config["startPageTime"]=microtime(true);
$config["systemROOT"]="../";
header("Content-type: text/html; charset=utf-8");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache"); // HTTP/1.0 

// use database
include ($config["systemROOT"]."share/inc/config.inc.php");
$config["dbConnect"] = new PDO($config["configShare"]["databaseType"].':host='.$config["configShare"]["databaseServer"].';dbname='.$config["configShare"]["databaseSelect"], $config["configShare"]["databaseUser"], $config["configShare"]["databasePassword"]);
$setNames=$config["dbConnect"]->prepare($config["configShare"]["setNames"]);
$setNames->execute();

// include libs
include ($config["systemROOT"]."share/lib/config.lib.php");
$config = configFieldSearchAll($config,"backend");
$config = languageFieldSearchAll($config,"backend");
$fileName="configShare";
$fileType="cfg";
$filePath="cfg/";
$loadError="cssNotFound";
$config = cfgLoader($config,$fileName,$fileType,$filePath,$loadError);

// set whichSystem and whichSystemMode
$_SESSION[$config["configShare"]["whichSystem"]."whichSystemMode"] = "backend";
$config["configShare"]["whichSystemAndMode"]=$config["configShare"]["whichSystem"].$config["configShare"]["whichSystemMode"]."_";
$config["configShare"]["startPath"]="backend";
$config["configShare"]["startNextIndexPath"]="backend";
$config["startPath"]=$config["configShare"]["startPath"];

$config["configShare"]["whichSystemMode"]="backend";
//$config = localserverSet($config,"backend");

$fileName="configShare";
$fileType="lng";
$filePath="lng/";
$loadError="lngNotFound";
$config = lngLoader($config,$fileName,$fileType,$filePath,$loadError);

include ($config["systemROOT"].$config["configShare"]["shareLibPath"]."phpmkrfn.lib.php");
include ($config["systemROOT"].$config["configShare"]["shareLibPath"]."function.lib.php");
include ($config["systemROOT"].$config["configShare"]["shareLibPath"]."sql.lib.php");
include ($config["systemROOT"].$config["configShare"]["shareLibPath"]."screen.lib.php");

if (isset($_POST["modulOperation"]) && $_POST["modulOperation"]=="login") {
	include $config["systemROOT"].$config["configShare"]["shareModulsPath"]."login.inc.php";    	
}

if (!ISSET($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"])) {
	$_POST["modulOperation"]="simple::logout";
}
	// set layout from core_users_config
	$config["layoutMainHTML"]="layoutsetup";
	
	$_SESSION[$config["configShare"]["whichSystemAndMode"]."layout"] = $config["layoutMainHTML"];
	// set From core_groups
	$core_groups_configSQL = "SELECT fieldName,fieldValue FROM core_groups_config WHERE core_groupsID='".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"]."'";
	foreach ($config["dbConnect"]->query($core_groups_configSQL) as $core_groups_configData) {
		$config["configShare"][$core_groups_configData["fieldName"]]=$core_groups_configData["fieldValue"];
	}
	// set zoom from core_users_config
	$core_zoomSQL = "SELECT fieldName,fieldValue FROM core_users_config WHERE core_usersID='".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]."' AND fieldName LIKE '%Zoom'";
	foreach ($config["dbConnect"]->query($core_zoomSQL) as $zoomData) {
		$config["configShare"][$zoomData["fieldName"]]=$zoomData["fieldValue"];
	}
	// set config from core_configs
	$configSQL = "SELECT id, name, title, tplName FROM core_configs WHERE active=1 AND name !='configShare'";
	foreach ($config["dbConnect"]->query($configSQL) as $configData) {
		$configRowCount = 0;
		$config[$configData["name"]]["name"]=$configData["name"];
		$config[$configData["name"]]["title"]=$configData["title"];
		$config[$configData["name"]]["modulID"]=$configData["id"];
		$configRowCount++;
	}
	if (isset($_POST["x_modulFilterID"]) && !empty($_POST["x_modulFilterID"])) {
		if ($_POST["x_modulFilterID"] != -1) {
			$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_modulFilterID"] = $_POST["x_modulFilterID"];
		} else {
			unset($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_modulFilterID"]);
		}
	}
	$config["configShare"]["modulID"] = $_SESSION[$config["configShare"]["whichSystemAndMode"]. "status_modulID"];
	$config["configShare"]["modulFilterID"] = $_SESSION[$config["configShare"]["whichSystemAndMode"]. "status_modulFilterID"];

	// set modulSelect
	if (isset($_SESSION[$config["configShare"]["whichSystemMode"].'SESSIONID'])) $sessionLive=$_SESSION[$config["configShare"]["whichSystemMode"].'SESSIONID'];
	$config = modulOperation($config);
	if (!empty($config["modulOperation"])) {
		$modulSelect = $config["modulSelect"];
//		$_SESSION[$config["configShare"]["whichSystemMode"]."modulSelect"] = $modulSelect;
		$modulAction = $config["modulAction"];
//		$_SESSION[$config["configShare"]["whichSystemMode"]."modulAction"] = $modulAction;
	} else {
		if (isset($_GET["modulSelect"]) ) {
			$modulSelect=$_GET["modulSelect"]; 
			$_SESSION[$config["configShare"]["whichSystemMode"]."modulSelect"] = $modulSelect;
		} else if (isset($_POST["modulSelect"])) {
			$modulSelect=$_POST["modulSelect"]; 
			$_SESSION[$config["configShare"]["whichSystemMode"]."modulSelect"] = $modulSelect;
		} else if (isset($_SESSION[$config["configShare"]["whichSystemMode"]."modulSelect"])) {
			$modulSelect=$_SESSION[$config["configShare"]["whichSystemMode"]."modulSelect"]; 
		}
		$config["modulSelect"]=$modulSelect;
	
		// set modulAction
//		$modulAction="list";
		if (isset($config["modulAction"]) && !empty($config["modulAction"]) && $config["modulAction"]!="list") {
			$modulAction = $config["modulAction"];
		} else if (isset($_GET["modulAction"])) {
			$modulAction=$_GET["modulAction"]; 
			$_SESSION[$config["configShare"]["whichSystemMode"]."modulAction"] = $modulAction;
		} else if (isset($_POST["addSubmit"])) {
			$modulAction="add"; 
			$_SESSION[$config["configShare"]["whichSystemMode"]."modulAction"] = $modulAction;
		} else if (isset($_POST["modulAction"])) {
			$modulAction=$_POST["modulAction"]; 
			$_SESSION[$config["configShare"]["whichSystemMode"]."modulAction"] = $modulAction;
		} else if (!isset($modulAction) || empty($modulAction)) {
	//		$modulAction="list"; 
		}
		$config["modulAction"]=$modulAction;
	}
	if (isset($config["modulSelect"]) && !empty($config["modulSelect"])) {
		if ($config["modulSelect"] == "login" || $config["modulSelect"] == "logout") {
			$config["modulSelect"] = $config["configShare"]["homeModul"];
		}
	} else {
		$config["modulSelect"] = $config["configShare"]["homeModul"];
		$_SESSION[$config["configShare"]["whichSystemMode"]."modulSelect"] = $config["modulSelect"];
		$config["modulAction"]="list"; 
		$_SESSION[$config["configShare"]["whichSystemMode"]."modulAction"] = $config["modulAction"];
	}
	if (!isset($config[$modulSelect]["modulID"]) && empty($config[$modulSelect]["modulID"])) {
		$modulSelect = $config["configShare"]["homeModul"];
	} else 	{
		$config["configShare"]["modulID"]=$config[$modulSelect]["modulID"];
	}
	
	$modulImagePath = $config["configShare"]["docrootPath"] . $config[$modulSelect]["imgpath"];

	$config["sharedTPL"]["iniCFG"] = tplUp("shared",$config,"tpl/");

	// set themes from database
	if (isset($_POST["x_core_themesFilterID"]) && !empty($_POST["x_core_themesFilterID"])) {
		$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"] = $_POST["x_core_themesFilterID"];
		coreUsersConfigSet($config,"themes",$_POST["x_core_themesFilterID"]);
	} else if (@$_SESSION[$config["configShare"]["whichSystemAndMode"]. "status_core_themesFilterID"] == "") {
		$themesStartSQL = "SELECT id, name FROM core_themes WHERE active=1 AND name='".$config["configShare"]["themeStart"]."'";
		$themesStartRS=$config["dbConnect"]->prepare($themesStartSQL);
		$themesStartRS->execute();
		$themesStartCount = $themesStartRS->rowCount();
		if ($themesStartCount > 0) {
			$themesStartData = $themesStartRS->fetch();
			$config["configShare"]["themePath"] = "backend/themes/".$config["configShare"]["themesName"]."/";
			$_SESSION[$config["configShare"]["whichSystemAndMode"]. "status_core_themesFilterID"] = $themesStartData["id"];
		} else {
			$_SESSION[$config["configShare"]["whichSystemAndMode"]. "status_core_themesFilterID"] = 2;
		}
	}
	$_SESSION["status_core_themesFilterID"] = $_SESSION[$config["configShare"]["whichSystemAndMode"]. "status_core_themesFilterID"];
	
	$config["configShare"]["themesFilterID"] = $_SESSION[$config["configShare"]["whichSystemAndMode"]. "status_core_themesFilterID"];
	$themesSQL = "SELECT id, name, bgcolor, fgcolor FROM core_themes WHERE active=1 AND id=".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_core_themesFilterID"];
	$themesRS=$config["dbConnect"]->prepare($themesSQL);
	$themesRS->execute();
	$themesCount = $themesRS->rowCount();
	if ($themesCount > 0) {
		$themesData=$themesRS->fetch(PDO::FETCH_ASSOC);
//		$config["configShare"]["themesName"]=$themesData["path"];
//		$config["configShare"]["themePath"] = "themes/".$config["configShare"]["themesName"]."/";
//		$config["configShare"]["imagePath"] = $config["configShare"]["themePath"]."img/";
//		$config["configShare"]["imageDirectory"] = $config["configShare"]["themePath"]."img/";
//		$config["configShare"]["imageButton"] = $config["configShare"]["imagePath"] . "button/";
		$config["actualBgColor"] = $themesData["bgcolor"];
		$config["actualFgColor"] = $themesData["fgcolor"];
	}
	if (isset($_REQUEST["whichModul"]) &&!empty($_REQUEST["whichModul"])) {
		$config["whichModul"]=$_REQUEST["whichModul"];
	}
	if (isset($_REQUEST["x_whichModul"]) &&!empty($_REQUEST["x_whichModul"])) {
		$config["whichModul"]=$_REQUEST["x_whichModul"];
	}
	$allRecs = modulPermission($config,$modulSelect);
	$config["modulSelect"]=$modulSelect;
	$config["modulAction"]=$modulAction;
	
	// CFG Start 
	$fileType="cfg";
	$filePath="cfg/";
	$loadError="cfgNotFound";
	$config = cfgLoader($config,$config["modulSelect"],$fileType,$filePath,$loadError);

	$config[$config["modulSelect"]]["modulFrameInclude"] = $config["systemROOT"];
	$otherFrame = 0;
	if (!isset($config[$config["modulSelect"]]["modulFramePath"])) {
		$config[$config["modulSelect"]]["modulFrameInclude"] .= $config["configShare"]["modulFramePath"];
	} else 	{
		$config[$config["modulSelect"]]["modulFrameInclude"] .= $config[$config["modulSelect"]]["modulFramePath"];
		$otherFrame = 1;
	}
	$config["configShare"]["modulFrameIncludePath"] = $config["systemROOT"].$config["configShare"]["modulFramePath"];
	$config[$config["modulSelect"]]["modulFrameIncludePath"] = $config[$config["modulSelect"]]["modulFrameInclude"];
	if (!isset($config[$config["modulSelect"]]["modulFrameFile"])) {
		$config[$config["modulSelect"]]["modulFrameInclude"] .= $config["configShare"]["modulFrameFile"];
	} else {
		$config[$config["modulSelect"]]["modulFrameInclude"] .= $config[$config["modulSelect"]]["modulFrameFile"];
		$otherFrame = 1;
	}
	require_once ($config["configShare"]["modulFrameIncludePath"].$config["configShare"]["modulFrameFile"]);
	if ($otherFrame == 1) {
		require_once ($config[$config["modulSelect"]]["modulFrameInclude"]);
	}

	if (!isset($config[$config["modulSelect"]]["modulFrameName"])) {
		$config[$config["modulSelect"]]["modulFrameName"] = $config["configShare"]["modulFrameName"];
	}

	$config["contentRightWidth"]="width:100%;";
//	$config["layoutFullBack"]= "?modulSelect=".$modulSelect."&modulAction=".$modulAction."&cmd=resetall";
	$viewItem["listTopNavigation"]=1;
	$viewItem["listBottomNavigation"]=1;
	$config = modulFrame($config, $modulSelect, $modulAction, $viewItem);
	$config["content_setupHTML"] = $config["contentHTML"];
	
	$config["modulSelect"]=$modulSelect;
	$config["modulAction"]=$modulAction;
	$config[$modulSelect]["templateName"]="";

	$config["configShare"]["modulName"]=$config[$modulSelect]["title"];
	$config["configShare"]["actionName"]=$config["configShare"][$modulAction."Title"];
	$config["stopPageTime"]=microtime(true);
	$config["loadPageTime"]=$config["stopPageTime"]-$config["startPageTime"];
	$config["runTime"] = "&nbsp;".$_SESSION["screenResolution"]."&nbsp;".number_format($config["loadPageTime"],4,',',',')."&nbsp;".$config["configShare"]["secTitle"];
	
	switch ($config["modulSelect"]) {
		case 'video':
			$diagramSQL = "SELECT IF(ISNULL(rateNumber),'NULL',rateNumber) AS name, COUNT(ISNULL(rateNumber)) AS counter FROM video GROUP BY rateNumber";
			$diagramList=$config["dbConnect"]->prepare($diagramSQL);
			$diagramList->execute();
			$diagramRecordCount = $diagramList->rowCount();
			$diagramRecords = $diagramList->fetchAll();
			$diagramHead[0] = 'Pontszám';
			$diagramHead[1] = 'Mennyiség';
			$diagramItemTextPlus = ' pont';
			$diagramTotalText = 'Film pont megoszlása (Összesen: ';
			break;
		case 'recipe':
			$diagramSQL = "SELECT (SELECT name FROM recipetopic WHERE id=recipe.recipetopicID) AS name, COUNT(recipetopicID) AS counter FROM recipe GROUP BY recipetopicID";
			$diagramList=$config["dbConnect"]->prepare($diagramSQL);
			$diagramList->execute();
			$diagramRecordCount = $diagramList->rowCount();
			$diagramRecords = $diagramList->fetchAll();
			$diagramHead[0] = 'Kategória';
			$diagramHead[1] = 'Mennyiség';
			$diagramItemTextPlus = '';
			$diagramTotalText = 'Recept kategória megoszlása (Összesen: ';
			break;
		default:
			$diagramLabels = [];
			$diagramData = [];
			$diagramItemTextPlus = '';
			break;
	}
	if (count($diagramRecords) > 0) {
		$diagramLabels = [];
		$diagramData = [];
		$diagramTotal = 0;
		foreach ($diagramRecords as $item) {
			$diagramData[] = $item['counter'];
			$diagramLabels[] = $item['name'].$diagramItemTextPlus." (".$item['counter'].')';
			$diagramTotal += $item['counter'];
		}
		$diagramTotalText .= $diagramTotal.')';
	
	}
	if (count($diagramData)) {
		$config["diagram"].= "
		<div id='container' style='width: 98%;'>
			<canvas id='myChart'></canvas>
		</div>
		<script>
		var ctx = document.getElementById('myChart');
		var myChart = new Chart(ctx, {
			type: 'pie',
			data: {
				labels: ".json_encode($diagramLabels).",
				datasets: [{
					label: '# pont',
					data: ".json_encode($diagramData).",
					backgroundColor: [
						window.chartColors.black,
						window.chartColors.white,
						window.chartColors.silver,
						window.chartColors.gray,
						window.chartColors.maroon,
						window.chartColors.red,
						window.chartColors.purple,
						window.chartColors.fuchsia,
						window.chartColors.green,
						window.chartColors.lime,
						window.chartColors.olive,
						window.chartColors.yellow,
						window.chartColors.navy,
						window.chartColors.blue,
						window.chartColors.teal,
						window.chartColors.aqua,
						window.chartColors.orange
					],
					borderColor: '#CCCCCC',
					borderWidth: 2
				}]
			},
			options: {
				responsive: true,
				legend: {
					display: true,
					position: 'left'
				},
				title: {
					display: true,
					text: '".$diagramTotalText."'
				},

				tooltips: {
                			callbacks: {
						label: function(tooltipItem, data) {
							var label = data.labels[tooltipItem.index];
							var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
							var res = label.split('(',1);
 
							if (label) {
								var labelText = label;
							}
							label = res + ': '+value;
							return label;
						}
					},

	                	},
	                	
			}
		});
		</script>
		";
	}
	if (isset($config[$modulSelect]["layoutMainHTMLNo"]) && $config[$modulSelect]["layoutMainHTMLNo"]==1) {
		echo $config["content_setupHTML"];
	} else {
		if (!isset($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]) ||
			!isset($_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"]) ||
			$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserLevel"]==1) {
			$config["contentHTML"] = "";
			$config["topStatusHTML"] = "";
			$config["topSearchBasicHTML"] = "";
			$config["listFilterFullHTML"] = "";
			$config["statusMessageHTML"] = "";
			$config["topMenuHTML"] = "";

		}
		display($config);
	}
//close connection
$config["dbConnect"] = NULL;	
?>
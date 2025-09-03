<?php
function modulFramePDF($config, $viewItem)
	{
	if (isset($_REQUEST["back"])) {jumpToPage($config[$config["modulSelect"]]["whichBack"]);}
	$_SESSION["modulSelectPDF"]=$config["modulSelect"];
	if (isset($config["modulRecordID"]))
		{
		$_SESSION["keyToPDF"]=$config["modulRecordID"];
		$getRecordPDFSQL = "SELECT ".$config[$config["modulSelect"]]["mainTable"].".*,";
		$getRecordPDFSQL .= "(SELECT core_users.nickname FROM core_users WHERE core_users.id = ".$config[$config["modulSelect"]]["mainTable"].".insertUserID ) AS insertUserID,";
		$getRecordPDFSQL .= "(SELECT core_users.nickname FROM core_users WHERE core_users.id = ".$config[$config["modulSelect"]]["mainTable"].".modifyUserID ) AS modifyUserID";
		$getRecordPDFSQL .= " FROM " . $config[$config["modulSelect"]]["mainTable"];
		$getRecordPDFSQL .= " WHERE " . $_SESSION[$config["modulSelect"]["whichSystemAndMode"].$config["modulSelect"]."sqlKey"];
		$_SESSION["listToPDF"]=$getRecordPDFSQL;
		}
	else
		{
		$_SESSION["listToPDF"]=$_SESSION[$config["modulSelect"]]["strSQLNoLimit"];
		unset($_SESSION["keyToPDF"]);
		}
	$config["getAction"]="";
	$config["contentPDFHTML"] = modulFramePDFRecord($config,$itemValues,"", $viewItem);
	$viewHTML = iniCFGParser($config["sharedTPL"]["iniCFG"],"##pdfForm##","##/pdfForm##");
	$config["contentHTML"]=parseContent($viewHTML,$config,$itemValues);
	return $config;
	}

function modulFramePDFRecord($config, $p_itemValues, $p_getAction, $viewItem)
	{
	$viewCFG = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##inputCFG##","##/inputCFG##");
	$viewCFG = iniCFGParser($config["configShare"]["iniCFG"],"##inputCFG##","##/inputCFG##");
	$viewForm = iniCFGParser($config[$config["modulSelect"]]["iniCFG"],"##pdfForm##","##/pdfForm##");
	$resultHTML = clearForm($config, $viewForm, $viewItem);
	return $resultHTML;
	}
?>

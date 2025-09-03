<?php
if (!DEFINED('runOK')) exit;
$config["importErrorLine"] ="";
switch ($config["modulSelect"]) 
	{
	case "products":
		{
		$import["productId"]=0;
		$import["name"]=1;
		$import["quantity"]=2;
		$import["makeWho"]=3;
		$import["makeType"]=4;
		$import["descriptionPublic"]=5;
		$import["descriptionPrivate"]=6;
		$import["price"]=7;
		$import["storageWhere"]=8;
		$import["updateWhen"]=9;
		$import["products_statusID"]=10;

		$core_localserverID = 1;
		if (@$_FILES["x_fileName"]["name"]!="") 
			{
			$fileNameElement = explode(".",@$_FILES["x_fileName"]["name"]);
			$extension = ".".$fileNameElement[count($fileNameElement)-1];
			$actualImgPath = $config["configShare"]["docrootPath"].$config["configShare"]["imageDirectory"].$config[$config["modulSelect"]]["imgPath"]."import/";
			$dirMake = rmkdir($actualImgPath, 0755);
			$fileNameSAVE = $fileNameElement[0]. $extension."_".date('YmdHis');
			$fileNameOrig = realPath($actualImgPath)."/".$fileNameSAVE;
			move_uploaded_file(@$_FILES["x_fileName"]['tmp_name'],$fileNameOrig);
			chmod($fileNameOrig,0644);
			$insertUserID = $_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"];
			$fileNewlist = realPath($actualImgPath)."/".$fileNameSAVE;
			$handle = @fopen($fileNewlist, "r");
			if ($handle)
				{
				$counterFull=0;
				$counterReal=0;
				$config[$config["modulSelect"]]["whichBack"].="&".$config["modulSelect"]."cmd=resetall&import=ok";
				$deleteSQL = "DELETE FROM `products` WHERE insertUserID='".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]."';";
				$productsDelete=$config["dbConnect"]->exec($deleteSQL);
				$config["importErrorLine"] ="";
				while (($buffer = fgets($handle)) !== false)
					{
					$buffer = str_replace("\r\n","",$buffer);
					$productsItem = explode(";",$buffer);
					$counterFull++;
					if ($counterFull > 1)
						{
						if (count($productsItem) != $config[$config["modulSelect"]]["importLineFieldsNumber"])
							{
							$config[$config["modulSelect"]]["whichBack"].="&".$config["modulSelect"]."cmd=resetall&import=bad";
							$config["importErrorLine"] = "Mező hiba a sorban!";
							break;
							}
						if (!empty($productsItem[0]))
							{
							$insertProduct["productId"]=$productsItem[$import["productId"]];
							$insertProduct["name"]=$productsItem[$import["name"]];
							$insertProduct["quantity"]=$productsItem[$import["quantity"]];
							$insertProduct["makeWho"]=$productsItem[$import["makeWho"]];
							$insertProduct["makeType"]=$productsItem[$import["makeType"]];
							$insertProduct["descriptionPublic"]=$productsItem[$import["descriptionPublic"]];
							$insertProduct["descriptionPrivate"]=$productsItem[$import["descriptionPrivate"]];
							$insertProduct["price"]=$productsItem[$import["price"]];
							$insertProduct["storageWhere"]=$productsItem[$import["storageWhere"]];
							$insertProduct["updateWhen"]=$productsItem[$import["updateWhen"]];
							$insertProduct["products_statusID"]=$productsItem[$import["products_statusID"]];
							
							if ($insertProduct["name"]=='NULL') {$insertProduct["name"]="";}
							if ($insertProduct["makeWho"]=='NULL') {$insertProduct["makeWho"]="";}
							if ($insertProduct["makeType"]=='NULL') {$insertProduct["makeType"]="";}
							if ($insertProduct["descriptionPublic"]=='NULL') {$insertProduct["descriptionPublic"]="";}
							if ($insertProduct["descriptionPrivate"]=='NULL') {$insertProduct["descriptionPrivate"]="";}
							if ($insertProduct["storageWhere"]=='NULL') {$insertProduct["storageWhere"]="";}
							if ($insertProduct["quantity"]=='NULL' || empty($insertProduct["quantity"])) {$insertProduct["quantity"]=1;}
							if ($insertProduct["products_statusID"]=='NULL' || empty($insertProduct["products_statusID"])) {$insertProduct["products_statusID"]=1;}
							if ($insertProduct["updateWhen"]=='NULL' || empty($insertProduct["updateWhen"])) {$insertProduct["updateWhen"]=db_actual_datetime();}
							$insertSQL = "INSERT INTO `products` (insertUserID,insertWhen,productId,name,descriptionPublic,descriptionPrivate,storageWhere,quantity,updateWhen,price,makeWho,makeType,products_statusID) VALUES (
								'".$_SESSION[$config["configShare"]["whichSystemAndMode"] . "status_UserID"]."',	
								'".db_actual_datetime()."',
								'".$insertProduct["productId"]."',
								'".$insertProduct["name"]."',
								'".$insertProduct["descriptionPublic"]."',
								'".$insertProduct["descriptionPrivate"]."',
								'".$insertProduct["storageWhere"]."',
								'".$insertProduct["quantity"]."',
								'".$insertProduct["updateWhen"]."',
								'".$insertProduct["price"]."',
								'".$insertProduct["makeWho"]."',
								'".$insertProduct["makeType"]."',
								'".$insertProduct["products_statusID"]."');";
							$productsInsert=$config["dbConnect"]->exec($insertSQL);
							$counterReal++;
							}
						else {
							$config["importErrorLine"] .= $counterFull." => ".$buffer.'<br>';
							}
						}
					else
						{
						if (count($productsItem) != $config[$config["modulSelect"]]["importLineFieldsNumber"])
							{
							$config[$config["modulSelect"]]["whichBack"].="&".$config["modulSelect"]."cmd=resetall&import=bad";
							$config["importErrorLine"] = "Mező hiba a fejben!";
							break;
							}
						}
					}
				if (!feof($handle))
					{
					$config[$config["modulSelect"]]["whichBack"].="&".$config["modulSelect"]."cmd=resetall&import=bad";
						if (empty($config["importErrorLine"])) {
							$config["importErrorLine"] = "Hiba a beolvasott file-ban!";
						}				
					}
				fclose($handle);
				}
			}
		$import=$config["dbConnect"]->exec("INSERT INTO `core_import` (name,fileName,description,errorMessage,insertUserID,insertWhen) VALUES ('".$itemValues["x_importName"]."','".$fileNameSAVE."','".$itemValues["x_description"]."','".$config["importErrorLine"]."','".$insertUserID."','".date("Y-m-d H:m:s")."')");
		break;
		}
	}
?>
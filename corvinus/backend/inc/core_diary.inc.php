<?php
if ($config["modulAction"] == "list") {$viewItem['core_diary_x_insertWhen']=1;}
if ($config["modulAction"] == "list")
	{
	if ($config[$config["modulSelect"]]["viewDescription"]==1) {$viewItem['core_diary_x_description']=1;} else {$viewItem['core_diary_x_description']=0;}
		if (isset($_SESSION[$config["modulSelect"]]["desription"])) {
			if ($_SESSION[$config["modulSelect"]]["desription"]==1) {
				$config[$config["modulSelect"]]["viewDesription"]=1;
				$viewItem['core_diary_x_activity']=1;
			} else {
				$config[$config["modulSelect"]]["viewDesription"]=0;
				$viewItem['core_diary_x_activity']=0;
			}
		}
	}
?>
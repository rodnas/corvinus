<?php
// user levels
define("ewAllowAdd", 1, true);
define("ewAllowDelete", 2, true);
define("ewAllowEdit", 4, true);
define("ewAllowView", 8, true);
define("ewAllowList", 8, true);
define("ewAllowSearch", 8, true);
define("ewAllowAdmin", 16, true);

// database connect
$config["configShare"]["databaseType"] = "mysql";
$config["configShare"]["languageType"] = "hu";
$config["configShare"]["setNames"]="set names utf8";

switch(strtolower($_SERVER['HTTP_HOST'])) {
	case 'localhost':		// Wamp64\Xampp
	case 'rodnas.site':
	case 'corvinus.site':
		$config["configShare"]["databaseServer"] = "localhost";
		$config["configShare"]["databaseSelect"] = "corvinus";
		$config["configShare"]["databaseUser"] = "root";
		$config["configShare"]["databasePassword"] = "";
		break;
	case 'localhost:81':		// Laragon
	case 'corvinus:81':
		$config["configShare"]["databaseServer"] = "localhost";
		$config["configShare"]["databaseSelect"] = "corvinus";
		$config["configShare"]["databaseUser"] = "root";
		$config["configShare"]["databasePassword"] = "";
		break;
	case 'localhost.docker:8100':	// Docker
	case 'corvinus.docker:8100':
		$config["configShare"]["databaseServer"] = "database:3306";
		$config["configShare"]["databaseSelect"] = "corvinus";
		$config["configShare"]["databaseUser"] = "root";
		$config["configShare"]["databasePassword"] = "tiger";
		break;
	case 'localhost.server':	// Guest Ubuntu Server
	case 'corvinus.server':
	case 'localhost.desktop':	// Guest Ubuntu Server
	case 'corvinus.desktop':
		$config["configShare"]["databaseServer"] = "localhost";
		$config["configShare"]["databaseSelect"] = "corvinus";
		$config["configShare"]["databaseUser"] = "root";
		$config["configShare"]["databasePassword"] = "123";
		break;
	case 'moodle3test.uni-corvinus.hu':
		$config["configShare"]["databaseServer"] = "146.110.9.54";
		$config["configShare"]["databaseSelect"] = "moodle3mdb";
		$config["configShare"]["databaseUser"] = "tdtk";
		$config["configShare"]["databasePassword"] = "vJQyRABkGET7ysRX";
		break;
	default:
		$config["configShare"]["databaseServer"] = "localhost";
		$config["configShare"]["databaseSelect"] = "corvinus";
		$config["configShare"]["databaseUser"] = "root";
		$config["configShare"]["databasePassword"] = "";
		break;
}
?>
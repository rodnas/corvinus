-- MariaDB dump 10.17  Distrib 10.4.10-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: corvinus
-- ------------------------------------------------------
-- Server version	10.4.10-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `corvinus`
--

/*!40000 DROP DATABASE IF EXISTS `corvinus`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `corvinus` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `corvinus`;

--
-- Table structure for table `core_activitymodul`
--

DROP TABLE IF EXISTS `core_activitymodul`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_activitymodul` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_activitymodul`
--

LOCK TABLES `core_activitymodul` WRITE;
/*!40000 ALTER TABLE `core_activitymodul` DISABLE KEYS */;
INSERT INTO `core_activitymodul` VALUES (1,'Tevékenységmodulok',NULL,1,NULL,NULL,NULL,NULL),(10,'Blokkok',NULL,1,2,'2019-07-07 15:33:16',NULL,NULL),(11,'Atto HTML-szerkesztő / Az Alto segédprogramjai',NULL,1,2,'2019-07-07 15:33:35',NULL,NULL),(12,'Rendszergazda eszközei',NULL,1,2,'2019-07-07 15:44:04',NULL,NULL),(13,'Tiltott másolást ellenőrző segédprogramok',NULL,1,2,'2019-07-07 15:44:18',NULL,NULL),(14,'Stílusok',NULL,1,2,'2019-07-07 15:44:28',NULL,NULL),(15,'Helyi segédprogramok',NULL,1,2,'2019-07-07 15:44:41',NULL,NULL),(16,'2.2 (kiiktatott) feladat / assignment',NULL,1,2,'2019-07-14 19:45:30',NULL,NULL),(17,'Kérdéstípusok',NULL,1,2,'2019-07-14 20:38:38',NULL,NULL),(18,'Szövegszűrők',NULL,1,2,'2019-07-14 20:42:53',NULL,NULL),(19,'Beiratkozási módszerek',NULL,1,2,'2019-07-14 20:44:10',NULL,NULL),(20,'Hitelesítési segédprogramokBeállítások',NULL,1,2,'2019-07-14 20:45:24',NULL,NULL),(21,'Kurzusformák',NULL,1,2,'2019-07-14 20:53:28',NULL,NULL),(22,'Jelentések',NULL,1,2,'2019-07-14 20:53:44',NULL,NULL),(23,'contactfield',NULL,1,2,'2019-07-14 21:17:39',NULL,NULL);
/*!40000 ALTER TABLE `core_activitymodul` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_company`
--

DROP TABLE IF EXISTS `core_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_company` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_company`
--

LOCK TABLES `core_company` WRITE;
/*!40000 ALTER TABLE `core_company` DISABLE KEYS */;
/*!40000 ALTER TABLE `core_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_config`
--

DROP TABLE IF EXISTS `core_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_config` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `systemType` enum('frontend','backend') COLLATE utf8_bin DEFAULT NULL,
  `core_configsID` bigint(20) unsigned DEFAULT NULL,
  `fieldName` varchar(100) COLLATE utf8_bin NOT NULL,
  `fieldValue` text COLLATE utf8_bin NOT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `autoload` int(1) unsigned DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_config`
--

LOCK TABLES `core_config` WRITE;
/*!40000 ALTER TABLE `core_config` DISABLE KEYS */;
INSERT INTO `core_config` VALUES (1,'frontend',NULL,'core_localserverID','1',NULL,1,1,NULL,NULL,NULL,NULL),(14,'frontend',NULL,'cssFromFile','1',NULL,1,1,NULL,NULL,NULL,NULL),(15,'frontend',NULL,'cssInsertRename','0',NULL,1,1,NULL,NULL,NULL,NULL),(24,'frontend',NULL,'defaultOrderTime','--:-- - --:--',NULL,1,1,2,'2013-11-19 12:25:34',NULL,NULL),(32,'backend',72,'core_configsID','Modul',NULL,NULL,1,2,'2017-04-21 08:13:16',NULL,NULL);
/*!40000 ALTER TABLE `core_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_configs`
--

DROP TABLE IF EXISTS `core_configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_configs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `tplName` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `allrecs` int(2) unsigned DEFAULT 0,
  `ownrecs` int(2) unsigned DEFAULT 0,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned NOT NULL DEFAULT 0,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=105 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_configs`
--

LOCK TABLES `core_configs` WRITE;
/*!40000 ALTER TABLE `core_configs` DISABLE KEYS */;
INSERT INTO `core_configs` VALUES (1,'core_users','Felhasználók','core_users',15,0,NULL,1,1,'2005-08-29 23:45:38',2,'2013-08-24 11:47:27'),(2,'core_users_rights','Felhasználó jogai','core_users_rights',15,0,NULL,1,1,'2005-08-29 23:46:03',2,'2013-07-30 15:50:07'),(3,'core_groups','Csoport','core_groups',15,0,NULL,1,1,'2005-08-29 23:46:31',2,'2013-08-24 11:57:35'),(4,'core_groups_rights','Csoport jogai','core_groups_rights',15,0,NULL,1,1,'2005-08-29 23:46:46',2,'2012-01-17 13:37:39'),(5,'core_lang','Nyelv','core_lang',15,0,NULL,1,1,'2005-08-29 23:48:06',2,'2010-09-24 08:57:03'),(7,'core_userstitle','Titulus','core_userstitle',15,0,NULL,1,2,'2009-07-01 10:12:24',2,'2012-03-25 13:59:07'),(8,'userslog','login/logout',NULL,15,0,NULL,1,2,'2009-08-12 20:40:21',NULL,NULL),(10,'configShare','Rendszer',NULL,15,0,NULL,1,2,'2011-03-11 22:34:24',2,'2012-03-23 23:11:47'),(17,'core_configs','Konfigurátor','core_configs',15,15,NULL,1,2,'2012-01-16 14:15:08',2,'2013-07-30 15:48:30'),(22,'core_support','Támogatás','core_support',15,0,NULL,1,2,'2012-02-29 23:12:41',2,'2013-07-30 15:48:20'),(23,'core_support_topic','Téma','core_support_topic',8,0,NULL,1,2,'2012-03-02 23:02:26',2,'2013-08-01 09:24:49'),(24,'core_support_type','Típus','core_support_type',8,0,NULL,1,2,'2012-03-02 23:09:38',2,'2016-05-03 23:16:49'),(25,'core_support_status','Állapot','core_support_status',8,0,NULL,1,2,'2012-03-02 23:10:13',2,'2016-05-03 23:16:12'),(38,'core_messagewall','Üzenőfal','core_messagewall',8,0,NULL,1,2,'2012-03-21 18:28:31',2,'2012-05-12 23:30:35'),(61,'core_support_action','Intézkedés','core_support_action',8,0,NULL,1,2,'2013-08-05 11:36:14',2,'2016-05-03 23:16:08'),(72,'core_config','Setup','core_config',8,0,NULL,1,2,'2013-09-05 22:10:02',2,'2013-09-20 12:01:42'),(73,'core_language','Nyelv','core_language',8,0,NULL,1,2,'2013-09-23 13:12:50',NULL,NULL),(103,'core_activitymodul','Tevékenységmodul',NULL,0,0,NULL,1,2,'2019-07-07 14:44:57',NULL,NULL),(90,'core_themes','Arculat',NULL,0,0,NULL,1,2,'2017-04-28 10:15:35',NULL,NULL),(98,'admin','Admin',NULL,0,0,NULL,1,2,'2017-04-29 21:38:07',NULL,NULL),(99,'core_plugin','Plugin',NULL,0,0,NULL,1,2,'2019-07-07 07:41:22',NULL,NULL),(100,'core_info','Info',NULL,0,0,NULL,1,2,'2019-07-07 07:41:36',NULL,NULL),(101,'core_infogroup','Info csoport',NULL,0,0,NULL,1,2,'2019-07-07 07:41:55',NULL,NULL),(102,'core_diary','Napló',NULL,0,0,NULL,1,2,'2019-07-07 07:42:48',NULL,NULL),(104,'core_plugin_status','Plugin státusz',NULL,0,0,NULL,1,2,'2019-07-11 05:08:30',NULL,NULL);
/*!40000 ALTER TABLE `core_configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_diary`
--

DROP TABLE IF EXISTS `core_diary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_diary` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `actionWhen` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `what` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `activity` longtext COLLATE utf8_bin DEFAULT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `periodHour` float unsigned DEFAULT NULL,
  `active` int(1) DEFAULT 1,
  `langID` int(2) unsigned NOT NULL DEFAULT 0,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_diary`
--

LOCK TABLES `core_diary` WRITE;
/*!40000 ALTER TABLE `core_diary` DISABLE KEYS */;
INSERT INTO `core_diary` VALUES (1,'2019.04.04',NULL,'Sajnos az upgrade ma is sikertelen.\r\nElkezdtem összerakni, a segédrendszert amiről telefonon beszéltünk.\r\nNapló, Infó, Plugin lista.\r\nAmennyiben van esetleg neked is ötleted mi lenne jó benne még, kérlek írd meg','/* CORVINUS MOD */\r\n// ASK FOR PERMISSION TO CONTINUE.\r\n/*if (!empty($question)) {\r\n    echo \"\\n$question  Type \'yes\' to continue: \";\r\n    $line = fgets(STDIN);\r\n    if (trim($line) != \'yes\') {\r\n        echo \"\\nSTOPPED\\n\";\r\n        exit;\r\n    }\r\n*/\r\n    echo \"\\nMoodle course archiver running ...\\n\\n\";\r\n/*}*/\r\n    /* /CORVINUS MOD */',NULL,1,0,2,'2019-07-07 17:07:23',NULL,NULL),(2,'2019.07.03',NULL,'Sajnos az upgrade-el ma nem sikerült előrébb jutni, többször megkíséreltem.\r\nSikertelen után vissza kell állítani a kiinduló állapotot, moodle,moodledata, db visszatöltás.\r\nigaz a moodledata le van csupaszitva, csak a könyvtárak vannak benne a fileok nem, a db is csökkentve van 40Gb-ről 2.8Gb-re, de így is idő a visszaállítás.\r\nA plugin lista elkészítésével holnap a végére érek. ebben nem csak a 15 frissíthető, hanem az aminél szintén lehet kikapcsolni/bekapcsolni és eltávolítani.',NULL,NULL,1,0,2,'2019-07-07 17:14:47',NULL,NULL),(3,'2019.07.02',NULL,'Ubuntu Linux 18.04\r\n==================\r\nCorvinus Moodle site beindítása localhost-on.\r\nPlugin-ek frissítése.\r\nUpgrade megkísérlése 3.3.1+ -es 3.7+ -ra.\r\nSajnos nem sikerül, de teljesen mást jelez mint a windows-alatt.\r\nTáblákat hiányol, beraktam a a külön telepített Moodle-ből a táblákat, ezeket akkor továbbmegy, sajnos a végén még mindig elhasal.\r\nMajd Beni-ékkel megnézetem, nem kell még egyéb dolgokat is beállítani, a test server-en van moodle.crt, moodle.key ezek is lehet befolyásolják a működést.\r\nA külön telepített 3.6.3+ simán tudtam 3.7+ra frissíteni.\r\n\r\nHolnap tudnánk beszélni amikor neked megfelel, valamikor a Plugin-okról, egy kicsit rendet kelle teremteni.\r\nRengeteg van ami eleve \'kikapcsolva\' van, ezekez lehet simán \'eltávolítás\'-t lehetne kiadni rájuk, hogy ne terheljék a rendszer.',NULL,NULL,1,0,2,'2019-07-07 17:16:02',NULL,NULL),(4,'2019.04.01',NULL,'Nem gond, a gond, hogy az elérések nincsenek meg rendesen a test server-hez.\r\nDe nem emiatt kesergek, sikerült kideríteni, hogy gubanc lesz későbbiekben a php-vel.\r\nA rendszer 7.1.x verzión tud működni max, 7.2.x vagy 7.3.x verziókonxed, komolyabb nyomozást igényel majd.\r\nAz általam telepített moodle rendszer ellenben minden gond nélkül működik mindegyik php verzióval.\r\nEz csak azt jelenti, hogy a következő frissítésre ki kellene deríteni a gondokat, valószínűleg az már min 7.2.x-et vagy újabbat fog igényelni.\r\nAzt sikerült kiderítenem a lib/setuplib.php-ben az alábbi okoz gondot, amit nem tudom miért van benne?:\r\n/**\r\n * Simple class. It is usually used instead of stdClass because it looks\r\n * more familiar to Java developers ;-) Do not use for type checking of\r\n * function parameters. Please use stdClass instead.\r\n *\r\n * @package    core\r\n * @subpackage lib\r\n * @copyright  2009 Petr Skoda  {@link http://skodak.org}\r\n * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later\r\n * @deprecated since 2.0\r\n */\r\nclass object extends stdClass {\r\n    /**\r\n     * Constructor.\r\n     */\r\n    public function __construct() {\r\n        debugging(\"\'object\' class has been deprecated, please use stdClass instead.\", DEBUG_DEVELOPER);\r\n    }\r\n};\r\nEz szerintem felesleges lehet.\r\nEz a helyes ami benne van:\r\n\'class moodle_exception extends Exception {\'',NULL,NULL,1,0,2,'2019-07-07 17:17:19',NULL,NULL),(5,'2019.07.01',NULL,'Van egy ubuntu-m sikerült rá telepítenem egy 3.6.3+-os moodle-t!\r\nFrissítettem 3.7+ -ra, probléma mentesen sikerült, nem volt semmi zökkenő mint windows-on.\r\nEz megerősítette, hogy windows-t el kell felejteni moodle-el kapcsolatban, átálltam Ubuntu 18.04 Linux-ra.\r\nMost a testrendszer felélesztésével bíbelődöm, jelenleg fehér képernyő-t ad, valami nem stimmel.',NULL,NULL,1,0,2,'2019-07-07 17:18:31',NULL,NULL),(6,'2019.06.21',NULL,'Win 10 local saját telepítésű 3.6.3+ -ost sikerült upgradelni 3.7+ -re. \r\n\r\nmoodledata könyvtár upgrade  előtti visszatöltése az az upgrade után.\r\nezt nem láttam sehol lehírva, hogy kellene, vagy vaksi vagyok.',NULL,NULL,1,0,2,'2019-07-07 17:19:41',NULL,NULL),(7,'2019.06.19',NULL,'Windows 10 Pro\r\n\r\nlogo mellé jelzés illesztés, hogy mely serven vagyunk megoldható.\r\n\r\nfüggetlen friss telepítés 3.6.3+\r\n- update 3.7-re sikeresen lefut az update, ellenben utána az oldal nem találja magát.\r\n\r\nteszt server-ről leszedett verzió 3.3.1+\r\n- plugin frissítések (15) sikeresen lefutottak,  ellenben utána az oldal nem találja magát.\r\n- update 3.7-re sikeresen lefut az update, ellenben utána az oldal nem találja magát.\r\n- moodledata:\r\n    - közel 1TB-ról sikeresen zsugorítva,\r\n    - az oldal \'működésének\' megőrzésével a files és alkönyvtáraiból csak a könyvtárszerkezetet meghagyva\r\n- db: összméret 90GB (dump 41GB), GB-nél nagyobb tartalmú táblák egy részének ürítése\r\n- hack: - $CFG->loginhttps=false;                             //https kikapcsolás\r\n    - $CFG->siteadmins=\'2,86661\'; létező felhasználó id-k megadása     //administrator\r\n    - SELECT * FROM mdl_config WHERE name = \'siteadmin\'        //ez önmagában nem működött\r\n    - $CFG->passwordsaltmain = \'\';                    //jelszó sózás kikapcsolás\r\n\r\nkövetkeztetés\r\nwindows környezet nem igazán alkalmas a moodle-nek, nem minden művelet futtatása egyszerű.\r\n\r\nlocal linux-os környezet kialakítás szükséges, ez 1 nap minimum.\r\nminden segítség igazándiból linux-os környezetre vonatkozik.\r\n\r\nTeszt server szükséges, azon linux van, teljes elérhetőséggel!\r\n',NULL,NULL,1,0,2,'2019-07-07 17:20:24',NULL,NULL),(8,'2019.07.10',NULL,'Kiegészítő rendszer indítás.',NULL,NULL,1,0,3,'2019-07-11 09:01:16',NULL,NULL),(9,'2019.07.11',NULL,'Plugin státusz.\r\nRendszergazda:\r\nBalkányi Péter BPeter\r\nLi Róbert LRobert',NULL,NULL,1,0,3,'2019-07-11 09:02:50',NULL,NULL),(10,'2019.07.14',NULL,'Maradék plugin.',NULL,NULL,1,0,2,'2019-07-15 06:57:34',NULL,NULL),(11,'2019.07.15',NULL,'plugin takarítás úgy tűnik ok, plugin frissítés szintén ok tűnik.\r\n\r\nupgrade\r\nezek kellenek az adatbázisba végrehajtásra, a frissen külön telepítettből másolva, ezután jön login képernyő, de nem lép be\r\n\r\nmdl_message_conversations\r\nmdl_message_conversations_actions\r\nmdl_message_conversations_members\r\n\r\nmdl_analytics_indicator_calc\r\nmdl_analytics_models\r\nmdl_analytics_models_log\r\nmdl_analytics_predictions\r\nmdl_analytics_prediction_actions\r\nmdl_analytics_predict_samples\r\nmdl_analytics_train_samples\r\n\r\nmdl_notifications\r\nmdl_analytics_used_analysables\r\nmdl_analytics_used_files\r\n\r\nmdl_cohort\r\ntheme 	varchar(50) 	utf8mb4_unicode_ci 		Yes 	NULL 	\r\n\r\nmdl_messages',NULL,NULL,1,0,2,'2019-07-15 16:22:10',NULL,NULL),(12,'2019.07.16',NULL,'Rendszer újraélesztése.\r\nDump betöltés, file-ok másolása.',NULL,NULL,1,0,2,'2019-07-16 22:48:12',NULL,NULL),(13,'2019.07.21',NULL,'php php.ini opcache\r\n---------------------------\r\nopcache.enable = 1\r\nopcache.memory_consumption = 128\r\nopcache.max_accelerated_files = 10000\r\nopcache.revalidate_freq = 60\r\n\r\n; Required for Moodle\r\nopcache.use_cwd = 1\r\nopcache.validate_timestamps = 1\r\nopcache.save_comments = 1\r\nopcache.enable_file_override = 0\r\n\r\nmysql/mariadb my.ini\r\n---------------------------\r\n[client]\r\ndefault-character-set = utf8mb4\r\n\r\n[mysqld]\r\ninnodb_file_format = Barracuda\r\ninnodb_file_per_table = 1\r\ninnodb_large_prefix=ON\r\n\r\ncharacter-set-server = utf8mb4\r\ncollation-server = utf8mb4_unicode_ci\r\nskip-character-set-client-handshake\r\n\r\n[mysql]\r\ndefault-character-set = utf8mb4',NULL,NULL,1,0,2,'2019-07-22 05:28:44',NULL,NULL),(15,'2019.07.22',NULL,'http://moodle3test.uni-corvinus.hu server:\r\n--------------------------------------------------------\r\nplugin-ok rendbetétele:\r\ntörölhetők törlölve team assignment_team kivételével, keresem, hogy lehet kiszedni, mert ez is fejreállítja az upgrade-t.\r\nfrissíthetők frissítve',NULL,NULL,1,0,2,'2019-07-22 12:11:27',NULL,NULL),(14,'2019.07.22',NULL,'ezek gátolják az upgrade-t\r\n--------------------------------------------------------------------------\r\nattendance\r\n2017050226			Additional Missing from disk!\r\nThere is a new version 2019052801 available!\r\nRelease 3.6.7 Stable version Download More info...\r\n--------------------------------------------------------------------------\r\nadaptable\r\n2018111800			Additional Missing from disk!\r\nThere is a new version 2019062800 available!\r\nRelease 2.0.0 Stable version Download More info...\r\n--------------------------------------------------------------------------\r\ndownloadcenter\r\n2017111400			Additional Missing from disk!\r\nThere is a new version 2019052000 available!\r\nRelease v3.7.0 Stable version Download More info...',NULL,NULL,1,0,2,'2019-07-22 07:44:01',NULL,NULL),(16,'2019.07.23',NULL,'Coding error detected, it must be fixed by a programmer: moodle_database::update_record_raw() no fields found.\r\n\r\nMore information about this error\r\n\r\n×Debug info: \r\nError code: codingerror\r\n×Stack trace:\r\nline 1539 of \\lib\\dml\\mysqli_native_moodle_database.php: coding_exception thrown\r\nline 1589 of \\lib\\dml\\mysqli_native_moodle_database.php: call to mysqli_native_moodle_database->update_record_raw()\r\nline 279 of \\tag\\classes\\area.php: call to mysqli_native_moodle_database->update_record()\r\nline 366 of \\tag\\classes\\area.php: call to core_tag_area::update()\r\nline 1827 of \\lib\\upgradelib.php: call to core_tag_area::reset_definitions_for_component()\r\nline 518 of \\admin\\index.php: call to upgrade_core()',NULL,NULL,1,0,2,'2019-07-23 20:44:40',NULL,NULL),(17,'2019.07.27',NULL,'Ez most így nem gömbölyű!\r\nIgyekszem összeírni, milyen problémákat érzékelek, nem fontossági sorrendben:\r\n\r\n   - php 7.1.17 ami megfelelő, de amikor megbeszéltük 7.1.25.-ről volt szó (2019.05.28. email)\r\n   - kérdés, ahányszor telepítés van mindig más lesz az eredmény (minimum a design vagy db), ez hogy?\r\n   - nincs file kezelő mc\r\n   - nincs db elérés, csak konzolos\r\n   - A mostaniban (http://moodle-dev.uni-corvinus.hu) van .htaccess tartalma, visszanéztem az előzőeknek egyiknek sem volt.\r\n    deny from all\r\n    AllowOverride None\r\n    Note: this file is broken intentionally, we do not want anybody to undo it in subdirectory!\r\n    - moodle3test.uni-corvinus.hu akkor felejtős, arra nem kerúl újabb környezet?\r\n    - hol lehet az upgrade-t megkísérelni, na meg persze így hogyan?\r\n\r\nEz így hogy működjön, mi az elképzelés, én kifogytam?\r\n\r\nRészemről az utolsó elképzelés\\ötlet az lehet, ha egy notebook/linux (ubuntu/linuxmint)-ra felraknátok azt a verziót amellyel ténylegesen kell foglalkozni.\r\nBalu, Robi segítségével egy röpke ellenőrzést tennénk, hogy legalább látszatra alapjaiban megfelel-e?\r\n\r\nEgyéb ötlet?\r\nAmennyire lehet nyitott vagyok, de a jelenlegi metodika használhatatlan.',NULL,NULL,1,0,2,'2019-07-29 03:18:12',NULL,NULL),(18,'2019.07.28',NULL,'Fapadosan beraktam magam felhasználónak, beírtam a confog.php-ba az id-t.\r\nEz válasz rá (http://moodle-dev.uni-corvinus.hu):\r\nException - Class \'soapclient\' not found\r\nDebug info: \r\nError code: generalexceptionmessage\r\nStack trace:\r\n\r\n    line 249 of /local/hok/locallib.php: Error thrown\r\n    line 119 of /local/hok/locallib.php: call to kim_com->setup()\r\n    line 27 of /blocks/hok/block_hok.php: call to get_user_faculty()\r\n    line 288 of /blocks/moodleblock.class.php: call to block_hok->get_content()\r\n    line 230 of /blocks/moodleblock.class.php: call to block_base->formatted_contents()\r\n    line 1197 of /lib/blocklib.php: call to block_base->get_content_for_output()\r\n    line 1249 of /lib/blocklib.php: call to block_manager->create_block_contents()\r\n    line 374 of /lib/blocklib.php: call to block_manager->ensure_content_created()\r\n    line 41 of /theme/adaptable/layout/includes/header.php: call to block_manager->region_has_content()\r\n    line 27 of /theme/adaptable/layout/frontpage.php: call to require_once()\r\n    line 1162 of /lib/outputrenderers.php: call to include()\r\n    line 1092 of /lib/outputrenderers.php: call to core_renderer->render_page_layout()\r\n    line 114 of /index.php: call to core_renderer->header()',NULL,NULL,1,0,2,'2019-07-29 03:19:48',NULL,NULL),(19,'2017.07.28',NULL,'Ezzel egy kis gond van, mármint php.ini-vel:\r\n\r\n    nem ott ahol a test server-en, mindkettő solaris, akkor, hogy?\r\n    nagy nehezen megtaláltam /etc/php/7.1/php.ini\r\n    extension=php_soap.dll kivettem elöle a \';\' comment jelzést\r\n    solaris-on nem tudom hogyan kell újraindítani a server-t\r\n    linux lenne nem okozna gondot\r\n    nem szeretném a fiúk elöl elvenni a lehetőséget\r\n    legalább a meglevő működő rendszer felélesztését csinálják meg rendesen\r\n\r\nValamennyire jó hír nálam felélesztve ezt (local), le tudtam futtatni rajta az upgrade-t.\r\n2 probléma azért adódott:\r\n1 - a design elszállt,\r\n2 - bejelentkezés elszállt.',NULL,NULL,1,0,2,'2019-07-29 03:20:48',NULL,NULL),(20,'2019.07.31',NULL,'- .htaccaes kiürítés',NULL,NULL,1,0,2,'2019-07-31 14:33:24',NULL,NULL),(21,'2019.07.31',NULL,'- .htaccaes kiürítés\r\n- portálkezelés > nyelv > nyelvi csomagok > magyar',NULL,NULL,1,0,2,'2019-07-31 14:38:18',NULL,NULL),(22,'2019.07.31',NULL,'- .htaccaes kiürítés\r\n- portálkezelés > nyelv > nyelvi csomagok > magyar\r\n- portálkezelés > Szerver > Környezet',NULL,NULL,1,0,2,'2019-07-31 14:40:55',NULL,NULL),(23,'2019.07.31',NULL,'- .htaccaes kiürítés\r\n- portálkezelés > nyelv > nyelvi csomagok > magyar\r\n- portálkezelés > Szerver > Környezet\r\n- plugin frissítés\r\n    /mod/attandace\r\n    /mod/checklist\r\n    /mod/hvp\r\n    /mod/mindmap\r\n    /mod/oublog\r\n    /mod/questionnaire',NULL,NULL,1,0,2,'2019-07-31 14:58:29',NULL,NULL),(24,'2019.07.31',NULL,'- .htaccaes kiürítés\r\n- portálkezelés > nyelv > nyelvi csomagok > magyar\r\n- portálkezelés > Szerver > Környezet\r\n- plugin frissítés\r\n    /mod/attandace\r\n    /mod/checklist\r\n    /mod/hvp\r\n    /mod/mindmap\r\n    /mod/oublog\r\n    /mod/questionnaire\r\n    /mod/subcourse',NULL,NULL,1,0,2,'2019-07-31 14:59:08',NULL,NULL),(25,'2019.07.31',NULL,'- .htaccaes kiürítés\r\n- portálkezelés > nyelv > nyelvi csomagok > magyar\r\n- portálkezelés > Szerver > Környezet\r\n- plugin frissítés\r\n    /mod/attandace\r\n    /mod/checklist\r\n    /mod/hvp\r\n    /mod/mindmap\r\n    /mod/oublog\r\n    /mod/questionnaire\r\n    /mod/subcourse\r\n    /blocks/course_overview\r\n    /blocks/custom_course_menu',NULL,NULL,1,0,2,'2019-07-31 15:00:45',NULL,NULL),(26,'2019.07.31',NULL,'- .htaccaes kiürítés\r\n- portálkezelés > nyelv > nyelvi csomagok > magyar\r\n- portálkezelés > Szerver > Környezet\r\n- plugin frissítés\r\n    /mod/attandace\r\n    /mod/checklist\r\n    /mod/hvp\r\n    /mod/mindmap\r\n    /mod/oublog\r\n    /mod/questionnaire\r\n    /mod/subcourse\r\n    /blocks/course_overview\r\n    /lib/editor/atto/plugins/fullscreen\r\n\r\n    /blocks/custom_course_menu',NULL,NULL,1,0,2,'2019-07-31 15:01:17',NULL,NULL),(27,'2019.07.31',NULL,'- .htaccaes kiürítés\r\n- portálkezelés > nyelv > nyelvi csomagok > magyar\r\n- portálkezelés > Szerver > Környezet\r\n- plugin frissítés\r\n    /mod/attandace\r\n    /mod/checklist\r\n    /mod/hvp\r\n    /mod/mindmap\r\n    /mod/oublog\r\n    /mod/questionnaire\r\n    /mod/subcourse\r\n    /blocks/course_overview\r\n    /lib/editor/atto/plugins/fullscreen\r\n    /blocks/custom_course_menu\r\n    coursearchiver',NULL,NULL,1,0,2,'2019-07-31 15:02:02',NULL,NULL),(28,'2019.07.31',NULL,'- .htaccaes kiürítés\r\n- portálkezelés > nyelv > nyelvi csomagok > magyar\r\n- portálkezelés > Szerver > Környezet\r\n- plugin frissítés\r\n    /mod/attandace\r\n    /mod/checklist\r\n    /mod/hvp\r\n    /mod/mindmap\r\n    /mod/oublog\r\n    /mod/questionnaire\r\n    /mod/subcourse\r\n    /blocks/course_overview\r\n    /lib/editor/atto/plugins/fullscreen\r\n    /blocks/custom_course_menu\r\n    coursearchiver\r\n    /theme/adaptable',NULL,NULL,1,0,2,'2019-07-31 15:02:38',NULL,NULL),(29,'2019.07.31',NULL,'- .htaccaes kiürítés\r\n- portálkezelés > nyelv > nyelvi csomagok > magyar\r\n- portálkezelés > Szerver > Környezet\r\n- plugin frissítés\r\n    /mod/attandace\r\n    /mod/checklist\r\n    /mod/hvp\r\n    /mod/mindmap\r\n    /mod/oublog\r\n    /mod/questionnaire\r\n    /mod/subcourse\r\n    /blocks/course_overview\r\n    /lib/editor/atto/plugins/fullscreen\r\n    /blocks/custom_course_menu\r\n    coursearchiver\r\n    /theme/adaptable\r\n    klass',NULL,NULL,1,0,2,'2019-07-31 15:03:12',NULL,NULL),(30,'2019.07.31',NULL,'- .htaccaes kiürítés\r\n- portálkezelés > nyelv > nyelvi csomagok > magyar\r\n- portálkezelés > Szerver > Környezet\r\n- plugin törölhetők törlése\r\n- plugin > Elérhető frissítések ellenőrzése Debug info: cURL error 7: Failed to connect to download.moodle.org port 443: Timed out \r\n',NULL,NULL,1,0,2,'2019-07-31 15:04:25',NULL,NULL),(31,'2019.08.04',NULL,'plugin törlés:\r\nupload contacfield_opload',NULL,NULL,1,0,2,'2019-08-04 14:34:12',NULL,NULL),(32,'2019.08.04',NULL,'plugin törlés:\r\nupload contacfield_opload,\r\ntextarea contactfield_textarea',NULL,NULL,1,0,2,'2019-08-04 14:35:40',NULL,NULL),(33,'2019.08.04',NULL,'plugin törlés:\r\nupload contacfield_opload,\r\ntextarea contactfield_textarea,\r\ntext contactfield_text,',NULL,NULL,1,0,2,'2019-08-04 14:36:57',NULL,NULL),(34,'2019.08.04',NULL,'plugin törlés:\r\nupload contacfield_opload,\r\ntextarea contactfield_textarea,\r\ntext contactfield_text,\r\nmenu contactfield_menu,',NULL,NULL,1,0,2,'2019-08-04 14:38:14',NULL,NULL),(35,'2019.08.04',NULL,'plugin törlés:\r\nupload contacfield_opload,\r\ntextarea contactfield_textarea,\r\ntext contactfield_text,\r\nmenu contactfield_menu,\r\nlabel contactfield_label,',NULL,NULL,1,0,2,'2019-08-04 14:39:34',NULL,NULL),(36,'2019.08.04',NULL,'http://moodle-dev.uni-corvinus.hu/bce_eles\r\nplugin törlés:\r\nupload contacfield_opload,\r\ntextarea contactfield_textarea,\r\ntext contactfield_text,\r\nmenu contactfield_menu,\r\nlabel contactfield_label,',NULL,NULL,1,0,2,'2019-08-04 14:40:50',NULL,NULL),(37,'2019.08.04',NULL,'http://moodle-dev.uni-corvinus.hu/bce_eles\r\nplugin törlés:\r\nupload contacfield_opload,\r\ntextarea contactfield_textarea,\r\ntext contactfield_text,\r\nmenu contactfield_menu,\r\nlabel contactfield_label,\r\ndatetime contactfield_datetime,',NULL,NULL,1,0,2,'2019-08-04 14:41:15',NULL,NULL),(38,'2019.08.04',NULL,'http://moodle-dev.uni-corvinus.hu/bce_eles\r\nplugin törlés:\r\nupload contacfield_opload,\r\ntextarea contactfield_textarea,\r\ntext contactfield_text,\r\nmenu contactfield_menu,\r\nlabel contactfield_label,\r\ndatetime contactfield_datetime,\r\ncheckbox contactfield_checkbox,\r\nblocks/course_overview\r\nUpdate Moodle database now\r\n\r\nSystem\r\n\r\nTable \"message_conversations\" does not exist\r\n\r\nMore information about this error\r\nDebug info:\r\nError code: ddltablenotexist\r\nStack trace:\r\n\r\n    line 146 of /lib/ddl/database_manager.php: ddl_table_missing_exception thrown\r\n    line 2125 of /lib/db/upgrade.php: call to database_manager->field_exists()\r\n    line 1809 of /lib/upgradelib.php: call to xmldb_main_upgrade()\r\n    line 518 of /admin/index.php: call to upgrade_core()\r\n\r\nezzel leáll.',NULL,NULL,1,0,2,'2019-08-04 14:42:44',NULL,NULL),(39,'2019.08.04',NULL,'http://moodle-dev.uni-corvinus.hu/bce_eles\r\nplugin törlés:\r\nupload contacfield_opload,\r\ntextarea contactfield_textarea,\r\ntext contactfield_text,\r\nmenu contactfield_menu,\r\nlabel contactfield_label,\r\ndatetime contactfield_datetime,\r\ncheckbox contactfield_checkbox,\r\ncontact local_contact,\r\nopensso auth_opensso,\r\nserver_clock block_server_clock,\r\nmycourses block_mycourses,\r\nmsdnaa block_msdnaa, (504 Gateway Time-out) 4x visszajött,\r\nloancalc block_loancalc,\r\njelenlegi másolása bce_eles_20190804-be\r\nconfig.php, .htaccess meghagyása a bce_eles-ben\r\nmoodle 3.7.1+ másolás bce_eles-be\r\nindulás 3.7.1+ forrással\r\nauth/cusman másolás,\r\nupgrade indítás,\r\nphp_seeting opcache.enable (solarison gond, Beni),\r\nconfig.php ini_set(\'max_execution_time\', 0);,\r\nmod/activequiz másolás,\r\nmod/attendance másolás,\r\nmod/checklist másolás,\r\nmod/hvp másolás,\r\nmod/mindmap másolás,\r\nmod/oublog másolás,\r\nmod/questionnaire másolás,\r\nmod/subcourse másolás,\r\nmod/tquestionnaire másolás,\r\nblocks/chelpdesk,\r\nblocks/custom_course_menu,\r\nblocks/election,\r\nblocks/hok,\r\nblocks/message_board,\r\nblocks/semester,\r\nblocks_simple_clock,\r\nblocks/user_bookmarks,\r\nquestion/type/im,\r\nquestion/type/mrp,\r\nquestion/type/tlb,\r\nfilter/multilang2,\r\nenrol/kim,\r\nadmin/tool/coursearchiver,\r\nreport/customreport,\r\nplagiarism/urkund,\r\ntheme\\adaptable,\r\ntheme\\bootstrapbase,\r\nlocal\\..,\r\n_egyeba,\r\n_karbantartas,\r\n\r\n',NULL,NULL,1,0,2,'2019-08-04 14:42:53',NULL,NULL),(40,'2019.08.05',NULL,'eredeti 3.3.1 visszapakolás\r\nplugin törlés:\r\nklass theme_klass,\r\nbce theme_bce,\r\nbce1 theme_bce1,\r\neredmény ugyanaz \'message_converstiom\' probléma',NULL,NULL,1,0,2,'2019-08-05 04:25:34',NULL,NULL),(41,'2019.08.30',NULL,'felhasználói hely kvóta','http://moodle.uni-corvinus.hu/admin/settings.php?section=sitepolicies',NULL,1,0,2,'2019-08-30 08:20:32',NULL,NULL),(42,'2019.09.17.',NULL,'10:15 körül meeting sóház\r\nSikerült megoldani Beni-vel:\r\n- kiegészítő rendszer működik (https://moodle-dev.uni-corvinus.hu/corvinus)\r\n- gépen megoldani (ubuntu linux) a működéstét a rendszernek, csak az egyiket (3.7.1+), a réginek úgy néz kis sok a php verzió 7.2.19 van.\r\n- db-t be kell tőlteni ami van sajnos kiderült nem megfelelő',NULL,NULL,1,0,2,'2019-09-17 19:42:04',NULL,NULL),(43,'2019.09.18.',NULL,'Login képernyő leválasztását, értesítő dobozzal.\r\nLeválasztás megvan, az értesitő dobozban nem jelenik meg az infó.\r\nhttp://moodle.uni-corvinus.hu/blocks/message_board/list_messages.php\r\nHáttérben megy még a bce_restore db (legutolsó éles) betöltés.',NULL,NULL,1,0,2,'2019-09-18 19:48:40',NULL,NULL),(44,'2019.09.19.',NULL,'db betöltés lement, a rendszer elindul (Ubuntu Linux).\r\nLogin-hoz igazítás a régi rendszer mintájára:\r\n - adaptable\\config.php Login page columns1.php -> login.php\r\n - adaptable\\layout\\includes\\login_header.php régiből bemásolás\r\n - adaptable\\login.php 27 sor \"require_once(dirname(__FILE__) . \'/includes/login_header.php\');\" átírása.\r\nEz a megoldás sem működik.\r\nAnnyira nem, hogy a data könyvtárat törölni kellett és visszamásolni a kiindulót.\r\n\r\n',NULL,NULL,1,0,2,'2019-09-19 19:59:07',NULL,NULL),(46,'2019.09.20.',NULL,'Ubuntu VPN beállítás, Beni által adott info\\tipp alapján is:\r\nsudo add-apt-repository ppa:eivnaes/network-manager-sstp\r\nsudo apt-get update\r\nsudo apt-get install network-manager-sstp  sstp-client\r\nnem sikerült, az eap\\peap típusú kapcsolódást nem kiválasztható, ami kellene.\r\nJövő héten keressem meg, segít majd (Beni).\r\nJelenleg megy a rendszer Ubuntu-n, valamit csinálok, az átmegy windows-ra, onnan tudom elérni vpn révén a dolgokat. Visszafele ugyanez csak ellenkező irányban.\r\nLegutóbbi tevékenység után, nálam Ubuntu-n továbbra is működik, a dev-en nem.\r\nA fentiek miatt nem tudom igazán összehasonlitani a két rendszert, nálam miért működik, dev-n miért nem.',NULL,NULL,1,0,2,'2019-09-20 19:30:22',NULL,NULL),(47,'2019.09.23.',NULL,'bce_eles most használhatatlan.\r\nA kurzus moduljait módosítgatom (Ubuntu local) sql hiba, nyitás.\r\ncourse\r\nblocks\\course*\r\n\r\nbce_eles:\r\nInvalid cache store in config. Not an available plugin.\r\n\r\n    line 190 of /cache/classes/config.php: call to debugging()\r\n    line 400 of /cache/classes/factory.php: call to cache_config->load()\r\n    line 431 of /cache/classes/factory.php: call to cache_factory->create_config_instance()\r\n    line 200 of /cache/classes/factory.php: call to cache_factory->create_definition()\r\n    line 182 of /cache/classes/loaders.php: call to cache_factory->create_cache_from_definition()\r\n    line 343 of /lib/dml/moodle_database.php: call to cache::make()\r\n    line 714 of /lib/dml/mysqli_native_moodle_database.php: call to moodle_database->get_metacache()\r\n    line 662 of /lib/dml/moodle_database.php: call to mysqli_native_moodle_database->get_columns()\r\n    line 1603 of /lib/dml/moodle_database.php: call to moodle_database->where_clause()\r\n    line 1485 of /lib/moodlelib.php: call to moodle_database->get_field()\r\n    line 814 of /lib/setuplib.php: call to get_config()\r\n    line 648 of /lib/setup.php: call to initialise_cfg()\r\n    line 74 of /config.php: call to require_once()\r\n    line 26 of /admin/purgecaches.php: call to require_once()\r\n\r\nA cache mode mapping exists for a mode or store that does not exist.\r\n\r\n    line 269 of /cache/classes/config.php: call to debugging()\r\n    line 400 of /cache/classes/factory.php: call to cache_config->load()\r\n    line 431 of /cache/classes/factory.php: call to cache_factory->create_config_instance()\r\n    line 200 of /cache/classes/factory.php: call to cache_factory->create_definition()\r\n    line 182 of /cache/classes/loaders.php: call to cache_factory->create_cache_from_definition()\r\n    line 343 of /lib/dml/moodle_database.php: call to cache::make()\r\n    line 714 of /lib/dml/mysqli_native_moodle_database.php: call to moodle_database->get_metacache()\r\n    line 662 of /lib/dml/moodle_database.php: call to mysqli_native_moodle_database->get_columns()\r\n    line 1603 of /lib/dml/moodle_database.php: call to moodle_database->where_clause()\r\n    line 1485 of /lib/moodlelib.php: call to moodle_database->get_field()\r\n    line 814 of /lib/setuplib.php: call to get_config()\r\n    line 648 of /lib/setup.php: call to initialise_cfg()\r\n    line 74 of /config.php: call to require_once()\r\n    line 26 of /admin/purgecaches.php: call to require_once()\r\n\r\nSkip to main content\r\nThis page should automatically redirect. If nothing is happening please use the continue link below.\r\n(Continue)\r\n\r\nError output, so disabling automatic redirect.',NULL,NULL,1,0,2,'2019-09-23 20:32:14',NULL,NULL),(48,'2019.09.24.',NULL,'Megkíséreltem VPN-t beállítani, a Beni-től kapott új infokkal (Ubuntu local):\r\n/etc/NetworkManager/system-connections\r\nrefuse-eap=yes  ezt kéne kiszedni\r\nEzeket sajnos nem találtam, de kerestem én is infót, részben siker eap már van.\r\nKapcsolat sajnons még nem.\r\n\r\nMegjegyzendő, bármi bemásolás történik az alábbiakat kell kiadni a theme értelem szerün amit másolt arra.\r\nchmod -R 0777 theme\r\nchown -R moodle:staff theme\r\n\r\nAz éles ismét rakoncátlankodik:\r\n/theme/adaptable, /theme/bootstrap Higher version already installed! amit nem értek, miért baj, ha frissebb?',NULL,NULL,1,0,2,'2019-09-24 21:37:27',NULL,NULL),(49,'2019.09.25',NULL,'504 Gateway Time-ot (nginx)\r\nBeni:\r\nsvcadm disable php-fpm\r\nsvcadm enable php-fpm\r\nPéter:\r\nböngésző cache és egyebek törlés\r\nSándor:\r\nhttps://www.howtogeek.com/137681/how-to-automatically-clear-private-data-when-you-close-your-browser/\r\nfirefox, opera, chrome böngésző bezáráskor cache, cookie, Form & Search History törlés beállítás.\r\n\r\nVPN\r\nMS-CHAPv2\r\nBeni:\r\nhttps://torguard.net/knowledgebase.php?action=displayarticle&id=144\r\nSándor:\r\nhttps://thesafety.us/vpn-setup-ikev2-ubuntu17\r\nhttp://jhead.hu/index.php/home/blog/ubuntu/85-vpn-beallitasa-ubuntu-18-operacios-rendszeren\r\nhttps://necromuralist.github.io/posts/openvpn-on-ubuntu-1804/\r\nhttps://homepage.np-tokumei.net/post/notes-add-openvpn-and-sstp-vpn-connections-to-networkmanager-in-ubuntu-18.04-using-cli/\r\nSajnos nem működik.\r\n\r\nKurzus:\r\nView sql probléma, nincs sql hiba elszállás, hanem üzenet: \'Hiba az adatbázis olvasása közben\'.\r\n',NULL,NULL,1,0,2,'2019-09-26 06:54:01',NULL,NULL),(50,'2019.09.30.',NULL,'Beni-nek sem sikerült még VPN-t beállítani a gépen (Ubuntu 18.04 AnyDesk-en keresztül).\r\nVáltoztatások sajno felpakoláshoz elengedhetetlen.\r\nLeszedtem a legfrissebb adaptable-t és moodle 3.7.2+ -t.\r\nMásik irányból megközelítve alap rendszer telepítés, majd plugin-ok telepítése melyeket használ rendszer, így lehet kevesebb probléma adódik.',NULL,NULL,1,0,2,'2019-09-30 20:02:08',NULL,NULL),(51,'2019.09.30.',NULL,'homolya.k@uni-corvinus.hu felhasználóval igyeksze a félév választót endbehozin local-on.\r\nSajnos a dev bce_test sem megy nekem, szokásos 504 Gateway Time-out (nginx) jön.\r\nA dev bce_eles az adaptabla és bootstrap 3 miatt nem megy, \'Ennél újabb verzó van már telepítve\', ezt hogy, nem a legújabb a legjobb?\r\nVPN beállítással jelenleg Beni nem tud mit kezdeni.\r\nA gond az, hogy Ubuntu-n tudom használni a rendszert, Windows-on nem tudtama a 3.7.1+ feléleszteni.\r\nMindenképp kellene az Ubuntu-n a VPN, amíg nincs addig nagyon körülményes.\r\nleszedés: dev->win->pen->ubuntu\r\nfelpakolás: ubuntu->pen->win->dev\r\nez egyszerűnek tűnik, de az ubuntu nagyon lassan kezeli a pen-ről a tömörített file-okat.\r\n\r\nköszönöm a jelzést. Nagyon szeretném, hogy ha lennének legalább részeredmények. Azt beszéltük, hogy a félév választó funkcióra fókuszálsz. Kérlek, ezzel kapcsolatosan jelezz vissza. Kezdek nehéz helyzetbe kerülni a frissítés elmaradása kapcsán.',NULL,NULL,1,0,2,'2019-10-01 11:01:19',NULL,NULL),(52,'2019.10.01.',NULL,'Csak Ubuntu ocál-on tudok tevélkenykedmi, félévváltás.\r\nbce_test, bce_eles mindkettő 504 Gateway Time-out (nginx) ad, mindegy meiyik böngésző.\r\nchmod,chonwn rendben és mégsem jó.\r\nVPN  sincs meg.',NULL,NULL,1,0,2,'2019-10-01 20:27:29',NULL,NULL),(53,'2019.10.02.',NULL,'dev:\r\nBeni- felhívtam, VPN-re továbbra sincs megoldás, az 504-re részmegoldás amit írt 2019.10.13.kor.\r\nlocal:\r\ndmlreadexception hiba, az alábbi tippeket találtam, amiket beleírtam\r\nmy.in/my.cnf be:\r\nmax_allowed_packet=500M\r\nbinlog_format = mixed\r\nshow_compatibility_56=ON ??\r\nde nem oldotta meg.\r\nféléváltás-t nézném a bce_test-en, hogy tudjam, hogyan kellene működni, de a test nekem nem akar működni.\r\n\'felhasználók listázása\', pörög de nem jön be, így még odáig sem jutok el, hogy belépés mint.',NULL,NULL,1,0,2,'2019-10-03 09:01:58',NULL,NULL),(54,'2019.10.10.',NULL,'Végre jó hír, mindkettő sikerült local-on be izzítani.\r\nFélre dobtam az eddigi \'próbálkozásokat\' Windows\\Ubuntu.\r\nWindow+VirtualBox+Vagrant hozott sikert, mindkettő a bce_test,bce_eles működik.\r\nEgy apró gond csak, a db-k betöltése a kettő db 1.5-2 nap.\r\nIT így csak a dev server-hez kell, megkíséreltem a bce_eles-en újra betölteni a db-t, de a putty a 290.-ik táblánál elszáll.\r\nÍrtam Beni-nek, megkértem töltse vissza, gondolom amikor lesz ideje megteszi.',NULL,NULL,1,0,2,'2019-10-10 08:58:18',NULL,NULL),(55,'2019.10.14.',NULL,'Megy Local+Virtualbox+Vagrant mindkét rendszer.\r\nMost az új verzióra átálított sql dump-ot próbálnám visszatölteni, de ugyanúgy nem akar menni mint a dev server-en.\r\nLocal-on test-en újra lefuttatam az update-t (legfrissebb 3.7.2+), utánna dump készítés szépen lement, elkészült, a visszatöltés nem.\r\nMegkértem ismét Beni-t (telefon) töltse vissza a dev a bce_eles db dump-ját ami nekem mindig lerobbant a 291.-ik táblánál, hogy neki működik?\r\nFélévválasztó most a régi verzión nézem, hogy kell működni, az újon igyekszen lekövetni.',NULL,NULL,1,0,2,'2019-10-14 08:34:29',NULL,NULL),(56,'2019.10.19.',NULL,'dev server:\r\nbce_restore_preupgrade.sql sem vissuatölthető putty-on keresztül.\r\n\'Network error: Software cause connection abort\' 263 táblámál.\r\n2x kíséreltem meg.',NULL,NULL,1,0,2,'2019-10-19 17:08:11',NULL,NULL),(57,'2019.10.28.',NULL,'352 \'corvinus mod\' code plusz rész áttekintése/átvitele\r\n753 \'bce mod\' code plusz rész áttekintése/átvitele\r\nindítás',NULL,NULL,1,0,2,'2019-11-03 18:14:10',NULL,NULL),(58,'2019.11.07.',NULL,'2017/2018/2 startdt: 1514811600\r\n2018/2019/2 startdt: 1546347600\r\n2019/2020/1-startdt: 1568023200',NULL,NULL,1,0,2,'2019-11-07 09:31:06',NULL,NULL),(59,'2019.11.10.','/* CORVINUS MOD */','/admin/tool/coursearchiver/cli/coursearchiver.php\r\nsor 221','/* CORVINUS MOD */\r\n// ASK FOR PERMISSION TO CONTINUE.\r\n/*if (!empty($question)) {\r\n    echo \"\\n$question  Type \'yes\' to continue: \";\r\n    $line = fgets(STDIN);\r\n    if (trim($line) != \'yes\') {\r\n        echo \"\\nSTOPPED\\n\";\r\n        exit;\r\n    }\r\n*/\r\n    echo \"\\nMoodle course archiver running ...\\n\\n\";\r\n/*}*/\r\n    /* /CORVINUS MOD */',NULL,1,0,2,'2019-11-10 18:58:31',NULL,NULL);
/*!40000 ALTER TABLE `core_diary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_groups`
--

DROP TABLE IF EXISTS `core_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `core_themesID` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_groups`
--

LOCK TABLES `core_groups` WRITE;
/*!40000 ALTER TABLE `core_groups` DISABLE KEYS */;
INSERT INTO `core_groups` VALUES (1,NULL,'Vendég',NULL,1,2,'2005-08-29 21:08:54',2,'2013-07-22 23:29:48'),(2,NULL,'Supervisor',NULL,1,1,'2005-08-29 21:08:54',2,'2011-12-26 14:56:34'),(3,NULL,'Rendszergazda',NULL,1,1,'2005-08-29 21:10:02',NULL,NULL),(4,NULL,'Kiemelt Tag',NULL,1,1,'2005-08-29 21:10:55',2,'2010-10-05 12:23:21'),(5,NULL,'Tag',NULL,1,2,'2016-10-14 20:37:36',NULL,NULL);
/*!40000 ALTER TABLE `core_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_groups_config`
--

DROP TABLE IF EXISTS `core_groups_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_groups_config` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fieldName` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `fieldValue` text COLLATE utf8_bin DEFAULT NULL,
  `autoload` int(1) unsigned DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `core_groupsID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_groups_config`
--

LOCK TABLES `core_groups_config` WRITE;
/*!40000 ALTER TABLE `core_groups_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `core_groups_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_groups_rights`
--

DROP TABLE IF EXISTS `core_groups_rights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_groups_rights` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `core_groupsID` bigint(20) unsigned NOT NULL DEFAULT 0,
  `core_configsID` bigint(20) unsigned NOT NULL DEFAULT 0,
  `allrecs` int(2) unsigned DEFAULT 0,
  `ownrecs` int(2) unsigned DEFAULT 0,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=158 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_groups_rights`
--

LOCK TABLES `core_groups_rights` WRITE;
/*!40000 ALTER TABLE `core_groups_rights` DISABLE KEYS */;
INSERT INTO `core_groups_rights` VALUES (1,2,1,31,0,1,2,'2012-03-30 15:44:44',NULL,NULL),(2,2,2,31,0,1,2,'2012-03-30 15:45:16',NULL,NULL),(3,2,3,31,0,1,2,'2012-03-30 15:46:14',NULL,NULL),(4,2,4,31,0,1,2,'2012-03-30 15:46:27',NULL,NULL),(5,2,5,15,0,1,2,'2012-03-30 15:46:42',NULL,NULL),(7,2,7,31,0,1,2,'2012-03-30 15:47:09',NULL,NULL),(9,2,10,15,0,1,2,'2012-03-30 15:48:16',NULL,NULL),(16,2,17,31,0,1,2,'2012-03-30 15:50:10',NULL,NULL),(124,2,90,31,0,1,2,'2017-04-28 10:16:35',NULL,NULL),(21,2,22,31,0,1,2,'2012-03-30 15:51:54',NULL,NULL),(22,2,23,31,0,1,2,'2012-03-30 15:52:07',NULL,NULL),(23,2,24,31,0,1,2,'2012-03-30 15:52:23',NULL,NULL),(24,2,25,31,0,1,2,'2012-03-30 15:52:36',NULL,NULL),(37,2,38,31,0,1,2,'2012-03-30 15:56:44',NULL,NULL),(84,2,72,31,0,1,2,'2013-09-05 22:10:29',NULL,NULL),(87,2,73,31,0,1,2,'2013-09-23 13:14:02',NULL,NULL),(108,6,84,8,0,1,2,'2016-10-14 20:38:37',NULL,NULL),(109,6,83,8,0,1,2,'2016-10-14 20:38:56',NULL,NULL),(110,3,1,13,0,1,2,'2016-10-16 20:58:25',NULL,NULL),(111,4,1,12,0,1,2,'2016-10-16 20:59:13',NULL,NULL),(113,5,83,31,0,1,2,'2016-10-20 21:26:15',NULL,NULL),(114,5,84,8,0,1,2,'2016-10-20 21:26:24',NULL,NULL),(115,5,1,4,0,1,2,'2016-10-20 21:26:58',NULL,NULL),(140,2,103,13,0,1,2,'2019-07-07 14:45:22',NULL,NULL),(131,2,98,8,0,1,2,'2017-04-29 21:38:30',NULL,NULL),(132,2,61,31,0,1,2,'2017-04-29 23:19:42',NULL,NULL),(136,2,99,31,0,1,2,'2019-07-07 07:45:21',NULL,NULL),(137,2,100,31,0,1,2,'2019-07-07 07:45:53',NULL,NULL),(138,2,101,13,0,1,2,'2019-07-07 07:46:09',NULL,NULL),(139,2,102,31,0,1,2,'2019-07-07 07:46:28',NULL,NULL),(146,2,104,13,0,1,2,'2019-07-11 05:09:25',NULL,NULL),(147,3,7,13,0,1,2,'2019-07-11 05:10:35',NULL,NULL),(148,3,3,8,0,1,2,'2019-07-11 05:10:52',NULL,NULL),(149,3,4,8,0,1,2,'2019-07-11 05:11:09',NULL,NULL),(150,3,38,13,0,1,2,'2019-07-11 05:11:37',NULL,NULL),(151,3,102,13,0,1,2,'2019-07-11 05:12:00',NULL,NULL),(152,3,100,13,0,1,2,'2019-07-11 05:12:14',NULL,NULL),(153,3,101,13,0,1,2,'2019-07-11 05:12:27',NULL,NULL),(154,3,103,13,0,1,2,'2019-07-11 05:12:40',NULL,NULL),(155,3,99,13,0,1,2,'2019-07-11 05:12:57',NULL,NULL),(156,3,104,13,0,1,2,'2019-07-11 05:13:11',NULL,NULL),(157,3,90,8,0,1,2,'2019-07-11 05:13:42',NULL,NULL);
/*!40000 ALTER TABLE `core_groups_rights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_import`
--

DROP TABLE IF EXISTS `core_import`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_import` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `fileName` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin DEFAULT NULL,
  `errorMessage` text COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_import`
--

LOCK TABLES `core_import` WRITE;
/*!40000 ALTER TABLE `core_import` DISABLE KEYS */;
/*!40000 ALTER TABLE `core_import` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_info`
--

DROP TABLE IF EXISTS `core_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_info` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `core_infogroupID` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `info` longtext COLLATE utf8_bin DEFAULT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) DEFAULT 1,
  `langID` int(2) unsigned NOT NULL DEFAULT 0,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_info`
--

LOCK TABLES `core_info` WRITE;
/*!40000 ALTER TABLE `core_info` DISABLE KEYS */;
INSERT INTO `core_info` VALUES (1,1,'Elérhetőségek','sandor.szabo2@uni-corvinus.hu\r\nssandor/qi2lGt\r\n\r\nmoodle3test.uni-corvinus.hu \r\nmoodle3dev.uni-corvinus.hu\r\nhttps://otrs.uni-corvinus.hu/otrs/index.pl?Action=AgentDashboard\r\nhttps://cusmanweb.uni-corvinus.hu/webapp/WEBControllerJSP.jsp\r\nhttps://vcs.uni-corvinus.hu/users/sign_in\r\n\r\nadmin/Phoenix0204!\r\n\r\nhttp://portal.office.com sandor.szabo2@uni-corvinus.hu/qi2lGt',NULL,1,0,2,'2019-07-07 15:19:15',NULL,NULL),(2,1,'felhasználói magán hely kvóta','http://moodle.uni-corvinus.hu/admin/settings.php?section=sitepolicies',NULL,1,0,2,'2019-08-30 08:21:08',NULL,NULL);
/*!40000 ALTER TABLE `core_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_infogroup`
--

DROP TABLE IF EXISTS `core_infogroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_infogroup` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_infogroup`
--

LOCK TABLES `core_infogroup` WRITE;
/*!40000 ALTER TABLE `core_infogroup` DISABLE KEYS */;
INSERT INTO `core_infogroup` VALUES (1,'moodle',NULL,1,2,'2019-07-07 15:00:22',NULL,NULL);
/*!40000 ALTER TABLE `core_infogroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_lang`
--

DROP TABLE IF EXISTS `core_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_lang` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `active` int(1) unsigned NOT NULL,
  `name` varchar(4) COLLATE utf8_bin NOT NULL,
  `pictureURL` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_lang`
--

LOCK TABLES `core_lang` WRITE;
/*!40000 ALTER TABLE `core_lang` DISABLE KEYS */;
INSERT INTO `core_lang` VALUES (1,1,'HU','images/public/button/hu.gif');
/*!40000 ALTER TABLE `core_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_language`
--

DROP TABLE IF EXISTS `core_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_language` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `systemType` enum('frontend','backend') COLLATE utf8_bin DEFAULT NULL,
  `core_configsID` bigint(20) unsigned DEFAULT NULL,
  `fieldName` varchar(100) COLLATE utf8_bin NOT NULL,
  `fieldValue` text COLLATE utf8_bin NOT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `autoload` int(1) unsigned DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=389 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_language`
--

LOCK TABLES `core_language` WRITE;
/*!40000 ALTER TABLE `core_language` DISABLE KEYS */;
INSERT INTO `core_language` VALUES (1,'frontend',10,'labelWaitDr','ORVOS:',NULL,1,1,NULL,NULL,2,'2013-09-10 15:54:47'),(9,'frontend',NULL,'templateNotFound','Template nem tal',NULL,1,1,NULL,NULL,NULL,NULL),(13,'frontend',NULL,'cssNotFound','CSS nem található',NULL,1,1,NULL,NULL,NULL,NULL),(14,'backend',10,'copyright','Copyright &copy; Corvinus',NULL,1,1,NULL,NULL,2,'2016-05-03 17:38:21'),(15,'backend',10,'loginBoxHeaderText','Bejelentkezés',NULL,0,1,NULL,NULL,2,'2013-09-11 09:05:46'),(16,'frontend',10,'loginSealNumberLabel','PECSÉTSZÁM',NULL,0,1,NULL,NULL,2,'2013-09-11 09:07:14'),(17,'backend',10,'loginNicknameLabel','Név',NULL,0,1,NULL,NULL,2,'2013-09-11 09:09:00'),(18,'backend',10,'loginPasswordLabel','Jelszó',NULL,0,1,NULL,NULL,2,'2013-09-11 09:09:18'),(19,'frontend',10,'shortSystemName','MySys Admin 1.0',NULL,1,1,NULL,NULL,2,'2016-05-03 17:37:44'),(20,'frontend',NULL,'startSelectTitle','- Kérem válasszon -',NULL,1,1,NULL,NULL,NULL,NULL),(22,'backend',NULL,'loginNicknameEmpty','Üres felhasználónév!',NULL,0,1,NULL,NULL,NULL,NULL),(23,'backend',NULL,'loginPasswordEmpty','Üres jelszó!',NULL,0,1,NULL,NULL,NULL,NULL),(24,'backend',NULL,'loginNicknameNotExist','Nincs ilyen felhasználó!',NULL,0,1,NULL,NULL,NULL,NULL),(25,'backend',NULL,'loginPasswordBad','Hibás jelszó!',NULL,0,1,NULL,NULL,NULL,NULL),(26,'frontend',NULL,'jsNotFound','js file nem található!',NULL,1,1,NULL,NULL,NULL,NULL),(29,'backend',10,'nocore_whereID','Kihez',NULL,1,1,NULL,NULL,2,'2013-11-19 20:16:02'),(30,'backend',10,'loginSubmitButtonText','Belépés',NULL,1,1,2,'2013-09-09 13:51:43',2,'2013-09-11 09:06:18'),(31,'backend',10,'nocore_statusID','Állapot',NULL,0,1,NULL,NULL,2,'2013-11-19 20:14:59'),(375,'backend',99,'core_activitymodulIDEmpty','Üres Tevékenységmodul!',NULL,NULL,1,2,'2019-07-07 15:22:14',NULL,NULL),(376,'backend',100,'core_infogroupID','Info csoport',NULL,NULL,1,2,'2019-07-07 15:22:37',NULL,NULL),(60,'backend',57,'startTimeEmpty','Üres Mettől!',NULL,0,1,NULL,NULL,NULL,NULL),(61,'backend',57,'stopTimeEmpty','Üres Meddig!',NULL,0,1,NULL,NULL,NULL,NULL),(62,'backend',10,'message','Üzenet',NULL,0,1,NULL,NULL,NULL,NULL),(63,'backend',10,'messageEmpty','Üres Üzenet!',NULL,0,1,NULL,NULL,2,'2013-11-19 20:11:09'),(65,'backend',10,'stopDate','Meddig','',0,1,NULL,NULL,2,'2013-11-19 20:24:30'),(68,'backend',55,'textValue','Szöveg','',0,1,NULL,NULL,NULL,NULL),(69,'backend',10,'advertFileNameEmpty','Üres Kép!',NULL,0,1,NULL,NULL,NULL,NULL),(70,'backend',55,'textValueEmpty','Üres Szöveg!',NULL,0,1,NULL,NULL,NULL,NULL),(73,'backend',10,'information','Információ','',0,1,NULL,NULL,2,'2013-11-19 20:36:54'),(373,'backend',102,'activityEmpty','Üres Tevékenység!',NULL,NULL,1,2,'2019-07-07 10:11:59',NULL,NULL),(374,'backend',103,'name','Termékmodul név',NULL,NULL,1,2,'2019-07-07 14:48:04',NULL,NULL),(77,'backend',53,'statusName','Állapot',NULL,0,1,NULL,NULL,NULL,NULL),(83,'backend',10,'nocore_statusIDEmpty','Üres állapot!',NULL,0,1,NULL,NULL,2,'2013-11-19 20:15:33'),(84,'backend',20,'fgcolor','Előtérszín',NULL,0,1,NULL,NULL,NULL,NULL),(85,'backend',20,'bgcolor','Háttérszín',NULL,0,1,NULL,NULL,NULL,NULL),(86,'backend',20,'path','Útvonal','',0,1,NULL,NULL,NULL,NULL),(87,'backend',17,'title','Megnevezés',NULL,0,1,NULL,NULL,NULL,NULL),(88,'backend',17,'tplName','Template',NULL,0,1,NULL,NULL,NULL,NULL),(89,'backend',17,'titleEmpty','Üres Megnevezés!',NULL,0,1,NULL,NULL,NULL,NULL),(90,'backend',3,'name','Csoport',NULL,0,1,NULL,NULL,NULL,NULL),(91,'backend',3,'actionCount','User',NULL,0,1,NULL,NULL,NULL,NULL),(92,'backend',10,'rightsCount','Jog',NULL,0,1,NULL,NULL,2,'2013-11-19 20:21:09'),(93,'backend',3,'nameEmpty','Üres Csoport',NULL,0,1,NULL,NULL,NULL,NULL),(94,'backend',10,'core_groupsID','Csoport',NULL,0,1,NULL,NULL,2,'2013-11-19 20:35:33'),(95,'backend',10,'core_groupsIDEmpty','Üres Csoport!',NULL,0,1,NULL,NULL,2,'2013-11-19 20:35:41'),(96,'backend',61,'core_supportID','Támogatás',NULL,0,1,NULL,NULL,NULL,NULL),(97,'backend',61,'downloadURL','Melléklet',NULL,0,1,NULL,NULL,NULL,NULL),(98,'backend',61,'core_supportIDEmpty','Üres támogatás!',NULL,0,1,NULL,NULL,NULL,NULL),(99,'backend',1,'core_userstitleID','Titulus',NULL,0,1,NULL,NULL,NULL,NULL),(100,'backend',1,'surname','Vezetéknév',NULL,0,1,NULL,NULL,NULL,NULL),(101,'backend',1,'forename','Keresztnév','',0,1,NULL,NULL,NULL,NULL),(102,'backend',1,'nickname','Becenév',NULL,0,1,NULL,NULL,NULL,NULL),(103,'backend',1,'password','Jelszó',NULL,0,1,NULL,NULL,NULL,NULL),(104,'backend',1,'password2','Jelszó megerősítés',NULL,0,1,NULL,NULL,NULL,NULL),(105,'backend',1,'oldpassword','Régi jelszó',NULL,0,1,NULL,NULL,NULL,NULL),(106,'backend',1,'pictureURL','Kép',NULL,0,1,NULL,NULL,NULL,NULL),(107,'backend',1,'activationWhen','Aktiválva',NULL,0,1,NULL,NULL,NULL,NULL),(108,'backend',1,'newsletter','Hirlevél',NULL,0,1,NULL,NULL,NULL,NULL),(109,'backend',1,'myData','Adataim',NULL,0,1,NULL,NULL,NULL,NULL),(110,'backend',10,'passchange','Jelszóváltás',NULL,0,1,NULL,NULL,2,'2013-10-02 10:37:49'),(111,'backend',1,'registration','Regisztráció',NULL,0,1,NULL,NULL,NULL,NULL),(112,'backend',1,'nicknameEmpty','Üres Becenév!',NULL,0,1,NULL,NULL,NULL,NULL),(113,'backend',1,'passwordEmpty','Üres Jelszó!',NULL,0,1,NULL,NULL,NULL,NULL),(114,'backend',1,'password2Empty','Üres Jelszó megerősítés!',NULL,0,1,NULL,NULL,NULL,NULL),(115,'backend',1,'passwordPassword','Hibás jelszó megerősítés!',NULL,0,1,NULL,NULL,NULL,NULL),(116,'backend',1,'passwordOldEmpty','Üres Régi jelszó!',NULL,0,1,NULL,NULL,NULL,NULL),(117,'backend',1,'surnameEmpty','Üres Vezetéknév!',NULL,0,1,NULL,NULL,NULL,NULL),(118,'backend',1,'forenameEmpty','Üres Keresznév!',NULL,0,1,NULL,NULL,NULL,NULL),(119,'backend',10,'emailEmpty','Üres Email!',NULL,0,1,NULL,NULL,2,'2013-11-19 20:01:36'),(120,'backend',10,'emailDuplicate','Már van ilyen Email!',NULL,0,1,NULL,NULL,2,'2013-11-19 20:01:56'),(121,'backend',1,'notFoundUser','Nem létező Rövidnév/Jelszó!',NULL,0,1,NULL,NULL,NULL,NULL),(122,'backend',10,'systemType','Rendszertípus',NULL,NULL,1,2,'2013-09-05 22:40:41',2,'2013-11-20 09:31:26'),(123,'backend',10,'fieldType','Típus',NULL,NULL,1,2,'2013-09-05 22:41:35',2,'2013-11-19 20:03:32'),(124,'backend',10,'fieldName','Megnevezés',NULL,NULL,1,2,'2013-09-05 22:41:59',2,'2013-11-19 20:02:54'),(125,'backend',10,'fieldValue','Érték',NULL,NULL,1,2,'2013-09-05 22:42:18',2,'2013-11-19 20:04:14'),(126,'backend',10,'autoload','Autobetöltés',NULL,NULL,1,2,'2013-09-05 22:43:07',2,'2013-11-19 19:51:40'),(127,'backend',10,'systemTypeEmpty','Üres Rendszertípus!',NULL,NULL,1,2,'2013-09-05 22:43:39',2,'2013-11-20 09:31:16'),(128,'backend',10,'fieldTypeEmpty','Üres Típus!',NULL,NULL,1,2,'2013-09-05 22:44:46',2,'2013-11-19 20:03:18'),(129,'backend',10,'fieldNameEmpty','Üres Megnevezés!',NULL,NULL,1,2,'2013-09-05 22:46:17',2,'2013-11-19 20:02:37'),(130,'backend',10,'fieldValueEmpty','Üres Érték!',NULL,NULL,1,2,'2013-09-05 22:46:41',2,'2013-11-19 20:04:03'),(131,'backend',22,'actionCount','Intézkedés',NULL,NULL,1,2,'2013-09-05 22:51:31',NULL,NULL),(132,'backend',22,'core_support_topicID','Téma',NULL,NULL,1,2,'2013-09-05 22:51:59',NULL,NULL),(133,'backend',22,'core_support_typeID','Típus',NULL,NULL,1,2,'2013-09-05 22:52:21',NULL,NULL),(134,'backend',22,'core_support_statusID','Állapot',NULL,NULL,1,2,'2013-09-05 22:52:42',NULL,NULL),(135,'backend',22,'planTime','Tervezett idő',NULL,NULL,1,2,'2013-09-05 22:53:06',NULL,NULL),(136,'backend',22,'realTime','Valós idő',NULL,NULL,1,2,'2013-09-05 22:53:26',NULL,NULL),(137,'backend',22,'comment','Megjegyzés',NULL,NULL,1,2,'2013-09-05 22:55:35',NULL,NULL),(138,'backend',22,'insertUserID','Rögzítő',NULL,NULL,1,2,'2013-09-05 22:56:01',NULL,NULL),(139,'backend',10,'nameEmpty','Üres Megnevezés!',NULL,NULL,1,2,'2013-09-05 22:56:31',2,'2013-11-19 20:50:32'),(140,'backend',22,'core_support_topicIDEmpty','Üres Téma!',NULL,NULL,1,2,'2013-09-05 22:57:05',NULL,NULL),(141,'backend',22,'core_support_statusIDEmpty','Üres Állapot!',NULL,NULL,1,2,'2013-09-05 22:57:32',NULL,NULL),(142,'backend',38,'insertName','Kitől',NULL,NULL,1,2,'2013-09-05 23:24:50',NULL,NULL),(143,'backend',38,'targetUserID','Kinek',NULL,NULL,1,2,'2013-09-05 23:25:14',2,'2013-10-07 16:06:10'),(144,'backend',38,'targetGroupID','Kiknek',NULL,NULL,1,2,'2013-09-05 23:25:44',NULL,NULL),(145,'backend',38,'subject','Tárgy',NULL,NULL,1,2,'2013-09-05 23:26:24',NULL,NULL),(146,'backend',10,'actionCount','Mennyiség',NULL,NULL,1,2,'2013-11-19 19:44:58',NULL,NULL),(147,'backend',38,'readWhen','Olvasva',NULL,NULL,1,2,'2013-09-05 23:27:12',NULL,NULL),(148,'backend',38,'copy','Válasz',NULL,NULL,1,2,'2013-09-05 23:27:37',NULL,NULL),(149,'backend',38,'answer','Válasz erre',NULL,NULL,1,2,'2013-09-05 23:27:55',NULL,NULL),(150,'backend',38,'subjectEmpty','Üres Tárgy!',NULL,NULL,1,2,'2013-09-05 23:28:23',NULL,NULL),(151,'backend',10,'viewButtonText','Megtekintés',NULL,1,1,2,'2013-09-10 12:31:44',2,'2013-09-10 12:48:34'),(152,'frontend',10,'labelWaitNurse','NŐVÉR:',NULL,1,1,2,'2013-09-10 15:54:02',2,'2013-09-19 15:08:43'),(153,'backend',10,'deleteGroup','Törlés',NULL,NULL,1,2,'2013-09-16 14:41:19',2,'2013-10-08 13:06:52'),(154,'backend',10,'topMessage','//A Honlap feltőltése folyamatban ezért 1-2 funkció még nem működik.',NULL,1,1,2,'2013-09-23 15:24:00',2,'2013-09-23 15:36:21'),(155,'backend',10,'list','List',NULL,NULL,1,2,'2013-09-23 15:48:57',NULL,NULL),(156,'backend',10,'add','Felvitel',NULL,NULL,1,2,'2013-09-23 15:49:28',2,'2016-03-04 09:05:11'),(157,'backend',10,'copy','Másolás',NULL,NULL,1,2,'2013-09-23 15:55:32',NULL,NULL),(158,'backend',10,'edit','Módosítás',NULL,NULL,1,2,'2013-09-23 15:58:07',NULL,NULL),(159,'backend',10,'view','Megtekintés',NULL,NULL,1,2,'2013-09-23 15:59:04',NULL,NULL),(160,'backend',10,'delete','Törlés',NULL,NULL,1,2,'2013-09-23 16:00:40',NULL,NULL),(161,'backend',10,'first','Első',NULL,NULL,1,2,'2013-09-23 16:02:21',2,'2013-09-23 16:04:13'),(162,'backend',10,'prev','Elöző oldal',NULL,NULL,1,2,'2013-09-23 16:05:21',NULL,NULL),(163,'backend',10,'prevItem','Elöző tétel',NULL,NULL,1,2,'2013-09-23 16:05:34',NULL,NULL),(164,'backend',10,'next','Következő oldal',NULL,NULL,1,2,'2013-09-23 16:07:58',NULL,NULL),(165,'backend',10,'nextItem','Következő tétel',NULL,NULL,1,2,'2013-09-23 16:08:12',NULL,NULL),(166,'backend',10,'last','Utolsó',NULL,NULL,1,2,'2013-09-23 16:09:14',NULL,NULL),(167,'backend',10,'layoutfull','Teljes',NULL,NULL,1,2,'2013-09-23 16:10:10',NULL,NULL),(168,'backend',10,'layoutmini','Behívó',NULL,NULL,1,2,'2013-09-23 16:10:32',NULL,NULL),(169,'backend',10,'layoutsetup','Beállítások',NULL,NULL,1,2,'2013-09-23 16:10:54',NULL,NULL),(170,'backend',10,'search','Keresés',NULL,NULL,1,2,'2013-09-23 16:12:03',NULL,NULL),(171,'backend',10,'searchOff','Összes',NULL,NULL,1,2,'2013-09-23 16:14:28',NULL,NULL),(172,'backend',10,'yes','Igen',NULL,NULL,1,2,'2013-09-23 16:15:25',NULL,NULL),(173,'backend',10,'no','Nem',NULL,NULL,1,2,'2013-09-23 16:15:37',NULL,NULL),(174,'backend',10,'save','Mentés',NULL,NULL,1,2,'2013-09-23 16:17:50',NULL,NULL),(175,'backend',10,'saveNoBack','Mentés és maradok',NULL,NULL,1,2,'2013-09-23 16:18:17',NULL,NULL),(176,'backend',10,'back','Vissza',NULL,NULL,1,2,'2013-09-23 16:18:45',NULL,NULL),(177,'backend',10,'noRecord','Nincs találat!',NULL,NULL,1,2,'2013-09-23 16:22:27',NULL,NULL),(178,'backend',10,'noRights','Nincs jogosultság!',NULL,NULL,1,2,'2013-09-23 16:23:52',NULL,NULL),(179,'backend',10,'order','Rendezettség',NULL,NULL,1,2,'2013-09-23 16:24:29',NULL,NULL),(180,'backend',10,'logout','Kijelentkezés',NULL,NULL,1,2,'2013-09-23 16:25:38',NULL,NULL),(181,'backend',10,'description','Leírás',NULL,NULL,1,2,'2013-09-23 16:26:17',NULL,NULL),(182,'backend',10,'item','Tétel',NULL,NULL,1,2,'2013-09-23 20:38:58',NULL,NULL),(183,'backend',10,'page','Oldal',NULL,NULL,1,2,'2013-09-23 20:39:58',NULL,NULL),(184,'backend',10,'myDataChange','Adataim',NULL,NULL,1,2,'2013-09-23 20:41:53',NULL,NULL),(185,'backend',10,'passwordChange','Jelszóváltás',NULL,NULL,1,2,'2013-09-23 20:42:39',NULL,NULL),(186,'backend',10,'zoomin','Kicsi',NULL,NULL,1,2,'2013-09-23 20:47:40',2,'2013-10-04 08:58:10'),(187,'backend',10,'zoomout','Nagy',NULL,NULL,1,2,'2013-09-23 20:49:22',NULL,NULL),(188,'backend',10,'zoomClose','Bezárás',NULL,NULL,1,2,'2013-09-23 20:49:42',NULL,NULL),(189,'backend',10,'itemSelect','----',NULL,NULL,1,2,'2013-09-23 21:04:30',NULL,NULL),(190,'backend',10,'insertWhen','Rögzítve',NULL,NULL,1,2,'2013-09-23 21:11:15',NULL,NULL),(191,'backend',10,'newItem','Új tétel',NULL,NULL,1,2,'2013-09-23 21:13:35',NULL,NULL),(192,'backend',10,'topLogo','//Backend',NULL,NULL,1,2,'2013-09-23 21:23:13',2,'2013-09-23 21:29:03'),(193,'backend',10,'sec','másodperc',NULL,NULL,1,2,'2013-09-23 21:24:47',2,'2013-09-23 21:43:09'),(194,'backend',10,'system','Corvinus Admin 1.0',NULL,NULL,1,2,'2013-09-23 22:23:12',2,'2016-05-03 17:33:57'),(195,'backend',55,'sequenceId','Sorrend',NULL,NULL,1,2,'2013-09-24 09:41:18',NULL,NULL),(196,'backend',10,'core_advert_advertiserID','Hírdető',NULL,NULL,1,2,'2013-09-24 12:57:12',2,'2013-11-19 19:54:57'),(197,'backend',10,'core_advert_zoneID','Zóna',NULL,NULL,1,2,'2013-09-24 12:59:14',2,'2013-11-19 19:56:22'),(198,'backend',10,'activateWhen','Mettől',NULL,NULL,1,2,'2013-09-24 12:59:45',2,'2013-11-19 19:49:55'),(199,'backend',10,'deactivateWhen','Meddig',NULL,NULL,1,2,'2013-09-24 12:59:58',2,'2013-11-19 19:50:07'),(200,'backend',10,'playMaxNum','Maximális lejátszás',NULL,NULL,1,2,'2013-09-24 13:01:06',2,'2013-11-19 20:19:24'),(201,'backend',10,'playCounter','Lejátszott',NULL,NULL,1,2,'2013-09-24 13:01:25',2,'2013-11-19 20:18:53'),(202,'backend',10,'clickMaxNum','Maximális klikkelés',NULL,NULL,1,2,'2013-09-24 13:01:49',2,'2013-11-19 19:54:01'),(203,'backend',10,'clickCounter','Klikkeltek',NULL,NULL,1,2,'2013-09-24 13:02:12',2,'2013-11-19 19:53:18'),(204,'backend',10,'priceMax','Maximálisan költhető',NULL,NULL,1,2,'2013-09-24 13:02:38',2,'2013-11-19 20:20:28'),(205,'backend',10,'priceActual','Elköltött',NULL,NULL,1,2,'2013-09-24 13:02:57',2,'2013-11-19 20:20:05'),(206,'backend',10,'address','Utca, házszám',NULL,NULL,1,2,'2013-09-24 13:59:15',2,'2013-11-19 20:34:36'),(207,'backend',13,'contactName','Kapcsolattartó',NULL,NULL,1,2,'2013-09-24 13:59:35',NULL,NULL),(208,'backend',13,'phone','Telefon',NULL,NULL,1,2,'2013-09-24 13:59:49',NULL,NULL),(209,'backend',13,'fax','Fax',NULL,NULL,1,2,'2013-09-24 14:00:01',2,'2013-09-24 14:00:10'),(210,'backend',13,'mobile','Mobil',NULL,NULL,1,2,'2013-09-24 14:00:25',NULL,NULL),(211,'backend',10,'email','Email',NULL,NULL,1,2,'2013-09-24 14:00:40',2,'2013-11-19 20:01:18'),(212,'backend',13,'website','Weboldal',NULL,NULL,1,2,'2013-09-24 14:00:55',NULL,NULL),(213,'backend',10,'nameDuplicate','Már van ilyen!',NULL,NULL,1,2,'2013-09-24 12:56:20',2,'2013-11-19 20:13:03'),(214,'backend',10,'advertFileName','Kép',NULL,NULL,1,2,'2013-09-24 14:17:35',NULL,NULL),(215,'backend',6,'textValue','Szöveges tartalom',NULL,NULL,1,2,'2013-09-24 14:18:08',NULL,NULL),(216,'backend',6,'jumpURL','Link',NULL,NULL,1,2,'2013-09-24 14:18:24',NULL,NULL),(217,'backend',6,'core_advert_groupID','Reklám csoport',NULL,NULL,1,2,'2013-09-24 14:19:29',NULL,NULL),(218,'backend',6,'core_advert_campaignID','Kampány',NULL,NULL,1,2,'2013-09-24 14:19:51',NULL,NULL),(219,'backend',6,'core_advert_sizeID','Méret',NULL,NULL,1,2,'2013-09-24 14:20:06',NULL,NULL),(220,'backend',6,'core_advert_sourceID','Forrás',NULL,NULL,1,2,'2013-09-24 14:20:22',NULL,NULL),(221,'backend',10,'sizeWidth','Szélesség',NULL,NULL,1,2,'2013-09-24 14:20:42',2,'2013-11-19 20:23:02'),(222,'backend',10,'sizeHeight','Magasság',NULL,NULL,1,2,'2013-09-24 14:20:57',2,'2013-11-19 20:22:45'),(223,'backend',6,'changeTime','Csere idő',NULL,NULL,1,2,'2013-09-24 14:21:20',2,'2013-11-05 09:22:53'),(224,'backend',10,'core_configsIDEmpty','Üres Modul!',NULL,NULL,1,2,'2013-09-24 14:28:51',2,'2013-11-19 19:57:16'),(225,'backend',2,'core_usersIDEmpty','Üres Felhasználó!',NULL,NULL,1,2,'2013-09-24 14:29:23',NULL,NULL),(226,'backend',2,'core_usersID','Felhasználó',NULL,NULL,1,2,'2013-09-24 14:29:53',2,'2013-09-24 14:30:40'),(227,'backend',10,'import','Import',NULL,1,1,2,'2013-09-30 10:48:03',NULL,NULL),(228,'backend',10,'fileNameEmpty','Üres Fájlnév!',NULL,NULL,1,2,'2013-09-30 11:03:52',2,'2013-11-20 08:46:27'),(229,'backend',83,'importOK','Adatok importja sikeres!',NULL,NULL,1,2,'2013-09-30 15:18:45',2,'2013-09-30 15:19:15'),(230,'backend',83,'importBAD','Adatok importja sikertelen!',NULL,NULL,1,2,'2013-09-30 15:58:52',NULL,NULL),(231,'backend',10,'fileName','Fájlnév',NULL,NULL,1,2,'2013-10-01 08:53:24',2,'2013-11-20 08:46:12'),(232,'backend',10,'core_configsID','Modul',NULL,NULL,1,2,'2013-10-01 08:55:02',2,'2013-11-19 19:57:02'),(233,'backend',10,'mydata','Adataim',NULL,NULL,1,2,'2013-10-02 08:36:01',2,'2013-10-02 08:38:17'),(234,'backend',1,'oldpasswordEmpty','Üres Régi jelszó!',NULL,NULL,1,2,'2013-10-02 09:45:25',NULL,NULL),(235,'backend',1,'oldpasswordBad','Hibás Régi jelszó!',NULL,NULL,1,2,'2013-10-02 10:28:58',NULL,NULL),(371,'backend',102,'actionWhenEmpty','Üres Mikor!',NULL,NULL,1,2,'2019-07-07 10:11:09',NULL,NULL),(237,'backend',10,'pdf','PDF',NULL,NULL,1,2,'2013-10-09 12:27:31',NULL,NULL),(238,'backend',10,'calendarToday','Ma',NULL,NULL,1,2,'2013-10-14 15:43:12',NULL,NULL),(372,'backend',102,'activity','Tevékenység',NULL,NULL,1,2,'2019-07-07 10:11:34',NULL,NULL),(240,'backend',75,'startWhen','Mettől',NULL,NULL,1,2,'2013-10-15 13:21:55',NULL,NULL),(241,'backend',75,'stopWhen','Meddig',NULL,NULL,1,2,'2013-10-15 13:22:44',NULL,NULL),(370,'backend',102,'actionWhen','Mikor',NULL,NULL,1,2,'2019-07-07 10:10:38',NULL,NULL),(243,'backend',10,'week','Hét',NULL,NULL,1,2,'2013-10-15 14:03:51',NULL,NULL),(245,'backend',10,'id','Azonosító',NULL,NULL,1,2,'2013-10-16 09:22:28',2,'2013-11-19 20:06:41'),(246,'backend',83,'productId','Cikkszám',NULL,NULL,1,2,'2013-11-19 20:48:14',NULL,NULL),(247,'backend',75,'title','Bejegyzés',NULL,NULL,1,2,'2013-10-16 13:09:43',2,'2013-10-16 13:13:08'),(248,'backend',10,'startDate','Mettől',NULL,NULL,1,2,'2013-10-17 08:32:02',2,'2014-02-06 08:58:36'),(249,'backend',10,'zipcode','Irányítőszám',NULL,NULL,1,2,'2013-10-21 12:07:09',2,'2013-11-19 20:25:47'),(250,'backend',10,'settlement','Település',NULL,NULL,1,2,'2013-10-21 12:07:34',2,'2013-11-19 20:22:08'),(251,'backend',53,'phone','Telefon',NULL,NULL,1,2,'2013-10-21 12:08:39',NULL,NULL),(252,'backend',10,'core_localserverIDEmpty','Üres Szerver!',NULL,NULL,1,2,'2013-11-04 20:57:08',NULL,NULL),(253,'backend',10,'min','perc',NULL,NULL,1,2,'2013-11-04 20:57:08',NULL,NULL),(254,'backend',10,'dateViewFormat','(éé-hh-nn)',NULL,NULL,1,2,'2013-11-05 08:37:40',NULL,NULL),(255,'backend',10,'piece','darab',NULL,NULL,1,2,'2013-11-05 08:40:04',NULL,NULL),(256,'backend',10,'timeViewFormat','(óó:pp:mm)',NULL,NULL,1,2,'2013-11-05 08:45:04',2,'2013-11-05 08:46:30'),(257,'backend',10,'weekly','Hét',NULL,NULL,1,2,'2013-11-06 10:36:03',2,'2014-01-27 11:45:04'),(258,'backend',10,'daily','Nap',NULL,NULL,1,2,'2013-11-06 10:36:58',2,'2014-01-27 11:44:43'),(260,'backend',53,'alwaysView','Midig látható',NULL,NULL,1,2,'2013-11-19 08:55:16',NULL,NULL),(261,'backend',10,'core_localserverID','Szerver',NULL,NULL,1,2,'2013-11-19 15:57:43',NULL,NULL),(262,'backend',10,'monthly','Hónap',NULL,NULL,1,2,'2014-01-10 10:40:23',2,'2014-01-27 11:45:43'),(263,'backend',10,'journal','Napló',NULL,NULL,1,2,'2014-01-27 11:46:03',NULL,NULL),(264,'backend',10,'journal','Napló',NULL,NULL,1,2,'2014-01-27 11:46:03',NULL,NULL),(265,'backend',75,'startDateTime','Mettől',NULL,NULL,1,2,'2014-02-06 08:55:28',NULL,NULL),(266,'backend',75,'stopDateTime','Meddig',NULL,NULL,1,2,'2014-02-06 08:55:44',NULL,NULL),(269,'backend',57,'startTimeReserve','Előjegyzés mettől',NULL,NULL,1,2,'2014-02-10 19:54:02',NULL,NULL),(270,'backend',57,'stopTimeReserve','Előjegyzés meddig',NULL,NULL,1,2,'2014-02-10 19:54:29',NULL,NULL),(271,'backend',10,'deleteReally','Valóban törlöd?',NULL,1,1,2,'2014-02-16 18:58:12',2,'2016-03-04 09:06:01'),(272,'backend',10,'day','nap',NULL,NULL,1,2,'2014-02-16 21:20:44',NULL,NULL),(278,'backend',83,'name','Termék név',NULL,NULL,1,2,'2013-11-19 20:48:14',NULL,NULL),(279,'backend',83,'descriptionPublic','Megjegyzés',NULL,NULL,1,2,'2013-11-19 20:48:14',NULL,NULL),(280,'backend',83,'descriptionPrivate','Belső megjegyzés',NULL,NULL,1,2,'2013-11-19 20:48:14',NULL,NULL),(281,'backend',83,'storageWhere','Tárhely',NULL,NULL,1,2,'2013-11-19 20:48:14',NULL,NULL),(282,'backend',83,'quantity','Mennyiség',NULL,NULL,1,2,'2013-11-19 20:48:14',NULL,NULL),(283,'backend',83,'updateWhen','Frissítve',NULL,NULL,1,2,'2013-11-19 20:48:14',NULL,NULL),(284,'backend',83,'price','Átadási ár',NULL,NULL,1,2,'2013-11-19 20:48:14',NULL,NULL),(285,'backend',83,'makeWho','Gyártmány',NULL,NULL,1,2,'2013-11-19 20:48:14',NULL,NULL),(286,'backend',83,'makeType','Típus',NULL,NULL,1,2,'2013-11-19 20:48:14',NULL,NULL),(287,'backend',83,'products_statusID','Állapot',NULL,NULL,1,2,'2013-11-19 20:48:14',NULL,NULL),(288,'backend',83,'products_statusID','Állapot',NULL,NULL,1,2,'2016-10-03 21:11:43',NULL,NULL),(289,'backend',84,'name','Megnevezés',NULL,NULL,1,2,'2016-10-03 22:59:08',NULL,NULL),(290,'backend',1,'firmName','Cég',NULL,NULL,1,2,'2016-10-04 07:06:06',NULL,NULL),(291,'backend',1,'address','Cím',NULL,NULL,1,2,'2016-10-04 07:06:24',NULL,NULL),(292,'backend',1,'contactName','Kapcsolattartó név',NULL,NULL,1,2,'2016-10-04 07:07:43',NULL,NULL),(293,'backend',1,'contactPhone','Kapcsolattartó telefon',NULL,NULL,1,2,'2016-10-04 07:08:03',NULL,NULL),(295,'backend',83,'productIdEmpty','Üres Cikkszám!',NULL,NULL,1,2,'2016-10-04 07:28:01',NULL,NULL),(296,'backend',83,'nameEmpty','Üres Megnevezés!',NULL,NULL,1,2,'2016-10-04 07:28:42',NULL,NULL),(297,'backend',83,'products_statusIDEmpty','Üres Állapot!',NULL,NULL,1,2,'2016-10-04 07:29:17',NULL,NULL),(298,'backend',1,'nameEmpty','Üres Név!',NULL,NULL,1,2,'2016-10-04 07:47:59',NULL,NULL),(299,'backend',1,'addressEmpty','Üres Cím!',NULL,NULL,1,2,'2016-10-04 07:48:18',NULL,NULL),(300,'backend',1,'contactNameEmpty','Üres Kapcsolattartó Név!',NULL,NULL,1,2,'2016-10-04 07:49:26',NULL,NULL),(301,'backend',89,'makeYearEmoty','Üres Megjelenés!',NULL,NULL,1,2,'2016-10-04 07:49:48',NULL,NULL),(304,'backend',83,'core_usersID','Cég',NULL,NULL,1,2,'2016-10-04 08:03:58',NULL,NULL),(305,'backend',83,'own','Saját',NULL,NULL,1,2,'2016-11-13 23:26:18',NULL,NULL),(310,'backend',10,'insertUserID','Rögzítő',NULL,NULL,1,2,'2017-04-16 19:45:39',NULL,NULL),(311,'backend',72,'core_configsID','Modul',NULL,NULL,1,2,'2017-04-21 08:16:23',NULL,NULL),(312,'backend',17,'name','Modul',NULL,NULL,1,2,'2017-04-21 08:44:37',NULL,NULL),(315,'backend',10,'comment','Megjegyzés',NULL,NULL,1,2,'2017-04-21 10:03:42',NULL,NULL),(316,'backend',89,'name','Cím',NULL,NULL,1,2,'2017-04-26 22:42:05',NULL,NULL),(317,'backend',89,'makeYear','Mikor',NULL,NULL,1,2,'2017-04-26 22:42:41',NULL,NULL),(318,'backend',89,'rateNumber','Pont',NULL,NULL,1,2,'2017-04-26 22:43:09',NULL,NULL),(319,'backend',89,'story','Történet',NULL,NULL,1,2,'2017-04-27 12:34:49',NULL,NULL),(320,'backend',89,'watchWhen','Megtekintve',NULL,NULL,1,2,'2017-04-27 22:38:43',NULL,NULL),(321,'backend',7,'name','Titulus',NULL,NULL,1,2,'2017-04-28 06:51:59',NULL,NULL),(322,'backend',90,'name','Megnevezés',NULL,NULL,1,2,'2017-04-28 23:27:06',NULL,NULL),(323,'backend',90,'bgcolor','Háttér',NULL,NULL,1,2,'2017-04-28 23:27:57',NULL,NULL),(324,'backend',90,'fgcolor','Előtér',NULL,NULL,1,2,'2017-04-28 23:28:10',NULL,NULL),(325,'backend',90,'path','Útvonal',NULL,NULL,1,2,'2017-04-28 23:30:06',NULL,NULL),(369,'backend',100,'infoEmpty','Üres Információ!',NULL,NULL,1,2,'2019-07-07 08:59:52',NULL,NULL),(363,'backend',101,'name','Info csoport',NULL,NULL,1,2,'2019-07-07 08:30:44',NULL,NULL),(332,'backend',89,'makeYearEmpty','Üres Megjelenés!',NULL,NULL,1,2,'2017-04-29 15:28:49',NULL,NULL),(333,'backend',89,'storyEmpty','Üres Történet!',NULL,NULL,1,2,'2017-04-29 15:29:28',NULL,NULL),(339,'backend',10,'nameDuplicate','Van mér ilyen tétel!',NULL,NULL,1,2,'2017-04-29 15:37:04',NULL,NULL),(364,'backend',100,'name','Neve',NULL,NULL,1,2,'2019-07-07 08:56:45',NULL,NULL),(365,'backend',100,'nameEmpty','Üres Név!',NULL,NULL,1,2,'2019-07-07 08:57:15',NULL,NULL),(366,'backend',99,'core_activitymodulID','Tevkenységmodul',NULL,NULL,1,2,'2019-07-07 08:58:21',NULL,NULL),(367,'backend',100,'core_infogroupIDEmpty','Üres Info csoport!',NULL,NULL,1,2,'2019-07-07 08:59:04',NULL,NULL),(368,'backend',100,'info','Információ',NULL,NULL,1,2,'2019-07-07 08:59:30',NULL,NULL),(346,'backend',96,'name','Megnevezés',NULL,NULL,1,2,'2017-04-29 19:27:33',NULL,NULL),(353,'backend',99,'pluginName','Plugin neve',NULL,NULL,1,2,'2019-07-07 08:17:25',NULL,NULL),(354,'backend',99,'pluginNameEmpty','Üres Plugin név!',NULL,NULL,1,2,'2019-07-07 08:18:10',NULL,NULL),(355,'backend',99,'componentName','Component neve',NULL,NULL,1,2,'2019-07-07 08:18:58',NULL,NULL),(356,'backend',99,'componentNameEmpty','Üres Component név!',NULL,NULL,1,2,'2019-07-07 08:19:19',NULL,NULL),(357,'backend',99,'pluginVersion','Plugin verzió',NULL,NULL,1,2,'2019-07-07 08:19:55',NULL,NULL),(358,'backend',99,'pluginVersionEmpty','Üres Plugin verzió!',NULL,NULL,1,2,'2019-07-07 08:20:23',NULL,NULL),(359,'backend',99,'availability','Elérhetőség',NULL,NULL,1,2,'2019-07-07 08:21:21',NULL,NULL),(360,'backend',99,'availabilityEmpty','Üres Elérhetőség!',NULL,NULL,1,2,'2019-07-07 08:21:44',NULL,NULL),(361,'backend',99,'activity','Tevékenység',NULL,NULL,1,2,'2019-07-07 08:22:08',NULL,NULL),(362,'backend',99,'notes','Jegyzetek',NULL,NULL,1,2,'2019-07-07 08:22:34',NULL,NULL),(377,'backend',104,'name','Plugin státusz név',NULL,NULL,1,2,'2019-07-11 05:19:19',NULL,NULL),(378,'backend',99,'core_plugin_statusID','Plugin státusz',NULL,NULL,1,2,'2019-07-11 05:28:40',NULL,NULL),(379,'backend',99,'core_plugin_statusIDEmpty','Üres Plugin státusz!',NULL,NULL,1,2,'2019-07-11 05:29:20',NULL,NULL),(380,'backend',102,'periodHour','Időtartam',NULL,NULL,1,2,'2019-07-29 05:04:40',NULL,NULL),(381,'backend',22,'name','Megnevezés',NULL,NULL,1,2,'2019-09-18 13:29:28',NULL,NULL),(382,'backend',61,'name','Megnevezés',NULL,NULL,1,2,'2019-09-18 13:29:44',NULL,NULL),(383,'backend',25,'name','Státusz név',NULL,NULL,1,2,'2019-09-18 13:30:04',NULL,NULL),(384,'backend',23,'name','Téma név',NULL,NULL,1,2,'2019-09-18 13:30:30',NULL,NULL),(385,'backend',24,'name','Típus név',NULL,NULL,1,2,'2019-09-18 13:30:53',NULL,NULL),(386,'backend',102,'what','Mit',NULL,NULL,1,2,'2019-11-10 18:12:11',NULL,NULL),(387,'backend',102,'where','Hol',NULL,NULL,1,2,'2019-11-10 18:12:58',NULL,NULL),(388,'backend',102,'position','Pozíció',NULL,NULL,1,2,'2019-11-10 18:14:20',NULL,NULL);
/*!40000 ALTER TABLE `core_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_messagewall`
--

DROP TABLE IF EXISTS `core_messagewall`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_messagewall` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `targetUserID` bigint(20) unsigned DEFAULT NULL,
  `targetGroupID` bigint(20) unsigned DEFAULT NULL,
  `subject` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `description` longtext COLLATE utf8_bin NOT NULL,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  `isReadWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_messagewall`
--

LOCK TABLES `core_messagewall` WRITE;
/*!40000 ALTER TABLE `core_messagewall` DISABLE KEYS */;
/*!40000 ALTER TABLE `core_messagewall` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_plugin`
--

DROP TABLE IF EXISTS `core_plugin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_plugin` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `core_activitymodulID` bigint(20) unsigned DEFAULT NULL,
  `pluginName` varchar(100) COLLATE utf8_bin NOT NULL,
  `componentName` varchar(100) COLLATE utf8_bin NOT NULL,
  `pluginVersion` varchar(100) COLLATE utf8_bin NOT NULL,
  `availability` varchar(100) COLLATE utf8_bin NOT NULL,
  `core_plugin_statusID` bigint(20) unsigned DEFAULT NULL,
  `linebgcolor` varchar(20) COLLATE utf8_bin DEFAULT '',
  `activity` varchar(100) COLLATE utf8_bin NOT NULL,
  `notes` longtext COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `langID` int(2) unsigned NOT NULL DEFAULT 0,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `insertWhen` (`insertWhen`),
  KEY `insertUserId` (`insertUserID`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_plugin`
--

LOCK TABLES `core_plugin` WRITE;
/*!40000 ALTER TABLE `core_plugin` DISABLE KEYS */;
INSERT INTO `core_plugin` VALUES (1,1,'Részvétel - jelenlét','mod_attendance','3.3.9 2017050226','Bekapcsolva',2,' ','Eltávolítás','Új 2017050226 verzió érhető el!\r\n3.3.15 programverzió\r\nStabil verzió\r\nLetöltés\r\nTovábbi információk...',1,0,2,'2019-07-07 08:37:21',NULL,NULL),(2,1,'Feladatlista','mod_checklist','2.7+ (Build: 2017060800) 2017110900','Bekapcsolva',1,' ','Beállítások, Eltávolítás','Új 2017110900 verzió érhető el!\r\n2.7+ (Build: 2017110900) programverzió Stabil verzió Letöltés\r\nTovábbi információk...',1,0,2,'2019-07-07 14:15:00',NULL,NULL),(3,1,'HSP','mod_hvp','1.9 2019052100','Bekapcsolva',2,' ','Eltávolítás','Új 2019052100 verzió érhető el!\r\n1.18 programverzió Stabil verzió Letöltés További információk...',1,0,2,'2019-07-07 14:18:49',NULL,NULL),(4,1,'Elmetérkép','mod_mindmap','2014060900 2019042500','Bekapcsolva',2,' ','Eltávolítás','Új 2019042500 verzió érhető el!\r\n2019042500 programverzió Stabil verzió Letöltés További információk...',1,0,2,'2019-07-07 14:19:52',NULL,NULL),(5,1,'OU-blog','mod_oublog','3.1 r1 2017061600','Bekapcsolva',2,' ','Eltávolítás','Új 2017061600 verzió érhető el!\r\n3.3 r1 programverzió Stabil verzió Letöltés További információk...',1,0,2,'2019-07-07 14:22:24',NULL,NULL),(6,1,'Kérdőív','mod_questionnaire','3.3.1 (Build - 2017051800) 2017050103','Bekapcsolva',2,' ','Eltávolítás','Új 2017050103 verzió érhető el!\r\n3.3.3 (Build - 2018013100) programverzió Stabil verzió Letöltés További információk...',1,0,2,'2019-07-07 14:23:15',NULL,NULL),(7,1,'Subcourse','mod_subcourse','5.0.0 2019020100','Kikapcsolva',1,' ','Eltávolítás','Új 2019020100 verzió érhető el!\r\n7.2.0 programverzió Stabil verzió Letöltés További információk...',1,0,2,'2019-07-07 14:24:12',NULL,NULL),(8,10,'Kurzusáttekintő (elavult)','block_course_overview','3.3.1 2018070400','Bekapcsolva',3,' ','-','Előíró: theme_adaptable\r\nÚj 2018070400 verzió érhető el!\r\n3.5.4 programverzió Stabil verzió Letöltés További információk...',1,0,2,'2019-07-07 14:27:03',NULL,NULL),(9,10,'Kurzus menü','block_custom_course_menu','1.1.1 2019020700','Bekapcsolva',2,' ','Eltávolítás','Új 2019020700 verzió érhető el!\r\n2.1.6 programverzió Stabil verzió Letöltés További információk...',1,0,2,'2019-07-07 15:36:29',NULL,NULL),(10,11,'Toggle full screen','atto_fullscreen','2015122001 2015122006','-',2,' ','Eltávolítás','Új 2015122006 verzió érhető el!\r\n2015122001 programverzió Stabil verzió Letöltés További információk...',1,0,2,'2019-07-07 15:43:28',NULL,NULL),(11,12,'Kurzus archiváló','tool_coursearchiver','2.x (Build: 2016012500) 2018121306','Bekapcsolva',2,' ','Eltávolítás','Új 2019062700 verzió érhető el!\r\n3.7.3 (Build: 2016090200) programverzió Stabil verzió Letöltés További információk...',1,0,2,'2019-07-07 15:45:50',NULL,NULL),(12,13,'URKUND plágium-ellenőrző segédprogram','plagiarism_urkund','3.3.7 2017051509','-',3,' ','-','Új 2017051509 verzió érhető el!\r\n3.3.8 programverzió Stabil verzió Letöltés További információk...',1,0,2,'2019-07-07 15:47:01',NULL,NULL),(13,14,'Adaptable','theme_adaptable','1.1.1 2018111800','-',3,' ','-','Új 2018111800 verzió érhető el!\r\n1.6.2 programverzió Stabil verzió Letöltés További információk...',1,0,2,'2019-07-07 15:50:19',NULL,NULL),(14,14,'klass','theme_klass','2018052800','Kikapcsolva',1,' bg-danger','Eltávolítás','Nincs a lemezen\r\nÚj 2018052800 verzió érhető el!\r\nv1.5.2 programverzió Stabil verzió Letöltés További információk...\r\nNincs a lemezen',1,0,2,'2019-07-07 15:50:41',NULL,NULL),(15,15,'contact','local_contact','2018052100','Kikapcsolva',1,' bg-danger','Eltávolítás','Nincs a lemezen\r\nÚj 2018052100 verzió érhető el!\r\n0.8.4 programverzió Stabil verzió Letöltés További információk...\r\nNincs a lemezen',1,0,2,'2019-07-07 15:55:18',NULL,NULL),(16,1,'Aktív teszt','mod_activequiz','3.7.1 (Build: 2017010400) 2017010400','Bekapcsolva',3,'','Beállítások, Eltávolítás',NULL,1,0,2,'2019-07-14 15:20:41',NULL,NULL),(17,1,'Questionnaire T.','mod_tquestionnaire','3.3.1 (Build - 2017051800) 2017102501','Bekapcsolva',1,'','Beállítások, Eltávolítás',NULL,1,0,2,'2019-07-14 19:47:57',NULL,NULL),(18,16,'team','assignment_team','2012040500','Kikapcsolva',1,'bg-danger','-','Nincs a lemezen',1,0,2,'2019-07-14 19:49:33',NULL,NULL),(19,10,'Corvinus Live Helpdesk','block_chelpdesk','2.2 (Build: 2012091300) 2017101901','Bekapcsolva',2,'','Beállítások, Eltávolítás',NULL,1,0,2,'2019-07-14 19:50:52',NULL,NULL),(20,10,'2.2 (Build: 2012091300) 2017101901','block_election','2017092501','Bekapcsolva',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 19:54:43',NULL,NULL),(21,10,'HOK block','block_hok','2013080702','Bekapcsolva',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 19:55:43',NULL,NULL),(22,10,'Üzenőfal blokk','block_message_board','2018072400','Kikapcsolva',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 19:56:46',NULL,NULL),(23,10,'Félév választó blokk','block_semester','2016040502','Bekapcsolva',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 19:57:54',NULL,NULL),(24,10,'Szerver / helyi idő','block_simple_clock','Version for Moodle 2.9 onwards 2015101600','Bekapcsolva',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 20:29:45',NULL,NULL),(25,10,'Felhasználói könyvjelzők','block_user_bookmarks','1.1 2014031002','Bekapcsolva',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 20:30:48',NULL,NULL),(26,10,'loancalc','block_loancalc','2007101509','Kikapcsolva',1,'bg-danger','Eltávolítás','Nincs a lemezen',1,0,2,'2019-07-14 20:32:39',NULL,NULL),(27,10,'msdnaa','block_msdnaa','2016101802','Kikapcsolva',1,'bg-danger','Eltávolítás','Nincs a lemezen',1,0,2,'2019-07-14 20:33:46',NULL,NULL),(28,10,'mycourses','block_mycourses','2012120411','Kikapcsolva',1,'bg-danger','Eltávolítás','Nincs a lemezen',1,0,2,'2019-07-14 20:34:36',NULL,NULL),(29,10,'server_clock','block_server_clock','2008150300','Kikapcsolva',1,'bg-danger','Eltávolítás','Nincs a lemezen',1,0,2,'2019-07-14 20:35:23',NULL,NULL),(30,17,'Készlet','qtype_im','2013052300','Bekapcsolva',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 20:39:40',NULL,NULL),(31,17,'MRP (Anyagszükséglet tervezése)','qtype_mrp','2013052300','Bekapcsolva',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 20:41:15',NULL,NULL),(32,17,'TLB (Termékelvű létesítmények berendezése)','qtype_tlb','2013060601','Bekapcsolva',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 20:42:08',NULL,NULL),(33,18,'Multi-Language Content (v2)','filter_multilang2','1.0 2016080700','Bekapcsolva',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 20:43:42',NULL,NULL),(34,19,'Neptun beiratkozás','enrol_kim','2012090800','Bekapcsolva',3,'','Beállítások, Eltávolítás',NULL,1,0,2,'2019-07-14 20:45:01',NULL,NULL),(35,20,'Cusman-os beléptetés','auth_cusman','2016042000','Bekapcsolva',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 20:46:16',NULL,NULL),(36,20,'opensso','auth_opensso','012082400','Kikapcsolva',1,'bg-danger','Eltávolítás','Nincs a lemezen',1,0,2,'2019-07-14 20:47:19',NULL,NULL),(37,21,'Board formátum','format_board','(Build: 2017062800) 2017062800','Bekapcsolva',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 20:55:20',NULL,NULL),(38,22,'Egyedi riport','report_customreport','2016060601','-',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 20:56:25',NULL,NULL),(39,14,'bce','theme_bce','2012082800','Kikapcsolva',1,'bg-danger','Eltávolítás','Nincs a lemezen',1,0,2,'2019-07-14 20:58:04',NULL,NULL),(40,14,'bce1','theme_bce1','2012082601','Kikapcsolva',1,'bg-danger','Eltávolítás','Nincs a lemezen',1,0,2,'2019-07-14 20:59:12',NULL,NULL),(41,15,'Letöltőközpont modul','local_downloadcenter','v3.2.0 2017111400','-',2,'','-',NULL,1,0,2,'2019-07-14 21:04:16',NULL,NULL),(42,15,'BCE általános szavazás modul','local_election','2017103102','-',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 21:06:15',NULL,NULL),(43,15,'Finlab foglalási felület','local_finlab','2014012701','-',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 21:06:56',NULL,NULL),(44,15,'BCE HÖK választás','local_hok','2017011701','-',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 21:07:50',NULL,NULL),(45,15,'Kimsync','local_kimsync','2016090901','-',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 21:08:47',NULL,NULL),(46,15,'Teszt ütemező','local_quizschedule','2017100602','-',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 21:09:28',NULL,NULL),(47,15,'Félév választó','local_semester','2016040502','-',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 21:10:12',NULL,NULL),(48,15,'Felhasználói túrák','local_usertours','3.0 (Build: 2015111606) 2016052307','-',3,'','Eltávolítás',NULL,1,0,2,'2019-07-14 21:10:52',NULL,NULL),(49,23,'checkbox','contactfield_checkbox','2016101200','-',1,'bg-danger','Eltávolítás','Nincs a lemezen',1,0,2,'2019-07-14 21:18:59',NULL,NULL),(50,23,'datetime','contactfield_datetime','2016101200','-',1,'bg-danger','Eltávolítás','Nincs a lemezen',1,0,2,'2019-07-14 21:20:12',NULL,NULL),(51,23,'label','contactfield_label','2016101500','-',1,'bg-danger','Eltávolítás','Nincs a lemezen',1,0,2,'2019-07-14 21:21:30',NULL,NULL),(52,23,'menu','contactfield_menu','2016101200','-',1,'bg-danger','Eltávolítás','Nincs a lemezen',1,0,2,'2019-07-14 21:22:08',NULL,NULL),(53,23,'text','contactfield_text','2016101200','-',1,'bg-danger','Eltávolítás','Nincs a lemezen',1,0,2,'2019-07-14 21:22:47',NULL,NULL),(54,23,'textarea','contactfield_textarea','2016101200','-',1,'bg-danger','Eltávolítás','Nincs a lemezen',1,0,2,'2019-07-14 21:23:25',NULL,NULL),(55,23,'upload','contactfield_upload','2016101500','-',1,'bg-danger','Eltávolítás','Nincs a lemezen',1,0,2,'2019-07-14 21:23:58',NULL,NULL);
/*!40000 ALTER TABLE `core_plugin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_plugin_status`
--

DROP TABLE IF EXISTS `core_plugin_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_plugin_status` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_plugin_status`
--

LOCK TABLES `core_plugin_status` WRITE;
/*!40000 ALTER TABLE `core_plugin_status` DISABLE KEYS */;
INSERT INTO `core_plugin_status` VALUES (1,'törölhető','uninstall',1,3,'2019-07-11 14:42:51',NULL,NULL),(2,'frissítendő',NULL,1,3,'2019-07-11 14:43:07',NULL,NULL),(3,'fontos','azok a pluginek, amelyek működése nélkül nem futhat az éles rendszer.',1,3,'2019-07-11 14:43:51',NULL,NULL),(4,'telepítendő',NULL,1,3,'2019-07-11 14:44:02',NULL,NULL),(5,'élesíthető',NULL,1,3,'2019-07-11 14:44:10',NULL,NULL),(6,'teszten elérhető',NULL,1,3,'2019-07-11 14:44:26',NULL,NULL);
/*!40000 ALTER TABLE `core_plugin_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_site`
--

DROP TABLE IF EXISTS `core_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_site` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_site`
--

LOCK TABLES `core_site` WRITE;
/*!40000 ALTER TABLE `core_site` DISABLE KEYS */;
/*!40000 ALTER TABLE `core_site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_support`
--

DROP TABLE IF EXISTS `core_support`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_support` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `core_configsID` bigint(20) unsigned DEFAULT NULL,
  `core_support_topicID` int(2) unsigned DEFAULT 0,
  `core_support_typeID` int(2) unsigned DEFAULT 0,
  `planTime` int(11) unsigned DEFAULT NULL,
  `realTime` int(11) unsigned DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `comment` longtext COLLATE utf8_bin DEFAULT NULL,
  `core_support_statusID` int(2) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  `isReadWhen` datetime DEFAULT NULL,
  `isReadUserID` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_support`
--

LOCK TABLES `core_support` WRITE;
/*!40000 ALTER TABLE `core_support` DISABLE KEYS */;
/*!40000 ALTER TABLE `core_support` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_support_action`
--

DROP TABLE IF EXISTS `core_support_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_support_action` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `core_supportID` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_bin DEFAULT '',
  `planTime` int(11) unsigned DEFAULT NULL,
  `realTime` int(11) unsigned DEFAULT NULL,
  `downloadURL` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  `isReadWhen` datetime DEFAULT NULL,
  `isReadUserID` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_support_action`
--

LOCK TABLES `core_support_action` WRITE;
/*!40000 ALTER TABLE `core_support_action` DISABLE KEYS */;
/*!40000 ALTER TABLE `core_support_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_support_status`
--

DROP TABLE IF EXISTS `core_support_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_support_status` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_support_status`
--

LOCK TABLES `core_support_status` WRITE;
/*!40000 ALTER TABLE `core_support_status` DISABLE KEYS */;
INSERT INTO `core_support_status` VALUES (1,'Bejelentve',NULL,1,2,'2012-03-30 15:59:55',NULL,NULL),(2,'Folyamatban',NULL,1,2,'2012-03-30 16:00:09',NULL,NULL),(3,'Továbbítva',NULL,1,2,'2012-03-30 16:00:22',NULL,NULL),(4,'Javítva',NULL,1,2,'2012-03-30 16:00:31',NULL,NULL),(5,'Javítva és értesítve',NULL,1,2,'2012-03-30 16:01:07',NULL,NULL),(6,'Lezárva',NULL,1,2,'2012-03-30 16:01:22',NULL,NULL),(7,'Tervezett',NULL,1,2,'2012-03-30 16:01:33',NULL,NULL),(8,'Törölve',NULL,1,2,'2012-03-30 16:01:42',NULL,NULL);
/*!40000 ALTER TABLE `core_support_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_support_topic`
--

DROP TABLE IF EXISTS `core_support_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_support_topic` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_support_topic`
--

LOCK TABLES `core_support_topic` WRITE;
/*!40000 ALTER TABLE `core_support_topic` DISABLE KEYS */;
INSERT INTO `core_support_topic` VALUES (1,'Hiba',NULL,1,2,'2012-03-30 15:58:36',NULL,NULL),(2,'Bővítés',NULL,1,2,'2012-03-30 15:59:12',NULL,NULL),(3,'Módosítás',NULL,1,2,'2012-03-30 15:59:24',NULL,NULL),(4,'Érdeklődés',NULL,1,2,'2013-08-02 12:39:17',NULL,NULL);
/*!40000 ALTER TABLE `core_support_topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_support_type`
--

DROP TABLE IF EXISTS `core_support_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_support_type` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_support_type`
--

LOCK TABLES `core_support_type` WRITE;
/*!40000 ALTER TABLE `core_support_type` DISABLE KEYS */;
INSERT INTO `core_support_type` VALUES (1,'Frontend',NULL,1,2,'2012-03-30 16:02:10',NULL,NULL),(2,'Backend',NULL,1,2,'2012-03-30 16:02:18',NULL,NULL);
/*!40000 ALTER TABLE `core_support_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_themes`
--

DROP TABLE IF EXISTS `core_themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_themes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `bgcolor` varchar(7) COLLATE utf8_bin DEFAULT NULL,
  `fgcolor` varchar(7) COLLATE utf8_bin DEFAULT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_themes`
--

LOCK TABLES `core_themes` WRITE;
/*!40000 ALTER TABLE `core_themes` DISABLE KEYS */;
INSERT INTO `core_themes` VALUES (1,'black','#000000','#FFFFFF',NULL,1,2,'2010-09-24 00:41:33',2,'2010-09-27 14:08:51'),(2,'white','#FFFFFF','#000000',NULL,1,2,'2010-09-24 00:41:53',2,'2010-09-27 14:16:18'),(3,'silver','#C0C0C0','#000000',NULL,1,2,'2010-09-24 00:42:20',2,'2010-09-27 14:17:10'),(4,'gray','#808080','#FFFFFF',NULL,1,2,'2010-09-24 00:55:14',2,'2010-09-27 14:18:47'),(5,'maroon','#800000','#FFFFFF',NULL,1,2,'2010-09-24 00:55:45',2,'2010-09-27 14:18:30'),(6,'purple','#800080','#FFFFFF',NULL,1,2,'2010-09-24 00:55:57',2,'2010-09-27 14:19:23'),(7,'fuchsia','#FF00FF','#FFFFFF',NULL,1,2,'2010-09-26 14:09:10',2,'2010-09-27 14:21:51'),(8,'green','#008000','#FFFFFF',NULL,1,2,'2010-09-26 14:09:41',2,'2010-09-27 14:22:20'),(9,'lime','#00FF00','#000000',NULL,1,2,'2010-09-26 14:21:39',2,'2010-09-27 14:23:00'),(10,'olive','#808000','#FFFFFF',NULL,1,2,'2010-09-26 15:20:25',2,'2010-09-27 14:23:30'),(11,'yellow','#FFFF00','#000000',NULL,1,2,'2010-09-26 22:24:13',2,'2010-09-27 14:24:10'),(12,'navy','#000080','#FFFFFF',NULL,1,2,'2010-09-26 23:22:00',2,'2010-09-27 14:24:54'),(13,'blue','#0000FF','#FFFFFF',NULL,1,2,'2010-09-27 13:12:59',2,'2010-09-27 14:25:26'),(14,'teal','#008080','#FFFFFF',NULL,1,2,'2010-09-27 14:54:08',NULL,NULL),(15,'aqua','#00FFFF','#000000',NULL,1,2,'2010-09-27 16:26:35',NULL,NULL),(16,'orange','#FFA500','#000000',NULL,1,2,'2010-09-27 17:09:27',2,'2017-04-28 11:02:18');
/*!40000 ALTER TABLE `core_themes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_users`
--

DROP TABLE IF EXISTS `core_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `core_userstitleID` bigint(20) unsigned DEFAULT NULL,
  `surname` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `forename` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `nickname` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` varchar(20) COLLATE utf8_bin NOT NULL,
  `email` varchar(40) COLLATE utf8_bin NOT NULL,
  `firmName` varchar(100) COLLATE utf8_bin NOT NULL,
  `address` varchar(100) COLLATE utf8_bin NOT NULL,
  `contactName` varchar(100) COLLATE utf8_bin NOT NULL,
  `contactPhone` varchar(100) COLLATE utf8_bin NOT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `lastLoginWhen` datetime DEFAULT NULL,
  `lastLogoutWhen` datetime DEFAULT NULL,
  `activationCode` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `regmailWhen` datetime DEFAULT NULL,
  `activationWhen` datetime DEFAULT NULL,
  `core_groupsID` bigint(20) unsigned NOT NULL DEFAULT 3,
  `pictureURL` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `newsletter` int(1) DEFAULT 0,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  `isReadWhen` datetime DEFAULT NULL,
  `isReadUserID` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nickname` (`nickname`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_users`
--

LOCK TABLES `core_users` WRITE;
/*!40000 ALTER TABLE `core_users` DISABLE KEYS */;
INSERT INTO `core_users` VALUES (1,NULL,NULL,NULL,'Guest','','','','','','',1,NULL,NULL,'2016-05-03 17:45:52',NULL,NULL,NULL,1,NULL,0,NULL,NULL,2,'2012-01-24 11:06:15','2006-03-28 23:38:24',2),(2,NULL,'Szabó','Sándor','SzSanyi','phoenix','rodnas@uw.hu','Első','Első','Első','Első',1,NULL,'2013-09-02 13:09:13','2019-07-20 19:20:00',NULL,NULL,NULL,2,NULL,0,NULL,'2005-02-19 09:00:00',2,'2013-11-04 10:14:52','2009-06-03 09:01:09',2),(3,NULL,'Balkányi','Péter','BPeter','zU348y$*#Sy7eF3Y','peter.balkanyi@uni-corvinus.hu','Corvinus','Corvinus','Corvinus','Corvinus',1,NULL,NULL,'2019-07-11 14:49:37',NULL,NULL,NULL,3,NULL,0,2,'2005-02-19 09:00:00',NULL,NULL,NULL,NULL),(4,NULL,'Li','Róbert','LRobert','LRobert','robert.li@uni-corvinus.hu','Corvinus','Corvinus','Corvinus','Corvinus',1,NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,0,2,'2005-02-19 09:00:00',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `core_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_users_config`
--

DROP TABLE IF EXISTS `core_users_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_users_config` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fieldName` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `fieldValue` text COLLATE utf8_bin DEFAULT NULL,
  `autoload` int(1) unsigned DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `core_usersID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_users_config`
--

LOCK TABLES `core_users_config` WRITE;
/*!40000 ALTER TABLE `core_users_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `core_users_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_users_rights`
--

DROP TABLE IF EXISTS `core_users_rights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_users_rights` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `core_usersID` bigint(20) unsigned DEFAULT NULL,
  `core_configsID` bigint(20) unsigned DEFAULT NULL,
  `allrecs` int(2) unsigned DEFAULT 0,
  `ownrecs` int(2) unsigned DEFAULT 0,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_users_rights`
--

LOCK TABLES `core_users_rights` WRITE;
/*!40000 ALTER TABLE `core_users_rights` DISABLE KEYS */;
/*!40000 ALTER TABLE `core_users_rights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_userslog`
--

DROP TABLE IF EXISTS `core_userslog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_userslog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `usersID` bigint(20) unsigned DEFAULT NULL,
  `modul` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `actionWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_userslog`
--

LOCK TABLES `core_userslog` WRITE;
/*!40000 ALTER TABLE `core_userslog` DISABLE KEYS */;
/*!40000 ALTER TABLE `core_userslog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_userstitle`
--

DROP TABLE IF EXISTS `core_userstitle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_userstitle` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `active` int(1) unsigned DEFAULT 1,
  `insertUserID` bigint(20) unsigned DEFAULT NULL,
  `insertWhen` datetime DEFAULT NULL,
  `modifyUserID` bigint(20) unsigned DEFAULT NULL,
  `modifyWhen` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_userstitle`
--

LOCK TABLES `core_userstitle` WRITE;
/*!40000 ALTER TABLE `core_userstitle` DISABLE KEYS */;
INSERT INTO `core_userstitle` VALUES (1,'dr',NULL,1,2,'2013-07-26 08:48:39',NULL,NULL);
/*!40000 ALTER TABLE `core_userstitle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-12  8:35:37

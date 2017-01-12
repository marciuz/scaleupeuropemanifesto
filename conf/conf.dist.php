<?php
/**
* Configuration file 
* 
* @package edfx
* @author Mario Marcello Verona <marcelloverona@gmail.com>
* @copyright 2015 Open Evidence
* @version $Id$
* @license http://www.gnu.org/licenses/gpl.html GNU Public License
*/

ini_set('default_charset','utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);


if(!defined('__DIR__')){
	define('__DIR__',dirname(__FILE__));
}

define('FRONT_DOCROOT',"/edfx");

define('FRONT_ROOT', str_replace("/conf","",realpath(__DIR__)));

define('FRONT_ERROR_LOG',FRONT_ROOT."/errors.log");
define('FRONT_ENCODING','UTF-8');
define('SESSION_NAME','startupmanifestotracker');

define('EMAIL_ADMIN','marcelloverona@gmail.com');
define('EMAIL_STAFF','marcelloverona@gmail.com');

$DEBUG_SQL=true;
$DEBUG_SQL_STRING=array();

// google analytics
// define('GOOGLE_ANALYTICS_CODE','UA-39433218-1');

define('PROJ_NAME', 'Startup Manifesto Tracker');

// DB connection
$db1['dbtype']="mysql";
$db1['host']="localhost";
$db1['port']="3306";
$db1['user']="";
$db1['passw']="";
$db1['dbname']="";
$db1['frontend']="";


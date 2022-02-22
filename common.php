<?php
/*
// administration/common.php, v 0.1 
* Common file for simpledrome administration page
* SimpleDrome main package 
* SimpleDrome is Free Software
* Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*/

defined('CHECK_PAGE_ADMIN_') or die( "You do not allowed to enter this page 1" );

//check the version of php
$phpversion = phpversion();
list( $v_upper , $v_major , $v_minor ) = explode( "." , $phpversion );

if ( ( $v_upper == 4 && $v_major < 1 ) || $v_upper < 4 ) 
{
	$_FILES = $HTTP_POST_FILES;
	$_ENV = $HTTP_ENV_VARS;
	$_GET = $HTTP_GET_VARS;
	$_POST = $HTTP_POST_VARS;
	$_COOKIE = $HTTP_COOKIE_VARS;
	$_SERVER = $HTTP_SERVER_VARS;
	$_SESSION = $HTTP_SESSION_VARS;
	$_FILES = $HTTP_POST_FILES;
}


//create the session
include_once("simple/simplesess/simplesess.php");
$mysession = new simpleSESS($simplePAGE['skrxnt']);

//create error message object
include_once("classes/errorshow.php");
$errorShow = new errorShow;

//check group id



	$groups = 0;
	$language = null;

?>
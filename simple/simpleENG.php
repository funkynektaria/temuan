<?php
/*
// simpleENG.php, v 0.1 
* Engine for simpledrome
* SimpleDrome main package 
* SimpleDrome is Free Software
* Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
*/

defined('CHECK_PAGE_') or die("You do not allowed to enter this page");

class simpleCLASS
{
	//declare variables
	//group id
	var $gid;
	
	//configuration vars
	var $simplePAGE = array();
	
	//database object
	var $database;
	
	//sessionobject
	var $mysession;
	
	//for error checking object
	var $errorShow;
	
	//the template you want to use
	var $templateUse;
	
	//tell the body.php to take some action
	var $bodyShow;
	
	//constructor
	function simpleCLASS($groups , $database , $simplePAGE, $mysession, $errorShow)
	{
		$this->gid = $groups;
		$this->simplePAGE = $simplePAGE;
		$this->database = $database;
		$this->mysession = $mysession;
		$this->errorShow = $errorShow;
		$this->bodyShow = 0;
	}
	
	//this function will return the blocks name
	function getBlocks($pos)
	{
		/*$query1 = "SELECT b.mid FROM " . $this->simplePAGE['tableprefix'] .
			"groups_no_mods AS b WHERE b.gid = " . $this->gid;
		
		$fetchdb1 = $this->database->simpleDB_queryinput($query1);
		$fetchfinal = "";
		
		//this would join the result
		if(!empty($fetchdb1))
		{
			for($i=0;$i<count($fetchdb1);$i++)
    		{
				$fetchfinal1 = $fetchfinal1 . "'" . $fetchdb1[$i][0] . "'";
    		}
		}
		else
			$fetchfinal1 = 'null';*/
		
		if(!isset($_SESSION['id']))
		{
			$query2 = "SELECT a.mod_name, a.title FROM " . 
				$this->simplePAGE['tableprefix'] . "modules as a " .
				"WHERE a.position = '$pos' " .
				"AND a.publish = '1' AND a.access = '0' ORDER BY a.order";	
		}
		else
		{
			$query2 = "SELECT a.mod_name, a.title FROM " . 
				$this->simplePAGE['tableprefix'] . "modules as a " .
				"WHERE a.position = '$pos' " .
				"AND a.publish = '1' ORDER BY a.order";
		}
					
		$fetchdb2 = $this->database->simpleDB_queryinput($query2);
		
		$simplePAGE = $this->simplePAGE;
		$database = $this->database;			
		for( $i = 0 ; $i < count( $fetchdb2 ) ; $i++ )
		{
			$title = $fetchdb2[$i][1];
			$templateName = $this->templateUse;
			include_once("modules/" . $fetchdb2[$i][0] . ".php");
			echo "<br />\n";
		}
			
	}
	
	//get the system language
	function getLanguage( $language )
	{
		//if $language isn't empty, use the user language
		if( !empty( $language ) )
		{
			
		}
		else
		{
			$query = "SELECT a.pathto FROM " . $this->simplePAGE['tableprefix'] .
				"language AS a WHERE a.publish = 1";
			$fetchdb = $this->database->simpleDB_queryinput($query);
			return $fetchdb[0][0];
		}
	}
	
	//get the system template
	function getTemplate( $template )
	{
		//if $template isn't empty, use the user template
		if( !empty( $template ) )
		{
			
		}
		else
		{
			$query = "SELECT a.pathto FROM " . $this->simplePAGE['tableprefix'] .
				"template AS a WHERE a.publish = 1";
			$fetchdb = $this->database->simpleDB_queryinput($query);
			$this->templateUse = $fetchdb[0][0];
			return $fetchdb[0][0];
		}
	}
	
	//this function is for checking the action modes
	function act( $act, $mode=0 )
	{	
		if($act=="login")
		{
				$this->login( $_POST['username'], $_POST['password'] );
		}
		elseif($act=="logout")
				$this->logout();
		else
		{
			if( $mode==1 )
			{
				$this->com_engine($act);
			}
			else
			{
				$this->bodyShow = 1;
			}
		}
	}
	
	//this function is for login use
	function login( $user , $pass )
	{
		$query = "SELECT a.* FROM " . $this->simplePAGE['tableprefix'] .
				"user AS a WHERE a.userNAME = '$user' AND a.userPASSWORD = MD5('$pass')";
		$fetchdb = $this->database->simpleDB_queryinput($query);
		if(!empty($fetchdb))
		{	
			//register sessions
			$this->mysession->SESS_register( 'id', $fetchdb[0]['userID'] );
			$this->mysession->SESS_register( 'name', $fetchdb[0]['userNAME'] );
			$this->mysession->SESS_register( 'level', $fetchdb[0]['levelID']);
		}
		else
		{
			$this->errorShow->loginerror = 1;
		}
	}
	
	//this is for logout function
	function logout()
	{
		$this->mysession->SESS_unregisterall();
		$this->mysession->SESS_destroy();
		header("Location:" . $simplePAGE['basename'] ."index.php");
	}
	
	function com_engine( $act )
	{
		$act_rep = preg_replace("/^(com_)/" , "" , $act );
		include_once( $simplePAGE['basename'] . "components/" . $act . "/" . $act_rep . ".php");
	}
	
	function getIssuedSide($id)
	{
		$query = "SELECT a.HDkategori FROM " . $this->simplePAGE['tableprefix'] .
				"user AS a WHERE a.userID = '$id'";
		$fetchdb = $this->database->simpleDB_queryinput($query);
	}
	//return error message
	/*function errorMsg( $errortype )
	{
		switch( $errortype )
		{
			case "login" :
				if($this->loginerror==1)
				{
					echo _ERROR_LOGIN;
				}
			break;
		}
	}*/
}
?>
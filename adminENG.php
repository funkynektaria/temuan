<?php

include_once("simple/simpledb/simpledb.php");
$database = new simpleDB( $simplePAGE['host'] , $simplePAGE['username'] , $simplePAGE['password'] , $simplePAGE['db'] );

class adminENG
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
	
	//tell what icon the system should show
	var $iconShow;
	
	//object to adminIcon
	var $adminIcon;
	
	function __construct( $groups, $database , $simplePAGE, $mysession, $errorShow )
	{
		$this->gid = $groups;
		$this->simplePAGE = $simplePAGE;
		$this->database = $database;
		$this->mysession = $mysession;
		$this->errorShow = $errorShow;
		$this->bodyShow = 0;
	}

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
	
	function act( $act, $mode=0 )
	{
		switch($act)
		{
			case "login":
				$this->login( htmlspecialchars($_POST['adminuser']), htmlspecialchars($_POST['adminpass']) );
			break;
			case "logout":
				$this->logout();
			break;
			case "absendatang":
				$this->absendatang( $_SESSION['id'] );
			break;
			case "absenpulang":
				$this->absenpulang( $_SESSION['id'] );
			break;
			default :
				$this->bodyShow = 1;
			//case "site":
			//	$this->iconShow = "site";
			//	if( !empty($mode))
			//	{
			/*		$this->bodyShow = 1;
				}
			break;
			default :
				if( isset($mode))
				{
					$this->com_engine($mode);
				}
				else
				{
					$this->bodyShow = 1;
				}
			break;*/
		}
	}
	
	function login( $user , $pass )
	{
		$query = "SELECT a.userID, a.userNAME, a.userREALNAME, a.groupID FROM " . $this->simplePAGE['tableprefix'] .
				"user AS a " .
				"WHERE a.userNAME = '$user' AND a.userPASSWORD = MD5('$pass')";
		//echo $query;
		$fetchdb = $this->database->simpleDB_queryinput($query);
		
		if(!empty($fetchdb))
		{	
				//register sessions
				$this->mysession->SESS_register( 'id', $fetchdb[0]['userID'] );
				$this->mysession->SESS_register( 'username', $fetchdb[0]['userNAME'] );
				$this->mysession->SESS_register( 'realname', $fetchdb[0]['userREALNAME'] );
				$this->mysession->SESS_register( 'admin', '1' );
				$this->mysession->SESS_register( 'groupid', $fetchdb[0]['groupID'] );
				$this->mysession->SESS_register( 'appname', $this->simplePAGE['skrxnt'] );
				
				$qSubdit = "SELECT a.subdit_id FROM " . $this->simplePAGE['tableprefix'] .
				"usertosubdit AS a " .
				"WHERE a.user_id = '". $fetchdb[0]['userID']."'";
				//echo $qSubdit;
				$fSubdit = $this->database->simpleDB_queryinput($qSubdit);
				
				$this->mysession->SESS_register( 'subdit_id', $fSubdit[0]['subdit_id'] );
				
				$dateTimeNow = date("Y-m-d H:i:s");
				$IP = $_SERVER['REMOTE_ADDR'];
				$queryLog = "INSERT INTO " . $this->simplePAGE['tableprefix'] . "`log` (`userID`, `logTYPE`, `logCONTENT`, `logDATETIME`) VALUES ('".$fetchdb[0]['userID']."', 'login', 'login', '".$dateTimeNow."')";
				//echo $query;
				$fetchdbLog = $this->database->simpleDB_queryinput($queryLog);
				
				$this->redirect( $this->simplePAGE['basename'] );
		}
		else
		{
			$this->errorShow->loginerror = 1;
		}
	}
	
	function logout()
	{
		$dateTimeNow = date("Y-m-d H:i:s");
		$IP = $_SERVER['REMOTE_ADDR'];
		$queryLog = "INSERT INTO " . $this->simplePAGE['tableprefix'] . "`log` (`userID`, `logTYPE`, `logCONTENT`, `logDATETIME`) VALUES ('".$_SESSION['id']."', 'logout', 'logout', '".$dateTimeNow."')";
				//echo $query;
		$fetchdbLog = $this->database->simpleDB_queryinput($queryLog);
		
		$this->mysession->SESS_unregisterall();
		
		$this->redirect( $this->simplePAGE['basename'] );
	}
	
	function logUser($mode, $userID)
	{
		$query = "INSERT INTO ".$this->simplePAGE['tableprefix']."log ( logTYPE, logCONTENT, logDATETIME, userID) " .
							"VALUES " .
							"( 'akses ".$mode."', 'user ".$userID." masuk halaman mode ".$mode."', '".date("Y-m-d H:i:s")."', '$userID' )";
		
		//echo $query;
							
		$fetchdb = $this->database->simpleDB_queryinput($query);
	}
	
	function absendatang($user_id)
	{
		$datetimenow = date("Y-m-d H:i:s");
		
		//echo $this->absendatangcheck($user_id);
		
		if(!$this->absendatangcheck($user_id))
		{
			if(!$this->absendatangtime())
			{
				header("Location: ".$this->simplePAGE['adminbasename']."index.php?act=site&mode=com_absen&amode=datangtimefalse");
			}
			else
			{
				$query = "INSERT INTO " . $this->simplePAGE['tableprefix'] . "`absen` " . 
						"(`absen_stat`, `absen_datetime`, `user_id`) " . 
						"VALUES " . 
						"('absen datang', '$datetimenow', '$user_id')";
					//echo $query;
				$fetchdb = $this->database->simpleDB_queryinput($query);
				
				$queryLog = "INSERT INTO " . $this->simplePAGE['tableprefix'] . "`log` (`userID`, `logTYPE`, `logCONTENT`, `logDATETIME`) VALUES ('".$user_id."', 'absen datang', 'absen kedatangan ".$datetimenow."', '".$datetimenow."')";
				//echo $queryLog;
				$fetchdbLog = $this->database->simpleDB_queryinput($queryLog);
				
				header("Location: ".$this->simplePAGE['adminbasename']."index.php?act=site&mode=com_absen&amode=datang");
			}
			
		}
		else
		{
			header("Location: ".$this->simplePAGE['adminbasename']."index.php?act=site&mode=com_absen&amode=datangfalse");
		}
	}
	
	function absendatangcheck($user_id)
	{
		$datenow = date("Y-m-d");
		
		$query = "SELECT * FROM absen WHERE user_id = '$user_id' AND DATE(absen_datetime) = '$datenow' AND absen_stat = 'absen datang'";
		
		//echo $query;
		
		$fetchdb = $this->database->simpleDB_queryinput($query);
		
		$countAbsen = $this->database->simpleDB_affectedrows();
		
		//echo $countAbsen;
		
		if($countAbsen >= 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function absendatangtime()
	{
		$hournow = date("Hi");
		if($hournow < $this->simplePAGE['jamdatangstart'] || $hournow > $this->simplePAGE['jamdatangend'] )
		{
			//echo "salah";
			return FALSE;
		}
		else
		{
			//echo "bener";
			return TRUE;
		}
	}
	
	function absenpulang($user_id)
	{
		if(!$this->absenpulangcheck($user_id))
		{
			if(!$this->absenpulangtime())
			{
				header("Location: ".$this->simplePAGE['adminbasename']."index.php?act=site&mode=com_absen&amode=pulangtimefalse");
			}
			else
			{
				$datetimenow = date("Y-m-d H:i:s");
				
				$query = "INSERT INTO " . $this->simplePAGE['tableprefix'] . "`absen` " . 
							"(`absen_stat`, `absen_datetime`, `user_id`) " . 
							"VALUES " . 
							"('absen pulang', '$datetimenow', '$user_id')";
						//echo $query;
				$fetchdb = $this->database->simpleDB_queryinput($query);
				
				$queryLog = "INSERT INTO " . $this->simplePAGE['tableprefix'] . "`log` (`userID`, `logTYPE`, `logCONTENT`, `logDATETIME`) VALUES ('".$user_id."', 'absen pulang', 'absen pulang ".$datetimenow."', '".$datetimenow."')";
				echo $query;
				$fetchdbLog = $this->database->simpleDB_queryinput($queryLog);
				
				header("Location: ".$this->simplePAGE['adminbasename']."index.php?act=site&mode=com_absen&amode=pulang");
			}
		}
		else
		{
			header("Location: ".$this->simplePAGE['adminbasename']."index.php?act=site&mode=com_absen&amode=pulangfalse");
		}
	}
	
	function absenpulangcheck($user_id)
	{
		$datenow = date("Y-m-d");
		
		$query = "SELECT * FROM absen WHERE user_id = '$user_id' AND DATE(absen_datetime) = '$datenow' AND absen_stat = 'absen pulang'";
		
		//echo $query;
		
		$fetchdb = $this->database->simpleDB_queryinput($query);
		
		$countAbsen = $this->database->simpleDB_affectedrows();
		
		//echo $countAbsen;
		
		if($countAbsen >= 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function absenpulangtime()
	{
		$hournow = date("Hi");
		if($hournow < $this->simplePAGE['jampulang'])
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function getPIC($user_id)
	{
		$query = "SELECT a.pic_id, b.pic_nama FROM " . 
				$this->simplePAGE['tableprefix'] . "usertopic AS a, " .
				$this->simplePAGE['tableprefix'] . "pic AS b " . 
				"WHERE a.user_id = '$user_id' AND a.pic_id = b.pic_id";
		
		//echo $query;
		
		$fetchdb = $this->database->simpleDB_queryinput($query);
		return $fetchdb;
	}
	
	function getIcon()
	{
		$act = $this->iconShow;
		switch($act)
		{
			case "site" :
				$this->adminIcon->siteIcon();
			break;
		}
	}
	
	function getIssuedSide($id)
	{
		$query = "SELECT a.HDkategori FROM " . $this->simplePAGE['tableprefix'] .
				"user AS a WHERE a.userID = '$id'";
		$fetchdb = $this->database->simpleDB_queryinput($query);
		return $fetchdb;
	}
	
	function gantiIssuedSide($ig, $userID)
	{
		if($ig == "3n")
		{
			$issuedSide = "ganjil";
		}
		elseif($ig == "2n")
		{
			$issuedSide = "genap";
		}
		else
		{
			exit();
		}
		
		$query = "UPDATE " . $this->simplePAGE['tableprefix'] .
				"user " .
				"SET HDkategori = '$issuedSide' ". 
				"WHERE userID = '$userID'";
		//echo $query;
		$fetchdb = $this->database->simpleDB_queryinput($query);
		$this->mysession->SESS_register( 'HDkategori', $issuedSide );
		return $fetchdb;

	}
	
	function redirect( $to )
	{
		header("Location: ".$to);
	}
	
	function com_engine( $mode )
	{
		$mode_rep = preg_replace("/^(com_)/" , "" , $mode );
		include_once( "components/" . $mode . "/" . $mode_rep . ".php");
	}
}
?>
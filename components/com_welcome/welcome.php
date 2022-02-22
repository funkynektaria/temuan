<?php
//echo $_SESSION['groupid'];
defined('CHECK_PAGE_ADMIN_') or die( "You do not allowed to enter this page 1" );

$setDie = 0;
//if( $_SESSION['groupid'] == 1 || $_SESSION['groupid'] == 4 ) 
//{
//	$setDie = 0;
//}


if($setDie == 1)
{
	die( "You do not allowed to enter this page" );
}


class com_welcome
{
	
	//configuration vars
	var $simplePAGE = array();
	
	//database object
	var $database;
	
	//sessionobject
	var $mysession;
	
	function __construct( $database , $simplePAGE )
	{
		$this->simplePAGE = $simplePAGE;
		$this->database = $database;
	}
	
	function getDataList( $id )
	{
		
		$query = "SELECT * FROM " . 
					$this->simplePAGE['tableprefix'] . "laporan AS a " .
					"WHERE a.user_id = '$id' " . 
					"ORDER BY a.laporan_real_datetime DESC "; 
					
					
		$fetchdb = $this->database->simpleDB_queryinput($query);
		
		//echo $query;
		if($fetchdb)
		{
			return $fetchdb;	
		}
		else
		{
			return 0;
		}
	}
	
	function getInstrumenSubName($instrumen_sub_id)
	{
		$query = "SELECT * FROM " . 
					$this->simplePAGE['tableprefix'] . "instrumen_sub AS a " .
					"WHERE a.instrumen_sub_id = '$instrumen_sub_id' "; 
					
		$fetchdb = $this->database->simpleDB_queryinput($query);
		
		//echo $query;
		return $fetchdb;
	}
	
	function getPost($post_category)
	{
		$query = "SELECT * " .
						"FROM " . $this->simplePAGE['tableprefix'] . "posts AS a " .
						"WHERE a.post_category = '$post_category'";
 						
		//echo $query;			
		$fetchdb = $this->database->simpleDB_queryinput($query);
		return $fetchdb;
	}
	
	function getDownload($category)
	{
		$query = "SELECT * " .
						"FROM " . $this->simplePAGE['tableprefix'] . "filestodownload AS a " .
						"WHERE a.ftd_category = '$category'";
 						
		//echo $query;			
		$fetchdb = $this->database->simpleDB_queryinput($query);
		return $fetchdb;
	}
	
}

$com_welcome =  new com_welcome( $database , $simplePAGE );

include_once( "components/com_welcome/welcome.html.php" ); 

$welcomeHTML = new com_welcome_html( $database, $simplePAGE );

if(isset($_GET['amode']))
{
	
}
else
{
	$welcomeHTML->showWelcomeMessage();
	
	if($_SESSION['groupid'] == 7 || $_SESSION['groupid'] == 9)
	{
		$category = "sekolah";
	}
	elseif($_SESSION['groupid'] == 8)
	{
		$category = "puskesmas";
	}
	elseif($_SESSION['groupid'] == 5  || $_SESSION['groupid'] == 6)
	{
		$category = "dinas";
	}
	elseif($_SESSION['groupid'] == 2)
	{
		$category = "monev";
	}
	else
	{
		$category = "";
	}
	
	//$downloadList = $com_welcome->getDownload($category);
	
	//$welcomeHTML->showDownload($downloadList);
	
	//$dataList = $com_welcome->getPost($category);
	
	//$welcomeHTML->showPost($dataList);

}
?>
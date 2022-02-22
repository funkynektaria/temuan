<?php
/////////////////////////////////////////////////////////////////////////////
//                                                                         //
//                    simpleDB1.0.0                                        //
//                    creator : Ramadhani                                  //
//                    Description : Mysql simple connection                //
//                    Lisence : GPL                                        //
//                                                                         //
/////////////////////////////////////////////////////////////////////////////

class simpleDB
{
    //create all variables here

    //mysql hostname
    var $simpleDB_hostname;
    //mysql username
    var $simpleDB_user;
    //mysql password
    var $simpleDB_password;
    //mysql db name
    var $simpleDB_name;
    //mysql connection indentifier
    var $simpleDB_connection;
    //mysql database connection status
    var $simpleDB_inuse;

    //this function is for constructor
    function __construct($site_simpleDBhostname,$site_simpleDBuser,$site_simpleDBpassword,$site_simpleDBname)
    {
       $this->simpleDB_hostname = $site_simpleDBhostname;
       $this->simpleDB_user = $site_simpleDBuser;
       $this->simpleDB_password = $site_simpleDBpassword;
       $this->simpleDB_name = $site_simpleDBname;
       //call the connect database function from here
       $this->simpleDB_connection = $this->simpleDB_connect($this->simpleDB_hostname,$this->simpleDB_user,$this->simpleDB_password);
       //select the database you want to use
    }

    //this function is for connecting database
    function simpleDB_connect($simpleDB_hostname,$simpleDB_user,$simpleDB_password)
    {
       $simpleDB_connection = mysqli_connect($this->simpleDB_hostname,$this->simpleDB_user,$this->simpleDB_password, $this->simpleDB_name);
       return $simpleDB_connection;
    }

    //this function is for selecting the database

    //this function is for query
    function simpleDB_queryinput($queryMsg)
    {
       $queryReport = mysqli_query($this->simpleDB_connection, $queryMsg);

       //if the query is SELECT, then continue fetching
       $searchpattern = "/^(SELECT).+/i";
       if(preg_match($searchpattern,$queryMsg))
       {

           //this will return the fetching data
           $simpleDB_datafetch = $this->simpleDB_fetching($queryReport);
           return $simpleDB_datafetch;
       }

       else
       {
           if($queryReport)
               return 1;
           else
               return 0;
       }
    }

    //this function is for error checking using
    function simpleDB_error()
    {
       return mysql_error();
    }

    //this function is for counting the affected rows
    function simpleDB_affectedrows()
    {
       $identifier = $this->simpleDB_connection;
       return mysqli_affected_rows($identifier);
    }
		
		function simpleDB_lastid()
		{
			 $identifier = $this->simpleDB_connection;
       return mysqli_insert_id($identifier);
		}
	

    //this function is for getting the database data
    function simpleDB_fetching($simpleDB_data)
    {
	   	if($this->simpleDB_affectedrows() > 0)
			{
     		$i = 0;
       	while($simpleDB_fetchdata = mysqli_fetch_array($simpleDB_data, MYSQLI_BOTH ))
				{
         	//this will create multidimenssion array
         	$simpleDB_dataget[$i] = $simpleDB_fetchdata;
         	$i++;
       	}
       	return $simpleDB_dataget;
			}
			else
			{
				$simpleDB_dataget = null;
				return $simpleDB_dataget;
			}
    }
		
		function simpleDB_begintransaction()
		{
			mysqli_autocommit($this->simpleDB_connection, FALSE);
		}
		
		function simpleDB_endtransaction()
		{
			if (!mysqli_commit($this->simpleDB_connection)) 
			{
				print("Transaction commit failed\n");
				exit();
			}
		}
	
	//you can close the connection with this
	function simpleDB_close()
	{
		$identifier = $this->simpleDB_connection;
		mysqli_close($identifier);
	}
}
?>
<?php

/////////////////////////////////////////////////////////////////////////////
//                                                                         //
//                    simpleFILE1.0.0                                      //
//                    creator : Ramadhani                                  //
//                    Description : File system class                      //
//                    Lisence : GPL                                        //
//                                                                         //
/////////////////////////////////////////////////////////////////////////////



class simpleFILE
{
	//variables
	
	//for file handling
	var $simpleFILE_handle;
	
	//for error checking
	var $simpleFILE_error;
	
	//comstructor
	function simpleFILE()
	{
		//tell the program that there is no error right now
		$this->simpleFILE_error = 0;
	}
	
	//use this to open your file
	function open_file($filename,$mode)
	{
		//check if the file exists
		if(file_exists($filename))
		{
			if(!$handle = fopen($filename,$mode))
			{
				$this->simpleFILE_error = 1;	
			}
			else
			{	
			$this->simpleFILE_handle = $handle;
			}
		}
		else
		{
			$this->simpleFILE_error = 3;
		}
	}
	
	//read your file
	function gets_file($length)
	{
		$handle = $this->simpleFILE_handle;
		while (!feof($handle)) 
		{
    		$bufferfile = fgets($handle, $length);
    		return $bufferfile;
		}
	}
	
	//write your file here
	function write_file($content)
	{
		$handle = $this->simpleFILE_handle;
		if(fwrite($handle, $somecontent) === FALSE)
		{
			$this->simpleFILE_error = 2;
		}
	}
	
	//return how big the file size
	function size_file($filename)
	{
		//check if file exists
		if(file_exists($filename))
		{
			$size = filesize($filename);
			return $size;
		}
		else
		{
			$this->simpleFILE_error = 3;
		}
	}
	
	function type_file($filename)
	{
		if(file_exists($filename))
		{
			$type = filetype($filename);	
			return $type;
		}
		else
		{
			$this->simpleFILE_error = 3;
		}
	}
	
	//want to know the type of the file extenssion?
	function type_ex_file($filename)
	{
		//include the list of file name
		include_once("filetype.php");
		
		//this pattern will catch the extenssion
		$pattern = "/([a-z0-9]+)$/i";
		preg_match($pattern,$filename,$match);
		
		//check if the array exists
		if(isset($simpleFILE_type[$match[0]]))
		{
		 	return $simpleFILE_type[$match[0]];
		}
		else
		{
			return $simpleFILE_type['unknown'];
		}
	}
	
	//and close your connection with this
	function close_file()
	{
		$handle = $this->simpleFILE_handle;
		fclose($handle);
	}
	
	//in case you have errors, call this function and echo the errors
	function error_file()
	{
		$error = $this->simpleFILE_error;
		switch($error)
		{
			case 0:
				$errorMSG = "No Error Found";
				break;
			
			case 1:
				$errorMSG = "CANNOT OPEN FILE!";
				break;
			
			case 2:
				$errorMSG = "CANNOT WRITE FILE!";
				break;
				
			case 3:
				$errorMSG = "FILE DOES'T EXISTS!";
				break;
		}
		return $errorMSG;
	}
}
?>
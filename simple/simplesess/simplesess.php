<?php
class simpleSESS
{
     //create all variables here

     //check for register global is on or off
     var $SESS_registerglobals;

     //constructor
     function __construct($name = 'simple')
     {
     		 session_name($name);
         session_start();
		 		 
         //check if register globals is set
         $SESS_checkglobals = ini_get('register_globals');
         if(empty($SESS_checkglobals))
            $this->SESS_registerglobals = 0;
         else
            $this->SESS_registerglobals = 1;
     }

     //return session id
     function SESS_id()
     {
         return session_id();
     }

     //this function is for registering the session
     function SESS_register( $varName, $varReg)
     {
         //check if register globals is set
         $registerGLOBALS = $this->SESS_registerglobals;
         $sessReg = $varReg;
         if($registerGLOBALS!=1)
            $this->SESS_registeroff( $varName, $sessReg );
         else
            $this->SESS_registeron( $varName, $sessReg );
     }

	 //if register globals is off, then use this
     function SESS_registeroff( $varName, $sessReg )
     {
    	 $_SESSION[$varName] = $sessReg;
     }
	
	 //if register globals is on, then use this
     function SESS_registeron( $varName, $sessReg )
     {
		 session_register($varName);
		 $_SESSION[$varName] = $sessReg;
	 }
	 
	 //this function is for unregistering session
	 function SESS_unregister( $varName )
	 {
	 	 //check if register globals is set to be on
	 	 $registerGLOBALS = $this->SESS_registerglobals;
         if($registerGLOBALS!=1)
            $this->SESS_unregisteroff( $varName );
         else
            $this->SESS_unregisteron( $varName );	
	 }
	 
	 //this function is for unregistering session when register globals is off
	 function SESS_unregisteroff( $varName )
     {
    	 unset($_SESSION[$varName]);
     }
	
	 //this function is for unregistering session when register globals is on
	 function SESS_unregisteron( $varName )
     {
         session_unregister($varName);
     }
	 
	 //this function is for unregister all session variables
	 function SESS_unregisterall()
	 {
	 	 //check if register globals is set to on or off
	 	 $registerGLOBALS = $this->SESS_registerglobals;
         if(empty($registerGLOBALS))
            $this->SESS_unregisteralloff();
         else
            $this->SESS_unregisteralloff();
	 }

	 //this function is for unregistering all session variables when register globals is off	 
	 function SESS_unregisteralloff()
	 {
	   	 $_SESSION = array();
	 }
	 
	 //this function is for unregistering all session variables when register globals is on
	 function SESS_unregisterallon()
	 {
	   	 session_unset();
	 }
	 
	 //this function is for destroying the session
	 function SESS_destroy()
	 {
	 	 session_destroy();
	 }
}

?>
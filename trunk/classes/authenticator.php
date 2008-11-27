<?php
Load::FromModels("users");
Load::FromDataMappers("contact");
Class Authenticator 
{

	function __construct()
	{
		
		
	}
	
	
	private static function initSession()
	{
		
		$_SESSION['Logged']="0";
		$_SESSION['userId']="";
		
	}
	
	function IsLogged ()
	{
		header("Expires: Thu, 20 Mar 2008 06:26:41 GMT");
		header("Last-Modified: ".gmdate("D ,d M Y H:i:s") . " GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma:no-cache");
		if(!isset($_SESSION['Logged']))
			session_start();
		if(!isset($_SESSION['Logged']))
		{
			Authenticator::initSession();
		}
    if($_SESSION['Logged']=="1")
		{
			
			return true;
		}
		else 
		{
			
			return false;
		}
	
	}
	
	function IsAdmin()
	{
	
	}
	
	static function Login ($registry, $email, $password)
	{
		
		$tableModel = new Users ($registry);
		$row = $tableModel -> GetBy("eMail", $email);
		if (isset($row[0]) && $row[0]["password"] == $password)
		{
			if(!isset($_SESSION['Logged']))
				session_start();

			$_SESSION['Logged']="1";
			$_SESSION['userId']=$row[0]["id"];
			return $row[0]["id"];
		}
		
		return false;
	}
	
	function Logout()
	{
		session_destroy();
		unset($_SESSION);
	}
	
	
	static function GetLoggedUserId()
	{
		if(!isset($_SESSION['Logged']))
			session_start();
		if(isset($_SESSION['Logged']) && $_SESSION['Logged']=="1" && isset($_SESSION['userId']) )
			return $_SESSION['userId'];
		return false;
			
	}
}

?>
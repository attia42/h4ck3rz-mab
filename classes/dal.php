<?php


// this interface must be implemented by each new DataBase system you want to add , like if you want to add Microsoft SQL database instead of MySQL
abstract class Database
{

	private $dbName;
	private $dbHost;
	private $dbUser;
	private $dbPass;
	private $dbLink;

	abstract function Connect();
	abstract function Query($queryString);
	abstract function DisConnect();

}


// this class used to return the DB which the user inputs by $dbType 
class DatabaseFactory
{
	public static function GetDatabase($dbType,$dbHost,$dbName,$dbUser,$dbPass)
	{
		if($dbType=="mysql")
		{
			Load::FromDatabases('mysql');
			return new MySql($dbHost,$dbName,$dbUser,$dbPass);
		}
	}	
} 



?> 


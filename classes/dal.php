<?php

interface Idatabase
{

	private $dbName;
	private $dbHost;
	private $dbUser;
	private $dbPass;
	private $dbLink;

	public function Connect();
	public function query($queryString);
	public function DisConnect();

}



class MySql implements Idatabase
{
	// Constructor :
	function __construct($dbName,$dbHost,$dbUser, $dbPass)
	{
		$this->dbName=$dbName;
		$this->dbHost=$dbHost;
		$this->dbUser=$dbUser;
		$this->dbPass=$dbPass;

	}


	// The Mutators 
	function setdbName($NewdbName)
	{
		$this->dbName=$newdbName;
		$this->UpdateLink();
	}

	function setDataHost($NewdbHost)
	{
		$this->dbHost=$newdbHost;
		$this->UpdateLink();
	}

	function setdbUser($NewdbUser)
	{
		$this->dbUser=$newdbUser;
		$this->UpdateLink();
	}

	function setdbPass($NewdbPass)
	{
		$this->dbPass=$newdbPass;
		$this->UpdateLink();
	}
	
	function setAllFields($NewdbName,$NewdbHost,$NewdbUser,$NewdbPass)
	{
		$this->dbName=$newdbName;
		$this->dbHost=$newdbHost;
		$this->dbUser=$newdbUser;
		$this->dbPass=$newdbPass;
	}


	
	// 	Main  db Functions
	function Connect()
   	{
		$this->dbLink = mysql_connect($this->dbHost, $this->dbUser, $this->dbPass) or die("Could not make connection to MySQL");
		mysql_select_db($this->dbName) or die ("Could not open db: ". $this->dbName);
	}
	
	function query($queryString)
	{
		if(!isset($this->dbLink)) $this->Connect(); 
		$result = mysql_query($queryString, $this->dbLink) or die("Error: ". mysql_error());
		$returnArray = array();
		$i=0;
		while ($row = mysql_fetch_array($result, MYSQL_BOTH))
		if ($row)
			$returnArray[$i++]=$row;
		mysql_free_result($result);
		return $returnArray;

	}
	
	function DisConnect()
	{
	        if(isset($this->dbLink)) 
		{
			mysql_close($this->dbLink); 
		}
        	else mysql_close();

	}

	function __destruct() {
		$this->DisConnect();
	}
	public function UpdateLink()
	{
		// to get Link with the newly Changed Value
	if(isset($this->dbLink))
	{
	$this->DisConnect();
	$this->Connect();
	}
	
	}

}



class DatabaseFactory
{
	public static function dbConnect($dbType,$dbName,$dbHost,$dbUser,$dbPass)
	{
		if($dbType=="mysql")
		{
			return new MySql($dbName,$dbHost,$dbUser,$dbPass);
		}
	}	
} 



?> 


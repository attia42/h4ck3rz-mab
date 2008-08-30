<?php 
class MySql extends Database
{
	// Constructor :
	function __construct($dbHost, $dbName, $dbUser, $dbPass)
	{
		$this->dbName=$dbName;
		$this->dbHost=$dbHost;
		$this->dbUser=$dbUser;
		$this->dbPass=$dbPass;

	}


	// The Mutators 
	function setdbName($newdbName)
	{
		$this->dbName=$newdbName;
		$this->UpdateLink();
	}

	function setDataHost($newdbHost)
	{
		$this->dbHost=$newdbHost;
		$this->UpdateLink();
	}

	function setdbUser($newdbUser)
	{
		$this->dbUser=$newdbUser;
		$this->UpdateLink();
	}

	function setdbPass($newdbPass)
	{
		$this->dbPass=$newdbPass;
		$this->UpdateLink();
	}
	
	function setAllFields($newdbName,$newdbHost,$newdbUser,$newdbPass)
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
	
	function Query($queryString)
	{
		if(!isset($this->dbLink)) 
		{
			$this->Connect(); 
			
		}
		$result = mysql_query($queryString, $this->dbLink) or die("Error: ". mysql_error());
		$returnArray = array();
		$i=0;
		if ($result==1)
			return "";
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			if ($row)
			{	
				
				$returnArray[$i++]=$row;
				
			}
		}
		mysql_free_result($result);
		return $returnArray;

	}
	
	function DisConnect()
	{
	  if(isset($this->dbLink)) 
		{
			mysql_close($this->dbLink); 
		}
    

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
	
		// Main Query Array for SELECT :
	//Array tables($tablesName..)
	//Array selections($selectionColumns), empty for all columns > "*"
	//Array joins(joinType,tablesJoined ..)
	//String onCondition , 
	//String whereCondition , 
	//Array orderBy($column => DESC or ASC ,...)
	function BuildSqlSelect ($queryArray)
	{
		$query = "";
		$selectString ="Select ";
		$fromString = " FROM ";
		$joinStatement = "";
		$onString = "";
    $whereString = "";
        
		if ( check_not_empty($queryArray["joins"], 1) && check_not_empty($queryArray["onCondition"], 1) ) {
            $onString = " ON " . $queryArray['onCondition'] . " ";
        }
        
        if ( check_not_empty($queryArray['whereCondition'], 1) ) {
            $whereString = " WHERE ". $queryArray["whereCondition"] ." ";
        }
		 
		$orderByStatement = "ORDER BY ";
		
		//Building the Selection
		$selectString .= check_not_empty($queryArray['selections'], 1) ? $this->BuildItems($queryArray['selections']) . "  " : " * ";
		$query .= $selectString;
		
		//Building the From 
		$fromString .= check_not_empty($queryArray["tables"], 1) ? $this->BuildItems($queryArray["tables"]) . " " : "";
		$query .= $fromString;
		
		//Building the Joins
		$joinStatement .= check_not_empty($queryArray["joins"], 1) ?  $queryArray["joins"][0] ." " : "";
		unset($queryArray["joins"][0]);
		$joinStatement .= check_not_empty($queryArray["joins"], 1) ? $this->BuildItems($queryArray["joins"]) . " " : "";
		$query .= $joinStatement;
		
		$query .= $onString . $whereString;
		
		return $query;
				
	}
	//Array Values ($coulmnName => $its value)
	function BuildSqlInsert($table, $values)
	{
		$query = "";
		$columnsStatement = "";
		$valuesStatement = "";
        
		if(check_not_empty($values))
		{
			foreach($values as $column => $value)
			{
				if($columnsStatement != "")
					$columnsStatement .= ", ";
				$columnsStatement .= $column;
				
				if($valuesStatement != "")
					$valuesStatement .= ", ";
				$valuesStatement .= "'".$value."'";
			}
		}
		$query .= "INSERT INTO " . $table . " ( " . $columnsStatement . " ) " . "Values ( " . $valuesStatement . " ) ";
		return $query;
	}
	
	
	function BuildSqlDelete ($table, $whereCondition)
	{
		if ( check_not_empty($table) && check_not_empty($whereCondition) ) {
            $query = "DELETE FROM " . $table . " WHERE " . $whereCondition;
        }
        
		return $query;
	}
	
	
	//Array Values ($coulmnName => $its new value)
	function BuildSqlUpdate ($table, $values ,$whereCondition)
	{
		$query = "";
		$setStatement = "";
		$whereStatement = chech_not_empty($whereCondition, 1) ? " WHERE " . $whereCondition: "" ;
        
		if(isset($values[0]))
		{
			foreach($values as $column => $value)
			{
				if($columnsStatement != "")
					$columnsStatement .= ", ";
				$setStatement .= $column . " = " . $value;
			}
		}
		
		$query .=  "UPDATE " . $table . " SET " . $setStatement . $whereCondition;
		return $query;
	}
	
	function BuildItems( $array = array() )
	{
		$str= "";
		foreach($array as $item)
		{
			if(empty($str))
				$str .= $item;
			else
				$str .= ", " . $item;
		}
		return $str;
	}
	
	function BuildSqlDescripe($table)
	{
		$query = "DESCRIBE {$table}";
		return $query;
	}

}
?>
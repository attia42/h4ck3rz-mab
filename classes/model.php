<?php 

class Model
{
	
	function GetRow($table, $selections, $where)
	{
		
	}
	
	
	
	
	
	function Query ($query)
	{
		
	}
	
	function AddRow($table, $values)
	{
		
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
		$joinString = "";
		$onString = !empty($queryArray["joins"]) && !empty(trim($queryArray["onCondition"])) ? " ON ". $queryArray["onCondition"] ." " : "" ;
		$whereString = !empty($queryArray["whereCondition"]) ? " WHERE ". $queryArray["whereCondition"] ." ": "" ; 
		$orderByStatement = "ORDER BY ";
		
		//Building the Selection
		$selectString += !empty($queryArray["selections"]) ? implode(", ", $queryArray["selecions"]) . " " : "";
		$query += $selectString;
		
		//Building the From 
		$fromString += !empty($queryArray["tables"]) ? implode(", ", $queryArray["tables"]) . " " : "";
		$query += $fromString;
		
		//Building the Joins
		$joinStatement += !empty($queryArray["joins"]) ?  $queryArray["joins"][0] ." " : "";
		unset($queryArray["joins"][0]);
		$joinStatement += !empty($queryArray["joins"]) ? implode(", ", $queryArray["joins"]) . " " : "";
		$query += $joinStatement;
		
		$query += $onString . $whereString;
		
		return $query;
				
	}
	//Array Values ($coulmnName => $its value)
	function BuildSqlInsert($table, $values)
	{
		$query = "";
		$columnsStatement = "";
		$valuesStatement = "";
		if(isset($values[0]))
		{
			foreach($values as $column => $value)
			{
				if($columnsStatement != "")
					$columnsStatement += ", ";
				$columnsStatement += $column;
				
				if($valuesStatement != "")
					$valuesStatement += ", ";
				$valuesStatement += $value;
			}
		}
		$query += "INSERT INTO " . $table . " ( " . $columsStatement . " ) " . "Values ( " . $valuesStatement . " ) ";
		return $query;
	}
	
	
	function BuildSqlDelete ($table, $whereCondition)
	{
		$query = (!empty(trim($table))) && (!empty(trim($whereCondition))) ? "DELETE FROM ". $table . "WHERE " . $whereCondition;
		return $query;
	}
	
	
	//Array Values ($coulmnName => $its new value)
	function BuildSqlUpdate ($table, $values ,$whereCondition)
	{
		$query = "";
		$setStatement = "";
		$whereStatement = !empty(trim($whereCondition)) ? " WHERE " . $whereCondition: "" ;
		if(isset($values[0]))
		{
			foreach($values as $column => $value)
			{
				if($columnsStatement != "")
					$columnsStatement += ", ";
				$setStatement += $column . " = " . $value;
			}
		}
		
		$query +=  "UPDATE " . $table . " SET " . $setStatement . $whereCondition;
	}
}

?>

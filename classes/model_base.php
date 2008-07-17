<?php 

abstract class Model
{

	function Query ($query)
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
		$selectString .= check_not_empty($queryArray["selections"], 1) ? implode(", ", $queryArray["selecions"]) . " " : "";
		$query .= $selectString;
		
		//Building the From 
		$fromString .= check_not_empty($queryArray["tables"], 1) ? implode(", ", $queryArray["tables"]) . " " : "";
		$query .= $fromString;
		
		//Building the Joins
		$joinStatement .= check_not_empty($queryArray["joins"], 1) ?  $queryArray["joins"][0] ." " : "";
		unset($queryArray["joins"][0]);
		$joinStatement .= check_not_empty($queryArray["joins"], 1) ? implode(", ", $queryArray["joins"]) . " " : "";
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
        
		if(isset($values[0]))
		{
			foreach($values as $column => $value)
			{
				if($columnsStatement != "")
					$columnsStatement .= ", ";
				$columnsStatement .= $column;
				
				if($valuesStatement != "")
					$valuesStatement .= ", ";
				$valuesStatement .= $value;
			}
		}
		$query .= "INSERT INTO " . $table . " ( " . $columsStatement . " ) " . "Values ( " . $valuesStatement . " ) ";
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
	}
}

?>

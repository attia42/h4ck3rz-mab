<?php 

class Model
{
	
	function GetRow($table, $selections, $where)
	{
		$query="SELECT ";
		$selectStatement = "";
		$whereStatement = "";
		if(isset($selections[0]))
		{
			foreach($selections as column)
			{
				if($selectStatement != "")
					$selectStatement += ", "
				$selectStatement += $column;
			}
		}
		else
			$selectStatement = "* "
		
		$query += $selectStatement . " FROM " . $table;
		
		if(isset($where[0]))
		{
			foreach(where as $key => $value)
			{
				if($whereStatement != "")
					$whereStatement += ", ";
				$whereStatement += $key . " = " . $value;
			}
			
			
			$query += " WHERE ( " . $whereStatement . " )";
			$this -> Query($query);
		}
	}
	
	function Query ($query)
	{
		
	}
	
	function AddRow($table, $values)
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
		$this -> Query($query);
	}
	
	
	
}

?>

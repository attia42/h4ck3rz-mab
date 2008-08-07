<?php
	
abstract class DataMap Implements ArrayAccess
{
	protected $fields = array();
	protected $key;
	protected $tableModel;
	
	
	//ArrayAccess Implemtation, will enable datamappers to be used as array : user1["firstName"]
	//not like : user1->fields["firstName"] , which only means less typing :D
	function offsetExists($offset) {
        return isset($this->fields[$offset]);
}

	function offsetGet($offset) 
	{
        return $this->get($offset);
	}

	function offsetSet($offset, $value) 
	{
        
	}

	function offsetUnset($offset) 
	{
        
	}
	//End ArrayAccess Implemtation
	
	//Mutators
	function get($key) 
	{
        if (isset($this->fields[$key]) == false) {
                return null;
        }

        return $this->fields[$key];
	}
	
	
	//End Mutators
	
	
	//Loads data from the db table
  protected function __Load()
	{
		
		
			$arr = $this->tableModel->Get($this->key);
			$this->fields = $arr[0];
		
	}
	//Updates changed data , so Adds if this is a new row (no key), 
	//deletes if fields are null, edits if else
	protected function __Update()
	{
		if(isset($key))
		{
			if(!isset($this->fields))
			{
				$this->tableModel->Remove($key);
			}
			else
			{
				$this->tableModel->Set($key,$fields);
			}
		}
		else
		{
			if(CheckNotNull())
			{
				$this->tableModel->Add($fields);
			}
			else
			{
				throw new Exception('Unable to add data, there are some required fields messing.');
				}
		}
	}
	

	//This is a special method, that checks if the columns in the DB that are "Not Null" is null or not
	//NOT TESTED YET
	protected function CheckNotNull()
	{
		$result = $registry->Query("DESCRIBE '{$this->tableModel->tableName}'");
		foreach($this->fields as $column)
		{
			if($column["Null"]=="NO" && !isset($this->fields[$column["Field"]]))
			{
				return false;
			}
		}
	}
}
?>
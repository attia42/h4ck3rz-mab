<?php
	
abstract class DataMap Implements ArrayAccess
{
	protected $fields = array();
	protected $key;
	protected $tableModel;
	//ArrayAccess Implemtation
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
	
  protected function __Load()
	{
		
		
			$arr = $this->tableModel->Get($this->key);
			$this->fields = $arr[0];
		
	}
	
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
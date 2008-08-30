<?php
	
abstract class DataMap Implements Countable, ArrayAccess, SeekableIterator
{
	protected $fields = array();
	protected $id;
	protected $tableModel;
	protected $editFlag = array();
	private $indexedFields = array();
	private $currentindex = 0;
	
	
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
		
			$this -> set($offset, $value);
		
	}

	function offsetUnset($offset) 
	{
        //sorry :D, you cann't do it :p
	}
	
	
	//implementing SeekableIterator 
	
	
	//*found this code on the spl docu. as I was confused of how it's supposed to function*
	
	function seek($index)   	
	{
		/*
		$this->rewind();
		$position = 0;
		while($position < $index && $this->valid()) {
			$this->next();
			$position++;
		
		}
        	
		if (!$this->valid()) {
			throw new OutOfBoundsException('Invalid seek position');
		}
*/
	}
	//implementing iterator
	function current()   	
	{
		
		return $this[$this->indexedFields[$this->currentindex]];
	}
	
	function key()   	
	{
		return $this->indexedFields[$this->currentindex];
	}
	
	function next()   	
	{
		++$this->currentindex;
		//return $this[$this->indexedFields[$this->currentindex]];
	}
	
	function rewind()   	
	{
		
		$this->currentindex = 0;
	}
	function valid ()   	
	{
		
		if(isset($this->indexedFields[$this->currentindex]) && isset($this[$this->indexedFields[$this->currentindex]]))
			return true;
		return false;
	}
	
	//implementing Countable. 
	function count()   	
	{
		
		return count($this->fields);
	}
	//Mutators
	function get($key) 
	{
        if (isset($this->id) && check_not_empty($this->fields[$key] ) ) {
        	$this -> __LoadField($key);
        }

        return $this->fields[$key];
	}
	
	function Set($key, $value) 
	{
		if (!isset($this->fields[$key])) {
			return ;
		}

  $this->fields[$key] = $value;
 	$this->editFlag[$key] = 1;
        
	}
	
	//End Mutators
	
	
	//Loads data from the db table
  protected function __LoadField($key)
	{
		
		
		$arr = $this->tableModel->Get($this->id,array($key));
		$this->fields[$key] = $arr[0][$key];
		
	}
	//Updates changed data , so Adds if this is a new row (no key), 
	//deletes if fields are null, edits if else
	protected function __Update()
	{
		if(isset($this -> id))
		{
			if(!isset($this->fields))
			{
				$this->tableModel->Remove($key);
			}
			else
			{
				foreach($this->editFlag as $key -> $isEdited)
				{	
					if ($isEdited == 1)
					{
						$this->tableModel->Set($key,array($key => $this->fields[$key]));
					}
				}
			}
		}
		else
		{
			$this->tableModel->Add($this->fields);

		}
	}
	
	protected function __LoadRowStructure()
	{
		$tableDescribe = $this->tableModel->GetTableStructure();
		foreach($tableDescribe as $dis)
		{
			$this->fields[$dis["Field"]] = "";
			$this->fields[$dis["Field"]] = 0;
			$this->indexedFields[] = $dis["Field"];
		}
		
	}


	}

?>
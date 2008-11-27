<?php
//loads class 
Load::FromClasses("datamap");
class Contact extends DataMap
{
	protected $registry;
	function __construct($registry, $id="")
	{
	$this->registry = $registry;
		Load::FromModels("phonebook");
		$this->tableModel = new Phonebook($registry);
		$this->__LoadRowStructure();
		if(check_not_empty($id))
		{
		$this->id = $id;
		}
	}
	
	
	
	function AddToDB ()
	{
		unset($this->id);
		$this->__Update();	
	}
	
	function DeleteContact()
	{
		unset($this->fields);
		$this->__Update();
		//Here can lay some bussiness logic that may make Data mappers very important , How ??
		//in Mab there will be sharing contacts and contacts grouping, so when deleting a contact you 
		// must delete its sharing and grouping if found , you can add this code in here later ISA.
	}
	
	function GetFields()
	{
		$this->__Load();
	}
	
	function UpdateDB()
	{
		if (isset($this->id) && check_not_empty($this->fields))
			$this->__Update();
		
	}
	
	
	
}


?>
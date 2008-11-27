<?php
//loads class 
Load::FromClasses("datamap");
class Group extends DataMap
{
	protected $registry;
	function __construct($registry, $id="")
	{
	$this->registry = $registry;
		Load::FromModels("contactgroup");
		$this->tableModel = new ContactGroup($registry);
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
	
	function DeleteGroup()
	{
		Load::FromModels("phonebook");
		Load::FromDataMappers("contact");
		$phonebookModel = new PhoneBook($this->registry);
		$contactsID = $phonebookModel->GetBy("contactGroupID", $this['id'], array(id));
		for($i=0 ; $i < count($contactsID);$i++)
		{
			$contact = new Contact($this->registry, $contactsID[$i]);
			$contact["contactGroupID"] = 0;
			$contact->UpdateDB();
		}
		unset($this->fields);
		$this->__Update();
		
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
<?php
Load::FromClasses('controller_base');

Class Controller_Index extends Controller_Base {

	function index() 
	{
		if(isset($_GET['table']) && isset($_GET['searchIn']))
		{
		$contactsModel = new Phonebook($this->registry);
		$uId = Authenticator::GetLoggedUserId();
		$searchFor = $_GET['searchFor'];
		$searchIn = $_GET['searchIn'];
		$contactsId = $contactsModel->GetByWhere(" owner = {$uId} AND ($searchIn LIKE '%$searchFor%' or $searchIn LIKE '$searchFor%' or $searchIn LIKE '$searchFor' or $searchIn LIKE '%$searchFor')");
		
		}
	}
	
	
	
}
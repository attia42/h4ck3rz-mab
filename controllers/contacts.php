<?php
Load::FromClasses('controller_base');
class Controller_Contacts extends Controller_Base
{
	function index()
	{
		
	}
	
	function phonebook()
	{
		//a function used to load models
		Load::FromModels("phonebook");
		//a function used to load datamaps
		Load::FromDataMappers("contact");
		//contacts that will be listed  in this page
		$contacts = array();
		//Gets page number
		$page= 1;
		if(isset($_GET["page"]))
		{
			$page=$_GET["page"]; 
		}
		//Get a model for phonebook table, and gets a list for the contacts in the DB
		$contactsModel = new Phonebook($this->registry);
		$contactsId = $contactsModel->GetIdList(array("id"));
		//calculates the total number of pages according to total contacts in the table
		$pagesNum = (count($contactsId) / 10)+1;
		
		//checks if there is an error in iput page, user can input a page number that is out of range of contacts in db
		while(10*($page-1) > count($contactsId))
		{
			$page--;
		}
		
		//offset : from the prev. contacts listed in prev. pages
		$offset = 10*($page-1);
		
		//calculates number of contacts to be loaded in current page, which i made a default number 
		//of 10, but it can be changed later as a setting for each user, the equality is used to, 
		//specially for a last page, as it can contain less than 10 contacts, according to number of contacts in db
		
		$numToBeLoaded = count($contactsId)-$offset < 10 ? abs(count($contactsId)-$offset) : 10;
	  for($i = $offset ; $i < $offset+$numToBeLoaded ; $i++ )
		{
			//here I add Contact instances to the array, this is a battern called Data mapper, you can see this class under  datamaps/contact.php
			$contacts[]=new contact($this->registry, $contactsId[$i]["id"]);
		}
		
		//adding the variables that will be used with the template , templates/phonebook.php, and then echoing it
		$this->registry['template']->set ('contacts',$contacts);
		$this->registry['template']->set ('thisPagenum',$page);
		$this->registry['template']->set ('site_path',$this->registry['site_path']);
		$this->registry['template']->set ('pagesNum',$pagesNum);
		$this->registry['template']->show('contacts'.DIRSEP.'phonebook'.DIRSEP.'phonebook');
	
		
		
	}
}

?>
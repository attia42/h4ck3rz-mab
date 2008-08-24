<?php
Load::FromClasses('controller_base');
class Controller_Contacts	 extends Controller_Base
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
		$thisPage= 1;
		if(isset($_GET["page"]))
		{
			$thisPage=$_GET["page"]; 
		}
		//Get a model for phonebook table, and gets a list for the contacts in the DB
		$contactsModel = new Phonebook($this->registry);
		$contactsId = $contactsModel->GetIdList(array("id"));
		//calculates the total number of pages according to total contacts in the table
		$pagesNum = (count($contactsId) / 10)+1;
		
		//checks if there is an error in iput page, user can input a page number that is out of range of contacts in db
		while(10*($thisPage-1) > count($contactsId))
		{
			$thisPage--;
		}
		
		//offset : from the prev. contacts listed in prev. pages
		$offset = 10*($thisPage-1);
		
		//calculates number of contacts to be loaded in current page, which i made a default number 
		//of 10, but it can be changed later as a setting for each user, the equality is used to, 
		//specially for a last page, as it can contain less than 10 contacts, according to number of contacts in db
		
		$numToBeLoaded = count($contactsId)-$offset < 10 ? abs(count($contactsId)-$offset) : 10;
	  for($i = $offset ; $i < $offset+$numToBeLoaded ; $i++ )
		{
			//here I add Contact instances to the array, this is a battern called Data mapper, you can see this class under  datamaps/contact.php
			$contacts[]=new contact($this->registry, $contactsId[$i]["id"]);
		}
		//geting rows
		$rows ="";
		foreach($contacts as $contact)
		{
			$replace = array(
			"firstName" => $contact['firstName'],
			"homeAddress" => $contact['homeAddress'],
			"homePhone" => $contact['homePhone'],
			"eMail" => $contact['eMail'] );
			$row =" ". $this->get_replace(site_path."views".DIRSEP."contacts".DIRSEP."phonebook".DIRSEP."row.php",$replace);
		  
			$rows .= $row;
		}
		
		//getting pages numbers :
		$pages ="";
		for( $i = 1 ; $i <= $pagesNum ; $i++)
		{
			if($thisPage == $i)
      {
      	
    		$link = $i;
      }
      else
      {
      	$link = "<a href=\"{$this->registry['online_path']}contacts/phonebook?page={$i}\"> {$i}</a>";
      }
			$replace = array("i" => $link);
			$page = $this->get_replace(site_path."views".DIRSEP."contacts".DIRSEP."phonebook".DIRSEP."pagenum.php",$replace);
			$pages .= $page;
		}
		
		//getting main page : 
		$view = $this->get_replace(site_path."views".DIRSEP."contacts".DIRSEP."phonebook".DIRSEP."phonebook.php", array("rows" => $rows, "pages" => $pages));
		echo $view;
		
		
	}
	
	function addcontact()
{
	Load::FromDataMappers("contact");
	if(!(empty($_POST['firstName']) && empty($_POST['lastName'])) )
	{

   $newContact=new Contact($this->registry);
if(isset($_POST['bday_day']))
		$_POST['birthday']= date("Y-m-d", mktime(0, 0, 0,$_POST['bday_day'] , $_POST['bday_month'] , $_POST['bday_year']));
		
foreach($newContact->fields as $key => $value )
 {
	if(isset($_POST[$key]))
    {

	$newContact[$key] = $_POST[$key];

	}

  }

 $newContact->AddToDb();
 
 echo "Contact was added successfully.";
  }
$view = $this->get(site_path."views".DIRSEP."contacts".DIRSEP."addcontact".DIRSEP."add.html"); 
 echo $view;
 
	
}
}

?>
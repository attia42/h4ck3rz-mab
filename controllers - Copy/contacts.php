<?php
Load::FromClasses('controller_base');
//a function used to load models
Load::FromModels("phonebook");
//a function used to load datamaps
Load::FromDataMappers("contact");
Load::FromDataMappers("user");

class Controller_Contacts	 extends Controller_Base
{
	function index()
	{
		
	}
	
	function phonebook()
	{
		if(!Authenticator::IsLogged())
				header("Location: ../user/login");
		
		$user = new User($this->registry, Authenticator::GetLoggedUserId());
		
		//contacts that will be listed  in this page
		$contacts = array();
		//Gets page number
		$thisPage= 1;
		$currentLetter;
		if(isset($_GET['letter']))
		{
			$currentLetter = $_GET['letter'];
		}
		if(isset($_GET["page"]))
		{
			$thisPage=$_GET["page"]; 
		}
		//Get a model for phonebook table, and gets a list for the contacts in the DB
		$contactsModel = new Phonebook($this->registry);
		$contactsId = $contactsModel->GetBy("owner", Authenticator::GetLoggedUserId());
		//calculates the total number of pages according to total contacts in the table
		$pagesNum = (count($contactsId) / $user['numOfRowsPerPage'])+1;
		
		//checks if there is an error in iput page, user can input a page number that is out of range of contacts in db
		while($user['numOfRowsPerPage']*($thisPage-1) > count($contactsId))
		{
			$thisPage--;
		}
		
		//offset : from the prev. contacts listed in prev. pages
		$offset = $user['numOfRowsPerPage']*($thisPage-1);
		
		//calculates number of contacts to be loaded in current page, which i made a default number 
		//of 10, but it can be changed later as a setting for each user, the equality is used to, 
		//specially for a last page, as it can contain less than 10 contacts, according to number of contacts in db
		
		$numToBeLoaded = count($contactsId)-$offset < 10 ? abs(count($contactsId)-$offset) : 10;
	  for($i = $offset ; $i < $offset+$numToBeLoaded ; $i++ )
		{
			//here I add Contact instances to the array, this is a battern called Data mapper, you can see this class under  datamaps/contact.php
			$contacts[] = new contact($this->registry, $contactsId[$i]["id"]);
		}
		
		$contacts = $this-> search($contacts);
		//geting rows
		$rows ="";
		foreach($contacts as $contact)
		{
			if((isset($currentLetter) && $currentLetter !="" &&ucfirst( $currentLetter[0] )!= ucwords($contact["firstName"][0]))  || ($contact['isBc'] == 1))
			{
				continue;
			}
				$replace = array(
				"id" => $contact['id'],
				"firstName" => $contact['firstName'],
				"lastName" => $contact['lastName'],
				"city" => $contact['city'],
				"homePhone" => $contact['homePhone']);
				$row =" ". $this->get_replace("views/contacts/phonebook/row.php",$replace);
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
      	$letterInLink = isset($currentLetter)? "letter=".$currentLetter ."&": "";
      	$link = "<a href=\"{$this->registry['online_path']}contacts/phonebook?".$letterInLink ."page={$i}\"> {$i}</a>";
      }
			$replace = array("i" => $link);
			$page = $this->get_replace("views/contacts/phonebook/pagenum.php",$replace);
			$pages .= $page;
		}
		//getting letters :
		$letter = 'A' ;
		$letters ="";
    for($i=0;$i<26;$i++){
      if(!isset($currentLetter) || $letter != $currentLetter)
      {
      	$link = "<a href=\"{$this->registry['online_path']}contacts/phonebook?letter={$letter}\"> {$letter}</a>";
      }
      else
      {
      	$link = $letter;
      }
      $letter++;
      $letterText = $this->get_replace("views/contacts/phonebook/letter.html",array("letter" => $link));
      $letters .= $letterText;
    }
    if (isset($currentLetter))
    {
			$letters .=  "<a href=\"{$this->registry['online_path']}contacts/phonebook\"> All</a>";
		}
		else
		{
			$letters .= " All";
		}
		
		$searchOptions="";
		$dumpContact = new Contact($this->registry);
		foreach($dumpContact as $field => $value)
		{
			if($field != "id")
			$searchOptions .= "<option>{$field}</option>";
		}
		$pageIdent ="";
		if(!isset($currentLetter) || isset($thisPage))
		{
				$letter = isset($currentLetter)? "letter=".$currentLetter: "";
				$page = isset($thisPage)? "page=".$thisPage: "";
				$letter .= isset($currentLetter) && isset($thisPage) ? "&" : "";
				
				$pageIdent = "?" . $letter.$thisPage;
				
		}
		$searchForm = $this->get_replace("views/contacts/phonebook/searchform.html",array("options" => $searchOptions,"table" => "phonebook", "pageIdent" => $pageIdent));
		
		//getting main page : 
		$view = $this->get_replace("views/contacts/phonebook/phonebook.php", array("rows" => $rows, "pages" => $pages , "letters" => $letters, "searchForm" => $searchForm));
		echo $view;
		
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////
	function addcontact()
	{
		if(!Authenticator::IsLogged())
				header("Location: ../user/login");
		Load::FromDataMappers("contact");
		if(!(empty($_POST['firstName']) && empty($_POST['lastName'])) )
		{

			$newContact=new Contact($this->registry);
			if(isset($_POST['bday_day'])&&isset($_POST['bday_month'])&&isset($_POST['bday_year']))
				$_POST['birthday']= date("Y-m-d", mktime(0, 0, 0,$_POST['bday_day'] , $_POST['bday_month'] , $_POST['bday_year']));

			foreach($newContact as $key => $value )
			{
				if(isset($_POST[$key])&& $_POST[$key]!="")
				{
				
					
					$newContact[$key] = $_POST[$key];

				}
			}
				$newContact['owner'] = Authenticator::GetLoggedUserId();
			 $newContact->AddToDb();
			echo "Contact Added.";
			header("Location: ../contacts/phonebook");
		}
			$view = $this->get("views/contacts/addcontact/add.html");
			echo $view;
		}
	
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////
	function editcontact()
	{
		
		if(!Authenticator::IsLogged())
			header("Location: ../user/login");
		$contactToEdit = isset($_GET['id']) ? new Contact($this->registry, $_GET['id']) : new Contact($this->registry,$_POST['id']);		
		if (Authenticator::GetloggedUserId() != $contactToEdit['owner'] ) 
			header("Location: ../contacts/phonebook");
			
		if(isset($_POST['firstName']) && isset($_POST['lastName']))
		{			
		
			if(isset($_POST['bday_day']))
				$_POST['birthday']= date("Y-m-d", mktime(0, 0, 0,$_POST['bday_month'], $_POST['bday_day']  , $_POST['bday_year']));

			foreach($contactToEdit as $key => $value )
			{
				if(isset($_POST[$key]))
				{
					$contactToEdit [$key] = $_POST[$key];
				}
			}
			$contactToEdit ->UpdateDB();
			header("Location: ../contacts/viewcontact?id={$contactToEdit['id']}");
		}
		if (isset($_GET['id']))
		{
			$replaceArray = array(
						"id" => $_GET['id'],
						"firstName" => $contactToEdit['firstName'],
						"lastName" => $contactToEdit['lastName'],
						"bday_day" => date('d',strtotime($contactToEdit['birthday'])),
						"bday_month" => date('m',strtotime($contactToEdit['birthday'])),
						"bday_year" => date('Y',strtotime($contactToEdit['birthday'])),
						"country" => $contactToEdit['country'],
						"city" => $contactToEdit['city'],
						"homeAddress" => $contactToEdit['homeAddress'],
						"workAddress" => $contactToEdit['workAddress'],
						"homePhone" => $contactToEdit['homePhone'],
						"mobilePhone" => $contactToEdit['mobilePhone'],
						"workPhone" => $contactToEdit['workPhone'],
						"eMail" => $contactToEdit['eMail'],
						"webSite" => $contactToEdit['webSite'],
						"msn" => $contactToEdit['msn'],
						"yahoo" => $contactToEdit['yahoo'],
						"aol" => $contactToEdit['aol'],
						"gmail" => $contactToEdit['gmail'],
						"facebook" => $contactToEdit['facebook'],
						"myspace" => $contactToEdit['myspace'],
						"company" => $contactToEdit['company'],
						"photo" => $contactToEdit['photo']
						
		);
		
		$view = $this->get_replace("views/contacts/editcontact/editcontact.html", $replaceArray);
		echo $view;
		}
		
		
	}
	
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////
	private function search($contacts)
	{
		if(isset($_POST['table']) && isset($_POST['searchIn']))
		{
			$searchedContacts = array();
			$searchFor = $_POST['searchFor'];
			$searchIn = $_POST['searchIn'];
		
			foreach($contacts as $contact)
			{
				$found = false;
				foreach($contact as $field => $value)
				{
					if($field = $searchIn && ucwords( $value )== ucwords($searchFor ))
					{
						//(stristr($value,$searchFor) != false)
						$found = true;
					}
				}
				if($found)
				{
					$searchedContacts [] = $contact;
				}
			}
			return $searchedContacts;
		}
		
		return $contacts;
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////

	function viewcontact()
	{
		if(!Authenticator::IsLogged())
			header("Location: ../user/login");
		if(!isset($_GET['id']))
			header("Location: ../contacts/phonebook");
		
		$contact = new Contact($this->registry, $_GET['id']);
		if($contact['owner'] != Authenticator::GetLoggedUserId())
			header("Location: ../contacts/phonebook");
		if($contact['isBc'] == 1)
			header("Location: ../contacts/phonebook");
			
		$photo = empty($contact['photo']) ? "../views/images/contact.jpg" : $contact['photo'];
		$details = array(
						"firstName" => $contact['firstName'],
						"lastName" => $contact['lastName'],
						"birthday" => $contact['birthday'],
						"country" => $contact['country'],
						"city" => $contact['city'],
						"homeAddress" => $contact['homeAddress'],
						"workAddress" => $contact['workAddress'],
						"homePhone" => $contact['homePhone'],
						"mobilePhone" => $contact['mobilePhone'],
						"workPhone" => $contact['workPhone'],
						"webSite" => $contact['webSite'],
						"msn" => $contact['msn'],
						"yahoo" => $contact['yahoo'],
						"aol" => $contact['aol'],
						"gmail" => $contact['gmail'],
						"facebook" => $contact['facebook'],
						"myspace" => $contact['myspace'],
						"company" => $contact['company'],
						"photo" => $photo
		);
		
		$view = $this->get_replace("views/contacts/viewcontact/viewcontact.html", $details);
		echo $view;
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////
	function deletecontact()
	{
		if(!Authenticator::IsLogged())
			header("Location: ../user/login");
		$user = new User($this->registry,Authenticator::GetLoggedUserId() );
		foreach($_POST as $key => $value)
		{
			if(is_int($key))
			{
				$contactToDel = new Contact($this->registry, $key);
				if($user['id'] == $contactToDel['owner'] && $user['bcID'] != $contactToDel['id'])
				{
					$contactToDel ->DeleteContact();
				}
			}
		}
		
		
		header("Location: ../contacts/phonebook");
	}
	
	
	
	function action ()
	{
		if(!Authenticator::IsLogged())
			header("Location: ../user/login");
		if(!isset($_POST['action']))
			header("Location: ../contacts/phonebook");
		
		if($_POST['action'] == "Delete")
		{
			$this->deletecontact();
		}

	}
}

?>
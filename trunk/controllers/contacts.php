<?php
Load::FromClasses('controller_base');
//a function used to load models
Load::FromModels("phonebook");
//a function used to load datamaps
Load::FromDataMappers("contact");
Load::FromDataMappers("contactgroup");
Load::FromDataMappers("user");
Load::FromDataMappers("group");
Load::FromModels("contactgroup");


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
		$contactsId = $this->search($contactsId);
		if(!isset($_GET['sortby']))
		{
			$_GET['sortby'] = "name";
		}
		$dir = isset($_GET['dir']) ? $_GET['dir'] : "desc";
		//$dir = $dir != "asc" || $dir != "desc" ? "desc" : $dir;   what was I thinking ^o)
			$contactsId = $this->ContactsSort($contactsId, $_GET['sortby'], $dir);
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
		if(isset($_GET['group']))
		{
			$groupToShow = new Group ($this->registry, $_GET['group']);
			if($groupToShow['owner'] == $user['id'])
			{
			$contacts = $this->FilterGroup($groupToShow,$contacts);
			}
		}
		
		
		
		//geting rows
		$rows ="";
		foreach($contacts as $contact)
		{
			if((isset($currentLetter) && $currentLetter !="" &&ucfirst( $currentLetter[0] )!= ucwords($contact["firstName"][0]))  || $user['bcID'] == $contact['id'])
			{
				continue;
			}
				
			  $contactGroup = new Group($this->registry, $contact["contactGroupID"]);
			  $groupLink= urlSetGet(getPageUrl(),"group",$contactGroup["id"]); ;
			  $groupName= $contactGroup["name"];
			  $groupAvatar=$contactGroup["avatar"];
				$replace = array(
				"id" => $contact['id'],
				"firstName" => $contact['firstName'],
				"lastName" => $contact['lastName'],
				"city" => $contact['city'],
				"homePhone" => $contact['homePhone'],
				"groupName" => $groupName,
				"groupAvatar" => $groupAvatar,
				"groupLink" => $groupLink);
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
      	
      	$link = "<a href=\"".urlSetGet(getPageUrl(),"page",$i)."\"> {$i}</a>";
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
      	$link = "<a href=\"".urlSetGet(getPageUrl(),"letter",$letter)."\"> {$letter}</a>";
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
			$letters .=  "<a href=\" ../contacts/phonebook\"> All</a>";
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
		
		
		$searchForm = $this->get_replace("views/contacts/phonebook/searchform.html",array("options" => $searchOptions,"table" => "phonebook", "currentUrl" => getPageUrl()));
		
		$upGif = "<img src=\"../views/images/up.gif\">" ;
		$downGif = "<img src=\"../views/images/down.gif\">" ;
		$c=$n=$h=$m="";
		
		$sortByNameUrl = urlSetGet(getPageUrl(),"sortby","name");
		$sortByNameUrl = urlSetGet($sortByNameUrl,"dir","desc");
		
		
		$sortByCityUrl = urlSetGet(getPageUrl(),"sortby","city");
		$sortByCityUrl = urlSetGet($sortByCityUrl,"dir","desc");
		
		
		$sortByHomePhone = urlSetGet(getPageUrl(),"sortby","homePhone");
		$sortByHomePhone = urlSetGet($sortByHomePhone,"dir","desc");
		
		
		
		$sortByMobilePhone = urlSetGet(getPageUrl(),"sortby","mobilePhone");
		$sortByMobilePhone = urlSetGet($sortByMobilePhone,"dir","desc");
		
		
		
		if($_GET['sortby']=="name" )
		{
			if($dir=="desc")
			{
				$sortByNameUrl = urlSetGet($sortByNameUrl,"dir","asc");
				$n =  $upGif;
			}
			else if($dir=="asc")
			{
				$sortByNameUrl = urlSetGet($sortByNameUrl,"dir","desc");
				$n = $downGif;
			}
		}
		else if($_GET['sortby']=="city")
		{
			if($dir=="desc")
			{
				$sortByCityUrl = urlSetGet($sortByCityUrl,"dir","asc");
				$c =  $upGif;
			}
			else if($dir=="asc")
			{
				$sortByCityUrl = urlSetGet($sortByCityUrl,"dir","desc");
				$c = $downGif;
			}
			
		}
		else if($_GET['sortby']=="homePhone")
		{
			if($dir=="desc")
			{
				$sortByHomePhone = urlSetGet($sortByHomePhone,"dir","asc");
				$h =  $upGif;
			}
			else if($dir=="asc")
			{
				$sortByHomePhone = urlSetGet($sortByHomePhone,"dir","desc");
				$h = $downGif;
			}
			
		}
		else if($_GET['sortby']=="mobilePhone" && $dir=="desc")
		{
			if($dir=="desc")
			{
				$sortByMobilePhone = urlSetGet($sortByMobilePhone,"dir","asc");
				$m =  $upGif;
			}
			else if($dir=="asc")
			{
				$sortByMobilePhone = urlSetGet($sortByMobilePhone,"dir","desc");
				$m = $downGif;
			}
			
		}
		
		$replace = array(
							"sortByNameUrl" => $sortByNameUrl,
							"sortByCityUrl" => $sortByCityUrl,
							"sortByHomePhoneUrl" => $sortByHomePhone,
							"sortByMobilePhoneUrl" => $sortByMobilePhone,
							"n^" => $n,
							"c^" => $c,
							"h^" => $h,
							"m^"=> $m
							);
							
		//get table header
		$tableHeader = $this->get_replace("views/contacts/phonebook/tableheader.html",$replace);
		
		$groups = $this->GetGroups(Authenticator::GetLoggedUserId());
		$groupsOptions = "";
		foreach($groups as $group)
		{
			$groupsOptions .= '<option value=\''.$group["id"].'\' >'.$group["name"].'</option>';
		}
		
		//getting main page : 
		$view = $this->get_replace("views/contacts/phonebook/phonebook.php", array("rows" => $rows, "pages" => $pages , "letters" => $letters, "searchForm" => $searchForm,"tableHeader" => $tableHeader, "groupsOptions"=> $groupsOptions));
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
		if(!(isset($_GET["id"]) || isset($_POST["id"])))
		{
			header("Location: ../contacts/phonebook");
		}
		$contactToEdit = isset($_GET['id']) ? new Contact($this->registry, $_GET['id']) : new Contact($this->registry,$_POST['id']);		
		
		
		if($contactToEdit['owner'] != Authenticator::GetLoggedUserId())
			header("Location: ../contacts/phonebook");
			
				
		if (Authenticator::GetloggedUserId() != $contactToEdit['owner'] ) 
			header("Location: ../contacts/phonebook");
			
		if(isset($_POST['firstName']) && isset($_POST['lastName']))
		{
		unset($_POST['owner']);
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
		if(isset($_GET['table']) && isset($_GET['searchIn']))
		{
			$searchedContacts = array();
			$searchFor = $_GET['searchFor'];
			$searchIn = $_GET['searchIn'];
		
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
	private function deleteContacts()
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
			header("Location: ../contacts/phonebook");
		}
		
		
		
	}
	
	function addtogroup()
	{
		if(!Authenticator::IsLogged())
			header("Location: ../user/login");
		$user = new User($this->registry,Authenticator::GetLoggedUserId() );
		foreach($_POST as $key => $value)
		{
			
			if(is_int($key))
			{
				$contactToGroup = new Contact($this->registry, $key);
				if($user['id'] == $contactToGroup['owner'] && $user['bcID'] != $contactToGroup['id'])
				{
					$contactToGroup ->AddToGroup($_POST);
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
			$this->deleteContacts();
		}
		else if($_POST['action'] == "Group")
		{
			$this->groupContacts();
			header("Location: ../contacts/addtogroup");
		}
		

	}
	
	
	private function ContactsSort($contacts, $sortBy, $dir)
	{
		if(!isset($contacts[0][$sortBy]))
		{
			
			if($sortBy != "name")
				$sortBy ="name";
		}
		$arrToSort = array();
		for($i=0 ; $i< count($contacts);$i++)
		{
			$valueToBeSorted = $sortBy == "name" ? $contacts[$i]['firstName']." ".$contacts[$i]['lastName'] : $contacts[$i][$sortBy];
			$arrToSort[] = array($i, $valueToBeSorted);
		}
		
		usort($arrToSort, "CustomSearch");
		
		
		if($dir=="asc")
		{
			
			$arrToSort=array_reverse($arrToSort);
		}
			
		
		$sortedContacts = array();
		
		foreach($arrToSort as $sContact)
		{
			$sortedContacts[] = $contacts[$sContact[0]];
		}
		return $sortedContacts;
	}
	
	private function FilterGroup($groupToView, $contacts)
	{
		$this->PrintHint("Viewing Group : {$groupToView['name']}");
		$groupToView = new Group($this->registry, $groupToView['id']);
		if(isset($groupToView))
		{
			$arrToReturn = array();
			foreach($contacts as $contact)
			{
				if($contact['contactGroupID']== $groupToView['id'])
				{
					$arrToReturn[] = $contact;
				}
				
			}
			return $arrToReturn;
		}
		
		return $contacts;
	}
	
	private function GetGroups ($userID)
	{
		$groupsModel = new ContactGroup($this->registry);
		$groups = $groupsModel->GetBy("owner", $userID, array("id", "name"));
		return $groups;
	}


	private function groupContacts()
	{
		var_dump($_POST);
		if(!Authenticator::IsLogged())
			header("Location: ../user/login");
		$user = new User($this->registry,Authenticator::GetLoggedUserId() );
		foreach($_POST as $key => $value)
		{
			
			if(is_int($key))
			{
				
				$contact = new Contact($this->registry, $key);
				if( isset($_POST["group"]) && $user['id'] == $contact['owner'] && $user['bcID'] != $contact['id'])
				{
					$contact ['contactGroupID'] = $_POST["group"] ;
					$contact->UpdateDB();
				}
			}
		}
		
		header("Location: ../contacts/phonebook");
	}
}

?>
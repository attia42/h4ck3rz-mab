<?php
Load::FromClasses('controller_base');
Load::FromClasses('authenticator');
Load::FromDataMappers("user");
Load::FromDataMappers("contact");
Load::FromModels("users");
Load::FromModels("phonebook");

Class Controller_user extends Controller_Base {

	function index() {
		
	}
	function login ()
	{
		if(Authenticator::IsLogged())
				header("Location: ../contacts/phonebook");
		if(isset($_POST['email']) && isset($_POST['password']))
		{
			
			
			
				
			if (Authenticator::Login($this->registry, $_POST['email'], $_POST['password']) != false)
				{
				 	//log him in	
				 
				 header("Location: ../contacts/phonebook");
				 	return true;
				}
		 	  else
			  {
					echo '<div class="error">Error : Wrong Email or Password.</div>';
				}
				 
		}
	
		$view = $this->get("views/user/login/login.html");
		echo $view;
		
	}
	
	function signup()
	{
		if(Authenticator::IsLogged())
			header("Location: ../contacts/phonebook");
		if(isset($_POST['eMail']) && isset($_POST['password']) && isset($_POST['firstName']) && isset($_POST['lastName']))
		{
			
			$newUser = new User ($this->registry);
			$newUser['eMail'] = $_POST['eMail'];
			$newUser['password'] = $_POST['password'];
			if($newUser->AddToDB())
				{
					//header("Location: ../contacts/phonebook");
				}
			else
				{
					echo '<div class="error">Error : this Email is already registered.</div>';
					return false;
				}
			$usersModel = new Users($this->registry);
			$userAdded = $usersModel->GetBy("eMail",$_POST['eMail']);
			$_POST['owner'] = $userAdded[0]['id'];
			$newContact=new Contact($this->registry);
			if(isset($_POST['bday_day']))
				$_POST['birthday']= date("Y-m-d", mktime(0, 0, 0,$_POST['bday_day'] , $_POST['bday_month'] , $_POST['bday_year']));
			
			foreach($newContact as $key => $value )
			{
				if(isset($_POST[$key])&& $_POST[$key]!="")
				{
				
					
					$newContact[$key] = $_POST[$key];

				}
			}
		$newContact['isBc']=1;
		$newContact->AddToDb();
		$phonebookModel = new Phonebook($this->registry);
		$addedContact = $phonebookModel->GetBy("owner",$userAdded[0]['id']);
		$editUser = new User($this->registry, $userAdded[0]['id']);
		
		$editUser['bcID'] = $addedContact[0]['id'];
		
		
		$editUser->UpdateDB();
		
		if (Authenticator::Login($this->registry, $editUser['eMail'], $editUser['password']) != false)
		{
			//log him in	
			header("Location: ../contacts/phonebook");
			return true;
		}
		
		}

		$view = $this->get("views/user/signup/signup.html");
		echo $view;
	}
	
	function logout()
	{
		Authenticator::Logout();
		header("Location: ../user/login");
	}
	
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////
	
	
	function editaccount()
	{
		if(!Authenticator::IsLogged())
			header("Location: ../user/login");
		$user = new User($this->registry, Authenticator::GetLoggedUserId());
		$userContact = new Contact($this->registry, $user['bcID']);
		if (isset($_POST['oldpassword'])&&isset($_POST['newpassword']))
		{
			if($user['password'] == $_POST['oldpassword'])
			{
				$user['password'] = $_POST['newpassword'];
				$user->UpdateDB();
				header("Location: ../user/index");
				exit;
			}
			else
			{
				$this->outputError("Wrong old password entered");
				
			}
		}
		
		else if(isset($_POST['firstName']) && isset($_POST['lastName']) )
		{
			if( !empty($_POST['firstName']) && !empty($_POST['lastName']))
			{
			unset($_POST['eMail']);
			if(isset($_POST['bday_day']))
				$_POST['birthday']= date("Y-m-d", mktime(0, 0, 0,$_POST['bday_day'] , $_POST['bday_month'] , $_POST['bday_year']));

			foreach($userContact as $key => $value )
			{
				if(isset($_POST[$key]))
				{
					$userContact[$key] = $_POST[$key];
				}
			}
			$userContact ->UpdateDB();
			header("Location: ../user/index");
			exit;
			}
		
		else
			$this->outputError("Please enter first and last names.");
		}
	
		$replaceArray = array(
						"firstName" => $userContact['firstName'],
						"lastName" => $userContact['lastName'],
						"bday_day" => date('d',strtotime($userContact['birthday'])),
						"bday_month" => date('m',strtotime($userContact['birthday'])),
						"bday_year" => date('Y',strtotime($userContact['birthday'])),
						"country" => $userContact['country'],
						"city" => $userContact['city'],
						"homeAddress" => $userContact['homeAddress'],
						"workAddress" => $userContact['workAddress'],
						"homePhone" => $userContact['homePhone'],
						"mobilePhone" => $userContact['mobilePhone'],
						"workPhone" => $userContact['workPhone'],
						"webSite" => $userContact['webSite'],
						"msn" => $userContact['msn'],
						"yahoo" => $userContact['yahoo'],
						"aol" => $userContact['aol'],
						"gmail" => $userContact['gmail'],
						"facebook" => $userContact['facebook'],
						"myspace" => $userContact['myspace'],
						"company" => $userContact['company'],
						"photo" => $userContact['photo']
						
		);
		
		$view = $this->get_replace("views/user/editaccount/editaccount.html", $replaceArray);
		echo $view;

		
		
	}
	
	
	function viewbc()
	{
		if(!isset($_GET['id']))
			header("Location: ../contacts/phonebook");
		
		$userToView = new User($this->registry, $_GET['id']);
		if($userToView['bcAccess']!=0)
		{
			header("Location: ../contacts/phonebook");
		}
		
		$contact = new Contact($this->registry, $userToView['bcID']);
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
}

?>
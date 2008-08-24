<?php
Load::FromDataMappers('phonebook');
class Controller_Phonebook extends Controller_Base
{
	
function addcontact($firstName,$lastName)
{
	if(!(empty($_POST['firstName']) && empty($_POST['lastName'])) )
	{

   $newContact=new Contact($this->registry);

foreach($newContact as $key)
 {
	if(isset($_POST['$key']))
    {
	    
	$newContact['$key'] = $_POST['$key'];
	
	}

  }

 $newContact->AddToDb();
  chdir("views/contacts/addcontact");
$view = $this->get("add.html");  
 echo $view;
 echo "Contact was added successfully.";
  }
else
 { 

  chdir("views/contacts/addcontact");
  $view = $this->get("add.html"); 

echo $view;
}	
 
	
}

}


 
 ?>

 
 	
 
  
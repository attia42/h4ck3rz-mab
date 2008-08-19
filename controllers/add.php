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
 $view = $this->get_replace(site_path."views".DIRSEP."contacts".DIRSEP."phonebook".DIRSEP."phonebook.php", array("rows" => $rows, "pages" => $pages)); 
 echo $view;
 echo "Contact was added successfully.";
  }
else
 { 

$view = $this->get_replace(site_path."views".DIRSEP."contacts".DIRSEP."phonebook".DIRSEP."phonebook.php", array("rows" => $rows, "pages" => $pages)); 

echo $view;
}	
 
	
}

}


 
 ?>

 
 	
 
  
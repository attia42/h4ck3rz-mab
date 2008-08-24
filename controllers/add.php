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
 $view = $this->get(site_path."views".DIRSEP."contacts".DIRSEP."addcontact".DIRSEP."add.html", array("rows" => $rows, "pages" => $pages)); 
 echo $view;
 echo "Contact was added successfully.";
  }
else
 { 

$view = $this->get(site_path."views".DIRSEP."contacts".DIRSEP."addcontact".DIRSEP."add.html", array("rows" => $rows, "pages" => $pages)); 

echo $view;
}	
 
	
}

}


 
 ?>

 
 	
 
  
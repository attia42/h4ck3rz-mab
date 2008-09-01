<?php
Load::FromDataMappers('phonebook');
class Controller_Phonebook extends Controller_Base
{
	function editcontacts()
	
	{
		
        
        if(!(empty($_POST['firstName'])&&($_POST['lastName']))
        {
	        $contacToEdit=new Contact($registry,$id);
	        if(isset($_POST['bday_day']))
                                $_POST['birthday']= date("Y-m-d", mktime(0, 0, 0,$_POST['bday_day'] , $_POST['bday_month'] , $_POST['bday_year']));

                        foreach($contacToEdit as $key => $value )
                        {
                                if(isset($_POST[$key]))
                                {
                                
                                        
                                        $contacToEdit[$key] = $_POST[$key];

                                }
                        }

		                    $contacToEdit->UpdateDB();
		                    echo "profile edited successfully ";
		                    
	                    }
	
		$view = $this->get_replace(site_path."views".DIRSEP."contacts".DIRSEP."addcontact".DIRSEP."add.html", array("firstName" => $firstName, "lastName" => $lastName)); 
        echo $view;
	
	

	
      }

}

?>




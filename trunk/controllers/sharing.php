<?php
Load::FromClasses('controller_base');
Load::FromClasses('authenticator');
Load::FromDataMappers("user");
Load::FromDataMappers("contact");
Load::FromModels("users");
Load::FromModels("phonebook");

Class Controller_sharing extends Controller_Base {
	function index ()
	{
		
	}
		
		
}


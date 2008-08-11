<?php
__autoloadModel("phonebook");
$aModel = new Phonebook($this->registry);
for($i = 0 ; $i<50 ; i++)
{
	$values = array(
	"title" => "Mr",
	"firstName" => "Mohamed",
	"lastName"	=> "Atia",
	"birthday" => date('Y-m-d'),
	"contactGroupID" => 0
	"owner" => 0
	);
	$aModel->Add($values);
	
	}

?>
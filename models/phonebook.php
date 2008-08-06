<?php
//**********************************************************************************
//Class Name:                 phonebook
//Filename:                   phonebook_model.php
//Author:                     Reem Al-Ashry  <reem.alashry@gmail.com>
//Purpose:                    Basic CRUD functions for [CAT-Hackers MyAdressBook Project]
//***********************************************************************************************

__autoload("model_base");


class Phonebook extends Model

{
	public $tableName = "phonebook";
	
	function GetIdList($selections,$where="",$limit = "",$offset="")
	{
		$query = $this->BuildSqlSelect(array("tables" => array($this->tableName) , "selections" => $selections ,"joins" => array() , "onCondition" => "" , "whereCondition" => $where ,"orderBy" => array()));
		$query .= check_not_empty($limit,1)&& check_not_empty($offset, 1) ? " LIMIT $offset , $limit " : "";
		return $this->Query($query);
	}
}
      
?>	
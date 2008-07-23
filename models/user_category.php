<?php
//*********************************************
//Class Name:              MessageStatus
//Filename:                   Mesage_Status.php
//Author:                     Amr Salah  <amr.salah.2010@gmail.com>
//Purpose:                    Basic CRUD functions for [CAT-Hackers MyAdressBook Project]
//*********************************************

class UserCategory extends Model{

	function AddCategory($values){
		$query = $this->BuildSqlInsert("usercategory", $values);
		$this->Query($query);
	}
	
	function DeleteCategory($id){
		$query = $this->BuildSqlDelete("usercategory"," id = '" .$id. "' ");
		$this->Query($query);
	}
	
	function EditCategory($id, $values){						
		$query = $this->BuildSqlUpdate("usercategory", $values, " id = '" .$id. "' ");
		$this->Query($query);
	}
	
	function ShowCategory($id, $selections = array()){
		$query = $this->BuildSqlSelect(array("tables" => array("usercategory") , 
		"selections" => $selections ,"joins" => array() , "onCondition" => "" , 
		"whereCondition" => " id = '". $id."'" ,"orderBy" => array()));
		$this->Query($query);
	}

}



?>
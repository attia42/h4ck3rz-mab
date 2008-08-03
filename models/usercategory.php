<?php
//*********************************************
//Class Name:              MessageStatus
//Filename:                   Mesage_Status.php
//Author:                     Amr Salah  <amr.salah.2010@gmail.com>
//Purpose:                    Basic CRUD functions for [CAT-Hackers MyAdressBook Project]
//*********************************************

class UserCategory extends Model
{
	$tableName="usercategory";

	
	function Add($values){
		$query = $this->BuildSqlInsert($tableName, $values);
		$this->Query($query);
	}
	
	function Remove($id){
		$query = $this->BuildSqlDelete($tableName," id = '" .$id. "' ");
		$this->Query($query);
	}
	
	function Set($id, $values){						
		$query = $this->BuildSqlUpdate($tablename, $values, " id = '" .$id. "' ");
		$this->Query($query);
	}
	
	function Get($id, $selections = array()){
		$query = $this->BuildSqlSelect(array("tables" => array($tableName) , 
		"selections" => $selections ,"joins" => array() , "onCondition" => "" , 
		"whereCondition" => " id = '". $id."'" ,"orderBy" => array()));
		$this->Query($query);
	}

}



?>
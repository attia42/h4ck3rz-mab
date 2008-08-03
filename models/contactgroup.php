<?php
//*********************************************
//Class Name:              ContactGroup
//Filename:                   contact_Group.php
//Author:                     Amr Salah  <amr.salah.2010@gmail.com>
//Purpose:                    Basic CRUD functions for [CAT-Hackers MyAdressBook Project]
//*********************************************
require_once("../classes/model_base.php");

class ContactGroup extends Model{
     $tableName = "contactgroup";
	function Add($values){
		$query = $this->BuildSqlInsert($tableName,$values);
		return $this->Query($query);
	}
		
	function Remove($id){
		$query = $this->BuildSqlDelete($tableName,"id = '" . $id . "' ");
		return $this->Query($query);
	}
		
	function Get($id, $selections = array()){
		$query = $this->BuildSqlSelect(array("tables" => array($tableName) , 
		"selections" => $selections ,"joins" => array() , "onCondition" => "" , "whereCondition" => " id = '". $id."'" ,"orderBy" => array()));
			return $this->Query($query);
		}
		
	function Set( $id, $values){
		$query = $this->BuildSqlUpdate($tableName,$values,"id = '" . $id . "' ");
		return $this->Query($query);
	}
		
}

?>
<?php
//*********************************************
//Class Name:              ContactGroup
//Filename:                   contact_Group.php
//Author:                     Amr Salah  <amr.salah.2010@gmail.com>
//Purpose:                    Basic CRUD functions for [CAT-Hackers MyAdressBook Project]
//*********************************************
require_once("../classes/model_base.php");

class ContactGroup extends Model{

	function Add($values){
		$query = $this->BuildSqlInsert("contactgroup",$values);
		return $this->Query($query);
	}
		
	function Remove($id){
		$query = $this->BuildSqlDelete("contactgroup","id = '" . $id . "' ");
		return $this->Query($query);
	}
		
	function Get($id, $selections = array()){
		$query = $this->BuildSqlSelect(array("tables" => array("contactgroup") , 
		"selections" => $selections ,"joins" => array() , "onCondition" => "" , "whereCondition" => " id = '". $id."'" ,"orderBy" => array()));
			return $this->Query($query);
		}
		
	function Set( $id, $values){
		$query = $this->BuildSqlUpdate("contactgroup",$values,"id = '" . $id . "' ");
		return $this->Query($query);
	}
		
}

?>
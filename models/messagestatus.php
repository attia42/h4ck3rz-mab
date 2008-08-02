<?php
//*********************************************
//Class Name:              MessageStatus
//Filename:                   Mesage_Status.php
//Author:                     Amr Salah  <amr.salah.2010@gmail.com>
//Purpose:                    Basic CRUD functions for [CAT-Hackers MyAdressBook Project]
//*********************************************
require_once("../classes/model_base.php");

class MessageStatus extends Model{

	function Add($values){
		$query = $this->BuildSqlInsert("messagestatus",$values);
		return $this->Query($query);
	}
	// i Think Delete Message Function not used because of  This table contain Just Message ID and it's status ...
	function Remove($id){
		$query = $this->BuildSqlDelete("messagestatus","id = '" . $id . "' ");
		return $this->Query($query);
	}
	
	function Get($id, $selections = array()){
		$query = $this->BuildSqlSelect(array("tables" => array("messagestatus") , "selections" => $selections ,"joins" => array() , "onCondition" => "" , "whereCondition" => " id = '". $id."'" ,"orderBy" => array()));
		return $this->Query($query);
	}
	
	function Set( $id, $values){
		$query = $this->BuildSqlUpdate("messagestatus",$values,"id = '" . $id . "' ");
		return $this->Query($query);
	}
	
}


?>
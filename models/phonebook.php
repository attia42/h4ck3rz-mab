<?php
//**********************************************************************************
//Class Name:                 phonebook
//Filename:                   phonebook_model.php
//Author:                     Reem Al-Ashry  <reem.alashry@gmail.com>
//Purpose:                    Basic CRUD functions for [CAT-Hackers MyAdressBook Project]
//***********************************************************************************************

require_once("../classes/model_base.php");


class Phonebook extends Model

{
	$tableName="phonebook";
	
	function Add($values)
	{
		$query=$this->BuildSqlInsert($tableName,$values);
		$this->Query($query);
	}
	
	
	
	function Get($id,$selections=array())
	{
		$query = $this->BuildSqlSelect(array("tables" => array($tableName) , "selections" => $selections ,"joins" => array() , "onCondition" => "" , "whereCondition" => " id = '". $id."'" ,"orderBy" => array()));
		return $this->Query($query);
	}
	
	
	
	function Set($id,$values)
	{
		$query=$this->BuildSqlUpdate($tableName,$values,"id= '" . $id ."' ");
		$this->Query($query);
	}
	
	
	
	function Remove($id)
	{
		$query=$this->BuildSqlDelete($tabelName,"id= '" .$id "' ");
		$this->Query($query);
	}
	
}
      
?>	
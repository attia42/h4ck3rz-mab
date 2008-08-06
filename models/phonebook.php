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
	
	function Add($values)
	{
		$query=$this->BuildSqlInsert($this->tableName,$values);
		$this->Query($query);
	}
	
	
	
	function Get($id,$selections=array())
	{
		$query = $this->BuildSqlSelect(array("tables" => array($this->tableName) , "selections" => $selections ,"joins" => array() , "onCondition" => "" , "whereCondition" => " id = '". $id."'" ,"orderBy" => array()));
		return $this->Query($query);
	}
	
	
	
	function Set($id,$values)
	{
		$query=$this->BuildSqlUpdate($this->tableName,$values,"id= '" . $id ."' ");
		$this->Query($query);
	}
	
	
	
	function Remove($id)
	{
		$query=$this->BuildSqlDelete($this->tableName,"id= '" .$id . "' ");
		$this->Query($query);
	}
	
	function GetIdList($selections,$where="",$limit = "",$offset="")
	{
		$query = $this->BuildSqlSelect(array("tables" => array($this->tableName) , "selections" => $selections ,"joins" => array() , "onCondition" => "" , "whereCondition" => $where ,"orderBy" => array()));
		$query .= check_not_empty($limit,1)&& check_not_empty($offset, 1) ? " LIMIT $offset , $limit " : "";
		return $this->Query($query);
	}
}
      
?>	
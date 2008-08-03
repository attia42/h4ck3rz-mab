<?php
//*********************************************
//Class Name:                 SentContact
//Filename:                   sentcontact_model.php
//Author:                     Reem Al-Ashry  <reem.alashry@gmail.com>
//Purpose:                    Basic CRUD functions for [CAT-Hackers MyAdressBook Project]
//*********************************************


require_once("../classes/model_base.php");

class SentContact extends Model
{
	$tableName="sentcontact";
	
	
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
		$query=$this->BuildSqlUpdate($tableName,$values,"id = '" . $id . "' ");
		$this->Query($query);
	}
	
	
	
	function Remove($id)
	{
		$query=$this->BuildSqlDelete($tableName,"id = '" . $id . "' ");
		$this->Query($query);
	}
	  
        }
        
    ?>
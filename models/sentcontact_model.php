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
	function NewSentContact($values)
	{
		$query=$this->BuildSqlInsert("sentcontact",$values);
		$this->Query($query);
	}
	
	
	
	function ShowSentContact($id,$selections=array())
	{
		$query = $this->BuildSqlSelect(array("tables" => array("sentcontact") , "selections" => $selections ,"joins" => array() , "onCondition" => "" , "whereCondition" => " id = '". $id."'" ,"orderBy" => array()));
        return $this->Query($query);
	}
	
	
	
	function EditSentContact($id,$values)
	{
		$query=$this->BuildSqlUpdate("sentcontact",$values,"id = '" . $id . "' ");
		$this->Query($query);
	}
	
	
	
	function DeleteSentContact($id)
	{
		$query=$this->BuildSqlDelete("sentcontact","id = '" . $id . "' ");
		$this->Query($query);
	}
	  
        }
        
    ?>
<?php
//*********************************************
//Class Name:              ContactGroup
//Filename:                   contact_Group.php
//Author:                     Amr Salah  <amr.salah.2010@gmail.com>
//Purpose:                    Basic CRUD functions for [CAT-Hackers MyAdressBook Project]
//*********************************************
	require_once("../classes/model_base.php");
	
	class ContactGroup extends Model{
	
			function AddGroup($values){
				$query = $this->BuildSqlInsert("contactgroup",$values);
				return $this->Query($query);
			}
			
			function DeleteGroup($id){
				$query = $this->BuildSqlDelete("contactgroup","id = '" . $id . "' ");
				return $this->Query($query);
			}
			
			function ShowGroupDetails($id, $selections = array()){
				$query = $this->BuildSqlSelect(array("tables" => array("contactgroup") , "selections" => $selections ,"joins" => array() , "onCondition" => "" , "whereCondition" => " id = '". $id."'" ,"orderBy" => array()));
				return $this->Query($query);
			}
			
			function EditGroup( $id, $values){
				$query = $this->BuildSqlUpdate("contactgroup",$values,"id = '" . $id . "' ");
				return $this->Query($query);
			}
			
	}


?>
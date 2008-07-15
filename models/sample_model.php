<?php
require_once("../classes/model_base.php");

class SampleModel extends Model
{
	// argument : $values associative array can be like
	//array(
	//"column1Name" => $firstName
	//"column2Name" => $secondName
	//)
	function AddContact($values)
	{
		$query = $this->BuildSqlInsert("phonebook",$values);
		$this->Query($query);
	}
	
	
	//	$selections array is for containing columns names you want to select from the table 
	//array(
	//"firstName"
	//, "secondName" 
	//)
	//you can enter an empty array for selecting all columns (fields)
	// $id  is used to generate the where condition that will be used in the query to find the certain contact
	function GetContact ($selections = array(), $id)
	{
	// Main Query Array for SELECT :
	//Array tables($tablesName..)
	//Array selections($selectionColumns), empty for all columns > "*"
	//Array joins(joinType,tablesJoined ..)
	//String onCondition , 
	//String whereCondition , 
	//Array orderBy($column => DESC or ASC ,...)
		$query = $this->BuildSqlSelect(array(array("phonebook") , $selections , array() , "" , " id = '". $id."'" , array()));
		return $this->Query($query);
	}
	
	
	function DeleteContact ()
	{
		//Continue your model :D
	}
}

?>
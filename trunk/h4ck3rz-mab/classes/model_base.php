<?php 

abstract class Model
{
	protected $registry;	
	function __construct($registry)
	{
		$this->registry = $registry;
	}
	function Query ($query)
	{
		
		return $this->registry["db"]->Query($query);
	}
	function Add($values)
	{
		$query=$this->registry["db"]->BuildSqlInsert($this->tableName,$values);
		$this->Query($query);
	}
	
	
	
	function Get($id,$selections=array())
	{
		$query = $this->registry["db"]->BuildSqlSelect(array("tables" => array($this->tableName) , "selections" => $selections ,"joins" => array() , "onCondition" => "" , "whereCondition" => " id = '". $id."'" ,"orderBy" => array()));
		return $this->Query($query);
	}
	
	function GetBy($column, $value, $selections = array())
	{
		$query = $this->registry["db"]->BuildSqlSelect(array("tables" => array($this->tableName) , "selections" => $selections ,"joins" => array() , "onCondition" => "" , "whereCondition" => " ".$column." = '". $value."'" ,"orderBy" => array()));
		return $this->Query($query);
	}
	
	function GetByWhere($where, $selections = array())
	{
		$query = $this->registry["db"]->BuildSqlSelect(array("tables" => array($this->tableName) , "selections" => $selections ,"joins" => array() , "onCondition" => "" , "whereCondition" => $where, "orderBy" => array()));
		return $this->Query($query);
	}
	
	function Set($id,$values)
	{
		$query=$this->registry["db"]->BuildSqlUpdate($this->tableName,$values,"id= '" . $id ."' ");
		$this->Query($query);
	}
	
	
	
	function Remove($id)
	{
		$query=$this->registry["db"]->BuildSqlDelete($this->tableName,"id= '" .$id . "' ");
		$this->Query($query);
	}
	
	function GetTableStructure()
	{
		$query=$this->registry["db"]->BuildSqlDescripe($this->tableName);
		return $this->Query($query);
	}
	

}

?>

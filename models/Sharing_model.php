<?php

require_once("../classes/model_base.php");

class Sharing extends Model
{
	function BuildSharedList($values)
	{
	$query=$this->BuildSqlInsert("sharing",$values);
	$this->Query($query);
	}
	function ShowSharedList($selections=array(),$id)
	{
		$query=$this->BuildSqlSelect(array(array("sharing"),$selections,array(),"",id='".$id."'",array()));
        return $this->Query($query);
    }
    $queryArray['tables']=array('sharing');
    function UpdateSharedList($destID,$userID)
    {
	    $query=$this->BuildSqlUpdate($queryArray);
	    $this->Query($query);
				}
				function DeleteSharedList($queryArray)
				{
					$query=$this->BuildSqlDelete($quaryArray);
					$this->Query($query);
				}
			}
	?>
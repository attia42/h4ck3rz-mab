<?php
//*********************************************
//Class Name:                 Sharing
//Filename:                   Sharing_model.php
//Author:                     Reem Al-Ashry  <reem.alashry@gmail.com>
//Purpose:                    Basic CRUD functions for [CAT-Hackers MyAdressBook Project]
//*********************************************

require_once("../classes/model_base.php");

class Sharing extends Model
{
	
     function NewShare($values)
       {
       $query=$this->BuildSqlInsert("sharing",$values);
       $this->Query($query);
       }
       
       
       
     function ShowShare($id,$selections=array())
       {
       $query = $this->BuildSqlSelect(array("tables" => array("sharing") , "selections" => $selections ,"joins" => array() , "onCondition" => "" , "whereCondition" => " id = '". $id."'" ,"orderBy" => array()));
       return $this->Query($query);
       }
       
       
       
     function EditShare($id,$values)
       {
       $query=$this->BuildSqlUpdate("sharing",$values,"id = '" . $id . "' ");
       $this->Query($query);
       }
                               
                               
                               
     function DeleteShare($id)
       {
       $query=$this->BuildSqlDelete("sharing","id = '" . $id . "' ");
       $this->Query($query);
        }
                       
        }
        
        
       ?>

<?php

require_once("../classes/model_base.php");

class Sharing extends Model
{
       function BuildSharedList($table,$values)
       {
       $query=$this->BuildSqlInsert("sharing",$values);
       $this->Query($query);
       }
       function ShowSharedList($selections=array(),$id)
       {
               $query=$this->BuildSqlSelect(array(array("sharing"),$selections,array(),"","id = '" . $id ."' ",array()));
       return $this->Query($query);
   }
   function UpdateSharedList($table,$values,$whereCondition)
   {
           $query=$this->BuildSqlUpdate("sharing",$values,$whereCondition);
           $this->Query($query);
                               }
                               function DeleteSharedList($table,$whereCondition)
                               {
                                       $query=$this->BuildSqlDelete("sharing",$whereCondition);
                                       $this->Query($query);
                               }
                       }
       ?>

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
               $query=$this->BuildSqlSelect(array(array("sharing"),$selections,array(),"","id = '" . $id ."' ",array()));
       return $this->Query($query);
   }
   function EditShare($values,$id)
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

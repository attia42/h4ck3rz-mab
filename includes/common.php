<?php

// ----------------------------------------------------------------------
// Filename:   				common.php
// Original Author(s):		<clever.netman>Maher M. Seif [CAT-HACKERS MyAdressBook Project] <clever.nemtman@gmail.com>
// Purpose:   				Common functions
// ----------------------------------------------------------------------


/**
  * @return [bool] true or false
  * @param String $s input string/int to check if empty
           Bool $include_whitespace input bool to control whitespace
  * @desc Determine whether a variable is not empty
  * @Maher Seif
  **/
function check_not_empty( $s, $include_whitespace = false) {
    if(is_array($s))
    {
    	return (!empty($s));
    }
    else
    {
    	if ( $include_whitespace ) {
        $s = trim( $s );
    	}
    
    return( isset( $s ) && strlen( $s ) );
    
    }
    
}

function getPageUrl() {
 $pageURL = 'http';

 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

 function urlSetGet($url,$key,$value)
		{
			
			//$replaceVia = $value=="" ? "" : $key."=".$value;
			$replaceVia = $key."=".$value;

			$position = strpos($url , "?{$key}=");
			if(!is_numeric( $position))
			{
				
				$position = strpos($url , "&{$key}=");
				
			}
			
			if(!is_numeric( $position))
			{
				
				$url .= is_numeric(strpos($url , "?")) ? "&".$replaceVia : "?".$replaceVia;
				
				return $url;
				
			}
			
			
			$position += $url[$position]=='?' ? 1 : 0 ;
			
			$count = 0;
			for($i=$position ; $i < strlen($url); $i++)
			{
				
				
				if( $url[$position] = '&'  )
				{
					$count+=1;
				}
				else
				{
					break;
					
				}
				
				
			}
			
				$leftSub = substr($url, 0,$position);
				$leftSub .= $leftSub[strlen($leftSub)-1]!="?" ? "&" : "";
				
				$rightSub = substr($url, $position+$count,strlen($url));
				
				$url = $leftSub.$replaceVia.$rightSub;
				
				
			return $url;
			
		}
		
		function CustomSearch($a, $b)
		{
         return strcasecmp($a[1], $b[1]); 
		}

?>

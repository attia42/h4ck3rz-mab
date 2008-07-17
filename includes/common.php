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
    if ( $include_whitespace ) {
        $s = trim( $s );
    }
    
    return( isset( $s ) && strlen( $s ) );
}

<?php


function old($field_name) {
  	if(isset($_SESSION['old'][$field_name])) {
	    $old_value = $_SESSION['old'][$field_name];
	    unset($_SESSION['old'][$field_name]);
	    return $old_value;
  	}
  	if($_SERVER['REQUEST_METHOD'] === 'POST') {
    	$_SESSION['old'] = $_POST;
	    if(isset($_POST[$field_name])) {
	      	return $_POST[$field_name];
	    }
 	}
  	return '';
}
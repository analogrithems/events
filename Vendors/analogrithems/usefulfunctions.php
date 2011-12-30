<?php

/*
 * This is a collection of helpful functions I've discoverd over the years
 */


	function json_encode_jsfunc($input=array(), $funcs=array(), $level=0) {
	  foreach($input as $key=>$value) {
		  if (is_array($value)) {
		      $ret = json_encode_jsfunc($value, $funcs, 1); 
		      $input[$key]=$ret[0]; 
		      $funcs=$ret[1]; 
		  }else {
		      if (substr($value,0,9)=='function(') {
			  $func_key="#".uniqid()."#"; 
			  $funcs[$func_key]=$value; 
			  $input[$key]=$func_key; 
			 } 
		     } 
	  } 
	  if ($level==1){ 
	      return array($input, $funcs); 
	  }else {
	      $input_json = json_encode($input); 
	      foreach($funcs as $key=>$value) {
		      $input_json = str_replace('"'.$key.'"', $value, $input_json); 
		} 
	      return $input_json; 
	  } 
	} 

	function isGood(&$var){
		if(isset($var) && !empty($var)){
			return true;
		}else{
			return false;
		}
	}
?>

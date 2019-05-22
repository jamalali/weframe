<?php

function camelToCapitalised($value) {
	
	$value = json_encode($value);
	
	$parts = preg_split('/(?=[A-Z])/', $value);
	
	$value = implode(' ', $parts);
	
	$value = str_replace('"', '', $value);
	
	return ucwords($value);
}
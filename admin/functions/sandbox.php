<?php
function selected($value1, $value2, $return){
	if($value1 == $value2){
		echo $return;
	}
}
function file_edit($dir, $contents){
	$parts = explode('/', $dir);
	$file = array_pop($parts);
	$dir = '';
	foreach($parts as $part)
		if(!is_dir($dir .= "/$part")) mkdir($dir);
	file_put_contents("$dir/$file", $contents, FILE_APPEND);
}
function file_create($dir, $contents){
	$parts = explode('/', $dir);
	$file = array_pop($parts);
	$dir = '';
	foreach($parts as $part)
		if(!is_dir($dir .= "/$part")) mkdir($dir);
	file_put_contents("$dir/$file", $contents);
}
?>
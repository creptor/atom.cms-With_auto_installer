<?php
include ("functions.php");

//Check server settings (to see if it can install)
$mysql_version=find_SQL_Version();
if(version_compare(PHP_VERSION,'5.3.10','>')){
	$val['php']='success';
	$php='Ok';
}else{
	$val['php']='warning';
	$error=true;
	$php='Too old';
}        
if($mysql_version<5){
	if($mysql_version==-1){
		$val['sql']='success';
		$mysql="will be checked";
	}else{
		$val['sql']='warning';
		$error=true;
		$mysql="Too old";
	}
}
if(is_writable('../dbconnection.php')||(!file_exists('../dbconnection.php') && is_writable('../'))){
	$val['file']='success';
	$dbfile='Ok';
}else{
	$val['file']='warning';
	$error=true;
	$dbfile='Denied';
}
if(function_exists('json_encode') && function_exists('json_decode')){
	$val['json']='success';
	$json='Enabled';
}else{
	$val['json']='warning';
	$error=true;
	$json='Disabled';
}
if(function_exists('parse_ini_file')){
	$val['ini']='success';
	$ini='Enabled';
}else{
	$val['ini']='warning';
	$error=true;
	$ini='Disabled';
}
if(function_exists('mail')){
	$val['mail']='success';
	$mail='Enabled';
}else{
	$val['mail']='warning';
	$error=true;
	$mail='Disabled';
}
$_SESSION['try']=1;
if(!empty($_SESSION['try'])){
	$val['session']='success';
	$session='Enabled';
}else{
	$val['session']='warning';
	$error=true;
	$session='Disabled';
}
if(isset($error)){
	$type='error';
}else{
	$type='success';
}
$array=array('type'=>$type);
$array['php']=array('val'=>$php,'text'=>'Version of PHP >= 5.3.10','class'=>$val['php']);
$array['mysql']=array('val'=>$mysql,'text'=>'Database Support','class'=>$val['sql']);
$array['dbfile']=array('val'=>$dbfile,'text'=>'dbconnection.php Writeable','class'=>$val['file']);
$array['ini']=array('val'=>$ini,'text'=>'INI Parser Support','class'=>$val['ini']);
$array['json']=array('val'=>$json,'text'=>'JSON Support','class'=>$val['json']);
$array['mail']=array('val'=>$mail,'text'=>'Mail Support','class'=>$val['mail']);
$array['session']=array('val'=>$session,'text'=>'Session Support','class'=>$val['session']);
$output=json_encode($array);
echo $output;
?>
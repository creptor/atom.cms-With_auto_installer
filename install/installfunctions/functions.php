<?php
function prepare_fetch($val, $opt){
	if($opt!=NULL){
		if($opt=="i"){if(!$data=filter_var($val, FILTER_VALIDATE_INT)){$data['error']='non-valid number.';}}
		if($opt=="s"){if(!$data=filter_var($val, FILTER_SANITIZE_STRING)){$data['error']='non-valid string.';}}
		if($opt=="m"){if(!$data=filter_var($val, FILTER_VALIDATE_EMAIL)){$data['error']='non-valid email';}}
	}else{
		die('error');
	}
	return $data;
}
function write_ini_file($assoc_arr, $path, $has_sections=FALSE){ 
    $content=""; 
    if($has_sections){ 
        foreach($assoc_arr as $key=>$elem){ 
            $content .= "[".$key."]\n"; 
            foreach($elem as $key2=>$elem2){ 
                if(is_array($elem2)){ 
                    for($i=0;$i<count($elem2);$i++){ 
                        $content .= $key2."[] = \"".$elem2[$i]."\"\n"; 
                    } 
                } 
                else if($elem2=="")$content.=$key2." = \n"; 
                else $content.=$key2." = \"".$elem2."\"\n"; 
            } 
        } 
    }else{ 
        foreach($assoc_arr as $key=>$elem){ 
            if(is_array($elem)){ 
                for($i=0;$i<count($elem);$i++){ 
                    $content.=$key."[] = \"".$elem[$i]."\"\n"; 
                } 
            } 
            else if($elem=="")$content.=$key." = \n"; 
            else $content.=$key." = \"".$elem."\"\n"; 
        } 
    }
    if(!$handle=fopen($path,'w')){
		return false;
	}
    $success=fwrite($handle, $content);
    fclose($handle);
    return $success; 
}
function stripslashes_deep($value){
	if(is_array($value)){
		$value=array_map('stripslashes_deep',$value);
	}elseif(is_object($value)){
		$vars=get_object_vars($value);
		foreach($vars as $key=>$data){
			$value->{$key}=stripslashes_deep( $data );
		}
	} elseif(is_string($value)){
		$value=stripslashes($value);
	}
	return $value;
}
function find_SQL_Version(){ 
	$output = shell_exec('mysql -V');    
	preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version); 
	return @$version[0]?$version[0]:-1; 
}
function deleteDir($path){
    if(empty($path)){ 
        return false;
    }
    return is_file($path) ? @unlink($path) : array_map(__FUNCTION__, glob($path.'/*')) == @rmdir($path);
}
?>
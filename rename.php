<?php
$dir = "images";
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    $oldname = $filename;
	$newname = str_replace("-","_",$oldname);
	if($oldname!=$newname)
	{
		copy($dir."/".$oldname,$dir."/".$newname);
		unlink($dir."/".$oldname);
	}
	
}
?>
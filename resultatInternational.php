<?php 
	$homepage=file_get_contents("http://www.promosport.sport.tn/index.php?rid=17");
	$xml="";
	$myFile="XML/resultatInternational.xml";
	//$homepage = nl2br($homepage);
	$homepage=strstr($homepage,"<!-- fin ajout 2 -->");
	$homepage=strstr($homepage,"noi11n");
	$homepage=strstr($homepage,"</table>",true);
	$homepage=substr($homepage,9,strlen($homepage));
	$homepage =strip_tags($homepage);
	$homepage=str_replace("            ","*",$homepage);
	$homepage=str_replace("\n","*",$homepage);
	// $homepage=str_replace("\n","",$homepage);
	// $homepage=str_replace("xxyayaxx","",$homepage);
	// $homepage=str_replace("<br>","",$homepage);
	// $homepage=str_replace('tdalign',"",$homepage);
	
	// $homepage=str_replace(" ","",$homepage);
	$table = explode("*",$homepage);
	foreach ($table as &$value) {
		$value = trim($value);
	}
	$table = array_filter($table);
	$table = array_values($table);
	// var_dump($table);
	$xml.="<collection>\n";
	for($i=0;$i<sizeof($table);$i=$i+4)
	{
		$xml.="\t<result>\n";
			$xml.="\t\t<number>".$table[$i]."</number>\n" ;
			$xml.="\t\t<team1>".$table[$i+1]."</team1>\n" ;
			$xml.="\t\t<team2>".$table[$i+2]."</team2>\n";
			$xml.="\t\t<resultMatch>".$table[$i+3]."</resultMatch>\n" ;
		$xml.="\t</result>\n";
	}
	$xml.="</collection>";
	//var_dump(array_filter($table));
	// echo $homepage;
	
	$fh=fopen($myFile, "w");
    fwrite($fh, utf8_encode ($xml));
	fclose($fh);
?>

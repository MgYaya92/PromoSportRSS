<?php 
	$xml="<rss version='2.0'>\n";
	$myFile="XML/prices.xml";
	
	// PRICES NATIONAL
	$homepage=file_get_contents("http://www.promosport.sport.tn/index.php?rid=31");
	$homepage=strstr($homepage,'bgcolor="#00318C"');
	$homepage=strstr($homepage,"</table>",true);
	$homepage=substr($homepage,9,strlen($homepage));
	$homepage = nl2br($homepage);
	$homepage =strip_tags($homepage);
	$homepage=str_replace("                            ","!!!!!!!!",$homepage);
	$table = explode("!!!!!!!!",$homepage);
	foreach ($table as $value) {
		$value = trim($value);
	}
	unset($table[0]);unset($table[1]);unset($table[2]);unset($table[3]);unset($table[5]);unset($table[7]);unset($table[9]);
	$table = array_values($table);
	// END PRICES NATIONAL
	
	// PRICES INTERNATIONAL
	$homepage=file_get_contents("http://www.promosport.sport.tn/index.php?rid=32");
	$homepage=strstr($homepage,'bgcolor="#00318C"');
	$homepage=strstr($homepage,"</table>",true);
	$homepage=substr($homepage,9,strlen($homepage));
	$homepage =strip_tags($homepage);
	$homepage = nl2br($homepage);
	// $homepage=str_replace("          ","!!!!!!!!",$homepage);
	// $table1 = explode("!!!!!!!!",$homepage);
	$table1 = explode("<br />",$homepage);
	for($i=0;$i<sizeof($table1);$i++)
	{
		$table1[$i]=trim($table1[$i]);
		if(strlen($table1[$i])==0)unset($table1[$i]);
	}
	// var_dump($table1);
	// unset($table1[0]);unset($table1[1]);unset($table1[2]);unset($table1[3]);unset($table1[5]);unset($table1[7]);unset($table1[9]);
	// $table1 = array_values($table1);
	// END PRICES INTERNATIONAL
	
	// var_dump($table);
	// var_dump($table1);
	
	
		$xml.="<prices>\n";
			$xml.="\t<national>\n";
				$xml.="\t\t<Premium>".trim($table[0])."</Premium>\n" ;
				$xml.="\t\t<Wnewsletters>".trim($table[1])."</Wnewsletters>\n" ;
				$xml.="\t\t<Wcolumns>".trim($table[2])."</Wcolumns>\n";
				$xml.="\t\t<Weach>".trim($table[3])."</Weach>\n" ;
			$xml.="\t</national>\n";
			$xml.="\t<international>\n";
				$xml.="\t\t<Premium>".$table1[7]."</Premium>\n" ;
				$xml.="\t\t<Wnewsletters>".$table1[11]."</Wnewsletters>\n" ;
				$xml.="\t\t<Wcolumns>".$table1[15]."</Wcolumns>\n";
				$xml.="\t\t<Weach>".trim($table1[19])."</Weach>\n" ;
			$xml.="\t</international>\n";
		$xml.="</prices>\n";
	$xml.="</rss>";
	echo $xml;
	
	$fh=fopen($myFile, "w");
    fwrite($fh, utf8_encode ($xml));
	fclose($fh);
	header("location:".$myFile);
?>

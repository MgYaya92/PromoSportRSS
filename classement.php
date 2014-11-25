<?php
	$myFile = "XML/classement.xml";
	$url = "http://www.kawarji.com/classement-ligue1-tunisie.html";
	$myFileXML = "<rss version='2.0'>\n";
	
	$homepage =file_get_contents($url);
	$homepage =strstr($homepage,'class="classement"');
	$homepage =strstr($homepage,"</div",true);
	$homepage =strip_tags($homepage);
	$homepage =substr($homepage,120,strlen($homepage));
	$homepage =nl2br($homepage);
	$table = explode("<br />",$homepage);
	for($i=0;$i<sizeof($table);$i++)
	{
		$table[$i]=trim($table[$i]);
		if(strlen(trim($table[$i]))==0)unset($table[$i]);
	}
	$table = array_values($table);
	unset($table[140]);unset($table[141]);unset($table[142]);unset($table[153]);unset($table[154]);unset($table[155]);unset($table[166]);
	$table = array_values($table);
	// print_r($table);
	
	// XML processing
	$myFileXML .="\t<classement>\n";
	for($i=0;$i<sizeof($table)-10;$i=$i+10)
		{
			if($table[$i]!="")
			{
				$myFileXML .= "\t\t<team>\n";
					$myFileXML .= "\t\t\t<rang>".trim($table[$i])."</rang>\n";
					$myFileXML .= "\t\t\t<name>".trim($table[$i+1])."</name>\n";
					$myFileXML .= "\t\t\t<pts>".trim($table[$i+2])."</pts>\n";
					$myFileXML .= "\t\t\t<played>".trim($table[$i+3])."</played>\n";
					$myFileXML .= "\t\t\t<wins>".trim($table[$i+4])."</wins>\n";
					$myFileXML .= "\t\t\t<draws>".trim($table[$i+5])."</draws>\n";
					$myFileXML .= "\t\t\t<loses>".trim($table[$i+6])."</loses>\n";
					$myFileXML .= "\t\t\t<goals>".trim($table[$i+7])."</goals>\n";
					$myFileXML .= "\t\t\t<Cgoals>".trim($table[$i+8])."</Cgoals>\n";
					$myFileXML .= "\t\t\t<diff>".trim($table[$i+9])."</diff>\n";
				$myFileXML .= "\t\t</team>\n";
			}
		}
	$myFileXML .="\t</classement>\n";
	$myFileXML .="</rss>";
	// echo $myFileXML;
	$fh=fopen($myFile, "w");
    fwrite($fh, $myFileXML);
	fclose($fh);
	//end XML processing
?>
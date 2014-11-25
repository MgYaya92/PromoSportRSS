<?php
	$myFile = "XML/resultatInternationalALL.xml";
	$leagues = ["england","spain","france","italy","germany"];
	$myFileXML = "<rss version='2.0'>\n";
	
	foreach($leagues as $league)
	{
		$url = "http://www.forebet.com/en/football-tips-and-predictions-for-".$league.".html?task=results";
		$homepage =file_get_contents($url);
		$homepage =strstr($homepage,'clear:both;padding-top:7px;');
		$homepage =strstr($homepage,"</table",true);
		$homepage =str_replace('<a','<a>',$homepage);
		$homepage =str_replace("' class='odds'>",'&',$homepage);
		$homepage =str_replace("href='",'',$homepage);
		$homepage =strip_tags($homepage);
		$homepage =substr($homepage,30,strlen($homepage));
		$homepage =nl2br($homepage);
		$table = explode("<br />",$homepage);
		// echo $homepage;
	
		$myFileXML .="\t<league nation='".$league."'>\n";
		$i=0;
		// echo $myFileXML;
		// echo sizeof($table);
		while($i<sizeof($table))
		{
			if(preg_match("/\d\d.\d\d.\d\d/",$table[$i]))
			{
				$myFileXML .= "\t\t<day date='".trim($table[$i])."'>\n";
				$i++;
				while(!preg_match("/\d\d.\d\d.\d\d/",$table[$i]))
				{
					if(strlen(trim($table[$i]))==0)$i++;
					else 
					{
						$myFileXML .= "\t\t\t<match>\n";
							$myFileXML .= "\t\t\t\t<time>".trim($table[$i])."</time>\n";
							$i++;
							$myFileXML .= "\t\t\t\t<hteam link='".trim(substr($table[$i],0,strpos($table[$i],"&")))."'>".trim(substr($table[$i],strpos($table[$i],"&")+1,strlen($table[$i])))."</hteam>\n";
							$i++;
							$myFileXML .= "\t\t\t\t<score>".trim($table[$i])."</score>\n";
							$i++;
							$myFileXML .= "\t\t\t\t<ateam link='".trim(substr($table[$i],0,strpos($table[$i],"&")))."'>".trim(substr($table[$i],strpos($table[$i],"&")+1,strlen($table[$i])))."</ateam>\n";
							$i++;
						$myFileXML .= "\t\t\t</match>\n";
					}
					if($i>=sizeof($table))break;
				}
				$myFileXML .= "\t\t</day>\n";
			}else $i++;
		}
		$myFileXML .="\t</league>\n";
	}
	$myFileXML .="</rss>";
	// echo $myFileXML;
	echo "Parsing done.";
	$fh=fopen($myFile, "w");
    fwrite($fh,$myFileXML);
	fclose($fh);
?>
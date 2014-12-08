<?php
	$myFile = "XML/classementInternational.xml";
	$myFileXML = "<rss version='2.0'>\n";
	
	$leagues[0]["name"]="England";
	$leagues[0]["lien"]="http://www.forebet.com/en/football-tips-and-predictions-for-england/premier-league.html?task=standing";
	$leagues[1]["name"]="Spain";
	$leagues[1]["lien"]="http://www.forebet.com/en/football-tips-and-predictions-for-spain.html?league=5&task=standing";
	$leagues[2]["name"]="Germany";
	$leagues[2]["lien"]="http://www.forebet.com/en/football-tips-and-predictions-for-germany.html?league=7&task=standing";
	$leagues[3]["name"]="France";
	$leagues[3]["lien"]="http://www.forebet.com/en/football-tips-and-predictions-for-france.html?league=8&task=standing";
	$leagues[4]["name"]="Italy";
	$leagues[4]["lien"]="http://www.forebet.com/en/football-tips-and-predictions-for-italy.html?league=6&task=standing";
	
	
	foreach($leagues as $league)
	{
		$homepage=file_get_contents($league["lien"]);
		$homepage=strstr($homepage,"</h5>");
		$homepage=strstr($homepage,"color0");
		$homepage=strstr($homepage,'</table>',true);
		$homepage=substr($homepage,57,strlen($homepage));
		$homepage =strip_tags($homepage);
		$homepage = nl2br($homepage);
		$homepage=str_replace(".","",$homepage);
		$table = explode("<br />",$homepage);
		for($i=0;$i<sizeof($table);$i++)
		{
			$table[$i]=trim($table[$i]);
			if(strlen($table[$i])==0 || $table[$i]=="check")unset($table[$i]);
		}
		$table = array_values($table);
		// var_dump($table);
		$myFileXML .="\t<league nation='".$league["name"]."'>\n";
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
		$myFileXML .="\t</league>\n";
	}
	$myFileXML .="</rss>";
	// echo $myFileXML;
	echo "Parsing done.";
	$fh=fopen($myFile, "w");
    fwrite($fh,$myFileXML);
	fclose($fh);
?>
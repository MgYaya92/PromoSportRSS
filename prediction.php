<?php
	$myFile = "XML/prediction.xml";
	$leagues = ["england","spain","france","italy","germany"];
	$myFileXML = "<rss version='2.0'>\n";
	
	foreach($leagues as $league)
	{
		$url = "http://www.forebet.com/en/football-tips-and-predictions-for-".$league.".html";
		$homepage=file_get_contents($url);
		$homepage=strstr($homepage,"schema");
		$homepage=strstr($homepage,'width="100%"',true);
		$homepage=substr($homepage,77,strlen($homepage));
		$homepage =strip_tags($homepage);
		$homepage = nl2br($homepage);
		$homepage=str_replace("&deg;","°",$homepage);
		
		$table = explode("<br />",$homepage);
		for($i=0;$i<sizeof($table);$i++)
		{
			$table[$i]=trim($table[$i]);
			if(strlen($table[$i])==0 || $table[$i]=="check")unset($table[$i]);
		}
		//var_dump($table);
		$table = array_values($table);
		for($i=0;$i<12;$i++)
		{
			unset($table[$i]);
		}
		$table = array_values($table);
		$dateRound = $table[0];
		unset($table[0]);
		$table = array_values($table);
		unset($table[90]);
		$table = array_values($table);
		// var_dump($table);
		$myFileXML .="\t<league nation='".$league."'>\n";
		for($i=0;$i<sizeof($table);$i=$i+9)
		{
			if(preg_match("/Round/",$table[$i]))break;
			if($table[$i]!="")
			{
				$myFileXML .= "\t\t<Match>\n";
					$myFileXML .= "\t\t\t<HomeTeam>".substr($table[$i],0,strpos($table[$i]," -"))."</HomeTeam>\n";
					$myFileXML .= "\t\t\t<AwayTeam>".substr($table[$i],strpos($table[$i],"- ")+2,strlen($table[$i]))."</AwayTeam>\n";
					$myFileXML .= "\t\t\t<Date>".substr($table[$i+1],0,16)."</Date>\n";
					$myFileXML .= "\t\t\t<Prediction1>".substr($table[$i+1],strlen($table[$i+1])-6,2)."</Prediction1>\n";
					$myFileXML .= "\t\t\t<PredictionX>".substr($table[$i+1],strlen($table[$i+1])-4,2)."</PredictionX>\n";
					$myFileXML .= "\t\t\t<Prediction2>".substr($table[$i+1],strlen($table[$i+1])-2,2)."</Prediction2>\n";
					$myFileXML .= "\t\t\t<PredictionWinner>".$table[$i+2]."</PredictionWinner>\n";
					$myFileXML .= "\t\t\t<CorrectScore>".$table[$i+3]."</CorrectScore>\n";
					$myFileXML .= "\t\t\t<AvgGoals>".$table[$i+4]."</AvgGoals>\n";
					$myFileXML .= "\t\t\t<Weather>".$table[$i+5]."</Weather>\n";
					$myFileXML .= "\t\t\t<FinalScore>".$table[$i+8]."</FinalScore>\n";
				$myFileXML .= "\t\t</Match>\n";
			}
		}
		$myFileXML .="\t</league>\n";
	}
	$myFileXML .="</rss>";
	echo "Parsing done.";
	$fh=fopen($myFile, "w");
    fwrite($fh,$myFileXML);
	fclose($fh);
?>
<?php
	if(isset($_GET["link"]))
	{
		if(strlen($_GET["link"])==0){echo "empty link.";exit();}
	}else {echo "you should put link variable.";exit();}
	$myFile = "XML/teamInfo/".date("YmdH").trim(strrchr($_GET["link"],"/"),"/").".xml";
	if(file_exists($myFile))
	{
		//$homepage=file_get_contents($myFile);
		//echo $homepage;
		header("location:".$myFile);
	}else
	{
		require_once("simple_html_dom.php");
		$url 		= $_GET["link"];
		$opts = array(
			'http'=>array(
			'method'=>"GET",
			'header'=>"Accept-language: en\r\n" )
		);
		$context = stream_context_create($opts);
		$homepage =file_get_contents($url ,false, $context);
		$myFileXML 	= "<rss version='2.0'>\n";
		$html		=str_get_html($homepage);
		
		$teamName 		= trim($html->find('#team_main_data',0)->find("li",0)->plaintext);
		$teamLocation 	= trim(substr(trim($html->find('#team_main_data',0)->find("li",1)->plaintext),strpos(trim($html->find('#team_main_data',0)->find("li",1)->plaintext)," "),strlen(trim($html->find('#team_main_data',0)->find("li",1)->plaintext))));
		$teamWebsite	= trim($html->find('#team_main_data',0)->find("li",2)->children(0)->href);
		$nextMatch1X2	= trim($html->find(".tpredict",0)->plaintext);
		$nextMatchAVG	= trim($html->find(".tpredict",1)->plaintext);
		$nextMatchSCORE	= trim($html->find(".tpredict",2)->plaintext);
		$nextMatchHour  = trim($html->find(".inpage_match_hour",0)->plaintext);
		$myFileXML.="\t<team>\n";
		//INFO
			$myFileXML.="\t\t<info>\n";
				$myFileXML.="\t\t\t<teamName>".$teamName."</teamName>\n";
				$myFileXML.="\t\t\t<teamLocation>".$teamLocation."</teamLocation>\n";
				$myFileXML.="\t\t\t<teamWebsite>".$teamWebsite."</teamWebsite>\n";
			$myFileXML.="\t\t</info>\n";
		//END INFO
		
		//NEXT MATCH
			$myFileXML.="\t\t<nextmatch>\n";
				$myFileXML.="\t\t\t<nextMatch1X2>".$nextMatch1X2."</nextMatch1X2>\n";
				$myFileXML.="\t\t\t<nextMatchAVG>".$nextMatchAVG."</nextMatchAVG>\n";
				$myFileXML.="\t\t\t<nextMatchSCORE>".$nextMatchSCORE."</nextMatchSCORE>\n";
				$myFileXML.="\t\t\t<nextMatchHOUR>".$nextMatchHour."</nextMatchHOUR>\n";
			$myFileXML.="\t\t</nextmatch>\n";
		//END NEXT MATCH
		
		//PLAYED GAMES
			$myFileXML.="\t\t<playedgames>\n";
			foreach($html->find("#playedgames",0)->find("tr") as $line)
			{
				$myFileXML.= "\t\t\t<match>\n";
					$myFileXML.= "\t\t\t\t<DateM>".trim($line->find("td",0)->plaintext)."</DateM>\n";
					$myFileXML.= "\t\t\t\t<TeamA>".trim($line->find("td",1)->plaintext)."</TeamA>\n";
					$myFileXML.= "\t\t\t\t<Score>".trim($line->find("td",2)->plaintext)."</Score>\n";
					$myFileXML.= "\t\t\t\t<TeamB>".trim($line->find("td",3)->plaintext)."</TeamB>\n";
				$myFileXML.= "\t\t\t</match>\n";
			}
			$myFileXML.="\t\t</playedgames>\n";
		//PLAYED GAMES
		
		//HOME MATCHS
			$myFileXML.="\t\t<homematchs>\n";
			foreach($html->find("#playedgames",1)->find("tr") as $line)
			{
				$myFileXML.= "\t\t\t<match>\n";
					$myFileXML.= "\t\t\t\t<DateM>".trim($line->find("td",0)->plaintext)."</DateM>\n";
					$myFileXML.= "\t\t\t\t<TeamA>".trim($line->find("td",1)->plaintext)."</TeamA>\n";
					$myFileXML.= "\t\t\t\t<Score>".trim($line->find("td",2)->plaintext)."</Score>\n";
					$myFileXML.= "\t\t\t\t<TeamB>".trim($line->find("td",3)->plaintext)."</TeamB>\n";
				$myFileXML.= "\t\t\t</match>\n";
			}
			$myFileXML.="\t\t</homematchs>\n";
		//END HOME MATCHS
		
		//AWAY MATCHS
			$myFileXML.="\t\t<awaymatchs>\n";
			foreach($html->find("#playedgames",2)->find("tr") as $line)
			{
				$myFileXML.= "\t\t\t<match>\n";
					$myFileXML.= "\t\t\t\t<DateM>".trim($line->find("td",0)->plaintext)."</DateM>\n";
					$myFileXML.= "\t\t\t\t<TeamA>".trim($line->find("td",1)->plaintext)."</TeamA>\n";
					$myFileXML.= "\t\t\t\t<Score>".trim($line->find("td",2)->plaintext)."</Score>\n";
					$myFileXML.= "\t\t\t\t<TeamB>".trim($line->find("td",3)->plaintext)."</TeamB>\n";
				$myFileXML.= "\t\t\t</match>\n";
			}
			$myFileXML.="\t\t</awaymatchs>\n";
		//END AWAY MATCHS
		
		//NEXT 6 MATCHS
			$myFileXML.="\t\t<nextsixmatchs>\n";
			foreach($html->find("#playedgames",3)->find("tr") as $line)
			{
				$myFileXML.= "\t\t\t<match>\n";
					$nextM = $line->find("td",0)->plaintext;
					$myFileXML.= "\t\t\t\t<DateM>".trim(substr($nextM,0,strpos($nextM," ")))."</DateM>\n";
					$myFileXML.= "\t\t\t\t<TeamA>".trim(substr($nextM,10,strpos($nextM,"-")-10))."</TeamA>\n";
					$myFileXML.= "\t\t\t\t<TeamB>".trim(substr($nextM,strpos($nextM,"-")+2,strlen($nextM)))."</TeamB>\n";
				$myFileXML.= "\t\t\t</match>\n";
			}
			$myFileXML.="\t\t</nextsixmatchs>\n";
		//END NEXT 6 MATCHS
		$myFileXML.="\t</team>\n";
		$myFileXML.= "</rss>";
		$fh=fopen($myFile, "w");
		fwrite($fh,$myFileXML);
		fclose($fh);
		header("location:".$myFile);
	}	
?>
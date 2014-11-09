<?php
	$myFile = "XML/prediction.xml";
	$myFileXML = "";
	$url = "http://www.matchendirect.fr/rss/pronostic.xml";
	$xml = simplexml_load_file($url);
	$items = $xml->channel->item;
	
	$myFileXML .="<rss version='2.0'>\n";
	$myFileXML .="\t<prediction>\n";
	foreach($items as $item )
	{
		$title	= substr($item->title,10,strlen($item->title));
		$result = substr($item->description,18,1);
		if ( $result == "N") $result = "X";
		$date	= $item->pubDate;
		
		$myFileXML .= "\t\t<match>\n";
		$myFileXML .= "\t\t\t<title>".$title."</title>\n";
		$myFileXML .= "\t\t\t<result>".$result."</result>\n";
		$myFileXML .= "\t\t\t<date>".$date."</date>\n";
		$myFileXML .= "\t\t</match>\n";
	}
	$myFileXML .="\t</prediction>\n";
	$myFileXML .="</rss>";
	
	$fh=fopen($myFile, "w");
    fwrite($fh,$myFileXML);
	fclose($fh);
?>
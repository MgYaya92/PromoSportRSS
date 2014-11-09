<?php
	$homepage=file_get_contents("XML/outlets.html");
	$xml='<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>results</title>
		<link rel="stylesheet" href="app/stylesheets/outlets.css" />
		<link rel="stylesheet" href="app/stylesheets/aboutPanel.css" />
		<link rel="stylesheet" href="app/stylesheets/controlPanel.css" />
		<script src="app/javascript/jquery.js"></script>
		<script src="app/javascript/outlets.js"></script>
	</head>
	<body>
		<p id="xmlZone" style="color:black;display:none;"></p>
		<input id="area" type="hidden" value="menu" />
		<div id="transition"></div>
		<div id="aboutContainer">
				<h1>About</h1>
				<h2>Developped By : </h2>
				<div class="developper">
					<img src="images/yahia.png" />
					<span>YAHIA MGARRECH</span>
				</div>
				<div class="developper">
					<img src="images/ahmed.jpg" />
					<span>AHMED ABD MOULA</span>
				</div>
		</div>
		<div id="container">
			<div id="in-container">
				<div id="top">
					<h2>OUTLETS</h2>
				</div>
				<div id="left">';
	$myFile="outletsGenerated.html";
	
	$homepage=strstr($homepage,'id="ewlistmain"');
	$homepage=strstr($homepage,"</table>",true);
	$homepage=substr($homepage,32,strlen($homepage));
	//$homepage =strip_tags($homepage);
	//echo $homepage;
	$table = explode("<span>",$homepage);
	foreach ($table as &$value) {
		$value = trim(strip_tags($value));
	}
	for($i=0;$i<9;$i++)unset($table[$i]); //delete header
	
	// foreach ($table as &$value) {
		// echo $value."<br />";
	// }
	$xml.="<h3>Outlet Adresses</h3>";
	for($i=9;$i<sizeof($table);$i=$i+6)
	{
		$xml.='<div class="item"><span>'.$table[$i+4].'</span>';
			$xml.='<input class="itemId" type="hidden" value="'.$table[$i].'"/>' ;
			$xml.='<input class="itemZone" type="hidden" value="'.$table[$i+1].'"/>' ;
			$xml.='<input class="itemStatus" type="hidden" value="'.$table[$i+2].'"/>' ;
			$xml.='<input class="itemNumber" type="hidden" value="'.$table[$i+3].'"/>' ;
			$xml.='<input class="itemAddress" type="hidden" value="'.$table[$i+4].'"/>' ;
			$xml.='<input class="itemCity" type="hidden" value="'.$table[$i+5].'"/>' ;
		$xml.="</div>";
	}
	$xml.='</div>
				<div id="right">
					<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d6387.031545878194!2d10.190173870532089!3d36.83012179525866!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2sfr!4v1415131455028" width="100%" height="60%" frameborder="0" style="border:0"></iframe>
					<table cellspacing="0" id="outletInfoTable" >
						<tr>
							<td>Id</td>
							<td>:</td>
							<td></td>
						</tr>
						<tr>
							<td>Zone</td>
							<td>:</td>
							<td></td>
						</tr>
						<tr>
							<td>Status</td>
							<td>:</td>
							<td></td>
						</tr>
						<tr>
							<td>Number</td>
							<td>:</td>
							<td></td>
						</tr>
						<tr>
							<td>City</td>
							<td>:</td>
							<td>qsqdsdsqd</td>
						</tr>
						<tr>
							<td>Address</td>
							<td>:</td>
							<td></td>
						</tr>					
					</table>
				</div>
			</div>
		</div>
		<div id="bottomPanel">
			<div class="control">
				<img id="down" src="images/Control/DownButton.png"/>
				<img id="up" src="images/Control/UpButton.png"/>
				<span>: Move </span>
			</div>
			<div class="control">
				<img id="Cleft" src="images/Control/LeftButton.png"/>
				<img id="Cright" src="images/Control/RightButton.png" />
				<span>: Menu </span>
			</div>
			<div class="control">
				<img id="enter" src="images/Control/Focus.png"/>
				<span>: Enter</span>
			</div>
			<div class="control">
				<img id="about" src="images/Control/InfoButton.png"/>
				<span>: About</span>
			</div>
			<div class="control off">
				<img id="return" src="images/Control/Return.png"/>
				<span>: Return</span>
			</div>
			<div class="control">
				<img id="exit" src="images/Control/Exit.png"/>
				<span>: Exit</span>
			</div>
		</div>
	</body>
</html>';
	
	$fh=fopen($myFile, "w");
    fwrite($fh, $xml); //html_entity_decode($xml)
	fclose($fh);
?>
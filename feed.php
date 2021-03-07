<?php

	// HARDCODED CHANNEL DEFAULTS
	$TITLE  = "dukeart/weblog";
	$HOST   = "https://dukeart.netlib.re/weblog";
	$AUTHOR = "duke";
	$TAGS   = ["IT","information","technologies","programming","web","social","science","art"];

	// JSON DATA TREE
	$fn = "data.json";
	$fd = fopen( $fn,"r");
	$items = fread( $fd, filesize($fn) );
	fclose($fd);
	// JSON PARSE
	$items = json_decode($items);
	// JSON OUTPUT: ?json
	if (isset($_GET["json"])) {
		$feeds = array(
		"title" => $TITLE, "author" => $AUTHOR, "keywords" => $TAGS, "items" => []
		);
		foreach ($items as $item) { array_push($feeds["items"],$item); }
		echo json_encode($feeds);
		header('Content-Type:application/json');
		exit;
	}

	// XML FEED GENERATION
	$xml  = new SimpleXMLElement('<rss version="2.0"/>');
	$chan = $xml->addChild('channel');
	$chan->addChild("title",  $TITLE);
	$chan->addChild("host",   $HOST);
	$chan->addChild("link",   $HOST."/feed");
	$chan->addChild("json",   $HOST."/feed?json");
	$chan->addChild("author", $AUTHOR);
	foreach ($items as $item) {
		$xmlitem = $chan->addChild("item");
		$xmlitem->addChild("title",  $item->title);
		$xmlitem->addChild("link",   $HOST."/weblog?title=".implode('-',explode(' ',$item->title)));
		$xmlitem->addChild("guid",   $HOST."/weblog?title=".implode('-',explode(' ',$item->title)));
		$xmlitem->addChild("pubdate", Date(DATE_RFC2822,strtotime($item->pubdate)));
		$xmlitem->addChild("created", Date(DATE_RFC2822,strtotime($item->pubdate)));
		$tags = $xmlitem->addChild("tags");
		foreach ($item->tags as $tag) {
			$tags->addChild("tag",$tag);
		}
	}
	header('Content-Type: text/xml');
	echo $xml->asXML();
?>


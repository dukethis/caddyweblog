<?php
	$item = isset($_GET["title"]) ? $_GET["title"] : null;
	$title = strtr($item," ","-");
	$title = strtr($title,"+","-");
	$author = "duke";

	if ( !file_exists( $title.'.md' )) { header('Location: /'); exit; }

	$fn = "data.json";
	$fd = fopen( $fn,"r");
	$fc = fread( $fd, filesize($fn) );
	fclose($fd);
	$items = json_decode($fc);
	$key = base64_encode($title);
	$item = $items->$key;
	$author = $item->author;
	$pubdate = $item->pubdate;
	$tags = implode(', ', $item->tags);
	$htmltags = '<text>'.implode('</text><text>', $item->tags).'</text>';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"/>
		<meta name="author" content="<?php echo $author; ?>"/>
		<meta name="pubdate" content="<?php echo $pubdate; ?>"/>
		<meta name="keywords" content="weblog, blog, publication<?php echo $tags ? ', '.$tags : null; ?>"/>
		<meta name="viewport" content="width=device-width,initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="blog.css"/>
		<title><?php "weblog/".$title; ?></title>
	</head>
	<body>
		<section class="main">
			<section class="signature">
				<p><?php echo Date('l jS \of F, Y',strtotime($pubdate)); ?></p>
				<p><label>by&nbsp;</label><text><?php echo $author; ?></text></p>
			</section>
			{{ include "/<?php echo $title; ?>.md" | markdown }}
		</section>
		<hr/>
		<section class="foot">
			<p><?php echo $pubdate; ?></p>
			<p><?php echo $htmltags; ?></p>
		</section>
		<section class="link">
			<p><a href="#top">TOP</a></p>
			<p><a href="/weblog">INDEX</a></p>
		</section>
	</body>
</html>

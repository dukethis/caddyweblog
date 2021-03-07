<!DOCTYPE html>
<html>
    <head>
        <title>weblog</title>
        <link rel="stylesheet" type="text/css" href="blog.css"/>
    </head>
    <body>
        <section class="index">
        <h1><a class="index" href="javascript:switch_sort()">WEBLOG INDEX</h1>
        <?php

	$fn = "data.json";
	$fd = fopen( $fn,"r");
	$fc = fread( $fd, filesize($fn) );
	fclose($fd);
	$items = json_decode($fc);
	//usort($items, function($x,$y) { return $x->pubdate < $y->pubdate; });
        foreach ($items as $item) {
		$title = explode(' ',$item->title);
		$title = implode('-',$title);
		$file_path = $title.'.md';
		if (!file_exists( $file_path )) { continue; }
		$date = $item->pubdate;
		echo '<h3 class="item flex row"><a href="/weblog.php?title='.$title.'"><text style="font-size:1rem;font-weight:700;margin-right:30px">'.$date.'</text><text>'.$title.'</text></a></h3>';
        }
        ?>
        </section>
	<section class="feed">
		<a href="/weblog/feed" title="RSS Feed"><img src="https://dukeart.netlib.re/iconeleon?i=rss" width="20"/></a>
		<a href="/weblog/feed?json" title="JSON Feed"><img src="https://dukeart.netlib.re/iconeleon?i=js-square" width="20"/></a>
	</section>
        <script>
            function switch_sort() {
                    var xitem = document.getElementsByTagName("h3")
                    var items = []
                    for (var i=xitem.length-1;i>-1;i--) {
                            items.push( xitem[i] )
                    }
                    for (var i=0;i<xitem.length;i++) {
                            xitem[i].outerHTML = items[i].outerHTML
                    }
            }
        </script>
        </body>
</html>

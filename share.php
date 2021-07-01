<?php
$panoid = $_GET['panoid'];

// http://htmlparsing.com/php.html
# Use the Curl extension to query Google and get back a page of results
$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/';
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$html = curl_exec($ch);
curl_close($ch);

# Create a DOM parser object
$dom = new DOMDocument();

# Parse the HTML from Google.
# The @ before the method call suppresses any warnings that
# loadHTML might throw because of invalid HTML in the page.
@$dom->loadHTML($html);
foreach($dom->getElementsByTagName('li') as $link) {
	# Show the <a href>
	if($link->getAttribute('data-panoid') == $panoid){
		$title_scene = $link->getAttribute('data-share-title');
		$thumbnail_scene = $link->getAttribute('data-share-img');
	}
}

$title_project = $dom->getElementById('sharing')->getAttribute('data-title');
$author = $dom->getElementById('sharing')->getAttribute('data-author');
// $test = $dom->getElementsById('share-title');
// $title = $link->getAttribute('data-share-title');
// $thumbnail =  $url.$link->getAttribute('data-share-img');


//READ XML
// function recursive_array_search($needle,$haystack) {
//     foreach($haystack as $key=>$value) {
//         $current_key=$key;
//         if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
//             return $current_key;
//         }
//     }
//     return false;
// }
// $xmlmessages = 'indexdata/index_core_vr.xml';
// $xmlparser = xml_parser_create();
// // open a file and read data
// $fp = fopen($xmlmessages, 'r');
// $xmlmessages_data = fread($fp, 4096);
// xml_parse_into_struct($xmlparser,$xmlmessages_data,$xmlmessages_values);
// xml_parser_free($xmlparser);
// $xmlmessages_key = recursive_array_search('en_'.$panoid.'_title', $xmlmessages_values);
// $xmlmessages_value = $xmlmessages_values[$xmlmessages_key]['value'];

?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $title_scene ?></title>
		<meta name="description" content="<?php echo $title_project ?>">
		<meta http-equiv="refresh" content="0;URL='<?php echo $url.'#s='.$panoid ?>'" />

        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="<?php echo $title_scene ?>">
        <meta itemprop="description" content="<?php echo $title_project ?>">
        <meta itemprop="image" content="<?php echo $url.$thumbnail_scene ?>">

        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo $title_scene ?>">
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo $url.'share.php?panoid='.$panoid ?>">
        <meta property="og:image" content="<?php echo $url.$thumbnail_scene ?>">
        <meta property="og:description" content="<?php echo $title_project ?>">
        <meta name="generator" content="Panotour">
		<meta name="author" content="<?php echo $author ?>">
		<meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
		<script>
		// window.location.href = "<?php echo $url.'#s='.$panoid ?>";
		</script>
	<body>
	</body>
</html>

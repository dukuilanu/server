<rss version="2.0">
<channel>
  <title>Tropical Storms</title>
  <description>Active tropical cyclones in the Atlantic, Caribbean, and the Gulf of Mexico</description>
<?php

$handle = fopen("http://www.nhc.noaa.gov/index-at.xml", "rb");
$contents = stream_get_contents($handle);
fclose($handle);

$contents = str_replace("nhc:","nhc",$contents);

$xml_object = simplexml_load_string($contents,null,LIBXML_NOCDATA);

$forcast = $xml_object->xpath('channel/item[title="Atlantic Tropical Weather Outlook"]/description');
$forcast_str = $forcast[0][0];

$forcast = explode("<br/>",$forcast_str);

echo "  <item>
    <title>Atlantic Tropical Weather Outlook</title>
    <description>" . trim($forcast[11])  . "</description>
  </item>";

foreach($xml_object->channel->item as $item){
	$cyclone = $item->nhcCyclone->nhcname;
	
	if ($cyclone != "") {
		$name = $cyclone;
		$type = $item->nhcCyclone->nhctype;
		$headline = $item->nhcCyclone->nhcheadline;
		echo "  <item>
    <title>Tropical System</title>
    <description>" . $type . " " . $name . " " . $headline . "</description>
  </item>";
		
	}

}

?>

</channel>
</rss>
<?php header("Content-type: text/xml");
echo '<?xml version = "1.0" encoding = "windows-1251"?>'?>
<rss version = "2.0">
<channel>
<title>Understanding Software</title>
<link><?=base_url()?></link>
<description>Understanding Software</description>
<language>ru</language>

<?php foreach($feeds as $item):?>

<item>
    <title><?=$item['title']?></title>
    <link><?=base_url()?>materials/<?=$item['material_id']?></link>
    <description><?=$item['short_text']?></description>
    <guid><?=base_url()?>materials/<?=$item['material_id']?></guid>
</item>

<?php endforeach;?>

</channel>
</rss>
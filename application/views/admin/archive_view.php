<div id="primaryContentContainer">
    <div id="primaryContent">
        <h2><?="Архів за ".$url_month;?></h2>
        <br/>
        <?php foreach ($archive_result as $item):?>
        <h3><a href="<?=base_url()."materials/$item[material_id]";?>"><?=$item['title'];?></a></h3>
        <?=$item['short_text']; ?>
        <p class="meta"><?=$item['version'];?> &bull; <strong>Дата: </strong><?=$item['date'];?> &bull; <strong>Додав:</strong> <?=$item['author'];?> &bull; <strong>Кількість переглядів:</strong> <?=$item['count_views'];?> &bull; <a href="<?=base_url()."materials/$item[material_id]";?>">Читати далі</a></p>			
        <?php endforeach; ?> 
        <div style="clear: both;">&nbsp;</div>
        <a href="#top">Наверх</a>
    </div>
</div>
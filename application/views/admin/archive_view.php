<div id="primaryContentContainer">
    <div id="primaryContent">
        <h2><?="����� �� ".$url_month;?></h2>
        <br/>
        <?php foreach ($archive_result as $item):?>
        <h3><a href="<?=base_url()."materials/$item[material_id]";?>"><?=$item['title'];?></a></h3>
        <?=$item['short_text']; ?>
        <p class="meta"><?=$item['version'];?> &bull; <strong>����: </strong><?=$item['date'];?> &bull; <strong>�����:</strong> <?=$item['author'];?> &bull; <strong>ʳ������ ���������:</strong> <?=$item['count_views'];?> &bull; <a href="<?=base_url()."materials/$item[material_id]";?>">������ ���</a></p>			
        <?php endforeach; ?> 
        <div style="clear: both;">&nbsp;</div>
        <a href="#top">������</a>
    </div>
</div>
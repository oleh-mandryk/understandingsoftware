<div id="content">
    <div id="tertiaryContent">
			<h3>Пошук по сайті</h3>
            <form action="<?=base_url();?>search" method="post" >
        <p><input type="text" name="search" id="search_text" maxlength="50" value="<?=set_value('search');?>" /></p>
        <div id="error"><?=form_error('search');?></div>
        <p><input type="submit" name = "search_button" id="search_button" value="" /></p>
        </form>
            
            <h3>Нові матеріали</h3>
			<ul>
            <?foreach ($latest_materials as $item):?>
            <li><a href = "<?=base_url()."materials/$item[material_id]";?>"><?=$item['title'];?></a></li>
            <?php endforeach;?>
            </ul>
			
            <h3>Популярні матеріали</h3>
			<ul>
            <?php foreach ($popular_materials as $item):?>
            <li><a href = "<?=base_url()."materials/$item[material_id]";?>"><?=$item['title'];?></a></li>
            <?php endforeach;?>
			</ul>
            
            <h3>Архів матеріалів</h3>
            <ul>
            <?php foreach ($archive_list as $one):?>
            <?php foreach ($one as $month):?>
            <li><a href="<?=base_url()."archive/".$month;?>"><?=$month?></a></li>
            <?php endforeach; ?>
            <?php endforeach; ?>
            </ul>
            <div class="xbg"></div>
</div>
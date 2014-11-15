<div id="primaryContentContainer">
			<div id="primaryContent">
            
				<h2><?=$main_info['title'];?></h2>
				<?=$main_info['main_text'];?>
				<br/>
                <?php foreach ($materials_list as $item):?>
        
				<table>
                <tr>
                <td><a href = "<?=base_url()."materials/$item[material_id]";?>"><img 
                        src="<?=base_url().$item['small_img_url'];?>" width="35" height="35" alt="icon"/></a></td>
                <td><h3><a href="<?=base_url()."materials/$item[material_id]";?>"><?=$item['title'];?></a></h3></td>
				</tr>
                </table>
                <?=$item['short_text']; ?>
				<p class="meta"><strong>Версія: </strong><?=$item['version'];?> &bull; <strong>Дата: </strong><?=$item['date'];?> &bull; <strong>Додав:</strong> <?=$item['author'];?> &bull; <strong>Кількість переглядів:</strong> <?=$item['count_views'];?> &bull; <a href="<?=base_url()."materials/$item[material_id]";?>">Читати далі</a>
				</p>			
        <?php endforeach; ?> 
            <div style="clear: both;">&nbsp;</div>
            <div id="pagination"><p><?=$page_nav;?></p></div>    
			<a href="#top">Наверх</a>
            </div>
</div>
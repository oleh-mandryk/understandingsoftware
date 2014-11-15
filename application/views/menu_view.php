<div id="menu">
		<ul>
		<?php	foreach ($menu_top as $one):?>
        <li><a href="<?=base_url().$one['url_item'];?>"><?=$one['name_item']?></a></li>
        <?php endforeach; ?> 
		</ul>
	</div>
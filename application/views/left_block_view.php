<div id="secondaryContent">
    <h3>Категорії</h3>
    <ul>
        <?php	foreach ($menu_main as $one):?>
        <li><a href="<?=base_url().$one['url_item'];?>"><?=$one['name_item']?></a><span class="reg"> <?=$one['number']?></span></li>
        <?php endforeach; ?> 
    </ul>
        
    <h3>Цікаво знати</h3>
    <?=$i_wonder['main_text'];?>
        
    <h3>Голосування</h3>
    <div id="questions_vote">
        <p><strong>
        <?=$questions_vote_all[0]['ques']?>
        </strong></p>
    </div>
    <form name="poll" id='poll' action="<?=base_url();?>poll" method="post">
        <?php	foreach ($options_vote_all as $one):?>
        <input type="radio" name="poll" value="<?=$one['option_id']?>" id="<?=$one['option_id']?>" /><label for='<?=$one['option_id']?>'>&nbsp;<?=$one['value']?></label><br />                       
        <?php endforeach; ?>
        <br />
        <p>
        <input type="submit" name = "vote_button" id="vote_button" value="" />
        <input type="submit" name = "result_button" id="result_button" value="" />
        </p>
    </form>
    <h3>RSS-підписка</h3>
    <p style="text-align: center;">Нові метеріали через RSS.</p>
    <center><a href="<?=base_url();?>rss/"><img alt="RSS-стрічка" src="<?=base_url();?>img/icon_rss.jpg" /></a></center>
<p style="text-align: center;"><a href="<?=base_url();?>rss/">Підписатись!</a></p>
    <h3>Орфографія</h3>
    
    <p><center><script type="text/javascript" src="/js/orphus.js"></script>
<a href="http://orphus.ru" id="orphus" target="_blank"><img alt="Система Orphus" src="/img/orphus.gif" border="0" width="160" height="122" /></a></center>
</p>

 
    
    <div class="xbg"></div>
</div>
<div class="clear"></div>
</div>
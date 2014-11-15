<div id="primaryContentContainer">
			<div id="primaryContent">
            
				<h2><?=$main_info['title'];?></h2>
                <div id="error"><p><strong><?=$fail_captcha;?></strong></p></div>
            <div id="not_error"><p><strong><?=$success_comment;?></strong></p></div>
				<?=$main_info['main_text'];?>
<div style=" clear: both;  margin-bottom: 1em;"></div>			

<h3>Дивіться також:</h3>
<?php
for ($i = 0; $i < $see_also['counter']; $i++) {
    
    print <<<HERE
<table>
<tr>
<td>
<a href = "http://www.understandingsoftware.com.ua/materials/{$see_also[$i][0]}"><img 
src="http://www.understandingsoftware.com.ua/{$see_also[$i][2]}" width="35" height="35" alt="icon"/></a>

</td>
<td>
<a href = "http://www.understandingsoftware.com.ua/materials/{$see_also[$i][0]}">{$see_also[$i][1]}</a>
</td>


</tr>

</table>



HERE;
}
?>
<div style=" clear: both; margin-bottom: 2em;"></div>	


<!--<fb:like send="true" width="500" show_faces="true"></fb:like>-->

<!-- Put this div tag to the place, where the Like block will be -->
<div id="vk_like"></div>
<script type="text/javascript">
VK.Widgets.Like("vk_like", {type: "full"});
</script>

<div style=" clear: both; margin-bottom: 2em;"></div>
<h3>Добавити коментар:</h3>

<form action = "<?=base_url()."comments/add/$main_info[material_id]";?>" method="post">

<p>Ваше ім'я<br/>
<input type="text" id="form_char" name="author" value="<?=set_value('author');?>"/><br/>
<strong><?=form_error('author');?></strong>
</p>

<p>Текст коментаря<br/>
<textarea name="comment_text" id="form_text" cols="50" rows="10"><?=set_value('comment_text');?></textarea><br />
<strong><?=form_error('comment_text');?></strong>
</p>

<div id="smile"><?=$smiley_table;?></div>

<a name="captcha"></a>
<p>Введіть цифри з картинки:</p>
<p><?=$imgcode?></p>
<p><input type="text" id="form_char" name="captcha" size="10"/><br/>
<strong><?=form_error('captcha');?></strong>
</p>

<input name = "material_id" type = "hidden" value = "<?=$main_info['material_id'];?>"/>

<p><input type="submit" name="post_comment" id="comment_button" value=""/></p>

</form>
<a name="new_comment"></a>


<?php foreach ($comments_list as $item):?>

<div class="comment">

<p class = "comment">Дата: <?=$item['date'];?><br/>
<strong><?=$item['author'];?></strong>:</p>
<?=$item['comment_text'];?>

</div>

<?php endforeach;?>

            
            
            
            
            
            
            
            <div style="clear: both;">&nbsp;</div>	
			<a href="#top">Наверх</a>
            
            
            
            
            </div>
		
</div>
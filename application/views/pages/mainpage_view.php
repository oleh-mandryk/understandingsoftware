<div id="primaryContentContainer">
			<div id="primaryContent">
            
				<h2><?=$main_info['title'];?></h2>
				<?=$main_info['main_text'];?>
				<div style=" clear: both;  margin-bottom: 1em;"></div>			

<h2>�������� ��������:</h2>
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
<h3><a href = "http://www.understandingsoftware.com.ua/materials/{$see_also[$i][0]}">{$see_also[$i][1]}</a></h3>
</td>


</tr>

</table>
{$see_also[$i][3]}
<p class="meta"><strong>�����: </strong>{$see_also[$i][4]} &bull; <strong>����: </strong>{$see_also[$i][5]} &bull; <strong>�����:</strong> {$see_also[$i][6]} &bull; <strong>ʳ������ ���������:</strong> {$see_also[$i][7]} &bull; <a href = "http://www.understandingsoftware.com.ua/materials/{$see_also[$i][0]}">������ ���</a>
				</p>			
        
				
                
				
       


HERE;
}
?>
<div style=" clear: both; margin-bottom: 2em;"></div>
				
                <div style="clear: both;">&nbsp;</div>
			<a href="#top">������</a>
            </div>
		
        </div>
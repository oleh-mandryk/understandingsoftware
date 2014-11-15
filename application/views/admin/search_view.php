<div id="primaryContentContainer">
			<div id="primaryContent">
                <div id="not_error"><p><strong>По запиту "<?=$this->session->userdata('search_query')?>"  знайдено:</strong></p></div>
                                               
<?php
for ($i = $mpsearch_results['start_from']; $i < $mpsearch_results['start_from'] + $mpsearch_results['limit']; $i++)
{
    if (isset($mpsearch_results[$i][0]))
    {    
        $mpsearch_results[$i][1] = highlight_phrase($mpsearch_results[$i][1], $this->session->userdata('search_query'),'<span style="background:#feffc9">','</span>');
        $mpsearch_results[$i][2] = highlight_phrase($mpsearch_results[$i][2], $this->session->userdata('search_query'),'<span style="background:#feffc9">','</span>');
       
        print <<<HERE
        
                    <h3><a href = "http://www.understandingsoftware.com.ua/materials/{$mpsearch_results[$i][0]}">{$mpsearch_results[$i][1]}</a></h3>
                
                           
                    {$mpsearch_results[$i][2]}
                    <div style="border-bottom: 1px #3f8aba solid; margin-bottom: 1em;">&nbsp;</div>
                 
HERE;
    }
}   
        
        print <<<HERE_1
        <div id="pagination"><p>$page_nav</p></div>
HERE_1
?>
<div style="clear: both;">&nbsp;</div>
            <a href="#top">Наверх</a>
            </div>
</div>
            
     

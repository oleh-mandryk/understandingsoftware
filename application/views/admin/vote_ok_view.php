<div id="primaryContentContainer">
    <div id="primaryContent">
		<h2>���������� �����������</h2>
<?php if (isset($_POST['vote_button'])) {?>
                    <div id="not_error"><strong><p><?=$info_vote?></p></strong></div>
                <?php } ?>
                    
                        <p><strong><?=$questions_vote_all[0]['ques']?></strong></p>
                        <?php	foreach ($showresults_all as $one):
                        $percent=round(($one['votes']*100)/$count_votes['totalvotes']); ?> 
                        <?=$one['value'].' '?> <strong><?=$one['votes']?></strong> <?=' ('.$percent.'%'.')';?>
                        <div class="bar " style="width: <?=$percent?>%;"></div>
                        <?php endforeach; ?> 
                        <br />
                        <p>������ ������: <strong><?=$count_votes['totalvotes'];?></strong><br />
                        ������ �����: <strong><?=$first_vote['voted_on'];?></strong><br />
                        ������� �����: <strong><?=$last_vote['voted_on'];?></strong><br />
                        </p>
</div>
</div>
<h1><i class="fa fa-tachometer fa-fw"></i>Dashboard</h1>
<!--<div id="posts">
    <h3>Ultimos posts</h3>
    <div class="row">
        <div class="col-md-2">
            <div class="list-group">
            <?php
                $data = $dbc->query("SELECT id,topic_title,topic_subject FROM forum_topics ORDER BY topic_date ASC LIMIT 0,4");
                if($data != NULL){
                    while($list = $data->fetch_assoc()){
                        $blurb = substr(strip_tags($list['topic_subject']),0,50);
                ?>
                <a href="?page=forum&topics&id=<?php echo $list['id']; ?>" class="list-group-item">
                    <h4 class="list-group-item-heading"><?php echo $list['topic_title']; ?></h4>
                    <p class="list-group-item-text"><?php echo $blurb; ?></p>
                </a>
            <?php	}
                }?>
            </div>
        </div>
        <div class="col-md-3">
        	<h3>Total de nuevos posts - <?php
                $stmt = $dbc->query("SELECT id FROM forum_topics WHERE topic_date(CURDATE(),INTERVAL 20 DAY)");
                $new = $stmt->num_rows;
				if($new==''){$new=0;}
				echo $new;?></h3>
            <h4>Cantidad total - <?php
                $stmt = $dbc->query("SELECT id FROM forum_topics");
                $total =$stmt->num_rows;
				if($total==''){$total=0;}
				echo $total;?></h4>
            <h5>En la ultima hora - <?php
                $stmt = $dbc->query("SELECT id FROM forum_topics WHERE topic_date(CURTIME(),INTERVAL 1 HOUR)");
                $last = $stmt->num_rows;
				if($last==''){$last=0;}
				echo $last;?></h5>
        </div>
    </div>
</div>-->
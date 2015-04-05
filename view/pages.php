<div>
    <?php if($slideshow == $page['id']){ ?>
    <div id="slider_top">
        <div>
            <h1>Come and play</h1>
            <h3>It's free. Join now!</h3>
        </div>
    </div>
	<?php } ?>
    <div id="main_body">
        <div>
            <h1><?php echo $page['header'];?></h1>
            <div><?php if($debug == 1){ ?>
                    <pre>
                    <?php print_r($path); ?>
                    <?php print_r($page); ?>
                    </pre>
                <?php } else { 
                        echo $page['body_formatted']; };?>
            </div>
        </div>
    </div>
</div>
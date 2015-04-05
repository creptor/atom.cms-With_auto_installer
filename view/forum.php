<div>
    <div id="main_body" style="width:inherit !important;">
        <div>
			<?php
			if(!isset($_GET['topic'])&&!isset($_GET['cat'])){
				$check = true;
				echo "<h1>".$page['header']."</h1><div class='list-group'>";
				$q = "SELECT cat_id, cat_name, cat_description FROM forum_categories";
				$r = mysqli_query($dbc, $q);
				if(mysqli_num_rows($r)!=0){
					while($cat = mysqli_fetch_assoc($r)){?>
                <div class="row list-group-item">
                    <a class="col-md-9" href="?cat=<?php echo $cat['cat_id'];?>">
                        <h3><?php echo $cat['cat_name'];?></h3>
                        <p><?php echo $cat['cat_description'];?></p>
                    </a>
			<?php
						if (!$topic = $dbc->query("SELECT * FROM forum_topics WHERE topic_cat = $cat[cat_id] ORDER BY topic_date ASC LIMIT 0,1")) {
							echo "Query failed: (".$dbc->errno.") ".$dbc->error;
						}
						$numrows = $topic->num_rows;
						if($numrows==1){
							while($top = $topic->fetch_assoc()){?>
					<a class="col-md-3" href="?topic=<?php echo $top['topic_id'] ?>">
						<p><?php echo $top['topic_title']?></p>
                    </a>
				</div>
			<?php			}
                        }else{
							echo '<p class="col-md-3">no hay nada en esta categoria.</p></div>';
						}?>
			<?php	}
				}else{
					echo '<p>no hay categorias para mostrar.</p>';
				}
			}else{
				if(isset($_GET['cat']) && is_numeric($_GET['cat'])){
					$check = true;
					$catlimit = 10;
					if(!isset($_GET['page']) || !is_numeric($_GET['page'])){
						$page = 1;
					}else{
						$page = $_GET['page'];
					}
					$cal = $catlimit*$page;
					$start = $cal-$catlimit;
					$q = "SELECT * FROM forum_topics WHERE topic_cat = $_GET[cat] ORDER BY topic_date ASC LIMIT $start,$cal";
					$r = mysqli_query($dbc, $q);
					$q2 = "SELECT cat_name FROM forum_categories WHERE cat_id = $_GET[cat]";
					$r2 = mysqli_query($dbc, $q2);
					if($r2!=NULL){
						$head = mysqli_fetch_assoc($r2);
						echo "<h2>".$head['cat_name']."</h2><div class='list-group'>";
						if(mysqli_num_rows($r)!=0){
							while($top = mysqli_fetch_assoc($r)){?>
					<div class="row list-group-item">
						<a href="?topic=<?php echo $top['topic_id'] ?>">
							<h4><?php echo $top['topic_title'] ?></h4>
						</a>
					</div>
			<?php			}
					}else{
							echo "<p>There're no topics for this category yet</p>";
						}
					}else{
						echo "<p>Esta categoria no existe.</p>";
					}
				}
				if(isset($_GET['topic']) && is_numeric($_GET['topic'])){
					$check = true;
					$poslimit = 10;
					if(!isset($_GET['page']) || !is_numeric($_GET['page'])){
						$page = 1;
					}else{
						$page = $_GET['page'];
					}
					$cal = $poslimit*$page;
					$start = $cal-$poslimit;
					$data = $dbc->query("SELECT * FROM forum_topics WHERE topic_id = $_GET[topic]");
					$num = $data->num_rows;
					if($num!=0){
						$top = $data->fetch_assoc();
						echo'<h2>'.$top['topic_title'].'</h2><div>';
						if(isset($page)==1||!isset($page)){?>
                    <div>
                        <p><?php echo $top['topic_subject'] ?></p>
                    </div>
				<?php		$post = $dbc->query("SELECT * FROM forum_posts ORDER BY post_date ASC LIMIT $start, $cal WHERE post_topic = $_GET[topic]");
							$postnum = $post->num_rows;
                            if($postnum!=0){
                                while($pos = $post->fetch_assoc()){?>
                      	<div><p><?php echo $pos['post_by'];?></p></div>
                        <div><p><?php echo $pos['post_content'];?></p></div>
                <?php			}
                            }else{
                                echo "there're no messages yet in this category, be the first one!";
                            }
							echo'';
						}else{
							$q2 = "SELECT * FROM forum_posts ORDER BY topic_date ASC LIMIT $start, $cal WHERE post_id = $_GET[topic]";
							$r2 = mysqli_query($dbc, $q2);
							if(mysqli_num_rows($r2)!=0){
								while($pos = mysqli_fetch_assoc($r2)){?>
						<div><p><?php echo $pos['post_by'];?></p></div>
                        <div><p><?php echo $pos['post_content'];?></p></div>
					<?php		}
							}else{
								echo "there're no messages yet in this category, be the first one!";
							}
						}
					}else{
						echo '<p>An error ocurred, please go back</p>';
					}
				}
				if(!isset($check)||$check!=true){echo'<div class="alert alert-danger">An error ocurred.</div>';}
			} ?>
            </div>
        </div>
    </div>
</div>
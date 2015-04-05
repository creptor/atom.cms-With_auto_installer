<h1><i class="fa fa-th-list fa-fw"></i>Forum</h1>
<ul class="nav nav-tabs">
	<li role="presentation"<?php if(!isset($_GET['topics']) and !isset($_GET['categories'])) echo 'class="active"';?>><a href="?page=forum">Start</a></li>
	<li role="presentation"<?php if(isset($_GET['categories'])) echo 'class="active"';?>><a href="?page=forum&categories">Categories</a></li>
    <li role="presentation"<?php if(isset($_GET['topics'])) echo 'class="active"';?>><a href="?page=forum&topics">Topics</a></li>
</ul>
<div style="margin-top:10px" class="row">
<?php
echo isset($message);
if(isset($_GET['topics']) || isset($_GET['categories'])){
	if(isset($_GET['categories'])){
		if($_SERVER['REQUEST_METHOD'] != 'POST' && isset($_GET['categories'])){?>
    <div class="col-md-4">
    <form method='post' action="?page=forum&categories&id=<?php echo $opened['id']; ?>">
        <div class="form-group">
            <label class="control-label">Category name:</label>
            <input class="form-control" type='text' name='cat_name' value="<?php echo $opened['cat_name'];?>" />
        </div>
        <div class="form-group">
            <label class="control-label">Category description:</label>
            <textarea class="form-control" name='cat_description' rows="3"/><?php echo $opened['cat_description'];?></textarea>
        </div>
		<?php if(isset($opened['id'])){ ?>
        <input type="hidden" name="id" value="<?php echo $opened['id'];?>">
        <?php } ?>
        <div class="form-group">
        	<input class='btn btn-success' type='submit' value='Add category' />
        </div>
     </form>
     </div>
     <div class="col-md-8">
        <div class="list-group" style="overflow:auto;max-height:500px;">
            <a href="index.php?page=forum&categories" class="list-group-item">
                <p><i class="fa fa-plus fa-fw"></i> New category</p>
            </a>
		 <?php
            $data = $dbc->query("SELECT * FROM forum_categories ORDER BY cat_poss ASC");
            if($data != NULL){
                while($list = $data->fetch_assoc()){
                    $blurb = substr(strip_tags($list['cat_description']),0,80);
            ?>
            <div id="cat_<?php echo $list['id']; ?>" class="list-group-item<?php selected($list['id'], $opened['id'], ' active'); ?>">
                <h4 class="list-group-item-heading"><?php echo $list['cat_name']; ?>
                <span class="pull-right">
                    <a href="#" id="del_<?php echo $list['id']; ?>" class="btn btn-danger btn-delete"><i class="fa fa-trash-o"></i></a>
                    <a href="index.php?page=forum&categories&id=<?php echo $list['id']; ?>" class="btn btn-default"><i class="fa fa-chevron-right"></i></a>
                </span>
                
                </h4>
                <p class="list-group-item-text"><?php echo $blurb; ?></p>
            </div>
        <?php }
            }?>
        </div>
 	</div>
    <?php
		}else{
			if(!$stmt = $dbc->prepare("INSERT INTO forum_categories (cat_name, cat_description) VALUES (?, ?)")){
				file_edit('log.log',"Query failed: (".$dbc->errno.") ".$dbc->error)."\r\n";
				echo "Prepare failed: (".$dbc->errno.") ".$dbc->error;
			}
			$stmt->bind_params('ss',$_POST['cat_name'],$_POST['cat_description']);
			if (!$stmt->execute()) {
				file_edit('log.log',"Query failed: (".$dbc->errno.") ".$dbc->error)."\r\n";
				echo "<div class='alert alert-danger'>Execute failed: (".$dbc->errno.") ".$dbc->error."</div>";
			}else{
				echo '<div class="alert alert-success">New category successfully added.</div>';
			}
			$stmt->close();
			echo'<a href="?page=forum&categories"><button class="btn btn-default">Volver</button></a>';
		}
	}
	if(isset($_GET['topics'])){
		if($_SERVER['REQUEST_METHOD'] != 'POST' && isset($_GET['topics'])){
			$cat = $dbc->query("SELECT id, cat_name FROM forum_categories ORDER BY cat_name ASC");
			if($data != NULL){?>
    <div class="col-md-6">
    <form method='post' action="?page=forum&topics&id=<?php echo $opened['id']; ?>">
        <div class="form-group">
            <label class="control-label">Topic title:</label>
            <input class="form-control" type='text' name='topic_title' />
        </div>
        <div class="form-group">
            <label class="control-label">Topic category:</label>
            <select class="form-control" name="topic_cat">	
                <?php
                    while($list = $cat->fetch_assoc()) {       
                    ?>
                        <option value="<?php echo $list['id']; ?>"<?php if(isset($_GET['id'])){selected($list['id'], $opened['id'], ' selected');}?>><?php echo $list['cat_name']; ?></option>
                    <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Topic description:</label>
            <textarea class="form-control" name='topic_subject' rows="4"/></textarea>
        </div>
        <?php if(isset($opened['id'])){ ?>
        <input type="hidden" name="id" value="<?php echo $opened['id'];?>">
        <?php } ?>
        <div class="form-group">
        	<input class='btn btn-success' type='submit' value='Add topic' />
        </div>
     </form>
     </div>
     <div class="col-md-6">
        <div class="list-group" style="overflow:auto;max-height:500px;">
            <a href="index.php?page=forum&topics" class="list-group-item">
                <p><i class="fa fa-plus fa-fw"></i> New topic</p>
            </a>
		 <?php
            $data = $dbc->query("SELECT * FROM forum_topics ORDER BY topic_date ASC");
            if($data != NULL){
                while($list = $data->fetch_assoc()){
                    $blurb = substr(strip_tags($list['topic_subject']),0,80);
            ?>
            <div id="page_<?php echo $list['id']; ?>" class="list-group-item <?php selected($list['id'], $opened['id'], 'active'); ?>">
                <h4 class="list-group-item-heading"><?php echo $list['topic_title']; ?>
                <span class="pull-right">
                    <a href="#" id="del_<?php echo $list['id']; ?>" class="btn btn-danger btn-delete"><i class="fa fa-trash-o"></i></a>
                    <a href="index.php?page=forum&topics&id=<?php echo $list['id']; ?>" class="btn btn-default"><i class="fa fa-chevron-right"></i></a>
                </span>
                
                </h4>
                <p class="list-group-item-text"><?php echo $blurb; ?></p>
            </div>
        <?php	}
            }?>
        </div>
 	</div>
    <?php
			}else{?>
     <div class="col-md-12">
     	<p>There're not any categories, you have to create one first to add a new topic.</p>
     </div>
	 <?php }
		}else{
			if(!$stmt = $dbc->prepare("INSERT INTO forum_topics (topic_title, topic_subject, topic_date, topic_cat, topic_by) VALUES (?,?, NOW(),?,?)")){
				file_edit('log.log',"Query failed: (".$dbc->errno.") ".$dbc->error)."\r\n";
				echo "Prepare failed: (".$dbc->errno.") ".$dbc->error;
			}
			$stmt->bind_param('ssii',$_POST['topic_title'],$_POST['topic_subject'],$_POST['topic_cat'],$user['id']);
			if(!$stmt->execute()){
				file_edit('log.log',"Query failed: (".$dbc->errno.") ".$dbc->error)."\r\n";
				echo "<div class='alert alert-danger'>Execute failed: (".$dbc->errno.") ".$dbc->error."</div>";
			}else{
				echo '<div class="alert alert-success">New topic successfully added.</div>';
			}
			$stmt->close();
			echo'<a href="?page=forum&topics"><button class="btn btn-default">Volver</button></a>';
		}
	}
}else{
	echo '<div class="col-md-12"><p>Bienvenido al foro, para empezar selecciona que deseas editar.</p><p>Si deseas desactivarlo, puedes hacerlo en <a href="?page=settings">settings</a></p></div>';
}
?>
</div>
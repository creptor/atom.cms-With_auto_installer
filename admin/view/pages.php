<script>
$(document).ready(function(){
	$(".btn-delete").on("click", function() {
		
		var btn = $(this).attr("id");
		var pageid = btn.split("del_").join("");
		
		var confirmed = confirm("Are you sure you want to delete this page?");
		
		if(confirmed == true) {
			$.get("ajax/pages.php?id="+pageid);
			$("#page_"+pageid).remove();
		}
	})
});
</script>
<h1><i class="fa fa-files-o fa-fw"></i>Pages</h1>
<?php if(isset($message)){ echo $message;} ?>
<div class="row">
  <div class="col-md-3">
    <div class="list-group" style="overflow:auto;max-height:500px;">
    <a href="index.php?page=pages" class="list-group-item">
        <p><i class="fa fa-plus fa-fw"></i> New Page</p>
    </a>
	<?php
        $pages = $dbc->query("SELECT * FROM pages WHERE type = 1 ORDER BY id ASC");
		if($pages != NULL){
			while($list = $pages->fetch_assoc()){
				$blurb = substr(strip_tags($list['body']),0,80);
        ?>
        <div id="page_<?php echo $list['id']; ?>" class="list-group-item<?php selected($list['id'], $opened['id'], ' active'); ?>">
				<h4 class="list-group-item-heading"><?php echo $list['header']; ?>
				<span class="pull-right">
					<a href="#" id="del_<?php echo $list['id']; ?>" class="btn btn-danger btn-delete"><i class="fa fa-trash-o"></i></a>
					<a href="index.php?page=pages&id=<?php echo $list['id']; ?>" class="btn btn-default"><i class="fa fa-chevron-right"></i></a>
				</span>
				
				</h4>
				<p class="list-group-item-text"><?php echo $blurb; ?></p>
			</div>
    <?php	}
		}?>
		</div>
	</div>
	<div class="col-md-9">
        <form role="form" action="?page=pages&id=<?php echo $opened['id']; ?>" method="post">
          	<div class="form-group">
                <label for="Page Title">Title</label>
                <input type="text" name="title" class="form-control" id="title" value="<?php echo $opened['header'];?>" placeholder="Enter the title">
          	</div>
          	<div class="form-group">
                <label for="Page Label">Label</label>
                <input type="text" name="label" class="form-control" id="label" value="<?php echo $opened['label'];?>" placeholder="Enter the title">
          	</div>
          	<div class="form-group">
                <label for="Page Header">Header</label>
                <input type="text" name="header" class="form-control" id="header" value="<?php echo $opened['header'];?>" placeholder="Enter the title">
          	</div>
			<div class="form-group">
                <label for="Page Content">Content</label>
                <textarea name="body" class="form-control editor" id="body" placeholder="Content" rows="4" style="width: 100%;"><?php echo $opened['body'];?></textarea>
			</div>
			<button type="submit" class="btn btn-default">Submit</button>
			<input type="hidden" name="submitted" value="1">
			<?php if(isset($opened['id'])){ ?>
			<input type="hidden" name="id" value="<?php echo $opened['id'];?>">
			<?php } ?>
		</form>
	</div>
</div>
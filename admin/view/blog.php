<script>
$(document).ready(function(){
	$(".btn-delete").on("click", function() {
		
		var btn = $(this).attr("id");
		var id = btn.split("del_").join();
		
		var confirmed = confirm("Are you sure you want to delete this page?");
		
		if(confirmed == true) {
			$.get("ajax/entrances.php?id="+id);
			$("#entrance_"+id).remove();
		}
	})
});
</script>
<h1><i class="fa fa-pencil-square-o fa-fw"></i>Entrances</h1>
<?php if(isset($message)){ echo $message;} ?>
<div class="row">
  <div class="col-md-3">
    <div class="list-group" style="overflow:auto;max-height:500px;">
    <a href="index.php?page=pages" class="list-group-item">
        <p><i class="fa fa-plus fa-fw"></i> New Page</p>
    </a>
	<?php
        $q = "SELECT * FROM blog_posts ORDER BY id ASC";
        if($q != NULL){
			$r = mysqli_query($dbc, $q);
        	while($list = mysqli_fetch_assoc($r)){
            	$blurb = substr(strip_tags($list['body']),0,80);
        ?>
        <div id="entrance_<?php echo $list['id']; ?>" class="list-group-item <?php selected($list['id'], $opened['id'], 'active'); ?>">
				<h4 class="list-group-item-heading"><?php echo $list['title']; ?>
				<span class="pull-right">
					<a href="#" id="del_<?php echo $list['id']; ?>" class="btn btn-danger btn-delete"><i class="fa fa-trash-o"></i></a>
					<a href="index.php?page=entrances&id=<?php echo $list['id']; ?>" class="btn btn-default"><i class="fa fa-chevron-right"></i></a>
				</span>
				
				</h4>
				<p class="list-group-item-text"><?php echo $blurb; ?></p>
			</div>
    <?php	}
		} ?>
		</div>
	</div>
	<div class="col-md-9">
        <form role="form" action="?page=entrances&id=<?php echo $opened['id']; ?>" method="post">
          	<div class="form-group">
                <label for="Page Header">Header</label>
                <input type="text" name="header" class="form-control" id="header" value="<?php echo $opened['title'];?>" placeholder="Enter the title">
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
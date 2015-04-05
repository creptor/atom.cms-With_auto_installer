<h1><i class="fa fa-usd fa-fw"></i>Store</h1>
<div class="row">
  <div class="col-md-4 col-sm-5">
    <div class="list-group" style="overflow:auto;max-height:500px;">
    <a href="index.php?page=pages" class="list-group-item">
        <p><i class="fa fa-plus fa-fw"></i> New item</p>
    </a>
	<?php
		if($stmt = $dbc->query("SELECT * FROM store")){
			while($list = $stmt->fetch_assoc()){
				$blurb = substr(strip_tags($list['description']),0,80);
        ?>
        <div id="page_<?php echo $list['store_item_id']; ?>" class="list-group-item<?php selected($list['store_item_id'], $opened['id'], ' active'); ?>">
            <h4 class="list-group-item-heading"><?php echo $list['title']; ?>
            <span class="pull-right">
            	<h5><?php echo $list['price']; ?>
                    <a href="#" id="del_<?php echo $list['store_item_id']; ?>" class="btn btn-danger btn-delete"><i class="fa fa-trash-o"></i></a>
                    <a href="?page=store&id=<?php echo $list['store_item_id']; ?>" class="btn btn-default"><i class="fa fa-chevron-right"></i></a>
                </h5>
            </span>
            </h4>
            <p class="list-group-item-text"><?php echo $blurb; ?></p>
        </div>
    <?php	}
		}else{
			echo "Query failed: (".$dbc->errno.") ".$dbc->error;
		}?>
	</div>
  </div>
	<div class="col-md-8 col-sm-7 hidden-xs row">
        <form action="?page=store&id=<?php echo $opened['id']; ?>" method="post" id="store_editor" title="store_editor" role="form">
        <div class="col-md-8 col-sm-push-3">
                <div class="form-group">
                    <label for="Item Title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="<?php echo $opened['title'];?>" placeholder="Enter the title">
                </div>
                <div class="form-group">
                    <label for="Item Description">Description</label>
                    <textarea name="desc" class="form-control" id="item_desc" placeholder="Enter the Description"><?php echo $opened['description'];?></textarea>
                </div>
                <div class="form-group">
                    <label for="Item quantity">Quantity</label>
                    <input type="number" name="qty" class="form-control" id="item_qty" value="<?php echo $opened['qty'];?>">
                </div>
                <div class="form-group">
                    <label for="Item Price">Price</label>
                    <input type="number" name="price" class="form-control" id="item_price" value="<?php echo $opened['price'];?>">
                </div>
                <div class="form-group">
                	<button type="submit" class="btn btn-default">Submit</button>
                </div>
            </div>
            <div class="col-md-4 col-sm-pull-9">
                <label for="Item Image">Image</label>
                <div class="form-group">
                    <div id="item_img" class="img-thumbnail form-control" style="margin:auto;width:160px;height:160px;background-size:140px;background-image:url(../../<?php echo $opened['img'];?>);background-repeat:no-repeat;background-position:50%;"></div>
                    <div class="custom-file-upload">
                        <input type="file" id="file" accept="image/*" name="myfiles[]"/>
                    </div>
                </div>
            </div>
			<input type="hidden" name="submitted" value="1">
			<?php if(isset($opened['id'])){ ?>
			<input type="hidden" name="id" value="<?php echo $opened['id'];?>">
			<?php } ?>
		</form>
	</div>
</div>
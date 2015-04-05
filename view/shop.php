<div>
    <?php if($slideshow == $page['id'] && !isset($_GET['cart'])){ ?>
    <div id="slider_top">
        <div>
            <h1>Come and play</h1>
            <h3>It's free. Join now!</h3>
        </div>
    </div>
	<?php } ?>
    <div id="main_body" style="width:inherit !important;">
	<?php if(!isset($_GET['cart'])){?>
        <div>
        	<a class="btn btn-default" style="float:right;" href="<?php echo $page['slug']; ?>?cart"><i class="fa fa-shopping-cart"></i> check out</a>
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
        <div class="row">
        <?php
			//variables
			if(!isset($_GET['page'])||!is_numeric($_GET['page'])||$_GET['page']<1){
				$view = 1;
			}else{
				$view = mysqli_real_escape_string($dbc, $_GET['page']);
			}
			if(!isset($_GET['by'])){
				$order = 'title';
			}else{
				$order = mysqli_real_escape_string($dbc, $_GET['by']);
			}
			$min = ($storeItems*$view)-$storeItems;
			$max = $storeItems*$view;
			//fetch results
			if(!$stmt = $dbc->query("SELECT * FROM store")){
				echo "Query failed: (".$dbc->errno.") ".$dbc->error;
			}
			$numrows = $stmt->num_rows;
			if($numrows == 0||$numrows ==''){
				echo '<div class="alert alert-warning">No hay items para mostrar.</div>';
			}
			$pagination = ceil($numrows/$storeItems);
			//display results
			if(!$store = $dbc->prepare("SELECT * FROM store ORDER BY ? ASC LIMIT ?,?")){
				echo "Prepare failed: (".$dbc->errno.") ".$dbc->error;
			}
			$store->bind_param('sii', $order, $min, $max);
			if(!$store->execute()){
				echo "Execute failed: (".$dbc->errno.") ".$dbc->error;
			}
			if(!($res = $store->get_result())){
				echo '<div class="alert alert-warning">No hay items para mostrar.</div>';
			}
			while($list = $res->fetch_assoc()){
		?>
			<div class="list-shop">
                <h3><?php echo $list['title']; ?></h3>
                <img alt="<?php echo $list['title']; ?>" class="img_shop" src="<?php echo $list['img']; ?>"/>
                <form class="shop_form" action="#" method="post">
                    <input name="id" type="hidden" value="<?php echo $list['store_item_id']; ?>">
                    <input name="qty" type="hidden" value="1">
                    <input name="sessionid" type="hidden" value="<?php echo session_id(); ?>">
                    <div>
                        <button type="submit" class="shop-btn btn btn-success"><i class="fa fa-plus fa-fw"></i> Add</button>
                        <i id="load_<?php echo $list['store_item_id']; ?>" class="fa fa-spinner fa-2x fa-spin" style="display:none;position:relative;vertical-align:middle;"></i>
                        <i id="done_<?php echo $list['store_item_id']; ?>" class="fa fa-check fa-2x" style="display:none;color:green;vertical-align:middle;"></i>
                    </div>
                </form>
            </div>
		<?php }
			$store->close();
			echo'</div>';
			//pagination
			if($pagination>1){
				echo'<nav><ul class="pagination" style="margin-left: auto;margin-right: auto;display: table;">';
				if($view==1){echo'<li class="disabled"><a><span aria-hidden="true"><i class="fa fa-caret-left"></i></span></a></li>';}else{echo'<li><a href="'.$page['slug'].'?page='.($view-1).'"><span aria-hidden="true"><i class="fa fa-caret-left"></i></span></a></li>';}
				for($x=($view-$RangeItems);$x<(($view+$RangeItems)+1);$x++){
					if(($x>0)&&($x<=$pagination)){
						if($x==$view){
							echo'<li class="active"><a>'.$x.'<span class="sr-only">(current)</span></a></li>';
						}else{
							echo'<li><a href="'.$page['slug'].'?page='.$x.'">'.$x.'</a></li>';
						}
					}
				}
				if($view==$pagination){echo'<li class="disabled"><a><span aria-hidden="true"><i class="fa fa-caret-right"></i></span></a></li>';}else{echo'<li><a href="'.$page['slug'].'?page='.($view+1).'"><span aria-hidden="true"><i class="fa fa-caret-right"></i></span></a></li>';}
				echo'</ul></nav>';
			}?>
    <?php }else{ ?>
    	<h1>Carro</h1>
        <?php
		//retrieve items . use session_id and/or datetime 
		$PHPSESSID = session_id(); 
		$showcart = $dbc->query("SELECT * FROM cart INNER JOIN store ON item_id = store_item_id WHERE session_id = '$PHPSESSID'"); 
		if(!$showcart){ 
			$err = true;
			file_edit('log.log',"Query failed: (".$dbc->errno.") ".$dbc->error)."\r\n";
			$errmsg = "<div class='alert alert-danger'>Query failed: (".$dbc->errno.") ".$dbc->error."</div>"; 
		}else{
			$num = $showcart->num_rows; 
		} 
		?>
		<div> 
			<?php if(!$err){ ?> 
			<div class="row"> 
				<div class="col-md-2"><strong>Nombre</strong></div> 
				<div class="col-md-2"><strong>Cantidad</strong></div> 
				<div class="col-md-2"><strong>Precio</strong></div> 
				<div class="col-md-2"><strong>Total</strong></div> 
			</div> 
			<?php 
			$gtotal=0; 
			if($num > 0){ 
				while($row = $showcart->fetch_assoc()){ 
			?> 
			<div class="row"> 
				<div class="col-md-2"><?php echo trim(stripslashes($row['title']))?></div> 
				<div class="col-md-2"><?php echo trim(stripslashes($row['quantity']))?></div> 
				<div class="col-md-2"><?php echo trim(stripslashes($row['price']))?></div> 
				<div class="col-md-2"><?php 
					$total= $row['quantity'] * $row['price']; 
					$ctotal=number_format($row['price'],2);
					$gtotal=number_format($gtotal,2);
					$gtotal = $gtotal + $ctotal; 
					$_SESSION['gtotal'] = $gtotal; 
					echo "$".$total;?></div> 
				<div class="col-md-2"><a href="delete.php?cid=<?php echo $row['id'] ?>">Eliminar</a></div> 
			</div> 
			<?php 
				} 
			}else{ 
			?> 
			<div class="row"> 
				 <div class="col-md-12"><p>No tienes nada en tu carro.</p></div>  
			</div> 
			<?php 
			} 
			?> 
			<div class="row">
				<div class="col-md-2 col-md-offset-4"><strong>Costo final:</strong></div> 
				<div class="col-md-2"><strong><?php echo "$".$gtotal;?></strong></div> 
			</div>
			<div class="row">
                <form action="checkout.php" method="post"> 
				<div class="col-md-2 col-md-offset-4"><input class="btn btn-default" type="submit" name="checkout" value="Check Out" /></div> 
                </form>
				<div class="col-md-2"><a href="tienda" class="btn btn-default">Atras</a></div> 
			</div>
			<?php 
			}else{ 
			?> 
			<div class="row"> 
				<div class="col-md-12"><p><?php echo $errmsg;?></p></div> 
			</div> 
			<?php  } ?> 
		</div> 
	<?php }?>
    </div>
</div>
<h1><i class="fa fa-bars fa-fw"></i>Navigation</h1>
<div class="row">
	<div id="message"></div>
	<div class="col-md-4 col-sm-6 col-xs-12">
    	<h3>List</h3>
		<ul id="sort-nav" class="list-group connectedSortable sort">	
			<?php
			$data = $dbc->query("SELECT * FROM navigation ORDER BY position ASC");
			if($data != NULL){		
				while ($list = $data->fetch_assoc()) {
				?>
			<li id="list_<?php echo $list['pageid']; ?>" class="list-group-item">
				<a id="label_<?php echo $list['pageid']; ?>" data-toggle="collapse" data-target="#form_<?php echo $list['pageid']; ?>"><?php echo $list['label']; ?><i class="fa fa-chevron-down"></i>
				</a>
				<div id="form_<?php echo $list['pageid']; ?>" class="collapse">
					<form class="form-horizontal nav-form" action="index.php?page=navigation&id=<?php echo $list['pageid']; ?>" method="post" role="form">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="label">Label:</label>
							<div class="col-sm-10">
								<input class="form-control input-sm" type="text" name="label" id="label" value="<?php echo $list['label']; ?>" placeholder="Label" autocomplete="off">
							</div>
						</div>
						<div class="form-group iconpicker-container">
							<label class="col-sm-2 control-label" for="label">Icon:</label>
                            <div class="col-sm-10">
                            	<input name="icon" class="form-control input-sm icp icp-auto iconpicker-element iconpicker-input" value="<?php echo $list['icon']; ?>" type="text">
                            </div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="value">Url:</label>
							<div class="col-sm-10">
								<input class="form-control input-sm" type="text" name="url" id="url" value="<?php echo $list['url']; ?>" placeholder="Url" autocomplete="off">
							</div>
						</div>	
						<div class="form-group">
							<label class="col-sm-2 control-label" for="status">Visible:</label>
							<div class="col-sm-10">
                            	<input style="vertical-align: -webkit-baseline-middle;vertical-align:bottom;" type="checkbox" name="status" id="status" value="1"<?php if($list['status'] == 1){echo ' checked';} ?>>
							</div>
						</div>
						<button type="submit" class="btn btn-default">Save</button>
                        <i id="load_<?php echo $list['pageid']; ?>" class="fa fa-spinner fa-2x fa-spin" style="display:none;position:relative;vertical-align:middle;"></i>
                        <i id="done_<?php echo $list['pageid']; ?>" class="fa fa-check fa-2x" style="display:none;color:green;vertical-align:middle;"></i>
						<input type="hidden" name="submitted" value="1">
                        <input type="hidden" name="page_id" value="<?php echo $list['pageid']; ?>">
						<input type="hidden" name="openedid" value="<?php echo $list['pageid']; ?>">
					</form>
				</div>
			</li>
            </a>
			<?php }
			}?>
		</ul>
	</div>
    <div class="col-md-4 col-sm-6 col-xs-12">
    	<h3>Pages</h3>
		<ul id="sort-pag" class="list-group connectedSortable sort">
        <?php
			$pages = $dbc->query("SELECT * FROM pages WHERE on_field_editable = 1");
			if($pages != NULL){
				while ($list2 = $pages->fetch_assoc()) {
				?>
			<li id="list_<?php echo $list2['id']; ?>" class="list-group-item">
				<a id="label_<?php echo $list2['id']; ?>" data-toggle="collapse" data-target="#form_<?php echo $list2['id']; ?>"><?php echo $list2['label']; ?> <i class="fa fa-chevron-down"></i>
				</a>
				<div id="form_<?php echo $list2['id']; ?>" class="collapse">
					<form class="form-horizontal nav-form" action="index.php?page=navigation&id=<?php echo $list2['id']; ?>" method="post" role="form">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="label">Label:</label>
							<div class="col-sm-10">
								<input class="form-control input-sm" type="text" name="label" id="label" value="<?php echo $list2['label']; ?>" placeholder="Label" autocomplete="off">
							</div>
						</div>
						<div class="form-group iconpicker-container">
							<label class="col-sm-2 control-label" for="label">Icon:</label>
                            <div class="col-sm-10">
                            	<input name="img" id="img" class="form-control input-sm icp icp-auto iconpicker-element iconpicker-input" value="" data-placement="bottomRight" type="text">
                            </div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="value">Url:</label>
							<div class="col-sm-10">
								<input class="form-control input-sm" type="text" name="url" id="url" value="<?php echo $list2['slug']; ?>" placeholder="Url" autocomplete="off">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="status">Visible:</label>
							<div class="col-sm-10">
                            	<input style="vertical-align: -webkit-baseline-middle;vertical-align:bottom;" type="checkbox" name="status" id="status" value="1">
							</div>
						</div>
						<button type="submit" class="btn btn-default disabled">Save</button>
                        <i id="load_<?php echo $list2['id']; ?>" class="fa fa-spinner fa-2x fa-spin" style="display:none;position:relative;vertical-align:middle;"></i>
                        <i id="done_<?php echo $list2['id']; ?>" class="fa fa-check fa-2x" style="display:none;color:green;vertical-align:middle;"></i>
						<input type="hidden" name="submitted" value="1">
						<input type="hidden" name="openedid" value="<?php echo $list2['id']; ?>">
					</form>					
				</div>
			</li>
            </a>
			<?php }
			}?>
        </ul>
	</div>
</div>
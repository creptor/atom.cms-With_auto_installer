<h1><i class="fa fa-users fa-fw"></i>Users</h1>
<?php if(isset($message)){ echo $message;} ?>
<div class="row">
  <div class="col-md-4 col-sm-5">
    <div class="list-group" style="overflow:auto;max-height:500px;">
    <a href="index.php?page=users" class="list-group-item">
        <p><i class="fa fa-plus fa-fw"></i> New User</p>
    </a>
        <?php
            $q = "SELECT * FROM users ORDER BY id ASC";
			if($q != NULL){
				$r = mysqli_query($dbc, $q);
				while($list = mysqli_fetch_assoc($r)){
					$list = data_user($dbc, $list['id']);
					if(strlen($list['email']) > 23){
						$email = substr($list['email'],0,20)."...";
					} else {
						$email = $list['email'];
					}
            ?>
            <a class="list-group-item<?php selected($list['id'], $opened['id'], ' active'); ?>" href="index.php?page=users&id=<?php echo $list['id'];  ?>">
                <h4 class="list-group-item-heading"><?php echo $list['nickname']; ?></h4>
                <div class="user_icon_menu" style="background-size: 48px;display: inline-block;vertical-align: middle;"></div><p style="display: inline-block;vertical-align: middle;margin-left: 5px;"><?php echo $email ?></p>
            </a>
        <?php }
			}?>
    </div>
  </div>
  <div class="col-md-6 col-sm-7 hidden-xs">
    <form role="form" action="?page=users&id=<?php echo $opened['id']; ?>" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="User Username">Nickname</label>
        <input type="text" name="nickname" class="form-control" id="username" value="<?php echo $opened['nickname'];?>" placeholder="Enter the username" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="User Name">Name</label>
        <input type="text" name="name" class="form-control" id="name" value="<?php echo $opened['name'];?>" placeholder="Enter the name" autocomplete="off">
      </div>
      <?php if(isset($opened['id'])){ ?>
      <div class="form-group">
        <label for="User Name">Image</label>
        <div>
            <div id="avatar" style="display:inline-block;vertical-align:middle;">
                <div class="user_icon_menu" style="background-size: 48px;background-image:url(../../<?php /*echo $opened['img'];*/?>);"></div>
            </div>
            <input style="display:inline-block;vertical-align:middle;" type="file" name="fileToUpload" id="fileToUpload">
      	</div>
      </div>
      <?php } ?>
      <div class="form-group">
        <label for="User Email">Email</label>
        <input type="email" name="email" class="form-control" id="email" value="<?php echo $opened['email'];?>" placeholder="Enter the email" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="User Password">Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Enter the password" autocomplete="off">
      </div>
      <div class="form-group">
        <input type="password" name="passwordv" class="form-control" id="passwordv" placeholder="Enter the password again" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="User Value">Permission</label>
        <input type="radio" name="permissions" value="3"<?php if(isset($_GET['id'])){ selected('3', $opened['permissions'], ' checked');}?>>Administrator</input>
        <input type="radio" name="permissions" value="2"<?php if(isset($_GET['id'])){ selected('2', $opened['permissions'], ' checked');}?>>Staff</input>
        <input type="radio" name="permissions" value="1"<?php if(isset($_GET['id'])){ selected('1', $opened['permissions'], ' checked');}?>>Moderator</input>
        <input type="radio" name="permissions" value="0"<?php if(isset($_GET['id'])){ selected('0', $opened['permissions'], ' checked');}?>>User</input>
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
      <input type="hidden" name="submitted" value="1">
      <?php if(isset($opened['id'])){ ?>
      <input type="hidden" name="id" value="<?php echo $opened['id'];?>">
      <?php } ?>
    </form>
</div>
</div>
<!--register page compressed--><div id="main_body"><div><h1><?php echo $page['header'];?></h1><div><?php if(isset($message)){echo $message;}?><blockquote><footer>Para ingresar con google, facebook, twitter o cualquier otro disponible no es necesario registrarse.</footer></blockquote><form role="form" action="" method="post" enctype="multipart/form-data"><div class="form-group"><label for="User Username">Username</label><input type="text" name="username" class="form-control" id="username" placeholder="Enter the username" autocomplete="off"></div><div class="form-group"><label for="User Name">Name</label><input type="text" name="name" class="form-control" id="name" placeholder="Enter the name" autocomplete="off"></div><div class="form-group"><label for="User Email">Email</label><input type="email" name="email" class="form-control" id="email" placeholder="Enter the email" autocomplete="off"></div><div class="form-group"><label for="User Password">Password</label><input type="password" name="password" class="form-control" id="password" placeholder="Enter the password" autocomplete="off"></div><div class="form-group"><input type="password" name="passwordv" class="form-control" id="passwordv" placeholder="Enter the password again" autocomplete="off"></div><?php if($captchaPUBLIC!=''||$captchaPRIVATE!=''){ ?><div class="g-recaptcha form-group" data-sitekey="<?php echo $captchaPUBLIC ?>"></div><?php } ?><button type="submit" class="btn btn-success">Registrarse</button><input type="hidden" name="submitted" value="1"></form></div></div></div>
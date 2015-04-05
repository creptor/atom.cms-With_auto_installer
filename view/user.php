<?php
$nick="'%".prepare_fetch($_GET['nick'],"s")."%'";
$stmt=$dbc->query("SELECT * FROM users INNER JOIN countries ON (users.location = countries.id) LEFT OUTER JOIN friends ON (users.id = friends.user_id_1) OR (users.id = friends.user_id_2) WHERE nickname LIKE $nick");
$data=$stmt->fetch_assoc();
?><div id="main_body">
	<div id="profile_header">
        <div><h1>-IMG HERE-</h1></div>
        <div id="profile_header_summary">
            <h1><?php echo $data['nickname'];?></h1>
            <div id="header_real_name ellipsis"><?php echo $data['name'];?>&nbsp;<?php echo $data['country_name'];?></div>
            <div id="profile_summary"><?php echo $data['profile_summary'];?></div>
        </div>
        <div class="profile_header_badgeinfo">
        	<div>Nivel: <div class="PlayerLevel"><span><?php  echo $data['level'];?></span></div></div>
            <a href="edit?val=<?php ?>"><span>Modificar perfil</span></a>
        </div>
	</div>
</div>
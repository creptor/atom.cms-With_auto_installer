<nav class="navbar">
	<ul>
        <li<?php if($page=='dashboard'){echo' class="nav_active"';}?>><a href="?page=dashboard"><i class="fa fa-tachometer fa-fw"></i>Dash Board</a></li>
        <li<?php if($page=='blog'){echo' class="nav_active"';}?>><a href="?page=blog"><i class="fa fa-pencil-square-o fa-fw"></i>Blog</a></li>
        <li<?php if($page=='pages'){echo' class="nav_active"';}?>><a href="?page=pages"><i class="fa fa-files-o fa-fw"></i>Pages</a></li>
        <li<?php if($page=='navigation'){echo' class="nav_active"';}?>><a href="?page=navigation"><i class="fa fa-bars fa-fw"></i>Navigation</a></li>
		<li<?php if($page=='users'){echo' class="nav_active"';}?>><a href="?page=users"><i class="fa fa-users fa-fw"></i>Users</a></li>
		<li<?php if($page=='store'){echo' class="nav_active"';}?>><a href="?page=store"><i class="fa fa-usd fa-fw"></i>Store</a></li>
		<li<?php if($page=='forum'){echo' class="nav_active"';}?>><a href="?page=forum"><i class="fa fa-th-list fa-fw"></i>Forum</a></li>
        <li<?php if($page=='settings'){echo' class="nav_active"';}?>><a href="?page=settings"><i class="fa fa-sliders fa-fw"></i>Settings</a></li>
        <li<?php if($page=='help'){echo' class="nav_active"';}?>><a href="?page=help"><i class="fa fa-life-ring fa-fw"></i>Help</a></li>
	</ul>
</nav>
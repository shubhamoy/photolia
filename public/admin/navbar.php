<ul class="nav navbar-nav">
	<li><a href="index.php">Home</a></li>
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			Users <span><i class="fa fa-chevron-down"></i></span>
		</a>
		<ul class="dropdown-menu">
			<li><a href="adduser.php">Add Users</a></li>	
			<li><a href="manageusers.php">Manage Users</a></li>	
		</ul>
	</li>
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			Pics <span><i class="fa fa-chevron-down"></i></span>
		</a>
		<ul class="dropdown-menu">
			<li><a href="addpic.php">Add Pic</a></li>	
			<li><a href="managepics.php">Manage Pics</a></li>	
		</ul>
	</li>
	<li><a href="managecomments.php">Comments</a></li>
	<li><a href="logfile.php">Logs</a></li>
	<li><a href="logout.php">Logout(<?=$u->username;?>)</a></li>
	<li><a href="/index.php" target="_blank">Visit Homepage</a></li>
</ul>
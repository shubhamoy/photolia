<?php
	require_once(__DIR__.'/../loader.php');
	require_once(__DIR__.'/../includes/db.php');

	if(check_db()){
	  redirect_to('/');
	}

  if(isset($_POST['submit'])) {
    $dsn = ['host' => $_POST['host'], 
				    'username' => $_POST['username'], 
			   	  'password' => $_POST['password'],
				    'dbname' => $_POST['dbname']
			     ];

		$search = ["/HOST', '\w*'/", 
               "/USER', '\w*'/",
               "/PWD', '\w*'/", 
               "/DBNAME', '\w*'/"];

		$replace = ["HOST', '".$dsn['host']."'", 
								"USER', '".$dsn['username']."'",
								"PWD', '".$dsn['password']."'", 
								"DBNAME', '".$dsn['dbname']."'"];

		$data = ['file' => "/config.php",
   				   'search' => $search,
   				   'replace' => $replace
				    ];

    $insertQuery = "INSERT INTO `users` VALUES(1, '".$_POST['loguser']."', '".password_hash($_POST['logpwd'], PASSWORD_BCRYPT)."', '".$_POST['loguser']."', '".$_POST['loguser']."', '".get_timestamp()."', '".get_timestamp()."', NULL);";				

  	$install = Install::start($dsn);

  	if($install::$check === 1) {
  		if($install->installConfig($data)) {
  			if($install->installTables($query)) {
  				if($install->createUser($insertQuery)) {
  					$_SESSION['install_login'] = 1;
  				  redirect_to('admin/index.php');
  				} else {
  				  echo "<h2>Installation Failed! Reason: User Account Creation couldn't finish. Try Again</h2>";
  					die();
  				}
  			} else {
  				echo "<h2>Installation Failed! Reason: Table Installation Failed. Try Again";
  				die();
  			}
  		} else {
  			echo "<h2>Installation Failed! Reason: Configuring config.php Failed. Try Again";
  			die();
  		}
  	} else {
  		echo "<h2>Installation Failed! Reason: Database Connection Issue. Try Again";
  		die();
  	}
  }
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--<link rel="icon" href="../../favicon.ico"> -->
		<title>Photolia</title>

		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">  
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<!-- Custom styles for this template -->
		<link href="css/style.css" rel="stylesheet">
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>

		<div class="row">
			<div class="col-lg-8 col-lg-offset-4">
				<h1>Photolia Installer</h1>
			</div>
		</div>
<div class="row">
	<div class="col-lg-4 col-lg-offset-4">
		<form method="POST" action="" class="form-horizontal">
			<input type="text" class="form-control" name="host" placeholder="Enter your MySQL Host(e.g., localhost)">
			&nbsp;
			<input type="text" class="form-control" name="username" placeholder="Enter your MySQL Username">
			&nbsp;
			<input type="password" class="form-control" name="password" placeholder="Enter your MySQL Password">
			&nbsp;
			<input type="text" class="form-control" name="dbname" placeholder="Enter your MySQL Database Name">
			&nbsp;
			<input type="text" class="form-control" name="loguser" placeholder="Enter your Username for Admin Login">
			&nbsp;
			<input type="password" class="form-control" name="logpwd" placeholder="Enter your Password for Admin Login">
			&nbsp;
			<button type="submit" class="btn btn-primary btn-block" name="submit">Install</button>
		</form>
	</div>
</div>
<footer class="footer">
	<div class="container">
		<p class="text-muted text-center" id="footer_text">Copyright &copy; <?=date('Y'); ?> Shubhamoy</p>
	</div>
</footer>

<!-- Bootstrap core JavaScript================================================== -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>

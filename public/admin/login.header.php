<?php
    require_once(__DIR__.'/../../includes/helpers.php');
    require_once(__DIR__.'/../../loader.php');
    
    $a = new Auth;
    if (Auth::isLoggedIn()) {
        redirect_to('index.php');
        exit();
    }


    if(isset($_SESSION['install_login'])) {
    	$u = User::getUser($_SESSION['install_login']);
    	$a->login($u);
    	$_SESSION['ACTIVITY'] = time();
    	redirect_to('index.php');
    }
    
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $u = User::auth($username, $password);
        if ($u) {
            $a->login($u);
            $_SESSION['ACTIVITY'] = time();
            Logger::start()->add($username, $_SERVER['PHP_SELF'], 'Login');
            redirect_to('index.php');
        } else {
            $msg = opmsg("Username or Password Incorrect", "danger");
        }
    } else {
        $username = "";
        $password = "";
        $msg = "";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<!--<link rel="icon" href="../../favicon.ico"> -->
	<title>Photolia - Login</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">    
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<!-- Custom styles for this template -->
	<link href="../css/style.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Photolia</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="/">Home</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>

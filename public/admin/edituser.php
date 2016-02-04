<?php
require_once(__DIR__.'/../../includes/helpers.php');
require_once(__DIR__.'/../../loader.php');
Session::checkSession();
$a = new Auth;
if (!$a->isLoggedIn()) {
    redirect_to('login.php');
    exit();
}
$u = User::getUser();
//$l = Logger::start();
$msg = "";
    if (isset($_POST['edit'])) {
        if ($_SESSION['uid'] == $_POST['eid']) {
            redirect_to('manageusers.php');
            exit();
        }
        $user = User::getUser($_POST['eid']);
        if ($user) {
            $id= $user->id;
            $username = $user->username;
            $fname = $user->fname;
            $lname = $user->lname;
        } else {
            redirect_to('manageusers.php');
            exit();
        }
    }
    
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $data=array(
            'username'=>$_POST['username'],
            'password'=>password_hash($_POST['password'], PASSWORD_BCRYPT),
            'fname'=>$_POST['fname'],
            'lname'=>$_POST['lname']
        );
        $update = User::update($id, $data);
        if ($update) {
            $msg = opmsg("User Updated Successfully", "success");
            redirect_to('manageusers.php');
        } else {
            $msg = opmsg("User Updation Failed", "danger");
        }
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
<title>Photolia</title>

<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">    
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="../css/style.css"
<!-- Custom styles for this template -->
<link href="../css/style.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<h1 class="text-center">Edit Admin User</h1>
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Photolia</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
		<?php require_once('navbar.php');?>
		</div><!--/.nav-collapse -->
	</div>
</nav>
<div class="container">
	<?=$msg;?>
	<form action="" name="editUser" method="post"> 
		<input type="hidden" name="id" value="<?=$id;?>">
		<div class="form-group">
			<label>Username</label>
			<input class="form-control" type="text" name="username" placeholder="Enter the username" value="<?=$username;?>">
		</div>
		<div class="form-group">
			<label>Password</label>
			<input class="form-control" type="text" name="password" placeholder="Enter the new password">		
		</div>
		<div class="form-group">
			<label>First Name</label>
			<input class="form-control" type="text" name="fname" placeholder="Enter the first name" value="<?=$fname;?>">		
		</div>
		<div class="form-group">
			<label>Last Name</label>
			<input class="form-control" type="text" name="lname" placeholder="Enter the last name" value="<?=$lname;?>">		
		</div>
		<button type="submit" name="update" class="btn btn-primary btn-block"><i class="fa fa-refresh"></i> Update</button>
	</form> 
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
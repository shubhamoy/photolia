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
$pics = Pics::getAllPics();

//$l = Logger::start();
$msg = "";

if (isset($_POST['del'])) {
    $id = intval($_POST['did']);
    $d = Pics::delete($id);
    
    if ($d) {
        $msg = opmsg("Pic Deleted Successfully", "success");
        redirect_to('managepics.php');
    } else {
        $msg = opmsg("Pic Not Deleted", "danger");
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
<h1 class="text-center">Manage Pics</h1>
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
	<div id="no-more-tables">
	<table class="table table-striped">
		<thead>
			<tr>
	            <th class="text-center">Image</th>    
				<th class="text-center">File Name</th>
                <th class="text-center">Type</th>
                <th class="text-center">Size</th>
                <th class="text-center">Caption</th>
                <th class="text-center">Uploaded On</th>
                <th class="text-center">Last Edited</th>
                <th class="text-center">Edit</th>
                <th class="text-center">Delete</th>
            </tr>
		</thead>
		<tbody>			
<?php 
foreach ($pics as $p) {
    ?>
		<tr> 
			<td class="text-center" data-title="Image"><img src="../images/<?=$p->filename;
    ?>" class="img-thumbnail" style="width:100px;height:100px;"></td> 
			<td class="text-center" data-title="File Name"><?=$p->filename;
    ?></td> 
			<td class="text-center" data-title="Type"><?=$p->type;
    ?></td> 
			<td class="text-center" data-title="Type"><?=fsize($p->size);
    ?></td>
			<td class="text-center" data-title="Caption"><?=$p->caption;
    ?></td>  
			<td class="text-center" data-title="Uploaded On"><?=$p->created_at;
    ?></td> 			
			<td class="text-center" data-title="Last Edited"><?=$p->updated_at;
    ?></td> 
			<td class="text-center" data-title="Edit">
				<form method="POST" action="editpic.php" accept-charset="UTF-8">
					<input type="hidden" name="eid" value="<?=$p->id;
    ?>">
					<button type="submit" name="edit" class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</button>
				</form>	
			</td> 
			<td class="text-center" data-title="Delete">
				<form method="POST" action="managepics.php" accept-charset="UTF-8">
					<input type="hidden" name="did" value="<?=$p->id;
    ?>">
					<button type="submit" name="del" class="btn btn-danger"><i class="fa fa-times"></i> Delete</button>
				</form>	
			</td> 
		</tr> 
<?php

}
?>
	</tbody>
  </table>
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

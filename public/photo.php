<?php
require_once(__DIR__.'/../includes/helpers.php');
require_once(__DIR__.'/../loader.php');

if (empty($_GET['id']) and empty($_GET['slug'])) {
    redirect_to("index.php");
}
if (isset($_GET['id'])) {
    $p = Pics::getPic($_GET['id']);
} else {
    $p = Pics::getBySlug($_GET['slug']);
}



$c = Comment::findComments($p->id);
if (!$p) {
    redirect_to("index.php");
}

if (isset($_POST['submit'])) {
    if(CSRF::check($_POST['token'])){
		$author = htmlspecialchars($_POST['author']);
	    $body = htmlspecialchars($_POST['body']);
	    
	    $comment = Comment::make($p->id, $author, $body);
	    if ($comment) {
	        $comment->create();
			$msg = opmsg("Comment posted successfully and awaiting moderation!", "success");
	    } else {
			$msg = opmsg("Failed", "danger");
	    }
	}else{
		$msg = opmsg("Failed", "danger");
	}
} else {
    $author = "";
    $body = "";
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
<title>Photolia</title>

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
<h1 class="text-center"><?=$p->caption;?></h1>
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
		<ul class="nav navbar-nav">
			<li><a href="/">Home</a></li>
			<li><a href="#contact">Contact</a></li>
		</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="thumbnail">
				<img class="img-responsive" src="images/<?=$p->filename;?>" alt="<?=$p->caption;?>">
			</div>
		</div>
		<div class="col-lg-6 col-lg-offset-3">
			<form method="post" action="photo.php?id=<?=$p->id;?>">
				<input type="hidden" name="token" value="<?=CSRF::token();?>">
				<h4>Add your comment</h4>
				
				<?=$msg;?>
				<div class="form-group">
					<label>Name</label>
					<input class="form-control" type="text" placeholder="Enter your Name" name="author" value="">
				</div>
				
				<div class="form-group">
					<label>Comment</label>
					<textarea class="form-control" placeholder="Enter your Comment" name="body"></textarea>				
				</div>
				<button name="submit" type="submit" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Add</button>
			</form>
			&nbsp;
			<div>
			<?php
                foreach (array_reverse($c) as $comment) {
                    ?>
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"><?=$comment->author;
                    ?></h3>
						<small><?=date('h:iA, jS M Y', strtotime($comment->created_at));
                    ?></small>
					</div>
					<div class="panel-body">
						<?=$comment->body;
                    ?>
					</div>
				</div>
			<?php 
                } ?>
			</div>
		</div>
	</div>
</div>

<br>
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
<?php
require_once(__DIR__.'/../includes/helpers.php');
require_once(__DIR__.'/../loader.php');
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 2;
$pics = Pics::findPaginate($page, $per_page);
if (!$pics) {
    redirect_to('index.php');
}
$paging = $pics[count($pics)-1];
$images = array_pop($pics);
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
<h1 class="text-center">Welcome to Photolia</h1>
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
	<?php 
    foreach ($pics as $p) {
        ?>
		<div class="col-lg-6">
			<div class="thumbnail">
				<a style="text-decoration:none;" href="/<?=$p->slug;
        ?>"><img style="width:512px;height:512px;" src="images/<?=$p->filename;
        ?>" alt="<?=$p->caption;
        ?>">
				&nbsp;
				<div class="caption" style="background:#428bca;border-radius:0px 0px 10px 10px;color:#fff">
					<h4 class="text-center"><?=$p->caption;
        ?></h4>
				</div>
				</a>
			</div>
		</div>
	<?php

    }
    ?>
	</div>
</div>
<div class="text-center">
<ul class="pagination">
<?php

if ($paging->total_pages() > 1) {
    if ($paging->has_prev_page()) {
        echo "<li><a href='/?page={$paging->prev_page()}'> < </a></li>";
    } else {
        echo '<li class="disabled"><span> < </a></span></li>';
    }
    
    for ($i=1; $i<= $paging->total_pages(); $i++) {
        if (isset($_GET['page'])) {
            if ($_GET['page'] == $i) {
                echo "<li class='active'><a href=''>{$i}</a></li>";
            } else {
                echo "<li><a href='/?page={$i}'>{$i}</a></li>";
            }
        }
        
        if (empty($_GET['page'])) {
            if ($i == 1) {
                echo "<li class='active'><a href=''>{$i}</a></li>";
            } else {
                echo "<li><a href='/?page={$i}'>{$i}</a></li>";
            }
        }
    }
    
    if ($paging->has_next_page()) {
        echo "<li><a href='/?page={$paging->next_page()}'> ></a></li>";
    } else {
        echo '<li class="disabled"><span> > </span></li>';
    }
}
?>
<!--


<li class="active"><span>1</span></li>
<li><a href="?page=2">2</a></li>
<li><a href="https://dashtics.com/manage/users?page=2" rel="next">»</a></li> 
</ul>
-->
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

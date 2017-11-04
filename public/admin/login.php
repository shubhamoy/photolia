<?php
	require_once(__DIR__.'/login.header.php');
?>
<br>
<div class="row">
	<div class="col-lg-4 col-lg-offset-4">
		<h1 class="text-center">Login to Photolia</h1>
		<form method="POST" action="login.php" class="form-horizontal">
		<?=$msg; ?>
			<input type="text" class="form-control" name="username" placeholder="Enter your username">
			&nbsp;
			<input type="password" class="form-control" name="password" placeholder="Enter your password">
					&nbsp;
			<button type="submit" class="btn btn-primary btn-block" name="submit">Login</button>
		</form>
		&nbsp;<br>
		<div class="text-right">
         <span class="glyphicon glyphicon-tag"></span> <a href="/">Visit Homepage</a>
     </div>
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
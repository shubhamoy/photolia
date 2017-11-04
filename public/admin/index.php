<?php require_once(__DIR__.'/index.header.php'); ?>

		<div class="container">
			<div class="row">
			  <div class="col-sm-6 col-md-4">
			    <a href="addpic.php" class="button-link">
			    	<div class="thumbnail">
			      		<span class="glyphicon glyphicon-upload button-glyph" aria-hidden="true"></span>
			      		<div class="caption">
			        		<h3 class="text-center">Add Picture</h3>
			      		</div>
			    	</div>
			    </a>
			  </div>
			  <div class="col-sm-6 col-md-4">
			    <a href="managepics.php" class="button-link">
			    	<div class="thumbnail">
			      		<span class="glyphicon glyphicon-picture button-glyph" aria-hidden="true"></span>
			      		<div class="caption">
			        		<h3 class="text-center">Manage Pictures</h3>
			      		</div>
			    	</div>
			    </a>
			  </div>
			  <div class="col-sm-6 col-md-4">
			    <a href="addpic.php" class="button-link">
			    	<div class="thumbnail">
			      		<span class="glyphicon glyphicon-user button-glyph" aria-hidden="true"></span>
			      		<div class="caption">
			        		<h3 class="text-center">Add User</h3>
			      		</div>
			    	</div>
			    </a>
			  </div>
			</div>
			<div class="row">
				<div class="col-sm-6 col-md-4">
					<a href="manageusers.php" class="button-link">
						<div class="thumbnail">
							<span class="glyphicon glyphicon-user button-glyph" aria-hidden="true"></span>
							<div class="caption">
								<h3 class="text-center">Manage Users</h3>
							</div>
						</div>
					</a>
				</div>
				<div class="col-sm-6 col-md-4">
					<a href="managecomments.php" class="button-link">
						<div class="thumbnail">
							<span class="glyphicon glyphicon-comment button-glyph" aria-hidden="true"></span>
							<div class="caption">
								<h3 class="text-center">Comments</h3>
							</div>
						</div>
					</a>
				</div>
				<div class="col-sm-6 col-md-4">
					<a href="logfile.php" class="button-link">
						<div class="thumbnail">
							<span class="glyphicon glyphicon-list-alt button-glyph" aria-hidden="true"></span>
							<div class="caption">
								<h3 class="text-center">Logs</h3>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div><!-- /.container -->
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
<?php require_once('logfile.header.php'); ?>
<div class="text-center">
	<form method="POST" accept-charset="UTF-8">
		<input type="hidden" name="reset">
		<input type="hidden" name="token" value="<?=CSRF::token();?>">
		<button type="submit" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
	</form>	
</div>
<br>
<div id="no-more-tables">
	<table class="table table-striped">
		<thead>
			<tr>
                <th class="text-center">User</th>
                <th class="text-center">File</th>
                <th class="text-center">Action</th>
                <th class="text-center">Time</th>
                <th class="text-center">IP</th>
            </tr>
		</thead>
		<tbody>			
<?php
foreach ($l as $word) {
    echo <<<END
		<tr> 
			<td class="text-center" data-title="User">$word[2]</td> 
			<td class="text-center" data-title="File">$word[1]</td> 
			<td class="text-center" data-title="Action">$word[3]</td> 
			<td class="text-center" data-title="Time">$word[0]</td>
			<td class="text-center" data-title="IP">$word[4]</td> 
		</tr> 
END;
}
?>
	</tbody>
  </table>
  <ul class="pagination">
<?php

if ($paging->total_pages() > 1) {
    if ($paging->has_prev_page()) {
        echo "<li><a href='?page={$paging->prev_page()}'> < </a></li>";
    } else {
        echo '<li class="disabled"><span> < </a></span></li>';
    }
    
    for ($i=1; $i<= $paging->total_pages(); $i++) {
        if (isset($_GET['page'])) {
            if ($_GET['page'] == $i) {
                echo "<li class='active'><a href=''>{$i}</a></li>";
            } else {
                echo "<li><a href='?page={$i}'>{$i}</a></li>";
            }
        }
        
        if (empty($_GET['page'])) {
            if ($i == 1) {
                echo "<li class='active'><a href=''>{$i}</a></li>";
            } else {
                echo "<li><a href='?page={$i}'>{$i}</a></li>";
            }
        }
    }
    
    if ($paging->has_next_page()) {
        echo "<li><a href='?page={$paging->next_page()}'> ></a></li>";
    } else {
        echo '<li class="disabled"><span> > </span></li>';
    }
}
?>
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

</body>
</html>
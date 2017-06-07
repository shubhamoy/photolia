<?php
    spl_autoload_register(function ($class) {
        require_once('includes/'.ucfirst($class).'.php');
    });
    require_once('includes/Session.php');
?>

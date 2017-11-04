<?php
    require_once('includes/helpers.php');

    spl_autoload_register(function ($class) {
        require_once('includes/'.ucfirst($class).'.php');
    });
    require_once('includes/Session.php');
    
    if(!check_db()) {
        if($_SERVER['SCRIPT_NAME'] === '/install.php'){
            
        } else {
            redirect_to('/install.php');
        } 
    } 
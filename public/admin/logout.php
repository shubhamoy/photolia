<?php
    require_once(__DIR__.'/../../includes/helpers.php');
    require_once(__DIR__.'/../../loader.php');
    
    Logger::start()->add(User::getUser($_SESSION['uid'])->username, $_SERVER['PHP_SELF'], 'Logout', getIP());
    $a = new Auth;
    $a->logout();
<?php

require_once("utils/functions.php");

$base = dirname($_SERVER['PHP_SELF']); 

if(ltrim($base, '/')) { 
    $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen($base));
}

checkRequestMethod();

sec_session_start();

require_once('core/Router.php');

?>
<?php 

function checkRequestMethod() {
    if(isset($_POST['_method'])) {
        $method = strtoupper($_POST['_method']);
        $_SERVER['REQUEST_METHOD'] = $method;
    }
}

function sec_session_start() {
    $session_name = 'sec_session_id'; 
    $secure = false; // Set to true if you want https. 
    $httponly = true; // Javascript can't access to the session id. 
    ini_set('session.use_only_cookies', 1); 
    $cookieParams = session_get_cookie_params(); 
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
    session_name($session_name); 
    session_start(); 
    session_regenerate_id(); 
}

?>

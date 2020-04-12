<?php

$base = dirname($_SERVER['PHP_SELF']);

define("LOGOUT", $base . "/auth");
define("LOGIN",  $base . "/auth");
define("SIGNUP", $base . "/auth/create");
define("HOME",   $base . "/home");
define("EVENT",  $base . "/events/");
define("ADMIN",  $base . "/admin/");
define("USER",   $base . "/users/");
define("CART",   $base . "/cart");

/* images paths */
define("IMAGE_PATH", $base . "/uploads/");

/* javascript libraries */
define("JS_QUERY",  $base . "/js/jquery-3.4.1.min.js");
define("JS_SHA512", $base . "/js/sha512.js");
define("JS_FORMS",  $base . "/js/forms.js");
define("JS_LIB_CHART", $base . "/js/Chart.min.js");
define("JS_CHARTS", $base . "/js/charts.js");
define("JS_SEARCH", $base . "/js/search.js");
define("JS_NOTIFY", $base . "/js/notify.js");
define("JS_ALERT", $base . "/js/ticket-alerts.js");
define("JS_CART", $base . "/js/cart.js");
define("JS_ADMIN_NOTIFY", $base . "/js/admin_notify.js");
define("JS_USER_CHART", $base . "/js/user_chart.js");

/* login errors */
define("BRUTE_ERR", 1);
define("PASSW_ERR", 2);
define("USER_ERR",  3);
define("LOGIN_ERR", 4);
define("APPR_ERR",  5);

const login_errors = [
  "",
  "The account is disabled!",
  "Incorrect password!",
  "Incorrect email!",
  "An error has occured!",
  "The user has to be approved!"
];

/* signup errors */
define("USER_EXS", 1);
define("SIGNUP_ERR", 2);

const signup_errors = [
  "",
  "User already registered",
  "An error has occured",
];


?>

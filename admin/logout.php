<?php
set_include_path(dirname(__FILE__) . '/../');

include_once "inc/error.php";
include_once "inc/session.php";

session_end();
header("Location: http://bio.g6.cz/admin");

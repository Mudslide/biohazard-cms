<?php
set_include_path(dirname(__FILE__) . '/../');

include_once("inc/error.php");
include_once("inc/session.php");

if(!session_exists()){
 header("Location: http://".$_SERVER['HTTP_HOST']."/admin/login.php");
 exit();
}

include("view/begin.php");
include("view/admin/sidebar.php");
include("view/middle.php");
echo("Vítejte v administraci!");
include("view/end.php");

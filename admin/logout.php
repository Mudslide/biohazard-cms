<?php

include_once "../inc/error.php";
include_once "../inc/session.php";

session_end();
header("Location: http://bio.g6.cz/admin");

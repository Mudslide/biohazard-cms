<?php
//Inner function - not escaped!
function error($str){
 include("./view/begin.php");
 echo "<ul><li><a href='http://bio.g6.cz'>Hlavní stránka</a></li></ul>";
 include("./view/middle.php");
 echo $str;
 include("./view/end.php");
 exit();
}

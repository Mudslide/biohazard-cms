<?php
$connect = new mysqli(
 'localhost',
 'mudsl1381577265',
 'OKj5pz3',
 'mudsl1381577265'
);
$connect->set_charset("utf8"); 
if($connect->mysqli_connect_errno){
 //FIXME Possible security hole
 exit('Nepodařilo se připojit k mysql databázi'.mysqli_connect_errno());
}

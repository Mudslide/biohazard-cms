<?php
include_once("./inc/error.php");
$ini = parse_ini_file("./inc/connect.ini",1);
if(!$ini){
 error("Podprogramu se nepodařilo načíst soubor s nastavením. Zkontrolujte <i>inc/connect.ini</i>");
}
$connect = new mysqli(
 $ini['connect']['host'],
 $ini['connect']['user'],
 $ini['connect']['pass'],
 $ini['connect']['dbnm']
);
$connect->set_charset("utf8"); 
if($connect->mysqli_connect_errno){
 //FIXME Possible security hole
 exit('Nepodařilo se připojit k mysql databázi'.mysqli_connect_errno());
}

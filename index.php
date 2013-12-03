<?php
include("inc/database.php");
include("view/begin.php");
echo("<ul>");


$query = "SELECT * FROM class ORDER BY id";
if($result = $connect->query($query)){
 while($row = $result->fetch_assoc()){
  $class = $row['class'];
  if($row['viditelnost'] == 1){
   echo('<li><a href="list.php?class='.$class.'">'.$class.'</a></li>');
  }
 }
}

echo("</ul>");

include("view/middle.php");

echo("<h3>Nejnovější příspěvky</h3>");

$query = "SELECT * FROM soubory ORDER BY id desc";
if($result = $connect->query($query)){
 while($row = $result->fetch_assoc()){
  if($row['viditelnost'] == 1){
   $popis = htmlspecialchars($row['popis'], ENT_QUOTES, "UTF-8");
   if(strlen($popis)>42){
    $popis = substr($popis,0,42)."...";
   }
  }
  if($row['id']>15){
   break;
  }
 }
}
include("view/end.php");

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
$i = 0;
if($result = $connect->query($query)){
 while($row = $result->fetch_assoc()){
  if($row['viditelnost'] == 1){
   $i++;
   $popis = htmlspecialchars($row['popis'], ENT_QUOTES, "UTF-8");
   if(strlen($popis)>42){
    $popis = substr($popis,0,42)."...";
    echo '<span class=row><a class=nadpis href="topic.php?id='.$row['id'].'">'.$row['nadpis'].'</a> &bull; '.$popis."</span>";
   }
  }
  if($i>15){
   break;
  }
 }
}
include("view/end.php");

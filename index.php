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

echo("<div class=table>");
$query = "SELECT * FROM soubory ORDER BY id desc";
$i = 0;
if($result = $connect->query($query)){
 while($row = $result->fetch_assoc()){
  if($row['viditelnost'] == 1){
   $i++;
   
   $popis  = $row['popis'];
   $nadpis = $row['nadpis'];
   
   $popis  = preg_replace("/<br\\/?>$/i","",$popis);
   $popis  = htmlspecialchars($popis, ENT_QUOTES, "UTF-8");
   $nadpis = htmlspecialchars($row['nadpis'],ENT_QUOTES, "UTF-8");
   
   if(strlen($popis)>42){
    $popis = substr($popis,0,42)."...";
   }
   if(strlen($nadpis)>28){
    $nadpis = substr($nadpis,0,18)."...";
   }
   echo '<span class=row><a class=nadpis href="topic.php?id='.$row['id'].'">'.$nadpis.'</a> <span class=popis>'.$popis."</span></span>";
  }
  if($i>15){
   break;
  }
 }
}
echo("</div>");
include("view/end.php");

<?php
include("inc/database.php");
include("view/begin.php");
echo("<ul>");
echo("<li><a href=index.php>Přehled</a></li>");

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

echo("<h3>Třída: ".$_GET['class']."</h3>");

echo("<div class=table>");
if(isset($_GET['class']) && !empty($_GET['class'])){
 $class  = $connect->real_escape_string($_GET['class']);
 $query = "SELECT * FROM soubory WHERE class='$class' ORDER BY id desc";
 
 if($result = $connect->query($query)){
  while($row = $result->fetch_assoc()){
   if($row['viditelnost'] == 1){
    $popis  = $row['popis'];
    $nadpis = $row['nadpis'];
    
    $popis  = preg_replace("/<br\\/?>$/i","",$popis);
    $popis  = htmlspecialchars($popis, ENT_QUOTES, "UTF-8");
    $nadpis = htmlspecialchars($row['nadpis'],ENT_QUOTES, "UTF-8");
    
    echo("<span class=row>");
    
    if(!empty($row['soubor'])){
     $real_name = $row['real_name'];
     $file_name = $row['soubor'];
     $file_name = '<a href="../files/'.$file_name.'"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/clip.png" /></a>'; 
    }else{
     $file_name = '<img src="http://'.$_SERVER['HTTP_HOST'].'/img/empty.png" />';
    }
    echo($file_name.' <a class=nadpis href="topic.php?id='.$row['id'].'">'.$row['nadpis'].'</a> <span class=popis>'.$popis.'</span></span>');
   }
  }
 }
}
echo("</div>");

include("view/end.php");

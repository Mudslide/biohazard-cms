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
   
if(isset($_GET['class']) && !empty($_GET['class'])){
 $class  = $connect->real_escape_string($_GET['class']);
 $query = "SELECT * FROM soubory WHERE class='$class' ORDER BY id";
 
 if($result = $connect->query($query)){
  while($row = $result->fetch_assoc()){
   if($row['viditelnost'] == 1){
    $popis = htmlspecialchars($row['popis']);
    if(strlen($popis)>42){
     $popis = substr($popis,0,42)."...";
    }
    if(!empty($row['soubor'])){
     $real_name = $row['real_name'];
     $file_name = $row['soubor'];
     $file_name = '<a href="../files/'.$file_name.'"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/clip.png" /></a>'; 
    }else{
     $file_name = '<img src="http://'.$_SERVER['HTTP_HOST'].'/img/empty.png" />';
    }
    echo('<span class=row>'.$file_name.' <a class=nadpis href="topic.php?id='.$row['id'].'">'.$row['nadpis'].'</a> &bull; '.$popis.'</span>');
   }
  }
 }
}

include("view/end.php");

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
    if(!empty($row['soubor'])){
     $real_name = $row['real_name'];
     $file_name = $row['soubor'];
     $file_name = '<a href="../files/'.$file_name.'">'.$real_name.'</a>'; 
    }
    echo('<a href="topic.php?id='.$row['id'].'">'.$row['nadpis'].'</a>   '.$row['popis'].'   '.$file_name);
   }
  }
 }
}

include("view/end.php");

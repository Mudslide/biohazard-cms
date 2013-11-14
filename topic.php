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
if($_GET['id']){
  $id = $_GET['id'];
  $query_topic = "SELECT * FROM soubory WHERE id='$id'";
  if($result_topic = $connect->query($query_topic)){
    $row_topic = $result_topic->fetch_assoc();
    echo $row_topic['nadpis']."<br>";
    echo $row_topic['popis']."<br>";
    if($row_topic['soubor']){
      echo $row_topic['soubor']; 
    }
    echo date($row_topic['date'])."<br>";
  }
}

include("view/end.php");

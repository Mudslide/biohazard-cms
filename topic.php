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
    echo "<h3 class=nadpis>".$row_topic['nadpis']."</h3>";
    echo "<div class=clanek>".$row_topic['popis']."</div>";
    if($row_topic['soubor']){
      echo '<span class=row><a href="http://'.$_SERVER['HTTP_HOST'].'/files/'.$row_topic['soubor'].'"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/clip.png" /> '.$row_topic['real_name'].'</a></span>'; 
    }
    echo "<span class=date>".date("m. d. Y, H:i", $row_topic['date'])."</span>";
  }
}

include("view/end.php");

<?php
set_include_path(dirname(__FILE__) . '/../');

include_once("inc/error.php");
include_once("inc/session.php");

if(!session_exists()){
 header("Location: http://".$_SERVER['HTTP_HOST']."/admin/login.php");
 exit();
}

include("view/begin.php");
include("view/admin/sidebar.php");
include("view/middle.php");
include_once("inc/database.php");

if($_GET['id']){
  $id = $_GET['id'];
  $query_topic = "SELECT * FROM soubory WHERE id='$id'";
  if($result_topic = $connect->query($query_topic)){
    $row_topic = $result_topic->fetch_assoc();
    echo "<h3 class=nadpis>".$row_topic['nadpis']."</h3>";
    echo "<div class=clanek>".$row_topic['popis']."</div>";
    if($row_topic['soubor']){
      echo '<span class=row><a href="http://'.$_SERVER['HTTP_HOST'].'/files/'.$row_topic['soubor'].'" download><img src="http://'.$_SERVER['HTTP_HOST'].'/img/clip.png" /> '.$row_topic['real_name'].'</a></span>'; 
    }
    echo "<span class=date>".date("d. m. Y, H:i", $row_topic['date'])."</span>";
  }
}

include("view/end.php");

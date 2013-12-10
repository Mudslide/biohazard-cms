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
if($_GET['id']){
 $id = $_GET['id'];
 $query_topic = "SELECT * FROM soubory WHERE id='$id'";
 if($result_topic = $connect->query($query_topic)){
  $row_topic = $result_topic->fetch_assoc();
  
  //Kdyby PHP nebylo tak blbý, mohl z toho bejt krásnej 1liner :(
  $viditelnost_tridy =
   $connect
   ->query(
    "SELECT * FROM class WHERE class='".$row_topic['class']."'"
   );
  $viditelnost_tridy = $viditelnost_tridy->fetch_assoc()['viditelnost'];
  //A já mám rád 1liners...
  
  if($row_topic['viditelnost']&&$viditelnost_tridy){
   echo "<h3 class=nadpis>".$row_topic['nadpis']."</h3>";
   echo "<div class=clanek>".$row_topic['popis']."</div>";
   if($row_topic['soubor']){
    echo '<span class=row><a href="http://'.$_SERVER['HTTP_HOST'].'/files/'.$row_topic['soubor'].'"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/clip.png" /> '.$row_topic['real_name'].'</a></span>'; 
   }
   echo "<span class=date>".date("d. m. Y, H:i", $row_topic['date'])."</span>";
  }else{
   $_JOLANDA['nadpis'] = "To není normální!";
   $_JOLANDA['zprava'] = "Příspěvek neexistuje - možná byl smazán nebo je skrytý - ale jediné, co s tím můžete dělat je kontaktovat správce.";
   include("view/jolanda.php");
  }
 }
}

include("view/end.php");

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

if(isset($_GET['del']) && !empty($_GET['del'])){
 include_once "inc/database.php";
 $id = $_GET['del'];
 $query_01 = "SELECT soubor FROM soubory WHERE id=".$id;
 
 if($result_01 = $connect->query($query_01)){
  $row = $result_01->fetch_assoc();
  
  if(!empty($row['soubor'])){
   $soubor = $row['soubor']; 
   unlink("../files/$soubor");
  }
  
  $query_02 = "DELETE FROM soubory WHERE id=".$id;
  
  if($result = $connect->query($query_02)){
   echo('<script type="text/javascript">alert("Příspěvek smazán"); document.location = "set.php?list='.urlencode($_GET['list']).'";</script>');
  }
 }
}

if(isset($_GET['vis']) && !empty($_GET['vis'])){
 include "inc/database.php";
 $values = explode('E',$_GET['vis']);
 $query = "UPDATE soubory SET viditelnost = '".$values[0]."' WHERE id='".$values[1]."'";
 if($result = $connect->query($query)){
  echo '<script type="text/javascript">document.location = "set.php?list='.urlencode($_GET['list']).'";</script>';
 }
}


?>
     
   <form action method="get">
    <select name="list">
      <?php
      include "connect/inc.php"; //includuje connect.php prostě připojí mysql
        $query_01 = "SELECT * FROM class ORDER BY id";
        if ($result = $connect->query($query_01)) {
          while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['class'].'"';
            if($row['class']==$_GET['list']){
             echo " selected";
            }
            echo '>'.$row['class'].'</option> ';
          }
        }
      
      ?>
      
    </select>
    <button type="submit">Zobrazit</button>
  </form>
    
    
    
<?php

  if(isset($_GET['list']) && !empty($_GET['list'])){
    include "inc/database.php";
      $query = "SELECT * FROM soubory ORDER by ID DESC";
      $class = $_GET['list'];
       
    if ($result = $connect->query($query)) {
     $count = $result->num_rows;
     if($count == 0){
      //TODO Teď sčítá příspěvky všech tříd dohromady!
      //echo 'Tato třída nemá zatím žádný příspěvek';
     }else{
      //echo 'Nalezeno '.$count.' příspěvků<br /><br />';
     }
     
     while ($row = $result->fetch_assoc()) {
      if($row['class'] == $class){
       $id = $row['id'];
       $nadpis= $row['nadpis'];
       $popis = $row['popis'];
       $popis = preg_replace("/<br\\/?>$/i","",$popis);
       $nadpis = preg_replace("/<br\\/?>$/i","",$nadpis);
       $popis = htmlspecialchars($popis);
       $nadpis= htmlspecialchars($nadpis);
       if(strlen($nadpis)>32){
        $nadpis = substr($nadpis,0,24)."...";
       }
       if(strlen($popis)>42){
        $popis = substr($popis,0,42)."...";
       }
       
       if(!empty($row['soubor'])){
        $file_name = $row['soubor'];
        $file_name = '<a href="http://'.$_SERVER['HTTP_HOST'].'/files/'.$file_name.'"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/clip.png" /></a>'; 
       }else{
        $file_name = '<img src="http://'.$_SERVER['HTTP_HOST'].'/img/empty.png" />';
       }
       
       if($row['viditelnost'] == 1 ){
        $viditelnost = '<a href="set.php?vis=0E'.$id.'&list='.urlencode($_GET['list']).'"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/vis.png" /></a>';    
       }else{
        $viditelnost = '<a href="set.php?vis=1E'.$id.'&list='.urlencode($_GET['list']).'"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/hid.png" /></a>';
       }
       
       echo('<span class=row>'.$file_name.' <a href="set.php?del='.$id.'&list='.urlencode($_GET['list']).'"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/del.png" /></a> '.$viditelnost.' <a href="topic.php?id='.$row['id'].'"><strong>'.$nadpis.'</strong></a> &bull; '.$popis.' &bull; ID: '.$row['id'].'</span>');
      }
     }
     //$result->free();
    }
    $connect->close();
 }


include("view/end.php");?>

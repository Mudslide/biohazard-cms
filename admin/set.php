<?php

include_once("../inc/error.php");
include_once("../inc/session.php");

if(!session_exists()){
 header("Location: http://bio.g6.cz/admin/login.php");
 exit();
}

include("../view/begin.php");
include("../view/admin/sidebar.php");
include("../view/middle.php");
include_once("../inc/connect.php");

if(isset($_GET['del']) && !empty($_GET['del'])){
 include_once "../inc/connect.php";
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
   echo('<script type="text/javascript">alert("Příspěvek smazán"); document.location = "set.php";</script>');
  }
 }
}

if(isset($_GET['vis']) && !empty($_GET['vis'])){
 include "connect/inc.php";
 $values = explode('E',$_GET['vis']);
 $query = "UPDATE soubory SET viditelnost = '".$values[0]."' WHERE id='".$values[1]."'";
 if($result = $connect->query($query)){
  echo '<script type="text/javascript">alert("Příspěvek byl upraven"); document.location = "set.php";</script>';
 }
}


?>
     
     <form action="#" method="POST">
    <select name="list">
      <?php
      include "connect/inc.php"; //includuje connect.php prostě připojí mysql
        $query_01 = "SELECT * FROM class ORDER BY id";
        if ($result = $connect->query($query_01)) {
          while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['class'].'">'.$row['class'].'</option> ';
          }
        }
      
      ?>
      
    </select>
    <input type="submit" value="Zobrazit">
  </form>
    
    
    
<?php

  if(isset($_POST['list']) && !empty($_POST['list'])){
    include "connect/inc.php";
      $query = "SELECT * FROM soubory ORDER by ID DESC";
      $class = $_POST['list'];
       
    if ($result = $connect->query($query)) {
      $count = $result->num_rows;
      if($count == 0){
         echo 'Tato třída nemá zatím žádný příspěvek';
      }else{
      echo 'Nalezeno '.$count.'<br /><br />';
      }
      
      while ($row = $result->fetch_assoc()) {
        if($row['class'] == $class){
            $id = $row['id']; 
            
            
            if(!empty($row['soubor'])){
            $file_name = $row['soubor'];
            $file_name = '<a href="../files/'.$file_name.'">Soubor</a>'; 
            }
            
            if($row['viditelnost'] == 1 ){
              $viditelnost = '<a href="set.php?vis=0E'.$id.'">Skrýt</a>';    
            }else{
              $viditelnost = '<a href="set.php?vis=1E'.$id.'">Zobrazit</a>';
            }
            
            echo '<a href="set.php?del='.$id.'">Smazat</a>   '.$viditelnost.'   '.$row['id'].'   '.$row['nadpis'].'   '.$row['popis'].'   '.$file_name;
            echo "<br />";
        }
      }
      //$result->free();
    }
    $connect->close();
 }


include("../view/end.php");?>

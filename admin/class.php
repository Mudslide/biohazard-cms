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
?>
  <form action="#" method="POST" enctype="multipart/form-data">
    <input type="text" name="class" placeholder="Jméno třídy" required>
    <span class=row><label>Zobrazit třídu: <input type="checkbox" name="viditelnost" value="ano" checked></label></span>
    <button type="submit">Přidat</button>
  </form>
  <br/>
<?php
if(isset($_GET['del']) && !empty($_GET['del'])){ //TODO Proč ne if($_GET['del'])?
 $class = $_GET['del'];
 $query_01 = 'SELECT soubor FROM soubory WHERE class="'.$_GET['del'].'"';
 if($result = $connect->query($query_01)){
  while($row = $result->fetch_assoc()){
   $soubor = $row['soubor'];
   unlink("../files/$soubor");
  }
 }
 
 $query_02 = 'DELETE FROM class WHERE class="'.$_GET['del'].'"'; //FIXME Security hole
 if($result = $connect->query($query_02)){
  $query_02 = 'DELETE FROM soubory WHERE class="'.$_GET['del'].'"';
  if($result = $connect->query($query_02)){
   echo('<script type="text/javascript">alert("Třída a dokumenty smazány"); document.location = "class.php";</script>');
  }
 }
}
  
if(isset($_GET['vis']) && !empty($_GET['vis'])){ //TODO Proč ne if($_GET['vis'])?
 $values = explode('E',$_GET['vis']);
 $query = "UPDATE class SET viditelnost = '".$values[0]."' WHERE id='".$values[1]."'"; //FIXME Security hole
 if($result = $connect->query($query)){
  echo('<script type="text/javascript">alert("Třída byl upravena");document.location = "class.php";</script>');
 }
}

$query_01 = "SELECT * FROM class ORDER BY id";
if($result = $connect->query($query_01)){
 while ($row = $result->fetch_assoc()){
  $class = $row['class'];
  $id = $row['id']; 
  if($row['viditelnost'] == 1 ){
   $viditelnost = '<a href="class.php?vis=0E'.$id.'"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/vis.png" /></a>';    
  }else{
   $viditelnost = '<a href="class.php?vis=1E'.$id.'"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/hid.png" /></a>';
  }
  echo('<span class=row><a href="class.php?del='.$class.'"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/del.png" /></a>  '.$viditelnost.' '.$row['class'].' &bull; ID:'.$id.'</span>'); 
 }
}

if(isset($_POST['class']) && !empty($_POST['class'])){ //TODO Proč ne if($_POST['class'])?
 $class = $connect->real_escape_string($_POST['class']);
 if(isset($_POST['viditelnost'])){ //TODO Proč ne if($_POST['viditelnost'])?
  $viditelnost = 1;
 }else{
  $viditelnost = 0;
 }
 
 $query = "INSERT INTO class (class,viditelnost) VALUES ('".$class."','".$viditelnost."')";
 if($connect->query($query)){
  echo('<script type="text/javascript">alert("Třída byl uložena (ID třídy: '.$connect->insert_id.')"); document.location = "class.php";</script>');
 }  
}

include("view/end.php");

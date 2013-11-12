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
include_once("../inc/database.php");


if(isset($_POST['nadpis']) && !empty($_POST['nadpis']) && isset($_POST['trida'])){
 $file = $_FILES['file']; //$_FILES je isset a !empty pořád
 $time = time(); //čas příspěvku
 
 //deklarace vstupů a escapovaní "SQL infection"
 $class  = $connect->real_escape_string($_POST['trida' ]);
 $nadpis = $connect->real_escape_string($_POST['nadpis']);
 $popis  = $connect->real_escape_string($_POST['popis' ]);
 
 if($_POST['viditelnost']){ 
  $viditelnost = 1;
 }else{
  $viditelnost = 0;
 }
 
  if(!empty($file['name'])){ //VYSVĚTLENÍ problém je v tom že if($_FILES['file'];) je pořád TRUE když je prázdný i když ne, no takže to vezme jméno nahráteho souboru které není prázdný nikdy  
    if($file["error"] !== UPLOAD_ERR_OK){
    //Chyba nahrávání mezi klientem a serverem
    $error[0] = "Soubor nebyl v pořádku nahrán (Error 01)\n"; 
    }
  
    $dir = "../files/";
    $info = pathinfo($file["name"]); //informace o souboru (připona etc.)
    $name = $time.'.'.$info['extension'];
    $name = $connect->real_escape_string($name); //aby měl soubor stejný název v mysql i ve složce
    $real_name = $connect->real_escape_string($file['name']); 
    $success = move_uploaded_file($file["tmp_name"], $dir.$name); //uložení souboru do složky files
    if(!$success){
      //Chyba při ukládání do složky
    $error[1] = "Soubor nebyl v pořádku nahrán (Error 02)\n"; 
    }
  }
 
  $query = "INSERT INTO soubory (date, class, nadpis ,popis ,soubor, real_name , viditelnost ) VALUES ( '".$time."', '".$class."', '".$nadpis."', '".$popis."' , '".$name."' , '".$real_name."' , '".$viditelnost."')";
 
  if (!$connect->query($query)){
    //Chyba při odesílání query
    $error[3] = "Připojení do mysql neproběhlo v pořádku (Error 03)";
  }
 
  //JS alert + přesměrování (aby se při refreshi soubory nenahrály znovu)
  if(!empty($error)){
    echo('<script type="text/javascript">alert("'.$error[0] . $error[1] . $error[3].'"); document.location = "add.php";</script>'); 
  }else{
    echo('<script type="text/javascript">alert("Příspěvek byl uložen (ID přispěvku: '.$connect->insert_id.')"); document.location = "add.php";</script>'); 
 }
}


?>
  <form action="#" method="POST" enctype="multipart/form-data">
    <input type="text" name="nadpis" placeholder="Nadpis" required>
      <br />
<?php
$query_01 = "SELECT * FROM class ORDER BY id";
if($result = $connect->query($query_01)){
 while($row = $result->fetch_assoc()){
  echo('<input type="radio" name="trida" value="'.$row['class'].'" required>'.$row['class'].'<br>'); 
 }
}
?>
      <br />
    <textarea name="popis" placeholder="Popis"></textarea>
      <br />
      <br />
    Zobrazit příspěvek: <input type="checkbox" name="viditelnost" value="ano" checked>
      <br />
      <br />
    <input type="file" name="file">
      <br />
    <input type="submit" value="Uložit">
   </form>
<?php
 include("../view/end.php");
?>

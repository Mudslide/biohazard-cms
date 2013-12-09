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


if($_POST['nadpis'] && $_POST['trida']){
  $file = $_FILES['file']; //$_FILES je isset a !empty pořád
  $time = time(); //čas příspěvku
 
  //deklarace vstupů a escapovaní "SQL infection"
  $class  = $connect->real_escape_string($_POST['trida']);
  $nadpis = $connect->real_escape_string(trim($_POST['nadpis']));
  $popis  = $connect->real_escape_string(trim($_POST['popis']));
 
  $offset = 0;
  $find = "v=";
   
  $position = strpos($popis, $find, $offset);
 
  if($position > 11){
  $a = $position + "2";
  $b = "11";
  $youtube_kod = mb_substr($text_textarea, $a, $b);
  }
  if(empty($youtube_kod)){
  $youtube_kod2 = "";
  }else{
  $youtube_kod2 = '<iframe width="420" height="315" src="http://www.youtube.com/embed/'.$youtube_kod.'" frameborder="0" allowfullscreen></iframe>'; 
  }
  $popis = $popis.'<br>'.$youtube_kod2;
 
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
 
  $query = "INSERT INTO soubory (date, class, nadpis, popis, soubor, real_name, viditelnost ) VALUES ( '".$time."', '".$class."', '".$nadpis."', '".$popis."', '".$name."', '".$real_name."', '".$viditelnost."')";
 
  if (!$connect->query($query)){
    //Chyba při odesílání query
    $error[3] = "Připojení do mysql neproběhlo v pořádku (Error 03)";
  }
 
  //JS alert + přesměrování (aby se při refreshi soubory nenahrály znovu)
  if(!empty($error)){
    echo('<script type="text/javascript">alert("'.$error[0] . $error[1] . $error[3].'"); document.location = "add.php";</script>'); 
  }else{
    echo('<script type="text/javascript">document.location = "add.php?success=1&prispevek='.$connect->insert_id.'";</script>'); 
 }
}


?>
  <form class=add action method="post" enctype="multipart/form-data">
<?php
if($_GET['success']){
 echo('<span class=done>Příspěvek byl úspěšně nahrán! Jeho id je '.$_GET['prispevek'].'.</span>');
}
?>
    <input type="text" name="nadpis" placeholder="Nadpis" required/></span>
<?php
$query_01 = "SELECT * FROM class ORDER BY id";
$existuje_trida = false;
if($result = $connect->query($query_01)){
 while($row = $result->fetch_assoc()){
  echo('<label><input type="radio" name="trida" value="'.$row['class'].'" required />'.$row['class'].'</label>'); 
  $existuje_trida = true;
 }
}
if(!$existuje_trida){
 echo('<span>Nejprve prosím vytvořte třídu!</span>');
}
?>
    <textarea name="popis" placeholder="Popis"></textarea>
    <span>Zobrazit příspěvek: <input type="checkbox" name="viditelnost" value="ano" checked></span>
    <span>Příloha: <input type="file" name="file"></span>
    <?php if($existuje_trida){ ?>
     <button type="submit">Uložit</button>
    <?php } ?>
   </form>
   
   <!-- Prevent from submitting form by pressing enter -->
   <script>
    function nextField(n){
     var i = Array.prototype.indexOf.call(n.form.elements,n);
     while(
      ++i < n.form.elements.length
     ){
      if(n.form.elements[i].tabIndex+1){
       n.form.elements[i].focus();
       if(n.form.elements[i].type == "text"){
        n.form.elements[i].select();
       }
       break;
      }
     }
    }
    
    function kpress(e){
     if(
      e.keyCode==13&
      e.target.tagName.toLowerCase()!="textarea"&
      e.target.tagName.toLowerCase()!="button"
     ){
      if(e.target.form){
       nextField(e.target);
      }
      e.preventDefault();
      e.returnValue=false;
      e.cancel = true;
     }
    }
    
    document.addEventListener("keypress",kpress);
   </script>
<?php
 include("view/end.php");
?>

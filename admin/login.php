<?php
set_include_path(dirname(__FILE__) . '/../');

include_once("inc/error.php");
include_once("inc/session.php");

if(session_exists()){
  header("Location: http://bio.g6.cz/admin");
  exit();
 
 } elseif($_GET['user']) {
 
  $ini = parse_ini_file("../inc/connect_test.ini",1);
  if(!$ini){
    error("Podprogramu se nepodařilo načíst soubor s nastavením. Zkontrolujte <i>inc/connect.ini</i>");
  }
 if($_GET['user'] == $ini['user']['name'] && $_GET['pass'] == $ini['user']['password']){
  //Successful login
  session_create();
  header("Location: http://bio.g6.cz/admin");
  exit();
  
 }else{
  //Login failed
  $fail = true;
  
 }
}

include("view/begin.php");

echo("<ul>");
echo(" <li><a href=http://bio.g6.cz>Zpět na hlavní stránku</a></li>");
echo("</ul>");

include("view/middle.php");
?>
   <h2>Přihlášení do administrace</h2>
    
    <?php if($fail){ ?>
     <!-- Login failed -->
     <span class=fail>Přihlášení se nezdařilo</span>
    <?php } ?>
    
    <form>
     <input name=user />
     <input name=pass type=password />
     <button type=submit>Přihlásit!</button>
    </form>
<?php include("view/end.php");?>

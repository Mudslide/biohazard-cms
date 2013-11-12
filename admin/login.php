<?php

include_once("../inc/error.php");
include_once("../inc/session.php");

if(session_exists()){
 header("Location: http://bio.g6.cz/admin");
 exit();
 
}elseif($_GET['user']){
 
 //Check user&password
 //TODO Use a database!
 
 if($_GET['user']=="zajicek"&&$_GET['pass']=='123'){
  //Successful login
  session_create();
  header("Location: http://bio.g6.cz/admin");
  exit();
  
 }else{
  //Login failed
  $fail = true;
  
 }
}

include("../view/begin.php");

echo("<ul>");
echo(" <li><a href=http://bio.g6.cz>Zpět na hlavní stránku</a></li>");
echo("</ul>");

include("../view/middle.php");
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
<?php include("../view/end.php");?>

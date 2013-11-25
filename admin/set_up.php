<?php
set_include_path(dirname(__FILE__) . '/../');

include_once("inc/error.php");
include_once("inc/session.php");

if(!session_exists()){
 header("Location: http://bio.g6.cz/admin/login.php");
 exit();
}

include("view/begin.php");
include("view/admin/sidebar.php");
include("view/middle.php");


if($_POST['name'] && $_POST['password'] && $_POST['email'] && $_POST['host'] && $_POST['pass'] && $_POST['dbnm']){
    $user       =  $_POST['user'];
    $pass       =  $_POST['pass'];
    $dbnm       =  $_POST['dbnm']; 
    $name       =  $_POST['name'];
    $password   =  $_POST['password'];
    $email      =  $_POST['email'];

    $my_file = '../inc/connect_test.ini'; //TODO rename to connect.inc
      if($handle = fopen($my_file, 'w+')){
          $data = '[connect]'."\n".
                  'host="localhost";       hostname'."\n".
                  'user="'.$user.'";       username'."\n".
                  'pass="'.$pass.'";       password'."\n".
                  'dbnm="'.$user.'";       database name'."\n".
                  "\n".
                  '[user]'."\n".
                  'name="'    .$name.'";   name'."\n".
                  'password="'.$password.'";   password'."\n".
                  'email="'   .$email.'";  email'."\n"
                  ;
                  
          
          fwrite($handle, $data);
          fclose($handle);
       }

}

  $ini = parse_ini_file("../inc/connect_test.ini",1);
  if(!$ini){
    error("Podprogramu se nepodařilo načíst soubor s nastavením. Zkontrolujte <i>inc/connect.ini</i>");
  }
?>
    <form action="#" method="POST" enctype="multipart/form-data">
      Jméno:  <input type="text" class="form" name="name"     value="<?php echo $ini['user']['name']; ?>" required> <br />
      Heslo:  <input type="text" class="form" name="password" value="<?php echo $ini['user']['password']; ?>" required> <br />
      Email:  <input type="email" class="form" name="email"   value="<?php echo $ini['user']['email']; ?>"required> <br />
      <br />
      Host:    <input type="text" class="form" name="host" value="<?php echo $ini['connect']['host']; ?>" required><br />
      Uživatel:<input type="text" class="form" name="user" value="<?php echo $ini['connect']['user']; ?>" required><br />
      Heslo:   <input type="text" class="form" name="pass" value="<?php echo $ini['connect']['pass']; ?>" required><br />
      Databáze:<input type="text" class="form" name="dbnm" value="<?php echo $ini['connect']['dbnm']; ?>" required><br />
      <input type="submit" class="button" value="Upravit">
    </form>

<?php
include("view/end.php");
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


if($_POST['name'] && $_POST['password'] && $_POST['email'] && $_POST['host'] && $_POST['pass'] && $_POST['dbnm']){
    $user       =  $_POST['user'];
    $pass       =  $_POST['pass'];
    $dbnm       =  $_POST['dbnm']; 
    $name       =  $_POST['name'];
    $password   =  $_POST['password'];
    $email      =  $_POST['email'];

    $my_file = '../inc/connect.ini';
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
                  'email="'   .$email.'";  email'."\n";
                  
          
          fwrite($handle, $data);
          fclose($handle);
       }

}

  $ini = parse_ini_file("../inc/connect.ini",1);
  if(!$ini){
    error("Podprogramu se nepodařilo načíst soubor s nastavením. Zkontrolujte <i>inc/connect.ini</i>");
  }
?>
    <form id=opts action method="post" enctype="multipart/form-data">
      <span>Jméno:  <input type="text" class="form" name="name"     value="<?php echo $ini['user']['name']; ?>" required /></span>
      <span>Heslo:  <input type="text" class="form" name="password" value="<?php echo $ini['user']['password']; ?>" required /></span>
      <span>Email:  <input type="email" class="form" name="email"   value="<?php echo $ini['user']['email']; ?>"required /></span>
      <br />
      <span>Host:    <input type="text" class="form" name="host" value="<?php echo $ini['connect']['host']; ?>" required /></span>
      <span>Uživatel:<input type="text" class="form" name="user" value="<?php echo $ini['connect']['user']; ?>" required /></span>
      <span>Heslo:   <input type="text" class="form" name="pass" value="<?php echo $ini['connect']['pass']; ?>" required /></span>
      <span>Databáze:<input type="text" class="form" name="dbnm" value="<?php echo $ini['connect']['dbnm']; ?>" required /></span>
      <button type="submit">Upravit</button>
    </form>

<?php
include("view/end.php");

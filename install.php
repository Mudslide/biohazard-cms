<!DOCTYPE HTML>
<html>
 <head>
  <meta charset=utf-8 />
  <title> Instalace </title>
  <link rel=stylesheet href=http://bio.g6.cz/style/install.css />
 <script>
 function check(){
  var b = document.getElementById("password_2");
  var a = document.getElementById("password_1");
  if(b.value != ""){
    if(b.value != a.value){
      b.style.border = '2px solid red';
      b.style.margin = '3px';
    }
  } 
 }
 </script>
 
 </head>
 <body>
<?php
$ini = parse_ini_file("inc/connect.ini",1); //TODO rename to connect.inc
  if($ini){
  header("Location: http://bio.g6.cz");
  }
  
  
  if($_POST['user'] && $_POST['pass']){
  
    $user       =  $_POST['user'];
    $pass       =  $_POST['pass'];
    $dbnm       =  $_POST['dbnm']; 
    $name       =  $_POST['name'];
    $password   =  $_POST['password_1'];
    $email      =  $_POST['email'];

    $my_file = 'inc/connect_test.ini'; //TODO rename to connect.inc
      if($handle = fopen($my_file, 'w+')){
          $data = '[connect]'."\n".
                  'host="localhost"; hostname'."\n".
                  'user="'.$user.'"; username'."\n".
                  'pass="'.$pass.'"; password'."\n".
                  'dbnm="'.$user.'"; database name'."\n".
                  "\n".
                  '[user]'."\n".
                  'name="'    .$name.'"; name'."\n".
                  'password="'.$password.'"; password'."\n".
                  'email="'   .$email.'"; email'."\n"
                  ;
                  
          
          fwrite($handle, $data);
          fclose($handle);
          
          unlink("install.php");
       }
   
  $connect = new mysqli('localhost',$user,$pass,$user);
  $connect->set_charset("utf8"); 
  if($connect->mysqli_connect_errno){
    //FIXME Possible security hole
    exit('Nepodařilo se připojit k mysql databázi'.mysqli_connect_errno());
  }
  
  //todo rename husty -> class, sbory -> soubory
  $sql_1 = "CREATE TABLE class    ( id int(255) AUTO_INCREMENT, 
                                    class text, 
                                    viditelnost tinyint(1),
                                    PRIMARY KEY (ID))";
                          
  $sql_2 = "CREATE TABLE soubory (  id int(255) AUTO_INCREMENT,
                                    date	int(255),
                                    class	text,
                                    nadpis	text,
                                    popis	text,
                                    soubor	text,
                                    real_name	text,
                                    viditelnost	tinyint(1),
                                    PRIMARY KEY (ID))";
 	
  if (mysqli_query($connect,$sql_1) && mysqli_query($connect,$sql_2)){
    header("Location: http://bio.g6.cz");
  }else{
    echo "Error creating table: " . mysqli_error($connect);
  } 
}
 
?>
  <div id="bg"></div>
  <div id="container">
    <form action="#" method="POST" enctype="multipart/form-data">
      <input type="text" class="form" name="name" placeholder="Jméno" required> <br />
      <input type="password" class="top_form" id="password_1" name="password_1" placeholder="Heslo"  required>
      <input type="password" class="top_form" id="password_2" name="password_2" placeholder="Heslo znovu" onblur="check()" required>  <br />
      <input type="email" class="form" name="email" placeholder="Email" required> <br />
      <br />
      <input type="text" class="form" name="host" value="localhost">               <br />
      <input type="text" class="form" name="user" placeholder="Uživatel" required> <br />
      <input type="text" class="form" name="pass" placeholder="Heslo" required>    <br />
      <input type="text" class="form" name="dbnm" placeholder="Databáze" required> <br />
      <input type="submit" class="button" value="VYTVOŘIT">
    </form>
  </div>
  <div id="ad"><endora></div>
  </body>
</html>

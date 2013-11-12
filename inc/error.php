<?php
function error($str){
 //TODO Include view files
 exit("
 <!DOCTYPE HTML>
 <html>
  <head>
   <meta charset=utf-8 />
   <title>Bio</title>
   <link rel=stylesheet href=../style.css />
  </head>
  <body>
   <h1><span>Bio</span>Hazard</h1>
   <div class=box data-role=side></div>
   <div class=box data-role=content>
    $str
   </div>
  </body>
 </html>
 ");
}

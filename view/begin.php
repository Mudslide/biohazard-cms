<!DOCTYPE HTML>
<html lang=en-US> <!-- jazyk definovan kvuli hyphens slovnikum -->
 <head>
  <meta charset=utf-8 />
  <title>BioHazard</title>
  <link rel=stylesheet href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/style.css" />
 </head>
 <body>
  <h1 class=supernadpis>Bio<span class=nope>Hazard</span></h1>
  <div class=vzkaz>
   <form action method=post>
   <textarea name=vzkaz placeholder="Popis"></textarea>
   <input type=email name=email placeholder="e-mail"/>
   <button type=submit>Odeslat</button>
  </div>
  <div class=box data-role=side>
  

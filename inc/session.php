<?php
//Drobné rozšíření k PHP sessions

function session_exists($id=false){
 $sid = '';
 if($id){
  $sid = $id;
 }elseif(session_id()){
  $sid = session_id();
 }elseif($_GET['SID']){
  $sid = $_GET['SID'];
 }elseif($_COOKIE['PHPSESSID']){
  $sid = $_COOKIE['PHPSESSID'];
 }
 if ($sid){
  if(!session_id()){
   session_id($sid);
   session_start();
  }
  if(!$_SESSION['authentic']){
   session_destroy();
   return false;
  }else{
   return true;
  }
 }else{
  return false;
 }
}

function session_create($sid=false){
 if(session_id()){
  session_destroy();
 }
 if(!$sid){$sid=md5(rand());}
 session_id($sid);
 session_start();
 $_SESSION['authentic'] = true;
}

function session_end($sid){
 if(session_exists()){
  $_SESSION['authentic'] = false;
  session_destroy();
  return true;
 }else{
  return false;
 }
}

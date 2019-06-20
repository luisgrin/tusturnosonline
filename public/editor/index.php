<?php 

function adminer_object() {

  foreach (glob("plugins/*.php") as $filename) {
      include_once "./$filename";
  }
  
  $plugins = array(
  	new AdminerTheme(),
  	//new AdminerPassword(),
    new AdminerFileUpload(__DIR__ . '/../uploads/')
  );

  return new AdminerPlugin($plugins); 
}

date_default_timezone_set('America/Argentina/Buenos_Aires'); 
/*
include_once __DIR__ . "/../../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::create(__DIR__ . '/../..');
$dotenv->overload();
*/
include_once __DIR__ . '/editor.php';


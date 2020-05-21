<?php
/* Config Database */
const _DB_HOST = "10.10.10.10";
const _DB_PORT = "5432";
const _DB_USER = "postgres";
const _DB_PASS = "Bloodi@123321";
const _DB_NAME = "bloodipbreal";

// Config Auth Server
const _PB_AUTH_IP = "10.10.10.100";
const _PB_AUTHPORT = 39190;

// Config Server
const _PB_GAME_IP = "10.10.10.100";
const _PB_GAMEPORT = 39192;



date_default_timezone_set('America/Sao_Paulo');

function save_log($file,$msg){
     $file=$_SERVER['DOCUMENT_ROOT']."/logs/".$file;
     $log=fopen("$file", "a+");
     fputs($log, date('Y-m-d H:i:s')." ".$msg.PHP_EOL);
     fclose($log);
}
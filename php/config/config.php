<?php
#error_reporting(0);

// Config Database
const _DB_HOST = "server.bloodipb.com";
const _DB_PORT = "5432";
const _DB_USER = "postgres";
const _DB_PASS = "@fJa._pbBloodi";
const _DB_NAME = "postgres";


// Config API
const _API_GAMESYNC = 1909;
const _API_GAME_IP = "server.bloodipb.com";
const _API_HOST = 'https://api.bloodipb.com/api/';






date_default_timezone_set('America/Sao_Paulo');

/* @var string Retorna o endereço ip publico real do cliente */
function RealIP() : string{
	$addr = $_SERVER['REMOTE_ADDR'];

	if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) 
	{
		$addr = $_SERVER['HTTP_CF_CONNECTING_IP'];
	}
	else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
	{
		$addr = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}

	return $addr;
	
}

/* @var string Armazena o endereço IP do Cliente */
define("_CLIENT_ADDR", RealIP());

$dataLocal = date('Y-m-d H:i:s');
function dataIso8601($data){ // Formata a data para o padrao ISO 8601
	$data = new DateTime($data);
	$data = $data->format(DateTime::ATOM);
	return $data;
}
function save_log($file,$msg){
     global $dataLocal;
     $ipLog=$_SERVER['DOCUMENT_ROOT']."/logs/".$file;
     $log=fopen("$ipLog", "a+");
     fputs($log, "$dataLocal ".$msg.PHP_EOL);
     fclose($log);
}


function query($query,$bool = false, $last_id = false){
	try{
		$conn = @new PDO("pgsql:host="._DB_HOST.";port="._DB_PORT.";dbname="._DB_NAME, _DB_USER, _DB_PASS,array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); 
		$conn->exec($query);
	    if ($last_id === true) {
			return $conn->lastInsertId();
		}
		if ($bool) {return true;}
    }catch(PDOException $e){
    	save_log("fatal.log","[SQL] ". _CLIENT_ADDR ." Query: ".$query." Resultado: ".$e->getMessage());
    	if ($bool) {return false;}
		return null;
    }
	return $conn;
}
function select_db($sql){
	try {
		$conn = new PDO("pgsql:host="._DB_HOST.";port="._DB_PORT.";dbname="._DB_NAME, _DB_USER, _DB_PASS,array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION )); 
		return $conn->query($sql);
	}
	catch(PDOException $e){
		save_log("fatal.log","[SQL] "._CLIENT_ADDR." Query: ".$sql." Resultado: ".$e->getMessage());
	}
	return null;
}
function soNumero($str) {return preg_replace("/[^0-9.]/", "", $str);}
function anti_injection($sql,$tipo = null,$nivel = 1){
	if ($nivel == 1) {
		$sql = str_replace("'","''",$sql);
		$sql = trim($sql);
		if ($tipo == "search") {
			$sql = str_replace('%', '\%', $sql);
			$sql = str_replace('_', '\_', $sql);
		}
	}elseif ($nivel == 2) {
		$sql = preg_replace('/(\*|--|\'|\\\\)/','',$sql);
		$sql = trim($sql);
		$sql = strip_tags($sql);
		$sql = addslashes($sql);
	}
	return $sql;
}
function UrlAtual(){
	$dominio= $_SERVER['HTTP_HOST'];
	$url = "http://" . $dominio. $_SERVER['REQUEST_URI'];
	return $url;
}
// --------- Sessão
session_start();
/* 
	Validação da conta deve vir abaixo
*/
if (isset($_SESSION['usuario'],$_SESSION['senha']) and !empty($_SESSION['usuario'])) {
	$user = anti_injection($_SESSION['usuario']);
	$pass = anti_injection(($_SESSION['senha']));

	$sql = "SELECT player_id,email,login,password,player_name,access_level,rank,online from contas WHERE login = '$user' AND password = '$pass'";

	$select = select_db($sql);
	if (!is_null($select) && $select->rowCount() > 0) { 
		foreach ($select as $row) {
			$account = array(
				'id'   		=> $row['player_id'],
				'email'   	=> $row['email'],
				'usuario' 	=> $row['login'],
				'senha'   	=> $row['password'],
				'nick'   	=> $row['player_name'],
				'nivel'   	=> $row['access_level'],
				'rank'   	=> $row['rank'],
				'online'   	=> $row['online']
			);
			if (empty($account['nick'])) {
				$account['nick'] = false;
			}
		}
	}else{
		$_SESSION['usuario'] = $account = null;
		session_destroy();
	}
}
function logado($admin = false) : bool{
	global $account;
	if (isset($_SESSION['usuario'],$_SESSION['senha'])){
		if ($admin && $account['nivel'] < 4) {
			return false;
		}
		return true;
	}
	else
		return false;
}
// URL requer login
function require_login($tipo = "js") : void{
	if (logado() === false) {
		if ($tipo == "js") {
			echo "<script>";
			echo "window.location.href='/login/?redirect=".UrlAtual()."'; ";
			echo "</script>";
		}elseif ($tipo == "php") {
			header('Location: /login/?redirect='.UrlAtual().'');
			exit();
		}
		
	}
}
if (isset($_GET['bye'])) {session_destroy();header('Location: /');exit();}
if (isset($_GET['bye_admin'])) {
	$_SESSION['admin'] = null;
	header('Location: /');exit();
}
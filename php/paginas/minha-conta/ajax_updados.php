<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/php/config/config.php");
if (logado()===false) { die('Sessão expirada!'); }

function gerar_hash($senha){
	$salt = '/x!a@r-$r%an¨.&e&+f*f(f(a)';
	$output = hash_hmac('md5', $senha, $salt);
	return $output;
}
if (isset($_POST['pedido']) and $_POST['pedido'] == "senha") {

	

	if (isset($_POST['login'],$_POST['senha'],$_POST['senha_antiga'])) {
		$login = anti_injection(strtolower($_POST['login']));
		$senha = gerar_hash($_POST['senha']);
		$senha_a = gerar_hash($_POST['senha_antiga']);

		if (mb_strlen($_POST['senha'], 'utf8') < 4 OR mb_strlen($_POST['senha'], 'utf8') > 16) {
			die('<b>Erro:</b> A senha deve ter entre 4-16 caracteres!');
		}

		if ($account['usuario'] != $login) {die('<b>Erro grave:</b> Problema desconhecido! #L22');}
		
		$sql = "SELECT * from contas WHERE player_id = ".$account['id']." AND password = '$senha_a' ";
		if (select_db($sql)->rowCount() < 1) {
			die("<b>Erro:</b> A senha antiga está incorreta!");
		}

		$sql = " UPDATE contas SET password = '$senha' WHERE player_id = ".$account['id']."  ";
		if (query($sql)) {
			die('1');
		}else{
			die("<b>Erro:</b> A senha antiga está incorreta!");
		}
	}
}


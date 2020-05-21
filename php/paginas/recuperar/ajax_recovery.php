<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/php/config/config.php");
query(" DELETE FROM site_recuperar_senha WHERE (data + interval '1 day') <= now() ");
if ($_POST['pedido']=="send") {
	$email = anti_injection($_POST['mail']);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		die('<b>Erro:</b> formato de email inválido!');
	}
	$sql = " SELECT player_id from contas where email = '".$email."' ";
	$select = select_db($sql);
	if ($select->rowCount() > 0) {
		foreach ($select as $row){$send['id'] = $row['player_id'];}

		// Limite de 3 links por conta
		$sql = "SELECT count(user_id) t FROM site_recuperar_senha WHERE user_id = ".$send['id']."; ";
		foreach (select_db($sql) as $row){
			if ($row['t'] > 2) {
				die('<b>Limite:</b> você já enviou 3 links hoje, verifique sua caixa de entrada.');
			}
		}

		$token = md5(intval($send['id']*77).$dataLocal.rand(1,9));
		$sql = "INSERT INTO site_recuperar_senha (user_id,token,ip) VALUES ('".$send['id']."', '".$token."', '"._CLIENT_ADDR."' )";
		if (query($sql)) {

			$mail_config = (parse_ini_file($_SERVER['DOCUMENT_ROOT']."/php/config/email.ini"));

			require $_SERVER['DOCUMENT_ROOT'].'/php/class/PHPMailer-5.2-stable/PHPMailerAutoload.php';

			// Instância do objeto PHPMailer
			$mail = new PHPMailer;
			$mail->CharSet = 'UTF-8';
			 
			// Configura para envio de e-mails usando SMTP
			$mail->isSMTP();
			 
			// Servidor SMTP
			$mail->Host = 'smtp.gmail.com';
			 
			// Usar autenticação SMTP
			$mail->SMTPAuth = true;
			 
			// Usuário da conta
			$mail->Username = $mail_config['usuario'];
			 
			// Senha da conta
			$mail->Password = $mail_config['senha'];
			 
			// Tipo de encriptação que será usado na conexão SMTP
			$mail->SMTPSecure = 'ssl';
			 
			// Porta do servidor SMTP
			$mail->Port = 465;
			 
			// Informa se vamos enviar mensagens usando HTML
			$mail->IsHTML(true);
			 
			// Email do Remetente
			$mail->From = $mail_config['remetente'];
			 
			// Nome do Remetente
			$mail->FromName = $mail_config['nomeRemetente'];
			 
			// Endereço do e-mail do destinatário
			$mail->addAddress($email);
			 
			// Assunto do e-mail
			$mail->Subject = 'Recuperação de conta';
			 
			// Mensagem que vai no corpo do e-mail
			$mail->Body = '<!DOCTYPE html>
			<html>
			<head>
			<meta charset="utf-8">
			<title>Alterar senha</title>
			</head>
			<body>
				<h1>Renove sua senha</h1>
				<p>Foi solicitado uma recuperação de conta para este email, se você não foi responsavel, ignore esta mensagem.</p>
				<p>Para renovar sua senha, entre link no abaixo:</p>
				<a href="'.$mail_config['dominio'].'recuperar/?token='.$token.'">'.$mail_config['dominio'].'recuperar/?token='.$token.'</a><hr>
				<address>'.$mail_config['descricao'].'</address>
				<style>*{font-family:arial;}</style>
			</body>
			</html>';
			 
			// Envia o e-mail e captura o sucesso ou erro
			if($mail->Send()){
			    echo 1;
			}else{
				$sql = "DELETE FROM site_recuperar_senha WHERE token = '$token' ";
				query($sql);
				echo '<b>Erro: </b> falha ao enviar o email para <address>'.$email.'</address> ';
				save_log('erros.log',_CLIENT_ADDR.' Falha ao enviar email -> '.$mail->ErrorInfo);
			}
		}else{
			die('<b>Erro</b> Falha ao registrar link de recuperação, contate o desenvolvedor.');
			save_log('erros.log', '[RECUPERAÇÂO] Falha ao inserir link de recuperação. SQL: '.$sql);
		}
	}else{
		die('<b>Falha:</b> Estem email não está registrado!');
	}
}else if ($_POST['pedido']=="renew") {
	function gerar_hash($senha){
		$salt = '/x!a@r-$r%an¨.&e&+f*f(f(a)';
		$output = hash_hmac('md5', $senha, $salt);
		return $output;
	}
	$token =preg_replace("/[^A-Za-z0-9]/", "", $_POST['token']);
	if(empty($token) OR strlen($token) != 32){die('<b>Erro:</b> Token é inválido!');}
	$pass = $_POST['pass'];
	$pass_c = $_POST['pass_c'];
	if(mb_strlen($pass, 'utf8') < 4 OR mb_strlen($pass, 'utf8') > 16){
		die('<b>Erro:</b> A senha deve ter entre 4-16 caracteres!');
	}
	if ($pass!=$pass_c) {die('<b>Erro:</b> Senhas diferente!');}
	$pass = gerar_hash($pass);
	$sql = " SELECT user_id FROM site_recuperar_senha WHERE token = '$token'";
	$select = select_db($sql);
	if ($select->rowCount() > 0) {
		foreach ($select as $row){
			$player_id = $row['user_id'];
		}
		$sql = " UPDATE contas SET password = '$pass' WHERE player_id = $player_id; ";
		if (query($sql)) {
			save_log("usuarios.log",_CLIENT_ADDR." [RECUPERACAO DE SENHA] Senha atualizada ID: ".$player_id);
			query(" DELETE FROM site_recuperar_senha WHERE token = '$token' ");
			die('1');
		}else{
			die('<b>Erro:</b> Problema ao atualizar a senha, reporte ao desenvolvedor.');
		}
	}else{
		die('<b>Erro:</b> O token não existe ou já foi usado.');
	}
}

<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/php/config/config.php");
if (isset($_GET['token'])) {$token = preg_replace("/\W/", "", $_GET['token']);}
if (mb_strlen($token, 'utf8') != 32) {die('Formato do token de confirmação inválido!');}

$sql = "SELECT * from site_accounts_confirm where token = '$token' and usado = false 
and (data + interval '1 day') > now(); ";
$select = select_db($sql);
if ($select->rowCount() > 0) {
	
	foreach ($select as $row) {
		$acc_email   = $row['email'];
		$acc_login = $row['login'];
		$acc_senha   = $row['password'];
		$acc_ip   = $row['ip'];
		$acc_data   = $row['data'];
	}

	$sql = "SELECT * from contas where ( lower(email) = '$acc_email' OR lower(login) = '$acc_login' ); ";
	if (select_db($sql)->rowCount() > 0) {
		$sql = "UPDATE site_accounts_confirm SET usado = true WHERE token = '$token' ";
		query($sql);
		$msg = "Email ou login já está sendo usado!";exit();
	}

	$sql = "INSERT INTO contas (email,login,password,lastip,data) 
	VALUES ('$acc_email','$acc_login', '$acc_senha','$acc_ip','$acc_data')";
	if (query($sql)) {
		$sql = "UPDATE site_accounts_confirm SET usado = true WHERE token = '$token' ";
		query($sql);
		$status = 1;
		$msg = '<div class="sucess">Conta ativada!</div>';
	}else{
		$msg = "Erro na inserção dos dados, contate o <b>desenvolvedor</b>.";exit();
	}

}else{
	$msg = 'Link de confirmação inválido! <br><hr>Possiveis causas: o link não existe ou já foi ativado.';
}
$sql = " DELETE FROM site_accounts_confirm WHERE usado = false AND (data + interval '1 day') <= now() ";
query($sql);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Confirmar conta</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="robots" content="noindex, nofollow">
    <?php if (@$status == 1) {echo " <meta http-equiv='refresh' content='15; url=/login/'> ";}?>
</head>
<body>
<?php 
echo $msg;
?>
<style type="text/css">
	*{font-family:arial;box-sizing:border-box;font-size: 19px;}
	body{margin:0;padding:10px;}
	.sucess{
		background: #088a08;
	    color: #ffffff;
	    padding: 9px 8px;
	    display: table;
	    text-shadow: 1px 1px #000;
	    border-left: 6px solid #075407;
	    box-shadow: 1px 1px 2px #000;
	}
</style>
</body>
</html>
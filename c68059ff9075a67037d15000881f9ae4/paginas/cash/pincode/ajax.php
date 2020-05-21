<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/php/config/config.php");
if (!logado() || $account['nivel']<4) {die('Sem permissão!');}

if (@$_POST['query'] == "add") {
	include_once($_SERVER['DOCUMENT_ROOT']."/c68059ff9075a67037d15000881f9ae4/class/char_generator.php");
	$valor = intval($_POST['valor']);
	if ($valor > 32767 || $valor < 100) {echo "<script>alert('Falha, requerido entre 100-32.767!');</script>";}
	$a = false;
	while ($a === false) {
		$pin = gerarPin();
		$sql = "SELECT * from site_pincode where pin = '$pin'; ";
		if (select_db($sql)->rowCount() < 1) {
			$sql = "SELECT * from site_pincode_logs where pin = '$pin'; ";
			if (select_db($sql)->rowCount() < 1) {
				$a = true;
			}
		}
	}

	$sql = "INSERT INTO site_pincode VALUES (default,".$account['id'].", '$pin','$valor')";
	if (query($sql)) {
		echo "
		<div class='alert alert-success' role='alert'>
		  <b>".$valor."</b> <span>".$pin."</span>
		</div>";
	}else{
		echo "<script>alert('Falha, tente novamente!');</script>";
	}
}
# Post delete
if (@$_POST['what'] == 'drop') {
	$id =intval($_POST['id']);
	$sql = "DELETE FROM site_pincode WHERE id = ".$id."; ";
	if (query($sql)) {echo 1;}else{echo 0;}
	exit();
}
# Fim do post
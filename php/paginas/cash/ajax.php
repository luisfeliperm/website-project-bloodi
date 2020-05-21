<?php 
// @luisfeliperm
// The first !!! haha 

include_once($_SERVER['DOCUMENT_ROOT']."/php/config/config.php");
if (!logado()) {die("{\"result\":\"error\",\"resposta\":\"Faça login\"}");}

function result($resp = "Ocorreu um erro!",$result = "error") : string{
	return "{
		\"result\":\"$result\",
		\"resposta\":\"$resp\"
	}";
}
function setcash(int $valor) : Bool{
	global $account;
	$Statistics = json_decode(file_get_contents(_API_HOST."statistics.php"));
	(bool) $serverOn = ($Statistics->server->auth && $Statistics->server->auth);
	// Player On mas server off, Tente mais tarde 
	if ($account['online'] && !$serverOn) { // PlayerON, serverOFF
		save_log("error.log","[ajax.setcash] O player Id:".$account['id']." tentou receber o cash mas seu status estava ONLINE e o servidor OFFLINE");
		return false;
	}
	else if ($account['online']) { // PlayerON, server ON
		require($_SERVER['DOCUMENT_ROOT']."/php/class/SendBytes.php");
		$write = new SendPacket();
		$write->addr = _API_GAME_IP;
		$write->port = _API_GAMESYNC;
		$write->int16(0b01100100);
		$write->int64($account['id']);
		$write->int32($valor);
		$write->Send();
		$write->clear();
		save_log("info.log","[Cash] Foi enviado via UDP ".$valor." de cash para o pId:".$account['id']);
		return true;
	}else{ // Server ON, PlayerOFF
		$sql = "UPDATE contas SET money =  money + ".$valor." WHERE player_id = '".$account['id']."' ";
		return query($sql,true);
	}
	
}


if (isset($_POST['daycash'])) {
	$sql = "SELECT from contas WHERE player_id = ".$account['id']." AND now()::date > daycash";
	if (select_db($sql)->rowCount() < 1) { // cash indisponivel
		die(result('Volte amanhã'));
	}
	if (!setcash(500)) {
		die(result('Falha ao inserir'));
	}
	$sql = "UPDATE contas SET daycash = now()::date WHERE player_id = ".$account['id'].";";
	query($sql);
	die(result('Parabéns, cash foi recebido!','sucess'));

}
if (isset($_POST['pincode'])) {
	$pin = soNumero($_POST['pincode']);

	$sql = "SELECT * FROM site_pincode WHERE pin = '$pin'";

	$select = select_db($sql);
	if ($select->rowCount() > 0 && mb_strlen($pin, 'utf8') == 20) {
		foreach ($select as $row) {
			$datePin = array(
				'id'   => $row['id'],
				'valor' => $row['valor'],
				'gm' => $row['criador_id']
			); 
		}

		if (!setcash($datePin['valor'])) { // Executa query e se der erro
			die(result('Falha ao ativar'));
		}

		$sql = "DELETE FROM site_pincode WHERE id = '" .$datePin['id']. "'";
		query($sql);

		$sql = "INSERT INTO site_pincode_logs (login,pin,valor,ip,data,criador_id) VALUES ('".$account['id']."', '".$pin."', '".$datePin['valor']."', '"._CLIENT_ADDR."','".$dataLocal."', '".$datePin['gm']."' ) ";
		query($sql);
		die(result('Pincode ativado!','sucess'));

	}else{
		$sql = "SELECT id FROM site_pincode_logs WHERE pin = '$pin' ";
		if (select_db($sql)->rowCount() > 0){
			die(result('Pincode já foi usado '));
		}else{
			die(result('Pincode inválido'));
		}
	}
}
echo result();
?>
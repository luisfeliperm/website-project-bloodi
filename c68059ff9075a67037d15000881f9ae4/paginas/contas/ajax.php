<?php 
//  Recebe o ID da conta e aplica um BANIMENTO PERMANENTE

// Forneça os dados via Ajax

include_once($_SERVER['DOCUMENT_ROOT']."/php/config/config.php");
if (!logado() || $account['nivel']<5) {die('Sem permissão!');}

if (@$_POST['query'] == "banir") {
	$idUser = intval($_POST['id']);

	$sql = "SELECT * from contas WHERE player_id = $idUser ";

	if (select_db($sql)->rowCount() == 1) {
		foreach (select_db($sql) as $row) {
			if ($row['access_level'] == -1) {die('O '.$row['login']." já está banido!");}
			$sql = "UPDATE contas SET access_level = -1 where player_id = $idUser ";
			if (query($sql)) {
				save_log('banimentos.log','[BANIMENTO] GM '.$account['nick'].' {ID:'.$account['id'].'} baniu '.$row['player_name'].' ID:'.$row['player_id']);
				die("1");
			}else{
				save_log('error.log','[FALHA AO BANIR] GM '.$account['nick'].' {ID:'.$account['id'].'} baniu '.$row['player_name'].' ID:'.$row['player_id']);
				echo "Falhou";
			}
		}
	}
}
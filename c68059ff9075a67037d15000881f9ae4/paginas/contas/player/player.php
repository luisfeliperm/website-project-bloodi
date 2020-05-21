<?php 
if (!logado() || $account['nivel']<4) {die('Sem permissão!');}

$playerId = intval($_GET['pid']);

$sql = "SELECT * FROM contas WHERE player_id = $playerId ";

/*
- Banimentos
- clan
- amigos
- nicks
- inventario
- mensagens

-- Menu
- Puxar historico
- Enviar
- Setar vip, help

*/

?>

<div class="row"><div class="col-lg-12"><h1> Controle avançado</h1></div></div><hr/>
<h3>@luisfeliperm</h3>
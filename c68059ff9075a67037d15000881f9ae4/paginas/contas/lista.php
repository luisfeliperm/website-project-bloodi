<?php 
if (!logado() || $account['nivel']<4) {die('Sem permissão!');}
function fixDate($str, $pos, $c){return substr($str, 0, $pos) . $c . substr($str, $pos);}

$secao['filtro'] = is_numeric(@$_GET['filtro']) ? $_GET['filtro'] : 0;

$filtro = " 1=1 ";
if ($secao['filtro'] == 2) {$filtro .= " AND online = true ";}
if ($secao['filtro'] == 3) {$filtro .= " AND access_level < 0 ";}
if ($secao['filtro'] == 4) {$filtro .= " AND player_name = '' ";}
if ($secao['filtro'] == 5) {$filtro .= " AND access_level > 2 ";}
if ($secao['filtro'] == 6) {$filtro .= " AND pc_room > 0 AND  access_level<3";}

/* ordem */ 
$secao['ordenar_por']  = $_GET['ordenar_por'] ?? 'player_id';
$secao['ordem'] = $_GET['ordem'] ?? 'desc';
if ($secao['ordenar_por'] != "player_id" AND $secao['ordenar_por'] != "data" ) {
	$secao['ordenar_por'] = 'player_id';
}
if ($secao['ordem'] != 'desc' AND $secao['ordem'] != 'asc') {
	$secao['ordem'] = 'desc';
}
$ordem = $secao['ordenar_por']." ".$secao['ordem']." ";

/* Busca */
if (isset( $_GET['busca'] ) AND !empty(anti_injection($_GET['busca']))) {
	switch ($_GET['busca_coluna']) {
		case 'player_id':
			$search_by = "player_id";
			break;
		case 'login':
			$search_by = "login";
			break;
		case 'email':
			$search_by = "email";
			break;
		case 'lastip':
			$search_by = "lastip";
			break;
		case 'last_mac':
			$search_by = "last_mac";
			break;
		default:
			$search_by = "player_name";
			break;
	}
	$search_key = anti_injection(($_GET['busca']),'search');
	
	if ($search_by=="last_mac") {
		if (filter_var( $search_key , FILTER_VALIDATE_MAC)) {
			$filtro .= " AND last_mac = '$search_key' ";
		}else{
			$status_listagem =  "<div class='status_listagem-error'>MAC ADDRESS INVALIDO</div>";
		}
		
	}elseif ($search_by=="lastip") {
		$filtro .= " AND $search_by like '$search_key%' ";
	}elseif ($search_by=="player_id") {
		/* Como é uma busca por ID, os filtros são removidos */
		$secao['filtro'] = 1;
		$search_key = soNumero($search_key);
		$filtro = " $search_by = 0$search_key ";
	}else{
		$filtro .= " AND lower($search_by) like lower('%$search_key%') ";
	}
}
?>
<div class="row"><div class="col-lg-12"><h1> Gerenciamento de usuarios</h1></div></div><hr/>
<link rel="stylesheet" type="text/css" href="/c68059ff9075a67037d15000881f9ae4/css/accounts.css?version=0.12.4">

<div class="info-geral">
	<div class="info">Total: <span><?php echo $Statistics->accounts->AllPlayers;?></span></div>
	<div class="info">Online: <span><?php echo $Statistics->accounts->PlayersOn;?></span></div>
</div>
<div class="player-search">
	<div class="right">
		<select class="ordem right" onchange="filtro(this);" id="ordem_select">
			<option <?php if(@$secao['filtro']==1){echo "selected";}?> value="1">Contas</option>
			<option <?php if(@$secao['filtro']==2){echo "selected";}?> value="2">Online</option>
			<option <?php if(@$secao['filtro']==3){echo "selected";}?> value="3">Banidos</option>
			<option <?php if(@$secao['filtro']==4){echo "selected";}?> value="4">Inativos</option>
			<option <?php if(@$secao['filtro']==5){echo "selected";}?> value="5">Staff</option>
			<option <?php if(@$secao['filtro']==6){echo "selected";}?> value="5">Vips</option>
		</select>
	</div>
	<form class="left" action="">
		<div class="form-item">
			<input type="hidden" name="adminPage" value="contas" >
			<input type="hidden" name="subPage" value="lista" >
			<input type="hidden" name="ordem" value="<?php echo @$_GET['ordem'];?>" >
			<input type="hidden" name="filtro" value="<?php echo @$_GET['filtro'];?>" >

			<select class="tb-coluna" name="busca_coluna">
				<option <?php if(@$_GET['busca_coluna']=="player_name"){echo "selected";}?> value="player_name">NICK</option>
				<option <?php if(@$_GET['busca_coluna']=="player_id"){echo "selected";}?> value="player_id">ID</option>
				<option <?php if(@$_GET['busca_coluna']=="login"){echo "selected";}?> value="login">LOGIN</option>
				<option <?php if(@$_GET['busca_coluna']=="email"){echo "selected";}?> value="email">EMAIL</option>
				<option <?php if(@$_GET['busca_coluna']=="lastip"){echo "selected";}?> value="lastip">IP</option>
				<option <?php if(@$_GET['busca_coluna']=="last_mac"){echo "selected";}?> value="last_mac">MAC</option>
			</select>
		</div>
		<div class="form-item">
			<input type="text" autofocus name="busca" placeholder="Pesquise" value="<?php echo @$_GET['busca'];?>">
		</div>
		
		<div class="form-item">
			<button type="submit">Procurar</button>
		</div>
	</form>
</div>

<hr>
<div class="mae_lista-user">
	<div class="info_contas ovl-h">
		<div class="left">
			<select onchange="ordem(this);">
				<option value="1" <?php if($secao['ordem']=='desc'){echo "selected='true' ";}?>>Novos</option>
				<option value="0" <?php if($secao['ordem']=='asc'){echo "selected='true' ";}?>>Antigos</option>
			</select>
		</div>
		<div class="right">Encontrados: <span id="total">0</span></div>
	</div>
	<?php echo @$status_listagem; ?>
	<div class="mae-table">
	<table class="lista_user">
		<thead>
			<tr>
				<th></th>
				<th>L</th>
				<th>id</th>
				<th>login</th>
				<th>nick</th>
				<th>email</th>
				<th>Ultimo IP</th>
				<th>atividade</th>
				<th>mac</th>
				<th>registro</th>
				<th><a href="#">ON</a></th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$sql = "SELECT * from contas WHERE $filtro ";
			$select = select_db($sql);
			$total_reg=0;
			if (!is_null($select) && $select->rowCount() >0) {
				$total_reg=$select->rowCount();

				$ipsOn = file_get_contents(_API_HOST.'check_connection.php?port=game');

				$pg_atual = preg_replace("/[^0-9.]/", "", @$_GET['p'] ?? 1) ;
				$pg_atual = is_numeric($pg_atual) ? $pg_atual : 1;
				$pg_total = 25;
				/** Calculo pra ver quantos links podem ter */
				$link_total = intval($total_reg/$pg_total);
				$link_rest = ($total_reg%$pg_total);
				if ($link_rest > 0) {$link_total++;}
				if ($pg_atual > $link_total) { /* Está em uma página que não existe */
					$pg_atual = $link_total;
				}
				/* Fim do calculo links */
				$inicio = ($pg_atual - 1)*$pg_total;

				$sql = "SELECT * from contas  WHERE $filtro ORDER BY $ordem LIMIT $pg_total OFFSET $inicio ";

				$destacado = false;
				foreach (select_db($sql) as $row) { 
					$tags = null;
					if($row['pc_cafe'] > 0 && $row['pc_cafe'] < 3)
						$tags .= "<img class='tag' src=\"/img/vip".$row['pc_cafe'].".png\">";
					if($row['pc_cafe'] > 2)
						$tags .= "<span class='tag alerta'>Vip Invalido</span>"
					?>
					<tr id="user<?php echo $row['player_id'];?>" data-user_nivel='<?php echo $row['access_level'];?>' >
						<td><a href="?adminPage=contas&subPage=player&pid=<?php echo $row['player_id'];?>"><i class="fas fa-user-edit"></i></a></td>
						<td><img src="/img/patentes/20x20/<?php echo $row['rank'];?>.gif"></td>
						<td><?php echo $row['player_id'];?></td>
						<td><?php echo htmlspecialchars($row['login']);?></td>
						<td>
							<?php echo $tags;echo htmlspecialchars($row['player_name']);?></td>
						<td><?php echo htmlspecialchars($row['email']);?></td>
						<td><?php echo $row['lastip'];?></td>
						<td><?php echo date('d/m/y H:i', strtotime(fixDate(fixDate(fixDate(fixDate($row['last_login'], 8, ':'), 6, ' '), 4, '-'), 2, '-')));?></td>

						<td><?php echo $row['last_mac'];?></td>
						<td><?php echo date('d/m/y H:i', strtotime($row['data']));?></td>
						<td><?php 
							if($row['online']==true){
								if(strpos("[".$ipsOn."]", $row['lastip'])){
									echo "<i class='fas green fa-check-circle'></i>";
								}else{
									echo "<i style='color:#c70000;' title='Provavelmente este usuario não está online.' class='fa fa-exclamation-triangle' aria-hidden='true'></i>";
								}
							}else{
								echo "<i class='far fa-circle'></i>";
							} ?>
						</td>
					</tr>

				<?php }	
			}else{ ?>
			<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
			<?php } ?>
		</tbody>
	</table>
	</div>
</div>

<div class="paginacao">
<?php if (!$total_reg<1) { ?>
<?php /* Paginação */
$link_total = intval($total_reg/$pg_total);
$link_rest = ($total_reg%$pg_total);
if ($link_rest > 0) {
	$link_total++;
}
$volta = $pg_atual -1;
$proxi = $pg_atual +1;

if ($pg_atual < 2) {
	$link_back = "javascript:void(0)";$a = 'pag-no';
}else{
	$get = $_GET;
	$get['p'] = $volta;
	$link_back = "./?".http_build_query($get);
	
}

if ($proxi > $link_total) {
	$link_prox = "javascript:void(0)";$b = 'pag-no';
}else{
	$get = $_GET;
	$get['p'] = $proxi;
	$link_prox = "./?".http_build_query($get);
	
}

echo "<a class='".@$a."' href='".$link_back."'><i class='fa fa-angle-double-left' aria-hidden='true'></i> Anterior</a>";

echo "<a class='".@$b."' href='".$link_prox."'>Proximo <i class='fa fa-angle-double-right' aria-hidden='true'></i></a>";
?>
			<?php } ?>			
</div>

<script>
	edita_texto('total', '<?php echo $total_reg;?>');
	function filtro(element){
		window.location.href="<?php 
		$get= $_GET;
		$get['filtro']='';
		$get['p']=1;
		echo "./?".str_replace("&filtro=","",http_build_query($get));
		?>&filtro="+parseInt(element.value);
	}
	function ordem(element){
		if (element.value == '1') {
			window.location.href="<?php $get=$_GET;$get['p']=1;$get['ordem']='desc';echo "./?".http_build_query($get);?>";
		}else{
			window.location.href="<?php $get=$_GET;$get['p']=1;$get['ordem']='asc';echo "./?".http_build_query($get);?>";
		}
		
	}
	
	function banir(id){
		var tr_user = document.getElementById('user'+id);

		if (tr_user.dataset.user_nivel == "-1"){
			alert('Este usuario já está banido!');
			return false;
		}
		var continuar = confirm('Deseja banir este usuario?');
		if (continuar===false) {return false;}

		display_edit('opt_user_load', 'block');
		$.post('/c68059ff9075a67037d15000881f9ae4/paginas/contas/ajax.php',{
			query:'banir',
			id:  id,
		},function(data){
			display_edit('opt_user_load', 'none');
			display_edit('opt_user_status', 'block');
			if (data == "1"){
				tr_user.dataset.user_nivel = "-1";
				document.getElementById('opt_user_status').innerHTML = "Usuario banido";
			}else{
				document.getElementById('opt_user_status').innerHTML = data;
			}
			
		});
	}
</script>
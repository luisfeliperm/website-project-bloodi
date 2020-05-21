<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/php/class/patentes.php");
function fixDate($str, $pos, $c){return substr($str, 0, $pos) . $c . substr($str, $pos);}
?>
<link rel="stylesheet" type="text/css" href="/css/pages/conta.css?version=0.12.4">
<section>
	<div class="pag-title"><i class="fa fa-chevron-right" aria-hidden="true"></i> Minha conta</div>

	<div class="ovl-h" id="myinfo">

		<div class="right acc-aside txt-right">

			<div class="text-right ovl-h opcoes">
				<a href="javascript:void(0)" style="cursor:not-allowed;">Alterar email</a>
				<a href="javascript:void(0)" onclick="display_edit('alterar-senha','block');display_edit('alter-dados','block');display_edit('voltar','block');display_edit('myinfo', 'none');">Trocar Senha</a>
				<div class="borda-1" style="margin-bottom: 10px;"></div>
				<?php 
				if ($account['online'] == false) {
					echo " <a href=\"javascript:void(0)\" onclick=\"inclui_page('/php/paginas/minha-conta/ajax_inventario.php')\">INVENTÁRIO</a> ";
				}else{
					echo " <a href=\"javascript:void(0)\" onclick=\"alert('Você está online no jogo. Feche ou atualize a pagina.')\">INVETÁRIO</a> ";
				};?>
			</div>

		 	<div class="caixa-download ovl-h">
				<div class="link link-green ovl-h">
					<img src="/img/layout/f7fa45206044d92b19c19eb98e16beae.png">
					<div class="info">
						<div class="titulo">Cash Diario</div> 
						<div>Resgate seu cash</div>
						<div><a href="/cash/"><i class="fa fa-download" aria-hidden="true"></i></a></div>
					</div>
				</div>
			</div>
			
		</div>

		<div class="left acc-main">
			<?php 
			$sql = "
			SELECT ac.login,ac.email,ac.data,ac.last_login,ac.exp,ac.money,ac.gp,clan.clan_name from contas ac LEFT JOIN clan_data clan ON clan.clan_id = ac.clan_id WHERE ac.player_id = ".$account['id']." ; 
			";
			$select = select_db($sql);
			foreach ($select as $row) { ?>

			<div class="acc-dados">
				<table>
					<tr><th colspan="2">SEUS DADOS</th></tr>
					<tr>
						<td>Status</td>
						<?php if($account['nivel'] == -1){ ?>
						<td class="ovl-h banido">BANIDO</td>
						<?php }elseif($account['online']==true){?>
						<td class="ovl-h online" >Online <a href="#" class="right">[Desconectar]</a></td>
						<?php }else{?>
						<td class="ovl-h">Offline</td>
						<?php }?>
					</tr>
					<tr>
						<td>Usuario</td>
						<td><?php echo htmlspecialchars($row['login']);?></td>
					</tr>
					<tr>
						<td>Nick</td>
						<td><?php echo htmlspecialchars($account['nick']);?></td>
					</tr>
					<tr>
						<td>email</td>
						<td><?php echo htmlspecialchars($row['email']);?></td>
					</tr>
					<tr>
						<td>Registro</td>
						<td><?php echo date('d/m/y H:i', strtotime($row['data']));?></td>
					</tr>
					<tr>
						<td>Ultimo login</td>
						<td><?php echo date('d/m/y H:i', strtotime(fixDate(fixDate(fixDate(fixDate($row['last_login'], 8, ':'), 6, ' '), 4, '-'), 2, '-'))); ?> </td>
					</tr>
				</table>
			</div>
			

			<div class="acc-player">
				<div class="acc-player-item ovl-h">
			 		<div class="left">Patente</div>
			 		
			 		<div class="right"><?php echo Patentes::Name($account['rank']);?></div>
			 	</div>

			 	<div class="acc-player-item ovl-h">
			 		<div class="left">Clan</div>
			 		<div class="right"><?php echo htmlspecialchars($row['clan_name']??"--");?></div>
			 	</div>

			 	<div class="acc-player-item ovl-h">
			 		<div class="left">EXP</div>
			 		<div class="right"><?php echo number_format($row['exp'],0,'.',".");?></div>
			 	</div>

			 	<div class="acc-player-item ovl-h">
			 		<div class="left">CASH</div>
			 		<div class="right"><?php echo $row['money'];?></div>
			 	</div>

			 	<div class="acc-player-item ovl-h">
			 		<div class="left">GOLD</div>
			 		<div class="right"><?php echo $row['gp'];?></div>
			 	</div>
			</div>
			<?php } ?>
		</div>


		
	</div>

	<div id="voltar">
		<button onclick="display_edit('status','none');display_edit('alterar-senha','none');display_edit('alter-dados','none');display_edit('myinfo','block');display_edit('voltar','none');">Voltar</button>
	</div>
	<div id="alter-dados">
		<div id="status" class="msg-0"></div>

		<form autocomplete="off" class="borda-0" onsubmit="trocaSenha(); return false;" id="alterar-senha">
			<input type="hidden" id="allow" value="1">
			<div class="titulo bold">Mudar senha</div>
			<div class="item">
				<label>Nova senha:</label>
				<input autofocus type="password" name="newpass" id="newpass">
			</div>

			<div class="item">
				<label>Confirme:</label>
				<input type="password" name="newpass-confirm" id="newpass-confirm">
			</div>
			<div class="borda"></div>
			<div class="item">
				<label>Senha atual:</label>
				<input type="password" name="oldpass" id="oldpass">
			</div>

			<div class="item submit">
				<button type="submit">CONFIRMAR</button>
			</div>
		</form>
	</div>

</section>
<script>
	function trocaSenha(){
		var allow = document.getElementById('allow');
		var newpass = document.getElementById('newpass');
		var newpass_c = document.getElementById('newpass-confirm');
		var oldpass = document.getElementById('oldpass');
		if (allow.value == '0') {return false;}
		if (newpass.value.length < 4 || newpass.value.length > 16 || oldpass.value.length < 4) {
			display_edit('status','block');
			edita_texto('status','<b>Senha:</b> Deve conter entre 4-16 caracteres.');
			allow.value = '1';
			return false;
		}
		if (newpass.value != newpass_c.value) {
			display_edit('status','block');
			edita_texto('status','<b>Senha:</b> Senhas diferentes!');
			allow.value = '1';
			return false;
		}
		allow.value = '0';
		$.post('/php/paginas/minha-conta/ajax_updados.php',{pedido: 'senha',login:'<?php echo @$account['usuario'];?>',senha:newpass.value,senha_antiga:oldpass.value},function(data){
		 if (data == 1) {
		 	display_edit('status','block');
		 	edita_texto('status','<b>Sucesso</b> Senha alterada, faça login novamente!');
		 	display_edit('alterar-senha','none');
		 }else{
		 	display_edit('status','block');
		 	edita_texto('status',data);
		 }
		 allow.value = '1';
		});
		return false;
	}
</script>
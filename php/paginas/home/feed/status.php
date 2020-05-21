<style type="text/css">
	.tb-server > table:first-child tr:not(:last-child) td:nth-child(2)
	{
		color:#bb0000;display: none;
	}
</style>
<li>
	<div class="ovl-h">
		<div class="left tb-server">
			<table>
				<tr id="fstatusTr_auth">
					<td><i class="g fa fa-check-circle-o" aria-hidden="true"></i></td>
					<td><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></td>
					<td>Auth</td>
				</tr>
				<tr id="fstatusTr_game">
					<td><i class="g fa fa-check-circle-o" aria-hidden="true"></i></td>
					<td><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></td>
					<td>Game Server</td>
				</tr>

				<tr>
					<td><i class="g fa fa-check-circle-o" aria-hidden="true"></i></td>
					<td>Battle</td>
				</tr>
			</table>

			<table>
				<tr>
					<td>Usuarios:</td>
					<td id="feedStatus_players">?</td>
				</tr>
				<tr>
					<td>Banidos:</td>
					<td id="feedStatus_blocks">?</td>
				</tr>
				<tr>
					<td>Online:</td>
					<td id="feedStatus_online">Yes</td>
				</tr>
			</table>
			<div class="borda"></div>
		</div>
					
		<div class="right intro ovl-h">
			<ul class="left">
				<li><i class="fa fa-check-circle-o" aria-hidden="true"></i> Privacidade dos players</li>
				<li><i class="fa fa-check-circle-o" aria-hidden="true"></i> Segurança++</li>
				<li><i class="fa fa-check-circle-o" aria-hidden="true"></i> Proteção contra DDoS</li>
				<li><i class="fa fa-check-circle-o" aria-hidden="true"></i> Backups diarios</li>
			</ul>
			<img class="left" src="https://i.imgur.com/ra5AOHq.png">
		</div>
	</div>
	<div class="borda-1" style="margin:10px 0px;"></div>
	<div class="msg-0">Servidor de Point Blank Privado - UDP3</div>
</li>

<script type="text/javascript">
	// Pega objeto carregado na index
	function homeFeedStatus(){
		edita_texto("feedStatus_players", api_srvDetais.accounts.AllPlayers);
		edita_texto("feedStatus_blocks", api_srvDetais.accounts.PlayersBlock);
		// edita_texto("feedStatus_online", api_srvDetais.accounts.PlayersOn);

		if (!api_srvDetais.server.auth) {
			var a =  document.getElementById("fstatusTr_auth");
			a.getElementsByTagName("td")[0].style.display = "none"; // on
			a.getElementsByTagName("td")[1].style.display = "block"; // off
		}
		if (!api_srvDetais.server.game) {
			var a =  document.getElementById("fstatusTr_game");
			a.getElementsByTagName("td")[0].style.display = "none"; // on
			a.getElementsByTagName("td")[1].style.display = "block"; // off
		}
	}
</script>
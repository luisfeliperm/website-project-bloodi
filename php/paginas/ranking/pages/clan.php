<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/php/class/ranking.php");


?>
<link rel="stylesheet" type="text/css" href="/css/pages/rank.css">
<section class="ranking">
	<div class="pag-title"><i class="fa fa-chevron-right" aria-hidden="true"></i> Ranking - Clan</div>

	<div class="header-rank">
		
		<div class="alter">
			<a href='#'>MEU RANK</a>
			<a href='/ranking/clan/' class="active">CLAN</a>
			<a href='/ranking/geral/'>PLAYERS</a>
		</div>

		<div class="tools-rank ovl-h">
			<form class="search" onsubmit="return submitSearch();" action="#ListRanking" name="formSearch">
				<input type="hidden" name="type" value="clan">
				<input spellcheck="false" onkeyup="this.value = removeAcento(this.value);limiteCaract(this, 15);this.value = this.value.replace(/\s+/g,' ')" type="text" name="busca" placeholder="Clãn" value="<?php echo htmlspecialchars(@$_GET['busca']);?>">
				<button>Procurar</button>
			</form>
		</div>

		<div class="rank-msg">
			<b>AVISO:</b> Em breve mudaremos nosso sistema de Ranking no site! O ranking será atualizado diariamente as 3:00 horas da manhã. Também traremos o ranking semanal. Fique por dentro, logo traremos noticias!
		</div>

	</div>

	<!-- Geral -->
	<div class="man-rank">
		<?php if (isset($_GET['busca'])): ?>
			<div class="result"><b>Resultados:</b> <?php echo htmlspecialchars($_GET['busca']);?></div>
		<?php endif ?>
		

		<table id="ListRanking">
			<thead>
				<tr>
					<th>Rank</th>
					<th>Patente</th>
					<th>Clã</th>
					<th class="desktop">Dono</th>
					<th>Exp</th>
					<th class="desktop">Points</th>
					<th>Win%</th>
				</tr>
			</thead>

			<tbody>
				<?php 
				try {
					$conn = new PDO("pgsql:host="._DB_HOST.";port="._DB_PORT.";dbname="._DB_NAME, _DB_USER, _DB_PASS); 
    				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    				$sql_where = !isset($_GET['busca']) ? null : "AND lower(clan_name) LIKE lower(:busca) ";
					
    				// Count total
    				$sql = "
    					SELECT 
							count(tb_clan.clan_rank) total
						FROM clan_data as tb_clan
						INNER JOIN contas as tb_contas
						ON tb_clan.owner_id = tb_contas.player_id
						WHERE 1=1  $sql_where ;
    				";
    				$stmt = $conn->prepare($sql); 
    				if($sql_where != null)
					    	$stmt->bindValue(':busca', "%".$_GET['busca']."%" , PDO::PARAM_STR);

					$stmt->execute();

					$total_reg = $stmt->fetch(PDO::FETCH_ASSOC)['total'];


    				$stmt = null;

    				if($total_reg > 0){
					
						$pg_atual = (empty($_GET['p']) || !is_numeric($_GET['p']) || $_GET['p'] < 1) ? 1 : $_GET['p'];
						$pg_total = 15;
						/** Calculo pra ver quantos links podem ter */
						$link_total = intval($total_reg/$pg_total);
						$link_rest = ($total_reg%$pg_total);
						if ($link_rest > 0) {$link_total++;}
						if ($pg_atual > $link_total) { /* Está em uma página que não existe */
							$pg_atual = $link_total;
						}
						/* Fim do calculo links */

						$inicio = ($pg_atual - 1)*$pg_total;
						$rank_postion = $inicio+1;

    					$sql = "
							SELECT 
								tb_clan.clan_rank rank, 
								tb_clan.clan_name nome, 
								tb_contas.player_name dono,
								tb_clan.clan_exp exp, 
								tb_clan.partidas partidas, 
								tb_clan.vitorias ganhos, 
								tb_clan.derrotas perdas,
								tb_clan.pontos pontos

							FROM clan_data as tb_clan
							INNER JOIN contas as tb_contas
							ON tb_clan.owner_id = tb_contas.player_id
							WHERE 1=1  $sql_where
							ORDER BY tb_clan.clan_exp DESC, tb_clan.vitorias DESC  
							LIMIT $pg_total OFFSET $inicio ;
						";

						$stmt = $conn->prepare($sql); 
						if($sql_where != null)
					    	$stmt->bindValue(':busca', "%".$_GET['busca']."%" , PDO::PARAM_STR);

					    $stmt->execute();

					    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		        		$stmt = null; 

	        			foreach ($rows as $row) {
	    					echo "<tr>";
								echo "<td>$rank_postion</td>";
								echo "<td><img src=\"/img/patentes/clan/".$row['rank'].".jpg\"> </td>";
								echo "<td>".htmlspecialchars($row['nome'])."</td>";
								echo "<td class='desktop'>".htmlspecialchars($row['dono'])."</td>";
								echo "<td>".$row['exp']."</td>";
								echo "<td class='desktop'>".$row['pontos']."</td>";
								echo "<td>".calcHS($row['partidas'], $row['ganhos'])."</td>";
							echo "</tr>";
							$rank_postion++;
	        			}


    				}else{ // Sem registros
    					?>
						<tr>
							<td>--</td>
							<td>--</td>
							<td>--</td>
							<td>--</td>
							<td>--</td>
							<td class="desktop">--</td>
							<td class="desktop">--</td>
						</tr>
						<?php 
    				}

    				

					

        			

				} catch (PDOException $e) {
    				save_log("error.log","[Ranking Clan] Error: " . $e->getMessage());
				}
				$conn = null;

				
				?>
			</tbody>

		</table>
	</div>
	<div class="footer-rank ovl-h" id="rank_footer">
		<?php if (!$total_reg<1) { ?>

		<div class="right paginacao">

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
				$link_back = "?p=$volta";
				if(!empty($list_rank['busca'])){
					$link_back = "?".$_GET['busca']."&p=".$volta;
				}
			}

			if ($proxi > $link_total) {
				$link_prox = "javascript:void(0)";$b = 'pag-no';
			}else{
				$link_prox = "?p=$proxi";
				if(!empty($list_rank['busca'])){
					$link_prox = "?busca=".$_GET['busca']."&p=".$proxi;
				}
			}
			echo "<a class='".@$a."' href='".$link_back."'><i class='fa fa-angle-double-left' aria-hidden='true'></i> Anterior</a>";
			echo "<a class='".@$b."' href='".$link_prox."'>Proximo <i class='fa fa-angle-double-right' aria-hidden='true'></i></a>";
			?>
		</div>
		<?php } ?>
	</div>

</section>
<script>
	function submitSearch(){
		var x = document.forms["formSearch"]["busca"].value;
		if (x.length < 2 || x.length > 16) {
			return false;
		}
	}
</script>
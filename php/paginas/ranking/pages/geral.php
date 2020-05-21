<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/php/class/ranking.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/class/patentes.php");

$list_rank['busca'] = $_GET['busca'] ?? null;

if(!empty($list_rank['busca']) ){

	$list_rank['busca'] = trim(preg_replace('/\s+/', '', $list_rank['busca']));

	if (mb_strlen($list_rank['busca'], 'utf8') < 2 OR mb_strlen($list_rank['busca'], 'utf8') > 16) {
		$rank_msg[] = "<div class=\"result\">Busca inválida!</div>";
		$list_rank['busca'] = null;
	}else{
		$list_rank['busca'] = anti_injection($list_rank['busca'],'search');
		$list_rank['where'] .= " AND LOWER(player_name) LIKE LOWER('%".$list_rank['busca']."%') ";
		$rank_msg[] = "<div class=\"result\"><b>Resultados:</b> ".htmlspecialchars($_GET['busca'])."</div>";
	}
}
?>
<link rel="stylesheet" type="text/css" href="/css/pages/rank.css">
<section class="ranking">
	<div class="pag-title"><i class="fa fa-chevron-right" aria-hidden="true"></i> Ranking - Geral</div>

	<div class="header-rank">
		
		<div class="alter">
			<a href='#'>MEU RANK</a>
			<a href='/ranking/clan/'>CLAN</a>
			<a href='/ranking/geral/' class="active">PLAYERS</a>
		</div>

		<div class="tools-rank ovl-h">
			<form class="search" onsubmit="return submitSearch();" action="#ListRanking" name="formSearch">
				<input spellcheck="false" onkeyup="this.value = removeAcento(this.value);limiteCaract(this, 15);this.value = this.value.replace(/\s+/g,' ')" type="text" name="busca" placeholder="Nick" value="<?php echo htmlspecialchars(@$_GET['busca']);?>">
				<button>Procurar</button>
			</form>
		</div>

		<div class="rank-msg">
			Em breve mudaremos nosso sistema de Ranking no site! O ranking será atualizado diariamente as 3:00 horas da manhã. Também traremos o ranking semanal. Fique por dentro, logo traremos noticias!
		</div>

	</div>

	<!-- Geral -->
	<div class="man-rank">
		<?php 
		if(!empty($rank_msg)){
			foreach ($rank_msg as $x) {
				echo $x;
			}
		}
		?>
		<table id="ListRanking">
			<thead>
				<tr>
					<?php if(is_null($list_rank['busca'])){echo "<th>Rank</th>";} ?>
					<th>Patente</th>
					<th>Nick</th>
					<th class="visible-min-500w">XP</th>
					<th>K/D%</th>
					<th>HS%</th>
					<th class="desktop">Win%</th>
				</tr>
			</thead>

			<tbody>

				<?php 
				$sql = "SELECT player_id from contas WHERE ".$list_rank['where']." ";
				$select = select_db($sql);
				$total_reg=0;
				if (!is_null($select) && $select->rowCount() >0) {
					$total_reg=$select->rowCount();
					
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
					
					$sql = "SELECT * from contas  WHERE ".$list_rank['where']." ORDER BY ".$list_rank['ordem']." LIMIT $pg_total OFFSET $inicio ";

					$rank_postion = $inicio+1;

					foreach (select_db($sql) as $row) {
						?>
						<tr>
							<?php 
							if(is_null($list_rank['busca'])){
								echo "<td>$rank_postion</td>";
							}
							?>
							<td title="<?php echo Patentes::Name($row['rank']);?>"><img src="/img/patentes/20x20/<?php echo $row['rank'];?>.gif"></td>

							<td><?php echo htmlspecialchars($row['player_name']);?></td>

							<td class="visible-min-500w"><?php echo number_format($row['exp'],0,'.',".");?></td>

							<td><?php echo calcKD($row['kills_count'],$row['deaths_count']);?>%</td>
							<td><?php echo calcHS($row['kills_count'], $row['headshots_count']);?>%</td>
							<td class="desktop"><?php echo calcHS($row['fights'],$row['fights_win']) ?>%</td>
						</tr>
						
						<?php
						$rank_postion++;
					}
				}else{ /* Sem registros */
					?>
					<tr>
						<?php if(is_null($list_rank['busca'])){echo "<th>--</th>";} ?>
						<td>--</td>
						<td>--</td>
						<td class="visible-min-500w">--</td>
						<td>--</td>
						<td>--</td>
						<td class="desktop">--</td>
					</tr>
					<?php
				}
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
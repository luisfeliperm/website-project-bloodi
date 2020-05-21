<link rel="stylesheet" type="text/css" href="/css/pages/news.css?version=0.12.4">
<section class="news" id="news">
	<div class="pag-title"><i class="fa fa-chevron-right" aria-hidden="true"></i> Novidades</div>
	<article class="news-principal" id="news-principal">
		<figure>
			<figcaption class="bold">Destaque semanal</figcaption>
			<img id="newDestaq-img">
		</figure>
		<div class="news-info">
			<div class="news-autor">
				<div><i class="fa fa-calendar" aria-hidden="true"></i> <time id="newDestaq-time" pubdate></time></div>
				<div><i class="fa fa-user" aria-hidden="true"></i> <span id="newDestaq-autor"></span></div>
			</div>
			<div class="borda-1" style="margin:10px 0px 20px 0px;"></div>
			<a href="#" id="newDestaq-title"></a>
			<h2 id="newDestaq-desc"></h2>
		</div>
	</article>
	<div class="borda-0" style="margin:6px 0px 20px 0px;box-shadow: 0px 4px 15px 1px #06286c;"></div>
	<div class="hr-face"><span>MAIS RECENTES</span></div>
	
	<ul class="li-news">
		<?php 
		$sql = "SELECT * FROM site_news WHERE destaque > -1  AND cat IN ($catSql)";

		$total_reg=0;
		$select = select_db($sql);
		if (!is_null($select) && $select->rowCount() >0) {
			$total_reg=$select->rowCount();
		
			$total_reg--; // Diminui um registro (Da noticia principal)
			$pg_atual = preg_replace("/[^0-9.]/", "", @$_GET['p'] ?? 1) ;
			$pg_atual = is_numeric($pg_atual) ? $pg_atual : 1;
			$pg_total = 6;
			/** Calculo pra ver quantos links podem ter */
			$link_total = intval($total_reg/$pg_total);
			$link_rest = ($total_reg%$pg_total);
			if ($link_rest > 0) {$link_total++;}
			if ($pg_atual > $link_total) { /* Está em uma página que não existe */
				$pg_atual = $link_total;
			}
			/* Fim do calculo links */
			if ($pg_atual == 0) {
				$inicio = 0;
			}else{
				$inicio = ($pg_atual - 1)*$pg_total;
			}
			
			$sql = " SELECT site_news.*,contas.player_name as autor from site_news JOIN contas ON contas.player_id = site_news.autor where destaque = 1
			UNION
			(select site_news.*,contas.player_name as autor from site_news JOIN contas ON contas.player_id = site_news.autor where destaque = 0 AND cat IN ($catSql) ORDER BY id DESC LIMIT $pg_total OFFSET $inicio) 
			order by destaque desc, id desc; ";

			$destacado = false;
			foreach (select_db($sql) as $row) {
				if (!$destacado) {
					$destacado = true;
					?>
					<script type="text/javascript">
						document.getElementById("newDestaq-img").alt = '<?php echo $row['keywords'];?>';
						document.getElementById("newDestaq-img").title = '<?php echo htmlspecialchars($row['titulo']);?>';
						document.getElementById("newDestaq-img").src = '<?php echo $row['imagem'];?>';
						document.getElementById('newDestaq-time').dateTime = '<?php echo dataIso8601($row['data']);?>';
						document.getElementById('newDestaq-time').innerHTML = '<?php echo date('d/m/Y',strtotime($row['data']));?>';
						document.getElementById('newDestaq-autor').innerHTML = '<?php echo $row['autor'];?>';
						document.getElementById('newDestaq-title').href = '/noticia/<?php echo $row['url_id'];?>/';
						document.getElementById('newDestaq-title').innerHTML = '<h1><?php echo htmlspecialchars($row['titulo']);?></h1>';
						
						document.getElementById('newDestaq-desc').innerHTML = '<?php echo htmlspecialchars($row['descricao']);?>';
					</script>
					<?php
				}else{
					?>
					<li>
						<div class="li-news-img">
							<figure class="bold">
								<figcaption onclick="window.location.href='/noticia/<?php echo $row['url_id'];?>/';">Acessar</figcaption>
								<img src="<?php echo $row['imagem'];?>">
							</figure>
						</div>

						<div class="li-news-info">
							<div class="meio">
								<a href="/noticia/<?php echo $row['url_id'];?>/" class="titulo"><h2><?php echo htmlspecialchars($row['titulo']);?></h2></a>
								<p><?php echo htmlspecialchars($row['descricao']);?></p>
							</div>
							<div class="fim">
								<div><i class="fa fa-user" aria-hidden="true"></i> <span><?php echo $row['autor'];?></span></div>
								<div><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d/m/Y',strtotime($row['data'])); ?></div>
							</div>
						</div>
					</li>
					<?php
				}
			}
		}else{
			echo "<script>document.getElementById('news').innerHTML = \"<div class='pag-title'><i class='fa fa-chevron-right' aria-hidden='true'></i> Novidades</div><h2>Sem resultados!</h2>\"; 
			</script>";
		}
		?>
	</ul>

	<?php if ($total_reg>0) { ?>
	<div class="news-paginacao">
		<div class="right">
			<?php /* Paginação */
			$link_total = intval($total_reg/$pg_total);
			$link_rest = ($total_reg%$pg_total);
			if ($link_rest > 0) {
				$link_total++;
			}
			$volta = $pg_atual -1;
			$proxi = $pg_atual +1;

			if ($pg_atual < 2) {
				echo "<a class='pag-no' href='javascript:void(0)'><i class='fa fa-angle-double-left' aria-hidden='true'></i></a>";
			}else{
				echo "<a href='?p=$volta'><i class='fa fa-angle-double-left' aria-hidden='true'></i></a>";
			}
			if ($proxi > $link_total) {
				echo "<a class='pag-no' href='javascript:void(0)'><i class='fa fa-angle-double-right' aria-hidden='true'></i></a>";
			}else{
				echo "<a href='?p=$proxi'><i class='fa fa-angle-double-right' aria-hidden='true'></i></a>";
			}
			?>
		</div>
	</div>
	<?php } ?>
</section>
<?php if (!logado() || $account['nivel']<4) {die('Sem permissão!');}?>
<div class="row"><div class="col-lg-12"><h1> Noticias </h1></div></div><hr/>

<div class="list-group">
  <?php 
		$sql = "SELECT * FROM site_news WHERE destaque > -1 ";
		$total_reg=(select_db($sql)->rowCount());
		if ($total_reg>0) {
			$total_reg--; // Diminui um registro (Da noticia principal)
			$pg_atual = preg_replace("/[^0-9.]/", "", @$_GET['p'] ?? 1) ;
			$pg_atual = is_numeric($pg_atual) ? $pg_atual : 1;
			$pg_total = 15;
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
			(select site_news.*,contas.player_name as autor from site_news JOIN contas ON contas.player_id = site_news.autor where destaque = 0 ORDER BY id DESC LIMIT $pg_total OFFSET $inicio) 
			order by destaque desc, id desc; ";

			$destacado = false;

			foreach (select_db($sql) as $row) {
				if (!$destacado) {
					$destacado = true;
					?>
					<a href="?adminPage=noticias&subPage=edit&url=<?php echo $row['url_id'];?>" class="list-group-item list-group-item-action flex-column align-items-start active">
				    <div class="d-flex w-100 justify-content-between">
				      <h5 class="mb-1"><?php echo $row['titulo'];?></h5>
				      <small><?php echo $row['access'];?> Acessos</small>
				    </div>
				    <p class="mb-1"><?php echo $row['descricao'];?></p>
				    <small><?php echo $row['autor']." ".date('d/m/Y', strtotime($row['data']));?></small>
				  </a>
					<?php
				}else{
					?>
					<a href="?adminPage=noticias&subPage=edit&url=<?php echo $row['url_id'];?>" class="list-group-item list-group-item-action flex-column align-items-start">
				    <div class="d-flex w-100 justify-content-between">
				      <h5 class="mb-1"><?php echo $row['titulo'];?></h5>
				      <small class="text-muted"><?php echo $row['access'];?> Acessos</small>
				    </div>
				    <p class="mb-1"><?php echo $row['descricao'];?></p>
				    <small class="text-muted"><?php echo $row['autor']." ".date('d/m/Y', strtotime($row['data']));?></small>
				  </a>
					<?php
				}
			}
		}else{echo "<div class='alert alert-info' role='alert'>Não há noticias!</div>";}
		?>
</div>
<br>
<?php if ($total_reg>0) { ?>
<div aria-label="Page navigation example">
  <ul class="pagination">

  	<?php /* Paginação */
	$link_total = intval($total_reg/$pg_total);
	$link_rest = ($total_reg%$pg_total);
	if ($link_rest > 0) {
		$link_total++;
	}
	$volta = $pg_atual -1;
	$proxi = $pg_atual +1;

	if ($pg_atual < 2) {$link = "javascript:void(0)";}else{$link = "?adminPage=noticias&subPage=lista&p=".$volta;}
	?>
	<li class="page-item">
	  <a class="page-link" href="<?php echo $link;?>" aria-label="Previous">
	    <span aria-hidden="true">&laquo;</span>
	    <span class="sr-only">Previous</span>
	  </a>
	</li>
	<?php
	$x = 0;
	while ($x < $link_total) {
		$x++; $css = null;
		if ($x == @$_GET['p']) {
			$css = "active";
		}
		echo "<li class='page-item ".@$css." '><a class='page-link' href='?adminPage=noticias&subPage=lista&p=$x'>$x</a></li>";
	}
	if ($proxi > $link_total) {$link = "javascript:void(0)";}else{$link = "?adminPage=noticias&subPage=lista&p=".$proxi;}
	?>
	<li class="page-item">
      <a class="page-link" href="<?php echo $link;?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
	
	

    
  </ul>
</div>
<?php } ?>
<?php 
$sql = "SELECT * FROM site_news WHERE destaque > -1 AND cat IN (4,3,8,9) order by id desc limit 3 ";
$select = select_db($sql);
if ($select->rowCount() > 0) {
	foreach ($select as $row) { ?>
		<li>
			<div class="titulo"><div><a href="/noticia/<?php echo $row['url_id'];?>/"><?php echo htmlspecialchars($row['titulo']);?></a></div> <div><?php echo date('d/m/Y', strtotime($row['data']));?></div> </div>
			<div class="sub_titulo"><?php echo htmlspecialchars($row['descricao']);?></div>
		</li>
	<?php } 
}else{
	echo "<div class='pad-10'>Sem atualizações!</div>";
}
?>
<a href="/atualizacoes/" class="btn-all" title="Ver mais atualizações"><i class="fa fa-plus" aria-hidden="true"></i></a>
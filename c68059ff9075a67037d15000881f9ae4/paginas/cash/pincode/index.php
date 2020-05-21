<?php 
if (!logado() || $account['nivel']<4) {die('Sem permissão!');}
$_GET['lista'] = $_GET['lista'] ?? "novos";
if ($_GET['lista'] != "usados") {$_GET['lista'] = "novos";}
?>
<div class="row"><div class="col-lg-12"><h1> Gerar Pincode </h1></div></div><hr/>

<div id="recent_pin"></div>

<form class="gerar-pin" method="post" onsubmit="return gerar();">
	<input id="valor_pin" type="number" min="100" max="32767" name="valor" autofocus value="1000"><br>
	<button>Gerar</button>
</form>
<hr>


<ul class="nav nav-pills">
  <li class="nav-item">
    <a class="nav-link <?php if($_GET['lista']=='novos'){echo 'active';}?>" href="?adminPage=cash&subPage=pincode&lista=novos">Novos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php if($_GET['lista']=='usados'){echo 'active';}?>" href="?adminPage=cash&subPage=pincode&lista=usados">Usados</a>
  </li>
</ul>

<br>

<ul class="list-group li-pins">
  	<?php 
  	if ($_GET['lista'] == "usados") {
  		$tab = "site_pincode_logs";
  	}else{
  		$tab = "site_pincode";
  	}
	$sql = "SELECT * FROM $tab";
	$total_reg=0;
	$select = select_db($sql);
	if (!is_null($select) && $select->rowCount() >0) {
		$total_reg=$select->rowCount();
		$pg_atual = preg_replace("/[^0-9.]/", "", @$_GET['p'] ?? 1) ;
		$pg_atual = is_numeric($pg_atual) ? $pg_atual : 1;
		$pg_total = 20;
		/** Calculo pra ver quantos links podem ter */
		$link_total = intval($total_reg/$pg_total);
		$link_rest = ($total_reg%$pg_total);
		if ($link_rest > 0) {$link_total++;}
		if ($pg_atual > $link_total) { /* Está em uma página que não existe */
			$pg_atual = $link_total;
		}
		/* Fim do calculo links */
		$inicio = ($pg_atual - 1)*$pg_total;

		if ($tab == "site_pincode_logs") {
			$sql = "
			SELECT $tab.*,contas.player_name as user FROM $tab JOIN contas ON contas.player_id = $tab.login ORDER BY id DESC LIMIT $pg_total OFFSET $inicio; 
			";
		}else{
			$sql = "SELECT * FROM $tab ORDER BY id DESC LIMIT $pg_total OFFSET $inicio";
		}
		
		$rank = $inicio+1;

		$destacado = false;
		foreach (select_db($sql) as $row) {
		?>
		<li class="list-group-item" id="li<?php echo $row['id'];?>">
			<?php if ($tab == "site_pincode") { ?>
			<div class="left icons">
				<i class="fas fa-trash-alt" onclick="
								deletar_global('drop','<?php echo $row['id'];?>','/c68059ff9075a67037d15000881f9ae4/paginas/cash/ajax.php','li<?php echo $row['id'];?>',true);
								"></i>
			</div>
			<?php } ?>
			<div class="left pin"><?php echo $row['pin'];?></div>

			<?php if ($tab == "site_pincode_logs") { ?>
				<div class="left info-used"> <b>Ativado por:</b> <span><?php echo $row['user'];?></span> <i><?php echo date('d/m/Y H:i:s', strtotime($row['data']));?></i></div>
			<?php } ?>
			

			<div class="right valor badge badge-primary badge-pill">
				<?php echo $row['valor'];?>
			</div>
		</li>


		<?php
		}
	}else{
		echo "<div class='alert alert-info' role='alert'>Não há pins gerados!</div>";
	}
	?>

</ul><br>


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

	if ($pg_atual < 2) {$link = "javascript:void(0)";}else{$link = "?adminPage=pincode&lista=".$_GET['lista']."&p=".$volta;}
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
		$x++;
		$css = null;
		if ($x == @$_GET['p']) {
			$css = "active";
		}
		echo "<li class='page-item ".@$css." '><a class='page-link' href='?adminPage=cash&subPage=pincode&lista=".$_GET['lista']."&p=$x'>$x</a></li>";
	}
	if ($proxi > $link_total) {$link = "javascript:void(0)";}else{$link = "?adminPage=cash&subPage=pincode&lista=".$_GET['lista']."&p=".$proxi;}
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


<style>
	#recent_pin span{margin-left:10px;letter-spacing:2px;}
	.gerar-pin{
		padding: 10px;
		margin:10px auto;
		display: table;
	}
	.gerar-pin input[type="number"]{
	    text-align: center;
	    padding: 5px;
	    font-size: 27px;
	    border: none;
	    border: 1px solid #71bdfb;
	    color: #007bff;
	    background: #ffffff;
	    width: 160px;
	}
	.gerar-pin button{
	    padding: 17px 30px;
	    border: 1px solid #ddd;
	    background: #fff;
	    font-weight: bold;
	    margin: 20px auto;
	    display: table;
	    font-size: 30px;
	    cursor: pointer;
	    color: #1b6dc5;
	    opacity: 0.8;
	}
	.gerar-pin button:hover{
		opacity: 1;
	}
	.li-pins li{overflow: hidden;}
	.li-pins li > div.icons{
		padding-right: 10px;
	}
	.li-pins li > div.icons i{
		cursor: pointer;
	}
	.li-pins li > div.pin{
		letter-spacing: 2px;
	}
	.li-pins li > div.valor{
	}

	.info-used{
		margin-left: 10px;
	}
	.info-used b{

	}
</style>

<script>
	function gerar(){
		valor = document.getElementById('valor_pin').value;
		if (valor < 100 || valor > 100000) {
			alert('min: 100 | max: 100.000');
			return false;
		}

		$.post('/c68059ff9075a67037d15000881f9ae4/paginas/cash/pincode/ajax.php',{
			query: 'add',
			valor:  valor,
		},function(data){
			document.getElementById('recent_pin').innerHTML = data+document.getElementById('recent_pin').innerHTML;
		});

		return false;
	}
</script>
<?php 
if (!logado() || $account['nivel']<4) {die('Sem permissão!');}
?>
<div class="row"><div class="col-lg-12"><h1> Pagina de download </h1></div></div><hr/>
<?php 

if (
	isset($_POST['link1-name'],$_POST['link1-url']) && 
	isset($_POST['link2-name'],$_POST['link2-url']) && 
	isset($_POST['link3-name'],$_POST['link3-url'])
) {

	$data_link = array(
		'link1' => array(
			'name' => htmlspecialchars($_POST['link1-name']),
			'url' => $_POST['link1-url'],
			'blank' => (bool)($_POST['link1-blank'] ?? false)
		), 
		'link2' => array(
			'name' => htmlspecialchars($_POST['link2-name']),
			'url' => $_POST['link2-url'],
			'blank' => (bool)($_POST['link2-blank'] ?? false)
		),
		'link3' => array(
			'name' => htmlspecialchars($_POST['link3-name']),
			'url' => $_POST['link3-url'],
			'blank' => (bool)($_POST['link3-blank'] ?? false)
		)
	);

	if ( !(filter_var($data_link['link1']['url'], FILTER_VALIDATE_URL) && 
		filter_var($data_link['link2']['url'], FILTER_VALIDATE_URL) && 
		filter_var($data_link['link3']['url'], FILTER_VALIDATE_URL)
	) ) {
		$erros[] = "Url inválidas";
	}

	if ( empty($data_link['link1']['name']) || empty($data_link['link2']['name']) || empty($data_link['link3']['name'])) {
		$erros[] = "Nome vazio!";
	}
	if (isset($erros)) {
		foreach ($erros as $key) {
			echo  "<div class=\"alert alert-danger\" role=\"alert\">";
			echo ($key);
			echo "</div>";
		}
	}else{
		require($_SERVER['DOCUMENT_ROOT']."/php/class/ini.php");
		echo "Sem erros";
		write_php_ini($data_link,$_SERVER['DOCUMENT_ROOT']."/php/paginas/download/links.ini");
	}
	
}

$read = (parse_ini_file($_SERVER['DOCUMENT_ROOT']."/php/paginas/download/links.ini",true));
?>

<div>
	<form class="fw-form-classic" method="post" action="?<?php echo $_SERVER['QUERY_STRING'];?>">
		<div class="field">
			<div class="field-titulo">Link #1</div>
			<div class="item">
				<div><label for="link1-name">Nome</label></div>
				<div><input type="text" required name="link1-name" id="link1-name" value="<?php echo $read['link1']['name'];?>"></div>
			</div>

			<div class="item">
				<div><label for="link1-url">URL</label></div>
				<div><input id="link1-url" type="url" required name="link1-url" value="<?php echo $read['link1']['url'];?>"></div>
			</div>

			<div class="item">
				<input <?php echo ($read['link1']['blank'] ? 'checked' : null); ?> type="checkbox" name="link1-blank" id="link1-blank"> <label for="link1-blank">Abrir nova guia</label>
			</div>
		</div>

		<div class="field">
			<div class="field-titulo">Link #2</div>
			<div class="item">
				<div><label for="link2-name">Nome</label></div>
				<div><input type="text" required name="link2-name" id="link2-name" value="<?php echo $read['link2']['name'];?>"></div>
			</div>

			<div class="item">
				<div><label for="link2-url">URL</label></div>
				<div><input id="link2-url" required type="url" name="link2-url" value="<?php echo $read['link2']['url'];?>"></div>
			</div>

			<div class="item">
				<input <?php echo ($read['link2']['blank'] ? 'checked' : null); ?> type="checkbox" name="link2-blank" id="link2-blank"> <label for="link2-blank">Abrir nova guia</label>
			</div>
		</div>

		<div class="field">
			<div class="field-titulo">Link #3</div>
			<div class="item">
				<div><label for="link3-name">Nome</label></div>
				<div><input type="text" required name="link3-name" id="link3-name" value="<?php echo $read['link3']['name'];?>"></div>
			</div>

			<div class="item">
				<div><label for="link3-url">URL</label></div>
				<div><input id="link3-url" type="url" required name="link3-url" value="<?php echo $read['link3']['url'];?>"></div>
			</div>

			<div class="item">
				<input <?php echo ($read['link3']['blank'] ? 'checked' : null); ?> type="checkbox" name="link3-blank" id="link3-blank"> <label for="link3-blank">Abrir nova guia</label>
			</div>
		</div>

		<div class="item submit">
			<button>APLICAR</button>
		</div>
	</form>
</div>
<style>
	.fw-form-classic{
		line-height: normal;
		margin:0 auto;
		padding: 10px;
		width: 100%;
		width: 450px;
		border:1px solid red;
		border:1px solid #ddd;
		background: rgba(255,255,255,0.6);
	}
	.fw-form-classic .field{
		border: 1px solid #ddd;padding: 10px;
		margin-bottom: 5px;
	}
	.fw-form-classic .field:last-child{margin-bottom: 0;}
	.fw-form-classic .field .field-titulo{
		font-size: 18px;
	    border-left: 3px solid #004085;
	    margin: 0;
	    color: #004085;
	    padding: 0px 5px;
		margin-bottom: 8px;
	}
	.fw-form-classic .field .item:not(:last-child){margin:6px 0px;}
	.fw-form-classic .field .item label{
		padding: 0px;
	    font-weight: bold;
	    color: #1e2e40;
	}
	.fw-form-classic .field .item input:not([type="checkbox"]){
		width: 100%;
	}
	.fw-form-classic .item.submit{
		overflow: hidden;
	}
	.fw-form-classic .item.submit button{
		background: rgba(0, 64, 133, 0.019);
	    float: right;
	    color: #343a40;
	    border: 1px solid #a9b3bd;
	    padding: 6px 12px;
	    font-weight: bold;
	}
	.fw-form-classic .item.submit button:hover{
		background: rgba(0, 64, 133, 0.04);
	}

</style>
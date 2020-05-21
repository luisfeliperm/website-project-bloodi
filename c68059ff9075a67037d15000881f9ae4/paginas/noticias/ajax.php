<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/php/config/config.php");
if (!logado() || $account['nivel']<5) {die('Sem permissão!');}
$enum_cat = [1,5,3,4,6,8,9]; // Possiveis categorias

if (@$_POST['query'] == "check_url") { // Verifica se a url já existe
	$url = $_POST['url']; 
	$sql = "SELECT * FROM site_news WHERE url_id = '".$url."'; ";
	if (select_db($sql)->rowCount() > 0) {
		echo "0"; // indisponivel
	}else{
		echo "1"; // disponivel
	}
}
if (@$_POST['query'] == "check_urlEdit") { // Verifica se a url já existe pra editar

	$rand0 = $_POST['rand0'] / 77;
	$id = (($_POST['id'])-$rand0)/77;

	$url = $_POST['url']; 
	$sql = "SELECT * FROM site_news WHERE url_id = '".$url."' AND id <> ".$id."; ";
	if (select_db($sql)->rowCount() > 0) {
		echo "0"; // indisponivel
	}else{
		echo "1"; // disponivel
	}
}

if (@$_POST['query'] == "update") {
	$titulo = anti_injection($_POST['titulo'],0,2); 
	$keywords = preg_replace("/[^0-9A-z,]/", "", $_POST['keywords']);
	$imagem = anti_injection($_POST['imagem']);
	$descricao = anti_injection($_POST['descricao'],0,2);
	$url_id = preg_replace("/[^0-9.A-z_-]/", "", $_POST['url_id']);
	$conteudo = htmlspecialchars($_POST['conteudo']);
	$cat = $_POST['cat'];
	if(!in_array($cat, $enum_cat)){
		$cat = 1;
	}

	$rand0 = $_POST['rand0'] / 77;
	$id = (($_POST['id'])-$rand0)/77;
	
	if (empty($titulo) or empty($imagem) or empty($descricao) or empty($conteudo) or empty($url_id) ) {die('Preencha os campos obrigatórios!');}

	if (mb_strlen($titulo, 'utf8') < 3 OR mb_strlen($titulo, 'utf8') > 60) {
		die('O titulo deve ter 3-60 caracteres!');
	}
	if (mb_strlen($descricao, 'utf8') < 10 OR mb_strlen($descricao, 'utf8') > 300) {
		die(mb_strlen($descricao, 'utf8'). ' A descricao deve ter 10-300 caracteres!');
	}


	$sql = "
	UPDATE site_news SET url_id = '".$url_id."', imagem = '".$imagem."',keywords =  '".$keywords."',titulo = '".$titulo."',descricao = '".$descricao."',conteudo = '".$conteudo."',cat = $cat WHERE id = ".$id.";
	";
	if (query($sql)) {
		die("1");
	}else{
		die("Falha ao inserir");
	}
	
}


if (@$_POST['query'] == "add") {
	$titulo = anti_injection($_POST['titulo'],0,2); 
	$keywords = preg_replace("/[^0-9A-z,]/", "", $_POST['keywords']);
	$imagem = anti_injection($_POST['imagem']);
	$descricao = anti_injection($_POST['descricao'],0,2);
	$url_id = preg_replace("/[^0-9.A-z_-]/", "", $_POST['url_id']);
	$conteudo = htmlspecialchars($_POST['conteudo']);
	$cat = $_POST['cat'];
	if(!in_array($cat, $enum_cat)){
		$cat = 1;
	}

	if (empty($titulo) or empty($imagem) or empty($descricao) or empty($conteudo) or empty($url_id) ) {
		die('Preencha os campos obrigatórios!');
	}

	if (mb_strlen($titulo, 'utf8') < 3 OR mb_strlen($titulo, 'utf8') > 60) {
		die('O titulo deve ter 3-60 caracteres!');
	}
	if (mb_strlen($descricao, 'utf8') < 10 OR mb_strlen($descricao, 'utf8') > 300) {
		die(mb_strlen($descricao, 'utf8'). ' A descricao deve ter 10-300 caracteres!');
	}
	$sql = "

	INSERT INTO site_news 
	(url_id,imagem,keywords,titulo,descricao,conteudo,data,autor,ip,cat) VALUES 
	('".$url_id."', '".$imagem."', '".$keywords."', '".$titulo."', '".$descricao."', '".$conteudo."','".$dataLocal."', '".$account['id']."', '"._CLIENT_ADDR."',$cat)

	";
	if (query($sql)) {
		die('1');
	}else{
		die('Falha ao inserir');
	}
	
}

if (@$_POST['what'] == 'trash_new') {
	$id =intval($_POST['id']);

	$sql = "
	UPDATE site_news SET destaque = -1 WHERE id = ".$id.";
	";
	if (query($sql)) {echo 1;}else{echo 0;}

}
?>
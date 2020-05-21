<?php 
$new_identy = preg_replace("/[^0-9.A-z_-]/", "", $_GET['new_identy']) ;
$sql = "
SELECT site_news.*,contas.player_name as autor FROM site_news JOIN contas ON contas.player_id = site_news.autor WHERE url_id = '$new_identy' AND destaque > -1 ; 
";

if (select_db($sql)->rowCount() < 1) {
	header("HTTP/1.0 404 Not Found");
	require $_SERVER['DOCUMENT_ROOT']."/php/paginas/404.html";
	exit();
}
foreach (select_db($sql) as $row) {
	$new = array(
		'id'   => $row['id'],
		'imagem'   => $row['imagem'],
		'keywords'   => $row['keywords'],
		'titulo'   => $row['titulo'],
		'descricao'   => $row['descricao'],
		'conteudo'   => $row['conteudo'],
		'data'   => $row['data'],
		'autor'   => $row['autor']
	);
}
// add viwer
$sql = "UPDATE site_news SET access = access+1 WHERE url_id = '".$new_identy."'";
query($sql);

$seo_data =$new['data'];
$seo_title = $new['titulo'];
$seo_desc = $new['descricao'];
$seo_key = $new['keywords'];



$api_coments_url = $project_details['url'];

$seo_metas = "<title>".$seo_title." - ".$project_details['nome']. "</title>\n";

$seo_metas .= " <meta name=\"description\" content=\"".$seo_desc."\"> \n";

$seo_metas .= " <meta name=\"keywords\" content=\"".$project_details['defaultTags'].$seo_key."\"> \n";

$seo_metas .= " <meta property='og:title' content='".$seo_title."'> \n";

$seo_metas .= " <meta property=\"og:image\" content=\"".$new['imagem']."\"> \n";
$seo_metas .= " <meta property=\"og:image:width\" content=\"800\"> \n";
$seo_metas .= " <meta property=\"og:image:height\" content=\"600\"> \n";

$seo_metas .= " <meta property=\"og:url\" content=\"".$project_details['url']."noticia/".$new_identy."/\"> \n";

$seo_metas .= " <meta property=\"og:description\" content=\"".$seo_desc."\"> \n";


$seo_metas .= " <meta property=\"og:type\" content=\"article\"> \n";
$seo_metas .= " <meta property='article:author' content='".$new['autor']."'> \n";
$seo_metas .= " <meta property='article:section' content='noticias'> \n";
$seo_metas .= " <meta property='article:tag' content='".$seo_key."'> \n";
$seo_metas .= " <meta property='article:published_time' content='".$seo_data."'> \n";



$seo_metas .= " <meta name=\"twitter:title\" content=\"".$seo_title."\"> \n";
$seo_metas .= " <meta name=\"twitter:description\" content=\"".$seo_desc."\"> \n";
$seo_metas .= " <meta name=\"twitter:image\" content=\"".$new['imagem']."\"> \n";
$seo_metas .= " <meta name=\"twitter:card\" content=\"summary_large_image\"> \n";
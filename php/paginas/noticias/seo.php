<?php 
$categoria = $_GET['cat'] ?? '1';
if ($categoria == "5") {
	$catSql = "6,5,8,9";
	$seo_title = "Eventos - ";
}elseif($categoria == "3"){
	$catSql = "4,3,8,9";
	$seo_title = "Atualizações - ";
}else{
	$catSql = "1,4,6,9";
	$seo_title = "Noticias - ";
}

$seo_title .= $project_details['nome'];

$seo_desc = "Confira as ultimas noticias e fique por dentro do que rola no game. Noticias, eventos, atualizacoes e muito mais. ".$project_details['nome'];
$seo_key = $project_details['defaultTags']."noticias, news, novidades, eventos, status,pointblank, pb";

$seo_metas = "<title>".$seo_title."</title>\n";

$seo_metas .= " <meta name=\"description\" content=\"".$seo_desc."\"> \n";

$seo_metas .= " <meta name=\"keywords\" content=\" ".$seo_key." \"> \n";

$seo_metas .= " <meta property='og:title' content='".$seo_title."'> \n";

$seo_metas .= " <meta property=\"og:image\" content=\"".$project_details['image']."\"> \n";

$seo_metas .= " <meta property=\"og:url\" content=\"".$project_details['url']."noticias/\"> \n";

$seo_metas .= " <meta property=\"og:description\" content=\"".$seo_desc."\"> \n";

$seo_metas .= " <meta property=\"og:type\" content=\"website\"> \n";

$seo_metas .= " <meta property=\"og:image:width\" content=\"640\"> \n";
$seo_metas .= " <meta property=\"og:image:height\" content=\"480\"> \n";
$seo_metas .= " <meta name=\"twitter:title\" content=\"".$seo_title."\"> \n";
$seo_metas .= " <meta name=\"twitter:description\" content=\"".$seo_desc."\"> \n";
$seo_metas .= " <meta name=\"twitter:image\" content=\"".$project_details['image']."\"> \n";
$seo_metas .= " <meta name=\"twitter:card\" content=\"summary_large_image\"> \n";
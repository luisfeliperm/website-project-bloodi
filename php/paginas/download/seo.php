<?php 
$seo_title = "Download - ".$project_details['nome'];
$seo_desc = "Faça o download do jogo e instale - Cliente Point Blank. ".$project_details['nome'];
$seo_key = $project_details['defaultTags']."download, baixar, instalar, pointblank,pb";


$seo_metas = "<title>".$seo_title."</title>\n";

$seo_metas .= " <meta name=\"description\" content=\"".$seo_desc."\"> \n";

$seo_metas .= " <meta name=\"keywords\" content=\" ".$seo_key." \"> \n";

$seo_metas .= " <meta property='og:title' content='".$seo_title."'> \n";

$seo_metas .= " <meta property=\"og:image\" content=\"".$project_details['image']."\"> \n";

$seo_metas .= " <meta property=\"og:url\" content=\"".$project_details['url']."download/\"> \n";

$seo_metas .= " <meta property=\"og:description\" content=\"".$seo_desc."\"> \n";

$seo_metas .= " <meta property=\"og:type\" content=\"website\"> \n";

$seo_metas .= " <meta property=\"og:image:width\" content=\"640\"> \n";
$seo_metas .= " <meta property=\"og:image:height\" content=\"480\"> \n";
$seo_metas .= " <meta name=\"twitter:title\" content=\"".$seo_title."\"> \n";
$seo_metas .= " <meta name=\"twitter:description\" content=\"".$seo_desc."\"> \n";
$seo_metas .= " <meta name=\"twitter:image\" content=\"".$project_details['image']."\"> \n";
$seo_metas .= " <meta name=\"twitter:card\" content=\"summary_large_image\"> \n";
<?php 
$seo_title = "Ranking Geral - ".$project_details['nome'];
$seo_desc = "Veja o ranking dos melhores players! Lista de jogadores. Veja sua posicao no ranking. ".$project_details['nome'];
$seo_key = $project_details['defaultTags']."ranking, rank, patentes, xp,top, jogadores, pointblank";


$seo_metas = "<title>".$seo_title."</title>\n";

$seo_metas .= " <meta name=\"description\" content=\"".$seo_desc."\"> \n";

$seo_metas .= " <meta name=\"keywords\" content=\" ".$seo_key." \"> \n";

$seo_metas .= " <meta property='og:title' content='".$seo_title."'> \n";

$seo_metas .= " <meta property=\"og:image\" content=\"".$project_details['image']."\"> \n";

$seo_metas .= " <meta property=\"og:url\" content=\"".$project_details['url']."ranking/geral/\"> \n";

$seo_metas .= " <meta property=\"og:description\" content=\"".$seo_desc."\"> \n";

$seo_metas .= " <meta property=\"og:type\" content=\"website\"> \n";

$seo_metas .= " <meta property=\"og:image:width\" content=\"640\"> \n";
$seo_metas .= " <meta property=\"og:image:height\" content=\"480\"> \n";
$seo_metas .= " <meta name=\"twitter:title\" content=\"".$seo_title."\"> \n";
$seo_metas .= " <meta name=\"twitter:description\" content=\"".$seo_desc."\"> \n";
$seo_metas .= " <meta name=\"twitter:image\" content=\"".$project_details['image']."\"> \n";
$seo_metas .= " <meta name=\"twitter:card\" content=\"summary_large_image\"> \n";
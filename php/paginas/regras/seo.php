<?php 
$seo_title = "Regras - ".$project_details['nome'];
$seo_desc = "Leia as regras do jogo @camp, @CNPB. Regras do servidor, jogadores e staff. ".$project_details['nome'];
$seo_key = $project_details['defaultTags']."regras,camp,cnpb,campeonato,up,armas permitidas,staff,pointblank";


$seo_metas = "<title>".$seo_title."</title>\n";

$seo_metas .= " <meta name=\"description\" content=\"".$seo_desc."\"> \n";

$seo_metas .= " <meta name=\"keywords\" content=\" ".$seo_key." \"> \n";

$seo_metas .= " <meta property='og:title' content='".$seo_title."'> \n";

$seo_metas .= " <meta property=\"og:image\" content=\"".$project_details['image']."\"> \n";

$seo_metas .= " <meta property=\"og:url\" content=\"".$project_details['url']."regras/\"> \n";

$seo_metas .= " <meta property=\"og:description\" content=\"".$seo_desc."\"> \n";

$seo_metas .= " <meta property=\"og:type\" content=\"website\"> \n";

$seo_metas .= " <meta property=\"og:image:width\" content=\"640\"> \n";
$seo_metas .= " <meta property=\"og:image:height\" content=\"480\"> \n";
$seo_metas .= " <meta name=\"twitter:title\" content=\"".$seo_title."\"> \n";
$seo_metas .= " <meta name=\"twitter:description\" content=\"".$seo_desc."\"> \n";
$seo_metas .= " <meta name=\"twitter:image\" content=\"".$project_details['image']."\"> \n";
$seo_metas .= " <meta name=\"twitter:card\" content=\"summary_large_image\"> \n";
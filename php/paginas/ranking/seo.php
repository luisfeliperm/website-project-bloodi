<?php 
require (__DIR__."/../../class/patentes.php");
require (__DIR__."/../../class/ranking.php");

$seo_metas = null;
if (isset($_GET['busca'])) {$seo_metas .= " <meta name='robots' content='noindex' />";}

// geral | clan
$type = $_GET['type'] ?? null;
if (!($type == "clan" || $type == "geral") ) {
	header("HTTP/1.0 404 Not Found");
	require $_SERVER['DOCUMENT_ROOT']."/php/paginas/404.html";
	exit();
}
require(__DIR__."/seo/".$type.".php");
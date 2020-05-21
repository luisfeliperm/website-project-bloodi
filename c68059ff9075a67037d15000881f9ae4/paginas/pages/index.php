<?php 
$subpage = $_GET['subPage'];

switch ($subpage) {
	case 'download':
		include("download.php");
		break;
	default:
		echo "<h3>Página não encontrada</h3>";
		break;
}
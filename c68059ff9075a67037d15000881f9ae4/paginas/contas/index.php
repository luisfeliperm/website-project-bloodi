<?php 
$subpage = $_GET['subPage'];

switch ($subpage) {
	case 'lista':
		include("lista.php");
		break;
	case 'player':
		include("player/player.php");
		break;
	default:
		echo "<h3>Página não encontrada</h3>";
		break;
}
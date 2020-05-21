<?php 
$subpage = $_GET['subPage'];

switch ($subpage) {
	case 'postar':
		include("postar.php");
		break;
	case 'lista':
		include("lista.php");
		break;
	case 'edit':
		include("edit.php");
		break;
	default:
		echo "<h3>Página não encontrada</h3>";
		break;
}
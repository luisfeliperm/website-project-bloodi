<?php 
$subpage = $_GET['subPage'];

switch ($subpage) {
	case 'pincode':
		require("pincode/index.php");
		break;
	default:
		echo "<h3>Página não encontrada</h3>";
		break;
}
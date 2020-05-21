<?php 
require ("config.php");
if (!isset($_GET['port'])) {
	die();
}

switch ($_GET['port']) {
	case 'game': // Service Game
		$port = _PB_GAMEPORT;
		break;
	case 'auth': // Service auth
		$port = _PB_AUTHPORT;
		break;
	
	
	default: // Numero de porta Inteiro
		$port = intval($_GET['port']);
		break;
}
die(shell_exec('netstat -nao | find /i ":'.$port.'" | find /i "ESTABLISHED"'));
?>
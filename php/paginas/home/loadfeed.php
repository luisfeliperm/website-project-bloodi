<?php 
if (!isset($_GET['p'])){exit();}
include_once($_SERVER['DOCUMENT_ROOT']."/php/config/config.php");

switch ($_GET['p']) {
	case 'news':
	case 'events':
	case 'updates':
	case 'status':
		break;
	
	default:
		exit();
}
include(__DIR__."/feed/".$_GET['p'].".php");


<?php 
require "config.php";
function statusServer(string $addr, int $port) : bool{
	$r = true;
	$socket = @fsockopen ($addr,$port,$errno, $errstr, 1);
	if(!$socket)
		$r=false;
	else
		fclose($socket);
	return $r;
}
	
try {
	$conn = new PDO("pgsql:host="._DB_HOST.";port="._DB_PORT.";dbname="._DB_NAME, _DB_USER, _DB_PASS); 
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "SELECT access_level l,COUNT(*) t from contas GROUP BY access_level;";
	$sql_result = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

}
catch(PDOException $e){
	save_log("fatal.log","Connection: ".$sql." Resultado: ".$e->getMessage());
	echo json_encode(['sucess' => false]);
	exit();
}



$totalPlayer = 0;
$totalBan = 0;
$total_on = (int) shell_exec('netstat -nao | find /i ":'._PB_GAMEPORT.'" | find /c /i "ESTABLISHED"') ?? 0;

foreach ($sql_result as $row) {
	$totalPlayer += $row['t'];
	if ($row['l'] < 0) {
		$totalBan += $row['t'];
	}
}

$api_return = array(
	'sucess' => true,
	'accounts' => array(
		'AllPlayers' => $totalPlayer, 
		'PlayersOn' => $total_on, 
		'PlayersBlock' => $totalBan, 
	),
	'server' => array(
		'auth' => statusServer(_PB_AUTH_IP, _PB_AUTHPORT), 
		'game' => statusServer(_PB_GAME_IP, _PB_GAMEPORT), 
	)

);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
echo json_encode($api_return,JSON_UNESCAPED_UNICODE);

?>
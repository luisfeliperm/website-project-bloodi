<?php 
function calcKD($k,$d){
	if ($k ==0 && $d == 0) {
		$k = 1;$d = 1;
	}
	if ($k == 0) {$k = 1;}
	$t = $k+$d;
	$m = $k*100/$t;
	$return = number_format($m,2);
	if ($return > 100) {$return = 100;}
	return $return;
}
function calcHS($k,$h){
	if ($k ==0 && $h == 0) {
		$k = 1;$h = 1;
	}
	if ($k == 0) {$k = 1;}
	$m = $h*100/$k;
	$return = number_format($m,2);
	if ($return > 100) {$return = 100;}
	return $return;
}
$list_rank['where'] = " rank between '5' and '52' AND access_level>=0 AND player_name!='' "; // Condição para ser exibido no ranking
$list_rank['ordem'] = " exp DESC, rank DESC, kills_count DESC, headshots_count DESC "; // ordem do rank

<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/php/config/config.php");
if (logado()!==true) {die("<a href='/login/'>Faça login</a> ");}

if ($account['online'] == true) {
	die('Você está online, feche o jogo.');
}

if (isset($_POST['what'],$_POST['id'])) {
	if (logado()===false) {die('0');}

	$item_id = intval($_POST['id']);
	$sql = "DELETE FROM player_items WHERE owner_id = ".$account['id']." AND item_id = $item_id; ";
	if (query($sql)) {
		die('1');
	}else{
		die('0');
	}
}
?>
<table class="inventario">
	<tr>
		<th>Inventário</th>
		<th>Excluir</th>
	</tr>
	<?php 
	$sql = "SELECT * FROM player_items WHERE owner_id = ".$account['id']." ";
	foreach (select_db($sql) as $row) {
		?>
		<tr id="i<?php echo $row['item_id'].$row['object_id'];?>">
			<td><?php echo $row['item_name'];?></td>

			<td><a onclick="alert('Opção desativada');" href="#">[X]</a></td>
		</tr>
		<?php
	}
	?>
</table>
<style>
	.inventario{font-size: 18px;color: #009a31;}
	.inventario{
		border-collapse:collapse;border:1px solid #4c4c4c;
	    background: #04102d;width:100%;
	}
	.inventario tr{
	    width:100%;box-shadow:inset 1px 1px 20px 1px rgba(0, 47, 140, 0.5019607843137255);
	    background:rgba(27, 68, 130, 0.10196078431372549);color:#83a1e6;cursor:pointer;
	}
	.inventario tr:first-child{
	    background-color:#000d2b;color:#c3c3c3;
	    box-shadow:inset 0px 17px 20px 1px rgba(11, 49, 123, 0.3686274509803922);
	}
	.inventario  td,.inventario th { 
	    text-align:center;border:1px solid #4c4c4c;padding:8px;
	    overflow:auto;word-break:break-all;border:1px solid #02091b;padding:8px;
	}
	.inventario  tr:not(:first-child):hover{cursor:pointer;background-color:#001033;}
</style>
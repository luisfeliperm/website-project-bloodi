<?php 
$daycash = true;
if (logado()) {
	$sql = "SELECT from contas WHERE player_id = ".$account['id']." AND now()::date > daycash";
	if (select_db($sql)->rowCount() < 1) { // cash indisponivel
		$daycash = false;
	}
}
?>
<section class="loja">
	<link rel="stylesheet" type="text/css" href="/css/pages/loja.css">
	<div class="pag-title"><i class="fa fa-chevron-right" aria-hidden="true"></i> Loja</div>

	<div class="main-loja">
		<div class="aviso"><b>Dica:</b> Voce não precisa fechar o jogo, nosso servidor é integrado com o site! </div>
		<div class="left">
			<form onsubmit="return ativepin();">
				<div class="item">
					<div><label class="bold">Ativar Pincode</label></div>
				</div>

				<div class="item">
					<div><input type="text" data-enable="1" onkeyup="limiteCaract(this,20);somenteNumeros(this);" spellcheck="false" maxlength="20" placeholder="XXXXXXXXXXXXXXXX" id="input_pin"></div>
				</div>

				<div class="item">
					<div><div class="status left" id="pin_status"></div><button class="right">Ativar</button></div>
				</div>
			</form>

			<form onsubmit="return cupom();">
				<div class="item">
					<div><label class="bold">Cupom</label></div>
				</div>

				<div class="item">
					<div><input type="text" spellcheck="false" placeholder="XxXxxxXXXxX" name=""></div>
				</div>

				<div class="item">
					<div><div class="status left" id="cupom_status"></div><button class="right">Ativar</button></div>
				</div>
			</form>

		</div>

		<div class="right">
			
			<div class="daycash borda-0">
				<div class="titulo">CASH DIARIO <i class="fa fa-usd" aria-hidden="true"></i> <i class="fa fa-usd" aria-hidden="true"></i></div>

				<div class="valor txt-center" data-valor="0" id="daycashval">
					<span id="val1">0</span><span id="val2">0</span><span id="val3">0</span><span id="val4">0</span>
				</div>

				<button onclick="dayCash()"><span>RECEBER</span></button>
			</div>
			<div class="ovl-h">
				<div class="txt-right right" id="daycash_status">
					Cash recebido!
				</div>
			</div>
			
		</div>

	</div>

</section>
<script>
	var daycashval = document.getElementById('daycashval');
	var val1 = document.getElementById('val1');
	var val2 = document.getElementById('val2');
	var val3 = document.getElementById('val3');
	var val4 = document.getElementById('val4');

	<?php 
	if ($daycash) {
		echo "
			val1.innerHTML = \"0\";
			val2.innerHTML = \"5\";
			val3.innerHTML = \"0\";
			val4.innerHTML = \"0\";
			daycashval.dataset.valor = \"1\";
		";
	}
	?>
	

	function dayCash(){
		if (daycashval.dataset.valor=="0"){return false;}

		$.post('/php/paginas/cash/ajax.php',{daycash: 0},function(data){
			console.log(data);
		 var dataObj = (JSON.parse(data));

		 display_edit('daycash_status','table');
		 edita_texto('daycash_status',dataObj.resposta);

		 if (dataObj.result == "sucess") {
		 	daycashval.dataset.valor = "0";
		 	val1.innerHTML = "0";
		 	val2.innerHTML = "0";
		 	val3.innerHTML = "0";
		 	val4.innerHTML = "0";
		 }
		});
	}
	function ativepin(){
		var pincode = document.getElementById('input_pin');

		if (pincode.dataset.enable == "0") {return false;}

	 	if (pincode.value.length < 20) {
	 		pincode.focus();
	 		return false;
	 	}
	 	pincode.dataset.enable = 0;
	 	edita_texto('pin_status', '<img src="/img/layout/load2.gif">');
	 	$.post('/php/paginas/cash/ajax.php',{pincode: pincode.value},function(data){
	 		console.log(data);
	 		var dataObj = (JSON.parse(data));
	 		edita_texto('pin_status', dataObj.resposta);
	 		pincode.dataset.enable = 1;
		});
		return false;
	}
	function cupom(){
		edita_texto('cupom_status', 'Cupom inválido');
		return false;
	}
</script>
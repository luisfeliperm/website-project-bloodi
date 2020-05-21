<?php 
$modo='send';
if (isset($_GET['token'])) {
	$token =preg_replace("/[^A-Za-z0-9]/", "", $_GET['token']);
	if (empty($token) OR strlen($token) != 32) {
		$token = null;
	}
}
?>
<section class="recuperar">
	<div class="pag-title" style="margin-bottom: 50px;"><i class="fa fa-chevron-right" aria-hidden="true"></i> Recuperar senha</div>

	<div class="width-300">
	<div id="status" class="msg-0"></div>
	<?php 
	if (isset($token)) {
		$sql = " SELECT * FROM site_recuperar_senha WHERE token = '$token' AND (data + interval '1 day') > now(); ";
		$select = select_db($sql);
		if ($select->rowCount() > 0) {
			foreach ($select as $row){
				$player_id = $row['user_id'];
			}
			$sql = " SELECT * from contas WHERE player_id = $player_id ";
			foreach (select_db($sql) as $row){ ?>
				<form autocomplete="off" class="borda-0 form-recover" onsubmit="renew(); return false;">
					<input type="hidden" id="allow" value="1">
					<div class="titulo bold">Renovar senha</div>
					<div class="item">
						<div class="msg-0"><?php echo $row['email'];?></div>
					</div>
					<div class="borda"></div>
					<div class="item">
						<label for="renew_pass">Nova senha:</label>
						<input autofocus type="password" name="renew_pass" id="renew_pass">
					</div>
					<div class="item">
						<label for="renew_pass-con">Confirme:</label>
						<input autofocus type="password" name="renew_pass-con" id="renew_pass-con">
					</div>
					<div class="item submit"><button type="submit">Salvar</button></div>
				</form>
			<?php }
		}else{echo "<div class=msg-0>Este link não existe ou já expirou!</div>";}
		?>
	<?php }else{ ?>
		<form autocomplete="off" class="borda-0 form-recover" onsubmit="recupera(); return false;">
			<input type="hidden" id="allow" value="1">
			<div class="titulo bold">Recuperar senha</div>
			<div class="item">
				<label for="recovery_mail">Email:</label>
				<input autofocus type="email" name="recovery_mail" id="recovery_mail">
			</div>
			<div class="item submit"><button type="submit">Enviar</button></div>
		</form>

	<?php } ?>
	</div><!--width-300-->
	
</section>

<script>
	function recupera(){
		var allow = document.getElementById('allow');
		if (allow.value == "0"){return false;}
		mail = document.getElementById('recovery_mail');
		if (IsEmail(mail.value) === false) {mail.focus();return false;}
		allow.value = '0';
		display_edit('status','block');
		edita_texto('status','Aguarde...');
		$.post('/php/paginas/recuperar/ajax_recovery.php',{pedido: 'send',mail: mail.value},function(data){
			if (data == 1) {
				edita_texto('status','<b>Aviso:</b> Foi enviado um link de recuperação para seu email.');
				mail.value = "";
			}else{edita_texto('status',data);}
			allow.value = '1';
		});
		return false;
	}
	function renew(){
		var allow = document.getElementById('allow');
		if (allow.value == "0"){return false;}
		pass = document.getElementById('renew_pass');
		pass_c = document.getElementById('renew_pass-con').value;
		display_edit('status','block');
		if (pass.value.length > 16 || pass.value.length < 4){
			edita_texto('status','<b>Senha:</b> Deve ter de 4-16 caracteres!');
			pass.focus();return false;
		}
		if (pass.value != pass_c){
			edita_texto('status','<b>Erro:</b> Senhas diferentes!');
			return false;
		}
		allow.value = '0';
		edita_texto('status','Aguarde...');
		$.post('/php/paginas/recuperar/ajax_recovery.php',{pedido: 'renew',pass: pass.value,pass_c:pass_c,token:'<?php echo @$token;?>'},function(data){
			if (data == 1) {
				edita_texto('status','<b>Sucesso!</b> Senha alterada, faça <a href="/login/">login</a>.');
			}else{
				edita_texto('status',data);
			}
			allow.value = '1';
		});
	}
</script>
<style>
	.width-300{max-width: 300px;margin:0 auto;}
	.recuperar #status{display:none;width: 100%;margin-bottom: 10px;}
	.form-recover{
	    display: table;
	    margin: 0px auto;
	    width: 100%;
	    padding: 10px;
	}
	.form-recover .borda{border: 0.5px solid #1c346d;margin:10px 0px;}
	.form-recover input,.form-recover button{width: 100%}
	.form-recover .titulo{
	    margin: -10px -10px 10px -10px;
	    padding: 6px 3px;
	    text-align: center;
	    border-bottom: 1px solid #0f2861;
	    color: #bed1f9;
	    background: #042665;
	}
	.form-recover .item{
	    margin-bottom: 8px;
	}
	.form-recover .item label{
	    margin-bottom: 3px;display:table;
	}
	.form-recover .item input{
	    padding: 8px 16px;
	    border: 1px solid #1f3362;
	    background: rgba(49, 75, 134, 0.6);
	    color: #94b0f1;
	}
	.form-recover .item.submit button{
	    margin-top: 5px;
	    padding: 9.5px;
	    width: 100%;
	    background: rgba(49, 75, 134, 0.6);
	    border: none;
	    color: #83aeff;
	    font-weight: bold;
	    cursor: pointer;
	    transition: 0.1s;
	}
	.form-recover .item.submit button:hover{
		    background: rgba(49, 75, 134, 0.7);
	}
</style>
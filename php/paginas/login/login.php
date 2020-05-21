<?php 
$rand1 = rand(1,9);
$rand2 = rand(1,9);
?>
<section class="login">
	<div class="pag-title" style="margin-bottom: 50px;"><i class="fa fa-chevron-right" aria-hidden="true"></i> Iniciar sessão</div>
	<div id="status_login" class="msg-0" style="display:none;width: 95%;max-width: 330px;margin-bottom: 20px;"></div>
	<input type="hidden" value="5" id="chance<?php echo $rand1;?>">
	<input type="hidden" value="1" id="allow_post<?php echo $rand1;?>">
	<form class="borda-0" id="formLogin<?php echo $rand1;?>">
		<div>Faça login</div>
		<div class="formitem">
			<div class="left"><label for="usuario<?php echo $rand1;?>">Usuario: </label></div>
			<div class="right"><input maxlength="16" spellcheck="false" required tabindex="1" autofocus type="text" onkeyup="this.value = this.value.replace(/ /g,'');ant_xfs(this);document.getElementById('allow_post<?php echo $rand1;?>').value='1';limiteCaract(this,16);" id="usuario<?php echo $rand1;?>" name="usuario"></div>
		</div>

		<div class="formitem">
			<div class="left"><label for="senha<?php echo $rand1;?>">Senha: </label></div>
			<div class="right"><input maxlength="16" required tabindex="2" type="password" id="senha<?php echo $rand1;?>" name="senha" onkeyup="document.getElementById('allow_post<?php echo $rand1;?>').value='1';"></div>
		</div>

		<div class="formitem">
			<button tabindex="3" onclick="return valida_login();" type="submit">Entrar</button>
		</div>
		<div class="formitem" style="text-align:center;">
			<a tabindex="4" href="/recuperar/" style="color:#bfcfe3">Esqueceu sua senha? </a>
		</div>
		<div id="login_load"></div>
	</form>
</section>
<script>
	function valida_login(){
		display_edit('login_load','none');

		var	user = document.getElementById('usuario<?php echo $rand1;?>');
		var	pass = document.getElementById('senha<?php echo $rand1;?>');
		var allow = document.getElementById('allow_post<?php echo $rand1;?>');
		var chance = document.getElementById('chance<?php echo $rand1;?>');

		if (user.value.length < 4){
			user.focus();
			return false;
		}
		if (pass.value.length < 4){
			pass.focus();
			return false;
		}
		if (allow.value != 1){ return false; }
		if (chance.value < 1){
			edita_texto('status_login','<b>Atenção:</b> Tentativas de login excedidas!');
		 	display_edit('status_login','block');
			return false;
		}

		allow.value = '0';
		display_edit('login_load','block');
		$.post('/php/paginas/login/login_ajax.php',{user:user.value,pass:pass.value},function(data){
		 if (data == 1) {
		 	<?php 
		 	if (isset($_GET['redirect'])) {
				echo "window.location.href='".str_replace("'","",$_GET['redirect'])."';"; 
			}else{
				echo "window.location.href='/'; ";
			}
			?>
			return false;
		 }
		 display_edit('login_load','none');
		 
		 display_edit('status_login','block');
		 chance.value = (chance.value - 1);
		 if(data == 0){
		 	edita_texto('status_login','<b>Problema:</b> Usuario ou senha inválidos!');
		 }else{
		 	edita_texto('status_login',data);
		 }
		});
		return false;
	}
</script>
<style>
.login form{
	display: block;
	width: 95%;
	max-width: 330px;
	position: relative;
	margin:0px auto;
	border-radius: 5px;
}
.login form #login_load{
	display:none;
	position:absolute;top:0%;left:0%;
 	height: 100%;width: 100%;
 	background: rgba(0,0,255,0.1);
 	opacity: 0.5;
 	background: url(/img/layout/loading.gif) no-repeat center center; 
 	-webkit-background-size: cover;
  	-moz-background-size: cover;
  	-o-background-size: cover
  	background-size: cover;
}
.login form > div:nth-child(1){
	background: #042665;
    padding: 5px 3px;
    color: #bed1f9;
    text-align: center;
    border-bottom: 1px solid #0f2861;
    font-weight: bold;
    margin-bottom: 15px;
}
.login form .formitem{
    overflow: hidden;
    margin: 10px 20px;
    /*border: 1px solid #111;*/
}
.login form .formitem .left{
    width: 80px;
    padding: 8px;
    background: #042665;
    color: #83aeff;
    font-weight: bold;
}
.login form .formitem .right{
	width: calc(100% - 80px);
}
.login form .formitem input{
    padding: 9.5px;
    width: 100%;
    background: rgba(49, 75, 134, 0.6);
    color: #94b0f1;
    border: none;font-weight:bold;
}
.login form .formitem input:focus{outline:0;}
.login form .formitem input:-webkit-autofill,
.login form .formitem input:-webkit-autofill:hover, 
.login form .formitem input:-webkit-autofill:focus, 
.login form .formitem input:-webkit-autofill:active  {
    -webkit-box-shadow: 0 0 0 100px #1f3463  inset !important;
    -webkit-text-fill-color: #94b0f1 !important;
}
.login form .formitem button{
	margin:0 auto;
	padding: 9.5px;
    width: 100%;
    background: rgba(49, 75, 134, 0.6);
    border: none;
    color: #83aeff;
    font-weight: bold;
    cursor: pointer;
    transition: 0.1s;
}
.login form .formitem button:hover{
	background: rgba(49, 75, 134, 0.7);
}
</style>
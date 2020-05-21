<?php
require $_SERVER['DOCUMENT_ROOT']."/php/config/re-captcha.php";
?>
<script src="https://www.google.com/recaptcha/api.js?hl=pt-BR" async defer></script>

<section class="signup">
	<div class="pag-title" style="margin-bottom: 50px;"><i class="fa fa-chevron-right" aria-hidden="true"></i> Registrar-se</div>

	<div id="status_signup" class="msg-0" style="display:none;width: 95%;max-width: 330px;margin-bottom:20px;"></div>

	<form class="borda-0" method="post" id="form_signup">
		<div>Crie uma conta</div>
		<div class="formitem">
			<div class="left"><label for="email">Email: </label></div>
			<div class="right"><input tabindex="1" autofocus type="email" onkeyup="this.value = removeAcento(this.value);" id="email" name="email"></div>
		</div>

		<div class="formitem">
			<div class="left"><label for="user">Usuario: </label></div>
			<div class="right"><input tabindex="2" autofocus type="text" onkeyup="this.value = this.value.replace(/ /g,'');ant_xfs(this);limiteCaract(this,16);" id="user" name="user"></div>
		</div>

		<div class="formitem">
			<div class="left"><label for="pass">Senha: </label></div>
			<div class="right"><input tabindex="3" type="password" id="pass" name="pass" onkeyup=""></div>
		</div>

		<div class="formitem">
			<div class="left"><label for="re-pass">Confirme: </label></div>
			<div class="right"><input tabindex="4" type="password" id="re-pass" name="re-pass"></div>
		</div>

		<div class="formitem">
			<div class="g-recaptcha" data-sitekey="<?php echo _CAPTCHA_SITEKEY;?>" data-tabindex="5" data-callback="sucess_captcha" data-expired-callback="expiredCallBack" data-error-callback="errorCallBack"></div>
		</div>

		<div class="formitem">
			<button tabindex="6" onclick="return valida_signup();" type="submit">Cadastrar</button>
		</div>

		<div class="formitem" style="text-align:center;">
			<a tabindex="7" href="/login/" style="color:#bfcfe3">Fazer login</a>
		</div>

		<div id="signup_load"></div>
	</form>
</section>
<script>
	var notRobot = false;
	
	function sucess_captcha(){notRobot = true;}
	function expiredCallBack(){notRobot = false;}
	function errorCallBack(){
		edita_texto('status_signup','<b>Erro:</b> Falha na conectividade com o captcha!');
		display_edit('status_signup','block');
	}

	function valida_signup(){
		display_edit('status_signup','none');

		var	email = document.getElementById('email');
		var	user = document.getElementById('user');
		var	pass = document.getElementById('pass');
		var	re_pass = document.getElementById('re-pass');

		if (email.value.length < 1){
			email.focus();return false;
		}
		if ( endsWithAny(["gmail.com", "outlook.com", "hotmail.com"], email.value)  === false) {
			edita_texto('status_signup','<b>Email:</b> só é permitido o uso do gmail, outlook e hotmail');
		 	display_edit('status_signup','block');
			email.focus();return false;
		}
		
		if (IsEmail(email.value) === false) {
			email.focus();return false;
		}
		if (user.value.length < 4){
			user.focus();return false;
		}
		if (pass.value.length > 16 || pass.value.length < 4){
			edita_texto('status_signup','<b>Senha:</b> Deve ter de 4-16 caracteres!');
		 	display_edit('status_signup','block');
			pass.focus();return false;
		}
		if (pass.value != re_pass.value){
			edita_texto('status_signup','<b>Atenção:</b> As senhas devem ser iguais!');
			display_edit('status_signup','block');
			re_pass.value = "";
			re_pass.focus();return false;
		}
		
		if(!notRobot){
			edita_texto('status_signup','<b>Atenção:</b> confirme o captcha!');
		 	display_edit('status_signup','block');
		 	return false;
		}
		
		display_edit('signup_load','block');
		$.post('/php/paginas/signup/ajax.php',{mail:email.value,user:user.value,pass:pass.value, re_captcha: grecaptcha.getResponse() },function(data){
			console.log(data);
		 display_edit('signup_load','none');
		 display_edit('status_signup','block');

		 if (data == 1) {
		 	edita_texto("status_signup","<b>Confirme: </b> <span style='color: #deca2c;font-weight: bold;'>"+email.value+"</span>");
		 	document.getElementById("form_signup").reset();
		 }else if(data == 0){
		 	edita_texto("status_signup","<b>Atenção: </b> Falha no sistema, informe ao administrador");
		 	console.log(data);
		 }else{
		 	edita_texto("status_signup", data);
		 }
		});

		notRobot = false;
		grecaptcha.reset();

		return false;
	}
	function allow_post(){ document.getElementById('allow_post').value='1';}
</script>
<style>
	.signup form{
		display: block;
		width: 95%;
		max-width: 330px;
		position: relative;
		margin:0px auto;
		border-radius: 5px;
	}
	.signup form #signup_load{
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
	.signup form > div:nth-child(1){
		background: #042665;
	    padding: 5px 3px;
	    color: #bed1f9;
	    text-align: center;
	    border-bottom: 1px solid #0f2861;
	    font-weight: bold;
	    margin-bottom: 15px;
	}
	.signup form .formitem{
	    overflow: hidden;
	    margin: 10px 20px;
	}
	.signup form .formitem .left{
	    width: 90px;
	    padding: 8px;
	    background: #042665;
	    color: #83aeff;
	    font-weight: bold;
	}
	.signup form .formitem .right{width: calc(100% - 90px);}
	.signup form .formitem input{
	    padding: 9.5px;
	    width: 100%;
	    background: rgba(49, 75, 134, 0.6);
	    color: #94b0f1;
	    border: none;font-weight:bold;
	}
	.signup form .formitem input:focus{outline:0;}
	.signup form .formitem input:-webkit-autofill,
	.signup form .formitem input:-webkit-autofill:hover, 
	.signup form .formitem input:-webkit-autofill:focus, 
	.signup form .formitem input:-webkit-autofill:active  {
	    -webkit-box-shadow: 0 0 0 100px #1f3463  inset !important;
	    -webkit-text-fill-color: #94b0f1 !important;
	}
	.signup form .formitem button{
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
	.signup form .formitem button:hover{background: rgba(49, 75, 134, 0.7);}
</style>
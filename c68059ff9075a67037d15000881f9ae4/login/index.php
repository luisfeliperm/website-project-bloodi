<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/php/config/config.php");
if (logado(true) === true) {
	header('Location: /c68059ff9075a67037d15000881f9ae4/');
	die('Voce ja está logado como admin');
}
require("maxAttempts.php");
try {
	$protecao = new noBrute();
	$protecao->getInfo();

	$restAttemps = (3-$protecao->check());
    if ($restAttemps < 1) {
		die("Voce errou 3 vezes em menos de 10 minutos, Tente novamente em ".$protecao->time(). " minutos.");
	}else if($restAttemps < 3){
		$alert[0] = "<div><b>Atenção!</b> Restam apenas $restAttemps tentativas.</div>";
	}
} catch (Exception $e) {
	save_log("fatal.log", "[admin.login.maxAttempts] ".$e->getMessage(), "\n");
    die('[FATAL] Contate o desenvolvedor urgente!');
}

$salt = "@*_-+#?!=$%&&";

function gerar_hash($senha){
	$salt = '/x!a@r-$r%an¨.&e&+f*f(f(a)';
	$output = hash_hmac('md5', $senha, $salt);
	return $output;
}

if (isset( $_POST['pass'],$_POST['user'] )) {
	
	(bool) $validPass = (mb_strlen(trim($_POST['pass']), 'utf8') >= 4  && mb_strlen(trim($_POST['pass']), 'utf8') <= 16);
	(bool) $validUser = (mb_strlen(trim($_POST['user']), 'utf8') >= 4  && mb_strlen(trim($_POST['user']), 'utf8') <= 16);


	$user = strtolower(anti_injection($_POST['user'])) ?? null;
	$pass = gerar_hash($_POST['pass']) ?? null;

	$sql = "SELECT * from contas WHERE lower(login) = '$user' AND password = '$pass' AND access_level > 3 ";

	if (($validPass && $validUser) && select_db($sql)->rowCount() > 0) {
		$_SESSION['usuario'] = $user;
		$_SESSION['senha'] = $pass;
		$_SESSION['admin'] = true;
		
		$protecao->dell();
		header('Location: /c68059ff9075a67037d15000881f9ae4/');
	}else{
		$protecao->write();
		if($restAttemps == 3){
			$alert[0] = "<div><b>Atenção!</b> Restam apenas 2 tentativas.</div>";
		}else if($restAttemps == 2){
			$alert[0] = "<div><b>Atenção!</b> Restam apenas 1 tentativas.</div>";
		}else if($restAttemps == 1){
			die("Voce errou 3 vezes em menos de 10 minutos, Tente novamente em ".$protecao->time(). " minutos.");

		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login - Administrador</title>
	<meta charset="utf-8">
	<script src="/js/default.js?version=0.12.4"></script>
	<meta name="robots" content="noindex, nofollow">
	<style type="text/css">
		*{font-family:arial;box-sizing:border-box;}
		.borda{border: 0.5px solid #ccc;}
		.pd-10{padding: 10px;}
		html{
			background: url(/img/wallpapers/background6.jpg) no-repeat center center fixed;
		    background-size: cover;
		  	height: 100%;
		}
		body{margin:10px;padding:0;}
		.your_ip{
		    margin: 20px auto;
		    margin-top: 156px;
		    display: table;
		    border: 1px solid #ddd;
		    background: #f3f3f3;
		    border-radius: 5px;
		    color: #004692;
		    width: 300px;
		    box-shadow: 0px 0px 42px 5px rgba(0,0,0,0.48);
		    padding: 10px;
		    box-shadow: inset 0px 0px 42px 5px rgba(111, 169, 232, 0.84);
		    border-left: 5px solid #004692;
		    text-shadow: 1px 1px 1px #fff;
		}
		form{
			margin: 20px auto;
		    display: table;
		    border: 1px solid #ddd;
		    background: #f3f3f3;
		    border-radius: 5px;
		    color: #5a5a5a;
		     width: 300px;
		    box-shadow: 0px 0px 42px 5px rgba(0, 0, 0, 0.47843137254901963);
		}
		form > p{
		    background-color: #dadada;
		    padding: 10px;
		    margin: 0;
		    font-weight: bold;
		    font-size: 18px;
		    text-align: center;
		    border-bottom: 1px solid #ccc;
		    color: #427298;
		    text-shadow: 1px 1px 1px #fff;
		}
		form div.item{
			overflow: hidden;
		}
		form div.item label{
		    display: block;
		    float: left;
		    border:none;
		    border-top: 1px solid #e4dfdf;
		    border-right: none;
		    font-weight: bold;
		    background: #ffff;
		    color: #5a5a5a;
		    width: 80px;
		    padding:8px 4px;
		}
		form div.item input{
		    display: block;
		    float: right;
		    border: 1px solid #e4dfdf;
		    border-width:1px 1px 0px 1px;
		    outline: none;
		    font-weight: bold;
		    width: calc(100% - 80px);
		    padding:9.5px 8px;
		    color: #444;
		}
		form div.item button{
		    width: 100%;
		    display: block;
		    background-image: linear-gradient(white, #e8e8e8);
		    border:none;
		    border-top:1px solid #ccc;
		    padding: 10.5px 5px;
		    font-weight: bold;
		}
		form div.item button:hover{
		    background-image: linear-gradient(#f5f5f5, #e8e8e8);
		    cursor: pointer;
		}
		/* Relembrar */
		.relembrar{
		    margin: 20px auto;
		    display: table;
		    color: #5a5a5a;
		    width: 300px;
		}
		.relembrar a{
		    color: #2669b1;
		    font-weight: bold;
		}
		.alertas{overflow: hidden;}
		.alertas > div{
			float: left;
			margin-right: 10px;
		    border: 1px solid #c1c08b;
		    background: #d2cb009c;
		    color: #401717;
		    border-radius: 5px;
		    width: 300px;
		    padding: 10px;
		}
	</style>
</head>
<body>
<div>
	<div class="alertas">
		<?php 
		if(isset($alert)){
			foreach ($alert as $value) {
			    echo $value;
			}
		}
		?>
		
	</div>

	<div class="your_ip"><b><?php echo _CLIENT_ADDR;?></b></div>
	<form method="post" id="form">
		<p>CMS - Project Bloodi</p>
		<div class="item">
			<label>Usuario:</label>
			<input type="text" name="user" id="user" onkeyup="this.value = this.value.replace(/ /g,'');ant_xfs(this);">
		</div>

		<div class="item">
			<label>Senha:</label>
			<input type="password" name="pass" id="pass">
		</div>

		<div class="item">
			<button onclick="return valida();">ACESSAR</button>
		</div>
	</form>
	<div class="relembrar">
		<a href="#">Esqueceu a senha?</a>
	</div>
</div>
<script>
	function valida(){
		var user = document.getElementById('user');
		var pass = document.getElementById('pass');

		if (user.value.length < 1) {
			user.focus();return false;
		}
		if (pass.value.length < 1) {
			pass.focus();return false;
		}
	}
</script>
</body>
</html>
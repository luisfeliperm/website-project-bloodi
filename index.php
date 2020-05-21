<?php
$pagina = @$_GET['page'] ?? "home";
$pagina = preg_replace("/[^A-Za-z0-9-]+/", "", $pagina);
$file_pagina = $_SERVER['DOCUMENT_ROOT']."/php/paginas/".$pagina."/".$pagina.".php";

$seo = $_SERVER['DOCUMENT_ROOT']."/php/paginas/".$pagina."/seo.php";
if(!file_exists(stream_resolve_include_path($file_pagina))){
	header("HTTP/1.0 404 Not Found");
	require $_SERVER['DOCUMENT_ROOT']."/php/paginas/404.html";
	exit();
}
if(!file_exists(stream_resolve_include_path($seo))){
	$seo = $_SERVER['DOCUMENT_ROOT']."/php/paginas/home/seo.php"; // Se nao existir, inclui SEO padrao
}
require($_SERVER['DOCUMENT_ROOT']."/php/config/config.php");
require($_SERVER['DOCUMENT_ROOT']."/php/class/project_details.php");
require $seo;
include($_SERVER['DOCUMENT_ROOT']."/php/class/msg.php");
?><!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<?php echo $seo_metas; ?>
	<meta property="og:locale" content="pt_BR">
	<meta property="fb:app_id" content="548645135620165" />
	<meta property="og:site_name" content="<?php echo $project_details['nome'];?>">
	<meta name="twitter:creator" content="@luisfeliperm" />
	<meta name="twitter:site" content="@luisfeliperm" />
	<meta name="google-site-verification" content="9PpTBuWjkf1acKxZmUL4YnCmUmvMQWXYDqOd_feHZAU" />
	<meta name="robots" content="index, follow">
	<link rel="stylesheet" type="text/css" href="/css/default.css?version=0.12.4">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="author" href="humans.txt" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="/favicon.ico" />
</head>
<body>
<noscript><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Seu navegador não suporta <span>JavaScript</span>, o site não funcionará corretamente!<img src="/img/layout/noscript.png"></noscript>
<div id="fb-root"></div>
<script>
	(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if(d.getElementById(id)) return;
	js = d.createElement(s);
	js.id = id;
	js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11&appId=2064418576960613&autoLogAppEvents=1';
	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>

<header>
	<!-- L O G O -->
	<div class="site-logo layout-01">
		<figure>
			<img alt="Project Bloodi - PointBlank Server UDP3" src="/img/layout/logo/logo.png">
		</figure>
	</div>


	<nav class="layout-01">
		<ul class="desktop">
			<li><a href="/">HOME</a></li>
			<li class="menu-drop">
				<a href="javascript:void(0);">NOVIDADES</a>
				<div class="nav-sub_menu">
					<a href="/eventos/">Eventos</a>
					<a href="/noticias/">Noticias</a>
					<a href="/atualizacoes/">Atualizações</a>
				</div>
			</li>
			<li><a href="/download/">DOWNLOAD</a></li>
			<li><a href="/cash/">CASH</a></li>
			<li class="menu-drop">
				<a href="javascript:void(0);">RANKING</a>
				<div class="nav-sub_menu">
					<a href="/ranking/geral/">GERAL</a>
					<a href="/ranking/clan/">CLÃN</a>
				</div>
			</li>
			<li><a href="/suporte/">SUPORTE</a></li>
			<li class="right menu-drop">
				<a href="javascript:void(0);"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
				<div class="nav-sub_menu">
					<a href="/regras/">Regras</a>
					<a href="#" target="_blank">Tutorial</a>
					<a href="#">Dúvidas</a>
					<a href="#">Sobre</a>
				</div>
			</li>
		</ul>

		<ul class="mobile">
			<li><a href="javascript:void(0);" onclick="display_edit('nav-mob','block');"><i class="fa fa-bars" aria-hidden="true"></i></a></li>
			<li class="menu-drop right">
				<a href="javascript:void(0);"><i class="fa fa-user" aria-hidden="true"></i></a>
				<div class="nav-sub_menu">
					<?php 
					if(logado() === true) {?>
					<a href="/minha-conta/"><span><i class="fa fa-user-circle" aria-hidden="true"></i></span> <span>Minha Conta</span></a>
					<a href="/cash/"><span><i class="fa fa-shopping-basket" aria-hidden="true"></i></span> <span>Pincode</span></a>
					<a href="/?bye"><span><i class="fa fa-sign-out" aria-hidden="true"></i></span> <span>Sair</span></a>
					<?php  }else{ ?>
					<a href="/login/"><span><i class="fa fa-sign-in" aria-hidden="true"></i></span> <span>Entrar</span></a>
					<a href="/signup/"><span><i class="fa fa-user-plus" aria-hidden="true"></i></span> <span>Criar conta</span></a>
					<?php }?>
				</div>
			</li>
		</ul>

		<div id="nav-mob" class="mobile esc"><!-- Menu oculto -->
			<a class="menumob-close" href="javascript:void(0);" onclick="display_edit('nav-mob','none');"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
			<ul class="mobile" id="menu-mob">
				<li><a href="/">HOME</a></li>
				<li class="menu-drop">
					<a href="javascript:void(0);">NOVIDADES <span class="mobile"><i class="fa fa-caret-down" aria-hidden="true"></i></span></a>
					<div class="nav-sub_menu">
						<a href="/eventos/"><span><i class="fa fa-caret-right" aria-hidden="true"></i></span> Eventos</a>
						<a href="/noticias/"><span><i class="fa fa-caret-right" aria-hidden="true"></i></span> Noticias</a>
						<a href="/atualizacoes/"><span><i class="fa fa-caret-right" aria-hidden="true"></i></span> Atualizações</a>
					</div>
				</li>
				<li><a href="/download/">DOWNLOAD</a></li>
				<li><a href="/cash/">CASH</a></li>


				<li class="menu-drop">
					<a href="javascript:void(0);">RANKING <span class="mobile"><i class="fa fa-caret-down" aria-hidden="true"></i></span></a>
					<div class="nav-sub_menu">
						<a href="/ranking/geral/"><span><i class="fa fa-caret-right" aria-hidden="true"></i></span> GERAL</a>
						<a href="/ranking/clan/"><span><i class="fa fa-caret-right" aria-hidden="true"></i></span> CLÃN</a>
					</div>
				</li>
				
				
				<li><a href="/suporte/">SUPORTE</a></li>
			</ul>
		</div>
		<div class="both"></div>
	</nav>
</header>
<div class="layout-01 principal">
<aside class="desktop">
	<div class="aside_cont-0 borda-0 acc">
		<?php 
		if(logado()) {?>
		<div class="welcome">Olá <span><?php echo (!empty($account['nick']) ? $account['nick'] : $account['usuario']);?></span></div>
		<a href="/minha-conta/" class="btn-0"> Minha conta</a>
		<a href="/cash/" class="btn-0">Pincode</a>
		<a href="/?bye" class="btn-0"><i class="fa fa-sign-out"></i> Logout</a> 
		<?php  }else{ ?>
		<div class="welcome">Faça login ou crie uma conta</div>
		<a href="/login/" class="btn-0"> Entrar</a>
		<a href="/signup/" class="btn-0">Cadastrar</a>
		<?php }?>
		
	</div>

	<div class="aside_cont-1">
		<a href="/download/" class="download"><i class="fa fa-download" aria-hidden="true"></i> Download <span>2.5gb</span></a>
	</div>

	<div class="aside_cont-1 daycash">
		<a href="/cash/"><img src="/img/layout/fljadslkjx2312312.jpeg"></a>
	</div>

	<div class="borda-0"></div>

	<div class="aside_cont-1 social">
		<div class="s_icon">
			<a href="https://www.facebook.com/groups/ProjectBloodiOficial1/" title="Grupo do facebook"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
			<a href="https://chat.whatsapp.com/D875byXoFTqKkwxDWYnAGf" title="Grupo WhatsApp"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
			<a href="https://www.youtube.com/channel/UC5yuelBl8etVkrJ-f-ojLbA/videos" title="Canal do Youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
		</div>

	    <div class="fb-group" 
	         data-href="https://www.facebook.com/groups/ProjectBloodiOficial1/" 
	         data-show-social-context="true" 
	         data-show-metadata="false">
	    </div>
	</div>

	<div class="aside_cont-1 borda-0 aside_menu">
		<div><b><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> MENU</b> - Atalhos</div>
		<ul>
			<li><a href="/arquivos/XPatentes.pdf">Patentes - XP</a></li>
			<li><a href="/cash/">Ativar Pincode</a></li>
			<li><a href="/#feed-tab-status">Status</a></li>
			<li><a href="#">Problemas Tecnicos</a></li>
			<li><a href="/regras/">Regras</a></li>
		</ul>
	</div>
</aside>
<main><?php require($file_pagina); # Inclui PÁGINAS?></main>

<div class="desktop both"></div>
</div>









<!-- !!! Não remova os créditos !!!! -->
<footer id="footer">
	<div style="max-width: 1000px;margin:0 auto">
		<h2>Point Blank Privado</h2>
		<div class="borda-1" style="margin:10px 0px;"></div>

		<div class="ovl-h">

			<div class="left sobre">
				<h4>Sobre nós</h4>

				<div>
					Este é um servidor de <strong>Point Blank Pirata</strong> e privado. Nosso objetivo não é financeiro mas sim o entretenimento e diversão dos jogadores. Estamos na área desde 2018 e construímos muita coisa. Nossa equipe conta com pessoas altamente capacitadas para administrar o servidor. Nossos serviços são protegidos contra qualquer tipo de ataque! Somos desenvolvedores da nossa distribuição do servidor <b>UDP3</b>. Temos "imunidade" contra os que costumavam atacar os mais fracos (Não citaremos nomes) e apavorar a comunidade do Point Blank Privado.
				</div>
			</div>
			
			<!-- Não remova os creditos do website -->
			<div class="right dev-website">
				<table>
					<thead>
						<tr>
							<th colspan="2">WebSite</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Criador:</th>
							<td>luisfeliperm</td>
						</tr>
						<tr>
							<th>Github:</th>
							<td>github.com/luisfeliperm</td>
						</tr>
						<tr>
							<th>Email:</th>
							<td>luisfelipepoint@gmail.com</td>
						</tr>
					</tbody>
				</table>			
			</div>

		</div>

		<div class="links">
			<ul>
				<li><a href="https://chat.whatsapp.com/D875byXoFTqKkwxDWYnAGf">WhatsApp Group</a></li>
				<li><a href="#">bloodipb.ts3bg.com</a></li>
				<li><a href="https://www.facebook.com/groups/ProjectBloodiOficial1/">facebook</a></li>
				<li><a href="https://youtube.com/">Youtube</a></li>
				<li><a href="http://forum.ragezone.com/">Ragezone</a></li>
			</ul>
		</div>

		
	</div>
	<div class="copyright">
		Copyright © 2018-<?php echo date("Y");?>  - Project Bloodi
	</div>
</footer>









<div id="modal" class="esc">
	<div class="modal_head ovl-h">
		<i onclick="display_edit('modal', 'none');" class="fa fa-times right" aria-hidden="true"></i>
	</div>
	<div id="modal_main"></div>
</div>
<script src="/js/default.js?version=0.12.4"></script>


<?php if ($project_details['off_Alert']): ?>
	<style>
		.alert-Server-Off{
		    position: fixed;top: 0;left:0;right:0;z-index: 3;
		    font-size: 14px;padding: 7px 20px;
		    border-bottom: 3px solid #ff6861;color: #ffffff;
		    background-color: #bb3504;
		    display: none;
		}
		.alert-Server-Off i{margin-right: 5px;}
	</style>

	<div class="alert-Server-Off" >
		<b><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta: </b>
		<span>O jogo está <b>offline!</b></span>
	</div>
<?php endif ?>

<script src="/js/api_server_details.js"  data-api_url="<?php echo _API_HOST."statistics.php";?>" async defer></script>

</body>
</html>

<link rel="stylesheet" href="/js/font-awesome-4.7.0/css/font-awesome.min.css?version=0.12.4">
<script>
	document.onkeydown = function(evt) {
	 /* ESC */ evt = evt || window.event;if(evt.keyCode == 27) {
	$('.esc').css('display','none');
	}};
	function inclui_page(nome){ // Função que inclui pagina no modal
		display_edit('modal', 'block');
		$(document).ready(function() {
		    $( "#modal_main" ).load(nome);
		});
	}
</script>
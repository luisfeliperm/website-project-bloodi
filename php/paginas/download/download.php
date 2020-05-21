<?php 
$read_download_links = (parse_ini_file($_SERVER['DOCUMENT_ROOT']."/php/paginas/download/links.ini",true));
?>

<link rel="stylesheet" type="text/css" href="/css/pages/download.css?version=0.12.4">
<section class="download">
	<div class="pag-title"><i class="fa fa-chevron-right" aria-hidden="true"></i> Download Cliente</div>

	<div class="download-header">
		<figure>
			<img src="/img/post/modal2.jpg">
			<figcaption>Download direto</figcaption>
		</figure>
		<div class="download-link">
			<a <?php echo ($read_download_links['link1']['blank'] ? 'target=_blank' : null); ?> href="<?php echo $read_download_links['link1']['url']; ?>"><i class="fa fa-download" aria-hidden="true"></i> <span>BAIXAR</span></a>
		</div>
	</div>

	<div class="download-second ovl-h">
		<a <?php echo ($read_download_links['link2']['blank'] ? 'target=_blank' : null); ?> href="<?php echo $read_download_links['link2']['url']; ?>"><?php echo $read_download_links['link2']['name']; ?></a>
		<a <?php echo ($read_download_links['link3']['blank'] ? 'target=_blank' : null); ?> href="<?php echo $read_download_links['link3']['url']; ?>"><?php echo $read_download_links['link3']['name']; ?></a>
	</div>

	<div class="borda" ></div>
	
	<div class="divide-2 ovl-h">
		<div class="left requisitos">
			<table>
				<thead>
					<tr><th colspan="2">Requisitos Minimos</th></tr>
				</thead>
				<tbody>
					<tr>
						<td>Sistema Operacional</td>
						<td>Windows Xp ou superior</td>
					</tr>
					<tr>
						<td>Processador</td>
						<td>P4 2.4Ghz ou Athlon 2500+</td>
					</tr>
					<tr>
						<td>RAM</td>
						<td>2GB</td>
					</tr>
					<tr>
						<td>Placa de Vídeo	</td>
						<td>Geforce 5700/Radeon 9600</td>
					</tr>
					<tr>
						<td>HD</td>
						<td>3GB para instalação</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="right help-a">
			<iframe src="https://www.youtube.com/embed/href3VsrK-s" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

			<div><b>Recomendação: </b>Baixe o <a style="color:#cecece" target="_blank" href="https://ouo.io/urTrx4">Game Boster 3.5</a> e obtenha o máximo de desempenho.</div>
		</div>
	</div>

	<div class="borda-1"></div><br>
	
	<div class="divide-2 download-footer ovl-h">
		<div class="right caixa-download ovl-h">
			<div class="link ovl-h">
				<img src="/img/layout/1896cea50f9c0c4445d340146a7352ca.png">
				<div class="info">
					<div class="titulo">Game Boster</div> 
					<div>Performance++</div>
					<div><a target="_blank" href="https://ouo.io/2aB8oj"><i class="fa fa-download" aria-hidden="true"></i></a></div>
				</div>
			</div>

			<div class="link link-blue ovl-h">
				<img src="/img/layout/63362e2d47c4e8e56ec026e748a6ae7c.png">
				<div class="info">
					<div class="titulo">Launcher</div> 
					<div>Fix Bugs</div>
					<div><a target="_blank" href="https://ouo.io/7bacCr"><i class="fa fa-download" aria-hidden="true"></i></a></div>
				</div>
			</div>
		</div>

		<div class="left suporte">
			<h1>Suporte</h1>
			<ul>
				<li>Launcher erro <b>0x000001</b> <a target="_blank" href="https://ouo.io/7bacCr">[FIX]</a></li>
			</ul>
		</div>

		
	</div>
	
</section>
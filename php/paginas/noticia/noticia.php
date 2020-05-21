<link rel="stylesheet" type="text/css" href="/css/post_class.css?version=0.12.4">

<style type="text/css">
	.news img{width: 100%;height: 100%;}
	/* Destaque */
	.news-principal{
	    min-height: 280px;
	    border: 1px solid #4267b2;
	    background: #091b46;
	    padding: 0;
	    color: #83a1e6;
	    box-shadow: 1px 1px 5px 1px #0f2861;
	    margin:0 auto;
	}
	.news-principal figure{
		margin:0;
		position:relative;
		height:347px;
	}
	.news-principal figure figcaption{
		position: absolute;top: 0;left: 0;
	    width: 100%;
	    text-align: right;
	    text-shadow: 1px 1px 16px #0f2861;
	    color: #b7ceff;
	    text-shadow: 1px 1px 1px #000;
	    font-size: 14px;
	    padding: 3px 10px;
	    background: rgba(0, 18, 56, 0.6);
	}
	.news-principal figure img{width: 100%;min-height: 220px;}
	.news-principal .news-info{padding: 20px 15px;min-height: 200px;}
	.news-principal .news-info .news-autor{overflow: hidden;margin-bottom: 10px;}
	.news-principal .news-info .news-autor > div{font-size: 15px;float: left;padding-right:15px;}
	.news-principal .news-info .news-autor > div:last-child{padding:0;}
	@media only screen and (max-width: 560px) {
		.news-principal figure {height: auto;min-height: 220px;}
	}
	/* Fim dos do DESTAQUE */
</style>
<section class="news">
	<div class="pag-title"><i class="fa fa-chevron-right" aria-hidden="true"></i> Noticia</div>
	<article class="news-principal">
		<figure>
			<figcaption class="bold">Noticia</figcaption>
			<img alt="Descrição da imagem" title="<?php echo $new['titulo'];?>" src="<?php echo $new['imagem'];?>">
		</figure>
		<div class="news-info">
			<div class="news-autor">
				<div><i class="fa fa-calendar" aria-hidden="true"></i> <time datetime="<?php echo dataIso8601($seo_data);?>" pubdate><?php echo date('d/m/Y', strtotime($new['data']));?></time></div>
				<div><i class="fa fa-user" aria-hidden="true"></i> <span><?php echo $new['autor'];?></span></div>
			</div>
			<div class="borda-1" style="margin:10px 0px 20px 0px;"></div>
			<h1><?php echo htmlspecialchars($new['titulo']);?></h1>
			<h2><?php echo htmlspecialchars($new['descricao']);?></h2>

			<div class="borda-1" style="margin:10px 0px"></div>
			<div class="news-conteudo">
				<?php echo html_entity_decode($new['conteudo']);?>
			</div>
		</div>
	</article>
	<div class="borda-0" style="margin:6px 0px 20px 0px;box-shadow: 0px 4px 15px 1px #06286c;"></div>
	<div class="comentarios">
		<script async defer src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.2"></script>
		<div>
			<div class="fb-comments" data-colorscheme="light" data-href="<?php echo $api_coments_url;?>noticia/<?php echo $new_identy;?>/" data-width="100%" data-numposts="5"></div>
		</div>
	</div>
</section>
<style>
	.news-conteudo{
		padding: 10px 0px;
	}
	.news-conteudo a{color: #b1bfe0;}
	.comentarios{
		border: 1px solid #02143e;
    	background: #fff;
	}

</style>
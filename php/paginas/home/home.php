<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/php/class/ranking.php");
include_once($_SERVER['DOCUMENT_ROOT']."/php/class/patentes.php");
?>
<link rel="stylesheet" type="text/css" href="/css/pages/home.css?version=0.12.4">
<section class="sct-home">
	<div class="pag-title"><i class="fa fa-chevron-right" aria-hidden="true"></i> Home Page</div>

	<input type="hidden" id="modal_atual" value="0"> <!-- Slide atual -->
	<input type="hidden" id="start" value="0"> <!-- Status de evento Slider -->
	<div class="home-modal">
		<div class="modal-news" style="background-image: url(/img/post/k157yp.gif);" id="home-modal1">
			<div class="modal-cont right">
				<div class="modal-title">Cash na hora!!</div>
				<div class="modal-desc">
					<p>Ative seu cash sem precisar relogar</p>
				</div>
				<div class="mod-alter txt-center">
					<i class="fa fa-circle ativo" aria-hidden="true"></i>
					<i class="fa fa-circle" aria-hidden="true"></i>
					<i class="fa fa-circle" aria-hidden="true"></i>
				</div>
			</div>
		</div>

		<div class="modal-news" style="background-image: url(/img/post/giphy-1.gif);" id="home-modal2">
			<div class="modal-cont right">
				<div class="modal-title">Servidor com PING FIXO!</div>
				<div class="modal-desc">
					<p>Nossa equipe conta com programadores</p>
				</div>
				<div class="mod-alter txt-center">
					<i class="fa fa-circle" aria-hidden="true"></i>
					<i class="fa fa-circle ativo" aria-hidden="true"></i>
					<i class="fa fa-circle" aria-hidden="true"></i>
				</div>
			</div>
		</div>

		<div class="modal-news" style="background-image: url(/img/post/animefire.webp);" id="home-modal3">
			<div class="modal-cont right">
				<div class="modal-title">VPS BRASILEIRA!</div>
				<div class="modal-desc">
					<p>Server top, sem lag ? Só aqui!</p>
					<p>Faça um teste</p>
				</div>
				<div class="mod-alter txt-center">
					<i class="fa fa-circle" aria-hidden="true"></i>
					<i class="fa fa-circle" aria-hidden="true"></i>
					<i class="fa fa-circle ativo" aria-hidden="true"></i>
				</div>
			</div>
		</div>
	</div>
	
	<div class="borda-0" style="margin:10px 0px 20px 0px"></div>

	<div class="last-updates">
		<div class="ls-u-topo">
			<div class="ls-u-topo-icon"><i class="fa fa-rss" aria-hidden="true"></i></div>
			<ul>
				<li><a id="a-feedtab-news" onclick="feed('news');" href="javascript:void(0)">Noticias</a></li>
				<li><a id="a-feedtab-updates" onclick="feed('updates');" href="javascript:void(0)">Atualizações</a></li>
				<li><a id="a-feedtab-events" onclick="feed('events');" href="javascript:void(0)">Eventos</a></li>
				<li><a id="a-feedtab-status" onclick="feed('status');" class="active" href="javascript:void(0)">Status</a></li>
			</ul>
		</div>
		<div class="ls-u-meio">
			<ul id="feed-tab-news" style="display:none;" data-load="0"></ul>

			<ul id="feed-tab-updates" style="display:none;" data-load="0"></ul>

			<ul id="feed-tab-events" style="display:none;" data-load="0"></ul>

			<!-- Status sempre será carregado no inicio devido ao callback da api_server_details -->
			<ul id="feed-tab-status" style="display:block;" data-load="1">
				<?php include(__DIR__."/feed/status.php"); ?>
			</ul>

		</div>
	</div>
	<div class="borda-0" style="margin:10px 0px 20px 0px;box-shadow: 0px 4px 15px 1px #06286c;"></div>

	<div class="top_five">
		<div><i class="fa fa-angle-double-up" aria-hidden="true"></i> Top 5 Players</div>
		<table>
			<tbody>
				<tr>
					<th>Rank</th>
					<th>Patente</th>
					<th>Nick</th>
					<th>K/D%</th>
					<th>HS%</th>
					<th class="desktop">Win%</th>
				</tr>
				<?php 
				$sql = "SELECT * from contas WHERE ".$list_rank['where']." ORDER BY ".$list_rank['ordem']." LIMIT 5";
				$num1 = rand(2,10);
				$num2 =rand(3,10);
				$rank = 1;

				$select = select_db($sql);
				if (!is_null($select) && $select->rowCount() > 0) {
					foreach ($select as $row) {
						$player_id = $row['player_id'];
						$kill  = $row['kills_count'];
						$death = $row['deaths_count'];
						$hs    = $row['headshots_count'];
						$fight =   $row['fights'];
						$fight_win =   $row['fights_win'];
						$kd = calcKD($kill,$death);
						$hs_media = calcHS(($kill), $hs);
						$win = calcHS($fight,$fight_win);
						?>
						<tr>
							<td><?php echo $rank?>º</td>
							<td title="<?php echo Patentes::Name($row['rank']);?>"><img src="/img/patentes/20x20/<?php echo $row['rank'];?>.gif"></td>
							<td title="XP <?php echo number_format($row['exp'],0,'.',".");?>"><?php echo htmlspecialchars($row['player_name']);?></td>
							<td title="<?php echo $kill."/".$death;?>"><?php echo $kd;?>%</td>
							<td title="<?php echo $hs;?>"><?php echo $hs_media;?>%</td>
							<td class="desktop" title="<?php echo $fight."/".$fight_win;?>"><?php echo $win;?>%</td>
						</tr>
						<?php
						$rank++;
					}
				}else{
					?>
					<tr>
						<td>--</td>
						<td>--</td>
						<td>--</td>
						<td>--</td>
						<td>--</td>
						<td>--</td>
					</tr>
					<?php 
				}
				?>
			</tbody>
		</table>
	</div>

	<article class="borda-0">
		<h1>Interface classica</h1>
		<p>Para aqueles que curtem a boa e velha interface classica</p>

		<figure class="figure-0">
			<figcaption>Point Blank - Project Bloodi</figcaption>
			<img src="/img/post/news/4_point_blank_strike.jpg">
		</figure>
	</article>
</section>
<script>
	function showSlides() {
		var start = document.getElementById('start');
		var ativo = document.getElementById('modal_atual');

		home_modal1 = document.getElementById('home-modal1');
		home_modal2 = document.getElementById('home-modal2');
		home_modal3 = document.getElementById('home-modal3');

		if (start.value == "0") { /* modal1 já está visivel, isso evita problema */
		  	home_modal1.style.display = "block";
		  	home_modal2.style.display = "none";
		  	home_modal2.style.left = "100%";
		  	home_modal1.style.zIndex  = "1";
		  	home_modal3.style.zIndex  = "0";
		  	start.value = 1;
		  	ativo.value = 2;
	  	}
	  	// Eventos de troca 	  
	  	if (ativo.value == "1") {
	  		home_modal1.style.display = "block";
	  		home_modal2.style.left = "100%";
	  		home_modal2.style.display = "none";

	  		home_modal3.style.zIndex  = "0";
	 	 	home_modal1.style.zIndex  = "1";
	 	}
	 	if (ativo.value == "2") {

	 	 	home_modal2.style.display = "block";
	 	 	home_modal3.style.display = "none";
	 	 	home_modal3.style.left = "100%";

	  		home_modal1.style.zIndex  = "0";
	  		home_modal2.style.zIndex  = "1";
	  	}
	  	if (ativo.value == "3") {
	  		home_modal1.style.left = "100%";
	  		home_modal3.style.display = "block";
	  		home_modal1.style.display = "none";

	  		home_modal3.style.zIndex  = "1";
	  		home_modal2.style.zIndex  = "0";
	  	}
	  	if (ativo.value == "4") {
	  		home_modal1.style.display = "block";
	  		home_modal2.style.display = "none";
	  		home_modal2.style.left = "100%";

	  		home_modal1.style.zIndex  = "1";
	  		home_modal3.style.zIndex  = "0";

	  		ativo.value = 0;
	  	}
	  	ativo.value = (parseInt(ativo.value) + 1);
	  	setTimeout(showSlides, 4000); // Change image every 2 seconds
	}
	/* feed de noticias */
	var atual = 'status';
	var tab_prefix = "feed-tab-";
	var a_tab_prefix = "a-feedtab-";
	function feed(proximo){
		var proxTab = document.getElementById(tab_prefix+proximo);
		document.getElementById(tab_prefix+atual).style.display = "none";
		document.getElementById(a_tab_prefix+atual).classList.remove("active");
		$("#"+tab_prefix+proximo).fadeIn();
		$("#"+a_tab_prefix+proximo).addClass("active");

		if (proxTab.dataset.load == '0') {
			proxTab.innerHTML = "<div class='pad-10'>Carregando...</div>";
			$("#"+tab_prefix+proximo).load("/php/paginas/home/loadfeed.php?p="+proximo);
			proxTab.dataset.load = 1;
		}
		atual = proximo;
	} /* Fim do feed */
	showSlides();
</script>
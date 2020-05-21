<?php if (!logado() || $account['nivel']<4) {die('Sem permissão!');}?>
<div class="row"><div class="col-lg-12"><h1> Editar noticia </h1></div></div><hr/>
<?php 
$new_identy = preg_replace("/[^0-9.A-z_-]/", "", @$_GET['url']) ; 
$rand0 = rand(1,9);
$sql = "
SELECT site_news.*,contas.player_name as autor FROM site_news JOIN contas ON contas.player_id = site_news.autor WHERE url_id = '".$new_identy."' AND destaque > -1 ; 
";

if (select_db($sql)->rowCount() < 1) {
	echo "<div class='alert alert-danger' role='alert'>Noticia não encontrada!</div>";
}else{
foreach (select_db($sql) as $row) {
	$new = array(
		'id'   => $row['id'],
		'imagem'   => $row['imagem'],
		'keywords'   => $row['keywords'],
		'titulo'   => $row['titulo'],
		'descricao'   => $row['descricao'],
		'conteudo'   => $row['conteudo'],
		'data'   => $row['data'],
		'autor'   => $row['autor'],
		'access' => $row['access']
	);
}
?>
<div class="voform">
<div style="padding: 10px 0px;">
	<a target="_blank" href="/noticia/<?php echo $new_identy;?>/"><button type="button" class="btn btn-primary">Visualizar <span class="badge badge-light"><?php echo $row['access'];?></span></button>
	</a>
	<button onclick="this.disabled = true;if (!deletar_global('trash_new','<?php echo $new['id'];?>','/c68059ff9075a67037d15000881f9ae4/paginas/noticias/ajax.php',null,null,true)) {this.disabled = false;}" type="button" class="btn btn-danger">Excluir</button>
</div>
<div class="paiForm">
	<form class="formAddNew" id="formAddNew"  style="opacity:1;" onsubmit="return envia();">
		<div class="form-group">
			<label for="addNewsTitle">Titulo</label>
			<input onfocus="document.getElementById('modificado').value = '1';" value="<?php echo $row['titulo'];?>" type="text" onautocomplete="false" onkeyup="limiteCaract(this, 60);this.value = this.value.replace(/\s\s+/g, ' ').replace(/<|>|\'/g, '');this.classList.remove('is-invalid');" class="form-control" id="addNewsTitle">
			<div class="invalid-feedback text-right" id="invalid-title"></div>
		</div>
		
		 <div class="form-group">
			<label for="addNewsKeywords">Palavras Chaves</label>
			<input onfocus="document.getElementById('modificado').value = '1';" value="<?php echo $row['keywords'];?>" type="text" spellcheck="false" onautocomplete="false" onkeyup="limiteCaract(this, 133);this.value = removeAcento(this.value).replace(/noticias,|pointblank,|, ,|,,|;/g,',').replace(/\s\s+/g, ' ').replace(/[^a-zA-Z0-9, ]/g,'')" class="form-control" id="addNewsKeywords" placeholder="Separadas por virgula (novo mapa, alteraçao, arsenal, bugs, ...)"style="text-align: right;">
		</div>

		<div class="form-group">
			<label for="addNewsImg">Imagem</label>
			<input onfocus="document.getElementById('modificado').value = '1';" value="<?php echo $row['imagem'];?>" type="text" spellcheck="false" onautocomplete="false" onkeyup="limiteCaract(this, 200);this.classList.remove('is-invalid');" class="form-control" id="addNewsImg" placeholder="http://exemplo.com/foto.jpg">
		</div>

		<div class="form-group">
			<label for="addNewsDescricao">Descrição</label>
			<textarea onfocus="document.getElementById('modificado').value = '1';" onautocomplete="false" onkeyup="limiteCaract(this, 300);this.value = this.value.replace(/\s\s+/g, ' ').replace(/<|>|\'/g, '');this.classList.remove('is-invalid');" maxlength="300" class="form-control" id="addNewsDescricao" rows="2"><?php echo htmlspecialchars($row['descricao']);?></textarea>
			<div class="invalid-feedback text-right" id="invalid-descricao"></div>
		</div>
		<hr>

		<div class="form-group">
			<label for="addNewsConteudo">Conteudo (Permitido <b class="text-secondary">JS, HTML & CSS</b>)</label>
			<textarea onfocus="document.getElementById('modificado').value = '1';" spellcheck="false" onautocomplete="false" onkeyup="valida('addNewsConteudo');this.classList.remove('is-invalid');" maxlength="5000" class="form-control" id="addNewsConteudo" rows="9"><?php echo ($row['conteudo']);?></textarea>
			<div class="invalid-feedback text-right" id="invalid-conteudo"></div>
		</div>


		<div class="col-auto padding-0">
			<div class="input-group mb-2">
				<div class="input-group-prepend">
					<div class="input-group-text radius-0">stangames.com.br/noticia/</div>
				</div>
				<input onfocus="document.getElementById('modificado').value = '1';" value="<?php echo $row['url_id'];?>" type="text" class="form-control radius-0" id="addNewsIdentify" placeholder="exemplo-noticia/" onkeyup="limiteCaract(this, 100);this.value = this.value.replace(/[^a-zA-Z1-9. -]/g,'').replace(/\s+/g, '-').replace('--', '-').toLowerCase();this.classList.remove('is-invalid');" onblur="valida('addNewsIdentify');">
				<div class="invalid-feedback text-right" id="invalid-url"></div>

			</div>
		</div>

		<div class="form-group">
			<div class="form-check form-check-inline">
				<input onclick="document.getElementById('modificado').value = '1';" class="form-check-input" type="checkbox" id="cat_new" <?php if($row['cat']==1 || $row['cat']==4 || $row['cat']==6 || $row['cat']==9){echo " checked='true' ";}?>>
				<label class="form-check-label" for="cat_new">Noticia</label>
			</div>
			<div class="form-check form-check-inline">
				<input onclick="document.getElementById('modificado').value = '1';" class="form-check-input" type="checkbox" id="cat_up" <?php if($row['cat']==3 || $row['cat']==4 || $row['cat']==8 || $row['cat']==9){echo " checked='true' ";}?>>
				<label class="form-check-label" for="cat_up">Atualização</label>
			</div>
			<div class="form-check form-check-inline">
				<input onclick="document.getElementById('modificado').value = '1';" class="form-check-input" type="checkbox" id="cat_even" <?php if($row['cat']==5 || $row['cat']==6 || $row['cat']==8 || $row['cat']==9){echo " checked='true' ";}?>>
				<label class="form-check-label" for="cat_even">Evento</label>
			</div>
		</div>

		<input type="hidden" id="status_url" value="9">
		<input type="hidden" id="modificado" value="0"><!-- Só aplica se for modificado -->


		<button class="btn btn-primary" type="submit" id="Formsubmit">Aplicar</button>


		<!-- Modal -->
		<div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog" aria-labelledby="addNewsModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addNewsModalTitle">Sucesso!</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="addNewsModalBody">Postagem modificada!</div>
					<div class="modal-footer" id="addNewsModalFooter"></div>
				</div>
			</div>
		</div>

	</form>

	
</div>
	<div class="ovl-h">
		<div class="info_post right">
			<?php echo "<b>Autor:</b> ".$row['autor']." <b>Data:</b> ".date('d/m/Y', strtotime($row['data']));?>
		</div>
	</div>
</div>

<style>
	.voform{
		max-width: 600px;
	    margin: 0 auto;
	    margin-bottom: 20px;
	}
	.paiForm{background: #000;}
	.formAddNew{
		padding: 10px;
		border:1px solid #ddd;
		background: #fff
	}
	.info_post{
		margin: 10px 0px;
	    padding: 10px;
	    color: #474c50;
	    background: #fff;
	    border: 1px solid #d3d4d6;
	    border-right: 4px solid #b5b8bb;
	    text-align: right;
	}
</style>


<script>
	function valida(campo){
		var elemento = document.getElementById(campo);
		if (campo == "addNewsConteudo") {
			if (elemento.value.length > 5000) {
				elemento.classList.add("is-invalid");
				document.getElementById('invalid-conteudo').innerHTML = "O conteudo ultrapassou 5000 caracteres!";
			}else{
				elemento.classList.remove("is-invalid");
			}
		}

		if (campo == "addNewsIdentify") {
			if (elemento.value.length > 0) {
				$.post('/c68059ff9075a67037d15000881f9ae4/paginas/noticias/ajax.php',{query: 'check_urlEdit',url: elemento.value,id:<?php echo $rand0+($new['id'] * 77);?>,rand0: <?php echo ($rand0 * 77);?>},function(data){

					console.log(data); // temp
				 if (data == 1) {
				 	elemento.classList.remove("is-invalid");
				 	document.getElementById('status_url').value = 1;
				 }else{
				 	console.log("URL <"+elemento.value+"> já existe.");
				 	console.log(data);
				 	document.getElementById('status_url').value = 0;
				 	document.getElementById('invalid-url').innerHTML = "Essa url já existe, tente outra!";
				 	elemento.classList.add("is-invalid");
				 }
				});
			}
		}
	}

	function envia(){
		document.getElementById('formAddNew').style.opacity = "0.8";
		document.getElementById('Formsubmit').disabled=true;

		var titulo = document.getElementById('addNewsTitle');
		var keywords = document.getElementById('addNewsKeywords');
		var imagem = document.getElementById('addNewsImg');
		var descricao = document.getElementById('addNewsDescricao');
		var conteudo = document.getElementById('addNewsConteudo');
		var url_id = document.getElementById('addNewsIdentify');
		var status_url = document.getElementById('status_url');
		var modificado = document.getElementById('modificado');

		var cat_new = document.getElementById('cat_new');
		var cat_up = document.getElementById('cat_up');
		var cat_even = document.getElementById('cat_even');
		var cat = 0;
		if (cat_new.checked) {
			cat += 1;
		}if (cat_up.checked) {
			cat += 3;
		}if (cat_even.checked) {
			cat += 5;
		}

		var enviar = true; // Será alterado para false se algum formlario estiver incorreto
		if (titulo.value.length < 3 || titulo.value.length >60) {
			document.getElementById('invalid-title').innerHTML = "Minimo de 3 caracteres e máximo de 60";
			titulo.classList.add("is-invalid");
			titulo.focus();
			enviar = false;
		}

		if (descricao.value.length < 10 || descricao.value.length >300) {
			document.getElementById('invalid-descricao').innerHTML = "Minimo de 10 caracteres e máximo de 300";
			descricao.classList.add("is-invalid");
			descricao.focus();
			enviar = false;
		}

		if (imagem.value.length < 1) {
			imagem.classList.add("is-invalid");
			imagem.focus();
			enviar = false;
		}

		if (conteudo.value.length < 15) {
			conteudo.classList.add("is-invalid");
			document.getElementById('invalid-conteudo').innerHTML = "Minimo de 15 caracteres!";
			conteudo.focus();
			enviar = false;
		}

		if (url_id.value.length < 1) {
			document.getElementById('invalid-url').innerHTML = "Obrigatório!";
			url_id.classList.add("is-invalid");
			url_id.focus();
			enviar = false;
		}

		if (status_url.value == 0) {
			document.getElementById('invalid-url').innerHTML = "Essa url já existe, tente outra!";
			url_id.classList.add("is-invalid");
			url_id.focus();
			enviar = false;
		}
		if (modificado.value < 1) {enviar = false;}
		if (enviar == false) {
			document.getElementById('formAddNew').style.opacity = "1";
			document.getElementById('Formsubmit').disabled=false;
			return false;
		}

		$.post('/c68059ff9075a67037d15000881f9ae4/paginas/noticias/ajax.php',{
			query:      'update',
			titulo:     titulo.value,
			keywords:   keywords.value,
			imagem:     imagem.value,
			descricao:  descricao.value,
			conteudo:   conteudo.value,
			url_id:     url_id.value,
			id: 		<?php echo $rand0+($new['id'] * 77);?>,
			rand0: 		<?php echo ($rand0 * 77);?>,
			cat: 		cat
		},function(data){
			console.log(data);
		 if (data == 1) {
		 	status_url.value = '9';
		 	modificado.value = '0';
		 	document.getElementById('addNewsModalFooter').innerHTML = 
		 	"<button type='button' class='btn btn-secondary' data-dismiss='modal'>Continuar editando</button>";
		 	document.getElementById('addNewsModalFooter').innerHTML += 
		 	"<a href='/noticia/"+url_id.value+"/' target='_blank' class='btn btn-primary' role='button'>Visualizar</a>";
		 	$('#addNewsModal').modal('show')
		 }
		 document.getElementById('Formsubmit').disabled=false;
		 document.getElementById('formAddNew').style.opacity = "1";

		});
		
		return false;
	}
</script>
<?php } # ELSE if not exist ?>
-- Documento criado em 24/02/2019 3:29
-- By luisfeliperm


/*
++++ Tabela de Noticias ++++++
*/

CREATE TABLE site_news(
	id SMALLSERIAL PRIMARY KEY,
	url_id varchar(100) NOT NULL UNIQUE, -- Url da noticia, ex: novos-arsenais-2018
	imagem varchar(200) NOT NULL, -- Url da imagem
	keywords varchar(160) NOT NULL, -- Palavras chaves (html metakeywords)
	titulo varchar(60) not null, -- Titulo da noticia
	descricao varchar(300) not null, -- Breve descrição
	conteudo varchar(6000) not null, -- Conteudo da noticia, inclui codigos html
	data timestamp NOT NULL DEFAULT NOW(), -- data em que foi postado
	autor bigint NOT NULL, -- Autor da postagem, faz referencia a tab contas
	ip inet, -- Ip do autor
	access smallint NOT NULL DEFAULT 0,
	destaque smallint NOT NULL DEFAULT 0, -- valor 1 indica a noticia em destaque
	cat smallint NOT NULL DEFAULT 1, -- Categorias 
	FOREIGN KEY (autor) REFERENCES contas (player_id)
);


	-- ____Exemplo____ --

/* 
select site_news.titulo, contas.login as autor from site_news JOIN contas on contas.player_id = site_news.autor;

---------- Registros ------------

Codigos HTML são filtrados pela função charsEspe() para evitar erros SQL

o admin insere uma tag <b> e no banco de dados irá como &#60 b &#62
no banco de dados " &#60 " aparece como " < " na página de noticias


titulo			autor
Nova noticia	GM DevZohan 

1 Noticia
3 Atualizações
5 Eventos

1 N
5 E
3 A
4 N A
6 N E
8 A E
9 N E A
*/

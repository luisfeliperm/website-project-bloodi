-- Documento criado em 10/05/2019
-- By luisfeliperm

CREATE TABLE site_recuperar_senha(
	id SMALLSERIAL PRIMARY KEY,
	user_id smallint NOT NULL,
	token varchar(32) NOT NULL UNIQUE,
	ip inet NOT NULL,
	data timestamp NOT NULL DEFAULT NOW()
);
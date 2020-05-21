-- Documento criado em 11/04/2019 10:44
-- By luisfeliperm

CREATE TABLE site_accounts_confirm(
	id SMALLSERIAL PRIMARY KEY,
	email varchar(245) NOT NULL,
	login varchar(16) NOT NULL ,
	password varchar(32) NOT NULL,
	ip inet NOT NULL,
	data timestamp NOT NULL DEFAULT NOW(),
	usado boolean NOT NULL DEFAULT false,
	token varchar(32) NOT NULL UNIQUE
);
-- Documento criado em 20/03/2019 16:34
-- By luisfeliperm


/*
++++ Tabelas de pincode ++++++
*/

CREATE TABLE site_pincode(
	id SMALLSERIAL PRIMARY KEY,
	criador_id bigint NOT NULL,
	pin varchar(20) NOT NULL UNIQUE,
	valor smallint NOT NULL DEFAULT 5000,
	FOREIGN KEY (criador_id) REFERENCES contas (player_id)
);

CREATE TABLE site_pincode_logs(
	id SMALLSERIAL PRIMARY KEY,
	login bigint NOT NULL,
	pin varchar(20) NOT NULL UNIQUE,
	valor smallint NOT NULL,
	ip inet DEFAULT '0.0.0.0',
	data timestamp NOT NULL DEFAULT NOW(),
	criador_id bigint NOT NULL,
	FOREIGN KEY (login) REFERENCES contas (player_id),
	FOREIGN KEY (criador_id) REFERENCES contas (player_id)
);
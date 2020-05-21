CREATE TABLE site_cash_pendente(
	id SMALLSERIAL PRIMARY KEY,
	user_id bigint NOT NULL,
	valor integer NOT NULL DEFAULT 0,
	data timestamp NOT NULL DEFAULT NOW(),
	FOREIGN KEY (user_id) REFERENCES contas (player_id)
);

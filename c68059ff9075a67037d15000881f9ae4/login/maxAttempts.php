<?php
// 1 Verificar se esta bloqueado
// 2 Se errar, incrementar
// 2 Se logar, deleta o arquivo
class noBrute {
    public $dataAtual;
    public $data;
    public $erros;
    public $file;
    private $ip;

    public function getInfo() : void{
      	(int) $this->dataAtual = date('ymdhi');
		$this->ip = _CLIENT_ADDR;
		$this->file = "blacklist/".$this->ip.".txt";
		if (!file_exists($this->file))
			return;

		$arquivo = fopen($this->file, "r");
		$atual = fread($arquivo,filesize($this->file));

		$a = explode(";",$atual);
		(int) $this->data = explode(":", $a[0])[1];
		(int) $this->erros = explode(":", $a[1])[1];
    } 
    function check() : int {
    	if($this->data === null) return 0;

		if (((int)$this->data+10) > $this->dataAtual) { // Ainda na blacklist
			return $this->erros;
		}else{
			// Deleta arquivo
			$this->dell();
			return 0;
		}
	}
	function write() : void{
		if($this->data === null){ // Primeiro ban
			$this->data  =$this->dataAtual;
		}

		$cont = "date:".$this->data.";erros:".($this->erros+1).";";
		$arquivo = fopen($this->file, "w") or $this->toss(new Exception('Erro ao escrever em arquivo! '.$this->file));;
		fwrite($arquivo, $cont);   
	}
	function dell() : void{
		if (!file_exists($this->file)) return;
		if (!unlink($this->file)) {
			throw new Exception('Falha ao deletar arquivo $file! Usuario saiu da blacklist e houve uma falha ao tentar deletar o arquivo referente.');
		}
	}
	function time() : float {
		return (($this->data+10)-$this->dataAtual);
	}
	function toss(Exception $exception): void
	{
	    throw $exception;
	}
    
}


?>
<?php
require $_SERVER['DOCUMENT_ROOT']."/php/config/config.php";


function gerar_hash($senha){
    $salt = '/x!a@r-$r%an¨.&e&+f*f(f(a)';
    $output = hash_hmac('md5', $senha, $salt);
    return $output;
}
if (!isset($_POST['user'],$_POST['pass']) ) {
	die(0);
}

$data['user'] = strtolower(trim($_POST['user']));
$data['pass'] = trim($_POST['pass']);

if (mb_strlen($data['pass'], 'utf8') < 4 OR mb_strlen($data['pass'], 'utf8') > 16) {
	die('A senha deve ter entre 4-16 caracteres!');
}

$data['pass'] = gerar_hash($data['pass']);

if (mb_strlen($data['user'], 'utf8') < 4 OR mb_strlen($data['user'], 'utf8') > 16) {
	die('O usuario deve ter 4-16 caracteres!');
}



try {
    $conn = new PDO("pgsql:host="._DB_HOST.";port="._DB_PORT.";dbname="._DB_NAME, _DB_USER, _DB_PASS); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql = "SELECT login,password from contas where lower(login) = :user limit 1; ";
    $stmt = $conn->prepare($sql); 
    $stmt->bindValue(':user', $data['user']);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $x = $stmt->fetch(PDO::FETCH_ASSOC);
        if($x['password'] != $data['pass']){
            die("<b>Aviso:</b> senha inválida!");
        }

        $_SESSION['usuario'] = $data['user'];
		$_SESSION['senha'] = $data['pass'];
		die("1");

    }else{
    	session_destroy();
    	die("<b>Aviso:</b> usuario inválido!");
    }
    $stmt = null;

}catch(PDOException $e){
    echo $e->getMessage();
    save_log("error.log","[loginAjax] Error: " . $e->getMessage());
}
$conn = null;